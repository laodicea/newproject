<?php

namespace App\Http\Controllers\Otn;
 
use App\Http\Requests\SaveNavrhZrusStnRequest;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use Facades\App\Repository\NavrhZrusStns;
use App\Model\Otn\NavrhZrusStn;
use Illuminate\Http\Request;
use Session;
use Auth;

class NavrhZrusStnController extends Controller
{
    CONST PAGINATE_PER_PAGE = 25; 
    private $rolesArray = array("otn","administrator"); 
    /**
    * Create a new controller instance.
    *
    * @return void
    */
    public function __construct()
    {
     	$this->middleware('auth');
    }
 
    /**
    * Show all draft canceled stn norms
	* @return \Illuminate\Http\Response
    */
    public function index()
    {
        $this->checkAuthorizedRoles($this->rolesArray);

    	$items = NavrhZrusStns::all('date_nav_zru');

    	return view('otn.navrh_zrus_stn.index')->withItems($items);
    }

    /**
     * Show form for draft canceled stn norm
     * @return [type] [description]
     */
    public function create()
    {
    	$this->checkAuthorizedRoles($this->rolesArray);

    	return view('otn.navrh_zrus_stn.create');
    }

    /**
     * 	Store all data from form.
     * @param  Request $request data from form 
	 * @return \Illuminate\Http\Response
     */
    public function store(SaveNavrhZrusStnRequest $request)
    {
        $this->checkAuthorizedRoles($this->rolesArray);

    	if(NavrhZrusStn::where('kat_c', $request->kat_c)->exists()){
            Session::flash('error', 'Zvolené publikačné číslo sa už v návrhu na zrušenie STN nachádza!');

            return view('otn.navzrus.create');

        }else{ 

        	NavrhZrusStns::create($request);

    		Session::flash('success', 'Návrh na zrušenie STN bol vložený do DB.');

    		return redirect()->route('navrh-zrusenia-stn.index'); 
        } 
    }

    /**
     * Show stored draft canceled stn norm
     * @param  [type] $kat_c [description]
     * @return [type]        [description]
     */
    public function show($kat_c)
    {
        $item = NavrhZrusStns::get($kat_c);

        return view('otn.navrh_zrus_stn.show')->withItem($item);
    }

    /**
     * 	Show form for draft canceled stn norm
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function edit($kat_c)
    { 
    	$item = NavrhZrusStn::find($kat_c);
  
    	return view('otn.navrh_zrus_stn.edit')->withItem($item);
    }

    /**
     * 	Update draft canceled stn norm
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function update(SaveNavrhZrusStnRequest $request,$kat_c)
    {
    	$item = NavrhZrusStn::find($kat_c);   
     
        if($item->user_id == Auth::id()){ 
            $item = NavrhZrusStns::update($request, $kat_c);  
        	  
            Session::flash('success', 'Navrh na zrušenie STN bol upravený.');
    		
            return redirect()->route('navrh-zrusenia-stn.show', $item->kat_c); 
        }else{
            Session::flash('error', 'Nie ste vlastníkom navrhu na zrušenie STN s katalógovým čislom nomry '.$kat_c. '.');
            
            return redirect()->route('navrh-zrusenia-stn.show', $item->kat_c); 
        }
    }

    /**
     * Remove the draft canceled stn norm from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($kat_c)
    { 
        $pom = NavrhZrusStns::delete($kat_c); 

        if($pom){  
            Session::flash('success', 'Položka bola zmazaná z DB!');
            return redirect()->route('navrh-zrusenia-stn.index');
        }else{
            Session::flash('error', 'Nemôžte zmazať navrh na zrušenie STN s publikčným čislom nomry '. $kat_c . ' pretože nie ste vlastníkom záznamu!');
            
            return redirect()->route('navrh-zrusenia-stn.show', $item->kat_c); 
        }
    }
 
    public function search()
    { 
        $search = Input::get('search');

        if($search != ''){ 

            $items = NavrhZrusStn::Where('kat_c','LIKE', '%'.$search.'%')->OrderBy('date_nav_zru','desc')->paginate(self::PAGINATE_PER_PAGE)->setpath(''); 

            $items->appends(array('search' => Input::get('search')));
 
            if(count($items) > 0){

                return view('otn.navrh_zrus_stn.index')->withItems($items);
            }  
            return view('otn.navrh_zrus_stn.index')->withMesage('Nebol nájdený žiadny výsledok!');
        }  
        return $this->index();
    }
}
