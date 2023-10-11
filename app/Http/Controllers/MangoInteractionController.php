<?php

namespace App\Http\Controllers;

use App\Models\SMSEventLog;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MangoInteractionController extends Controller
{
  public static function numbers()
  {
    $json = "{}";
    $sign = hash('sha256', env('VPBX_API_KEY') . $json . env('VPBX_API_SALT'));
    $options = [
      'form_params' => [
        'vpbx_api_key' => env('VPBX_API_KEY'),
        'sign' => $sign,
        'json' => $json,
      ],
      'allow_redirects' => false,
    ];
    $httpClient = new Client();
    $response = $httpClient->post(env('VPBX_API_URL') . '/forwarding/numbers', $options);
    return json_decode($response->getBody());
  }

  public static function users()
  {
    $json = "{}";
    $sign = hash('sha256', env('VPBX_API_KEY') . $json . env('VPBX_API_SALT'));
    $options = [
      'form_params' => [
        'vpbx_api_key' => env('VPBX_API_KEY'),
        'sign' => $sign,
        'json' => $json,
      ],
      'allow_redirects' => false,
    ];
    $httpClient = new Client();
    $response = $httpClient->post(env('VPBX_API_URL') . '/config/users/request', $options);
    return json_decode($response->getBody())->users;
  }

  public static function addUser(array $params) {
    $json = json_encode((Object)$params);
    $sign = hash('sha256', env('VPBX_API_KEY') . $json . env('VPBX_API_SALT'));
    $options = [
      'form_params' => [
        'vpbx_api_key' => env('VPBX_API_KEY'),
        'sign' => $sign,
        'json' => $json,
      ],
      'allow_redirects' => false,
    ];
    $httpClient = new Client();
    $response = $httpClient->post(env('VPBX_API_URL') . '/member/create', $options);
    return json_decode($response->getBody());
  }

  public static function getRoles()
  {
    $json = "{}";
    $sign = hash('sha256', env('VPBX_API_KEY') . $json . env('VPBX_API_SALT'));
    $options = [
      'form_params' => [
        'vpbx_api_key' => env('VPBX_API_KEY'),
        'sign' => $sign,
        'json' => $json,
      ],
      'allow_redirects' => false,
    ];
    $httpClient = new Client();
    $response = $httpClient->post(env('VPBX_API_URL') . '/roles', $options);
    return json_decode($response->getBody());
  }
    public static function smsEventHandler(Request $request)
    {
      Log::info(json_encode($request->all()));
      return response()->json(['message' => json_encode($request->all())]);
//      $json = $request->input('json', '[]');
//      $eventParams = json_decode($json);
//      return SMSEventLog::create($eventParams);
    }
}
