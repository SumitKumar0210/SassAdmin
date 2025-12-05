<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseInwardLog extends Model
{
    use HasFactory,SoftDeletes;

    public function itemData(){
        return $this->belongsTo(RawMaterial::class,'item_id');
    }
}
