<?php

declare(strict_types=1);

namespace App\Console;


use Freyr\Exchange\Exchange\Core\Ports\BuyOrder;
use Illuminate\Console\Command;

class PlaceBuyOrderCommand extends Command implements BuyOrder
{

    public function getPrice(): int
    {
        // TODO: Implement getPrice() method.
    }

    public function getBrokerId(): string
    {
        // TODO: Implement getBrokerId() method.
    }
}
