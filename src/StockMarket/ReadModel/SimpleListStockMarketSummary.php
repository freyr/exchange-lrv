<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\ReadModel;


class SimpleListStockMarketSummary
{
    public function __construct(private ReadModelRepository $repository)
    {

    }

    public function handle(string $name, array $payload)
    {
        // wybierz dane z payloadu w oparciu o nazwe

        // dociągamy brakujace dane uzywają idkow z payloadu zeby miec kompet informaccji

        // jezeli brakujace dane sa poza BC to uzywamy seriwsu tego kontekstu

        // opakowuje dane w obiekt typu ReadModel

        // zapisuje do dedykowanej tabeli w bazie danych
        $data = [

        ];
        $summaryReadModel = SummaryReadModel::fromRaw($data);
        $this->repository->updateByStock($summaryReadModel);
    }
}
