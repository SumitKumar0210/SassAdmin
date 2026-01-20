<?php

namespace App\Services;

use App\Models\Admin\SuperAdminAuditLog;

class AdminAuditService
{
    public static function log(
        string $action,
        $target = null,
        array $meta = []
    ): void {
        SuperAdminAuditLog::create([
            'admin_id'   => auth('admin')->id(),
            'action'     => $action,
            'target_type'=> $target ? class_basename($target) : null,
            'target_id'  => $target?->id,
            'meta'       => $meta,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
