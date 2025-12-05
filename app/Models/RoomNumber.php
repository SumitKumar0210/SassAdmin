<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomNumber extends Model
{
    use HasFactory,SoftDeletes;
    function roomNumberDetail(){
        return $this->hasOne('App\Models\RoomType', 'id', 'roomtype_id');
    }
    
    function roomCategoryDetail(){
        return $this->hasOne('App\Models\RoomType', 'id', 'category_id');
    }

    function roomBedConfiguration(){
        return $this->hasMany('App\Models\RoomBedConfiguration', 'roomtype_id', 'id');
    }
}
