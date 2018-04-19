<?php

namespace App\Http\Controllers;

use App\Dropzone;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class DropzoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $file_path;
    public function __construct()
    {
        $this->file_path = public_path().'/'.config('settings.theme').'/images/dropzone/';
    }

    public function index()
    {
        //
        if(view()->exists(config('settings.theme').'.dropzone_upload')){

            return view(config('settings.theme').'.dropzone_upload')->withTitle('Test-Exercise');
        }
        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $photos = $request->file;

        if (!is_array($photos)) {
            $photos = [$photos];
        }
        for ($i = 0; $i < count($photos); $i++) {
            $photo = $photos[$i];
            /* -----------перевірка формату файлу-------*/
                  switch ($photo->getClientMimeType()){
                      case "image/jpeg":
                          $name = 'dropzone-'.rand(0,50).'.jpg';
                          break;
                      case "image/png":
                          $name = 'dropzone-'.rand(0,50).'.png';
                          break;
                      case "image/gif":
                          $name = 'dropzone-'.rand(0,50).'.gif';
                          break;
                      default:
                          $name = basename($photo->getClientOrininalName());
                  }
            /* -----------/ перевірка формату файлу-------*/

            $img = Image::make($photo);
            $img->fit(\Config::get("settings.image_size")['width'], \Config::get("settings.image_size")['height'])->save($this->file_path . $name);

            //переміщуємо картинки в каталог
            $photo->move($this->file_path, $name);
            //зберігаємо в БД
            $save_img = new Dropzone;
            $save_img->foto_name = $name;
            $save_img->save();

        }
        return redirect('/dropzone');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
