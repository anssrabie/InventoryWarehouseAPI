<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\FilterPriceRange;
use App\Http\Controllers\Controller;
use App\Http\Resources\InventoryItemResource;
use App\Services\InventoryItemService;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class InventoryController extends Controller
{
    public function __construct(protected InventoryItemService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->service->getData(filters: [
            'name',
            'sku',
            AllowedFilter::custom('price_from', new FilterPriceRange()),
            AllowedFilter::custom('price_to', new FilterPriceRange()),
        ],sorts: ['id','name','price' ]);
        return $this->returnData(InventoryItemResource::collection($data)->response()->getData(),'Inventory Items retrieved successfully');
    }

}
