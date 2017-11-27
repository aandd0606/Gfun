<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $fillable = ['title','number','address','phone','fax'];
//    protected $table = 'my_flights';
}
