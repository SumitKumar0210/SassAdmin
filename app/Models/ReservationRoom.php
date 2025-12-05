<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use APP\Models\Reservation;

class ReservationRoom extends Model
{
    use HasFactory;
    public function res(){
        return $this->belongsTo(Reservation::class);
    }
    public function reservation_data(){
        return $this-> hasOne('App\Models\Reservation','reservation_id','reservation_id');
    }

    public function roomData(){
        return $this->hasOne('App\Models\RoomNumber','id','room_alloted_id');
    }

    public function room_type_detail(){
        return $this->belongsTo(RoomType::class,'room_category_id');
    }

    public function tariff_detail(){
        return $this->belongsTo(Tariff::class,'tariff_id');
    }
}
