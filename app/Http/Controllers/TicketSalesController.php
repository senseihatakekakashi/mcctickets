<?php

namespace App\Http\Controllers;

use App\Models\Slot;
use App\Models\TicketSales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;

class TicketSalesController extends Controller
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
        $user_id = auth()->user()->id;
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
        
        return view('ticket-sales.index', ['slots' => $slots, 'expired_slots' => $expired_slots]);        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        try {
            $slot = Slot::find(Crypt::decryptString($id));                    
            $ticket_sales = TicketSales::where('slot_id', Crypt::decryptString($id))->get();            
            return view('ticket-sales.create', ['slot' => $slot, 'ticket_sales' => $ticket_sales]);
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
            $reference_number = uniqid();
            $slot = Slot::find(Crypt::decryptString($id));
            $ticket_sale = new TicketSales();
            $ticket_sale->user_id = auth()->user()->id;
            $ticket_sale->slot_id = $slot->id;
            $ticket_sale->date = $slot->date;
            $ticket_sale->time_slot = $slot->time_slot;
            $ticket_sale->room_name = $slot->room_name;
            $ticket_sale->capacity = $slot->capacity;
            $ticket_sale->fee = $slot->fee;
            $ticket_sale->email_address = $request->input('email_address');
            $ticket_sale->reference_number = $reference_number;
            $ticket_sale->save();            
                        
            // $qr_code = QrCode::size(250)->generate(URL::to('/') . '/e-ticket/' . $reference_number);
            // $email_from = auth()->user()->name;
            // dd($email_from);
            // Send Email
            // dd(env('MAIL_FROM_ADDRESS'));

            Mail::send('emails.mail-ticket', ['ticket_sale' => $ticket_sale],
            function($mail) use($request, $reference_number) {
                $mail->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
                $mail->to($request->input('email_address'))->subject("MCC E-Ticket " . $reference_number);
            });

            return redirect('/ticket-sales/' . $id . '/create')->with('message', $ticket_sale);
        } catch (DecryptException $e) {
            abort(403);
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TicketSales  $ticketSales
     * @return \Illuminate\Http\Response
     */
    public function show(TicketSales $ticketSales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TicketSales  $ticketSales
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketSales $ticketSales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TicketSales  $ticketSales
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TicketSales $ticketSales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TicketSales  $ticketSales
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketSales $ticketSales)
    {
        //
    }
}
