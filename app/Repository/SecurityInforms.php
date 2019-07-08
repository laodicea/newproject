<?php
namespace App\Repository;
 
use App\Services\SecurityInform\SecInformService;
use App\Model\SecurityInform\Security_inform;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Facades\App\Repository\Users;
use App\Model\Notification; 
use App\Model\File;
use Carbon\Carbon; 
use Session;
use Auth;
 
class SecurityInforms
{
	CONST CACHE_KEY = 'SECINFORM';
	CONST PAGINATE_PER_PAGE = 40; 

	public function update($request, $slug)
	{ 
		$cacheKey = "SECINFORM.{$slug}"; 

		$item = Security_inform::where('slug', $slug)->first();
		$item->title = $request->title;
		$item->description = $request->description;
		$item->securitycategories_id = $request->securitycategories_id;
		$item->save();

		$uploadFile = new SecInformService($item->id);
		$uploadFile->changeFiles($request->listFiles);
		$uploadFile->uploadFiles($request->file('uploaded_files'));

		Cache::pull($cacheKey);
 		$this->clearPaginateCache();  
	}

	public function create($request, $slug)
	{ 
		$item = new Security_inform();
 		$item->title = $request->title;
		$item->description = $request->description;
		$item->user_id = Auth::id();
		$item->securitycategories_id = $request->securitycategories_id;
		$item->slug = $slug;
		$item->save();

		$uploadFile = new SecInformService($item->id);
		$uploadFile->uploadFiles($request->file('uploaded_files'));

        $this->clearPaginateCache(); 

        return $item;
	}

	public function all($orderBy)
	{	
		$cacheKey = "SECINFORM.ALL";  

		$currentPage = Input::get('page') ? Input::get('page') : '1'; 

		return Cache::rememberForever($cacheKey.'.'.$currentPage,  function() use($orderBy) {
		    return Security_inform::orderBy($orderBy,'AES')->paginate(self::PAGINATE_PER_PAGE);
		    
		});
	}

	public function get($slug)
	{
		$cacheKey = "SECINFORM.{$slug}";

		$item = Security_inform::where('slug', $slug)->first();
		$item->files = File::where('forienkey_id',$item->id)->where('folder','sec_inform')->get(); 
		$item->setAsRead($slug); 
  
		return Cache::rememberForever($cacheKey, function() use($item){

			return $item;   
		}); 
	}

	public function delete($slug)
	{
		$cacheKey = "SECINFORM.{$slug}";

		$sec = Security_inform::where('slug', $slug)->first(); 
		$sec->delete();

		$items = File::where('forienkey_id',$sec->id)->where('folder','sec_inform')->get();
		foreach ($items as $key => $item) {
			$item->delete();
		}
		\File::deleteDirectory(storage_path("sec_inform/{$sec->id}") );

        Cache::pull($cacheKey);
        $this->clearPaginateCache();  
	}

	public function getCacheKey($value)
	{
		$key = strtoupper($value);
		return self::CACHE_KEY .$key;
	}

	public function clearPaginateCache()
	{ 
		$cacheKey = "SECINFORM.ALL";
		
        Cache::pull($cacheKey);

 		$items = Security_inform::all();
		$totalResults = count($items);

        $totalPages = ceil($totalResults/self::PAGINATE_PER_PAGE) + 1;
        for ($i=1; $i <= $totalPages; $i++) { 
          	Cache::pull($cacheKey . '.' . $i);  
        } 
	}  
}
