<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use Config;
use Image;
class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $puth_file;

    public function __construct()
    {
        $this->puth_file = public_path().'/'.config('settings.theme').'/images/';

    }

    public function index()
    {
        $uploads_file = File::get(['id','filename']);
        //dd($uploads_file);
        if(view()->exists(config('settings.theme').'.form')){
            return  view(config('settings.theme').'.form', ['fotos'=>$uploads_file])->withTitle('Test-Exercise');
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $file = $request->img;
        //dd($file->getClientMimeType());
        if(empty($file)){
            return redirect()->route('home')->with('status','Виберіть файл!');
        }
        $img_info = getimagesize($file);
        //dd($img_info);
        if(!$img_info){
            return redirect()->route('home')->with(['status'=>'Помилка завантаження картинки. Картинка має бути формату: gif,jpeg,png']);
        }

        //переносимо картинку в каталог

        $path = public_path().'/'.config('settings.theme').'/images/';
        //умова коли користувач не завантажує watermark, тоді використовуємо дефолтну картинку
        if(empty($_FILES['watermark']['name']) && !empty($_FILES['img']['name']) ){


            $name = $_FILES['img']['name'];
             move_uploaded_file($_FILES['img']['tmp_name'], $path.$name);


             //check checkbox
            if (!empty($_POST['foto']) && !empty($_POST['text'])){
                if(!empty( $_POST['textmark'])){
                    $text = $_POST['textmark'];
                }
                else{
                    $text = 'Ohnitskiy';
                }
                $this->watermark($path.$name, FALSE);
                $this->textmark($path.$name, $text);
            }
            elseif(!empty($_POST['foto']) ){
                $this->watermark($path.$name, FALSE);
            }
            else{
                if(!empty($_POST['text'])) {
                    if(!empty( $_POST['textmark'])){
                        $text = $_POST['textmark'];
                    }
                    else{
                        $text = 'Ohnitskiy';
                    }
                    $this->textmark($path.$name, $text);
                }

            }
            /* may just loaded foto*/

        }
        //умова коли користувач завантажує watermark.png
        elseif(!empty($_FILES['img']['name']) && !empty($_FILES['watermark']['name'])){
            //переносимо картинку
            $name = $_FILES['img']['name'];
            move_uploaded_file($_FILES['img']['tmp_name'], $path . $name);

            if(strrchr($_FILES['watermark']['name'], '.') === '.png') {

                //переносимо watermark-картинку
                $path_watermark = public_path() . '/' . config('settings.theme') . '/images/';
                $name = $_FILES['watermark']['name'];
                move_uploaded_file($_FILES['watermark']['tmp_name'], $path_watermark . $name);


                //check checkbox
                if (!empty($_POST['foto']) && !empty($_POST['text'])) {
                    if (!empty($_POST['textmark'])) {
                        $text = $_POST['textmark'];
                    } else {
                        $text = 'Ohnitskiy';
                    }
                    $this->watermark($path . $_FILES['img']['name'],  $name);
                    $this->textmark($path . $_FILES['img']['name'], $text);
                } elseif (!empty($_POST['foto'])) {
                    $this->watermark($path . $_FILES['img']['name'],  $name);
                } else {
                    if (!empty($_POST['text'])) {
                        if (!empty($_POST['textmark'])) {
                            $text = $_POST['textmark'];
                        } else {
                            $text = 'Ohnitskiy';
                        }
                        $this->textmark($path . $name, $text);
                    }

                }
            }
            else{
                return redirect()->route('home')->with(['watermark'=>'Картинка має бути формату: .png']);
            }
        }
        //
        $images = $path.$_FILES['img']['name'];
        //визначаємо тип картинки - обрізаємо та зберігаємо картинку
        $img_info = getimagesize($images);

        //dd($img_info['mime']);
        if($images){
                if($img_info['mime'] == 'image/jpeg') {
                    $file_name = 'foto_' . str_random(8) . '.jpg';
                    $path = $this->puth_file;
                    $img = Image::make($images);
                    $img->fit(\Config::get("settings.image_size")['width'], \Config::get("settings.image_size")['height'])->save($path . $file_name);
                }
                elseif ($img_info['mime'] == 'image/png'){
                    $file_name = 'foto_' . str_random(8) . '.png';
                    $path = $this->puth_file;
                    $img = Image::make($images);
                    $img->fit(\Config::get("settings.image_size")['width'], \Config::get("settings.image_size")['height'])->save($path . $file_name);
                }
                elseif ($img_info['mime'] == 'image/gif'){
                    $file_name = 'foto_' . str_random(8) . '.gif';
                    $path = $this->puth_file;
                    $img = Image::make($images);
                    $img->fit(\Config::get("settings.image_size")['width'], \Config::get("settings.image_size")['height'])->save($path . $file_name);
                }
                else{
                    return redirect()->route('home');
                }
        }


      $upload =  File::create(['filename' => $file_name]);
        if($upload){
            return redirect()->route('home')->with('status','Фото збережено!');
        }

    }
        public function watermark($file,$watermark_file = FALSE){

            $img_info = getimagesize($file);
            //dd($img_info);
            switch($img_info['mime']){
                case 'image/jpeg':
                    /*for EI*/
                case 'image/pjpeg':
                    $img = imagecreatefromjpeg($file);
                    break;
                case 'image/png':
                    /*for EI*/
                case 'image/x-png':
                    $img = imagecreatefrompng($file);
                    break;
                case 'image/gif':
                    $img = imagecreatefromgif($file);
                    break;

            }
            //розміри картинки
            $img_wight = $img_info[0];
            $img_height = $img_info[1];

            if($watermark_file){
                $water = imagecreatefrompng(config('settings.theme').'/images/'.$watermark_file);
                //розміри водяного знака
                $water_width = imagesx($water);
                $water_height = imagesy($water);
            }

            else{
                if(!file_exists(config('settings.theme').'/images/watermark.png')){
                    return redirect()->route('home')->with(['status'=>'Файл з іменем \'watermark.png\' відсутній']);
                }
                $water = imagecreatefrompng(config('settings.theme').'/images/watermark.png');
                //розміри водяного знака
                $water_width = imagesx($water);
                $water_height = imagesy($water);


            }
            $res_img = imagecreatetruecolor($img_wight, $img_height);

            imagecopyresampled($res_img, $img, 0,0, 0,0,$img_wight,$img_height, $img_wight,$img_height);
            //переносимо знак watermark на картинку

            $new_image = imagecopy($res_img,$water,$img_wight/2-$water_width/2, $img_height/2-$water_height/2, 0,0,$water_width,$water_height);

            if($new_image){
                switch ($img_info['mime']){
                    case 'image/jpeg':
                        /*for EI*/
                    case 'image/pjpeg':
                        imagejpeg($res_img, $file,100);
                        break;
                    case 'image/png':
                        /*for EI*/
                    case 'image/x-png':
                        imagepng($res_img, $file, 0);
                        break;
                    case 'image/gif':
                        imagegif($res_img, $file);
                        break;
                }
                imagedestroy($res_img);
                imagedestroy($img);
                return redirect('/');
            }


        }

        public function textmark($foto,$text){
            //dd($text);
            $text = strip_tags(trim($text));
            $text = utf8_encode($text);
            $img_info = getimagesize($foto);

            switch($img_info['mime']){
                case 'image/jpeg':
                    /*for EI*/
                case 'image/pjpeg':
                    $img = imagecreatefromjpeg("$foto");
                    break;
                case 'image/png':
                    /*for EI*/
                case 'image/x-png':
                    $img = imagecreatefrompng("$foto");
                    break;
                case 'image/gif':
                    $img = imagecreatefromgif("$foto");
                    break;

            }

            $dir = public_path().'/'.config('settings.theme').'/fonts/';
            $files=array_diff(scandir($dir),array(".",".."));
            foreach ($files as $item){
                $font = $item;
            }
            $file_font = public_path().'/'.config('settings.theme').'/fonts/'.$font;
            //dd($file_font);
            //розміри картинки
            $img_wight = imagesx($img);
            $img_height = imagesy($img);


            $white = imagecolorallocatealpha($img, 255, 255, 255,70);
            $black = imagecolorallocatealpha($img, 0, 0, 0, 100);

            if($img_wight > 1024) {
                $size = 200;
                //тень
                imagettftext($img, $size, 15, $img_wight / 4, $img_height / 2 + $size + 10, $black, $file_font, $text);

                imagettftext($img, $size, 15, $img_wight / 4, $img_height / 2 + $size, $white, $file_font, $text);


            }
            else{
                $size = 100;
                //тень
                imagettftext($img, $size, 15, $img_wight / 4, $img_height / 2 + $size + 10, $black, $file_font, $text);

                imagettftext($img, $size, 15, $img_wight / 4, $img_height / 2 + $size, $white, $file_font, $text);

            }
            switch ($img_info['mime']) {
                case 'image/jpeg':
                    /*for EI*/
                case 'image/pjpeg':
                    imagejpeg($img, $foto, 100);
                    break;
                case 'image/png':
                    /*for EI*/
                case 'image/x-png':
                    imagepng($img, $foto);
                    break;
                case 'image/gif':
                    imagegif($img, $foto);
                    break;

            }

            imagedestroy($img);
            return redirect('/');

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

