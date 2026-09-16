# Simplia API PHP client

A typed PHP client for the Simplia shop API, version 3: every operation of the shop that has a `/api/3`
endpoint, as PHP methods with editor completion and static analysis (PHPStan level 8 clean), typed
entities and inputs, field selection that mirrors the API, page iteration that follows the API's
cursors for you, and typed exceptions for every error the API defines.

This package is generated from the API's OpenAPI document — every release of the shop regenerates it, so
please do not edit or send pull requests against these files; they would be overwritten. A wrong or missing
method is a bug in the API or its generator: report it to Simplia. The full reference of every operation,
property, filter and error is published at https://api.simplia.cz/ and served by every shop at
`/api/3/docs`.

## Installing

```shell
composer require simplia/api:^3
```

Requires PHP 8.3+ and any PSR-18 HTTP client (Guzzle, Symfony HttpClient, …). The `/api/3` client is the
`3.x` line of `simplia/api`; the `/api/2` client stays on the `0.1.x` line. Pin a version line, never
`dev-master`. Both lines share the `Simplia\Api` namespace: moving from the `/api/2` client is a
version bump, and what changes are the classes and methods, which follow the API.

Static analysis: the package ships a PHPStan 2.x rule that reports an input built in an endpoint call
without one of its required setters. `phpstan/extension-installer` picks it up; otherwise add to your
`phpstan.neon`:

```neon
includes:
    - vendor/simplia/api/phpstan-extension.neon
```

`3.0.2` is the first tag of the `3.x` line to build on: `3.0.0` and `3.0.1` were retired before any consumer
merged them (an older namespace, then constructor-based inputs).

## Getting started

```php
use Simplia\Api\Api;

$api = Api::withUsernameAuth($psr18Client, 'shop.example', 'api_login', 'api_key');   // HTTP Basic
$api = Api::withJWT($psr18Client, 'shop.example', $integrationToken);                // Bearer, integration token
```

The host is the shop's own domain; the client speaks HTTPS to `https://<host>/api/3/…`. Each shop
account or integration token is a separate credential with its own permissions (`api:<resource>:<action>`,
listed on every method) and its own rate-limit quota.

## Principles

Nine rules shape every call. They are the API's rules, and the client makes them explicit.

### You name what you read

A record is never fetched whole. Every read takes a `*ApiFieldConfig` naming the properties you want,
embedded records included, to any depth; the API returns exactly those, plus `id` at every level.

```php
use Simplia\Api\Entity\OrderApiEntity;
use Simplia\Api\Entity\UserApiEntity;

$fields = OrderApiEntity::createFieldConfig()
    ->selectCode()
    ->selectTotalPrice()
    ->selectUser(UserApiEntity::createFieldConfig()->selectEmail());   // an embed: name its fields too
```

A field config is a builder like a query builder: each `select…()` changes it and returns it, so build one
per request, or `clone` a base config before extending it.

An entity answers only what was selected: reading a property you did not name throws
(`Field "user.email" was not loaded - add it to the field config first`) rather than returning `null`, so a
missing selection never masquerades as a missing value. Without a field config a write's answer is the
record's `id` alone. Select what you use: the answer is smaller and the shop does less work.

### Lists are pages you iterate

Collections are paginated by keyset, not by page number: the API announces the next page as an opaque
cursor, and `iterate()` follows it for you until the last page.

```php
use Simplia\Api\Enum\OrderStatus;
use Simplia\Api\Request\OrdersApiRequest;

$request = OrdersApiRequest::create()
    ->whereStatus([OrderStatus::Unprocessed])       // filters: where*()
    ->whereCreatedAtFrom(new \DateTimeImmutable('-7 days'))
    ->orderByCreatedAtDesc();                       // sort: orderBy*(); the allowed sorts are the methods you see

foreach ($api->getOrdersEndpoint()->iterate($request, $fields, perPage: 100) as $order) {
    // one entity per row, across every page
}
$total = $api->getOrdersEndpoint()->count($request);   // the total only, no rows
```

A page costs the same rate-limit units whether it holds 1 row or 100, so page wide rather than often;
100 is the client's default. Filters and sorts are the generated methods: the API refuses an unknown one
before anything runs, and the client cannot express one. Date filters take a `\DateTimeInterface` or an
ISO 8601 string. Never build a cursor yourself.

### Money is a decimal string with a currency

