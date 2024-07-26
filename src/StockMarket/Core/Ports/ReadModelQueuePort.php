<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Core\Ports;

interface ReadModelQueuePort
{
    public function pushOn(string $queueName, string $job, array $payload): void;
}
