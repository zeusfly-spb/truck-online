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
      'dadataApiKey' => env('DADATA_API_KEY'),
      'dadataSecretKey' => env('DADATA_SECRET_KEY')
    ]);
  }
}
