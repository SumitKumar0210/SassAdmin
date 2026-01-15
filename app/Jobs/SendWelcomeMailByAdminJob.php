<?php
namespace App\Jobs;

use App\Mail\TenantWelcomeMailByAdmin;
use App\Models\Admin\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMailByAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public $timeout = 30;

    protected $tenantId;

    public function __construct($tenantId)
    {
        $this->tenantId = $tenantId;
    }

    public function handle(): void
    {
        $tenant = Tenant::where('uuid',$this->tenantId)->first();

        Mail::to('sumitkr56569@gmail.com')
            ->send(new TenantWelcomeMailByAdmin($tenant));
            Log::info('Welcome mail job dispatched', [
    'tenant_id' => $tenant->id,
    'email' => $tenant->email,
]);
    }

    /**
     * Runs automatically if job fails after retries
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Welcome mail job failed', [
            'tenant_id' => $this->tenantId,
            'error'     => $exception->getMessage(),
        ]);
    }
}
