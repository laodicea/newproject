<?php
namespace App\Repository;
 
use App\Model\SecurityInform\Sec_category;
use App\Model\Terminologia\Statistic;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use App\Library\TermStatisticModel;
use Carbon\Carbon; 
use Session;
 
class TermStatistics
{
	CONST CACHE_KEY = 'STATISTIC.TERM.'; 
 
	public function all()
	{	
		$cacheKey = self::CACHE_KEY . "ALL"; 

     return Cache::remember($cacheKey, Carbon::now()->endOfDay(), function() {

     	 $items = Statistic::get(); 
		 $stat = new TermStatisticModel();

		foreach ($items as $item) { 

			 if($item->name == 'users'){ 
			 	$stat->user = $item->num;   
			 }

			 if($item->name == 'terms'){
			  
			 	$stat->term = $item->num; 
			 }

			 if($item->name == 'norms'){
			 	 
			 	$stat->norm = $item->num; 
			 }

			 if($item->name == 'activeuser'){
			 
			 	$stat->activeuser = $item->num; 
			 } 
		}  
		 return $stat; 
		}); 
	}
  
}
