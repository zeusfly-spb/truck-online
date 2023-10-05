<?php

namespace App\Http\Controllers\Api\Cars;

use App\Http\Resources\Api\Cars\CarResource;
use App\Http\Requests\CarRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use App\Models\CarPass;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class CarController extends Controller
{
    protected $fileService;

    public function __construct(FileUploadService $fileService)
    {
        $this->fileService = $fileService;
    }
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
        $car = Car::create([
          "number" => $request->number,
          "company_id" => User::find(Auth::id())->company_id,
          "country_id" => $request->country_id,
          "mark_model" => $request->mark_model,
          "car_type_id" => $request->car_type_id,
          "sts" => $request->sts,
          "right_use_id" => $request->right_use_id,
          "max_weigth" => $request->max_weigth
        ]);
/*
        $car = new Car;
        $car->number = $request->number;
        $car->company_id = Auth::user()->company_id;
        $car->country_id = $request->country_id;
        $car->mark_model = $request->mark_model;
        $car->car_type_id = $request->car_type_id;
        $car->sts = $request->sts;
        $car->right_use_id = $request->right_use_id;
        $car->max_weigth = $request->max_weigth;
*/
        if ($request->hasFile('icon')){
//          $car->icon = $this->fileService->upload('uploads/car/images', $request->file('icon'));
          $car->icon = $request->file('icon')->store('uploads/car/images');
        }

        if ($request->hasFile('sts_file_1')){
          $car->sts_file_1 = $this->fileService->upload('uploads/car/documents', $request->file('sts_file_1'));
        }
        if ($request->hasFile('sts_file_2')){
          $car->sts_file_2 = $this->fileService->upload('uploads/car/documents', $request->file('sts_file_2'));
        }
        $car->save();
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
          File::delete($car->icon);
          $car->icon = $this->fileService->upload('uploads/car/images', $request->file('icon'));
        }

        if ($request->hasFile('sts_file_1')){
          File::delete($car->sts_file_1);
          $car->sts_file_1 = $this->fileService->upload('uploads/car/documents', $request->file('sts_file_1'));
        }

        if ($request->hasFile('sts_file_2')){
          $car->sts_file_2 = $this->fileService->upload('uploads/car/documents', $request->file('sts_file_2'));
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
      }catch(Exception $exception){
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
