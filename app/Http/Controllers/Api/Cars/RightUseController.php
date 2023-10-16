<?php

namespace App\Http\Controllers\Api\Cars;

use App\Http\Resources\Api\Cars\RightUseResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RightUse;

class RightUseController extends Controller
{
  /**
   * @OA\Get(
   *     path="/api/car/right-uses",
   *     summary="Get list of right use",
   *     tags = {"Car Right Uses"},
   *     @OA\Response(
   *         response=200,
   *         description="SUCCESS",
   *     ),
   * )
   */
  public function index()
  {
    try {
      $rightUses = RightUse::orderBy('created_at', 'desc')->get();
      return response()->json(RightUseResource::collection($rightUses)->collection);
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
   *     path="/api/car/right-uses",
   *     summary="Store right use",
   *     tags = {"Car Right Uses"},
   *      @OA\RequestBody(
   *         @OA\MediaType(
   *             mediaType="application/json",
   *             @OA\Schema(
   *                 @OA\Property(
   *                     property="name",
   *                     type="string",
   *                     example="Собственность"
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
      $rightUse = new RightUse;
      $rightUse->setTranslation('name', 'ru', $request->name)->save();
      return response()->json(RightUseResource::make($rightUse));
    } catch (\Exception $exception) {
      return response()->json(['error' => $exception->getMessage()], 500);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(RightUse $rightUse)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(RightUse $rightUse)
  {
    //
  }

  /**
   * @OA\Put(
   *      path="/api/car/right-uses/{id}",
   *      operationId="Update right use",
   *      tags={"Car Right Uses"},
   *      summary="Update right use",
   *      description="Update right use",
   *      @OA\RequestBody(
   *         @OA\MediaType(
   *             mediaType="application/json",
   *             @OA\Schema(
   *                 @OA\Property(
   *                     property="name",
   *                     type="string",
   *                     example="Собственность"
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
      $rightUse = RightUse::find($id);
      $rightUse->update($request->all());
      return response()->json(RightUseResource::make($rightUse));
    } catch (\Exception $exception) {
      return response()->json(['error' => $exception->getMessage()], 500);
    }
  }

  /**
   * @OA\Delete(
   *      path="/api/car/pass/right-uses/{id}",
   *      operationId="Delete right use",
   *      tags={"Car Right Uses"},
   *      summary="Summary",
   *      description="Delete ight use",
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
  public function destroy(RightUse $rightUse)
  {
    try {
      $rightUse->delete();
      return response()->json(['success' => true]);
    } catch (\Exception $exception) {
      return response()->json(['error' => $exception->getMessage()], 500);
    }
  }
}