Every amount is a `Simplia\Api\Money` — `amount` as a decimal string (`"1290.00"`), `currency` an ISO 4217
code — never a float, on inputs and outputs alike. Writes send amounts in the record's own currency (an
order in the currency its prices are sent in; a stock item, variant or voucher in the shop's main
currency); an order, a document row and a payment publish each amount twice — in the shop's main currency
under the plain name, and in the record's own currency under `*_in_order_currency`,
`*_in_document_currency` or `*_in_payment_currency`.

### Records have an id and, often, a code

`id` is always the numeric identifier. Where the shop also has a human code (orders, documents, stock
items, vouchers, …) the endpoint offers `getByCode()`; the client URL-encodes the code for you.

### Values are enums

Every property, filter or input value the API restricts to a fixed set is a PHP enum in
`Simplia\Api\Enum` (`OrderStatus`, `PaymentType`, …): filters and inputs take it, entities return it, and
`match` over it is checked by PHPStan.

```php
use Simplia\Api\Entity\OrderApiEntity;
use Simplia\Api\Enum\OrderStatus;

$order = $api->getOrdersEndpoint()->get(123, OrderApiEntity::createFieldConfig()->selectStatus());

$label = match ($order?->getStatus()) {
    OrderStatus::Unprocessed, OrderStatus::Processed => 'open',
    OrderStatus::Waiting, OrderStatus::Ready => 'in progress',
    OrderStatus::Finished, OrderStatus::Cancelled => 'closed',
    null => 'no public status',   // also the arm for a 404, which get() answers as null
};
```

The set is the API's at the time this client was generated; a value the shop adds later arrives as
`UnknownEnumValueException` (see Errors), which is your cue to upgrade `simplia/api`. A nullable member is
a nullable enum: `getStatus()` is `?OrderStatus`, null for an order in a state the API does not expose
(archived, deleted).

### Every credential has a rate limit

A credential may spend 600 units per sliding 60-second window: reading one record costs 1, a write 2, a
collection page or a batch write 5. A call that does not fit answers `429`, thrown as
`RateLimitedException`, whose `retryAfter()` is the number of seconds to wait; nothing ran. The client
does not wait or retry on its own.

### A retried write cannot run twice

Every POST carries an `Idempotency-Key` — a fresh UUID by default, or the key you pass as the method's
last argument. Send the same request with the same key and the API replays the first answer instead of
acting again, so a `create()` that timed out can be retried safely: keep your key and send it again.
`PATCH`, `PUT` and `DELETE` are idempotent by their HTTP definition and carry no key.

### Errors are exceptions

Every non-2xx answer is a `Simplia\Api\Exception\ApiProblemException` — `getStatus()`, `getType()` (the
slug after `/api/3/errors/`, the stable name of the error), `getTitle()`, `getDetail()`, `getBody()` —
or one of its subclasses:

- `ValidationException` (422): `violations()` names each property and why it was refused;
- `ConflictException` (409): the record's state refuses the change (a reused idempotency key with a
  different body is one of them);
- `RateLimitedException` (429): `retryAfter()`.

`get()` and `getByCode()` return `null` for a 404 instead of throwing.

One exception is not about the answer's status but its content. `UnknownEnumValueException` — an
`\UnexpectedValueException`, not an `ApiProblemException` — is thrown when a getter reads a value of an
enum-typed property that this client does not know: `getField()` is the property, `getValue()` the value
the shop sent, `getEnum()` the enum class that lacks it. The shop is newer than the client; upgrade
`simplia/api`.

And one is thrown before there is an answer at all: `IncompleteInputException` — a `\LogicException` — when
an input reaches an endpoint method without a property its schema requires. `getMissing()` lists the wire
paths (`delivery.payment_price`, `items[1].price`); the message names the setters to call. Nothing was sent.

### Version 3 evolves without breaking you

Changes within version 3 are additive: a new property, parameter or method may appear in any release and
never breaks a client that ignores it — and the entities read only the properties you selected.
Enumeration values are the one exception, because this client reads them as PHP enums rather than as
strings: a value it does not know throws. So a new value is declared in the API's document one release
before any shop emits it, and a client generated from that release already knows it. A removal is
announced at least twelve months ahead in
the changelog (`GET /api/3/changelog` on any shop, no credentials needed) and by `Deprecation` and
`Sunset` headers on the affected operation.

## Vocabulary

- `Api` — the entry point; `$api->get<Resource>Endpoint()` for each resource.
- `*ApiEndpoint` — the operations of one resource: `get()`, `getByCode()`, `iterate()`, `count()`,
  `create()`, `update()`, and the resource's actions (`updateStatus()`, `apply()`, `lock()`, …).
