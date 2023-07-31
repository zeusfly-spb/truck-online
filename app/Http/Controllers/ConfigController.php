<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigController extends Controller
{
  /**
   * @return \Illuminate\Http\JsonResponse
   */
  public function getConfig()
  {
    return response()->json([
      'dadata_api_key' => env('DADATA_API_KEY'),
      'dadata_secret_key' => env('DADATA_SECRET_KEY')
    ]);
  }
}
