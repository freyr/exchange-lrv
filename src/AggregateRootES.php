<?php

declare(strict_types=1);

namespace Freyr\Exchange;

abstract class AggregateRootES
{
    public AggregateId $id;
    private array $events = [];

    public static function fromStream(array $streamEvents): static
    {
        $instance = new static();
        if (!empty($streamEvents)) {
            $instance->replay($streamEvents);
        }


        return $instance;
    }

    /** @param array $payloads */
    protected function replay(array $payloads): void
    {
        foreach ($payloads as $payload) {
            $this->apply(static::restore(json_decode($payload, true)));
        }
    }

    abstract protected function apply(Event $event): void;

    abstract protected static function restore(array $payload): Event;

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
