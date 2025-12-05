<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemAddon extends Model
{
    use HasFactory;

    public function item_detail(){
        return $this->hasOne('App\Models\Item', 'id', 'item_id');
    }
    
    public function item_detail_addon(){
        return $this->hasOne('App\Models\Item', 'id', 'addon_item_id');
    }

    public function item_variant_detail(){
        return $this->hasOne('App\Models\ItemVariation', 'id', 'variation');
    }

    public function variation_detail(){
        return $this->hasOne('App\Models\ItemAttribute', 'id', 'addon_item_id');
    }
}
