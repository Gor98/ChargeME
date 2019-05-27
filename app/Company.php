<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['image', 'name', 'is_child'];

	public function parent(){
	    return $this->belongsToMany('App\Company', 'company_company', 'child_id', 'parent_id')->with('stations')->withTimestamps();
	}
	public function child(){
	    return $this->belongsToMany('App\Company', 'company_company', 'parent_id', 'child_id')->with('stations')->withTimestamps();
	}

	public function stations(){
		 return $this->hasMany('App\Station');
	}

	public function allStations($company){
		 if($company->child()->exists()){
		 
            foreach ($company->child as $key => $value) {

                foreach ($value->stations as $key => $item) {
                	$item->is_child = 1; 
                    $this->stations->push($item);
                }
                if($value->child()->exists()){
                	$this->allStations($value);
                }
            }
        }
        return $company;
	}
}
