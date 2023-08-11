<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Resources\Api\Orders\OrderStatusResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderStatus;
use Exception;


class OrderStatusController extends Controller
{
     /**
     * @OA\Get(
     *     path="/api/order-statuses",
     *     summary="Get list of Order Statuses",
     *     tags = {"Orders"},
     *     @OA\Parameter(
     *         description="Localization",
     *         in="header",
     *         name="X-Localization",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="ru", value="ru", summary="Russian")
     *    ),
     *     @OA\Response(
     *         response=200,
     *         description="SUCCESS",
     *     ),
     * )
    */
    public function index()
    {
        try{
            $orderStatuses = OrderStatus::orderBy('created_at', 'desc')->get();
            return OrderStatusResource::collection($orderStatuses);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *     path="/api/order-statuses",
     *     summary="Store Order Status",
     *     tags = {"Orders"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="OrderStatusNameTest"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="Localization",
     *         in="header",
     *         name="X-Localization",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="ru", value="ru", summary="Russian")
     *    ),
     *     @OA\Response(
     *         response=200,
     *         description="SUCCESS",
     *     ),
     * )
     */
    public function store(Request $request)
    {
        try{
            $orderStatus = new OrderStatus;
            $orderStatus->setTranslation('name', 'ru', $request->name)->save();
            return OrderStatusResource::make($orderStatus);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
    * @OA\Get(
    *      path="/api/order-statuses/{id}",
    *      summary="Show Order Status",
    *      tags={"Orders"},
    *      description="Show Order Status",
    *      @OA\Parameter(
    *      name="id",
    *      in="path",
    *      required=true,
    *      @OA\Schema(
    *           type="integer",
    *           example="1"
    *         )
    *      ),
    *     @OA\Parameter(
     *         description="Localization",
     *         in="header",
     *         name="X-Localization",
     *         required=false,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="ru", value="ru", summary="Russian")
     *    ),
    *     @OA\Response(
    *         response=200,
    *         description="SUCCESS",
    *     ),
    *     )
    */
    public function show(OrderStatus $orderStatus)
    {
        try{
            return OrderStatusResource::make($orderStatus);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }

    }

    public function edit(OrderStatus $orderStatus)
    {

    }

    /**
    * @OA\Put(
    *      path="/api/order-statuses/{id}",
    *      operationId="Update Order Status",
    *      tags={"Orders"},
    *      summary="Update Order Status",
    *      description="Update Order Status",
    *      @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="name",
    *                     type="string",
    *                     example="OrderStatusNameTest"
    *                 ),
    *             )
    *         )
    *     ),
    *     @OA\Parameter(
    *         in="path",
    *         name="id",
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
    public function update(Request $request, $id)
    {
        try{
            $orderStatus = OrderStatus::find($id);
            $orderStatus->update($request->all());
            return OrderStatusResource::make($orderStatus);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
    * @OA\Delete(
    *      path="/api/order-statuses/{id}",
    *      operationId="Delete Order Status",
    *      tags={"Orders"},
    *      summary="Summary",
    *      description="Orders",
    *      @OA\Parameter(
    *      name="id",
    *      in="path",
    *      required=true,
    *      @OA\Schema(
    *           type="integer",
    *           example="1"
    *         )
    *      ),
    *      @OA\Response(
    *          response=200,
    *          description="SUCCESS",
    *       ),
    *     )
    */
    public function destroy(OrderStatus $orderStatus)
    {
        try{
            $orderStatus->delete();
            return response()->json([ 'success' => true ]);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
