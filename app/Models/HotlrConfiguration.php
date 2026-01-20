<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotlrConfiguration extends Model
{
     protected $connection = 'tenant'; // ✅ REQUIRED
    protected $table = 'hotlr_configurations';

    use HasFactory;
}
