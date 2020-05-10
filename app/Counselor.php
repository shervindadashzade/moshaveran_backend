<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Counselor extends Model
{
    protected $fillable = [
        'fname','lname','email','phone','photo','description','cv'
    ];

    protected $hidden = [
        'api_token','isValid','charge','pivot'
    ];
    public function subCategories(){
        return $this->belongsToMany('App\SubCategory');
    }
}
