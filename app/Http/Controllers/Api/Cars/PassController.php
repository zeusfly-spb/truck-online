<?php

namespace App\Http\Controllers\Api\Cars;

use App\Http\Resources\Api\Cars\PassResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pass;


class PassController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/car/pass/types",
     *     summary="Get list of car pass types",
     *     tags = {"Car Passes"},
     *     @OA\Response(
     *         response=200,
     *         description="SUCCESS",
     *     ),
     * )
    */
    public function index()
    {
        try{
            $companies = Pass::orderBy('created_at', 'desc')->get();
            return PassResource::collection($companies);
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
    *     path="/api/car/pass/types",
    *     summary="Store Pass",
    *     tags = {"Car Passes"},
    *      @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="name",
    *                     type="string",
    *                     example="МКАД"
    *                 ),
    *                 @OA\Property(
    *                     property="number",
    *                     type="string",
    *                     example="S123"
    *                 ),
    *                 @OA\Property(
    *                     property="date",
    *                     type="string",
    *                     example="2023-08-10"
    *                 ),
    *             )
    *         )
    *     ),
    *      @OA\Parameter(
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
    * )
    */
    public function store(Request $request)
    {
        try{
          $pass = new Pass;
          $pass->number = $request->number;
          $pass->date = $request->date;
          $pass->setTranslation('name', 'ru', $request->name)->save();
          return PassResource::make($pass);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(Pass $pass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pass $pass)
    {
        //
    }


    /**
    * @OA\Put(
    *      path="/api/car/pass/types/{id}",
    *      operationId="Update Pass",
    *      tags={"Car Passes"},
    *      summary="Update Pass",
    *      description="Update Pass",
    *      @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="name",
    *                     type="string",
    *                     example="МКАД"
    *                 ),
    *                 @OA\Property(
    *                     property="number",
    *                     type="string",
    *                     example="S123"
    *                 ),
    *                 @OA\Property(
    *                     property="date",
    *                     type="string",
    *                     example="2023-08-10"
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
          $pass = Pass::find($id);
          $pass->update($request->all());
          return PassResource::make($pass);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
    * @OA\Delete(
    *      path="/api/car/pass/types/{id}",
    *      operationId="Delete pass",
    *      tags={"Car Passes"},
    *      summary="Summary",
    *      description="Cars",
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
    public function destroy(Pass $pass)
    {
        try{
            $pass->delete();
            return response()->json([ 'success' => true ]);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
