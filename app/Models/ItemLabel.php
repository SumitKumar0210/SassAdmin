<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemLabel extends Model
{
    use HasFactory;

    public function master_label_detail(){
        return $this->hasOne('App\Models\Label', 'id', 'label_id');
    }
}
