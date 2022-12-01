<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Slot;
use App\Models\TicketSales;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()    
    {                        
        
        $data = $this->agentDashboardStatistics();
        $agents = User::where('user_role', 'Agent')->where('record_status', 1)->get();
        return view('dashboard', ['data' => $data, 'agents' => $agents]);
    }    

    public function agentDashboardStatistics() {
        if(auth()->user()->user_role == 'Super Admin' || auth()->user()->user_role == 'Admin') {            
            $data['active_agents'] = User::where('user_role', 'Agent')->where('record_status', 1)->count();
            $data['slots'] = Slot::where('date', '>=', date("Y-m-d"))->count();            
            $data['total_active_ticket_slots'] = Slot::where('date', '>=', date("Y-m-d"))->sum('capacity');
            $data['total_earnings'] = TicketSales::sum('fee');
            return $data;
        }
        elseif(auth()->user()->user_role == 'Agent') {
            $user_id = auth()->user()->id;
            $data['ticket_sales'] = TicketSales::where('user_id', $user_id)->where('date', date("Y-m-d"))->count();

            $data['slots'] = Slot::whereExists(function($query) use ($user_id) {
                $query->select('slot_id')
                        ->from('ticket_allotments')
                        ->whereColumn('ticket_allotments.slot_id', 'slots.id')
                        ->where('user_id', $user_id);
            })->where('date', '>=', date("Y-m-d"))->count();
            
            $data['total_assigned_active_ticket_slots'] = Slot::whereExists(function($query) use ($user_id) {
                $query->select('slot_id')
                        ->from('ticket_allotments')
                        ->whereColumn('ticket_allotments.slot_id', 'slots.id')
                        ->where('user_id', $user_id);
            })->where('date', '>=', date("Y-m-d"))->sum('capacity');

            $data['total_earnings'] = TicketSales::where('user_id', $user_id)->sum('fee');
            return $data;
        }
        else {

        }        
    }
}
