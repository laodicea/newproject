<?php

namespace App\Model\Datasety;

use Illuminate\Support\Facades\Storage; 
use Illuminate\Database\Eloquent\Model;
use XmlParser;
use DB;

class Faktury extends Model
{
    protected $table = 'fakturies';
    protected $primaryKey = 'cislo'; 
    public $incrementing = false;
    public $timestamps  = false;
    protected $fillable = ['cislo','dodavatel','predmet','sumasdph','datum','objednavka','mena'];

    public function loadXmlFaktury($fileName){

		if (strpos($fileName, 'faktury') !== false) {
	        $content = storage_path('datasety/faktury/'.$fileName);
	        $xml = XmlParser::load($content); 
	        $products = $xml->getContent();
	        $faktury = $xml->parse(['faktura' =>
	            ['uses' => 'faktura[cislo,dodavatel,predmet,sumasdph,datum,objednavka,mena]'],
	        ]);
	            foreach ($faktury['faktura'] as $key => $value) {
	               
	                $obj = Faktury::updateOrCreate(['cislo' => $value['cislo']],[
	                    'dodavatel' => $value['dodavatel'],
	                    'predmet' => $value['predmet'],
	                    'sumasdph' => $value['sumasdph'],
	                    'datum' => $value['datum'],
	                    'objednavka' => $value['objednavka'], 
	                    'mena' => $value['mena']]);
	                   
	            }   
	            DB::select(DB::raw('CALL copy_faktury_dataset()'));
	        return true;
		}else{
			return false;
		}
	}

}
