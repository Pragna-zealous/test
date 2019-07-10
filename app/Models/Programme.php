<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Programme extends Model
{
    protected $table = "programme_images";
    protected $fillable = ['image_name','image_order'];
}
