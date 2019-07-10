<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = "partner_images";
    protected $fillable = ['image_name','image_order'];
}
