<?php
namespace App\Mail;

use App\Models\Admin\Tenant;
use Illuminate\Mail\Mailable;

class TenantWelcomeMailByAdmin extends Mailable
{
    public Tenant $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function build()
    {
        return $this
            ->subject('Welcome to Our Platform 🎉')
            ->view('emails.tenant_welcome');
    }
}
