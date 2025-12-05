<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryManagement extends Model
{
    use HasFactory,SoftDeletes;
    public function departmentData(){
        return $this->belongsTo(Department::class,'department_id');
    }

    public function rawMaterialDetail(){
        return $this->hasOne('App\Models\RawMaterial', 'id', 'item_id');
    }
}
