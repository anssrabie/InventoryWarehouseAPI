<?php

namespace Tests\Unit;

use App\Data\TransferStockData;
use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\User;
use App\Models\Warehouse;
use App\Services\StockTransferService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class StockServiceTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_it_fails_when_transferring_more_than_available()
    {

        $fromWarehouse = Warehouse::factory()->create();
        $toWarehouse = Warehouse::factory()->create();
        $item = InventoryItem::factory()->create();

        Stock::factory()->create([
            'warehouse_id' => $fromWarehouse->id,
            'inventory_item_id' => $item->id,
            'quantity' => 5,
        ]);

        $service = app(StockTransferService::class);

        $data = new TransferStockData(
            from_warehouse_id: $fromWarehouse->id,
            to_warehouse_id: $toWarehouse->id,
            inventory_item_id: $item->id,
            quantity: 10
        );

        $this->expectException(ValidationException::class);
        $service->transferStock($data);
    }


}
