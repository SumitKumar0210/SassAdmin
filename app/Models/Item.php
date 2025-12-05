<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    public function measurement_detail(){
        return $this->hasOne('App\Models\Measurement', 'id', 'uom');
    }
    
    public function category_detail(){
        return $this->hasOne('App\Models\Category', 'id', 'category');
    }
    
    public function sub_category_detail(){
        return $this->hasOne('App\Models\Category', 'id', 'sub_category');
    }
    
    public function label_detail(){
        return $this->hasMany('App\Models\ItemLabel', 'item_id', 'id');
    }

    public function item_variation_detail(){
        return $this->hasMany('App\Models\ItemVariation', 'item_id', 'id');
    }
    
}
