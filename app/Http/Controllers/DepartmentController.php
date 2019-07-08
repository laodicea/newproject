<?php

namespace App\Http\Controllers;
 
use App\Http\Requests\SaveDepartmentRequest;
use Facades\App\Repository\Departments;
use Illuminate\Http\Request;
use App\Model\Department;
use App\Model\Role;
use App\User;
use Session;
use DB; 

class DepartmentController extends Controller
{
    private $rolesArray = array("administrator", "department_manager");
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
     * Zobrazenie odborov podľa hodnoty value a active true.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    
       $department = Departments::all('value');

    	return view('department.index')->withDepartments($department); 
    } 
    /**
     * Zobrazenie formuláru pre vytvorenie odobru.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){  
    	$this->checkAuthorizedRoles($this->rolesArray);

        $allusers = User::select(
                       DB::raw("CONCAT(lastname,' ',name) AS name"),'id')->where('active', 1)->orderBy('lastname')
                       ->pluck('name', 'id');

        $users = $allusers;
        $users->prepend('Vyberte .. ', '0');

        $orgs = Department::pluck('name', 'id');
        $orgs->prepend('Vyberte .. ', '0');

    	return view('department.create')->withUsers($users)->withOrgs($orgs)->withBossusers($allusers);
    }

     /**
     * Uloženie odboru
     *
     * @param  App\Http\Requests\SaveDepartmentlRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveDepartmentRequest $request){   

     	$this->checkAuthorizedRoles($this->rolesArray); 

     	if(Department::where('short', $request->short)->exists()){
     		Session::flash('error', 'Zvolená skratka oddelenia-odboru už existuje v DB!');
              
     		return view('department.create');

     	} else{ 
     		$item = Departments::create($request);
  
            Session::flash('success', 'Nové oddelenie bolo vytvorené!');
           
     		return redirect()->route('department.show', $item->id);
     	}  
    } 
    /**
     * Zobrazenie odboru.
     * 
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
    	$this->checkAuthorizedRoles($this->rolesArray);
    	
        $item = Departments::get($id); 
        $myorgs = $item->getAllPodriadene(); 
        
    	return view('department.show')->withItem($item)->withMyorgs($myorgs);
    }

     /**
     * Zobrazenie formuláru pre editáciu odboru.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */ 
    public function edit($id){
        $this->checkAuthorizedRoles($this->rolesArray);

     	$item = Department::find($id);
        $item->boss = $item->getBossSekretarId('riadiaci pracovnik');
        $item->zastupca = $item->getBossSekretarId('zastupca');
        
        $myorgs = $item->getAllPodriadene(); 
       
        $allUsers = User::select(
                       DB::raw("CONCAT(lastname,' ',name) AS name"),'id')->where('active', 1)->orderBy('lastname')
                       ->pluck('name', 'id'); 
        $users = $allUsers;
        $users->prepend('Vyberte .. ', '0');

        $bossUsers = $allUsers;
   
        $orgs = Department::pluck('name', 'id');
        $orgs->prepend('Vyberte .. ', '0');
          
       // $withoutmyorgs = $this->arrayDiff($orgs, $myorgs); 
    
     	return view('department.edit')->withItem($item)->withUsers($users)->withOrgs($orgs)->withMyorgs($myorgs)->withBossusers($bossUsers);
    }
    /**
     * Update upraveného odboru.
     *
     * @param  App\Http\Requests\SaveDepartmentRequest   $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveDepartmentRequest $request, $id)
    {   
    	$this->checkAuthorizedRoles($this->rolesArray);
         
        if(Department::where('short', $request->short)->where('id', '!=', $id)->exists()){
         
            Session::flash('error', 'Zvolená skratka sa už v aplikácií nachádza!');
            
            return redirect()->route('department.edit', $request->id);
        }
        if($request->short_kniha != null){
            if(Department::where('short_kniha', $request->short_kniha)->where('id', '!=', $id)->exists()){
                Session::flash('error', 'Zvolená skratka sa už v aplikácií nachádza!');
                
                return redirect()->route('department.edit', $request->id);
            }
        } 
        $item = Departments::update($request, $id);

   		Session::flash('success', 'Objekt bol aktualizovaný!');

   		return redirect()->route('department.show', $item->id);
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

     	$item = Departments::delete($id);
        
     	Session::flash('success', 'Oddelenie bolo odstránené!');

     	return redirect()->route('department.index');
    }  
     /**
     * Funkcia pre zmzanie z tabulky role_user vztahy na zaklade department_id a role_id
     *
     * @param  int  $department_id
     */
    private function deleteRoleUser($department_id, $role_id){
        
        $user_role = DB::table('role_user')->where('department_id', $department_id)->where('role_id', $role_id)->delete(); 
    } 
 }
 
