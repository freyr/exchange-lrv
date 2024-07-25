<?php

declare(strict_types=1);

namespace Freyr\Exchange\Exchange\Core;

use Freyr\Exchange\Exchange\Core\Ports\SellOrder;

class SellOrderCommandHandler
{
    public function __invoke(SellOrder $command): void
    {
    }
}
