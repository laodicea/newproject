<?php
namespace App\Repository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use App\Model\Notification;
use App\Model\Department;
use Carbon\Carbon;  

class Departments
{
	CONST CACHE_KEY = 'DEPARTMENT';
	CONST PAGINATE_PER_PAGE = 3; 

	public function create($request)
	{ 
		$num_value = Department::max('value');

     	$item = new Department();
     	$item->short = $request->short;
     	$item->name = $request->name;
     	$item->value = $num_value+1; 
     	$item->save(); 

        $this->clearPaginateCache(); 

        return $item;
	}
	public function update($request, $id)
	{ 
		$cacheKey =  self::CACHE_KEY . ".{$id}"; 

		$item = Department::find($id);
        $item->short = $request->short;
        $item->name = $request->name; 

        if($request->short_kniha){
            $item->short_kniha = $request->short_kniha; 
        }

        if($request->parent != 0){
            $item->parent = $request->parent;

        }else{
            $item->parent = null;
        }
        $item->save();  
        $item->saveRoleUser($request->boss); 

		Cache::pull($cacheKey);
 		$this->clearPaginateCache(); 
 
    	return $item;
	}

	public function all($orderBy)
	{	
		$cacheKey =  self::CACHE_KEY . "ALL";
  
		$currentPage = Input::get('page') ? Input::get('page') : '1';
	 
		return Cache::rememberForever($cacheKey.'.'.$currentPage,  function() use($orderBy) {
			return Department::where('active',true)->orderBy($orderBy,'asc')->paginate(self::PAGINATE_PER_PAGE); 
		}); 
	}

	public function get($id)
	{
		$cacheKey = self::CACHE_KEY . ".{$id}";
		 
		return Cache::rememberForever($cacheKey, function() use($id){

			$item = Department::find($id);
	        $item->boss = $item->bossSekretar('riadiaci pracovnik');
	        $item->zastupca = $item->bossSekretar('zastupca');
	        $item->parent = $item->getUpOrg();
	  
			return $item;    
		}); 
	}

	public function delete($id)
	{
		$cacheKey = self::CACHE_KEY . ".{$id}";
		 
		$item = Department::find($id);
     	$item->active = false;
        $item->save();
        $item->removeRoles();

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
		$cacheKey = self::CACHE_KEY."ALL"; 
		  
        Cache::pull($cacheKey);

 		$items = Department::all();
		$totalResults = count($items);

        $totalPages = ceil($totalResults/self::PAGINATE_PER_PAGE) + 1;
        for ($i=1; $i <= $totalPages; $i++) { 
          	Cache::pull($cacheKey . '.' . $i);  
        } 
	}  
}
