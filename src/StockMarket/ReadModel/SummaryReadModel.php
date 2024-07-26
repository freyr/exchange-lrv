<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\ReadModel;

use JsonSerializable;

readonly class SummaryReadModel implements JsonSerializable
{

    public function __construct(
        public string $id,
    )
    {

    }

    public static function fromRaw(array $data)
    {
        return new self();
    }

    public static function fromDb($data)
    {
        return new self();
    }

    public function jsonSerialize(): mixed
    {
        return [

        ];
    }
}
