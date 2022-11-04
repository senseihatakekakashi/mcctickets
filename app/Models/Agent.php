<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    use HasFactory;

    protected $table = 'agents';

    public function ticketAllotment() {
        return $this->hasMany(TicketAllotment::class);
    }

    public function ticketSales() {
        return $this->hasMany(TicketSales::class);
    }    
}
