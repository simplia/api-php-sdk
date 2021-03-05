<?php

/**
 * !!! AUTOGENERATED FROM OPENAPI SPECIFICATION
 * !!! DON'T EDIT AND DON'T SEND PULL REQUESTS DIRECTLY FOR THIS FILE
 */

namespace Simplia\Api;

use Simplia\Api\Endpoint\ArticlesEndpoint;
use Simplia\Api\Endpoint\AvailabilitiesEndpoint;
use Simplia\Api\Endpoint\DocumentsEndpoint;
use Simplia\Api\Endpoint\OrdersEndpoint;
use Simplia\Api\Endpoint\PackagesEndpoint;
use Simplia\Api\Endpoint\PaymentsEndpoint;
use Simplia\Api\Endpoint\StockItemsEndpoint;
use Simplia\Api\Endpoint\StockRoomsEndpoint;
use Simplia\Api\Endpoint\TextPagesEndpoint;
use Simplia\Api\Endpoint\VoucherEndpoint;
use Simplia\Api\Endpoint\VoucherLockEndpoint;

final class Api {
    public RequestHandler $client;

    private function __construct(string $host, string $username, string $password) {
        $this->client = new RequestHandler($host, $username, $password);
    }

    public static function withUsernameAuth(string $hostname, string $username, string $password): self {
        return new self($hostname, $username, $password);
    }

    final public function getArticlesEndpoint(): ArticlesEndpoint {
        return new ArticlesEndpoint($this->client);
    }

    final public function getAvailabilitiesEndpoint(): AvailabilitiesEndpoint {
        return new AvailabilitiesEndpoint($this->client);
    }

    final public function getDocumentsEndpoint(): DocumentsEndpoint {
        return new DocumentsEndpoint($this->client);
    }

    final public function getOrdersEndpoint(): OrdersEndpoint {
        return new OrdersEndpoint($this->client);
    }

    final public function getPackagesEndpoint(): PackagesEndpoint {
        return new PackagesEndpoint($this->client);
    }

    final public function getPaymentsEndpoint(): PaymentsEndpoint {
        return new PaymentsEndpoint($this->client);
    }

    final public function getStockItemsEndpoint(): StockItemsEndpoint {
        return new StockItemsEndpoint($this->client);
    }

    final public function getStockRoomsEndpoint(): StockRoomsEndpoint {
        return new StockRoomsEndpoint($this->client);
    }

    final public function getTextPagesEndpoint(): TextPagesEndpoint {
        return new TextPagesEndpoint($this->client);
    }

    final public function getVoucherEndpoint(): VoucherEndpoint {
        return new VoucherEndpoint($this->client);
    }

    final public function getVoucherLockEndpoint(): VoucherLockEndpoint {
        return new VoucherLockEndpoint($this->client);
    }
}
