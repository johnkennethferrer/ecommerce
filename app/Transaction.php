<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
    	'user_id',
    	'status',
    	'total_amount'
    ];	

    public function orders() {
        return $this->hasMany('App\Orderlist');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
