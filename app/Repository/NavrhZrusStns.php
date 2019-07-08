<?php
namespace App\Repository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use App\Model\Otn\NavrhZrusStn;
use Carbon\Carbon; 
use Auth;

class NavrhZrusStns
{
	CONST CACHE_KEY = 'NAVRHZRUSSTN';
	CONST PAGINATE_PER_PAGE = 30; 

	public function create($request)
	{ 
		$item = new NavrhZrusStn(); 

    	$item->kat_c = $request->kat_c;
    	$item->ozn = $request->ozn;
    	$item->nazov = $request->nazov;
    	$item->date_vyd = date("Y-m-d", strtotime($request->date_vyd));
    	$item->date_nav_zru = date("Y-m-d", strtotime($request->date_nav_zru));
    	$item->zodp_zam = $request->zodp_zam; 
    	$item->user_id = Auth::id(); 

		$item->save();  

        $this->clearPaginateCache(); 

        return $item;
	}

	public function update($request, $kat_c)
	{  
		$cacheKey = "NAVRHZRUSSTN.{$kat_c}";

		$item = NavrhZrusStn::find($kat_c); 
		$item->ozn = $request->ozn;
    	$item->nazov = $request->nazov;
    	$item->date_vyd = date("Y-m-d", strtotime($request->date_vyd));
    	$item->date_nav_zru = date("Y-m-d", strtotime($request->date_nav_zru));
    	$item->zodp_zam = $request->zodp_zam; 
    	$item->user_id = Auth::id();
    	$item->save();
  
		Cache::pull($cacheKey);
 		$this->clearPaginateCache(); 
 
    	return $item;
	}

	public function all($orderBy)
	{	
		$cacheKey = "NAVRHZRUSSTN.ALL";
 
		$currentPage = Input::get('page') ? Input::get('page') : '1';
	 
		return Cache::rememberForever($cacheKey.'.'.$currentPage,  function() use($orderBy) {
			return NavrhZrusStn::OrderBy($orderBy,'desc')->paginate(self::PAGINATE_PER_PAGE);
		}); 
	}

	public function get($kat_c)
	{
		$cacheKey = "NAVRHZRUSSTN.{$kat_c}";
	  
		return Cache::rememberForever($cacheKey, function() use($kat_c){
 
			return NavrhZrusStn::findOrFail($kat_c);   
		}); 
	}

	public function delete($kat_c)
	{
		$cacheKey = "NAVRHZRUSSTN.{$kat_c}";

		$item = NavrhZrusStn::find($kat_c); 

        if($item->user_id == Auth::id()){  
            $item->delete(); 

            Cache::pull($cacheKey);
        	$this->clearPaginateCache(); 

        	return true;
         }else{
         	return false;
         } 
	}

	public function getCacheKey($value)
	{
		$key = strtoupper($value);
	}

	public function clearPaginateCache()
	{ 
		$cacheKey = "NAVRHZRUSSTN.ALL";
	 
        Cache::pull($cacheKey);

 		$items = NavrhZrusStn::all();
		$totalResults = count($items);

        $totalPages = ceil($totalResults/self::PAGINATE_PER_PAGE) + 1;
        for ($i=1; $i <= $totalPages; $i++) { 
          	Cache::pull($cacheKey . '.' . $i);  
        } 
	}
}
