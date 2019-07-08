<?php

namespace App\Services\Elearning;

use App\Library\ObjectForTags;
use App\Bi_Trip_Keyword;
use App\Bi_Trip;
use App\Slovnik;
use App\Wiki;
use DB;

class TagService
{
	private $id; 

 	public $margeObjects;

	public function __construct($tag_id){

		$this->id  = $tag_id; 
	}  

	private function getBiTrips(){

		$universalObjects = array(); 
		$tagsIds = Bi_Trip_Keyword::where('tag_id', $this->id)->get();

		foreach($tagsIds as $item){
			$trip = Bi_Trip::find($item->business_trip_id);
			
			$universalObj = new ObjectForTags;
			$universalObj->title = $trip->title;
			$universalObj->id    = $trip->id;
			$universalObj->tags  = $trip->keywordsPluck();
			$universalObj->typee = 'busines-trip/';
			$universalObj->url   = $trip->id;
 
			array_push($universalObjects, $universalObj);
		} 
		return $universalObjects;
	}

	private function getSlovniks(){
		$universalObjects = array(); 
		$tagsIds =  DB::table('slovnik_tag')->where('tag_id', $this->id)->get();

		foreach($tagsIds as $item){
			$slovnik= Slovnik::find($item->slovnik_id);
			
			$universalObj = new ObjectForTags;
			$universalObj->title = $slovnik->title;
			$universalObj->id    = $slovnik->id;
			$universalObj->tags  = $slovnik->keywordsPluck();
			$universalObj->typee = 'elearning/slovnik/';
			$universalObj->url   = $slovnik->url_link;	

			array_push($universalObjects, $universalObj);
		} 
		return $universalObjects;
	}

	private function getWikis(){
		$universalObjects = array(); 
		$tagsIds =  DB::table('tag_wiki')->where('tag_id', $this->id)->get();

		foreach($tagsIds as $item){
			$wiki = Wiki::find($item->wiki_id);
			
			$universalObj        = new ObjectForTags;
			$universalObj->title = $wiki->name." - ".$wiki->name_en;
			$universalObj->id    = $wiki->id;
			$universalObj->tags  = $wiki->keywordsPluck();
			$universalObj->typee = 'elearning/wiki/';
			$universalObj->url   = $wiki->url_link;	

			array_push($universalObjects, $universalObj);
		} 
		return $universalObjects;
	}

	public function mergeAll(){
 
		$trips        = $this->getBiTrips(); 
		$slovniks     = $this->getSlovniks();
		$wikis    	  = $this->getWikis(); 

		return array_merge($trips, $slovniks, $wikis);
	}
}
