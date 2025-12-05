<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRequireMaterial extends Model
{
    use HasFactory;

    public function material_detail(){
        return $this->hasOne('App\Models\RawMaterial', 'id', 'material_id');
    }
}
