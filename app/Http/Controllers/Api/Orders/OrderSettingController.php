<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderSetting;

class OrderSettingController extends Controller
{
    public function index(){
      $order_settings = OrderSetting::first();
      return response()->json($order_settings);
    }
}
