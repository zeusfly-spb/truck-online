<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MangoInteractionController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('vpbx')->group(function () {
  Route::prefix('events')->group(function () {
    Route::post('sms', [MangoInteractionController::class, 'smsEventHandler']);
  });
});


