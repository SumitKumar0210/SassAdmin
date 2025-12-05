<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomTypeName extends Model
{
    use HasFactory;
    function roomNumberType(){
        return $this->hasMany('App\Models\RoomNumber', 'roomtype_id', 'id');
    }
}
