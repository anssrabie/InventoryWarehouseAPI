<?php

namespace App\Repositories;

use App\Models\Stock;

class StockRepository extends BaseRepository
{
    public function __construct(protected Stock $stock)
    {
        parent::__construct($stock);
    }

    public function getStockForUpdate(int $warehouseId, int $inventoryItemId){
        return $this->model->where('warehouse_id', $warehouseId)
            ->where('inventory_item_id', $inventoryItemId)
            ->lockForUpdate()
            ->firstOrFail();
    }
}
