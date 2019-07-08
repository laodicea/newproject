<?php
namespace App\Http\Controllers\Rezervacie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Rezervacie\RezervacieController; 
use App\Http\Requests\UpdateCalendarEventRequest; 
use App\Http\Requests\SaveCalendarEventRequest;
use App\Model\Rezervacie\Calendar_event; 
use App\Model\Rezervacie\Reserve_room;
use Illuminate\Support\Facades\Input; 
use App\Model\Color;
use App\User;
use Paginator;
use Calendar;
use Redirect; 
use Session; 
use Auth;

class CalendarEventController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function store(SaveCalendarEventRequest $request)
  {   
    $room = Reserve_room::find($request->room);
    $start_date = date("Y-m-d H:i", strtotime($request->start_date));
    $end_date  = date("Y-m-d H:i", strtotime($request->end_date));
 
    if($this->checkInterval($start_date, $end_date, $request->room,0)){

      $event = new Calendar_event(); 
      $event->title = $request->title;
      $event->start_date = $start_date;
      $event->end_date = $end_date;
      //$event->url_link = $request->url;
      $event->reserve_room_id = $request->room;
      $event->user_id = Auth::id();
 
      $event->save(); 

      $calendar = (new RezervacieController)->getCalendar($request->room);
      $items = Reserve_room::all(); 
      $rooms = array();
      foreach ($items as $value) {
        $rooms[$value->id] = $value->name;
      }

      Session::flash('success', 'Udalosť bola pridaná do kalendáru '.$room->name.'!');

      return redirect()->route('rezervacie.show', $request->room)->withItems($items)->withCalendar($calendar)->withRooms($rooms)->withCurroom($room->name); 
    }else{ 
     return Redirect::back()->withErrors(['Tento čas je už v miestnosti: '.$room->name.' obsadený', 'Skúste si inú miestnosť zarezervovať alebo zvolte iný čas!'])->withInput(Input::all());
    }
  }

  public function allMyEvent()
  {
    $user = User::find(Auth::id());

    if($user->hasRole(['administrator']))
    {
      $events = Calendar_event::orderBy('start_date','desc')->paginate(15);  
    }else
    {
      $events = Calendar_event::where('user_id', $user->id)->orderBy('start_date','desc')->paginate(15); 
    } 
    return view('rezervacia.calendar_event.index')->withEvents($events);
  }

  public function edit($id)
  {
    $user = User::find(Auth::id());
    $event = Calendar_event::find($id);
    if($event->user_id == Auth::id() || $user->hasRole(['administrator']))
    {
      if($event->start_date > date("Y-m-d H:i:s"))
      {
       // $event->start_date = date("Y-m-d H:i", strtotime($event->start_date));  
        //$event->end_date = date("Y-m-d H:i", strtotime($event->end_date));
        $rooms_from_db = Reserve_room::All();
        $rooms = array();
        foreach ($rooms_from_db as $value) {
         $rooms[$value->id] = $value->name; 
       }
     }else{
      return back();
    }
  }else{
    return back();
  }

  return view('rezervacia.calendar_event.edit')->withEvent($event)->withRooms($rooms);
  }

  public function update(UpdateCalendarEventRequest $request, $id)
  {
    $room = Reserve_room::find($request->room);
    $start_date = date("Y-m-d H:i", strtotime($request->start_date));
    $end_date  = date("Y-m-d H:i", strtotime($request->end_date));
  
    if($this->checkInterval($request->start_date, $request->end_date, $request->room,$id))
    {
      $event = Calendar_event::find($id); 

      $event->title = $request->title;
      $event->start_date = $start_date;
      $event->end_date = $end_date;
     // $event->url_link = $request->url_link;
      $event->reserve_room_id = $request->room; 
      
      $event->save();

      Session::flash('success', 'Udalosť '.$event->title.' bola aktualizovaná!');

      return redirect()->action('Rezervacie\CalendarEventController@allMyEvent');
    }else{ 

    $event = Calendar_event::find($id);
    $rooms_from_db = Reserve_room::All();

      $rooms = array();
      foreach ($rooms_from_db as $value) {
        $rooms[$value->id] = $value->name; 
      } 
    
    Session::flash('error', 'Tento čas je už v miestnosti "'.$room->name. '" obsadený, skúste zarezervovať inú miestnosť alebo zvolte iný čas!');
    
    return redirect()->route('rezervacie.udalost.edit', $id);
  
     //Redirect::back()->withErrors(['Tento čas je už v miestnosti "'.$room->name. '" obsadený, skúste zarezervovať inú miestnosť alebo zvolte iný čas!'])->withInput(Input::all());
    }
  }

  private function checkInterval($start, $end, $id, $id_event){
 
   $counter = 0;
   $timekeepArray = Calendar_event::where('reserve_room_id', $id)->get(); 
   foreach($timekeepArray as $timekeep) 
   {
    if($timekeep->id == $id_event){
      continue;
    }
    if($start < $timekeep->end_date && $end>$timekeep->start_date){
                $counter++; //in range
              } 
            }
            if($counter == 0){
              return true; 
            }else{ 
             return false;
           }
         }

  /**
   * Soft delete udalosti
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $event = Calendar_event::find($id);
    if($event->user_id = Auth::id())
    {
      $event->delete();

      Session::flash('success', 'Udalosť  "'.  $event->title .'" bola odstránená z miestnosti "' . $event->reserve_room->name . '"!');

      return redirect()->action('Rezervacie\CalendarEventController@allMyEvent');
    }else{
      return back();
    }  
  }
}
