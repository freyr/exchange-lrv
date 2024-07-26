<?php

declare(strict_types=1);

namespace Freyr\Exchange\StockMarket\ReadModel;

class ReadModelRepository
{

    public function updateByStock(string $stock_full_name, array $data): void
    {
        $sql = 'UPDATE stock_market_summary
            set sum_sell_orders = sum_sell_orders + 1,
                total_value_for_sale = total_value + (:price * :amount)
            WHERE stock_full_name = :stock_full_name';
    }

    public function getSummaryReadModel(): SummaryReadModel
    {
        $sql = 'select * from stock_market_summary';
        // fetch from db
        return SummaryReadModel::fromDb($data);
    }
}
