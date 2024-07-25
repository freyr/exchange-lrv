<?php

declare(strict_types=1);

namespace Freyr\Exchange;

use Symfony\Component\Uid\Uuid;

readonly class AggregateId
{
    public string $id;

    public function __construct(private Uuid $aggregateId)
    {
        $this->id = $this->aggregateId->toRfc4122();
    }

    public static function fromRfc4122($uid): static
    {
        return new static(Uuid::fromRfc4122($uid));
    }

    public static function fromBinary($uid): static
    {
        return new static(Uuid::fromBinary($uid));
    }

    public function equals(AggregateId $id): bool
    {
        return $this->aggregateId->equals($id->aggregateId);
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function toBinary(): string
    {
        return $this->aggregateId->toBinary();
    }
}
