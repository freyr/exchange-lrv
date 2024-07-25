<?php

declare(strict_types=1);

namespace Freyr\Exchange\Trader;

use Freyr\Exchange\StockMarket\Core\Ports\TraderInfoPort;

class TraderInfoService
{
    public function load(string $brokerId): TraderInfoPort
    {
        return new MyTrader();
    }
}
