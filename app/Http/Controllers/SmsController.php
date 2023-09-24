<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Str;


class SmsController extends Controller
{
  public static function send($number, $text)
  {
    $params = [
      "text" => $text,
      "to_number" => $number,
      "command_id" => Str::uuid(),
      "from_extension" => "9977",
    ];
    $json = json_encode($params);
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
    return json_decode($httpClient->post(env('VPBX_API_URL') . '/commands/sms', $options)->getBody());
  }
}
