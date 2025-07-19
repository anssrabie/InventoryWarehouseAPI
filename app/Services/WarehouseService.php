<?php

namespace App\Services;

use App\Models\Warehouse;
use App\Repositories\WarehouseRepository;
use Illuminate\Support\Facades\Cache;

class WarehouseService extends BaseService
{
    public function __construct(protected WarehouseRepository $warehouseRepository)
    {
        parent::__construct($warehouseRepository);
    }

    public function getWarehouseInventoryWithCache(string $warehouseId)
    {
        $warehouse = $this->showResource($warehouseId,relations: ['stocks.inventoryItem']);
        return $this->getCachedStocks($warehouse);
    }


    public function getCachedStocks(Warehouse $warehouse){
        return Cache::remember(
            $this->getCachedKey($warehouse->id),
            now()->addMinutes(10),
            fn () => $warehouse->stocks()->with('inventoryItem')->get()
        );
    }

    public function forgetStocksCache(int $warehouseId): void
    {
        Cache::forget($this->getCachedKey($warehouseId));
    }

    private function getCachedKey(int $warehouseId): string
    {
        return "warehouse_{$warehouseId}_inventory";
    }
}
