<?php

namespace App\Http\Controllers\Admin\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Tenant;
use App\Models\Admin\TenantApplication;
use App\Models\Admin\Plan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use App\Helpers\Admin\DatabaseHelper;
use App\Jobs\SendWelcomeMailJob;
use App\Mail\TenantWelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $tenant = Tenant::where('email', $credentials['email'])->first();

        if (!$tenant) {
            throw ValidationException::withMessages([
                'email' => 'No tenant found with this email.',
            ]);
        }

        if ($tenant->status !== 'active') {
            throw ValidationException::withMessages([
                'email' => 'Your account is not active. Please contact support.',
            ]);
        }
        if (auth()->guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/tenant/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('auth.failed'),
        ]);
    }
}
