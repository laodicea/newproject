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

class RoomController extends Controller
{
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
	 * Zobrazenie všetkých miestností.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{   
		$this->checkRole('administrator');
		$rooms = Reserve_room::orderBy('name','asc')->paginate(15); 

		return view('rezervacia.room.all')->withRooms($rooms); 
	}  

	/**
	 * zobrazenie formuláru pre vytvorenie novej miestnosti
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{   
		$this->checkRole('administrator');
		$colorsFromDb = Color::orderBy('color', 'asc')->get();
		$colors = array();
		foreach ($colorsFromDb as $key => $value) { 
			$colors[$value->id] = $value->color;
		} 

		return view('rezervacia.room.create')->withColors($colors);
	}

	/**
	 * Uloženie vytvorenej miestnosti.
	 *
	 * @param  App\Http\Requests\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{   
		$this->checkRole('administrator');
		$room = new Reserve_room(); 
		$room->name = $request->name;
		$room->color_id = $request->color;
		$room->note = $request->name;
		$room->user_id = Auth::id();

		$room->save();

		Session::flash('success', 'Nová miestnosť "' . $room->name . '" bola pridaná do rezerváčného systému miestností');

		return redirect()->route('room.index'); 
	}

	/**
	 * Zobrazenie formuláru pre editovanie prípadu.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) 
	{ 
		$this->checkRole('administrator'); 
		$room = Reserve_room::find($id);
		$colorsFromDb = Color::orderBy('color', 'asc')->get();
		$colors = array();
		foreach ($colorsFromDb as $key => $value) { 
			$colors[$value->id] = $value->color;
		} 

		return view('rezervacia.room.edit')->withColors($colors)->withRoom($room);
	}

	/**
	 * Update prípadu.
	 *
	 * @param  App\Http\Requests\UpdateCasemodelRequest  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{ 
		$this->checkRole('administrator');

		$room = Reserve_room::find($id);
		$room->name = $request->name;
		$room->color_id = $request->color;
		$room->note = $request->name;
		$room->user_id = Auth::id();

		$room->save();
		Session::flash('success', 'Zmeny v miestnosti "' . $room->name . '" boli aktualizované!');

		return redirect()->route('room.index'); 

	} 

	/**
	 * Soft delete prípadu.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$this->checkRole('administrator');
		$room = Reserve_room::find($id);
		$room->delete();

		$events = Calendar_event::where('reserve_room_id', '=', $id)->get();

		foreach ($events as $item) {
			$item->delete();
		}

		Session::flash('success', 'Miestnosť  "'.  $room->name .'" bola odstránená i s jej rezerváciami!');

		return redirect()->action('Rezervacie\RoomController@index');
	}
}
