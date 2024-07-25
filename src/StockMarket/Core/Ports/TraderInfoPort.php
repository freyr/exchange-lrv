<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Core\Ports;

interface TraderInfoPort
{

    public function isAllowedToTrade(OrderInfoPort $order): bool;

    public function hasEnoughStock(OrderInfoPort $order): bool;

    public function hasEnoughInWallet(OrderInfoPort $order): bool;
}
