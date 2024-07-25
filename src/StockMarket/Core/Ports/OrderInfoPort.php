<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Core\Ports;

use Freyr\Exchange\StockMarket\Core\Order;

interface OrderInfoPort
{

    public static function create(Order $entity): self;

    public function getStockCode(): string;
}
