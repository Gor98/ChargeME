<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    
    protected $fillable = ['lat','lng', 'name', 'company_id'];
    
    public function company()
    {
        return $this->belongsTo('App\Company');
    }
}
