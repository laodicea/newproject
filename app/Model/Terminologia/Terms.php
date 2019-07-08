<?php

namespace App\Model\Terminologia;

use Illuminate\Database\Eloquent\Model;

class Terms extends Model
{
    protected $table = 'im_terms';
    protected $fillable = ['kat_c','skdef','user_id','sknote','skterm','enterm','endef','ennote'];
   
    public function user()
    {
		return $this->belongsTo('App\User');
	}

	public function getCreatedAt()
	{ 
    	return date('d.m.Y', strtotime($this->created_at));
    }
    
    public function getUpdatedAt()
    { 
        return date('d.m.Y', strtotime($this->updated_at));
    }

    
}
