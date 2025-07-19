<?php

namespace App\Repositories;

use App\Models\StockTransfer;

class StockTransferRepository extends BaseRepository
{
    public function __construct(protected StockTransfer $stockTransfer)
    {
        parent::__construct($stockTransfer);
    }
}
