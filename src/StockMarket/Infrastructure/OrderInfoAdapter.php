<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Infrastructure;

use Freyr\Exchange\StockMarket\Core\Order;
use Freyr\Exchange\StockMarket\Core\Ports\OrderInfoPort;

class OrderInfoAdapter implements OrderInfoPort
{

    public static function create(Order $entity): OrderInfoPort
    {
        // TODO: Implement create() method.
    }

    public function getStockCode(): string
    {
        // TODO: Implement getStockCode() method.
    }
}
