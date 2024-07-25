<?php

declare(strict_types=1);

namespace App\Console;


use Freyr\Exchange\StockMarket\Core\Ports\BuyOrder;
use Freyr\Exchange\StockMarket\Core\StockExchangeId;
use Illuminate\Console\Command;

class PlaceBuyOrderCommand extends Command implements BuyOrder
{

    public function __construct(string $stockCode, int $price, string $currency)
    {
        $this->stockCode = new StockExchangeId($stockCode);
        $this->money = new Money($price, $currency);

    }
    public function getPrice(): Money
    {
        return $this->money;
    }

    public function getBrokerId(): string
    {
        // TODO: Implement getBrokerId() method.
    }

    public function getStockCode(): string
    {
        // TODO: Implement getStockCode() method.
    }

    public function getNumberOfShares(): int
    {
        // TODO: Implement getNumberOfShares() method.
    }
}
