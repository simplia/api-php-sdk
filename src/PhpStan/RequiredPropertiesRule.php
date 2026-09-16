<?php

declare(strict_types=1);

namespace Simplia\Api\PhpStan;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;
use Simplia\Api\Endpoint\AbstractApiEndpoint;
use Simplia\Api\Input\AbstractApiInput;

/**
 * Reports an input built inline in an endpoint call that lacks one of its required setters — the omission the client
 * throws IncompleteInputException for at runtime, caught at analysis time instead. Best effort: only a chain written
 * in the call itself (`X::create()->set…()` or `(new X())->set…()`, chains nested in a setter's argument or in an
 * inline array included) can be read; an input built elsewhere is left to the runtime check.
 *
 * Register it with `includes: [vendor/simplia/api/phpstan-extension.neon]` (phpstan/extension-installer does it).
 *
 * @implements Rule<Node\Expr\MethodCall>
 */
final class RequiredPropertiesRule implements Rule {

    public function __construct(private readonly ReflectionProvider $reflectionProvider) {
    }

    public function getNodeType(): string {
        return Node\Expr\MethodCall::class;
    }

    public function processNode(Node $node, Scope $scope): array {
        if (!$node->name instanceof Node\Identifier) {
            return [];
        }
        $receiver = $scope->getType($node->var);
        if (!(new ObjectType(AbstractApiEndpoint::class))->isSuperTypeOf($receiver)->yes()) {
            return [];
        }
        $call = self::shortName($receiver->getObjectClassNames()[0] ?? AbstractApiEndpoint::class) . '::' . $node->name->toString() . '()';

        $errors = [];
        foreach ($node->getArgs() as $argument) {
            foreach ($this->missing($argument->value, $scope) as [$class, $setters]) {
                $errors[] = RuleErrorBuilder::message(sprintf(
                    '%s passed to %s lacks %s.',
                    self::shortName($class),
                    $call,
                    implode(', ', array_map(static fn(string $setter): string => $setter . '()', $setters)),
                ))
                    ->tip(sprintf('Every setter in %s::REQUIRED must be called before sending; the client throws IncompleteInputException otherwise.', self::shortName($class)))
                    ->identifier('simpliaApi.incompleteInput')
                    ->build();
            }
        }

        return $errors;
    }

    /**
     * Walks a chain: the setters it calls, its root, and the chains nested in its arguments.
     *
     * @return list<array{string, list<string>}> input class and the required setters it lacks — for this chain
     *                                            (when its root is inline) and for every nested inline chain
     */
    private function missing(Expr $expr, Scope $scope): array {
        $called = [];
        $nested = [];
        while ($expr instanceof Expr\MethodCall && $expr->name instanceof Node\Identifier) {
            if ($expr->isFirstClassCallable()) {
                return $nested;
            }
            $called[$expr->name->toString()] = true;
            foreach ($expr->getArgs() as $argument) {
                foreach (self::inlineValues($argument->value) as $value) {
                    foreach ($this->missing($value, $scope) as $found) {
                        $nested[] = $found;
                    }
                }
            }
            $expr = $expr->var;
        }
        $class = $this->rootClass($expr, $scope);
        if ($class === null) {
            return $nested;
        }
        $native = $class->getNativeReflection();
        $required = $native->hasConstant('REQUIRED') ? $native->getConstant('REQUIRED') : [];
        $lacking = [];
        foreach (is_array($required) ? $required : [] as $setter) {
            if (is_string($setter) && !isset($called[$setter])) {
                $lacking[] = $setter;
            }
        }

        return array_merge($lacking === [] ? [] : [[$class->getName(), $lacking]], $nested);
    }

    /** The chain's root — `X::create()` or `new X()` on an input class — or null when the input was built elsewhere. */
    private function rootClass(Expr $root, Scope $scope): ?ClassReflection {
        if ($root instanceof Expr\StaticCall && $root->name instanceof Node\Identifier && $root->name->toString() === 'create' && $root->class instanceof Node\Name) {
            $name = $scope->resolveName($root->class);
        } elseif ($root instanceof Expr\New_ && $root->class instanceof Node\Name) {
            $name = $scope->resolveName($root->class);
        } else {
            return null;
        }
        if (!$this->reflectionProvider->hasClass($name)) {
            return null;
        }
        $class = $this->reflectionProvider->getClass($name);

        return $class->isSubclassOfClass($this->reflectionProvider->getClass(AbstractApiInput::class)) ? $class : null;
    }

    /**
     * The expressions of one argument that may be inline chains: the value itself, or each item of an inline array.
     *
     * @return list<Expr>
     */
    private static function inlineValues(Expr $value): array {
        if (!$value instanceof Expr\Array_) {
            return [$value];
        }
        $items = [];
        foreach ($value->items as $item) {
            $items[] = $item->value;
        }

        return $items;
    }

    private static function shortName(string $class): string {
        $slash = strrpos($class, '\\');

        return $slash === false ? $class : substr($class, $slash + 1);
    }
}
