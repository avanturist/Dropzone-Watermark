<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dropzone extends Model
{
    //
    protected $table = 'dropzones';
    public $timestamps = true;
    protected $fillable = ['foto_name'];
}
