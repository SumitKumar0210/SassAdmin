<?php

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use App\Services\Tenancy\TenantResolver;
use App\Helpers\Admin\DatabaseHelper;
use Illuminate\Support\Facades\Log;

class SetTenantDatabase
{
    // public function handle($request, Closure $next)
    // {
    //     // Admin routes do NOT switch DB
    //     if ($request->is('admin/*')) {
    //         return $next($request);
    //     }

    //     // Resolve tenant
    //     $tenant = TenantResolver::resolve($request);

    //     if(!$tenant) {
    //         Log::info('No tenant found for request', ['host' => $request->getHost()]);
    //         return redirect()->to('/subdomain/404');
    //     }

    //     if($tenant->status !== 'active') {
    //         Log::info('Inactive tenant access attempt', ['tenant_id' => $tenant->id]);
    //         abort(403, 'Tenant is inactive');
    //     }


    //     Log::info('Setting tenant database', ['tenant_id' => $tenant ??  null]);
    //     $credentials = [
    //         "host" => $tenant->db_host,
    //         "database" => $tenant->db_name,
    //         "username" => $tenant->db_username,
    //         "password" => $tenant->db_password ? decrypt($tenant->db_password) : '',
    //     ];
    //     $isConnected = DatabaseHelper::checkWithUserCredentials($credentials);
    //     Log::info('Database connection status', ['is_connected' => $isConnected]);

    //     // Inject tenant DB credentials
    //     config([
    //         'database.connections.tenant.host' => $tenant->db_host,
    //         'database.connections.tenant.database' => $tenant->db_name,
    //         'database.connections.tenant.username' => $tenant->db_username,
    //         'database.connections.tenant.password' => $tenant->db_password ? decrypt($tenant->db_password) : null,
    //     ]);

    //     DB::purge('tenant');
    //     DB::setDefaultConnection('tenant');

    //     app()->instance('tenant', $tenant);

    //     return $next($request);
    // }

    public function handle($request, Closure $next)
    {
        // Admin routes should NOT switch tenant DB
        if ($request->is('admin/*')) {
            return $next($request);
        }

        // Resolve tenant
        $tenant = TenantResolver::resolve($request);

        if (! $tenant) {
            return redirect('/subdomain/404');
        }

        // Final hard block (defense-in-depth)
        if ($tenant->status !== 'active') {

            auth()->guard('tenant')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('tenant.login')
                ->withErrors([
                    'account' => 'Your account has been suspended. Please contact support.'
                ]);
        }

        // Optional DB connection test
        $credentials = [
            'host' => $tenant->db_host,
            'database' => $tenant->db_name,
            'username' => $tenant->db_username,
            'password' => $tenant->db_password ? decrypt($tenant->db_password) : '',
        ];

        DatabaseHelper::checkWithUserCredentials($credentials);

        // Switch tenant DB
        config([
            'database.connections.tenant.host' => $tenant->db_host,
            'database.connections.tenant.database' => $tenant->db_name,
            'database.connections.tenant.username' => $tenant->db_username,
            'database.connections.tenant.password' => $tenant->db_password ? decrypt($tenant->db_password) : null,
        ]);

        DB::purge('tenant');
        DB::setDefaultConnection('tenant');

        // Make tenant globally available
        app()->instance('tenant', $tenant);
        

        return $next($request);
    }
}
