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

Requires PHP 8.2+ and any PSR-18 HTTP client (Guzzle, Symfony HttpClient, …). The `/api/3` client is the
`3.x` line of `simplia/api`; the `/api/2` client stays on the `0.1.x` line. Pin a version line, never
`dev-master`.

## Getting started

```php
use Simplia\Api3\Api;

$api = Api::withUsernameAuth($psr18Client, 'shop.example', 'api_login', 'api_key');   // HTTP Basic
$api = Api::withJWT($psr18Client, 'shop.example', $integrationToken);                // Bearer, integration token
```

The host is the shop's own domain; the client speaks HTTPS to `https://<host>/api/3/…`. Each shop
account or integration token is a separate credential with its own permissions (`api:<resource>:<action>`,
listed on every method) and its own rate-limit quota.

## Principles

Six rules shape every call. They are the API's rules, and the client makes them explicit.

### You name what you read

A record is never fetched whole. Every read takes a `*ApiFieldConfig` naming the properties you want,
embedded records included, to any depth; the API returns exactly those, plus `id` at every level.

```php
use Simplia\Api3\Entity\OrderApiEntity;
use Simplia\Api3\Entity\UserApiEntity;

$fields = OrderApiEntity::createFieldConfig()
    ->withCode()
    ->withTotalPrice()
    ->withUser(UserApiEntity::createFieldConfig()->withEmail());   // an embed: name its fields too
```

An entity answers only what was selected: reading a property you did not name throws
(`Field "user.email" was not loaded - add it to the field config first`) rather than returning `null`, so a
missing selection never masquerades as a missing value. Without a field config a write's answer is the
record's `id` alone. Select what you use: the answer is smaller and the shop does less work.

### Lists are pages you iterate

Collections are paginated by keyset, not by page number: the API announces the next page as an opaque
cursor, and `iterate()` follows it for you until the last page.

```php
use Simplia\Api3\Request\OrdersApiRequest;

$request = OrdersApiRequest::create()
    ->whereStatus(['unprocessed'])                  // filters: where*()
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

Every amount is a `Simplia\Api3\Money` — `amount` as a decimal string (`"1290.00"`), `currency` an ISO 4217
code — never a float, on inputs and outputs alike. Writes send amounts in the record's own currency (an
order in the currency its prices are sent in; a stock item, variant or voucher in the shop's main
currency); an order, a document row and a payment publish each amount twice — in the shop's main currency
under the plain name, and in the record's own currency under `*_in_order_currency`,
`*_in_document_currency` or `*_in_payment_currency`.

### Records have an id and, often, a code

`id` is always the numeric identifier. Where the shop also has a human code (orders, documents, stock
items, vouchers, …) the endpoint offers `getByCode()`; the client URL-encodes the code for you.

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

Every non-2xx answer is a `Simplia\Api3\Exception\ApiProblemException` — `getStatus()`, `getType()` (the
slug after `/api/3/errors/`, the stable name of the error), `getTitle()`, `getDetail()`, `getBody()` —
or one of its subclasses:

- `ValidationException` (422): `violations()` names each property and why it was refused;
- `ConflictException` (409): the record's state refuses the change (a reused idempotency key with a
  different body is one of them);
- `RateLimitedException` (429): `retryAfter()`.

`get()` and `getByCode()` return `null` for a 404 instead of throwing.

### Version 3 evolves without breaking you

Changes within version 3 are additive: a new property, parameter, method or enumeration value may appear
in any release and never breaks a client that ignores it — and the entities read only the properties you
selected. A removal is announced at least twelve months ahead in the changelog (`GET /api/3/changelog` on
any shop, no credentials needed) and by `Deprecation` and `Sunset` headers on the affected operation.

## Vocabulary

- `Api` — the entry point; `$api->get<Resource>Endpoint()` for each resource.
- `*ApiEndpoint` — the operations of one resource: `get()`, `getByCode()`, `iterate()`, `count()`,
  `create()`, `update()`, and the resource's actions (`updateStatus()`, `apply()`, `lock()`, …).
- `*ApiFieldConfig` — which properties to fetch, embeds by nesting another field config.
- `*ApiRequest` — the filters and sort of a list.
- `*ApiInput` — the body of a write; `create()` takes the full input, `update()` a partial one (only
  what you set is sent, as a JSON merge patch).
- `*ApiEntity` — one record as returned; a getter per property, typed.
- `Money` — an amount and its currency.

## Read one record

```php
use Simplia\Api3\Entity\OrderApiEntity;

$order = $api->getOrdersEndpoint()->get(123, OrderApiEntity::createFieldConfig()->withCode()->withTotalPrice());
echo $order?->getCode();
echo $order?->getTotalPrice()->amount;   // "1290.00"
```

## Write

```php
use Simplia\Api3\Entity\OrderApiEntity;
use Simplia\Api3\Input\OrderStatusApiInput;

$order = $api->getOrdersEndpoint()->updateStatus(
    123,
    OrderStatusApiInput::create()->setStatus('processed'),
    OrderApiEntity::createFieldConfig()->withStatus(),   // what the answer should carry; omit it for the id alone
);
```

## Handle an error

```php
use Simplia\Api3\Exception\RateLimitedException;
use Simplia\Api3\Exception\ValidationException;

try {
    $api->getOrdersEndpoint()->create($input);
} catch (ValidationException $e) {
    foreach ($e->violations() as $violation) {
        // which property, and why
    }
} catch (RateLimitedException $e) {
    sleep($e->retryAfter() ?? 1);   // then send the same request, with the same idempotency key
}
```
