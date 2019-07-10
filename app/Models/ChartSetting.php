<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChartSetting extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'chart_settings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','legend','value','color'];
}
