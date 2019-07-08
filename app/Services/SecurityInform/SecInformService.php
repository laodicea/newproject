<?php

namespace App\Services\SecurityInform;
 
use App\Model\File;
use DB;
use Auth;

class SecInformService
{
	private $id; 
  
	public function __construct($secInform_id){

		$this->id  = $secInform_id; 
	}  

	/**
	 * Funkcia ktora sluzi na upload dokumentov
	 * @param  array $files       pole suborov
	 * @param  int $business_id ID pracovnej cesty
	 */
	public function uploadFiles($files){
		if($files){ 
		  	foreach ($files as $file) {
		 
		    if(!$file || !$file->isValid()) continue; 
	 
			$filepath = storage_path('sec_inform/' . $this->id);
			$filename = $file->getClientOriginalName();
			$extension = $file->getClientOriginalExtension();

			//ked uploadnem viacej rovnakych suborov tak vygenerujem pred koncovku nahodne cislo
			$filename = str_replace(".$extension", "-". rand(1111,9999). ".$extension", $file->getClientOriginalName()); 

			$sec_file = new File();
			$sec_file->user_id = Auth::id();
			$sec_file->forienkey_id = $this->id;
			$sec_file->folder = 'sec_inform';
			$sec_file->name = $filename;
			$sec_file->filename = $file->getClientOriginalName();
			$sec_file->ext = $extension;
			$sec_file->size = $file->getSize();
			$sec_file->save();  

			$file->move($filepath, $filename);
			}
		}  
	}
	/**
	 * Kontrola dokumentov ktore boli odmazane pocas uprav pracovnej cesty
	 * @param  array $newFiles dokumenty ktore prisli z requestu
	 * @param  Bi_Trip $id       id pracovnej cesty
	 * @return \Illuminate\Http\Response 
	 */
	public function changeFiles($newFiles){
		 
		$oldFiles = File::where('forienkey_id', $this->id)->where('folder','sec_inform')->pluck('id')->toArray(); 
		if($newFiles != null){
		$oldFiles = $this->arrayDiff($oldFiles, $newFiles); //subory kt. sa maju odstranit
		}
	 
		foreach ($oldFiles as $key => $value) {

			$secfile = File::find($value)->where('folder','sec_inform')->first(); 
			unlink(storage_path('sec_inform/' . $this->id . '/' . $secfile->name)); 
			$secfile->delete();
		}  
	}

	/**
     * Funkcia na zistenie rozdielu medzi dvoma polami
     *
     * @param  $array1
     * @param  $array2  
     */
    private function arrayDiff($array1, $array2){
        $newArray = array();
        foreach ($array1 as $key1 => $value1) {
            $pom = false;
            foreach ($array2 as $key2 => $value2) {
               if(($key1 == $key1) && ($value1 == $value2)){ 
                $pom = true;             
                }
            }
            if($pom == false){
                $newArray[$key1] = $value1;
            }
        }
        return $newArray;
    }

 
}
