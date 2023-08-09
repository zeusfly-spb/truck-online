<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(){
      $orders = Order::get();
      return $orders;
    }
    /**
     * @OA\Post(
     *     path="/api/orders",
     *     summary="Store Order",
     *     tags = {"Orders"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                  @OA\Property(
     *                     property="container_id",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                  @OA\Property(
     *                     property="company_id",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                @OA\Property(
     *                     property="from_address_id",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                @OA\Property(
     *                     property="from_date",
     *                     type="string",
     *                     example="2023-08-31"
     *                 ),
     *                @OA\Property(
     *                     property="from_slot",
     *                     type="string",
     *                     example="15:00"
     *                 ),
     *                @OA\Property(
     *                     property="from_contact_name",
     *                     type="string",
     *                     example="ConatctNAme"
     *                 ),
     *               @OA\Property(
     *                     property="from_contact_phone",
     *                     type="string",
     *                     example="COntactPhone"
     *                 ),
     *               @OA\Property(
     *                     property="from_contact_email",
     *                     type="string",
     *                     example="online@gmail.com"
     *                 ),
     *
     *
     *                @OA\Property(
     *                     property="delivery_adress_id",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                @OA\Property(
     *                     property="delivery_date",
     *                     type="string",
     *                     example="2023-08-31"
     *                 ),
     *                @OA\Property(
     *                     property="delivery_slot",
     *                     type="string",
     *                     example="15:00"
     *                 ),
     *                @OA\Property(
     *                     property="delivery_contact_name",
     *                     type="string",
     *                     example="ConatctNAme"
     *                 ),
     *               @OA\Property(
     *                     property="delivery_contact_phone",
     *                     type="string",
     *                     example="COntactPhone"
     *                 ),
     *               @OA\Property(
     *                     property="delivery_contact_email",
     *                     type="string",
     *                     example="online@gmail.com"
     *                 ),
     *
     *
     *                @OA\Property(
     *                     property="return_address_id",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                @OA\Property(
     *                     property="return_date",
     *                     type="string",
     *                     example="2023-08-31"
     *                 ),
     *                @OA\Property(
     *                     property="return_slot",
     *                     type="string",
     *                     example="15:00"
     *                 ),
     *                @OA\Property(
     *                     property="return_contact_name",
     *                     type="string",
     *                     example="ConatctNAme"
     *                 ),
     *               @OA\Property(
     *                     property="return_contact_phone",
     *                     type="string",
     *                     example="COntactPhone"
     *                 ),
     *               @OA\Property(
     *                     property="return_contact_email",
     *                     type="string",
     *                     example="online@gmail.com"
     *                 ),
     *
     *               @OA\Property(
     *                     property="car_id",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                @OA\Property(
     *                     property="price",
     *                     type="string",
     *                     example="10000"
     *                 ),
     *               @OA\Property(
     *                     property="weight",
     *                     type="string",
     *                     example="20000"
     *                 ),
     *               @OA\Property(
     *                     property="length_algo",
     *                     type="integer",
     *                     example="20000"
     *                 ),
     *               @OA\Property(
     *                     property="length_real",
     *                     type="integer",
     *                     example="20000"
     *                 ),
     *                @OA\Property(
     *                     property="imo",
     *                     type="boolean",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="temp_reg",
     *                     type="boolean",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="is_international",
     *                     type="boolean",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="tax_id",
     *                     type="integer",
     *                     example="1"
     *                 ),
     *                @OA\Property(
     *                     property="description",
     *                     type="string",
     *                     example="description"
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
    public function store(Request $request){

      $data = $request['data'];
      $order = $this->order_create($data);
      if($order) return response()->json([ 'success'=> true ], 201);

    }
    public function order_create($data){

      $order = new Order;
      $order['from_address_id'] = $data['from_address_id'];
      $order['from_date'] = $data['from_date'];
      $order['from_slot'] = $data['from_slot'];
      $order['from_contact_name'] = $data['from_contact_name'];
      $order['from_contact_phone'] = $data['from_contact_phone'];
      $order['from_contact_email'] = $data['from_contact_email'];

      $order['delivery_address_id'] = $data['delivery_address_id'];
      $order['delivery_contact_name'] = $data['delivery_contact_name'];
      $order['delivery_contact_phone'] = $data['delivery_contact_phone'];
      $order['delivery_contact_email'] = $data['delivery_contact_email'];
      $order['delivery_date'] = $data['delivery_date'];
      $order['delivery_slot'] = $data['delivery_slot'];

      $order['return_address_id'] = $data['return_address_id'];
      $order['return_contact_name'] = $data['return_contact_name'];
      $order['return_contact_phone'] = $data['return_contact_phone'];
      $order['return_contact_email'] = $data['return_contact_email'];
      $order['return_date'] = $data['return_date'];
      $order['return_slot'] = $data['return_slot'];

      $order['container_id'] = $data['container_id'];
      $order['length_algo'] = $data['length_algo'];
      $order['length_real'] = $data['length_real'];
      $order['price'] = $data['price'];
      $order['weight'] = $data['weight'];

      // if($data['imo']) $order['imo'] = true; else $order['imo'] = false;
      // if($data['is_international']) $order['is_international'] = true; else $order['is_international'] = false;
      // if($data['temp_reg']) $order['temp_reg'] = true; else $order['temp_reg'] = false;

      $order['description'] = $data['description'];
      $order->save();
    }
}
