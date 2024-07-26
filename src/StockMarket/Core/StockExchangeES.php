<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Core;

use Freyr\Exchange\AggregateRoot;
use Freyr\Exchange\AggregateRootES;
use Freyr\Exchange\Event;
use Freyr\Exchange\StockMarket\Core\Events\BuyOrderRegistered;
use Freyr\Exchange\StockMarket\Core\Events\OrdersWasExecuted;
use Freyr\Exchange\StockMarket\Core\Events\SellOrderRegistered;
use Freyr\Exchange\StockMarket\Core\Ports\BuyOrder;
use Freyr\Exchange\StockMarket\Core\Ports\SellOrder;

class StockExchangeES extends AggregateRootES
{
    /** @var Order[] */
    private array $buyOrders = [];
    /** @var Order[] */
    private array $sellOrders = [];

    public function placeSellOrder(SellOrder $command): void
    {
        $order = Order::from($command);
        $this->record(SellOrderRegistered::occur($this->id, [
            'order_id' => $order->getId(),
            'price' => $order->getPrice(),
            'stock_code' => $order->stockCode,
            'type' => 'sell'
        ]));
        $matchedOrder = $this->matchSellerToBuyer($order);
        if ($matchedOrder && $matchedOrder->isNotExecuted() && $order->isNotExecuted()) {
            $this->record(OrdersWasExecuted::occur($this->id, [
                'sell_order_id' => $order->getId(),
                'buy_order_id' => $matchedOrder->getId(),
            ]));
        }
    }

    public function placeBuyOrder(BuyOrder $command): void
    {
        $order = Order::from($command);
        $this->record(BuyOrderRegistered::occur($this->id, [
            'order_id' => $order->getId(),
            'price' => $order->getPrice(),
            'stock_code' => $order->stockCode,
            'type' => 'buy'
        ]));
        $matchedOrder = $this->matchBuyerToSeller($order);
        if ($matchedOrder && $matchedOrder->isNotExecuted() && $order->isNotExecuted()) {
            $this->record(OrdersWasExecuted::occur($this->id, [
                'sell_order_id' => $matchedOrder->getId(),
                'buy_order_id' => $order->getId(),
            ]));
        }
    }

    private function matchSellerToBuyer(Order $order): ?Order
    {
        /** @var Order[] $buyOrders */
        $buyOrders = array_values(
            array_filter(
                $this->buyOrders,
                fn(BuyOrder $o) => $o->getPrice() >= $order->getPrice()
            )
        );
        if (!$buyOrders) {
            return null;
        }
        $bestOrder = $buyOrders[0];
        foreach ($buyOrders as $o) {
            if ($o->getPrice() > $bestOrder->getPrice()) {
                $bestOrder = $o;
            }
        }

        return $bestOrder;

    }

    private function matchBuyerToSeller(Order $order): ?Order
    {
        /** @var Order[] $sellOrders */
        $sellOrders = array_values(
            array_filter(
                $this->sellOrders,
                fn(Order $o) => $o->getPrice() <= $order->getPrice()
            )
        );
        if (!$sellOrders) {
            return null;
        }
        $bestOrder = $sellOrders[0];
        foreach ($sellOrders as $o) {
            if ($o->getPrice() < $bestOrder->getPrice()) {
                $bestOrder = $o;
            }
        }

        return $bestOrder;
    }

    private function addNewBuyOrder(Event $event): void
    {
        $this->buyOrders[$event->field('order_id')] = new Order(
            $event->field('order_id'),
        );
    }

    private function addNewSellOrder(Event $event): void
    {
        $this->sellOrders[$event->field('order_id')] = new Order(
            $event->field('order_id'),
        );
    }

    private function executeOrder(Event $event): void
    {
        $order = $this->buyOrders[$event->field('sell_order_id')];
        $matchedOrder = $this->buyOrders[$event->field('buy_order_id')];
        $order->markAsExecuted($matchedOrder->getId());
        $matchedOrder->markAsExecuted($order->getId());
    }

    protected function apply(Event $event): void
    {
        match ($event->field('_name')) {
            BuyOrderRegistered::name() => $this->addNewBuyOrder($event),
            SellOrderRegistered::name() => $this->addNewSellOrder($event),
            OrdersWasExecuted::name() => $this->executeOrder($event)
        };
    }

    protected static function restore(array $payload): Event
    {
        return match ($payload['_name']) {
            BuyOrderRegistered::name() => new BuyOrderRegistered($payload),
            SellOrderRegistered::name() => new SellOrderRegistered($payload),
            OrdersWasExecuted::name() => new OrdersWasExecuted($payload),
        };
    }
}
