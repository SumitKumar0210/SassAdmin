<?php
namespace App\Jobs;

use App\Mail\TenantWelcomeMail;
use App\Models\Admin\TenantApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendWelcomeMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;          // retry 3 times
    public int $timeout = 30;       // seconds

    protected int $tenantId;

    public function __construct(int $tenantId)
    {
        $this->tenantId = $tenantId;
    }

    public function handle(): void
    {
        $tenant = TenantApplication::findOrFail($this->tenantId);

        Mail::to('sumitkr56569@gmail.com')
            ->send(new TenantWelcomeMail($tenant));
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
