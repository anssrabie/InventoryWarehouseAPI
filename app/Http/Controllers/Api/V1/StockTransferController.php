<?php

namespace App\Http\Controllers\Api\V1;

use App\Data\TransferStockData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StockTransferRequest;
use App\Http\Resources\StockTransferResource;
use App\Services\StockTransferService;
use Illuminate\Http\Request;

class StockTransferController extends Controller
{
    public function __construct(protected StockTransferService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->service->getData(relations: ['fromWarehouse', 'toWarehouse', 'inventoryItem'],filters: [
            'from_warehouse_id','to_warehouse_id','inventory_item_id'
        ]);
        return $this->returnData(StockTransferResource::collection($data)->response()->getData(),'Stock transfers retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StockTransferRequest $request)
    {
        $dto = TransferStockData::from($request);
        $this->service->transferStock($dto);
        return $this->successMessage('Stock transferred successfully',201);
    }
}
