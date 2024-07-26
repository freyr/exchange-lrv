<?php

declare(strict_types=1);

namespace Freyr\Exchange;

use DateTimeImmutable;
use DateTimeZone;
use Freyr\Exchange\StockMarket\Core\Order;
use Symfony\Component\Uid\Uuid;

abstract class Event
{
    public function __construct(protected array $payload)
    {
    }

    public static function occur(AggregateId $aggregateId, array $payload): self
    {
        $payload['_aggregateId'] = $aggregateId->id;
        $id = $payload['_id'] ?? Uuid::v7();
        $payload['_id'] = (string)$id;
        $payload['_name'] = static::name();
        /** @noinspection PhpUnhandledExceptionInspection */
        $payload['_occurred_on'] = new DateTimeImmutable('now', new DateTimeZone('UTC'));
        return new static($payload);
    }

    abstract public static function name(): string;

    public function payload(): array
    {
        return $this->payload;
    }

    public function binaryAggregateId(): string
    {
        return Uuid::fromRfc4122($this->field('_aggregateId'))->toBinary();
    }

    public function field($key)
    {
        return $this->payload[$key];
    }

    public function aggregateId(): string
    {
        return $this->field('_aggregateId');
    }
}
