<?php

declare(strict_types=1);

namespace App\Models;

use Freyr\Exchange\StockMarket\Core\StockExchangeES;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserEntityMapper
{

    public static function fromModel(Model|Collection|User|null $user): StockExchangeES
    {
        foreach ($user as $item) {

        }
        return new StockExchangeES($buyOrders, sellOrder);
    }

    public static function toModel(User $userEntity): User
    {
        foreach ($userEntity->getOrders() as $order) {
            $orderModel = self::findOrdrModel($order->id);
            $orderModel->price = $order->getPrice();
            $orderModel->isExecuted = $order->isExecuted();
        }
    }
}
