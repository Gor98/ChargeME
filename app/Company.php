<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['image', 'name'];

    public function stations(){
    	 return $this->hasMany('App\Station');
    }
}
