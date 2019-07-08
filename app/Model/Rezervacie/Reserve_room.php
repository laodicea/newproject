<?php

namespace App\Model\Rezervacie;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Reserve_room extends Model
{
    use SoftDeletes; 
    
    protected $dates = ['deleted_at'];
  	protected $table = 'reserve_rooms';
    protected $fillable = ['name','note','user_id','color_id'];

    public function calendar_events(){
        return $this->hasMany('App\Model\Rezervacie\Calendar_events');
    }  
    public function color(){
    	return $this->belongsTo('App\Model\Color');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
