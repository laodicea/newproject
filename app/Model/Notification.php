<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Facades\App\Repository\Users;
use Carbon\Carbon;

class Notification extends Model
{
     protected $table = 'notifications'; 

     public function getTitle()
     {
          $item = json_decode($this->data);

          return $item->title; 
     }

     public function getText()
     {
          $item = json_decode($this->data);
          return substr($item->text,0,70). '...';
     }

     public function getShowLink()
     {
          $item = json_decode($this->data);
          return $item->showlink;
     }

     public function getCategory()
     {
          $item = json_decode($this->data);

          return $item->category;
     }
     public function setAsRead()
     {
          $this->read_at = Carbon::now();
          $this->save();
     } 
 
     public function getCreatedAt()
     {
          return date('d.m.Y H:i', strtotime($this->created_at));
     }

     public function getUpdatedAt()
     {
          return date('d.m.Y', strtotime($this->updated_at));
     }
}
