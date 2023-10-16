<?php

namespace App\Http\Controllers\Api\Cars;

use App\Http\Resources\Api\Cars\CarTypeResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarType;

class CarTypeController extends Controller
{
  /**
   * @OA\Get(
   *     path="/api/car/types",
   *     summary="Get list of car types",
   *     tags = {"Car Types"},
   *     @OA\Response(
   *         response=200,
   *         description="SUCCESS",
   *     ),
   * )
   */
  public function index()
  {
    try {
      $companies = CarType::orderBy('created_at', 'desc')->get();
      return response()->json(CarTypeResource::collection($companies)->collection);
    } catch (\Exception $exception) {
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
   *     path="/api/car/types",
   *     summary="Store Company",
   *     tags = {"Car Types"},
   *      @OA\RequestBody(
   *         @OA\MediaType(
   *             mediaType="application/json",
   *             @OA\Schema(
   *                 @OA\Property(
   *                     property="name",
   *                     type="string",
   *                     example="Прицеп"
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
    try {
      $data = $request->all();
      $carType = CarType::create($data);
      return response()->json(CarTypeResource::make($carType));
    } catch (\Exception $exception) {
      return response()->json(['error' => $exception->getMessage()], 500);
    }
  }

  /**
   * @OA\Get(
   *      path="/api/car/types/{id}",
   *      summary="Show Car Type",
   *      tags={"Car Types"},
   *      description="Show Car Type",
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
  public function show($id)
  {
    try {
      return response()->json(CarTypeResource::make(CarType::find($id)));
    } catch (\Exception $exception) {
      return response()->json(['error' => $exception->getMessage()], 500);
    }
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(CarType $carType)
  {
    //
  }
  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\CarType  $province
   * @return \Illuminate\Http\Response
   */
  /**
   * Update the specified resource in storage.
   */
  /**
   * @OA\Put(
   *      path="/api/car/types/{id}",
   *      operationId="Update Car Type",
   *      tags={"Car Types"},
   *      summary="Update Car Type",
   *      description="Update Car Type",
   *      @OA\RequestBody(
   *         @OA\MediaType(
   *             mediaType="application/json",
   *             @OA\Schema(
   *                 @OA\Property(
   *                     property="name",
   *                     type="string",
   *                     example="CarTypeUpdate"
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
    try {
      $carType = CarType::find($id);
      $carType->update($request->all());
      return response()->json(CarTypeResource::make($carType));
    } catch (\Exception $exception) {
      return response()->json(['error' => $exception->getMessage()], 500);
    }
  }

  /**
   * @OA\Delete(
   *      path="/api/car/types/{id}",
   *      operationId="Delete car type",
   *      tags={"Car Types"},
   *      summary="Summary",
   *      description="Delete Car Type",
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
  public function destroy(CarType $carType)
  {
    try {
      $carType->delete();
      return response()->json(['success' => true]);
    } catch (\Exception $exception) {
      return response()->json(['error' => $exception->getMessage()], 500);
    }
  }
}
