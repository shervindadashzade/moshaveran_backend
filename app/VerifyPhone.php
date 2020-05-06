<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyPhone extends Model
{
    //
    protected $fillable = [
        'phone',
        'code'
    ];

}