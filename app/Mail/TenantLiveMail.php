<?php
namespace App\Mail;

use App\Models\Admin\Tenant;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TenantLiveMail extends Mailable
{
    use SerializesModels;

    public function __construct(public Tenant $tenant) {}

    public function build()
    {
        return $this
            ->subject('🎉 Your Hotel Is Live on ' . config('app.name'))
            ->view('emails.tenant_Approved');
    }
}
