<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class RoomController extends Controller
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
        $rooms = Room::all();        
        return view('file-maintenance.room.index', ['rooms' => $rooms]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('file-maintenance.room.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $room = new Room();                
        $room->room_name = $request->input('room_name');
        $room->capacity = $request->input('capacity');
        $room->save();
        return redirect('/room')->with('message', 'Room Details is Successfully Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {                    
            $room = Room::find(Crypt::decryptString($id)); 
            return view('file-maintenance.room.edit', ['room' => $room]);
        } catch (DecryptException $e) {
            abort(403);
        } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $room = Room::find(Crypt::decryptString($id));            
        $room->room_name = $request->input('room_name');
        $room->capacity = $request->input('capacity');
        $room->save();
        return redirect('/room')->with('message', 'Room Details is Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try  {
            Room::find(Crypt::decryptString($id))->delete();                       
            return redirect('/room')->with('message', 'Room Details is Successfully Deleted!');
        } catch (DecryptException $e) {
            abort(403);
        } 
    }

    public function getAllRoomsData()
    {        
        return response()->json(Room::all());     
    }
}
