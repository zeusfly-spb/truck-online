<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Containers\ContainerController;
use App\Http\Controllers\Api\Orders\OrderStatusController;
use App\Http\Controllers\Api\Addresses\AddressTypeController;
use App\Http\Controllers\Api\Addresses\AddressController;
use App\Http\Controllers\Api\Companies\CompanyController;
use App\Http\Controllers\Api\Cars\CarTypeController;
use App\Http\Controllers\Api\Taxes\TaxController;
use App\Http\Controllers\Api\Countries\CountryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DadataController;
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
  Route::prefix('dadata')->group(function () {
    Route::post('validate_address', [DadataController::class, 'validateAddress']);
    Route::post('address_geocode', [DadataController::class, 'addressGeocode']);
    Route::post('geo_ip_city', [DadataController::class, 'geoIpCity']);
    Route::post('suggest_address', [DadataController::class, 'suggestAddress']);
    Route::post('find_by_id', [DadataController::class, 'findById']);
  });
});

Route::apiResource('containers', ContainerController::class);
Route::apiResource('order-statuses', OrderStatusController::class);
Route::apiResource('address-types', AddressTypeController::class);
Route::apiResource('addresses', AddressController::class);
Route::apiResource('taxes', TaxController::class);
Route::apiResource('countries', CountryController::class);
Route::apiResource('companies', CompanyController::class);
Route::apiResource('car/types', CarTypeController::class);
