<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemVariation extends Model
{
    use HasFactory;
    public function attribute_detail(){
        return $this->hasOne('App\Models\ItemAttribute', 'id', 'attribute_id');
    }

    public function attribute_type_detail(){
        return $this->hasOne('App\Models\ItemAttribute', 'id', 'type');
    }
}
