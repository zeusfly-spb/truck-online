<?php

namespace App\Http\Controllers\Api\WayPoints;

use App\Http\Controllers\Controller;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\WayPoint;
use App\Models\File;
use Carbon\Carbon;
use Auth;
use App\Http\Resources\Api\WayPoints\WayPointResource;

class WayPointController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/way/points",
     *     summary="Get list of WayPoints",
     *     security={{"bearer_token": {}}},
     *     tags = {"WayPoints"},
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
        $wayPoints = WayPoint::get();
        return response()->json(WayPointResource::collection($wayPoints)->collection);
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
     *     path="/api/way/points",
     *     summary="Store WayPoints",
     *     security={{"bearer_token": {}}},
     *     tags = {"WayPoints"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                  @OA\Property(
     *                     property="order_id",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                @OA\Property(
     *                     property="type_id",
     *                     type="string",
     *                     example="1"
     *                 ),
     *                @OA\Property(
     *                     property="address_id",
     *                     type="string",
     *                     example="2023-08-31"
     *                 ),
     *                @OA\Property(
     *                     property="latitude",
     *                     type="string",
     *                     example="37.2377193"
     *                 ),
     *                @OA\Property(
     *                     property="longitude",
     *                     type="string",
     *                     example="55.6617422"
     *                 ),
     *               @OA\Property(
     *                     property="document",
     *                     type="string",
     *                     example=null
     *                 ),
     *               @OA\Property(
     *                     property="document_name",
     *                     type="string",
     *                     example=null
     *                 ),
     *                @OA\Property(
     *                     property="file_id",
     *                     type="string",
     *                     example=null
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
     *    ),
     * )
     */
    public function store(Request $request)
    {
        $wayPoint = new WayPoint;
        $wayPoint->user_id = Auth::user()->id;
        $wayPoint->order_id = $request->order_id;
        $wayPoint->address_id = $request->address_id;
        $wayPoint->type_id = $request->type_id;
        if($request->has('latitude') && $request->has('longitude'))
          $wayPoint->location = new Point($request->latitude, $request->longitude);
        $wayPoint->save();

        if($request->has('document')){
          $path = $request->document->move('uploads/documents', time().'_'.$request->document->getClientOriginalName());
          $document = new Document;
          $document->value = Carbon::now()->format('Y-m-d');
          $document->name = $request->document_name;
          $document->path = $path;
          $document->value = Carbon::now()->format('Y-m-d');
          $document->table_owner = 'WayPoint';
          $document->table_owner_id = $wayPoint->id;
          $document->save();
        }
        if($request->has('file')){

          $file = new File;
          $file->path = $request->file->move('uploads/files', time().'_'.$request->file->getClientOriginalName());
          $file->table_owner = 'WayPoint';
          $file->table_owner_id = $wayPoint->id;
          $file->save();
        }

        return response()->json(['message'=> 'Success' ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(WayPoint $wayPoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WayPoint $wayPoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WayPoint $wayPoint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WayPoint $wayPoint)
    {
        //
    }
}
