<?php

namespace App\Http\Controllers\Api\Orders;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Charge;
use App\Models\User;
use App\Models\Tax;
use App\Models\OrderStatus;
use App\Models\OrderAction;
use App\Models\CaclHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Resources\Api\Orders\OrderResource;
use App\Http\Resources\Api\CalcHistories\CalcHistoryResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Validator;
use App\Models\Address;
use App\Models\Container;
use App\Models\OrderSetting;
use App\Models\CalcHistory;

class OrderController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/orders",
     *     summary="Get list of Orders",
     *     security={{"bearer_token": {}}},
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
     *         @OA\JsonContent()
     *     ),
     * )
    */
    public function index(Request $request){
      //$orders = Auth::user()->orders;
      $orders = Order::query();

      if($request->has('order_statuses'))
        $orders = $orders->filterByOrderStatuses(json_decode($request->order_statuses));

      if($request->has('containers'))
        $orders = $orders->filterByOrderContainers(json_decode($request->containers));

      if($request->has('from_addresses'))
        $orders = $orders->filterByOrderFromAddresses(json_decode($request->from_addresses));

      if($request->has('delivery_addresses'))
        $orders = $orders->filterByOrderDeliveryAddresses(json_decode($request->delivery_addresses));

      if($request->has('companies'))
        $orders = $orders->filterByOrderCompanies(json_decode($request->companies));

      if($request->has('weight'))
        $orders = $orders->filterByWeight($request->weight);

      if($request->has('price'))
        $orders = $orders->filterByPrice($request->price);

      if($request->has('length_algo'))
        $orders = $orders->filterByLengthAlgo($request->length_algo);

      if($request->has('length_real'))
        $orders = $orders->filterByLengthReal($request->length_real);

      if($request->has('imo') && $request->imo){
        $orders = $orders->filterByImo(true);
      }
      if($request->has('temp_reg') && $request->temp_reg)
        $orders = $orders->filterByTemp(true);

      if($request->has('is_international') && $request->is_international)
        $orders = $orders->filterByInternational(true);

      if($request->has('fromDate'))
        $orders = $orders->filterByFromDate($request->fromDate);

      if($request->has('deliveryDate'))
        $orders = $orders->filterByDeliverydate($request->deliveryDate);

      //$orders = $orders->paginate(12);
      return response()->json(OrderResource::collection($orders->get())->collection);
      //return OrderResource::collection($orders)->collection;
    }
    /**
     * @OA\Post(
     *     path="/api/orders/store",
     *     summary="Store Order",
     *     tags = {"Orders"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="container_id",
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
     *                @OA\Property(
     *                     property="delivery_address_id",
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
     *                     example="ContactPhone"
     *                 ),
     *               @OA\Property(
     *                     property="delivery_contact_email",
     *                     type="string",
     *                     example="online@gmail.com"
     *                 ),
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
     *    ),
     * )
     */
    public function store(Request $request){

      $data = $request['data'];
      if(intval($data['calc'])){
        $calc_history = $this->calcHistoryCreate($data);
        if($calc_history) return response()->json(new CalcHistoryResource($calc_history));
      }else{
        if(Auth::guard('api')->user()){
          $order = $this->order_create($data);
          if($order) return response()->json(new OrderResource($order));
        }else{
          return response()->json(['message'=> "Unauthorized" ], 401);
        }
      }
    }
    public function createOrderByCalcHistoryId($id){

      $calcHistory = CalcHistory::find($id);

      $order = Order::create([
        'user_id' => Auth::user()->id,
        'company_id' => Auth::user()->company_id,
        'from_address_id' => $calcHistory->from_address_id,
        'delivery_address_id' => $calcHistory->delivery_address_id,
        'return_address_id' => $calcHistory->return_address_id,
        'container_id' => $calcHistory->container_id,
        'price' => $calcHistory->price,
        'distance' => $calcHistory->distance,
        'weight' => $calcHistory->weight,
        'tax_id' => $calcHistory->tax_id,
        'imo' => $calcHistory->imo,
        'is_international' => $calcHistory->is_international,
        'temp_reg' => $calcHistory->temp_reg,
        'length_algo' => $calcHistory->distance,
        'order_status' => OrderStatus::DRAFT,
      ]);
      if($order) return response()->json(OrderResource::make($order));
    }
    public function order_create($data){

      $priceAndDistace = $this->getPriceAndWeight($data);

      $order = Order::create([
        'user_id' => Auth::guard('api')->user()->id,
        'company_id' => Auth::guard('api')->user()->company_id,
        'tax_id' => $data['tax_id'],
        'from_address_id' => $data['from_address_id'] ?? null,
        'from_date' => $data['from_date'] ?? null,
        'from_slot' => $data['from_slot'] ?? null,
        'from_contact_name' => $data['from_contact_name'] ?? null,
        'from_contact_phone' => $data['from_contact_phone'] ?? null,
        'from_contact_email' => $data['from_contact_email'] ?? null,
        'delivery_address_id' => $data['delivery_address_id'] ?? null,
        'delivery_contact_name' => $data['delivery_contact_name'] ?? null,
        'delivery_contact_phone' => $data['delivery_contact_phone'] ?? null,
        'delivery_contact_email' => $data['delivery_contact_email'] ?? null,
        'delivery_date' => $data['delivery_date'] ?? null,
        'delivery_slot' => $data['delivery_slot'] ?? null,
        'return_address_id' => $data['return_address_id'] ?? null,
        'return_contact_name' => $data['return_contact_name'] ?? null,
        'return_contact_phone' => $data['return_contact_phone'] ?? null,
        'return_contact_email' => $data['return_contact_email'] ?? null,
        'return_date' => $data['return_date'] ?? null,
        'return_slot' => $data['return_slot'] ?? null,
        'delivery2_address_id' => $data['delivery2_address_id'] ?? null,
        'delivery2_contact_name' => $data['delivery2_contact_name'] ?? null,
        'delivery2_contact_phone' => $data['delivery2_contact_phone'] ?? null,
        'delivery2_contact_email' => $data['delivery2_contact_email'] ?? null,
        'delivery2_date' => $data['delivery2_date'] ?? null,
        'delivery2_slot' => $data['delivery2_slot'] ?? null,
        'return2_address_id' => $data['return2_address_id'] ?? null,
        'return2_contact_name' => $data['return2_contact_name'] ?? null,
        'return2_contact_phone' => $data['return2_contact_phone'] ?? null,
        'return2_contact_email' => $data['return2_contact_email'] ?? null,
        'return2_date' => $data['return2_date'] ?? null,
        'return2_slot' => $data['return2_slot'] ?? null,
        'container_id' => $data['container_id'] ?? null,
        'length_algo' => $priceAndDistace['distance'] ?? null,
        'length_real' => $data['length_real'] ?? null,
        'price' => $priceAndDistace['price'] ?? null,
        'weight' => $data['weight'] ?? null,
        'order_status' => OrderStatus::DRAFT,
        'description' => $data['description'] ?? null,
        'imo' => $data['imo'],
        'is_international' =>$data['is_international'],
        'temp_reg' => $data['temp_reg']
      ]);
      return $order;
    }
    public function calcHistoryCreate($data){

      $priceAndDistace = $this->getPriceAndWeight($data);

      $calc_history = CalcHistory::firstOrCreate([
          'user_id' => Auth::guard('api')->user() ? Auth::guard('api')->user()->id : null,
          'from_address_id' => $data['from_address_id'],
          'delivery_address_id' => $data['delivery_address_id'],
          'return_address_id' => $data['return_address_id'],
          'container_id' => $data['container_id'],
          'price' => $priceAndDistace['price'],
          'distance' => $priceAndDistace['distance'],
          'weight' => $data['weight'],
          'tax_id' => $data['tax_id'],
          'imo' => $data['imo'],
          'is_international' => $data['is_international'],
          'temp_reg' => $data['temp_reg'],
      ]);
      $calc_history->updated_at = \Carbon\Carbon::now();
      $calc_history->save();
      return $calc_history;
    }
    public function getPriceAndWeight($data){
      $points = array();
      //from
      if(array_key_exists('from_address_id', $data)){
        $fromAddress = Address::find($data['from_address_id']);
        $fromAddressPoints['lat'] = $fromAddress?->location?->latitude;
        $fromAddressPoints['lon'] = $fromAddress?->location?->longitude;
        $fromAddressPoints['type'] = "stop";
        array_push($points, $fromAddressPoints);
      }
      //to
      if(array_key_exists('delivery_address_id', $data)){
         $deliveryAddress = Address::find($data['delivery_address_id']);
         $deliveryAddressPoints['lat'] = $deliveryAddress?->location?->latitude;
         $deliveryAddressPoints['lon'] = $deliveryAddress?->location?->longitude;
         $deliveryAddressPoints['type'] = "stop";
         array_push($points, $deliveryAddressPoints);
      }
      //return
      if(array_key_exists('return_address_id',$data)){
        $returnAddress = Address::find($data['return_address_id']);
        $returnAddressPoints['lat'] = $returnAddress?->location?->latitude;
        $returnAddressPoints['lon'] = $returnAddress?->location?->longitude;
        $returnAddressPoints['type'] = "stop";
        array_push($points, $returnAddressPoints);
      }
      //delivery 2
      if(array_key_exists('delivery2_address_id', $data)){
        $delivery2Address = Address::find($data['delivery2_address_id']);
        $delivery2AddressPoints['lat'] = $delivery2Address?->location?->latitude;
        $delivery2AddressPoints['lon'] = $delivery2Address?->location?->longitude;
        $delivery2AddressPoints['type'] = "stop";
        array_push($points, $delivery2AddressPoints);
      }
      //return 2
      if(array_key_exists('return2_address_id',$data)){
        $return2Address = Address::find($data['return2_address_id']);
        $return2AddressPoints['lat'] = $return2Address?->location?->latitude;
        $return2AddressPoints['lon'] = $return2Address?->location?->longitude;
        $return2AddressPoints['type'] = "stop";
        array_push($points, $return2AddressPoints);
      }

      $orderSetting = OrderSetting::first();
      $fullDistanceLength = 0;
      $overWeightSum = 0;
      $defaultCarPrice = OrderSetting::first()['default_car_price'];

      for($i=0; $i<count($points)-1; $i++){
        $requestData['points'] = [$points[$i], $points[$i+1]];
        $fullDistanceLength +=100;
        //$fullDistanceLength += $this->getDistance($requestData['points']); //uncomment this line of code when Routing api key will start wirk
      }
      $overWeightSum = $this->getOverWeight($data);
      $price = ($fullDistanceLength*$orderSetting?->default_distance) + $overWeightSum + $defaultCarPrice;

      return ["price" => $price, 'distance' => $fullDistanceLength];
    }
    private function getDistance($points){

      //$proxy = 'http://127.0.0.1:8888';
      try {
        $response = Http::timeout(30)
          //->withOptions([
                  //'proxy' => $proxy,'verify' => false])
          ->withHeaders([
                  'Accept' => 'application/json',])
          ->post('https://routing.api.2gis.com/routing/7.0.0/global?key=cb315652-4a77-4656-b55c-2485e210e675', [
                'points' => $points,
                'locale' => 'ru',
                'transport'  => 'truck',
                "route_mode"=> "fastest",
                "traffic_mode"=> "jam",
                "output" => 'summary'
            ]);
        if ($response->successful()){return $response->body();
          $body = json_decode($response->body());
          return $body?->result[0]?->length;
        }else return 0;
      } catch (RequestException $e) {
          // Handle the error after multiple retries
      }
    }
    private function getOverWeight($data){

      $overWeightSum = 0;
      $containerWeight = Container::find($data['container_id'])['weight'];
      if($containerWeight < $data['weight']){
        $overWeight = $data['weight'] - $containerWeight;
        $overWeightSum = $overWeight*OrderSetting::first()['default_over_weight_price'];
      }
      return $overWeightSum;
    }
    /**
      * @OA\Get(
      *      path="/api/orders/show/{order_id}",
      *      summary="Show Order with waiting actions",
      *      security={{"bearer_token": {}}},
      *      tags={"Orders"},
      *      description="Show Order with waiting actions",
      *     @OA\Parameter(
      *         in="path",
      *         name="order_id",
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
      *    ),
      *     @OA\Response(
      *         response=200,
      *         description="SUCCESS",
      *     ),
      *     )
    */
    public function show($orderId){

      $order = Order::find($orderId);
      $orderActions = [];
      foreach($order->actions->where('status', false) as $action){

        if(!OrderAction::where('order_action_id', $action->id)->exists()){
          array_push($orderActions, $action);
        }
      }
      $order['actions'] = $orderActions;
      return response()->json([
        'order' => OrderResource::make(Order::find($orderId)),
        'orderActions' => $orderActions
      ]);

    }

    /**
      * @OA\Post(
      *      path="/api/orders/update/{id}",
      *      operationId="Order can be updated by executer and by customer",
      *     security={{"bearer_token": {}}},
      *      tags={"Orders"},
      *      summary="Order can be updated by executer and by customer",
      *      description="Order can be updated by executer and by customer",
      *      @OA\RequestBody(
      *         @OA\MediaType(
      *             mediaType="application/json",
      *             @OA\Schema(
      *                 @OA\Property(
      *                     property="from_contact_name",
      *                     type="string",
      *                     example="from_contact_name"
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
    public function update(Request $request, $orderId){

      $order = Order::find($orderId);
      $status = $order->order_status;

      if(Auth::user()->hasRole('super-admin')){

        $order->fill($request->all());
        $changes = $order->getDirty();
        $this->orderActionCreate($changes, $order, 1, null);  //checked
        $order->update($request->all());

      }else{

        switch ($status) {
        case OrderStatus::DRAFT:
            return $this->handleDraftStatus($order, $request, $status);
            break;
        case OrderStatus::CREATED:
            return $this->handleCreatedStatus($order, $request, $status);
            break;
        case OrderStatus::SELECTED:
            return $this->handleSelectedStatus($order, $request, $status);
            break;
        default:
            // Handle unknown status
            break;
        }
      }

      return response()->json([
        'message' => 'Success'
      ]);
    }

    private function handleDraftStatus(Order $order, $request, $status)
    {
      if(Auth::user()->id == $order->user_id){
        if($request->has('order_status') && $request->order_status == OrderStatus::CREATED || $request->order_status == OrderStatus::CANCELED){
          $order->update($request->all());
        }else{
          $order->update($request->all());
        }
      }
    }

    private function handleCreatedStatus(Order $order, $request, $status)
    {
      //customer checked for if has order status and order status cancel or draft, another way not work update for customer
      if(Auth::user()->id == $order->user_id){
        if($request->has('order_status')){
          if($request->order_status == OrderStatus::CANCELED || $request->order_status == OrderStatus::DRAFT)
            $order->update($request->all());
        }else{
          $order->update($request->all());
        }
      }

      if(Auth::user()->hasRole('executer') && $request->order_status == OrderStatus::SELECTED){
        $order->order_status = OrderStatus::SELECTED;
        $order->executer_id = Auth::user()->id;
        $order->executer_company_id = Auth::user()->company_id;
        $changes = $order->getDirty();

        foreach($changes as $key => $change){
          $order_action = OrderAction::create([
            'order_id' => $order->id,
            'column_name' => $key,
            'old_value' => Order::find($order->id)[$key] ?? null,
            'update_value' => $change,
            'status' => 1, //accept
            'user_id' => Auth::user()->id,
          ]);
          $order_action->order_action_id = $order_action->id;
          $order_action->save();
        }
        $order->save();
      }
    }

    private function handleSelectedStatus(Order $order, $request, $status)
    {
      $permitted_day = Carbon::createFromFormat('Y-m-d H:i', $order->from_date.' 17:00')->subDay();
      $order->fill($request->all());
      $changes = $order->getDirty();

      if(!$permitted_day->greaterThan(Carbon::now()) && $request->order_status == OrderStatus::CANCELED){

        $this->orderActionCreate($changes, $order, 1, null);

        if(Auth::user()->id == $order->executer_id){
          $order->order_status = OrderStatus::CREATED;
          $order->save();
        }else{
          $order->order_status = OrderStatus::CANCELED;
          $order->save();
        }

        $from_company = Auth::user()->company_id;
        $to_company = Auth::user()->id == $order->user_id ? User::find($order->executer_id)['company_id'] : User::find($order->user_id)['company_id'];
        $fine_amount = $order->price/100*20;

        Charge::create([
          'company_from_id' => $from_company,
          'company_to_id' =>  $to_company,
          'order_id' => $order->id,
          'amount' => $fine_amount,
          'notified' => 0,  //update when do notification
          'fine' => true,
          'payed' => false
        ]);
        //return 'noPermission';
      }elseif($request->has('order_status') && $request->order_status == OrderStatus::EXECUTED){
        if(Auth::user()->id == $order->executer_id){
          $this->orderActionCreate($changes, $order, 1, null);
          $order->order_status = OrderStatus::EXECUTED;
          $order->save();

        }
      }else{
        $this->orderActionCreate($changes, $order, 0, null);  //checked
      }
    }

    private function orderActionCreate($changes, $order, $status, $order_action_id){

      foreach($changes as $key => $change){

        //if($this->checkForExistAcceptColumn($orderId, $key)==true){

          $order_action = OrderAction::create([
            'order_id' => $order->id,
            'column_name' => $key,
            'old_value' => Order::find($order->id)[$key],
            'update_value' => $change,
            'status' => $status, // 0 = waiting // 1 = accept // 2 = decline
            'user_id' => Auth::user()->id,  //id otpravitelya
          ]);
          $order_action->order_action_id = null;  //null if ApprovalPending // orderActionId if Accept the or Decline
          $order_action->save();
       // } //utachnit
      }
    }

    public function checkForExistAcceptColumn($orderId, $key){

      $orderAction = OrderAction::where('order_id', $orderId)->where('colum_name', $key)->where('status', 1)->get();
      if(count($orderAction)>0){
        return false;
      } return true;
    }
}
