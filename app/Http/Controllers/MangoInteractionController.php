<?php

namespace App\Http\Controllers;

use App\Models\SMSEventLog;
use Illuminate\Http\Request;

class MangoInteractionController extends Controller
{
    public static function smsEventHandler(Request $request)
    {
      $json = $request->input('json', '[]');
      $eventParams = json_decode($json);
      return SMSEventLog::create($eventParams);
    }
}
