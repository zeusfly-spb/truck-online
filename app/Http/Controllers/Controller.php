<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(title="OnlinePort", version="0.1"),
 * @OA\SecurityScheme(
 *   securityScheme="bearer_token",
 *   type="http",
 *   scheme="bearer"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
