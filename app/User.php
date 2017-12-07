<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','power'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function index()
    {


        $array = [1,3,3,4,5];
        count($array);
        $array = array_unique($array);

        $array = [
            [
                'title' => '',
                'content' => '',
            ],
            [],
        ];

        [
            '', '', '',
        ];

        $collection = collect($array);
        $array = $collection->map(function ($item) {
            return $item['title'];
        })->each(functon ());

    }
}
