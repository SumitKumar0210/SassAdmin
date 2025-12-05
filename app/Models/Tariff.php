<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tariff extends Model
{
    use HasFactory,SoftDeletes;
    public function categoryData(){
        return $this->belongsTo(RoomCategory::class,'room_category_id');
    }

    public function roomTypeNameData(){
        return $this->belongsTo(RoomTypeName::class,'roomtype_name_id');
    }
   
    public function roomType(){
        return $this->belongsTo(RoomType::class,'room_category_id');
    }
}
