<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Slot;
use App\Models\TicketAllotment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class TicketAllotmentController extends Controller
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
        $users = User::where('record_status', 1)->where('user_role', 'Agent')->get();        
        return view('transaction.ticket-allotment.index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        try {                    
            $user_id = Crypt::decryptString($id);
            $user = User::find($user_id);             
            $slots = Slot::whereNotExists(function($query) {
                    $query->select('slot_id')
                            ->from('ticket_allotments')
                            ->whereColumn('ticket_allotments.slot_id', 'slots.id');
            })
            ->where('date', '>=', date("Y-m-d"))
            ->get();
            
            return view('transaction.ticket-allotment.setup', ['user' => $user, 'slots' => $slots]);
        } catch (DecryptException $e) {
            abort(403);
        }  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        try {               
            $user_id = Crypt::decryptString($id);                        

            foreach($request->input('assign_ticket') as $key => $slot_id) {
                $insert_data[$key] = [
                    'created_at' =>  \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(), 
                    'user_id' => $user_id,                     
                    'slot_id' => $slot_id
                ];
            }
            
            TicketAllotment::insert($insert_data);

            return redirect('/ticket-allotment/' . $id . '/setup')->with('message', 'Ticket(s) Successfully Assigned!');
        } catch (DecryptException $e) {
            abort(403);
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TicketAllotment  $ticketAllotment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {                    
            $user_id = Crypt::decryptString($id);
            $user = User::find($user_id); 
            $slots = Slot::whereExists(function($query) use ($user_id) {
                $query->select('slot_id')
                        ->from('ticket_allotments')
                        ->whereColumn('ticket_allotments.slot_id', 'slots.id')
                        ->where('user_id', $user_id);
            })
            ->where('date', '>=', date("Y-m-d"))
            ->get();

            $expired_slots = Slot::whereExists(function($query) use ($user_id) {
                $query->select('slot_id')
                        ->from('ticket_allotments')
                        ->whereColumn('ticket_allotments.slot_id', 'slots.id')
                        ->where('user_id', $user_id);
            })
            ->where('date', '<', date("Y-m-d"))
            ->get();
            
            return view('transaction.ticket-allotment.show', ['user' => $user, 'slots' => $slots, 'expired_slots' => $expired_slots]);
        } catch (DecryptException $e) {
            abort(403);
        }  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TicketAllotment  $ticketAllotment
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketAllotment $ticketAllotment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TicketAllotment  $ticketAllotment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TicketAllotment $ticketAllotment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TicketAllotment  $ticketAllotment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {                
        try  {
            if(Slot::find(Crypt::decryptString($id))->ticketSales()->count() == 0) {                
                TicketAllotment::where('slot_id', Crypt::decryptString($id))->delete();  
                return redirect()->back()->with('message', 'Assigned Ticket(s) is Successfully Deleted!');                
            }              
        } catch (DecryptException $e) {
            abort(403);
        } 
    }
}
