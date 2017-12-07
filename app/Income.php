<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    //
    protected $fillable = [
        'receipt_id',
        'income',
        'incomedate',
        'method'
    ];
}
