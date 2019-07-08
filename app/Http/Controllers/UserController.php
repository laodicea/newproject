<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest; 
use Facades\App\Repository\Users;
use App\Library\UserModelExcel;
use Illuminate\Http\Request;
use App\Model\Department; 
use App\Model\Role; 
use App\User;
use Session; 
use Auth;
use Excel;
 
class UserController extends Controller
{ 
	private $rolesArray = array("administrator", "user_manager");

    public function __construct()
	{
		$this->middleware('auth'); 
	} 

	/**
	 * Funkcia na zobrazenie pouzivatelov
	 * @return \Illuminate\Http\Response 
	 */
	public function index()
	{  
		$items= Users::all('lastname');
 

		return view('user.index')->withItems($items); 
	}

	public function create()
	{
		$this->checkAuthorizedRoles($this->rolesArray);
 
		$dep = Department::pluck('name', 'id'); 
		$roles = Role::pluck('name', 'id'); 

		return view('user.create')->withDepartments($dep)->withRoles($roles); 
	}

	public function store(UpdateUserRequest $request)
	{
		$this->checkAuthorizedRoles($this->rolesArray);
		
		$user = Users::create($request); 

		Session::flash('success', 'Použivateľ '.$request->name.' bol aktualizovaný!');

		return redirect()->route('user.index');
	}

	/**
	 * Funkcia na zobrazenie formularu pouzivatela
	 * @param  int 							$id 	User->id
	 * @return \Illuminate\Http\Response 
	 */
	public function edit($id)
	{ 
		$this->checkAuthorizedRoles($this->rolesArray);
		$item = User::find($id);  
		$dep = Department::pluck('name', 'id'); 
		$roles = Role::pluck('name', 'id'); 
		
		return view('user.edit')->withItem($item)->withDepartments($dep)->withRoles($roles); 
	} 
	
	/**
	 * Funkcia na ulozenie zmien pouzivatelov
	 * @param  UpdateUserRequest 			$request
	 * @param  int           				$id      
	 * @return \Illuminate\Http\Response 
	 */
	public function update(UpdateUserRequest $request, $id)
	{
 		$this->checkAuthorizedRoles($this->rolesArray);
		
		$user = Users::update($request, $id); 
 
		Session::flash('success', 'Použivateľ '.$request->name.' bol aktualizovaný!');

		return redirect()->route('user.index');
	}

	public function show($id)
	{
		$item = Users::get($id);
		 
		return view('user.show')->withItem($item);
	}

	/**
	 * Zmazanie puzivatela. V databazi sa zmeni active na false a prida sa do mailu string zmazany. 
	 * @param  int 							$id
	 * @return \Illuminate\Http\Response 
	 */
	public function destroy($id){
		$this->checkAuthorizedRoles($this->rolesArray);
		
		$item = Users::delete($id);

	    Session::flash('success', 'Používateľ "'.  $item->fullname() .'" bol odstránený!');
	    
	    return redirect()->route('user.index'); 
	}

	/**
	 * Zoradenie pouzivatelov po jednotlivych oddeleniach
	 * @return \Illuminate\Http\Response 
	 */
	public function usersByDepartment(){ 
		$items = Department::orderBy('value', 'ASC')->where('active', 1)->paginate(25);  
		return view('user.userByDepartment')->withItems($items);
	}

    /**
     * Generovanie excel dokumentu pouzivatelov
     * @return xls document
     */
	public function getExcel(){
		$data = User::orderBy('lastname')->where('active', 1)->get();
    	$data1 =  array();
    	foreach ($data as $key => $item) {
	        $user = new UserModelExcel();
	        $user->meno = $item->lastname . " ". $item->name . ", " . $item->degree; 
	        $user->klapka = $item->phone; 
	        $user->kancelaria = $item->room;
	        if(empty($item->department)){
				$user->odbor =" ";
	        }else{
	        	$user->odbor = $item->department->short;
	        }  
	         
       		array_push($data1,(array) $user); 
    	} 

    	$nameExcel = "pouzivatelia_". date("d_m_y");

    	return Excel::create($nameExcel, function($excel) use ($data1) {
        $excel->sheet('mySheet', function($sheet) use ($data1)
        {
            $sheet->fromArray($data1);
        });})->download('xlsx'); 
	}
} 
