<?php

namespace App\Services\Tenancy;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\Tenant;

class TenantResolver
{
    public static function resolve(Request $request): ?Tenant
    {
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];

        Log::info('Resolving tenant', ['host' => $host]);
        Log::info('Resolving tenant', ['subdomain' => $subdomain]);

        return Cache::remember(
            "tenant:host:{$host}",
            now()->addMinutes(30),
            function () use ($host, $subdomain) {
                $tenant = Tenant::on('admin')
                    ->where('subdomain', $subdomain) // or subdomain column if you prefer
                    ->where('status', 'active')
                    ->first();

                if ($tenant) {
                    Log::info('Tenant resolved', [
                        'id' => $tenant->id,
                        'domain' => $tenant->domain,
                    ]);
                }

                return $tenant;
            }
        );


                if ($tenant) {
                    Log::info('Tenant resolved', [
                        'id' => $tenant->id,
                        'domain' => $tenant->subdomain,
                    ]);
                }

                return $tenant;
            
        
    }
}
