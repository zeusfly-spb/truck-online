<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Containers\ContainerController;
use App\Http\Controllers\Api\Orders\OrderStatusController;
use App\Http\Controllers\Api\Addresses\AddressTypeController;
use App\Http\Controllers\Api\Addresses\AddressController;
use App\Http\Controllers\Api\Companies\CompanyController;
use App\Http\Controllers\Api\Cars\CarTypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

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
Route::prefix('auth')->group(function () {
  Route::post('/register', [UserController::class, 'register']);
  Route::post('/login', [UserController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
  Route::get('/details', [UserController::class, 'details']);
  Route::resource('orders', OrderController::class);
});

Route::apiResource('containers', ContainerController::class);
Route::apiResource('order-statuses', OrderStatusController::class);
Route::apiResource('address-types', AddressTypeController::class);
Route::apiResource('addresses', AddressController::class);
Route::apiResource('companies', CompanyController::class);
Route::apiResource('car/types', CarTypeController::class);
