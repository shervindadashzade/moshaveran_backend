<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $fillable = [
        'fname','lname','email','password'
    ];

    protected $hidden = [
        'remember_token'
    ];
}
