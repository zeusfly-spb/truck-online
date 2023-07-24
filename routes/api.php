<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Containers\ContainerController;
use App\Http\Controllers\Api\Orders\OrderStatusController;
use App\Http\Controllers\Api\Addresses\AddressTypeController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('containers', ContainerController::class);
Route::apiResource('order-statuses', OrderStatusController::class);
Route::apiResource('address-types', AddressTypeController::class);
