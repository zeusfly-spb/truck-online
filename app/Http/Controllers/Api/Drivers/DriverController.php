<?php

namespace App\Http\Controllers\Api\Drivers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;
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

    public function index(){

      $users = User::role('driver')->where('company_id', Auth::user()->company_id)->get();
      return UserResource::collection($users);
    }

    public function store(Request $request){

      $user = $this->createUser($request);

      if($user){
        $user->assignRole('driver');

        return $this->sendResponse($user,'Driver created successfully.');
      }
    }

    public function createUser($request){

      return User::create([
        'first_name'=> $request->first_name,
        'middle_name'=> $request->middle_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'phone'=> $request->phone,
        'password'=> bcrypt($request->password),
        'company_id' => Auth::user()->company_id
      ]);
    }

    public function uploadDocument(Request $request, $id){

      if ($request->hasFile('document')){

        $document = Document::where('table_owner_id', $id)->first();
        $path = $request->document->move('uploads/documents', time().'_'.$request->document->getClientOriginalName());

        if($document)
          RMFile::delete($document->path);
        else
          $document = new Document;

          $document->value = $request->document_date;
          $document->name = 'Водителькое удостоверение';
          $document->path = $path;
          $document->value = $request->document_date;
          $document->table_owner = 'User';
          $document->table_owner_id = $id;
          $document->save();
      }
      return response([
        'message' => 'Success'
      ]);

    }

    public function uploadFiles(Request $request, $id){


      $files = File::where('table_owner_id', $id)->get();
      if(count($files)>0){

        foreach($files as $file){
          RMFile::delete($file->path);
          $file->delete();
        }
      }

      foreach ($request->file('files') as $data) {
        $file = new File;
        $file->path = $data->move('uploads/files', time().'_'.$data->getClientOriginalName());
        $file->table_owner = 'User';
        $file->table_owner_id = $id;
        $file->save();
      }

      return response([
        'message' => 'Success'
      ]);
    }

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

      return response([
        'message' => 'Success'
      ]);
    }
}
