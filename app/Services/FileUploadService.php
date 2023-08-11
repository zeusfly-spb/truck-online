<?php

namespace App\Services;

class FileUploadService {

  public function upload($destinationPath,$file){
    return $file->move($destinationPath, time().'_'.$file->getClientOriginalName());
  }
}
