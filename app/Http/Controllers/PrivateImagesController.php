<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class PrivateImagesController extends Controller
{
    public function getImage($cin){
        $user  =  User::find($cin);
        if($user){
            $image_name = $user->image;
            $image  = storage_path("app/avatars/$image_name");

        }
        else{
            $image  = storage_path("app/avatars/default.jpg");
        }
        return response()->file($image);
    }
}
