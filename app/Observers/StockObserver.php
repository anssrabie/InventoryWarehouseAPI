<?php

namespace App\Observers;

use App\Models\Stock;
use App\Services\StockService;
use App\Services\WarehouseService;

class StockObserver
{
    public function __construct(protected WarehouseService $warehouseService)
    {
    }

    /**
     * Handle the Stock "created" event.
     */
    public function created(Stock $stock): void
    {
        //
    }

    /**
     * Handle the Stock "updated" event.
     */
    public function updated(Stock $stock): void
    {
        // Clear Cache
        $this->warehouseService->forgetStocksCache($stock->warehouse_id);

    }

    /**
     * Handle the Stock "deleted" event.
     */
    public function deleted(Stock $stock): void
    {
        //
    }

    /**
     * Handle the Stock "restored" event.
     */
    public function restored(Stock $stock): void
    {
        //
    }

    /**
     * Handle the Stock "force deleted" event.
     */
    public function forceDeleted(Stock $stock): void
    {
        //
    }
}
