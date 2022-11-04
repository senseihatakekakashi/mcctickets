<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RequestNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function getRequestNotification()
    {        
        return response(User::find(auth()->user()->id)->unReadNotifications)
        ->header("Access-Control-Allow-Origin", config('cors.allowed_origins'))
        ->header("Access-Control-Allow-Methods", config('cors.allowed_methods'));        
    }

    public function markAllAsRead() {
        User::find(auth()->user()->id)->unreadNotifications()->update(['read_at' => now()]);    
        return redirect()->back();
    }

    public function markAsRead($id) {
        User::find(auth()->user()->id)->unreadNotifications()->where('id', $id)->update(['read_at' => now()]);    
        return redirect()->back();
    }
}
