<?php

namespace App\Providers;
use App\Models\User;
use App\Models\Admin\Tenant;
// use App\Models\Order;
use App\Observers\AuditObserver;
use App\Observers\TenantObserver;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        User::observe(AuditObserver::class);
        // Order::observe(AuditObserver::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Tenant::observe(TenantObserver::class);
    }
}
