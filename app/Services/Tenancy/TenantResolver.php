<?php

namespace App\Services\Tenancy;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\Tenant;

class TenantResolver
{
    // public static function resolve(Request $request): ?Tenant
    // {
    //     // $host = $request->getHost();
    //     $host = 'abc.google.com';

    //     $subdomain = explode('.', $host)[0];

    //     Log::info('Resolving tenant', ['host' => $host]);
    //     Log::info('Resolving tenant', ['subdomain' => $subdomain]);

    //     return Cache::remember(
    //         "tenant:host:{$host}",
    //         now()->addMinutes(30),
    //         function () use ($host, $subdomain) {
    //             $tenant = Tenant::on('admin')
    //                 ->where('subdomain', $subdomain)
    //                 // ->where('status', 'active')
    //                 ->first();

    //             if ($tenant) {
    //                 Log::info('Tenant resolved', [
    //                     'id' => $tenant->id,
    //                     'domain' => $tenant->domain,
    //                 ]);
    //             }

    //             return $tenant;
    //         }
    //     );


    //     if ($tenant) {
    //         Log::info('Tenant resolved', [
    //             'id' => $tenant->id,
    //             'domain' => $tenant->subdomain,
    //         ]);
    //     }

    //     return $tenant;
    // }

    public static function resolve(Request $request): ?Tenant
    {
        // $host = $request->getHost(); // ex: abc.google.com
        $host = 'abc.google.com';
        $subdomain = explode('.', $host)[0];

        $cacheKey = "tenant:host:{$host}";

        
        $tenant = Cache::tags(['tenants'])->get($cacheKey);

        if ($tenant) {
            Log::info('Tenant resolved (CACHE HIT)', [
                'id' => $tenant->id,
                'status' => $tenant->status,
            ]);

            // Block inactive tenants even if cached
            if ($tenant->status !== 'active') {
                return null;
            }

            return $tenant;
        }

        // DB lookup (ONLY active tenants)
        $tenant = Tenant::on('admin')
            ->where('subdomain', $subdomain)
            ->where('status', 'active')
            ->first();

        if ($tenant) {
            Cache::tags(['tenants'])->put(
                $cacheKey,
                $tenant,
                now()->addMinutes(30)
            );

            Log::info('Tenant resolved (DB → CACHE)', [
                'id' => $tenant->id,
            ]);
        }

        return $tenant;
    }
}
