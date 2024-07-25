<?php

declare(strict_types=1);

namespace Freyr\Exchange\Exchange\Core;

use Freyr\Exchange\Exchange\Core\Ports\BuyOrder;

class BuyOrderCommandHandler
{
    public function __invoke(BuyOrder $command): void
    {
        // load Aggregate By Id

        // process

        // persist new state
    }
}
