<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Core\Ports;

use Freyr\Exchange\StockMarket\Core\StockExchange;
use Freyr\Exchange\StockMarket\Core\StockExchangeId;

interface StockExchangeRepository
{
    public function load(StockExchangeId $id): StockExchange;

    public function persist(StockExchange $aggregateRoot): void;
}
