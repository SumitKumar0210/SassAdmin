<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;
     public function vendorData(){
    return $this->belongsTo(Vendor::class,'vendor_id');
    }
    public function userData(){
    return $this->belongsTo(User::class, 'created_by');
    }
}
