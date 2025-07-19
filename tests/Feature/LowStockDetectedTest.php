<?php

namespace Tests\Feature;

use App\Events\LowStockDetected;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\InventoryItem;
use App\Services\StockService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class LowStockDetectedTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_fires_low_stock_detected_event()
    {
        Event::fake();

        $warehouse = Warehouse::factory()->create();
        $item = InventoryItem::factory()->create();

        $stock = Stock::factory()->create([
            'warehouse_id' => $warehouse->id,
            'inventory_item_id' => $item->id,
            'quantity' => 5,
        ]);

        $stockService = app(StockService::class);

        $stockService->checkLowStock($stock);

        Event::assertDispatched(LowStockDetected::class);
    }
}
