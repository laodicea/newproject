<?php

namespace App\Model\Otn;

use Illuminate\Database\Eloquent\Model;

class NavrhZrusStn extends Model
{
    protected $primaryKey = 'kat_c';
    protected $table = 'otn_navrh_zr_stns';
    protected $fillable = ['ozn','nazov','date_vyd','date_nav_zru','zodp_zam'];
    protected $hidden = ['kat_c'];  

 	public function user(){
		return $this->belongsTo('App\User');
	}

	public function getDateVyd(){
		return date('d.m.Y', strtotime($this->date_vyd));
	}

	public function getDateNavZru(){
		return date('d.m.Y', strtotime($this->date_nav_zru));
	}

	public function getCreatedAt(){
		return date('d.m.Y', strtotime($this->created_at));

	}

	public function getUpdatedAt(){
		return date('d.m.Y', strtotime($this->updated_at));
	}
	
	public function isPublic(){
		if($this->public == 0){
			return "Nie";
		}else{
			return "Áno";
		}
	}
}
