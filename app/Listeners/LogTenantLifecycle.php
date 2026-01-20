<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\TenantStatusChanged;
use App\Models\Admin\TenantLifecycleAuditLog;

class LogTenantLifecycle
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TenantStatusChanged $event)
    {
        TenantLifecycleAuditLog::create([
            'tenant_id' => $event->tenant->id,
            'event' => 'status_changed',
            'old_status' => $event->oldStatus,
            'new_status' => $event->newStatus,
            'performed_by' => auth()->id(),
            'source' => $event->source,
        ]);
    }
}
