<?php

namespace App\Http\Controllers\Api\CalcHistories;

use App\Http\Controllers\Controller;
use App\Models\CalcHistory;
use App\Http\Resources\Api\CalcHistories\CalcHistoryResource;
use Illuminate\Http\Request;
use Auth;

class CalcHistoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/calc/histories",
     *     summary="Get list of Calc history",
     *     tags = {"CalcHistory"},
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
      $calcHistories = [];
      if(Auth::user()->hasRole('super-admin'))
        $calcHistories = CalcHistory::orderBy('updated_at', 'desc')->get();
      else $calcHistories = CalcHistory::where('user_id', Auth::user()->id)->where('hidden', false)->orderBy('updated_at', 'desc')->get();

      return response()->json(CalcHistoryResource::collection($calcHistories)->collection);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try{
          return response()->json(CalcHistoryResource::make(CalcHistory::find($id)));
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CalcHistory $calcHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CalcHistory $calcHistory)
    {
        //
    }

  /**
    * @OA\Delete(
    *      path="/api/calc/histories/{id}",
    *      operationId="Delete CalcHistory",
    *      tags={"CalcHistory"},
    *      security={{"bearer_token": {}}},
    *      summary="Summary",
    *      description="CalcHistory",
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
    public function destroy($id)
    {
        $calcHistory = CalcHistory::find($id);
        $calcHistory->hidden = true;
        $calcHistory->save();
        return response()->json([
          'message' => 'Success'
        ]);
    }
}
