<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Models\OrderAction;
use App\Models\Order;
use Auth;
use Illuminate\Http\Request;

class OrderExecuterController extends Controller
{
    /**
      * @OA\Post(
      *      path="/api/orders/{id}/updates",
      *      operationId="Executer update order drivers & cars",
      *      security={{"bearer_token": {}}},
      *      tags={"Orders"},
      *      summary="Executer update order drivers & cars",
      *      description="Executer update order drivers & cars",
      *      @OA\RequestBody(
      *         @OA\MediaType(
      *             mediaType="application/json",
      *             @OA\Schema(
      *                 @OA\Property(
      *                     property="driver_id",
      *                     type="integer",
      *                     example="1"
      *                 ),
      *                 @OA\Property(
      *                     property="car_id",
      *                     type="integer",
      *                     example="1"
      *                 ),
      *                 @OA\Property(
      *                     property="car2_id",
      *                     type="integer",
      *                     example="1"
      *                 ),
      *             )
      *         )
      *     ),
      *     @OA\Parameter(
      *         in="path",
      *         name="id",
      *         required=false,
      *         @OA\Schema(type="integer", example="1"),
      *     ),
      *     @OA\Parameter(
      *         description="Localization",
      *         in="header",
      *         name="X-Localization",
      *         required=false,
      *         @OA\Schema(type="string"),
      *         @OA\Examples(example="ru", value="ru", summary="Russian")
      *     ),
      *     @OA\Response(
      *         response=200,
      *         description="SUCCESS",
      *     ),
      *   )
    */
    public function updates(Request $request, $id){

      $order = Order::find($id);

      $allInput = $request->all();
      foreach ($allInput as $fieldName => $fieldValue) {

        $order_action = OrderAction::create([
          'order_id' => $order->id,
          'column_name' => $fieldName,
          'old_value' => $order->$fieldName,
          'update_value' => $fieldValue,
          'status' => 1, // 0 = waiting // 1 = accept // 2 = decline
          'user_id' => Auth::user()->id,//id otpravitelya
        ]);
        $order_action->order_action_id = $order_action->id;  //null if ApprovalPending // orderActionId if Accept the or Decline
        $order_action->save();

        $order->$fieldName = $fieldValue;
        $order->save();
      }
      return response()->json([
        'message' => 'Success'
      ]);
    }
}
