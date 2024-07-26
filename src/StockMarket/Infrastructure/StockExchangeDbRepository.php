<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Infrastructure;

use Freyr\Exchange\AggregateId;
use Freyr\Exchange\AggregateRepository;
use Freyr\Exchange\AggregateRoot;
use Freyr\Exchange\Event;
use Freyr\Exchange\StockMarket\Core\Events\BuyOrderRegistered;
use Freyr\Exchange\StockMarket\Core\Order;
use Freyr\Exchange\StockMarket\Core\Ports\StockExchangeRepository;
use Freyr\Exchange\StockMarket\Core\StockExchangeES;

class StockExchangeDbRepository extends AggregateRepository implements StockExchangeRepository
{

    public function load(AggregateId $id): AggregateRoot
    {
        $sql = 'select * from stock_exchange se
                join stocks_orders so on se.id = so.stock_id
                where se.id = :stock_id';
        $data = $this->db->fetchAllAssociative($sql, ['stock_id' => $id->toBinary()]);
        foreach ($data as $row) {
            $buyOrder[] = new Order();
            $sellOrder[] = new Order();
        }
        return new StockExchangeES($stock_code, $buyOrder, $sellOrder);
    }

    protected function persistEvent(Event $event): void
    {
        match($event->field('_name')) {
            BuyOrderRegistered::name() => $this->doSomething(),
            /*
             * ...
             * ...
             * ...
             */
        };
        $this->logger->log($event);
    }

    protected function extractEvents(AggregateRoot $aggregate): array
    {
        $eventExtractor = function (): array {return $this->popRecordedEvents();};
        return $eventExtractor->call($aggregate);
    }


}
