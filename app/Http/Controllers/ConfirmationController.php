<?php

namespace App\Http\Controllers;

use App\Events\SendEmailConfirm;
use App\Models\EmailConfirmation;
use App\Models\User;
use Illuminate\Http\Request;

class ConfirmationController extends Controller
{
  public function getEmailConfirmation(Request $request)
  {
    if ($registered = User::whereEmail($request->email)->first()) {
      $errorMessage = 'Пользователь с email ' . $registered->email . ' уже зарегистрирован';
      return response()->json(['error' => $errorMessage]);
    }
    $exists = EmailConfirmation::whereEmail($request->email)->first();
    if ($exists) {
      return response()->json(['confirmation' => $exists->toArray(), 'fresh' => false, 'confirmed' => $exists->confirmed]);
    }
    $conf = EmailConfirmation::create([
      'email' => $request->email,
      'code' => rand(100000, 999999)
    ]);
    SendEmailConfirm::dispatch($conf);
    return response()->json(['confirmation' => $conf->toArray(), 'fresh' => true]);
  }

  public function markConfirmation(Request $request)
  {
    EmailConfirmation::whereEmail($request->email)->first()->update(['confirmed' => true]);
    return true;
  }

}
