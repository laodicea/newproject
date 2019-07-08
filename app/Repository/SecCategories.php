<?php
namespace App\Repository;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use App\Model\SecurityInform\Sec_category;
use Carbon\Carbon; 
use Session;
 
class SecCategories
{
	CONST CACHE_KEY = 'SECCATEGORY';
	CONST PAGINATE_PER_PAGE = 25; 

	public function update($request, $id)
	{  
		$cacheKey = "SECCATEGORY.{$id}";

		$item = Sec_category::find($id); 
        $item->name = $request->name;  
        $item->save(); 

		Cache::pull($cacheKey);
 		$this->clearPaginateCache(); 
 
    	return $item;
	}

	public function create($request)
	{ 
 		$item = new Sec_category(); 
 		$item->name = $request->name; 
 		$item->save(); 

        $this->clearPaginateCache(); 

        return $item;
	}

	public function all($orderBy)
	{	
		$cacheKey = "SECCATEGORY.ALL";

		$currentPage = Input::get('page') ? Input::get('page') : '1'; 

		return Cache::rememberForever($cacheKey.'.'.$currentPage,  function() use($orderBy) {
		    return Sec_category::orderBy($orderBy,'asc')->paginate(self::PAGINATE_PER_PAGE);
		    
		});
	}

	public function get($id)
	{
		$cacheKey = "SECCATEGORY.{$id}";

		return Cache::rememberForever($cacheKey, function() use($id){

			return  $item = Sec_category::find($id);    
		}); 
	}

	public function delete($id)
	{
		$cacheKey = "SECCATEGORY.{$id}";

		$item = Sec_category::find($id);
		$item->delete(); 

        Cache::pull($cacheKey);
        $this->clearPaginateCache(); 

        return $item;
	}

	public function getCacheKey($value)
	{
		$key = strtoupper($value);
		return self::CACHE_KEY .$key;
	}

	public function clearPaginateCache()
	{ 
		$cacheKey = "SECCATEGORY.ALL";
	 
        Cache::pull($cacheKey);

 		$items = Sec_category::all();
		$totalResults = count($items);

        $totalPages = ceil($totalResults/self::PAGINATE_PER_PAGE) + 1;
        for ($i=1; $i <= $totalPages; $i++) { 
          	Cache::pull($cacheKey . '.' . $i);  
        } 
	}  
}
