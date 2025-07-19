<?php

namespace App\Repositories;

use App\Models\Warehouse;

class WarehouseRepository extends BaseRepository
{
    public function __construct(protected Warehouse $warehouse)
    {
        parent::__construct($warehouse);
    }
}
