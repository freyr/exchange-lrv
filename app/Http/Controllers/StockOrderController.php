<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Console\PlaceBuyOrderCommand;
use Illuminate\Support\Facades\Bus;

class StockOrderController extends Controller
{

    public function placeOrder()
    {
        Bus::dispatch(new PlaceBuyOrderCommand());
    }
}
