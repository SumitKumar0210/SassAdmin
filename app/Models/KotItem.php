<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KotItem extends Model
{
    use HasFactory,SoftDeletes;

    public function itemDetail(){
        return $this->belongsTo(Item::class, 'category');
    }
}
