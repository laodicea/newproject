<?php

namespace App\Http\Controllers\Terminologia;

use App\Http\Requests\SaveTadRequest;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Model\Terminologia\Terms; 
use Illuminate\Http\Request;
use Session;
use Auth; 

class TermsController extends Controller
{
	private $rolesArray = array("term-tad","administrator"); 
	CONST PAGINATE_PER_PAGE = 25; 

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
	
		$items = Terms::where('old',true)->OrderBy('created_at','decs')->paginate(self::PAGINATE_PER_PAGE);

		return view('terminologia.tad.index')->withItems($items);  
	}

	/**
	* zobrazenie formuláru pre vloženie starých termínov a definícií
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{     
		$this->checkAuthorizedRoles($this->rolesArray);
		
		return view('terminologia.tad.create');
	}

	/**
	* Vytvorenie TaD.
	*
	* @param  App\Http\Requests\Request  $request
	* @return \Illuminate\Http\Response
	*/
	public function store(SaveTadRequest $request)
	{    
		$this->checkAuthorizedRoles($this->rolesArray);

		$item = new Terms(); 
		$item->kat_c = $request->kat_c;
		$item->skterm = $request->skterm;
		$item->skdef = $request->skdef;
		$item->sknote = $request->sknote;
		$item->enterm = $request->enterm;
		$item->endef = $request->endef;
		$item->ennote = $request->ennote; 
		$item->user_id = Auth::id();
		$item->old = true;

		$item->save();

		Session::flash('success', 'Nový termín a definícia boli vložené do TDB');

		return redirect()->route('tad.show', $item->id); 
	}

	public function show($id){
		$this->checkAuthorizedRoles($this->rolesArray);
    	
        $item = Terms::find($id);

        return view('terminologia.tad.show')->withItem($item); 
	}

	public function edit($id){

		$this->checkAuthorizedRoles($this->rolesArray);
		
		$item = Terms::find($id);

		return view('terminologia.tad.edit')->withItem($item); 
	}

	public function update(SaveTadRequest $request, $id){

		$this->checkAuthorizedRoles($this->rolesArray); 

		$item = Terms::find($id); 
		$item->kat_c = $request->kat_c;
		$item->skterm = $request->skterm;
		$item->skdef = $request->skdef;
		$item->sknote = $request->sknote;
		$item->enterm = $request->enterm;
		$item->endef = $request->endef;
		$item->ennote = $request->ennote; 
		$item->user_id = Auth::id();
		$item->old = true;
		$item->save();

		Session::flash('success', 'Termíny a definície boli v TDB upravené.');
		return redirect()->route('tad.show', $item->id);
	}

	 public function destroy($id)
	 {
	 	$this->checkAuthorizedRoles($this->rolesArray); 

     	$item = Terms::find($id);  
        $item->delete(); 
        
     	Session::flash('success', 'TaD bol odstránený!');

     	return redirect()->route('tad.index');
    } 

    public function search()
    {
    	$this->checkAuthorizedRoles($this->rolesArray);

    	$search = Input::get('search');

    	if($search != ''){ 
    		$items = Terms::where('kat_c','LIKE', '%'.$search.'%')->where('old',true)->OrderBy('created_at','desc')->paginate(self::PAGINATE_PER_PAGE)->setpath(''); 

    		$items->appends(array('search' => Input::get('search')));
			if(count($items) > 0){

    	 		return view('terminologia.tad.index')->withItems($items);
    		}  
    		return view('terminologia.tad.index')->withMesage('Nebol nájdený žiadny výsledok!');
    	}  
    	return $this->index();
    }
}
