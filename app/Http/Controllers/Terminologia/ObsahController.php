<?php

namespace App\Http\Controllers\Terminologia;

use App\Http\Requests\UpdateObsahRequest;
use App\Http\Requests\SaveObsahRequest;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Model\Terminologia\Obsahs;
use Illuminate\Http\Request;
use Session;
use Auth;

class ObsahController extends Controller
{
	CONST PAGINATE_PER_PAGE = 25; 
	private $rolesArray = array("term-obsahy","administrator"); 
    /**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{ 
		$this->checkAuthorizedRoles($this->rolesArray);

		$items = Obsahs::OrderBy('created_at','desc')->paginate(self::PAGINATE_PER_PAGE);
 
		return view('terminologia.obsah.index')->withItems($items);  
	}
	 /**
	  * Náhľad obsahu
	  * @param  integer $kat_c katalógové číslo
	  * @return \Illuminate\Http\Response
	  */
	public function show($kat_c)
	{
		$this->checkAuthorizedRoles($this->rolesArray);

		$item = Obsahs::where('kat_c',$kat_c)->first();

		return view('terminologia.obsah.show')->withItem($item);
	}

	/**
	* zobrazenie formuláru pre vytvorenie obsahu
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{     
		$this->checkAuthorizedRoles($this->rolesArray);

		return view('terminologia.obsah.create');
	}

	/**
	* Uloženie vytvoreného obsahu
	*
	* @param  App\Http\Requests\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(SaveObsahRequest $request)
	{   
		$this->checkAuthorizedRoles($this->rolesArray);
 	  
	  	if(Obsahs::where('kat_c', $request->kat_c)->exists()){ 
	  		
	  		Session::flash('error', 'Zvolené katalógove číslo "'. $request->kat_c.'" je už zapísane v databáze. Katalógove číslo môže mať len jeden obsah!');
		
			return view('terminologia.obsah.create');
	  			
 		}else{
 			if( Obsahs::withTrashed()->find($request->kat_c)){
 			 
				Session::flash('error', 'Zvolené katalógove číslo "'. $request->kat_c.'" je v DB ako zmazane. Ak si prajete obnoviť tento záznam kontaktujte administrátora informačného systému!');
		
				return view('terminologia.obsah.create');
			
			}else{
				 
				$item = new Obsahs(); 
				$item->kat_c = $request->kat_c;
				$item->obsah = $request->obsah;
				$item->user_id = Auth::id();  
				$item->save();

				Session::flash('success', 'Obsah bol vložený pod katalógovým číslom "' . $item->kat_c . '" do DB');
				return redirect()->route('obsahy.index'); 
	   		}
 		} 
	}

	/**
	* Zobrazenie formuláru pre editovanie prípadu.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function edit($kat_c) 
	{ 
		$this->checkAuthorizedRoles($this->rolesArray);

		$item = Obsahs::where('kat_c', $kat_c)->first();
		 
		return view('terminologia.obsah.edit')->withItem($item);
	}

	/**
	* Update prípadu.
	*
	* @param  App\Http\Requests\UpdateCasemodelRequest  $request
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function update(UpdateObsahRequest $request, $kat_c)		
	{ 
		$this->checkAuthorizedRoles($this->rolesArray);
	 
		$item = Obsahs::where('kat_c', $kat_c)->first();
		$item->kat_c = $request->kat_c;
		$item->obsah = $request->obsah; 
		$item->user_id = Auth::id(); 
		$item->save();

		Session::flash('success', 'Zmeny v obsahu boli aktualizované!');

		return redirect()->route('obsahy.index');  
	} 

	/**
	* Soft delete prípadu.
	*
	* @param  int  $id
	* @return \Illuminate\Http\Response
	*/
	public function destroy($kat_c)
	{
		$this->checkAuthorizedRoles($this->rolesArray);

		$item = Obsahs::where('kat_c', $kat_c)->first();
		$item->delete();
 
		Session::flash('success', 'Obsah katalógovým číslom "'.  $item->kat_c .'" bol odstránený!');

		return redirect()->route('obsahy.index');
	}
 
	public function search()
    {
    	$this->checkAuthorizedRoles($this->rolesArray);

    	$search = Input::get('search');

    	if($search != ''){ 

    		$items = Obsahs::where('kat_c', 'LIKE', '%'.$search.'%')->paginate(self::PAGINATE_PER_PAGE)->setpath(''); 

    		$items->appends(array('search' => Input::get('search')));
 
			if(count($items) > 0){

    	 		return view('terminologia.obsah.index')->withItems($items);
    		}  
    		return view('terminologia.obsah.index')->withMesage('Nebol nájdený žiadny výsledok!');
    	}  
    	return $this->index();
    }
}
