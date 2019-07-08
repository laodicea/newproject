<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Notification;
use Auth;
use DB;

class MessagesController extends Controller
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
     * Show all messages.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
    	$unreads = Notification::where('notifiable_id',Auth::id())->where('read_at', null)->paginate(25);

    	$reads = Notification::where('notifiable_id',Auth::id())->where('read_at', '!=',null)->paginate(25);

        return view('messages.index')->withUnreads($unreads)->withReads($reads);
    }
}
