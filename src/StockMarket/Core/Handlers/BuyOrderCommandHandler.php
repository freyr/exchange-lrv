<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Core\Handlers;

use Freyr\Exchange\StockMarket\Core\Ports\BuyOrder;
use Freyr\Exchange\StockMarket\Core\Ports\StockExchangeRepository;
use Freyr\Exchange\StockMarket\Core\StockExchangeId;
use Freyr\Exchange\Trader\TraderInfoService;

readonly class BuyOrderCommandHandler
{
    public function __construct(
        private StockExchangeRepository $repository,
        private TraderInfoService $traderInfoPort,
    )
    {

    }
    public function __invoke(BuyOrder $command): void
    {
        $trader = $this->traderInfoPort->load($command->getBrokerId());
        // load Aggregate By Id
        $aggregate = $this->repository->load(
            new StockExchangeId($command->getStockCode())
        );
        // process
        $aggregate->placeBuyOrder($command, $trader);

        // persist new state
        $this->repository->persist($aggregate);



    }
}
