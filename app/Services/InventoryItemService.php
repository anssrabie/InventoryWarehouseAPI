<?php

namespace App\Services;

use App\Repositories\InventoryItemRepository;

class InventoryItemService extends BaseService
{
    public function __construct(protected InventoryItemRepository $inventoryRepository)
    {
        parent::__construct($inventoryRepository);
    }
}
