<?php

use App\Http\Controllers\Api\Addresses\AddressController;
use App\Http\Controllers\Api\Addresses\AddressTypeController;
use App\Http\Controllers\Api\Cars\CarController;
use App\Http\Controllers\Api\Cars\CarTypeController;
use App\Http\Controllers\Api\Cars\PassController;
use App\Http\Controllers\Api\Cars\RightUseController;
use App\Http\Controllers\Api\Companies\CompanyController;
use App\Http\Controllers\Api\Containers\ContainerController;
use App\Http\Controllers\Api\Countries\CountryController;
use App\Http\Controllers\Api\Orders\OrderController;
use App\Http\Controllers\Api\Orders\OrderSettingController;
use App\Http\Controllers\Api\Orders\OrderStatusController;
use App\Http\Controllers\Api\Taxes\TaxController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\DadataController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
  Route::post('/update_user', [UserController::class, 'update']);
  Route::get('/details', [UserController::class, 'details']);
  Route::get('/config', [ConfigController::class, 'getConfig']);
  Route::prefix('dadata')->group(function () {
    Route::post('validate_address', [DadataController::class, 'validateAddress']);
    Route::post('address_geocode', [DadataController::class, 'addressGeocode']);
    Route::post('geo_ip_city', [DadataController::class, 'geoIpCity']);
    Route::post('suggest_address', [DadataController::class, 'suggestAddress']);
    Route::post('find_by_id', [DadataController::class, 'findById']);
    Route::post('info', [DadataController::class, 'getCompanyInfo']);
  });

  //orders
  Route::apiResource('orders', OrderController::class);
  Route::post('order/store', [OrderController::class, 'store']);
});

Route::prefix('confirmation')->group(function () {
  Route::post('/get_email_confirm', [ConfirmationController::class, 'getEmailConfirmation']);
  Route::post('/mark_email_confirm', [ConfirmationController::class, 'markConfirmation']);

});

Route::post('/company/find_by_inn', [CompanyController::class, 'findByInn']);

Route::apiResource('containers', ContainerController::class);
Route::apiResource('order-statuses', OrderStatusController::class);
//address
Route::apiResource('address-types', AddressTypeController::class);
Route::apiResource('addresses', AddressController::class);
Route::apiResource('address/accept', AddressController::class);
//company
Route::apiResource('taxes', TaxController::class);
Route::apiResource('countries', CountryController::class);
Route::apiResource('companies', CompanyController::class);
//cars
Route::apiResource('car/types', CarTypeController::class);
Route::apiResource('car/pass/types', PassController::class);
Route::apiResource('car/right-uses', RightUseController::class);
Route::apiResource('cars', CarController::class);

Route::get('order/settings', [OrderSettingController::class, 'index']);
