<?php
namespace App\Mail;

use App\Models\Admin\TenantApplication;
use Illuminate\Mail\Mailable;

class TenantWelcomeMail extends Mailable
{
    public TenantApplication $tenant;

    public function __construct(TenantApplication $tenant)
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
