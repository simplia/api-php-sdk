# Simplia /api/3 PHP client

Generated from the shop's OpenAPI document by `bin/console api3:sdk:generate` — never edit a generated file; change the generator (`src/Api/Sdk` in the shop repository) instead.

Why a client instead of raw HTTP: static analysis (PHPStan) of every call, editor completion, field selection that mirrors the API's `fields` parameter, iteration over keyset pages, typed errors.

## Installing

```shell
composer require simplia/api:^3
```

The `/api/3` client is the `3.x` line of `simplia/api` (Packagist, from github.com/simplia/api-php-sdk); the `/api/2` client stays on the `0.1.x` line. Pin a version line, never `dev-master`: the repository's master branch is replaced by every publish.

## Vocabulary

- `*ApiEndpoint` — the operations of one resource (`$api->getOrdersEndpoint()`).
- `*ApiFieldConfig` — which properties to fetch; an entity throws for a property you did not select (the API returns only what you name, `id` always).
- `*ApiRequest` — filters and sort of a list.
- `*ApiInput` — the body of a write.
- `*ApiEntity` — one record as returned.
- `Money` — an amount as a decimal string plus an ISO 4217 code; never a float.

## Authentication

```php
use Simplia\Api3\Api;

$api = Api::withUsernameAuth($psr18Client, 'shop.example', 'api_login', 'api_key');   // HTTP Basic
$api = Api::withJWT($psr18Client, 'shop.example', $integrationToken);                // Bearer, integration token
```

## Read one record

```php
use Simplia\Api3\Entity\OrderApiEntity;

$order = $api->getOrdersEndpoint()->get(
    123,
    OrderApiEntity::createFieldConfig()->withCode()->withTotalPrice()
);
echo $order?->getCode();
echo $order?->getTotalPrice()->amount;   // "1290.00"
```
`get()` returns `null` for a 404. A code is URL-encoded for you; a code containing `/` cannot be addressed by
the by-code routes (the server matches a single path segment).

## Iterate a list

```php
use Simplia\Api3\Entity\OrderApiEntity;
use Simplia\Api3\Entity\UserApiEntity;
use Simplia\Api3\Request\OrdersApiRequest;

$orders = $api->getOrdersEndpoint()->iterate(
    OrdersApiRequest::create()->whereStatus(['unprocessed'])->orderByCreatedAtDesc(),
    OrderApiEntity::createFieldConfig()->withCode()->withUser(UserApiEntity::createFieldConfig()->withEmail())
);
foreach ($orders as $order) {
    echo $order->getCode(), ' ', $order->getUser()?->getEmail(), "\n";
}
$total = $api->getOrdersEndpoint()->count(OrdersApiRequest::create()->whereStatus(['unprocessed']));
```
`iterate()` follows the `Link` header page by page; `count()` asks for the total only.

## Write

```php
use Simplia\Api3\Input\OrderStatusApiInput;

$api->getOrdersEndpoint()->updateStatus(123, OrderStatusApiInput::create()->setStatus('processed'));
```
Every POST (`create*`, `activate`, `apply`, `lock`, `send`, `uploadImage`, …) sends an `Idempotency-Key` (a fresh UUID, or the one you pass as the last argument) so a retried request cannot create twice.

## Errors

Every non-2xx answer is a `Simplia\Api3\Exception\ApiProblemException` (`getStatus()`, `getType()` — the slug after `/api/3/errors/`, `getDetail()`), or one of its subclasses: `ValidationException` (422, `violations()`), `ConflictException` (409), `RateLimitedException` (429, `retryAfter()`). Nothing is retried automatically.
