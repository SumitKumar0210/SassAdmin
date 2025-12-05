<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentReceived extends Model
{
    use HasFactory,SoftDeletes;

    public function payment_mode_detail(){
        return $this->hasOne('App\Models\PaymentMethod', 'id', 'payment_mode');
    }
    
    public function user_detail(){
        return $this->hasOne('App\Models\User', 'id', 'received_by');
    }
}
