<?php

namespace App\Http\Controllers;

use App\Dropzone;
use Illuminate\Http\Request;


class AllDropzoneImagesController extends Controller
{
    //
    public function show(){
        if(view()->exists(config('settings.theme').'.all_dropzone_images')){
            $photos = Dropzone::get(['id','foto_name']);
            return view(config('settings.theme').'.all_dropzone_images',['photos'=>$photos])->withTitle('Test-Exercise');
        }
        abort(403);
    }
}
