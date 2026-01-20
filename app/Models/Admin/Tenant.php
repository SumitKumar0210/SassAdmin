<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tenant extends Model
{
    use HasFactory, SoftDeletes;

    protected $connection = 'mysql';
    protected $table = 'tenants';
    protected $fillable = [
        'id',
        'uuid',
        'hotel_name',
        'legal_name',
        'woner_name',
        'email',
        'mobile',
        'subdomain',
        'plan_id',
        'status',
        'db_name',
        'db_host',
        'db_username',
        'db_password',
        'reseller_id',
        'onboarding_status',
        'go_live_date',
        'expiry_date',
        'state_id',
        'city', 
        'source',
        'rooms_count',
    ];


    public function plan()
    {
        return $this->hasOne(Plan::class, 'id', 'plan_id');
    }
}
