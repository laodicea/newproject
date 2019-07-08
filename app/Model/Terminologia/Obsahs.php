<?php

namespace App\Model\Terminologia;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obsahs extends Model
{
	use SoftDeletes; 
    protected $table = 'im_obsahs';
	protected $dates = ['deleted_at'];
    protected $fillable = ['obsah'];
    protected $primaryKey = 'kat_c';
  
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