- `*ApiFieldConfig` — which properties to fetch, embeds by nesting another field config.
- `*ApiRequest` — the filters and sort of a list.
- `*ApiInput` — the body of a write, built in steps: `create()`, then a `set…()` per property in any order;
  the class docblock lists the required ones, and an endpoint throws `IncompleteInputException` before
  sending when one is missing. The endpoint's `create()` takes the full input, its `update()` a partial one
  (only what you set is sent, as a JSON merge patch); where one body both creates and changes a record, the
  partial one is its own class with nothing required (`TextPagePatchApiInput`).
- `*ApiEntity` — one record as returned; a getter per property, typed.
- `Enum\*` — one per value set, named after the record and property that own it (`OrderStatus`,
  `ReviewSource`).
- `Money` — an amount and its currency.

## Read one record

```php
use Simplia\Api\Entity\OrderApiEntity;

$order = $api->getOrdersEndpoint()->get(123, OrderApiEntity::createFieldConfig()->selectCode()->selectTotalPrice());
echo $order?->getCode();
echo $order?->getTotalPrice()->amount;   // "1290.00"
```

## Write

An input is a builder: `create()`, then a `set…()` per property, in any order, conditionally. The class
docblock lists the setters the schema requires. Leave one out and the endpoint throws
`IncompleteInputException` before any request, naming the setter to call; a required property's setter is
typed non-null, so PHPStan and your editor catch a null earlier still. A rule the schema cannot express —
"one of these three", a value another property makes mandatory — is stated in the property's description;
those the API answers `422` for.

```php
use Simplia\Api\Entity\OrderApiEntity;
use Simplia\Api\Enum\OrderStatus;
use Simplia\Api\Input\OrderCreateApiInput;
use Simplia\Api\Input\OrderDeliveryApiInput;
use Simplia\Api\Input\OrderItemApiInput;
use Simplia\Api\Input\OrderStatusApiInput;
use Simplia\Api\Input\OrderUpdateApiInput;
use Simplia\Api\Money;

$input = OrderCreateApiInput::create()
    ->setItems([
        OrderItemApiInput::create()
            ->setQuantity(2)->setPrice(new Money('490.00', 'CZK'))->setVatRate(21.0)
            ->setStockItemCode('SKU-1'),        // not optional: one of the three names the item (or setStockItemId() / setStockItemTrackingId())
    ])
    ->setDelivery(
        OrderDeliveryApiInput::create()
            ->setTransportMethodId(3)->setTransportPrice(new Money('99.00', 'CZK'))->setTransportVatRate(21.0)
            ->setPaymentMethodId(1)->setPaymentPrice(new Money('0.00', 'CZK'))->setPaymentVatRate(21.0)
    );
if ($customerNote !== null) {
    $input->setCustomerNote($customerNote);     // an optional property: only what you set is sent
}

$order = $api->getOrdersEndpoint()->create(
    $input,
    OrderApiEntity::createFieldConfig()->selectCode()->selectStatus(),   // omit it for the id alone
);

$api->getOrdersEndpoint()->updateStatus($order->getId(), OrderStatusApiInput::create()->setStatus(OrderStatus::Processed));
$api->getOrdersEndpoint()->update($order->getId(), OrderUpdateApiInput::create()->setPackagingNote('fragile'));
```

An `update()` takes a partial input: nothing is required, and only what you set is sent, as a JSON merge
patch (a null clears the property). With the package's PHPStan rule (see Installing), a chain written in
the call that lacks a required setter is reported at analysis time —
`OrderCreateApiInput passed to OrdersApiEndpoint::create() lacks setDelivery().` — and whatever the rule
cannot see, the endpoint still checks before sending.

## Handle an error

```php
use Simplia\Api\Entity\OrderApiEntity;
use Simplia\Api\Exception\RateLimitedException;
use Simplia\Api\Exception\UnknownEnumValueException;
use Simplia\Api\Exception\ValidationException;

try {
    $order = $api->getOrdersEndpoint()->create($input, OrderApiEntity::createFieldConfig()->selectStatus());
    $status = $order->getStatus();
} catch (ValidationException $e) {
    foreach ($e->violations() as $violation) {
        // which property, and why
    }
} catch (RateLimitedException $e) {
    sleep($e->retryAfter() ?? 1);   // then send the same request, with the same idempotency key
} catch (UnknownEnumValueException $e) {
    // $e->getField() carried $e->getValue(), which this client does not know: upgrade simplia/api
}
```

The enum exception comes from the getter that reads the value, not from the call that fetched it: an
answer you never read a new value out of never throws.
