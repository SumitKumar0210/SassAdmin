<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantLifecycleAuditLog extends Model
{
    use HasFactory;
    protected $table = 'tenant_lifecycle_audit_logs';

    protected $fillable = [
        'tenant_id',
        'event',
        'old_status',
        'new_status',
        'performed_by',
        'source',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    protected $connection = 'admin'; // VERY IMPORTANT
}
