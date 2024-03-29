<?php

namespace App\Http\Controllers;

use App\Events\SendEmailConfirm;
use App\Http\Resources\EmailConfirmationResource;
use App\Http\Resources\PhoneConfirmationResource;
use App\Models\EmailConfirmation;
use App\Models\PhoneConfirmation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConfirmationController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getEmailConfirmation(Request $request)
    {
        if ($registered = User::whereEmail($request->email)->first()) {
            $errorMessage = 'Пользователь с email ' . $registered->email . ' уже зарегистрирован';
            return response()->json(['error' => $errorMessage]);
        }
        $exists = EmailConfirmation::whereEmail($request->email)->first();
        if ($exists) {
            return response()->json(['confirmation' => new EmailConfirmationResource($exists),
              'fresh' => false,'confirmed' => $exists->confirmed]);
        }
        $conf = EmailConfirmation::create([
            'email' => $request->email,
            'code' => rand(100000, 999999)
        ]);
        SendEmailConfirm::dispatch($conf);
        return response()->json(['confirmation' => new EmailConfirmationResource($conf), 'fresh' => true]);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function markConfirmation(Request $request)
    {
        return !!EmailConfirmation::whereEmail($request->email)->first()->update(['confirmed' => true]);
    }

  /**
   * @param Request $request
   * @return JsonResponse
   */
    public function getPhoneConfirmation(Request $request)
    {
        if ($registered = User::wherePhone($request->phone)->first()) {
            $errorMessage = 'Пользователь с номером ' . $registered->phone . ' уже зарегистрирован';
            return response()->json(['error' => $errorMessage]);
        }
        if ($exists = PhoneConfirmation::wherePhone($request->phone)->first()) {
            return response()->json(['confirmation' => new PhoneConfirmationResource($exists), 'fresh' => false]);
        }
        if ($conf = PhoneConfirmation::create(['phone' => $request->phone, 'code' => rand(1000, 9999)])) {
            $number = '7' . $conf->phone;
            SmsController::send($number, $conf->code);
        }
        return response()->json(['confirmation' => new PhoneConfirmationResource($conf), 'fresh' => true]);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function markPhoneConfirmation(Request $request)
    {
        return !!PhoneConfirmation::wherePhone($request->phone)->first()->update(['confirmed' => true]);
    }
}
