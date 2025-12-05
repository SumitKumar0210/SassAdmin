<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxSlab extends Model
{
    use HasFactory;

    public function tax_category(){
        return $this->hasOne('App\Models\Module', 'id', 'category_id');
    }
}
