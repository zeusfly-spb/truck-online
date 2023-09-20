<?php

namespace App\Http\Controllers;

use App\Models\SMSEventLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MangoInteractionController extends Controller
{
    public static function smsEventHandler(Request $request)
    {
      Log::info(json_encode($request->all()));
      return response()->json(['message' => json_encode($request->all())]);
//      $json = $request->input('json', '[]');
//      $eventParams = json_decode($json);
//      return SMSEventLog::create($eventParams);
    }
}
