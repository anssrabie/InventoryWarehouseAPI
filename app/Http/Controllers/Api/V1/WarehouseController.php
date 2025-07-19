<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\WarehouseInventoryResource;
use App\Http\Resources\WarehouseResource;
use App\Services\WarehouseService;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function __construct(protected WarehouseService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouses = $this->service->getData();
        return $this->returnData(WarehouseResource::collection($warehouses)->response()->getData(),'Warehouses retrieved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->service->getWarehouseInventoryWithCache($id);
        return $this->returnData(WarehouseInventoryResource::collection($data),'Inventory items for warehouse');
    }
}
