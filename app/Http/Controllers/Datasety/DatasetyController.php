<?php

namespace App\Http\Controllers\Datasety;

use Illuminate\Support\Facades\Storage; 
use App\Http\Controllers\Controller; 
use App\Model\Datasety\Objednavky;
use App\Model\Datasety\Faktury;
use Illuminate\Http\Request;  
use Session; 
use Auth;


class DatasetyController extends Controller
{
	CONST PAGINATE_PER_PAGE = 2; 
    private $rolesArray = array("datasety_manager","administrator"); 

    public function __construct()
    {
        $this->middleware('auth');
    }  
  
    public function createObjednavky()
    {  
        $this->checkAuthorizedRoles($this->rolesArray);

        return view('datasety.objednavky.upload');
    }

    public function uploadObjednavky(Request $request)
    {
        $this->checkAuthorizedRoles($this->rolesArray);

        $objednavky =  new Objednavky();
        
        $pom = $objednavky->loadXmlObjednavky($this->uploadFiles($request->file('uploaded_files'), "objednavky"));

         if ($pom) {

            Session::flash('success', 'Objednávky boli nahrané do DB!');
     
            return redirect()->route('objednavky.show');  
 
        }else{ 
            Session::flash('success', 'Objednávky neboli importovane do DB! Pravdepodobne ste vložili zlý XML súbor');  
            
            return redirect()->route('objednavky.show');   
        }  
    }
   
    public function createFaktury()
    {
        $this->checkAuthorizedRoles($this->rolesArray);

        return view('datasety.faktury.upload');
    }

    public function uploadFaktury(Request $request)
    {
        $this->checkAuthorizedRoles($this->rolesArray);

        $faktury = new Faktury();
       
        $pom = $faktury->loadXmlFaktury($this->uploadFiles($request->file('uploaded_files'), "faktury"));
       
        if($pom){ 
            
            Session::flash('success', 'Faktúry boli nahrané do DB!');
     
            return redirect()->route('faktury.show');  

        }else{ 
            Session::flash('success', 'Faktúry neboli importovane do DB! Pravdepodobne ste vložili zlý XML súbor');  
 
            return redirect()->route('faktury.show');  
        }  
 
    } 

    /**
     * Funkcia ktora sluzi na upload dokumentov
     * @param  one array $file     pole jedneho suboru 
     */
    private function uploadFiles($file, $folder)
    { 
      	if($file){  
  
	        $filepath = storage_path('datasety/' . $folder);
	        $filename =  $file[0]->getClientOriginalName();
	        $extension = $file[0]->getClientOriginalExtension();
	 
	        $file[0]->move($filepath, $filename);
	        return $filename; 
        }   
    }  
}
