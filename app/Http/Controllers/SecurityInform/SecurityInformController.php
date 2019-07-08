<?php

namespace App\Http\Controllers\SecurityInform;

use App\Http\Requests\UpdateSecurityInformRequest; 
use App\Services\SecurityInform\SecInformService;
use App\Http\Requests\SaveInformSecurityRequest;
use App\Model\SecurityInform\Security_inform;
use App\Model\SecurityInform\Sec_category;
use Facades\App\Repository\SecCategories;
use Facades\App\Repository\SecurityInforms;
use Illuminate\Support\Facades\Input;
use App\Notifications\SecurityInform;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Facades\App\Repository\Users;
use App\Model\Notification; 
use App\Model\File;
use App\User;
use Session; 
use Auth;

class SecurityInformController extends Controller
{
		private $rolesArray = array("administrator", "security_inform");
	CONST PAGINATE_PER_PAGE = 40; 

   	public function __construct()
	{
		$this->middleware('auth');
	} 
 
    /**
     * Zobrazenie všetkých zahraničných ciest podľa dátumu začatia, ale iba tie ktoré boli schválene. 
     * @return \Illuminate\Http\Response
     */
	public function index()
	{
		$items = SecurityInforms::all('created_at');
		$types = SecCategories::all('name'); 
  
		return view('securityinform.index')->withItems($items)->withTypes($types);
	} 

	public function create(){ 
		$this->checkAuthorizedRoles($this->rolesArray);
		$category = Sec_category::pluck('name','id');

		return view('securityinform.create')->withCategory($category);
	}

	public function store(SaveInformSecurityRequest $request)
	{
		$this->checkAuthorizedRoles($this->rolesArray);
       	
       	$slug = str_slug($request->title, '-');
     	if(Security_inform::where('slug', $slug)->exists()){
     		Session::flash('error', 'Zvolený názov v ozname informačnej bezpečnosti už existuje!');
              
     		return  redirect()->route('security-inform.create');

     	} else{ 
			SecurityInforms::create($request, $slug);
			
			Session::flash('success', 'Nový oznam informačnej bezpečnosti bol vytvorený!');
	           
	     	return redirect()->route('security-inform.index');
     	}
	}

	public function show($slug)
	{ 
		$id = Auth::id();
		Users::clearMyNotifications($id);
		Users::clearNumNotifications($id);

		$item = SecurityInforms::get($slug);
		 
		return view('securityinform.show')->withItem($item);;
	}

	public function edit($slug){
		$this->checkAuthorizedRoles($this->rolesArray);
		$item = Security_inform::where('slug', $slug)->first();
		
		$category = Sec_category::pluck('name','id');
		$files = File::where('forienkey_id',$item->id)->where('folder','sec_inform')->get();

		return view('securityinform.edit')->withItem($item)->withCategory($category)->withFiles($files);
	}

	public function update(UpdateSecurityInformRequest $request, $slug){
		$this->checkAuthorizedRoles($this->rolesArray);

		SecurityInforms::update($request, $slug);
 
		Session::flash('success', 'Oznam informačnej bezpečnosti bol upravený!');
	           
	    return redirect()->route('security-inform.show',$slug);
	}

	public function destroy($slug){
		$this->checkAuthorizedRoles($this->rolesArray);

		SecurityInforms::delete($slug);
		 
		Session::flash('success', 'Oznam informačnej bezpečnosti bol odstránený!');
	    
	    return redirect()->route('security-inform.index'); 
	}

	/**
     * Funkcia stiahnutiu dokumentu z informačnej bezpečnosti.
     *
     * @param int 	id_bussines_trip
     * @param string   filename
     * @return name of uploaded $file
     */
    public function download($slug, $filename){
    	$item = Security_inform::where('slug', $slug)->first();

        return response()->download(storage_path("sec_inform/{$item->id}/{$filename}"));
    }

    /**
     * Vyhladavanie podľa kategórie
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function filterByCategory()
    {
    	$search = Input::get('search');
    	$type = Input::get('type');
  
	    if($type === null || $type == 'Všetky'){ 
	    	$type = "Všetky"; 
	    }else{
	    	$type = Sec_category::select('id')->where('name', $type)->first();
	    }
 
	    $types = Sec_category::all();
	  
		if($type == "Všetky" && $search != null){
		 
			$items = Security_inform::where(function ($q) use ($search) {
	           $q->where('title','LIKE','%'.$search.'%')
	             ->orWhere('description','LIKE','%'.$search.'%');
	         })->orderBy('created_at','DESC')->paginate(self::PAGINATE_PER_PAGE)->setpath('');
			
		}elseif($type == "Všetky" && $search == null){
		 
			return $this->index();

		}elseif($type != "Všetky" && $search != null){   
	 
			$items = Security_inform::where('securitycategories_id', $type->id)->where(function ($q) use ($search) {
	           $q->where('title','LIKE','%'.$search.'%')
	             ->orWhere('description','LIKE','%'.$search.'%');
	        })->orderBy('created_at','DESC')->paginate(self::PAGINATE_PER_PAGE)->setpath(''); 

		} elseif($type != "Všetky" && $search == null){ 
		 
			$items = Security_inform::where('securitycategories_id', $type->id)->orderBy('created_at','DESC')->paginate(self::PAGINATE_PER_PAGE)->setpath('');
		}else{
			dd("nezname");
		}  

		$items->appends(array('search' => Input::get('search'),'type' => Input::get('type')));

		if(count($items) > 0){
                return view('securityinform.index')->withItems($items)->withTypes($types)->withSearch($search);
        }
        return view('securityinform.index')->withMesage('Nebol nájdený žiadny výsledok!')->withTypes($types)->withSearch($search);		
   } 

   public function notify($slug)
   {
   	   	$this->checkAuthorizedRoles($this->rolesArray);
	   	
	   	$item = Security_inform::where('slug', $slug)->first();
	    
	    $users = User::all();
	    foreach ($users as $key => $value) {
	    	$value->notify(new SecurityInform($item->title, $item->description, $item->category()->name, $item->slug ,'security-inform/'.$item->slug));
	    } 
        
        foreach ($users as $key => $value) {
              Users::clearAllNotifications($value->id);
        }
	 
	   	Session::flash('warning', 'Oznam informačnej bezpečnosti bol odoslaný všetkym zamestnancom úradu!');
		           
		return redirect()->route('security-inform.show',$slug);
	} 
}
