<?php

namespace App\Model\Datasety;

use Illuminate\Support\Facades\Storage; 
use Illuminate\Database\Eloquent\Model;
use XmlParser;
use DB;

class Objednavky extends Model
{
    protected $table = 'objednavkies';
    protected $primaryKey = 'cislo'; 
    public $incrementing = false;
    public $timestamps  = false;
    protected $fillable = ['cislo','dodavatel','predmet','sumasdph','datum','zmluva','schvalil','mena'];

    public function loadXmlObjednavky($fileName)
    { 
    	if (strpos($fileName, 'objednavky') !== false) {
	    	$content = storage_path('datasety/objednavky/'.$fileName);
		    $xml = XmlParser::load($content); 
		    $products = $xml->getContent();
		    $objednavky = $xml->parse(['objednavka' =>
		            ['uses' => 'objednavka[cislo,dodavatel,predmet,sumasdph,datum,zmluva,schvalil,mena]'],
		        ]);
		            foreach ($objednavky['objednavka'] as $key => $value) {
		               
		                $obj = Objednavky::updateOrCreate(['cislo' => $value['cislo']],[
		                    'dodavatel' => $value['dodavatel'],
		                    'predmet' => $value['predmet'],
		                    'sumasdph' => $value['sumasdph'],
		                    'datum' => $value['datum'],
		                    'zmluva' => $value['zmluva'],
		                    'schvalil' => $value['schvalil'],
		                    'mena' => $value['mena']]);
		                   
		            } 
		    DB::select(DB::raw('CALL copy_objednavky_dataset()'));
		    
		    return true;
		
		}else {

			return false; 
		}
	    
	}	            
}
