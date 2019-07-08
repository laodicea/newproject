<?php

namespace App\Model\SecurityInform;

use Illuminate\Database\Eloquent\Model;
use App\Model\SecurityInform\Security_inform;

class Sec_category extends Model
{
    protected $table = 'securitycategories';

    public function securityInforms(){
    	return $this->hasMany('App\Model\SecurityInform\Security_inform', 'securitycategories_id');
    }

    public function getAllItemsInCategoryes(){

   		return Security_inform::where('securitycategories_id',$this->id)->paginate(25);
    }

    public function user(){
        return $this->belongsTo('App\User');
    } 

    public function getCreatedAt(){
 
    	return date('d.m.Y', strtotime($this->created_at));
    }
    public function getUpdatedAt(){
 
        return date('d.m.Y', strtotime($this->updated_at));
    }
}
