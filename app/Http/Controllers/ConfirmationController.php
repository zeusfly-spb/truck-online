<?php

namespace App\Http\Controllers;

use App\Models\EmailConfirmation;
use Illuminate\Http\Request;

class ConfirmationController extends Controller
{
  public function getEmailConfirmation(Request $request)
  {
    $exists = EmailConfirmation::whereEmail($request->email)->first();
    if ($exists) {
      return response()->json(['confirmation' => $exists->toArray(), 'fresh' => false, 'confirmed' => $exists->confirmed]);
    }
    $conf = EmailConfirmation::create([
      'email' => $request->email,
      'code' => rand(100000, 999999)
    ]);
    return response()->json(['confirmation' => $conf->toArray(), 'fresh' => true]);
  }

  public function markConfirmation(Request $request)
  {
    EmailConfirmation::whereEmail($request->email)->first()->update(['confirmed' => true]);
    return true;
  }

}
