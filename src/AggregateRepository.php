<?php

declare(strict_types=1);

namespace Freyr\Exchange;

use Doctrine\DBAL\Connection;
use Throwable;

readonly abstract class AggregateRepository
{

    public function __construct(protected Connection $db)
    {
    }

    abstract public function load(AggregateId $id): AggregateRoot;

    public function persist(AggregateRoot $aggregateRoot): void
    {
        $events = $aggregateRoot->popRecordedEvents();
        try {
            $this->db->beginTransaction();
            foreach ($events as $event) {
                $this->persistEvent($event);
            }
            $this->db->commit();
        } catch (Throwable) {
            if ($this->db->isTransactionActive()) {
                $this->db->rollBack();
            }
        }
    }

    /** @return Event[] */
    public function extractEvents(AggregateRoot $aggregate): array
    {
        $eventExtractor = function (): array {return $this->popRecordedEvents();};
        return $eventExtractor->call($aggregate);
    }
    abstract protected function persistEvent(Event $event): void;
}
