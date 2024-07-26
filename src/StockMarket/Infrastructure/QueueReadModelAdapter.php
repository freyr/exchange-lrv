<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Infrastructure;

use Freyr\Exchange\StockMarket\Core\Ports\ReadModelQueuePort;
use Illuminate\Queue\Queue;

class QueueReadModelAdapter implements ReadModelQueuePort
{
    public function __construct(private Queue $queue)
    {

    }

    public function pushOn(string $queueName, string $job, array $payload): void
    {
        $this->queue->pushOn($queueName, $job, $payload);
    }
}
