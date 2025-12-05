<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BanquetMenuItem extends Model
{
    use HasFactory,SoftDeletes;
    public function menuCategoryData(){
        return $this->belongsTo(Category::class,'menu_category_id');
    }
}
