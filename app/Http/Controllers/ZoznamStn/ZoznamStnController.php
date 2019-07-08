<?php

namespace App\Http\Controllers\ZoznamStn;

use App\Http\Controllers\Controller;
use App\Model\Z_stn\ZoznamStn;
use App\Model\Z_stn\Ics;
use Illuminate\Http\Request;

class ZoznamStnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = ZoznamStn::where('cisk', " ")->orderBy('cist')->get();
        
        return view('z_stn.index1')->withItems($items);
    }

    public function ajax($cist){
       $items = ZoznamStn::where('cist', $cist)->where('cisk', '!='," ")->orderBy('cisk')->get();

        return response()->json(array('msg'=> $items, 'num' => $cist), 200);
    }

    public function ics(){

        $items = Ics::orderBy('ics')->get();
        
        return view('z_stn.ics')->withItems($items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ZoznamStn  $zoznamStn
     * @return \Illuminate\Http\Response
     */
    public function show(ZoznamStn $zoznamStn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ZoznamStn  $zoznamStn
     * @return \Illuminate\Http\Response
     */
    public function edit(ZoznamStn $zoznamStn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ZoznamStn  $zoznamStn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ZoznamStn $zoznamStn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ZoznamStn  $zoznamStn
     * @return \Illuminate\Http\Response
     */
    public function destroy(ZoznamStn $zoznamStn)
    {
        //
    }
}
