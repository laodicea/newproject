<?php
namespace App\Http\Controllers\Rezervacie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Rezervacie\Calendar_event; 
use App\Model\Rezervacie\Reserve_room;
use App\Model\Color; 
use Calendar;
use Session;
use Auth;

class RezervacieController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	 /**
 	* Zobrazenie miestnosti
 	*
 	* @return \Illuminate\Http\Response
 	*/
 	public function index()
 	{   
 		if(Reserve_room::count()>0){
 			$room = Reserve_room::orderBy('created_at','asc')->first();

 			$items = Reserve_room::orderBy('name','asc')->get(); 
 			$rooms = array();
 			foreach ($items as $value) {
 				$rooms[$value->id] = $value->name;
 			}

 			$colorsFromDb = Color::orderBy('color', 'asc')->get();
 			$colors = array();
 			foreach ($colorsFromDb as $key => $value) { 
 				$colors[$value->id] = $value->color;
 			}

 			return $this->showCalendar($room->id);  
 		}else{
 			return view('rezervacia.index')->withItems(null)->withCalendar(null)->withRooms(null)->withCurroom(null)->withIdselect(null); 
 		}
 	}
 
	 /**
	 * Zobrazenie miestnosti s kalendarom
	 *
	 * @return \Illuminate\Http\Response
	 */
	 public function showCalendar($id)
	 {   
	 	$items = Reserve_room::orderBy('name','asc')->get();  
	 	$rooms = array();
	 	foreach ($items as $value) {
	 		$rooms[$value->id] = $value->name;
	 	}
	 	$room = Reserve_room::find($id);

	 	return view('rezervacia.index')->withItems($items)->withCalendar($this->getCalendar($id))->withRooms($rooms)->withCurroom($room->name)->withIdselect($id);  
	 }

	/**
	 * Uloženie Casemodel-prípadu
	 *
	 * @param  App\Http\Requests\CreateCasemodelRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{   
		$this->validate($request, array(
			'name' => 'required|max:150'));

		$room = new Reserve_room();
		$room->name = $request->name;  
		$room->note = $request->name;  
		$room->user_id = Auth::id();
		$room->save();   

		Session::flash('success', 'Nová miestnosť "'. $room->name .'" bola vytvorená!');

		return redirect()->route('rezervacie.index'); 
	}

	public function getCalendar($id){
		$events = [];

		$data = Calendar_event::where('reserve_room_id',$id)->get();

		if($data->count()) {
			foreach ($data as $key => $value) {
	            //dd(Carbon($value->start_date));
				$events[] = Calendar::event(
					$value->title,
					false,
					$value->start_date,
					$value->end_date,
					1,
	                    // Add color and link on event
					[
						'color' => $value->reserve_room->color->color,
						'url' => '/user/' . $value->user_id,
						'overlap' => 'true'
					]
				);
			}
		}

		$calendar = Calendar::addEvents($events)->setOptions(['firstDay' => 1,'selectOverlap' => false]);

		return $calendar; 
	}
}
