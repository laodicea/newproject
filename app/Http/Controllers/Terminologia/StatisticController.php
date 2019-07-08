<?php

namespace App\Http\Controllers\Terminologia;
 
use App\Http\Controllers\Controller;
use App\Model\Terminologia\Statistic;
use Facades\App\Repository\TermStatistics;
use Illuminate\Http\Request;
use DB;

class StatisticController extends Controller
{
    public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{   
		$item = TermStatistics::all(); 

		return view('terminologia.statistic.index')->withItem($item);  
	}
}
