<?php

namespace App\Http\Controllers\SecurityInform;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveInformCategoryRequest; 
use App\Model\SecurityInform\Sec_category;
use Facades\App\Repository\SecCategories;
use Illuminate\Support\Facades\Input;
use Session;

class SecurityCategoryController extends Controller
{
    private $rolesArray = array("administrator", "security_inform");
    CONST PAGINATE_PER_PAGE = 40; 

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
     * Zobrazenie položky.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = SecCategories::all('name');   

        return view('securityinform.category.index')->withItems($items); 
    }  

     /**
     * Uloženie formuláru položky
     *
     * @param  App\Http\Requests\SaveDepartmentlRequest  $request
     * @return \Illuminate\Http\Response
     */
     public function store(SaveInformCategoryRequest $request)
     {   
        $this->checkAuthorizedRoles($this->rolesArray);

        if(Sec_category::where('name', $request->name)->exists()){
         Session::flash('error', 'Zvolený názov kategórie informačnej bezpečnosti už existuje v DB!');

         return view('securityinform.category.create');

     } else{  
        SecCategories::create($request);

        Session::flash('success', 'Nová kategória informačnej bezpečnosti bola vytvorená!');

        return redirect()->route('security-category.index');
    }  
    } 
    /**
     * Zobrazenie položky
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        $item = SecCategories::get($id); 

        return view('securityinform.category.show')->withItem($item);
    }

     /**
     * Zobrazenie formuláru pre editáciu položky.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
     public function edit($id)
     {
        $this->checkAuthorizedRoles($this->rolesArray);

        $item = Sec_category::find($id); 

        return view('securityinform.category.edit')->withItem($item);
    }
    /**
     * Update upravenej položky.
     *
     * @param  App\Http\Requests\SaveDepartmentRequest   $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveInformCategoryRequest $request, $id)
    {   
        $this->checkAuthorizedRoles($this->rolesArray); 

        if(Sec_category::where('name', $request->name)->where('id', '!=', $id)->exists()){

            Session::flash('error', 'Zvolený názov sa už v kategórie informačnej bezpečnosti nachádza!');
            
            return redirect()->route('securityinform.category.edit', $request->id);
        }

        $item = SecCategories::update($request, $id);  

        Session::flash('success', 'Položka bol aktualizovaná!');

        return redirect()->route('security-category.show', $item->id);
    } 
     /**
     * Nastavenie value active na false;
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
     { 
        $this->checkAuthorizedRoles($this->rolesArray);

        $item = Sec_category::find($id);
        if($item->securityInforms()->count() == 0){

            SecCategories::delete($id);
            
            Session::flash('success', 'Kategória z informačnej bezpečnosti bola odstránená!');

            return redirect()->route('security-category.index');
        }else{
            Session::flash('warning', 'Kategória z informačnej bezpečnosti môže byť odstránena ak všetky oznamy ktoré obsahuje budu zmazané!');

            return redirect()->route('security-category.index');
        }
        
    }  

    public function search()
    { 
        $search = Input::get('search');

        if($search != ''){ 

            $items = Sec_category::where('name', 'LIKE', '%'.$search.'%')->paginate(self::PAGINATE_PER_PAGE)->setpath(''); 

            $items->appends(array('search' => Input::get('search')));
            if(count($items) > 0){
                return view('securityinform.category.index')->withItems($items);
            }
            return view('securityinform.category.index')->withMesage('Nebol nájdený žiadny výsledok!');

        }
        return $this->index();
    }
}
