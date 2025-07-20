<?php

namespace App\Services;

use App\Data\TransferStockData;
use App\Repositories\StockTransferRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class StockTransferService extends BaseService
{
    public function __construct(protected StockTransferRepository $stockTransferRepository,protected StockService $stockService)
    {
        parent::__construct($stockTransferRepository);
    }

    public function transferStock(TransferStockData $data)
    {
        return DB::transaction(function () use ($data) {

            $qty = $data->quantity;
            $fromWarehouseId = $data->from_warehouse_id;
            $toWarehouseId = $data->to_warehouse_id;
            $inventoryItemId = $data->inventory_item_id;

            $fromStock = $this->stockService->getStockForUpdate($fromWarehouseId,$inventoryItemId);

            if ($fromStock->quantity < $qty) {
                throw ValidationException::withMessages([
                    'message' => 'Not enough stock to transfer.'
                ]);
            }
            $fromStock->quantity -= $qty;
            $fromStock->save();

            $toStock = $this->stockService->updateOrCreateStock($toWarehouseId,$inventoryItemId);
            $toStock->increment('quantity',$qty);

            $transfer = $this->storeResource($data->toArray());

            DB::afterCommit(function () use ($fromStock) {
                $this->stockService->checkLowStock($fromStock);
            });

            return $transfer;

        });
    }
}
