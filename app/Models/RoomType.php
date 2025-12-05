<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model
{
    use HasFactory,SoftDeletes;

    function roomTypeName(){
        return $this->hasMany('App\Models\RoomTypeName', 'roomtype_id', 'id');
    }

     function roomCategory(){
        return $this->hasOne('App\Models\RoomCategory', 'id', 'room_category_id');
    }
   
    function roomTypeNameDetail(){
        return $this->hasOne('App\Models\RoomTypeName', 'id', 'roomtype_name_id');
    }
}
