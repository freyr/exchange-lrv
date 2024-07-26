<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Core;

class Order
{
    private string $status;
    public readonly string $stockCode;
    private ?string $matchedOrderId = null;

    public function __construct(null|int $id, )
    {

    }
    public static function restore(array $dbRow)
    {
        return new self($dbRow['id'],  );
    }
    public static function from(Ports\Order $order): self
    {
        return new self(null, );
    }

    public function markAsExecuted(string $matchedOrderId)
    {
        $this->matchedOrderId = $matchedOrderId;
        $this->status = 'executed';
    }

    public function isNotExecuted(): bool
    {
    }

    public function getId(): string
    {

    }

    public function getPrice(): int
    {

    }
}
