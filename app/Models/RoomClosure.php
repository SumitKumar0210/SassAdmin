<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomClosure extends Model
{
    use HasFactory;
    public function roomData(){
        return $this->belongsTo(RoomNumber::class,'room_number');
    }

    public function closureData(){
        return $this->belongsTo(CloserReason::class,'reason_closure');
    }
}
