<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orderlist extends Model
{
    //
    protected $fillable = [
    	'product_id',
    	'transaction_id',
    	'quantity'
    ];

    public function transaction() {
        return $this->belongsTo('App\Transaction');
    }
}
