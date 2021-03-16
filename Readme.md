SDK pro API eshopů Simplia.cz (https://api.simplia.cz/) určené pro interní napojení. Automaticky generováno z [OpenAPI](https://api.simplia.cz/swagger.json) definic.

Výhody oproti přímému použití REST API:

 - možnost statické analýzy ([PHPStan](https://phpstan.org/)) a odhladění problému bez nutnosti volat API
 - jednodušší testování (komunikace s SDK se mockuje jednodušeji než celá HTTP komunikace)
 - napovídání v editoru

## Installing

```shell
composer require simplia/api:dev-master
```

## Contributing

Celý repozitář je automaticky generován z OpenAPI definic a pull request je potřeba poslat pro generátoru (nebo jen popsat problém v issue zde)

## Terminology

 - *___Endpoint* - kategorie operací
 - *___Request* - parametry výpisu jako je řazení, filtry, ...
 - *___FieldConfig* - seznam polí, které se mají získat z backendu
 - *___Input* - vstup pro operaci jako například nový popis produktu apod, který se pošle jako tělo API požadavku

## Examples

#### Change order status
```php
use \Simplia\Api\Api;
use \Simplia\Api\Input\OrderStatusTypeApiInput;

$api = Api::withUsernameAuth($httpClient, 'demo2.simpliashop.cz', 'api_user', '*********');
$api->getOrdersEndpoint()->updateStatus(
    '123',
    OrderStatusTypeApiInput::create()
        ->setStatusId(4)
);
```

#### List orders from status by name
```php
use \Simplia\Api\Api;
use \Simplia\Api\Entity\ContactApiEntity;
use \Simplia\Api\Entity\OrderApiEntity;
use \Simplia\Api\Request\OrderApiRequest;

$api = Api::withUsernameAuth($httpClient, 'demo2.simpliashop.cz', 'api_user', '*********');
$orders = $api->getOrdersEndpoint()->iterate(
    OrderApiRequest::create()
        ->whereStatus(1),
    OrderApiEntity::createFieldConfig()
        ->withId()
        ->withDeliveryAddress(
            ContactApiEntity::createFieldConfig()
                ->withCompanyName()
        )
);

foreach ($orders as $order) {
    echo $order->getId();
    echo $order->getDeliveryAddress()->getCompanyName();
}
```

#### Get single order
```php
use \Simplia\Api\Api;
use \Simplia\Api\Entity\ContactApiEntity;
use \Simplia\Api\Entity\OrderApiEntity;

$api = Api::withUsernameAuth($httpClient, 'demo2.simpliashop.cz', 'api_user', '*********');
$order = $api->getOrdersEndpoint()->get(
   '123',
    OrderApiEntity::createFieldConfig()
        ->withId()
        ->withDeliveryAddress(
            ContactApiEntity::createFieldConfig()
                ->withCompanyName()
        )
);

echo $order->getId();
echo $order->getDeliveryAddress()->getCompanyName();
echo $order->getCurrency(); // throws error because currency with wasn't loaded from API (is not defined in field config)
```

#### Article list by topic
```php
use \Simplia\Api\Api;
use \Simplia\Api\Request\ArticleApiRequest;
use \Simplia\Api\Entity\ArticleApiEntity;

$api = Api::withUsernameAuth($httpClient, 'demo2.simpliashop.cz', 'api_user', '*********');
$articles = $api->getArticlesEndpoint()->iterate(
    ArticleApiRequest::create()
        ->whereTopic(7)
        ->orderByPublishedAsc(),
    ArticleApiEntity::createFieldConfig()
        ->withName()
        ->withUrl()
);

foreach ($articles as $article) {
    echo '<a href="' . $article->getUrl() . '">' . $article->getName() . '</a>';
}

```
