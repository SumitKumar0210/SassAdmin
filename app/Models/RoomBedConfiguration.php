<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomBedConfiguration extends Model
{
    use HasFactory;

    public function bedConfig(){
        return $this-> hasOne('App\Models\BedType','id','bed_type');
    }
}
