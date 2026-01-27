<?php

namespace App\Services\Tenancy;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\Tenant;
use App\Services\Tenancy\TenantDatabaseManager;


class TenantResolver
{
    public static function resolve(Request $request): ?Tenant
    {
        // $host = $request->getHost();
        $host = 'abc.google.com';

        $subdomain = explode('.', $host)[0];

        Log::info('Resolving tenant', ['host' => $host]);
        Log::info('Resolving tenant', ['subdomain' => $subdomain]);

        return Cache::remember(
            "tenant:host:{$host}",
            now()->addMinutes(30),
            function () use ($host, $subdomain) {
                $tenant = Tenant::on('admin')
                    ->where('subdomain', $subdomain)
                    // ->where('status', 'active')
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

        $dbManager = app(TenantDatabaseManager::class);

        if (! $dbManager->boot($tenant)) {
            abort(500, 'Unable to connect to tenant database');
        }

        return $tenant;
    }
}
