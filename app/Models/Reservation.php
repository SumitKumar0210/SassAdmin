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
    public function reservationRoomData(){
        return $this->belongsTo(ReservationRoom::class, 'reservation_id', 'reservation_id');
    }
  

}
