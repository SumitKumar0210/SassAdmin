<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kot extends Model
{
    use HasFactory;

    public function items() {
        return $this->hasMany(KotItem::class, 'kot_id', 'id');
    }

    public function reservation() {
        return $this->hasOne(Reservation::class, 'reservation_id', 'kot_id');
    }
    
    public function waiterDetail() {
        return $this->hasOne(Waiter::class, 'id', 'waiter_id');
    }

    public function room(){
        return $this->belongsTo(RoomNumber::class, 'type_number');
    }

    public function table(){
        return $this->belongsTo(Table::class, 'type_number');
    }
    
    public function user_detail(){
        return $this->belongsTo(User::class, 'bill_by');
    }
}
