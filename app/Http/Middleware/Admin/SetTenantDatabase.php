<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Services\Tenancy\TenantResolver;
use App\Helpers\Admin\DatabaseHelper;

class SetTenantDatabase
{
    public function handle($request, Closure $next)
    {
        // Admin routes do NOT switch DB
        if ($request->is('admin/*')) {
            return $next($request);
        }

        // Resolve tenant
        $tenant = TenantResolver::resolve($request);

        \Log::info('Setting tenant database', ['tenant_id' => $tenant ??  null]);
        $credentials = [
            "host" => $tenant->db_host,
            "database" => $tenant->db_name,
            "username" => $tenant->db_username,
            "password" => $tenant->db_password ? decrypt($tenant->db_password) : '',
        ];
        $isConnected = DatabaseHelper::checkWithUserCredentials($credentials);
        \Log::info('Database connection status', ['is_connected' => $isConnected]);

        // Inject tenant DB credentials
        config([
            'database.connections.tenant.host' => $tenant->db_host,
            'database.connections.tenant.database' => $tenant->db_name,
            'database.connections.tenant.username' => $tenant->db_username,
            'database.connections.tenant.password' => $tenant->db_password ? decrypt($tenant->db_password) : null,
        ]);

        DB::purge('tenant');
        DB::setDefaultConnection('tenant');

        app()->instance('tenant', $tenant);

        return $next($request);
    }
}
