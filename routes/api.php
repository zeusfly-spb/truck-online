<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Containers\ContainerController;
use App\Http\Controllers\Api\Orders\OrderStatusController;
use App\Http\Controllers\Api\Addresses\AddressTypeController;
use App\Http\Controllers\Api\Addresses\AddressController;
use App\Http\Controllers\Api\Companies\CompanyController;
use App\Http\Controllers\Api\Cars\CarTypeController;
use App\Http\Controllers\Api\Cars\PassController;
use App\Http\Controllers\Api\Cars\RightUseController;
use App\Http\Controllers\Api\Cars\CarController;
use App\Http\Controllers\Api\Orders\OrderController;
use App\Http\Controllers\Api\Orders\OrderSettingController;
use App\Http\Controllers\Api\Taxes\TaxController;
use App\Http\Controllers\Api\Countries\CountryController;
use App\Http\Controllers\UserController;

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
 // Route::resource('orders', OrderController::class);
});

Route::apiResource('containers', ContainerController::class);
Route::apiResource('order-statuses', OrderStatusController::class);
//address
Route::apiResource('address-types', AddressTypeController::class);
Route::apiResource('addresses', AddressController::class);
//company
Route::apiResource('taxes', TaxController::class);
Route::apiResource('countries', CountryController::class);
Route::apiResource('companies', CompanyController::class);
//cars
Route::apiResource('car/types', CarTypeController::class);
Route::apiResource('car/pass/types', PassController::class);
Route::apiResource('car/right-uses', RightUseController::class);
Route::apiResource('cars', CarController::class);
//orders
Route::apiResource('orders', OrderController::class);
Route::post('order/store', [OrderController::class, 'store']);
Route::get('order/settings', [OrderSettingController::class, 'index']);
