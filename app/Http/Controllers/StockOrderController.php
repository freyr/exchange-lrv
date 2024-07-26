<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Console\PlaceBuyOrderCommand;
use Freyr\Exchange\StockMarket\ReadModel\ReadModelRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Bus;

class StockOrderController extends Controller
{

    public function placeOrder()
    {
        Bus::dispatch(new PlaceBuyOrderCommand());
    }

    public function showSummary(ReadModelRepository $repository): JsonResponse
    {
        $readModel = $repository->getSummaryReadModel();
        return response()->json($readModel);
    }
}
