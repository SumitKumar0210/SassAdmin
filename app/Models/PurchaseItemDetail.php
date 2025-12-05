<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItemDetail extends Model
{
    use HasFactory;
    public function itemData(){
        return $this->belongsTo(RawMaterial::class,'item_id');
    }
    public function purchaseOrder(){
    return $this->hasOne(PurchaseOrder::class, 'purchase_id');
    }
   

}
