<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'title','icon','color'
    ];

    public function subCategories(){
        return $this->hasMany('App\SubCategory');
    }
}
