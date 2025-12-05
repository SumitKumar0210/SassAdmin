<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterial extends Model
{
    use HasFactory;
    
    public function measurement_detail(){
        return $this->hasOne('App\Models\Measurement', 'id', 'uom');
    }
  
}
