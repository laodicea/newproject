<?php

namespace App\Model\SecurityInform;

use Illuminate\Database\Eloquent\Model;
use App\Model\SecurityInform\Sec_category;
use App\Model\Notification;
use Auth;

class Security_inform extends Model
{
    protected $table = 'securityinforms';

    public function category()
    {
    	return Sec_category::select('name')->where('id', $this->securitycategories_id)->first();
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

    public function getTextShort(){

    	return substr($this->description,0,250) . '<span class="ellipsis">...</span>';
    }
    public function setAsRead($slug){
       $notifications = Notification::where('notifiable_id', Auth::id())->where('type', 'App\Notifications\SecurityInform')->get();

        foreach ($notifications as $key => $notification) {
            $data = json_decode($notification->data);

            if($data->slug == $slug){ 
                $notification->setAsRead(); 
            }
        }
    } 
}
