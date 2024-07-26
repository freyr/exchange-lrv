<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Infrastructure;

use Freyr\Exchange\AggregateId;
use Freyr\Exchange\AggregateRepository;
use Freyr\Exchange\AggregateRoot;
use Freyr\Exchange\Event;
use Freyr\Exchange\StockMarket\Core\Ports\StockExchangeRepository;
use Freyr\Exchange\StockMarket\Core\StockExchangeES;

class StockExchangeDbESRepository extends AggregateRepository implements StockExchangeRepository
{

    public function load(AggregateId $id): AggregateRoot
    {
        $sql = 'select es.payload from exchange_store es
                join stocks s on es.stock_id = s.id
                where s.id = :stock_id';
        $payloads = $this->db->fetchFirstColumn($sql, ['stock_id' => $id->toBinary()]);
        return StockExchangeES::fromStream($payloads);
    }

    protected function persistEvent(Event $event): void
    {
        $this->persistToStore($event);
        $this->logger->log($event);
    }

    private function persistToStore(Event $event): void
    {
        $sql = 'insert into exchange_store (stock_id, payload) values (:stockId, :payload)';
        $this->db->executeStatement(
            $sql,
            [
                'stockId' => $event->binaryAggregateId(),
                'payload' => json_encode($event->payload())
            ]
        );
    }

}
