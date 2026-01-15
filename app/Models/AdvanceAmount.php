<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvanceAmount extends Model
{
    use HasFactory;

    public function payment_recorded_by(){
        return $this->hasOne('App\Models\User', 'id', 'recorded_by');
    }

    public function payment_mode_by(){
        return $this->hasOne('App\Models\PaymentMethod', 'id', 'mode');
    }
}
