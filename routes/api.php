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
use App\Http\Controllers\Api\Drivers\DriverController;
use App\Http\Controllers\Api\Orders\OrderActionController;
use App\Http\Controllers\Api\Orders\OrderController;
use App\Http\Controllers\Api\Orders\OrderExecuterController;
use App\Http\Controllers\Api\Orders\OrderSettingController;
use App\Http\Controllers\Api\WayPoints\WayPointController;
use App\Http\Controllers\Api\CalcHistories\CalcHistoryController;
use App\Http\Controllers\Api\Taxes\TaxController;
use App\Http\Controllers\AssignRoleController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\DadataController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MangoInteractionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\Api\BankDetails\BankDetailController;
use Illuminate\Support\Facades\Auth;
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

  Route::middleware('super-admin')->group(function () {
    Route::prefix('assign/role')->group(function () {
      Route::post('executer', [AssignRoleController::class, 'assign_role_executer']);
    });
    Route::post('orderAction/{order_id}/show', [OrderActionController::class, 'show']);
    Route::get('address/accept/{id}', [AddressController::class, 'accept']);
    Route::apiResource('companies', CompanyController::class);
  });

    Route::get('users', [UserController::class, 'index']);
    Route::get('user/addresses', [AddressController::class, 'userAddress']);

  //Orders
  Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('store/byCalcHistory/{calcHistoryId}', [OrderController::class, 'createOrderByCalcHistoryId']);
    Route::get('show/{order_id}', [OrderController::class, 'show']);
    Route::put('update/{order_id}', [OrderController::class, 'update']);
    Route::post('accept/action/{order_action_id}', [OrderActionController::class, 'accept']);
    Route::middleware('executer')->group(function () {
      Route::post('{id}/updates', [OrderExecuterController::class, 'updates']);
    });
  });

  Route::middleware('driver')->group(function () {
    Route::apiResource('way/points', WayPointController::class);
  });

  Route::apiResource('bank_details', BankDetailController::class);
  Route::post('update/company', [CompanyController::class, 'updateCompany']);
  //CRUD Driver
  Route::apiResource('drivers', DriverController::class);
  Route::post('driver/documents/{driver_id}', [DriverController::class, 'uploadDocument']);
  Route::post('driver/files/{driver_id}', [DriverController::class, 'uploadFiles']);

  //Cars
  Route::apiResource('car/types', CarTypeController::class);
  Route::apiResource('car/pass/types', PassController::class);
  Route::apiResource('car/right-uses', RightUseController::class);
  Route::apiResource('cars', CarController::class);

  //calcHistories
  Route::apiResource('calc/histories', CalcHistoryController::class);

  Route::get('roles', [RoleController::class, 'index']);
  Route::get('/mango-roles', function () {
    $roles = MangoInteractionController::getRoles();
    return response()->json($roles);
  });

});

Route::post('orders/store', [OrderController::class, 'store']);

Route::prefix('confirmation')->group(function () {
  Route::post('/get_email_confirm', [ConfirmationController::class, 'getEmailConfirmation']);
  Route::post('/get_phone_confirm', [ConfirmationController::class, 'getPhoneConfirmation']);
  Route::post('/mark_email_confirm', [ConfirmationController::class, 'markConfirmation']);
  Route::post('/mark_phone_confirm', [ConfirmationController::class, 'markPhoneConfirmation']);
});

Route::post('/company/find_by_inn', [CompanyController::class, 'findByInn']);
Route::post('/company/find_by_str', [CompanyController::class, 'findByStr']);

Route::apiResource('addresses', AddressController::class);
Route::apiResource('containers', ContainerController::class);
Route::apiResource('taxes', TaxController::class);
Route::apiResource('countries', CountryController::class);

Route::get('order/settings', [OrderSettingController::class, 'index']);


