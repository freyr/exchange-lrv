<?php

declare(strict_types=1);

namespace Freyr\Exchange\Exchange\Core\Ports;

interface TraderInfoPort
{

    public function isAllowedToTrade(Order $order): bool;

    public function hasEnoughStock(Order $order): bool;

    public function hasEnoughInWallet(Order $order): bool;
}
