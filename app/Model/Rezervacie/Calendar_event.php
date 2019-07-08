<?php

namespace App\Model\Rezervacie;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Calendar_event extends Model
{
    use SoftDeletes; 
    
    protected $dates = ['deleted_at'];
  	protected $table = 'calendar_events';
    protected $fillable = ['title','start_date','end_date', 'user_id', 'url_link', 'color'];

    public function reserve_room(){
		return $this->belongsTo('App\Model\Rezervacie\Reserve_room');
    }
    public function user(){
        return $this->belongsTo('App\User');
    } 
    public function getStartDate(){ 
        return date("d.m.Y H:i", strtotime($this->start_date));
    }
    public function getEndDate(){
        return date("d.m.Y H:i", strtotime($this->end_date));
    }
}
