<?php

namespace App\Http\Controllers\Api\Addresses;

use App\Http\Controllers\BaseController;
use App\Http\Resources\Api\Addresses\AddressResource;
use App\Models\Address;
use Auth;
use Illuminate\Http\Request;
use MatanYadaev\EloquentSpatial\Objects\Point;

class AddressController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/api/addresses",
     *     summary="Get list of Addresses",
     *     tags = {"Addresses"},
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
    /**
     * Admin Address Get
     */
    public function index()
    {
        try{
            return response()->json(AddressResource::collection(Address::all()));
        }catch(\Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/address/client",
     *     summary="Get list accepted addresses",
     *     tags = {"Addresses"},
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
    public function addressCLient(Request $request){
      try{

        $addresses = Address::query()->where('accept_status', true);
        if($request->has('name'))
          $addresses = $addresses->filterByName($request->name);

        if($request->has('address'))
          $addresses = $addresses->filterByAddress($request->address);

          return response()->json(AddressResource::collection($addresses->get())->collection);
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
     *     path="/api/addresses",
     *     summary="Store Addresses",
     *     tags = {"Addresses"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *              @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="Rossi Boutique Hotel & SPA"
     *              ),
     *              @OA\Property(
     *                     property="address",
     *                     type="string",
     *                     example="Rossi Boutique Hotel & SPA"
     *              ),
     *              @OA\Property(
     *                     property="latitude",
     *                     type="string",
     *                     example="59.9310551"
     *               ),
     *              @OA\Property(
     *                     property="longitude",
     *                     type="string",
     *                     example="30.3338147"
     *               ),
     *              @OA\Property(
     *                     property="to",
     *                     type="string",
     *                     example="true"
     *               ),
     *               @OA\Property(
     *                     property="from",
     *                     type="string",
     *                     example="true"
     *               ),
     *               @OA\Property(
     *                     property="return",
     *                     type="string",
     *                     example="true"
     *               ),
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

            $address = new Address;
            $address->location = new Point($request->latitude, $request->longitude);
            $address->accept_status = false;
            if($request->has('to') && $request->to) {
              $address->to = true;
              $address->accept_status = true;
            }else {
              $address->to = false;
            }
            if($request->has('from') && $request->from) $address->from = true; else $address->from = false;
            if($request->has('return') && $request->return) $address->return = true; else $address->return = false;
            $address->name = $request->name;
            $address->address = $request->address;
            if(!Auth::user()->hasRole('super-admin')){
              $address->user_id = Auth::user()->id;
            }
            $address->save();
            return $this->sendResponse($address,'Success');

        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/address/accept/{id}",
     *     summary="Accept Addresses",
     *     security={{"bearer_token": {}}},
     *     tags = {"Addresses"},
     *     @OA\Parameter(
     *          description="ID",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Examples(example="int", value="1", summary="an int value"),
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
     * )
     */
    public function accept(Request $request, $id){


      $address = Address::find($id);
      $address->accept_status = $request->status;
      $address->save();
      return $this->sendResponse($address,'Success');
    }

    /**
      * @OA\Get(
      *      path="/api/addresses/{id}",
      *      summary="Show Address",
      *      tags={"Addresses"},
      *      description="Show Address",
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
    public function show(Address $address)
    {
        try{
            return response()->json(AddressResource::make($address));
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Address $address)
    {
        //
    }

    /**
      * @OA\Put(
      *      path="/api/addresses/{id}",
      *      operationId="Update Address",
      *      tags={"Addresses"},
      *      security={{"bearer_token": {}}},
      *      summary="Update Address",
      *      description="Update Address",
      *      @OA\RequestBody(
      *         @OA\MediaType(
      *             mediaType="application/json",
      *             @OA\Schema(
      *                 @OA\Property(
      *                     property="name",
      *                     type="string",
      *                     example="Rossi Boutique Hotel & SPA"
      *                 ),
      *              @OA\Property(
      *                     property="latitude",
      *                     type="string",
      *                     example="59.9310551"
      *               ),
      *              @OA\Property(
      *                     property="longitude",
      *                     type="string",
      *                     example="30.3338147"
      *               ),
      *              @OA\Property(
      *                     property="address_type_id",
      *                     type="integer",
      *                     example="1"
      *               ),
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
          $address = Address::find($id);

          $accept_accept = false;
          if(Auth::user()->hasRole('super-admin')) $accept_accept = true;
          else $request->user_id = Auth::user()->id;

          if($request->has('to') && $request->to) {
            $request->to = true;
            $accept_accept = true;
          }else $request->to = false;

          $address->update($request->all());
          return $this->sendResponse(AddressResource::make($address),'Success');

        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
    * @OA\Delete(
    *      path="/api/addresses/{id}",
    *      operationId="Delete Address",
    *      tags={"Addresses"},
    *      summary="Summary",
    *      description="Addresses",
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
    public function destroy(Address $address)
    {
        try{
            $address->delete();
            return response()->json(['success' => true ]);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
