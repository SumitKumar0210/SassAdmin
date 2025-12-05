<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function category_detail(){
        return $this->hasOne('App\Models\Category', 'id', 'type');
    }

    public function item_detail(){
        return $this->hasMany('App\Models\Item', 'category', 'id');
    }
}
