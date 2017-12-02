<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use File;
use Input;

class UploadedFile extends Model {

    // this model is essentially for validation files
    // 
    // 
    // return true if file is correctly uploaded 
    // false if file is not uploaded

    public function validate($file) {


        if ($file == null) {
            return false;
        } else {
            if ($file->isValid()) {
                return true;
            } else {
                return false;
            }
        }
    }

    // this model is essentially for uploading  files
    // 
    // 
    // return true if file is correctly uploaded 
    // false if file is not uploaded
    public function uploadFile($user, $file, $destination) {

        $file = Input::file('image');
        $random_name = str_random(20);
        $extension = $file->getClientOriginalExtension();
        $filename = $random_name . '.' . $extension;
        $file->move($destinationPath, $filename);

        $data ['image'] = $filename;
    }

}
