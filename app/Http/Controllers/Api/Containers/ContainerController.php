<?php

namespace App\Http\Controllers\Api\Containers;

use App\Http\Resources\Api\Containers\ContainerResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Container;
use Exception;

class ContainerController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/containers",
     *     summary="Get list of containers",
     *     tags = {"Containers"},
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
            $containers = Container::orderBy('created_at', 'desc')->get();
            return ContainerResource::collection($containers);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

    }
    /**
     * @OA\Post(
     *     path="/api/containers",
     *     summary="Store Container",
     *     tags = {"Containers"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                     example="ContainerNameTest"
     *                 ),
     *                 @OA\Property(
     *                     property="weight",
     *                     type="string",
     *                     example="10 тонн"
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
            $container = new Container;
            $container->weight = $request->weight;
            $container->setTranslation('name', 'ru', $request->name)->save();
            return ContainerResource::make($container);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
    * @OA\Get(
    *      path="/api/containers/{id}",
    *      summary="Show Container",
    *      tags={"Containers"},
    *      description="Show Container",
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
    public function show(Container $container)
    {
        try{
            return ContainerResource::make($container);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    public function edit(Container $container)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    /**
    * @OA\Put(
    *      path="/api/containers/{id}",
    *      operationId="Update Containers",
    *      tags={"Containers"},
    *      summary="Update Containers",
    *      description="Update Containers",
    *      @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="name",
    *                     type="string",
    *                     example="ContainerNameTestUpdate"
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
    public function update(Request $request, Container $container)
    {
        try{
            $input = $request->all();
            $container->fill($input)->save();
            return ContainerResource::make($container);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
    * @OA\Delete(
    *      path="/api/containers/{id}",
    *      operationId="Delete container",
    *      tags={"Containers"},
    *      summary="Summary",
    *      description="Containers",
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
    public function destroy(Container $container)
    {
        try{
            $container->delete();
            return response()->json([ 'success' => true ]);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
