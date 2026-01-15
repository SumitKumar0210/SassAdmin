<?php

namespace App\Helpers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DatabaseHelper
{
    /**
     * Check database connection using user-provided credentials
     *
     * @param array $credentials
     * @return bool
     */
    public static function checkWithUserCredentials(array $credentials): bool
    {
        try {
            $connectionName = 'temp_user_db';

            config([
                "database.connections.$connectionName" => [
                    'driver'    => 'mysql',
                    'host'      => $credentials['host'],
                    'port'      => $credentials['port'] ?? 3306,
                    'database'  => $credentials['database'],
                    'username'  => $credentials['username'],
                    'password'  => $credentials['password'],
                    'charset'   => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix'    => '',
                    'strict'    => true,
                ],
            ]);

            DB::purge($connectionName);
            DB::connection($connectionName)->getPdo();

            return true;

        } catch (\Throwable $e) {

            Log::warning('User DB connection check failed', [
                'host' => $credentials['host'] ?? null,
                'db'   => $credentials['database'] ?? null,
                'error'=> $e->getMessage(),
            ]);

            return false;
        }
    }
}
