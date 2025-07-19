<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseInventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'inventory_item_id' => $this->inventory_item_id,
            'name' => $this->inventoryItem->name,
            'sku' => $this->inventoryItem->sku,
            'quantity' => $this->quantity,
        ];
    }
}
