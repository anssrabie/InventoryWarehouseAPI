<?php

namespace Tests\Feature;

use App\Models\InventoryItem;
use App\Models\Stock;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StockServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_transfers_stock_successfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $fromWarehouse = Warehouse::factory()->create();
        $toWarehouse = Warehouse::factory()->create();
        $item = InventoryItem::factory()->create();

        Stock::factory()->create([
            'warehouse_id' => $fromWarehouse->id,
            'inventory_item_id' => $item->id,
            'quantity' => 20,
        ]);

        $response = $this->postJson('/api/v1/stock-transfers', [
            'from_warehouse_id' => $fromWarehouse->id,
            'to_warehouse_id' => $toWarehouse->id,
            'inventory_item_id' => $item->id,
            'quantity' => 5,
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id' => $fromWarehouse->id,
            'inventory_item_id' => $item->id,
            'quantity' => 15,
        ]);

        $this->assertDatabaseHas('stocks', [
            'warehouse_id' => $toWarehouse->id,
            'inventory_item_id' => $item->id,
            'quantity' => 5,
        ]);
    }
}
