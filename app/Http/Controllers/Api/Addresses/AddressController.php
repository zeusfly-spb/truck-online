<?php

namespace App\Http\Controllers\Api\Addresses;

use App\Http\Resources\Api\Addresses\AddressResource;
use MatanYadaev\EloquentSpatial\Objects\Point;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
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
    public function index()
    {
        try{
            $addresses = Address::orderBy('created_at', 'desc')->get();
            return AddressResource::collection($addresses);
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
            $address->address_type_id = $request->address_type_id;
            $address->location = new Point($request->latitude, $request->longitude);
            $address->setTranslation('name', 'ru', $request->name)->save();
            return AddressResource::make($address);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
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
            return AddressResource::make($address);
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
          $address->address_type_id = $request->address_type_id;
          $address->location = new Point($request->latitude, $request->longitude);
          $address->setTranslation('name', 'ru', $request->name)->save();
          return AddressResource::make($address);
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
