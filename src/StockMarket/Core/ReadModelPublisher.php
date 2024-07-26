<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Core;

use Freyr\Exchange\Event;
use Freyr\Exchange\StockMarket\Core\Ports\ReadModelQueuePort;

class ReadModelPublisher
{
    public function __construct(private ReadModelQueuePort $queue)
    {
    }

    /**
     * @param array|Event[] $events
     * @return void
     */
    public function publish(array $events)
    {
        foreach ($events as $event) {
            $this->queue->pushOn(
                'exchange_read_model',
                $event->field('_name'),
                $event->payload()
            );
        }
    }
}
