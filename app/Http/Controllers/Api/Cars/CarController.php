<?php

namespace App\Http\Controllers\Api\Cars;

use App\Http\Resources\Api\Cars\CarResource;
use App\Http\Requests\CarRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CarPass;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;



class CarController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/cars",
     *     summary="Get list of Cars",
     *     tags = {"Cars"},
     *     security={{"bearer_token": {}}},
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
    public function index()
    {
        try{
            $cars = Car::orderBy('created_at', 'desc')->where('company_id', Auth::user()->company_id)->get();
            return response()->json(CarResource::collection($cars)->collection);
        }catch(\Exception $exception){
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
    *     path="/api/cars",
    *     summary="Store Cars",
    *     security={{"bearer_token": {}}},
    *     tags = {"Cars"},
    *      @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="number",
    *                     type="string",
    *                     example="1234"
    *                 ),
    *                 @OA\Property(
    *                     property="country_id",
    *                     type="string",
    *                     example="1"
    *                 ),
    *                 @OA\Property(
    *                     property="mark_model",
    *                     type="string",
    *                     example="Mercedes"
    *                 ),
    *                 @OA\Property(
    *                     property="car_type_id",
    *                     type="string",
    *                     example="1"
    *                 ),
    *                 @OA\Property(
    *                     property="sts",
    *                     type="string",
    *                     example="sts"
    *                 ),
    *                 @OA\Property(
    *                     property="right_use_id",
    *                     type="string",
    *                     example="1"
    *                 ),
    *                 @OA\Property(
    *                     property="max_weigth",
    *                     type="string",
    *                     example="1000"
    *                 ),
    *                 @OA\Property(
    *                     property="sts_file_1",
    *                     type="string",
    *                     example="File"
    *                 ),
    *                 @OA\Property(
    *                     property="sts_file_2",
    *                     type="string",
    *                     example="File"
    *                 ),
    *                 @OA\Property(
    *                     property="icon",
    *                     type="string",
    *                     example="File"
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
    public function store(CarRequest $request)
    {
      try{

        $icon = null;
        $sts_file_1 = null;
        $sts_file_2 = null;

        if ($request->hasFile('icon')){
            $path = "uploads/car/images";
            $originalName = time().'_'.$request->file('icon')->getClientOriginalName();
            $image = request()->icon;
            $icon = Storage::disk('local')->putFileAs($path, $image, $originalName);
        }
        if ($request->hasFile('sts_file_1')){
            $path = "uploads/car/documents";
            $originalName = time().'_'.$request->file('sts_file_1')->getClientOriginalName();
            $image = request()->sts_file_1;
            $sts_file_1 = Storage::disk('local')->putFileAs($path, $image, $originalName);
        }
        if ($request->hasFile('sts_file_2')){
            $path = "uploads/car/documents";
            $originalName = time().'_'.$request->file('sts_file_2')->getClientOriginalName();
            $image = request()->sts_file_2;
            $sts_file_2 = Storage::disk('local')->putFileAs($path, $image, $originalName);
        }

        $car = Car::create([
          'number' => $request->number,
          'company_id' => Auth::user()->company_id,
          'country_id' => $request->country_id,
          'mark_model' => $request->mark_model,
          'car_type_id' =>$request->car_type_id,
          'sts' => $request->sts,
          'right_use_id' => $request->right_use_id,
          'max_weigth' => $request->max_weigth,
          'icon' => $icon,
          'sts_file_1' => $sts_file_1,
          'sts_file_2' => $sts_file_2
        ]);

        if($request->has('passes')){
          $passes = json_decode($request->passes);
          foreach($passes as $pass){
              CarPass::create([
                'car_id' => $car->id,
                'pass_id' => $pass
              ]);
          }
        }
        return response()->json(CarResource::make($car));
      }catch(\Exception $exception){
          return response()->json(['error' => $exception->getMessage()], 500);
      }

    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        //
    }

    /**
    * @OA\Post(
    *     path="/api/cars/{id}",
    *     summary="Update Cars",
    *     security={{"bearer_token": {}}},
    *     tags = {"Cars"},
    *      @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="number",
    *                     type="string",
    *                     example="1234"
    *                 ),
    *                 @OA\Property(
    *                     property="country_id",
    *                     type="string",
    *                     example="1"
    *                 ),
    *                 @OA\Property(
    *                     property="mark_model",
    *                     type="string",
    *                     example="Mercedes"
    *                 ),
    *                 @OA\Property(
    *                     property="car_type_id",
    *                     type="string",
    *                     example="1"
    *                 ),
    *                 @OA\Property(
    *                     property="sts",
    *                     type="string",
    *                     example="sts"
    *                 ),
    *                 @OA\Property(
    *                     property="right_use_id",
    *                     type="string",
    *                     example="1"
    *                 ),
    *                 @OA\Property(
    *                     property="max_weigth",
    *                     type="string",
    *                     example="1000"
    *                 ),
    *                 @OA\Property(
    *                     property="sts_file_1",
    *                     type="string",
    *                     example="File"
    *                 ),
    *                 @OA\Property(
    *                     property="sts_file_2",
    *                     type="string",
    *                     example="File"
    *                 ),
    *                 @OA\Property(
    *                     property="icon",
    *                     type="string",
    *                     example="File"
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
    public function update(CarRequest $request, $id)
    {
      try{
        $car = Car::find($id);
        $car->number = $request->number;
        $car->company_id = $request->company_id;
        $car->country_id = $request->country_id;
        $car->mark_model = $request->mark_model;
        $car->car_type_id = $request->car_type_id;
        $car->sts = $request->sts;
        $car->right_use_id = $request->right_use_id;
        $car->max_weigth = $request->max_weigth;

        if ($request->hasFile('icon')){
          Storage::disk('local')->delete($car->icon);
          $path = "uploads/car/images";
          $originalName = time().'_'.$request->file('icon')->getClientOriginalName();
          $image = request()->icon;
          $car->icon = Storage::disk('local')->putFileAs($path, $image, $originalName);
        }

        if ($request->hasFile('sts_file_1')){
          $path = "uploads/car/documents";
          $originalName = time().'_'.$request->file('sts_file_1')->getClientOriginalName();
          $image = request()->sts_file_1;
          $car->sts_file_1 = Storage::disk('local')->putFileAs($path, $image, $originalName);
        }

        if ($request->hasFile('sts_file_2')){
          $path = "uploads/car/documents";
          $originalName = time().'_'.$request->file('sts_file_2')->getClientOriginalName();
          $image = request()->sts_file_2;
          $car->sts_file_2 = Storage::disk('local')->putFileAs($path, $image, $originalName);
        }
        $car->save();

        if($request->has('passes')){
          $passes = json_decode($request->passes);
          $car->passes->each->delete();
          foreach($passes as $pass){
              CarPass::create([
                'car_id' => $car->id,
                'pass_id' => $pass
              ]);
          }
        }
        return response()->json(CarResource::make($car));
      }catch(\Exception $exception){
          return response()->json(['error' => $exception->getMessage()], 500);
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        //
    }
}
