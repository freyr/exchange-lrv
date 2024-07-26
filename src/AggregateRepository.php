<?php

declare(strict_types=1);

namespace Freyr\Exchange;

use Doctrine\DBAL\Connection;
use Freyr\Exchange\StockMarket\Core\ReadModelPublisher;
use Throwable;

abstract class AggregateRepository
{

    public function __construct(protected Connection $db, private ReadModelPublisher $publisher)
    {
    }

    abstract public function load(AggregateId $id): AggregateRoot;

    public function persist(AggregateRoot $aggregateRoot): void
    {
        $events = $this->extractEvents($aggregateRoot);
        try {
            $this->db->beginTransaction();
            foreach ($events as $event) {
                $this->persistEvent($event);
            }
            $this->db->commit();
            // radmodels
            $this->publisher->publish($events);
        } catch (Throwable $exception) {
            if ($this->db->isTransactionActive()) {
                $this->db->rollBack();
            }
            throw new $exception;
        }

    }

    /** @return Event[] */
    protected function extractEvents(AggregateRoot $aggregate): array
    {
        $eventExtractor = function (): array {return $this->popRecordedEvents();};
        return $eventExtractor->call($aggregate);
    }


    abstract protected function persistEvent(Event $event): void;
}
