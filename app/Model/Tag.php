<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Bi_trip\Bi_Trip_Keyword;

class Tag extends Model
{  
	protected $hidden = ['tag_id', 'business_id'];

    public function wikies(){
    	return $this->belongsToMany('App\Wiki');
    }
    public function trips(){
    	return $this->belongsToMany('App\Bi_trip\Bi_Trip', 'bi_trip_keywords','tag_id');
    }
    public function slovniks(){
    	return $this->belongsToMany('App\Slovnik');
    }

    /**
     * helpers
    */
   	public function countTrips(){
		
   		$item = Bi_Trip_Keyword::where('tag_id', $this->id)->count();
   		return $item;
   	} 
   
}
