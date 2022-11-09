<?php

namespace App\Http\Controllers;

use App\Http\Requests\SlotValidationRequest;
use App\Models\Room;
use App\Models\Slot;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class SlotController extends Controller
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
        $slots = Slot::all();           
        return view('transaction.slot.index', [
            'slots' => $slots,            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $time_slots = TimeSlot::orderBy('time_from')->orderBy('time_to')->get();
        $rooms = Room::orderBy('room_name')->get();
        return view('transaction.slot.create', [            
            'time_slots' => $time_slots,
            'rooms' => $rooms,
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SlotValidationRequest $request)
    {
        $request->validated();
        
        $slot = new Slot();
        $slot->date = $request->input('date');
        $slot->time_slot = $request->input('time_slot');
        $slot->room_name = $request->input('room_name');
        $slot->capacity = $request->input('capacity');
        $slot->fee = $request->input('fee');
        $slot->save();
        return redirect('/slot')->with('message', 'Slot is Successfully Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function show(Slot $slot)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {                    
            $slot = Slot::find(Crypt::decryptString($id)); 
            $time_slots = TimeSlot::orderBy('time_from')->orderBy('time_to')->get();            
            $rooms = Room::orderBy('room_name')->get();            
            return view('transaction.slot.edit', [
                'slot' => $slot,
                'time_slots' => $time_slots,
                'rooms' => $rooms,
            ]);
        } catch (DecryptException $e) {
            abort(403);
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function update(SlotValidationRequest $request, $id)
    {
        $request->validated();
        
        $slot = Slot::find(Crypt::decryptString($id));            
        $slot->date = $request->input('date');
        $slot->time_slot = $request->input('time_slot');
        $slot->room_name = $request->input('room_name');
        $slot->capacity = $request->input('capacity');
        $slot->fee = $request->input('fee');
        $slot->save();        
        return redirect('/slot')->with('message', 'Slot is Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slot  $slot
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try  {
            if(Slot::find(Crypt::decryptString($id))->ticketAllotment()->count() == 0) {                
                Slot::find(Crypt::decryptString($id))->delete();                       
                return redirect('/slot')->with('message', 'Slot is Successfully Deleted!');
            }              
        } catch (DecryptException $e) {
            abort(403);
        } 
    }
}
