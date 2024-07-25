<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Core\Handlers;

use Freyr\Exchange\StockMarket\Core\Ports\SellOrder;

class SellOrderCommandHandler
{
    public function __invoke(SellOrder $command): void
    {
        // load Aggregate By Id

        // process

        // persist new state
    }
}
