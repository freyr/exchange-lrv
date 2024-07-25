<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Core\Ports;

interface Order
{
    public function getStockCode(): string;
    public function getPrice(): int;

    public function getNumberOfShares(): int;

    public function getBrokerId(): string;
}
