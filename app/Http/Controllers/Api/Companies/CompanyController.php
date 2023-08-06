<?php

namespace App\Http\Controllers\Api\Companies;

use App\Http\Requests\CompanyRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
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
     *                     type="integer",
     *                     example="12345678910"
     *                 ),
     *                  @OA\Property(
     *                     property="kpp",
     *                     type="integer",
     *                     example="123456789"
     *                 ),
     *                  @OA\Property(
     *                     property="ogrn",
     *                     type="string",
     *                     example="ogrn"
     *                 ),
     *                  @OA\Property(
     *                     property="phone",
     *                     type="string",
     *                     example="12345678910"
     *                 ),
     *                  @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     example="email@gmail.com"
     *                 ),
     *                 @OA\Property(
     *                     property="short_name",
     *                     type="string",
     *                     example="short_name"
     *                 ),
     *                  @OA\Property(
     *                     property="full_name",
     *                     type="string",
     *                     example="full_name"
     *                 ),
     *                 @OA\Property(
     *                     property="link",
     *                     type="string",
     *                     example="https://groozgo.ru/"
     *                 ),
     *                  @OA\Property(
     *                     property="company_reg_date",
     *                     type="string",
     *                     example="2023-07-26"
     *                 ),
     *                  @OA\Property(
     *                     property="edo_provider",
     *                     type="string",
     *                     example="edo_provider"
     *                 ),
     *                  @OA\Property(
     *                     property="edo_id",
     *                     type="string",
     *                     example="edo_id"
     *                 ),
     *                  @OA\Property(
     *                     property="user_id",
     *                     type="integer",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="tax_id",
     *                     type="integer",
     *                     example="1"
     *                 ),
     *                  @OA\Property(
     *                     property="country_id",
     *                     type="integer",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="address_id",
     *                     type="integer",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="post_address_id",
     *                     type="integer",
     *                     example="1"
     *                 ),
     *                 @OA\Property(
     *                     property="contact",
     *                     type="string",
     *                     example="contact"
     *                 ),
     *                 @OA\Property(
     *                     property="data_contract",
     *                     type="string",
     *                     example="2023-07-26"
     *                 ),
     *                @OA\Property(
     *                     property="ceo_name",
     *                     type="string",
     *                     example="ceo_name"
     *                 ),
     *                 @OA\Property(
     *                     property="cceo_name",
     *                     type="string",
     *                     example="cceo_name"
     *                 ),
     *                 @OA\Property(
     *                     property="cceo_contract_name",
     *                     type="string",
     *                     example="cceo_contract_name"
     *                 ),
     *                 @OA\Property(
     *                     property="cceo_contract_date",
     *                     type="string",
     *                     example="2023-07-26"
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
    public function store(CompanyRequest $request)
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
    *                     type="integer",
    *                     example="12345678910"
    *                 ),
    *                  @OA\Property(
    *                     property="kpp",
    *                     type="integer",
    *                     example="123456789"
    *                 ),
    *                  @OA\Property(
    *                     property="ogrn",
    *                     type="string",
    *                     example="ogrn"
    *                 ),
    *                  @OA\Property(
    *                     property="phone",
    *                     type="string",
    *                     example="12345678910"
    *                 ),
    *                  @OA\Property(
    *                     property="email",
    *                     type="string",
    *                     example="email@gmail.com"
    *                 ),
    *                 @OA\Property(
    *                     property="short_name",
    *                     type="string",
    *                     example="short_name"
    *                 ),
    *                  @OA\Property(
    *                     property="full_name",
    *                     type="string",
    *                     example="full_name"
    *                 ),
    *                 @OA\Property(
    *                     property="link",
    *                     type="string",
    *                     example="https://groozgo.ru/"
    *                 ),
    *                  @OA\Property(
    *                     property="company_reg_date",
    *                     type="string",
    *                     example="2023-07-26"
    *                 ),
    *                  @OA\Property(
    *                     property="edo_provider",
    *                     type="string",
    *                     example="edo_provider"
    *                 ),
    *                  @OA\Property(
    *                     property="edo_id",
    *                     type="string",
    *                     example="edo_id"
    *                 ),
    *                  @OA\Property(
    *                     property="user_id",
    *                     type="integer",
    *                     example="1"
    *                 ),
    *                 @OA\Property(
    *                     property="tax_id",
    *                     type="integer",
    *                     example="1"
    *                 ),
    *                  @OA\Property(
    *                     property="country_id",
    *                     type="integer",
    *                     example="1"
    *                 ),
    *                 @OA\Property(
    *                     property="address_id",
    *                     type="integer",
    *                     example="1"
    *                 ),
    *                 @OA\Property(
    *                     property="post_address_id",
    *                     type="integer",
    *                     example="1"
    *                 ),
    *                 @OA\Property(
    *                     property="contact",
    *                     type="string",
    *                     example="contact"
    *                 ),
    *                 @OA\Property(
    *                     property="data_contract",
    *                     type="string",
    *                     example="2023-07-26"
    *                 ),
    *                @OA\Property(
    *                     property="ceo_name",
    *                     type="string",
    *                     example="ceo_name"
    *                 ),
    *                 @OA\Property(
    *                     property="cceo_name",
    *                     type="string",
    *                     example="cceo_name"
    *                 ),
    *                 @OA\Property(
    *                     property="cceo_contract_name",
    *                     type="string",
    *                     example="cceo_contract_name"
    *                 ),
    *                 @OA\Property(
    *                     property="cceo_contract_date",
    *                     type="string",
    *                     example="2023-07-26"
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
    public function update(CompanyRequest $request, Company $company)
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

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function findByInn(Request $request)
  {
    if ($company = Company::where('inn', $request->inn)->first()) {
      return response()->json(['company' => new CompanyResource($company)]);
    } else {
      $dadata = new \Dadata\DadataClient(env('DADATA_API_KEY'), env('DADATA_SECRET_KEY'));
      $res = $dadata->findById('party', $request->inn, 1);
      return response()->json(['company' => new CompanyResource(Company::create(['inn' => $request->inn,
        'short_name' => $res[0]['value']]))]);
    }
  }
}
