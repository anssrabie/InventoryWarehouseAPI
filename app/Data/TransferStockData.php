<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class TransferStockData extends Data
{
    public function __construct(
        public  int $from_warehouse_id,
        public int $to_warehouse_id,
        public int $inventory_item_id,
        public  int $quantity,
    ) {}
}
