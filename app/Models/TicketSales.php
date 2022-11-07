<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketSales extends Model
{
    use HasFactory;

    protected $table = 'ticket_sales';

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function slot() {
        return $this->belongsTo(Slot::class);
    }
}
