<?php

namespace App\Http\Controllers\Api\Drivers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;
use App\Http\Resources\Api\Drivers\DriverResource;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\User;
use App\Models\File;
use File as RMFile;
use Auth;


class DriverController extends BaseController
{
  protected $documentService;

    public function __construct(FileUploadService $fileService){
        $this->documentService = $fileService;
    }
    /**
     * @OA\Get(
     *     path="/api/drivers",
     *     summary="Get list of Drivers",
     *     tags = {"Drivers"},
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
    public function index(){

      $users = User::role('driver')->where('company_id', Auth::user()->company_id)->get();
      return response()->json(DriverResource::collection($users)->collection);
    }
    /**
    * @OA\Post(
    *     path="/api/drivers",
    *     summary="Store Company",
    *     security={{"bearer_token": {}}},
    *     tags = {"Drivers"},
    *      @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="first_name",
    *                     type="string",
    *                     example="first_name"
    *                 ),
    *                 @OA\Property(
    *                     property="middle_name",
    *                     type="string",
    *                     example="middle_name"
    *                 ),
    *                 @OA\Property(
    *                     property="last_name",
    *                     type="string",
    *                     example="last_name"
    *                 ),
    *                 @OA\Property(
    *                     property="email",
    *                     type="string",
    *                     example="email"
    *                 ),
    *                 @OA\Property(
    *                     property="phone",
    *                     type="string",
    *                     example="111111111"
    *                 ),
    *                 @OA\Property(
    *                     property="password",
    *                     type="string",
    *                     example="12345678"
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
    public function store(Request $request){

      $user = $this->createUser($request);

      if($user){
        $user->assignRole('driver');

        return $this->sendResponse($user,'Driver created successfully.');
      }
    }

    public function createUser($request){

      $user = User::create([
        'first_name'=> $request->first_name,
        'middle_name'=> $request->middle_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'phone'=> $request->phone,
        'password'=> bcrypt($request->password),
        'company_id' => Auth::user()->company_id
      ]);
      $user->addMangoAccount();
      return $user;
    }
  /**
    * @OA\Post(
    *     path="/api/driver/documents/{driver_id}",
    *     summary="Store Document of Driver",
    *     security={{"bearer_token": {}}},
    *     tags = {"Drivers"},
    *      @OA\RequestBody(
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 @OA\Property(
    *                     property="document",
    *                     type="file"
    *                 ),
    *                 @OA\Property(
    *                     property="document_date",
    *                     type="string",
    *                     example="2023-01-01"
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
    public function uploadDocument(Request $request, $id){

      if ($request->hasFile('document')){

        $document = Document::where('table_owner_id', $id)->first();
        $path = $request->document->move('uploads/documents', time().'_'.$request->document->getClientOriginalName());

        if($document)
          RMFile::delete($document->path);
        else
          $document = new Document;

          $document->number = $request->document_number;
          $document->name = 'Водителькое удостоверение';
          $document->path = $path;
          $document->value = $request->document_date;
          $document->table_owner = 'User';
          $document->table_owner_id = $id;
          $document->save();
      }
      return response()->json(['message' => "success"]);
    }
    /**
    * @OA\Post(
    *     path="/api/drivers/{driver_id}",
    *     summary="Delete Driver",
    *     security={{"bearer_token": {}}},
    *     tags = {"Drivers"},
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
    public function uploadFiles(Request $request, $id){


      $files = File::where('table_owner_id', $id)->get();
      if(count($files)>0){

        foreach($files as $file){
          RMFile::delete($file->path);
          $file->delete();
        }
      }
      //return $request;
      foreach ($request->file('files') as $data) {
        $file = new File;
        $file->path = $data->move('uploads/files', time().'_'.$data->getClientOriginalName());
        $file->table_owner = 'User';
        $file->table_owner_id = $id;
        $file->save();
      }

      return response()->json(['message' => "success"]);
    }
    /**
    * @OA\Delete(
    *      path="/api/drivers/{id}",
    *      operationId="Delete Driver",
    *     security={{"bearer_token": {}}},
    *      tags={"Drivers"},
    *      summary="Drivers",
    *      description="Drivers",
    *      @OA\Parameter(
    *          description="Id",
    *          in="path",
    *          name="id",
    *          required=true,
    *          @OA\Examples(example="int", value="6", summary="an int value"),
    *      ),
    *     @OA\Response(
    *         response=200,
    *         description="SUCCESS",
    *     ),
    *     )
    */
    public function destroy($id){

      $user = User::find($id);
      $user->removeRole('driver');

      //remove files
      $files = File::where('table_owner', 'User')->where('table_owner_id', $id)->get();
      if(count($files)>0){
        foreach($files as $file){
          RMFile::delete($file->path);
          $file->delete();
        }
      }

      //remove document
      $document = Document::where('table_owner', 'User')->where('table_owner_id', $id)->first();
      if($document){
        RMFile::delete($document->path);
        $document->delete();
      }
      $user->delete();

      return response()->json(['message' => "success"]);
    }
}
