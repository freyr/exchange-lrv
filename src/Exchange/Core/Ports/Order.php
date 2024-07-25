<?php

declare(strict_types=1);

namespace Freyr\Exchange\Exchange\Core\Ports;

interface Order
{
    public function getPrice(): int;

    public function getBrokerId(): string;
}
