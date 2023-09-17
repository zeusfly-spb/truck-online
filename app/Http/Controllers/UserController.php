<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserController extends BaseController
{
  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function register(Request $request): JsonResponse
  {
    $username = $this->username();
    $usernameRule = $username === 'email' ? 'required|email' : 'required|digits:10';
    $validator = Validator::make($request->all(), [
      'username' => $usernameRule,
      'password' => 'required|confirmed|min:6'
    ]);
    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }
    $user = User::create([
      $username => $request->input('username'),
      'password' => bcrypt($request->input('password')),
      'company_id' => $request->company_id
    ]);
    $success['token'] = $user->createToken('MyApp')->accessToken;
    $success[$username] = $user->{$username};
    return $this->sendResponse($success, 'User register successfully.');
  }

  /**
   * @return string
   */
  public function username()
  {
    $login = request()->input('username');
    if (is_numeric($login)) {
      $field = 'phone';
    } elseif (filter_var($login, FILTER_VALIDATE_EMAIL)) {
      $field = 'email';
    } else {
      return $this->sendError('Username error!');
    }
    request()->merge([$field => $login]);
    return $field;
  }

  /**
   * @param Request $request
   * @return JsonResponse
   */
  public function login(Request $request): JsonResponse
  {
    $username = $this->username();
    if (Auth::attempt([$username => $request->input('username'), 'password' => $request->input('password')])) {
      $user = User::with('company')->find(Auth::id());
      $success['token'] = $user->createToken('OnlinePort')->accessToken;
      $success['user'] = new UserResource($user);
      return $this->sendResponse($success, 'User login successfully.');
    } else {
      return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
    }
  }

  /**
   * @return JsonResponse
   */
  public function details()
  {
    return response()->json(new UserResource(User::with('company')->find(Auth::id())));
  }

  public function update(Request $request)
  {
    Auth::user()->update($request->all());
    return response()->json(new UserResource(User::with('company')->find(Auth::id())));
  }
}
