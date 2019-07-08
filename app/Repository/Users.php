<?php
namespace App\Repository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use App\Model\Notification;
use Carbon\Carbon;
use App\User;
use Hash;
use DB;

class Users
{
	CONST CACHE_KEY = 'USERS';
	CONST PAGINATE_PER_PAGE = 30; 

	public function create($req)
	{ 
		$user = new User();

		$user->password =  Hash::make("nepoviem");
		$user->email = $req->email;
		$user->room = $req->room;
		$user->phone = $req->phone;
		$user->lastname = $req->lastname;
		$user->name = $req->name;
		$user->department_id = $req->department_id;
		$user->degree = $req->degree;
		$user->active = 1;

		$user->save();

		if(isset($req->roles)){
			$user->roles()->sync($req->roles);
		}else{
			$user->roles()->sync(array());
		}

        $this->clearPaginateCache(); 

        return $user;
	}
	public function update($req, $id)
	{ 
		$cacheKey = "USERS.{$id}"; 

		$user = User::find($id); 

		$user->room = $req->room;
		$user->phone = $req->phone;
		$user->lastname = $req->lastname;
		$user->name = $req->name;
		$user->department_id = $req->department_id;
		$user->degree = $req->degree;
		$user->save();

		if(isset($req->roles)){
			$user->roles()->sync($req->roles);
		}else{
			$user->roles()->sync(array());
		}

		Cache::pull($cacheKey);
 		$this->clearPaginateCache(); 
 
    	return $user;
	}

	public function all($orderBy)
	{	
		$cacheKey = "USERS.ALL";
  
		$currentPage = Input::get('page') ? Input::get('page') : '1';
	 
		return Cache::rememberForever($cacheKey.'.'.$currentPage,  function() use($orderBy) {
			return $items= User::orderBy($orderBy, 'ASC')->where('active', 1)->paginate(self::PAGINATE_PER_PAGE); 
		}); 
	}

	public function get($id)
	{
		$key = "USERS.{$id}";
		$cacheKey = $this->getCacheKey($key);

		return Cache::rememberForever($cacheKey, function() use($id){
 
			return User::find($id);    
		}); 
	}

	public function delete($id)
	{
		$key = "USERS.{$id}";
		$cacheKey = $this->getCacheKey($key);

		$item = User::find($id);
	    $item->active = false;
	    $item->email = $item->email . " zmazany";
 	    $item->save();

        Cache::pull($cacheKey);
        $this->clearPaginateCache(); 

        return $item;
	}

	public function getCacheKey($value)
	{
		$key = strtoupper($value);
	}

	public function clearPaginateCache()
	{ 
		$key = "USERS.ALL"; 
		$cacheKey = $this->getCacheKey($key);
	 
        Cache::pull($cacheKey);

 		$items = User::all();
		$totalResults = count($items);

        $totalPages = ceil($totalResults/self::PAGINATE_PER_PAGE) + 1;
        for ($i=1; $i <= $totalPages; $i++) { 
          	Cache::pull($cacheKey . '.' . $i);  
        } 
	}

	public function getMessagesNotifications($id)
	{ 
	    $cacheKey = "USERSMESSAGES." . $id; 
	    
	    return cache()->remember($cacheKey, Carbon::now()->addMinutes(2), function() use($id) { 
	        return Notification::where('type', 'App\Notifications\SecurityInform')->where('notifiable_type','App\User')->where('notifiable_id',$id)->where('read_at',null)->get();
	    });
	}
 
	public function clearMyNotifications($id)
	{
 		$cacheKey = "USERSMESSAGES." . $id;  
 
		Cache::pull($cacheKey);
	}

	/*
	/ count number of notifications
	*/

	public function getNumNotifications($id)
	{
		$cacheKey = "USERSNOTIFINUM.{$id}"; 
  
		return cache()->remember($cacheKey, Carbon::now()->addMinutes(1), function() use($id) { 
		   return DB::table('notifications')->where('type', 'App\Notifications\SecurityInform')->where('notifiable_type','App\User')->where('notifiable_id',$id)->where('read_at',null)->count(); 
		}); 
	}

	public function clearNumNotifications($id)
	{
		$cacheKey = "USERSNOTIFINUM.{$id}";  

		Cache::pull($cacheKey);
	}

	public function clearAllNotifications($id)
	{
		$this->clearNumNotifications($id);
		$this->clearMyNotifications($id);
	}
}
