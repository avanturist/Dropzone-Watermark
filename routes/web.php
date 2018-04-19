<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::resource('/dropzone', 'DropzoneController',[
                                                    'parameters'=>['dropzone'=>'id']
                                                    ]);
//view all dropzone images saved
Route::get('/images', ['uses'=>'AllDropzoneImagesController@show']);

Route::resource('/', 'IndexController', [
                                        'names'=> ['index' => 'home'],
                                        'only'  => ['index', 'store']
                                        ]);
//delete photo
Route::put('/delete/{id}', ['uses'=>'DeleteFileController@delFile', 'as'=>'delete']);
