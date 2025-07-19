<?php

namespace App\Repositories;

use App\Models\InventoryItem;

class InventoryItemRepository extends BaseRepository
{
    public function __construct(protected InventoryItem $inventoryItem)
    {
        parent::__construct($inventoryItem);
    }
}
