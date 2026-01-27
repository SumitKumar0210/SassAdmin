<?php

namespace App\Services\Tenancy;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\Admin\DatabaseHelper;

class TenantDatabaseManager
{
    public function boot($tenant): bool
    {
        $credentials = [
            'host'     => $tenant->db_host,
            'database' => $tenant->db_name,
            'username' => $tenant->db_username,
            'password' => $tenant->db_password ? decrypt($tenant->db_password) : null,
        ];

        // Check DB connection
        $isConnected = DatabaseHelper::checkWithUserCredentials($credentials);

        Log::info('Tenant DB connection check', [
            'tenant_id' => $tenant->id,
            'connected' => $isConnected
        ]);

        if (! $isConnected) {
            return false;
        }

        // Inject tenant DB credentials
        config([
            'database.connections.tenant.host'     => $credentials['host'],
            'database.connections.tenant.database' => $credentials['database'],
            'database.connections.tenant.username' => $credentials['username'],
            'database.connections.tenant.password' => $credentials['password'],
        ]);

        DB::purge('tenant');
        DB::setDefaultConnection('tenant');

        app()->instance('tenant', $tenant);

        return true;
    }
}
