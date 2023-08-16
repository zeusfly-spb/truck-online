<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Containers\ContainerController;
use App\Http\Controllers\Api\Orders\OrderStatusController;
use App\Http\Controllers\Api\Addresses\AddressTypeController;
use App\Http\Controllers\Api\Addresses\AddressController;
use App\Http\Controllers\Api\Companies\CompanyController;
use App\Http\Controllers\Api\Cars\CarTypeController;
use App\Http\Controllers\Api\Drivers\DriverController;
use App\Http\Controllers\Api\Cars\PassController;
use App\Http\Controllers\Api\Cars\RightUseController;
use App\Http\Controllers\Api\Cars\CarController;
use App\Http\Controllers\Api\Orders\OrderController;
use App\Http\Controllers\Api\Orders\OrderSettingController;
use App\Http\Controllers\Api\Taxes\TaxController;
use App\Http\Controllers\Api\Countries\CountryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DadataController;
use App\Http\Controllers\ConfigController;
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
  Route::get('/config', [ConfigController::class, 'getConfig']);
  Route::prefix('dadata')->group(function () {
    Route::post('validate_address', [DadataController::class, 'validateAddress']);
    Route::post('address_geocode', [DadataController::class, 'addressGeocode']);
    Route::post('geo_ip_city', [DadataController::class, 'geoIpCity']);
    Route::post('suggest_address', [DadataController::class, 'suggestAddress']);
    Route::post('find_by_id', [DadataController::class, 'findById']);
  });

  //orders
  Route::apiResource('orders', OrderController::class);
  Route::post('order/store', [OrderController::class, 'store']);
  //drivers
  Route::apiResource('drivers', DriverController::class);
  Route::post('driver/documents/{driver_id}', [DriverController::class, 'uploadDocument']);
  Route::post('driver/files/{driver_id}', [DriverController::class, 'uploadFiles']);

  //cars
  Route::apiResource('car/types', CarTypeController::class);
  Route::apiResource('car/pass/types', PassController::class);
  Route::apiResource('car/right-uses', RightUseController::class);
  Route::apiResource('cars', CarController::class);

  //SuperAdmin user
  Route::post('address/accept/{id}', [AddressController::class, 'accept']);
});

Route::post('/company/find_by_inn',[CompanyController::class, 'findByInn']);

Route::apiResource('containers', ContainerController::class);
Route::apiResource('order-statuses', OrderStatusController::class);
//address
Route::apiResource('addresses', AddressController::class);
//addressClient
Route::get('address/client', [AddressController::class, 'addressCLient']);
//company
Route::apiResource('taxes', TaxController::class);
Route::apiResource('countries', CountryController::class);
Route::apiResource('companies', CompanyController::class);

Route::get('order/settings', [OrderSettingController::class, 'index']);
