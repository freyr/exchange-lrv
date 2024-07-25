<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Core;

use Freyr\Exchange\StockMarket\Core\Ports\BuyOrder;
use Freyr\Exchange\StockMarket\Core\Ports\SellOrder;
use Freyr\Exchange\StockMarket\Core\Ports\TraderInfoPort;
use Freyr\Exchange\StockMarket\Infrastructure\OrderInfoAdapter;
use RuntimeException;

class StockExchange
{
    public function __construct(
        readonly public StockExchangeId $id,
        /** @var Order[] */
        private array $sellOrders,
        /** @var Order[] */
        private array $buyOrders,
    ) {
    }

    public function placeSellOrder(SellOrder $command, TraderInfoPort $trader): void
    {
        $order = Order::from($command);
        $orderInfo = OrderInfoAdapter::create($order);
        if (!$trader->isAllowedToTrade($orderInfo) ||
            !$trader->hasEnoughStock($orderInfo)) {
            throw new RuntimeException();
        }

        $this->sellOrders[] = $order;
        $matchedOrder = $this->matchSellerToBuyer($order);
        if ($matchedOrder && $matchedOrder->isNotExecuted() && $order->isNotExecuted()) {
            $order->markAsExecuted($matchedOrder->getId());
            $matchedOrder->markAsExecuted($order->getId());
        }
    }

    public function placeBuyOrder(BuyOrder $command, TraderInfoPort $trader): void
    {
        $order = Order::from($command);
        $orderInfo = OrderInfoAdapter::create($order);
        if (!$trader->isAllowedToTrade($orderInfo) ||
            !$trader->hasEnoughInWallet($orderInfo)) {
            throw new RuntimeException();
        }

        $this->buyOrders[] = $order;
        $matchedOrder = $this->matchBuyerToSeller($order);
        if ($matchedOrder && $matchedOrder->isNotExecuted() && $order->isNotExecuted()) {
            $order->markAsExecuted($matchedOrder->getId());
            $matchedOrder->markAsExecuted($order->getId());
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

}
