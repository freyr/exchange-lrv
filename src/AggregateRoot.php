<?php

declare(strict_types=1);

namespace Freyr\Exchange;

use RuntimeException;

abstract class AggregateRoot
{
    private array $events = [];

    /** @param array $payloads */

    protected function apply(Event $event): void
    {
    }

    /** @return array<int, Event> */
    private function popRecordedEvents(): array
    {
        $pendingEvents = $this->events;
        $this->events = [];
        return $pendingEvents;
    }

    protected function record(Event $event): void
    {
        $this->events[] = $event;
        $this->apply($event);
    }
}
