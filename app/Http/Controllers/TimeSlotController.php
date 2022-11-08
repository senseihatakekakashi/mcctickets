<?php

namespace App\Http\Controllers;

use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class TimeSlotController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $time_slots = TimeSlot::all();        
        return view('file-maintenance.time-slot.index', ['time_slots' => $time_slots]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('file-maintenance.time-slot.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {                 
        $time_slot = new TimeSlot();                
        $time_slot->time_from = $request->input('time_from');
        $time_slot->time_to = $request->input('time_to');
        $time_slot->save();
        return redirect('/time-slot')->with('message', 'Time Slot is Successfully Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TimeSlot  $timeSlot
     * @return \Illuminate\Http\Response
     */
    public function show(TimeSlot $timeSlot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TimeSlot  $timeSlot
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {                    
            $time_slot = TimeSlot::find(Crypt::decryptString($id)); 
            return view('file-maintenance.time-slot.edit', ['time_slot' => $time_slot]);
        } catch (DecryptException $e) {
            abort(403);
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimeSlot  $timeSlot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {         
        $time_slot = TimeSlot::find(Crypt::decryptString($id));            
        $time_slot->time_from = $request->input('time_from');
        $time_slot->time_to = $request->input('time_to');
        $time_slot->save();
        return redirect('/time-slot')->with('message', 'Time Slot is Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeSlot  $timeSlot
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try  {
            TimeSlot::find(Crypt::decryptString($id))->delete();                       
            return redirect('/time-slot')->with('message', 'Time Slot is Successfully Deleted!');
        } catch (DecryptException $e) {
            abort(403);
        } 
    }
}
