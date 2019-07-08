<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $dates = ['deleted_at']; 
    protected $table = 'files';
}
