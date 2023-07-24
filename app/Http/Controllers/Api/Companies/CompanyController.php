<?php

namespace App\Http\Controllers\Api\Companies;

use App\Http\Resources\Api\Companies\CompanyResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;
use Exception;

class CompanyController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/companies",
     *     summary="Get list of companies",
     *     tags = {"Companies"},
     *     @OA\Response(
     *         response=200,
     *         description="SUCCESS",
     *     ),
     * )
    */
    public function index()
    {
        try{
            $companies = Company::orderBy('created_at', 'desc')->get();
            return CompanyResource::collection($companies);
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
     *     path="/api/companies",
     *     summary="Store Company",
     *     tags = {"Companies"},
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="iin",
     *                     type="string",
     *                     example="IIN"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     example="1000000000"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="company@gmail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="first_name",
     *                     type="string",
     *                     example="CompanyUserName"
     *                 ),
     *                 @OA\Property(
     *                     property="last_name",
     *                     type="string",
     *                     example="CompanyLasName"
     *                 ),
     *                @OA\Property(
     *                     property="company_reg_date",
     *                     type="date",
     *                     example="2023-07-23"
     *                 ),
     *             )
     *         )
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
            $data = $request->all();
            $company = Company::create($data);
            return CompanyResource::make($company);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
    * @OA\Get(
    *      path="/api/companies/{id}",
    *      summary="Show Company",
    *      tags={"Companies"},
    *      description="Show Comapny",
    *      @OA\Parameter(
    *      name="id",
    *      in="path",
    *      required=true,
    *      @OA\Schema(
    *           type="integer",
    *           example="1"
    *         )
    *      ),
    *     @OA\Response(
    *         response=200,
    *         description="SUCCESS",
    *     ),
    *     )
    */
    public function show(Company $company)
    {
        try{
            return CompanyResource::make($company);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {

    }

    /**
    * @OA\Put(
    *      path="/api/companies/{id}",
    *      operationId="Update Companies",
    *      tags={"Companies"},
    *      summary="Update Companies",
    *      description="Update Companies",
    *      @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="iin",
    *                     type="string",
    *                     example="IIN"
    *                 ),
    *                 @OA\Property(
    *                     property="user_id",
    *                     type="integer",
    *                     example="1"
    *                 ),
    *                 @OA\Property(
    *                     property="phone",
    *                     type="string",
    *                     example="1000000000"
    *                 ),
    *                 @OA\Property(
    *                     property="email",
    *                     type="string",
    *                     example="company@gmail.com"
    *                 ),
    *                 @OA\Property(
    *                     property="first_name",
    *                     type="string",
    *                     example="CompanyUserName"
    *                 ),
    *                 @OA\Property(
    *                     property="last_name",
    *                     type="string",
    *                     example="CompanyLasName"
    *                 ),
    *                @OA\Property(
    *                     property="company_reg_date",
    *                     type="date",
    *                     example="2023-07-23"
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
    public function update(Request $request, Company $company)
    {
        try{
            $input = $request->all();
            $company->fill($input)->save();
            return CompanyResource::make($company);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }

    /**
    * @OA\Delete(
    *      path="/api/companies/{id}",
    *      operationId="Delete company",
    *      tags={"Companies"},
    *      summary="Summary",
    *      description="Companies",
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
    public function destroy(Company $company)
    {
        try{
            $company->delete();
            return response()->json([ 'success' => true ]);
        }catch(Exception $exception){
            return response()->json(['error' => $exception->getMessage()], 500);
        }
    }
}
