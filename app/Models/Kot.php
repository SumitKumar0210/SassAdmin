<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kot extends Model
{
    use HasFactory,SoftDeletes;

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
    
    public function user_detail_cancel(){
        return $this->belongsTo(User::class, 'cancel_by');
    }

    public function itemDetail() {
        return $this->hasMany(Item::class, 'id', 'item_id');
    }
}
