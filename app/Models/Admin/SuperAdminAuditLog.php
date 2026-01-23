<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuperAdminAuditLog extends Model
{
    use HasFactory;
    //  protected $table = 'super_admin_audit_logs';

    protected $fillable = [
        'admin_id',
        'action',
        'target_type',
        'target_id',
        'meta',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    // protected $connection = 'admin'; // VERY IMPORTANT
}
