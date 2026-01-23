<?php

namespace App\Observers;

use App\Models\Admin\Tenant;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TenantObserver
{
    public function created(Tenant $tenant): void
    {
        Cache::tags(['tenants'])->forget('admin:tenant:list');
    }

    public function updated(Tenant $tenant): void
    {
        try{
            Cache::tags(['tenants'])->forget('admin:tenant:list');
            Cache::tags(['tenants'])->forget("tenant:host:{$tenant->subdomain}");

            // If tenant is suspended → kill sessions
            if ($tenant->wasChanged('status') && $tenant->status !== 'active') {
                DB::table('sessions')
                    ->where('tenant_id', $tenant->id)
                    ->delete();
            }

            // If subdomain changed → clear OLD cache key
            if ($tenant->wasChanged('subdomain')) {
                Cache::tags(['tenants'])->forget(
                    "tenant:host:{$tenant->getOriginal('subdomain')}"
                );
            }
        } catch(\Exception $e) {
            Log::error('ob', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function deleted(Tenant $tenant): void
    {
        Cache::tags(['tenants'])->forget('admin:tenant:list');
        Cache::tags(['tenants'])->forget("tenant:host:{$tenant->subdomain}");
    }

    /**
     * Handle the Tenant "restored" event.
     */
    public function restored(Tenant $tenant): void
    {
        //
    }

    /**
     * Handle the Tenant "force deleted" event.
     */
    public function forceDeleted(Tenant $tenant): void
    {
        //
    }
}
