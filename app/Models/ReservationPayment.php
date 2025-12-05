<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationPayment extends Model
{
    use HasFactory;
    public function payment_recorded_by(){
        return $this->hasOne('App\Models\User', 'id', 'recorded_by');
    }
}
