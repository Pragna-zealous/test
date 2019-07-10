<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentTransactions extends Model
{
	protected $fillable = ['user_id', 'type', 'amount', 'fee', 'tax', 'currency', 'method', 'status', 'email', 'contact', 'description','payment_id','order_id','payment_type'];

    public function user()
	{
	    return $this->belongsTo('App\User', 'user_id');
	}

	// Pay::with('User')->get()
}
