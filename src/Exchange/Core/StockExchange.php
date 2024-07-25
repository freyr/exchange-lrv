<?php

declare(strict_types=1);

namespace Freyr\Exchange\Exchange\Core;

use Freyr\Exchange\Exchange\Core\Ports\BuyOrder;
use Freyr\Exchange\Exchange\Core\Ports\SellOrder;
use Freyr\Exchange\Exchange\Core\Ports\TraderInfoPort;
use RuntimeException;

class StockExchange
{
    public function __construct(
        readonly private TraderInfoPort $traderInfo,
        /** @var SellOrder[] */
        private array $sellOrders,
        /** @var BuyOrder[] */
        private array $buyOrders

    ) {
    }

    public function placeSellOrder(
        SellOrder $order
    ): void {
        if (!$this->traderInfo->isAllowedToTrade($order) ||
            !$this->traderInfo->hasEnoughStock($order)) {
            throw new RuntimeException();
        }

        $this->sellOrders[] = $order;
        $matchedOrder = $this->matchSellerToBuyer($order);
    }

    public function placeBuyOrder(BuyOrder $order): void
    {
        if (!$this->traderInfo->isAllowedToTrade($order) ||
            !$this->traderInfo->hasEnoughInWallet($order)) {
            throw new RuntimeException();
        }

        $this->buyOrders[] = $order;
        $matchedOrder = $this->matchBuyerToSeller($order);
    }

    public function matchSellerToBuyer(SellOrder $order): ?BuyOrder
    {
        /** @var BuyOrder[] $buyOrders */
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

    private function matchBuyerToSeller(BuyOrder $order): ?SellOrder
    {
        /** @var SellOrder[] $sellOrders */
        $sellOrders = array_values(
            array_filter(
                $this->sellOrders,
                fn(SellOrder $o) => $o->getPrice() <= $order->getPrice()
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
