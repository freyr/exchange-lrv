<?php

declare(strict_types=1);

namespace Freyr\Exchange\Trader;

use Freyr\Exchange\StockMarket\Core\Order;
use Freyr\Exchange\StockMarket\Core\Ports\OrderInfoPort;
use Freyr\Exchange\StockMarket\Core\Ports\TraderInfoPort;

class MyTrader implements TraderInfoPort
{

    public function __construct()
    {
    }

    public function isAllowedToTrade(OrderInfoPort $order): bool
    {
        if ($order->getStockCode() === 'APPL') {
            return true;
        }

        return false;
    }

    public function hasEnoughStock(\Freyr\Exchange\StockMarket\Core\Ports\Order $order): bool
    {
        // TODO: Implement hasEnoughStock() method.
    }

    public function hasEnoughInWallet(\Freyr\Exchange\StockMarket\Core\Ports\Order $order): bool
    {
        // TODO: Implement hasEnoughInWallet() method.
    }
}
