<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = ['user_id','payment_date','next_payment_date','status','unsubscribe'];

    public function user()
    {
    	$this->belongsTo('App\User','user_id','id');
    }
}
