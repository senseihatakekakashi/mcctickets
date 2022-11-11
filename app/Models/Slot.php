<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    protected $table = 'slots';

    public function ticketAllotment() {
        return $this->hasMany(TicketAllotment::class);
    }    

    public function ticketSales() {
        return $this->hasMany(TicketSales::class);
    } 
}
