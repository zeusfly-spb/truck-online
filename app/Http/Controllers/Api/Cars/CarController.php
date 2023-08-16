<?php

namespace App\Http\Controllers\Api\Cars;

use App\Http\Resources\Api\Cars\CarResource;
use App\Http\Requests\CarRequest;
use App\Http\Controllers\Controller;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use App\Models\CarPass;
use App\Models\Car;
use Auth;
use File;


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
     *     summary="Get list of cars",
     *     tags = {"Cars"},
     *     @OA\Response(
     *         response=200,
     *         description="SUCCESS",
     *     ),
     * )
    */
    public function index()
    {
        try{
            $cars = Car::orderBy('created_at', 'desc')->where('company_id', Auth::user()->company_id)->get();
            return CarResource::collection($cars);
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
     * Store a newly created resource in storage.
     */
    public function store(CarRequest $request)
    {
      try{
        $car = new Car;
        $car->number = $request->number;
        $car->company_id = Auth::user()->company_id;
        $car->country_id = $request->country_id;
        $car->mark_model = $request->mark_model;
        $car->car_type_id = $request->car_type_id;
        $car->sts = $request->sts;
        $car->right_use_id = $request->right_use_id;
        $car->max_weigth = $request->max_weigth;

        if ($request->hasFile('icon')){
          $car->icon = $this->fileService->upload('uploads/car/images', $request->file('icon'));
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
        return CarResource::make($car);
      }catch(Exception $exception){
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
     * Update the specified resource in storage.
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
        return CarResource::make($car);
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
