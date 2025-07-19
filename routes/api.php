<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\InventoryController;
use App\Http\Controllers\Api\V1\StockTransferController;
use App\Http\Controllers\Api\V1\WarehouseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);

    Route::apiResource('inventory', InventoryController::class)->only(['index']);
    Route::apiResource('stock-transfers', StockTransferController::class)->only(['index','store']);
    Route::get('warehouses/{id}/inventory', [WarehouseController::class, 'show']);
    Route::get('warehouses', [WarehouseController::class, 'index']);

});
