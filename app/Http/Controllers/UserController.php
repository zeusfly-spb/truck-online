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
    $validator = Validator::make($request->all(), [
      'email' => 'required|email',
      'password' => 'required|confirmed|min:6',
      'phone' => 'required|digits:10',
      'contact_person' => 'required'
    ]);
    if ($validator->fails()) {
      return $this->sendError('Validation Error.', $validator->errors());
    }
    $user = User::create([
      'email' => $request->email,
      'password' => bcrypt($request->password),
      'phone' => $request->phone,
      'company_id' => $request->company_id
    ]);
    $user->addMangoAccount();
    $success['token'] = $user->createToken('MyApp')->accessToken;
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
      $user = User::with('company', 'roles')->find(Auth::id());
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
    return response()->json(new UserResource(User::with('company', 'roles')->find(Auth::id())));
  }

  public function update(Request $request)
  {
    Auth::user()->update($request->all());
    return response()->json(new UserResource(User::with('company', 'roles')->find(Auth::id())));
  }
  /**
   * @OA\Get(
   *     path="/api/users",
   *     summary="Get list of Users",
   *     security={{"bearer_token": {}}},
   *     tags = {"Users"},
   *     @OA\Parameter(
   *         description="Localization",
   *         in="header",
   *         name="X-Localization",
   *         required=false,
   *         @OA\Schema(type="string"),
   *         @OA\Examples(example="ru", value="ru", summary="Russian")
   *    ),
   *     @OA\Response(
   *         response=200,
   *         description="SUCCESS",
   *         @OA\JsonContent()
   *     ),
   * )
  */
  public function index(){
    $users = [];
    if(Auth::user()->hasRole('super-admin'))
      $users = User::with('company', 'roles')->get();
    else $users = User::where('company_id', Auth::user()->company_id)->with('company', 'roles')->get();

    return response()->json(UserResource::collection($users)->collection);

  }
}
