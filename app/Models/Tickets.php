<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    use HasFactory;
    protected $fillable = ['seat_id', 'user_id', 'date', 'departing_destination', 'arriving_destination', 'price', 'qrCode', 'isActive', 'hasInsurance'];

    public function departing_destination()
    {
        return $this->belongTo(Destination::class, 'departing_destination');
    }

    public function arriving_destination()
    {
        return $this->belongTo(Destination::class, 'arriving_destination');
    }

    public function seat()
    {
        return $this->belongsTo(Seats::class,'seat_id');
    }

    public $timestamps = false;
}
