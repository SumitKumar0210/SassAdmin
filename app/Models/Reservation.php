<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ReservationRoom;

class Reservation extends Model
{
    use HasFactory;

    public function resRooms(){
        return $this->hasMany(ReservationRoom::class);
    }
}
