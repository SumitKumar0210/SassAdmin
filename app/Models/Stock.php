<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    public function rawMaterialDetail(){
        return $this->hasOne('App\Models\RawMaterial', 'id', 'item_id');
    }

     public function departmentData(){
        return $this->belongsTo(Department::class,'department_id');
    }
}
