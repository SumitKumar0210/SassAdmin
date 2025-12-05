<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanquetBooking extends Model
{
    use HasFactory;

    public function payment_mode_detail(){
        return $this->hasOne('App\Models\PaymentMethod', 'id', 'payment_mode');
    }

    public function user_detail(){
        return $this->hasOne('App\Models\User', 'id', 'created_by');
    }
}
