<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomCategory extends Model
{
    use HasFactory,SoftDeletes;

    function roomNumberCategroy(){
        return $this->hasMany('App\Models\RoomNumber', 'category_id', 'id');
    }
}
