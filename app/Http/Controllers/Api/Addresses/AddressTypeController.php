<?php

namespace App\Http\Controllers\Api\Addresses;

use App\Http\Resources\Api\Addresses\AddressTypeResource;
use App\Http\Controllers\Controller;
use App\Models\AddressType;
use Illuminate\Http\Request;
use Exception;

class AddressTypeController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/address-types",
     *     summary="Get list of Address Types",
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
            $addressTypes = AddressType::orderBy('created_at', 'desc')->get();
            return AddressTypeResource::collection($addressTypes);
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
     *     path="/api/address-types",
     *     summary="Store Address Type",
     *     tags = {"Addresses"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="AddressType1"
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
            $addressType = new AddressType;
            $addressType->setTranslation('name', 'ru', $request->name)->save();
            return AddressTypeResource::make($addressType);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
    * @OA\Get(
    *      path="/api/address-types/{id}",
    *      summary="Show Address Type",
    *      tags={"Addresses"},
    *      description="Show Address Type",
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
    public function show(AddressType $addressType)
    {
        try{
            return AddressTypeResource::make($addressType);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }

    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AddressType $addressType)
    {
        //
    }

     /**
    * @OA\Put(
    *      path="/api/address-types/{id}",
    *      operationId="Update Address Type",
    *      tags={"Addresses"},
    *      summary="Update Address Type",
    *      description="Update Address Type",
    *      @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="name",
    *                     type="string",
    *                     example="AddressTypeTest"
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
            $addressType = AddressType::find($id);
            $addressType->update($request->all());
            return AddressTypeResource::make($addressType);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
    * @OA\Delete(
    *      path="/api/address-types/{id}",
    *      operationId="Delete Address Type",
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
    public function destroy(AddressType $addressType)
    {
        try{
            $addressType->delete();
            return response()->json(['success' => true ]);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
