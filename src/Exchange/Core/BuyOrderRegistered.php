<?php

declare(strict_types=1);

namespace Freyr\Exchange\Exchange\Core;

use Freyr\Exchange\Event;

class BuyOrderRegistered extends Event
{

    public static function name(): string
    {
        return 'exchange.order.buy.registered';
    }
}
