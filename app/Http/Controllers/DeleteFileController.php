<?php

namespace App\Http\Controllers;

use App\File;
use Illuminate\Http\Request;

class DeleteFileController extends Controller
{
    //
    public function delFile($id){
        if($id){
            $file = File::find($id);
            $file->delete();
            return redirect()->route('home')->with('delete','Фото видалено!!!');
        }
    }
}
