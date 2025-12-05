<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreRequest extends Model
{
    use HasFactory,SoftDeletes;
    public function departmentData(){
        return $this->belongsTo(Department::class, 'request_from');
    }
    public function userData(){
        return $this->belongsTo(User::class, 'created_by');
    }
    public function itemData(){
        return $this->belongsTo(RawMaterial::class,'item_id');
    }
    public function measurement_detail(){
        return $this->hasOne('App\Models\Measurement', 'id', 'unit');
    }
}
