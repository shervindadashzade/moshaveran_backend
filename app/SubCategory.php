<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'title' , 'picture'
    ];
    
    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function counselors(){
        return $this->belongsToMany('App\Counselor');
    }
}
