<?php

namespace App\Http\Controllers\Api\Countries;

use App\Http\Resources\Api\Countries\CountryResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Exception;

class CountryController extends Controller
{
  /**
   * @OA\Get(
   *     path="/api/countries",
   *     summary="Get list of Countries",
   *     tags = {"Countries"},
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
    try {
      $taxes = Country::orderBy('created_at', 'desc')->get();
      return response()->json(CountryResource::collection($taxes)->collection);
    } catch (Exception $exception) {
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
   *     path="/api/countries",
   *     summary="Store Counntry",
   *     tags = {"Countries"},
   *      @OA\RequestBody(
   *         @OA\MediaType(
   *             mediaType="application/json",
   *             @OA\Schema(
   *                 @OA\Property(
   *                     property="name",
   *                     type="string",
   *                     example="РФ"
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
    try {
      $country = new Country;
      $country->setTranslation('name', 'ru', $request->name)->save();
      return response()->json(CountryResource::make($country));
    } catch (Exception $exception) {
      return response()->json(['error' => $exception->getMessage()], 500);
    }
  }

  /**
   * Display the specified resource.
   */
  public function show(Country $country)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Country $country)
  {
    //
  }

  /**
   * @OA\Put(
   *      path="/api/countries/{id}",
   *      operationId="Update Country",
   *      tags={"Countries"},
   *      summary="Update Country",
   *      description="Update Country",
   *      @OA\RequestBody(
   *         @OA\MediaType(
   *             mediaType="application/json",
   *             @OA\Schema(
   *                 @OA\Property(
   *                     property="name",
   *                     type="string",
   *                     example="UpdateCountry"
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
      $country = Country::find($id);
      $country->update($request->all());
      return response()->json(CountryResource::make($country));
    } catch (Exception $exception) {
      return response()->json(['error' => $exception->getMessage()], 500);
    }
  }


  /**
   * @OA\Delete(
   *      path="/api/countries/{id}",
   *      operationId="Delete Country",
   *      tags={"Countries"},
   *      summary="Country delete",
   *      description="Country delete",
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
  public function destroy(Country $country)
  {
    try {
      $country->delete();
      return response()->json(['success' => true]);
    } catch (Exception $exception) {
      return response()->json(['error' => $exception->getMessage()], 500);
    }
  }
}
