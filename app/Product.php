<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'receipt_id',
        'product',
        'price',
        'amount',
        'subtotal',
        'company_id',
        'cost',
        'detail',
        'user_id',
        'closing'
    ];

}
