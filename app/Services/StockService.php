<?php

namespace App\Services;

use App\Events\LowStockDetected;
use App\Models\Stock;
use App\Repositories\StockRepository;

class StockService extends BaseService
{
    public function __construct(protected StockRepository $stockRepository)
    {
        parent::__construct($stockRepository);
    }

    public function getStockForUpdate(int $warehouseId, int $inventoryItemId)
    {
        return $this->stockRepository->getStockForUpdate($warehouseId,$inventoryItemId);
    }

    public function updateOrCreateStock(int $warehouseId, int $inventoryItemId)
    {
        return $this->updateOrCreate(
            [
                'warehouse_id' => $warehouseId,
                'inventory_item_id' => $inventoryItemId,
            ],
            [
                'quantity' => 0
            ]
        );
    }

    public function checkLowStock(Stock $stock): void
    {
        if ($stock->quantity < 10) {
            event(new LowStockDetected($stock));
        }
    }
}
