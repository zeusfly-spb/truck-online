<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderAction;
use App\Http\Resources\Api\Orders\OrderActionResource;
use Auth;

class OrderActionController extends Controller
{
  /**
   * @OA\Post(
   *      path="/api/orders/accept/action/{action_id}",
   *      operationId="Order action accept if not action creater",
   *     security={{"bearer_token": {}}},
   *      tags={"Orders"},
   *      summary="Order action accept if not action creater",
   *      description="Order action accept if not action creater",
   *      @OA\RequestBody(
   *         @OA\MediaType(
   *             mediaType="application/json",
   *             @OA\Schema(
   *                 @OA\Property(
   *                     property="status",
   *                     type="integer",
   *                     example="1"
   *                 ),
   *             )
   *         )
   *     ),
   *     @OA\Parameter(
   *         in="path",
   *         name="action_id",
   *         required=true,
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
  public function accept(Request $request, $orderActionId)
  {

    $orderAction = OrderAction::find($orderActionId);
    if ($orderAction && $orderAction->user_id != Auth::user()->id) {
      $newOrderAction = $orderAction->replicate();
      $newOrderAction->status = $request->status; //accept=1 or decline=2
      $newOrderAction->order_action_id = $orderAction->id;
      $newOrderAction->save();

      if ($newOrderAction->status == 1) {
        Order::where('id', $newOrderAction->order_id)->update([
          $newOrderAction->column_name => $newOrderAction->update_value
        ]);
      }
      return response()->json([
        'message' => 'Success'
      ]);
    }
    return response()->json([
      'message' => 'noPermission'
    ]);
  }

  public function show($id)
  {

    $orderActions = OrderAction::where('order_id', $id)->get();
    return OrderActionResource::collection($orderActions);
  }
}
