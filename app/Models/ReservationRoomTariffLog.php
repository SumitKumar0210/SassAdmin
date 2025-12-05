<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationRoomTariffLog extends Model
{
    use HasFactory;

    public function roomData(){
        return $this->hasOne('App\Models\RoomType','id','room_type_id');
    }
}
