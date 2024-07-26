<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Core\Events;

use Freyr\Exchange\Event;
use Freyr\Exchange\StockMarket\Core\Order;

class BuyOrderRegistered extends Event
{

    public static function name(): string
    {
        return 'exchange.order.buy.registered';
    }

    public function getOrder(): Order
    {
        return new Order(
            $this->field('order_id'),/*....*/
        );
    }
}
