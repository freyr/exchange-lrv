<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\Core\Handlers;

use Freyr\Exchange\StockMarket\Core\Ports\BuyOrder;
use Freyr\Exchange\StockMarket\Core\Ports\StockExchangeRepository;
use Freyr\Exchange\StockMarket\Core\StockExchangeId;

readonly class BuyOrderCommandHandler
{
    public function __construct(private StockExchangeRepository $repository)
    {

    }

    public function __invoke(BuyOrder $command): void
    {
        $aggregate = $this->repository->load(new StockExchangeId($command->getStockCode()));
        $aggregate->newIPO($command);
        $this->repository->persist($aggregate);
    }
}
