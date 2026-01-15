<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenantApplication extends Model
{
    use HasFactory, SoftDeletes;

     protected $fillable = [
        'hotel_name',
        'woner_name',
        'email',
        'phone',
        'state_id',
        'city',
        'rooms_count',
        'preferred_subdomain',
        'source',
        'plan_id',
        'status',
    ];

    public function plan()
    {
        return $this->hasOne(Plan::class, 'id','plan_id');
    }
}
