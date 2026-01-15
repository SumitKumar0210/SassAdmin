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

class TenantRegistrationController extends Controller
{
    public function registerBySelf(Request $request)
    {
        try {

            $validated = $request->validate([
                'hotel_name' => 'required|string|max:255',
                'woner_name' => 'required|string|max:255',

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'unique:tenant_applications,email',
                    'unique:tenants,email',
                ],

                'mobile' => [
                    'required',
                    'digits:10',
                    'unique:tenant_applications,mobile',
                ],

                'preferred_subdomain' => [
                    'required',
                    'string',
                    'min:3',
                    'max:100',
                    'unique:tenant_applications,preferred_subdomain',
                    'regex:/^[a-z0-9][a-z0-9\-.]*[a-z0-9]$/',
                    'unique:tenants,subdomain',
                ],

                'state_id'    => 'required|integer',
                'city'        => 'required|string|max:100',
                'rooms_count' => 'required|integer|min:1',

                'source'  => 'nullable|string|max:50',
                'plan_id' => 'required|exists:plans,id',

                'status' => 'nullable|boolean',
            ], [
                'hotel_name.required' => 'Hotel name is required.',
                'woner_name.required' => 'Owner name is required.',
                'email.unique' => 'This email is already registered.',
                'mobile.unique' => 'This mobile number is already registered.',
                'preferred_subdomain.unique' => 'This subdomain is already taken.',
                'plan_id.exists' => 'Selected plan is invalid.',
            ]);

            DB::beginTransaction();

            $tenant = TenantApplication::create([
                'hotel_name'          => $validated['hotel_name'],
                'woner_name'          => $validated['woner_name'],
                'email'               => $validated['email'],
                'mobile'              => $validated['mobile'],
                'state_id'            => $validated['state_id'],
                'city'                => $validated['city'],
                'rooms_count'         => $validated['rooms_count'],
                'preferred_subdomain' => $validated['preferred_subdomain'],
                'source'              => $validated['source'] ?? 'website',
                'plan_id'             => $validated['plan_id'],
                'status'              => $validated['status'] ?? 1,
            ]);

            DB::commit();
            SendWelcomeMailJob::dispatch($tenant->id);


            return response()->json([
                'success' => true,
                'message' => 'Your account has been registered successfully.',
                'data'    => $tenant,
            ], 201);
        } catch (ValidationException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Tenant self-registration failed', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong. Please try again later.',
            ], 500);
        }
    }

    public function checkDbConnection(Request $request)
    {
        try {

            $validated = $request->validate([
                'host'     => 'required|string',
                'database' => 'required|string',
                'username' => 'required|string',
                'password' => 'nullable|string',
                'port'     => 'nullable|integer|min:1|max:65535',
            ]);


            $isConnected = DatabaseHelper::checkWithUserCredentials($validated);

            return response()->json([
                'success' => $isConnected,
                'message' => $isConnected
                    ? 'Database connection successful.'
                    : 'Unable to connect to the database. Please verify the provided credentials.',
            ], $isConnected ? 200 : 400);
        } catch (ValidationException $e) {

            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {

            Log::error('Database connection check failed', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unexpected error occurred while checking database connection.',
            ], 500);
        }
    }

    public function tenanteRegistrationForm(Request $request)
    {
        $plans = Plan::get();
        return view('admin.tenant.registration', compact('plans'));
    }

    public function storeTenantByAdmin(Request $request)
    {
        try {

            $validated = $request->validate([
                'hotel_name'     => 'required|string|max:255',
                'legal_name'     => 'nullable|string|max:255',
                'woner_name'     => 'required|string|max:255',

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    'unique:tenants,email',
                ],

                'mobile' => [
                    'required',
                    'digits_between:10,15',
                    'unique:tenants,mobile',
                ],

                'subdomain' => [
                    'required',
                    'string',
                    'min:3',
                    'max:100',
                    'unique:tenants,subdomain',
                    'regex:/^[a-z0-9][a-z0-9\-.]*[a-z0-9]$/',
                ],

                'db_name'     => 'required|string|unique:tenants,db_name',
                'db_host'     => 'required|string',
                'db_username' => 'required|string|min:3|max:32',
                'db_password' => 'nullable|string|min:6',

                'plan_id' => 'required|integer|exists:plans,id',

                'reseller_id' => 'nullable|integer|exists:resellers,id',

                'onboarding_status' => 'nullable|boolean',
                'expiry_date'       => 'nullable|date|after:today',
                'go_live_date'      => 'nullable|date',
                'status'            => 'required|in:active,inactive,suspended',
            ]);

            DB::beginTransaction();

            $tenant = Tenant::create([
                'uuid'                => (string) Str::uuid(),
                'hotel_name'        => $validated['hotel_name'],
                'legal_name'        => $validated['legal_name'] ?? null,
                'woner_name'        => $validated['woner_name'],
                'email'             => $validated['email'],
                'mobile'            => $validated['mobile'],
                'subdomain'         => strtolower($validated['subdomain']),

                'db_name'           => $validated['db_name'],
                'db_host'           => $validated['db_host'],
                'db_username'       => $validated['db_username'],
                'db_password'       => encrypt($validated['db_password'] ?? ''),

                'plan_id'           => $validated['plan_id'],
                'reseller_id'       => $validated['reseller_id'] ?? null,

                'onboarding_status' => 'approved',
                'go_live_date'      => $validated['go_live_date'] ?? null,
                'expiry_date'       => $validated['expiry_date'] ?? null,

                'status'            => $validated['status'],
            ]);

            DB::commit();

            return redirect('/')->with('success', 'Tenant created successfully!');
        } catch (ValidationException $e) {

            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Admin tenant creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'Failed to create tenant. Please try again.')
                ->withInput();
        }
    }

    public function tenantList(Request $request)
    {
        try {
            $lists = Tenant::with('plan')->orderBy('id', 'desc')->get();
            

            return view('admin.tenant.lists', compact('lists'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create tenant. Please try again. ' . $e->getMessage())
                ->withInput();
        }
    }
    public function edit(Request $request, $id)
    {
        // dd($id);
        try {
            $tenant = Tenant::with('plan')->where('uuid',$id)->first();
            $plans = Plan::get();
            if (!$tenant) {
                return redirect()->back()
                    ->with('error', 'Tenant not found.');
            }

            return view('admin.tenant.edit_tenant', compact('tenant','plans'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to fetch tenant. Please try again. ' . $e->getMessage())
                ->withInput();
        }
    }

    public function onBoardingList(Request $request)
    {
        try {
            $lists = TenantApplication::with('plan')->orderBy('id', 'desc')->get();

            return view('admin.tenant.on_boarding_request', compact('lists'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create tenant. Please try again. ' . $e->getMessage())
                ->withInput();
        }
    }

    public function editOnBoardingRequest(Request $request, $id)
    {
        try {
            $plans = Plan::all();

            $tenant = TenantApplication::with('plan')->find($id);

            if (!$tenant) {
                return redirect()->back()
                    ->with('error', 'Request not found.');
            }

            return view('admin.tenant.edit_on_boarding_request', compact('tenant', 'plans'));
        } catch (\Exception $e) {
            Log::error('Failed to load onboarding request', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()
                ->with('error', 'Failed to load onboarding request. Please try again.')
                ->withInput();
        }
    }


    public function approveAndUpdate(Request $request, $id)
    {
        dd($request->all());
        try {
            $application = TenantApplication::with('plan')->findOrFail($id);

            // Determine which action to perform
            $action = $this->determineAction($request);

            if (!$action) {
                return redirect()->back()->with('error', 'No action selected.');
            }

            // Validate based on action
            $validated = $this->validateRequest($request, $application, $action);

            // Execute action
            return match($action) {
                'update' => $this->handleUpdate($validated, $application),
                'approve' => $this->handleApprove($application),
                'update_and_approve' => $this->handleUpdateAndApprove($validated, $application),
            };

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Throwable $e) {
            Log::error('Onboarding action failed', [
                'tenant_id' => $id,
                'action' => $action ?? 'unknown',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->with('error', 'Something went wrong: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function determineAction(Request $request): ?string
    {
        if ($request->has('update_and_approve')) {
            return 'update_and_approve';
        }
        if ($request->has('approve')) {
            return 'approve';
        }
        if ($request->has('update')) {
            return 'update';
        }
        return null;
    }

    private function validateRequest(Request $request, TenantApplication $application, string $action): array
    {
        $rules = [
            'hotel_name' => ['required', 'string', 'min:3', 'max:255'],
            'legal_name' => ['nullable', 'string', 'max:255'],
            'woner_name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('tenant_applications', 'email')->ignore($application->id),
            ],
            'mobile' => [
                'required',
                'regex:/^[0-9]{10}$/',
                Rule::unique('tenant_applications', 'mobile')->ignore($application->id),
            ],
            'preferred_subdomain' => [
                'required',
                'string',
                'min:3',
                'max:63',
                'regex:/^[a-z0-9\-]+$/',
                Rule::unique('tenant_applications', 'preferred_subdomain')->ignore($application->id),
                Rule::unique('tenants', 'subdomain'),
            ],
            'plan_id' => ['required', 'exists:plans,id'],
            'status' => ['required', Rule::in(['pending', 'active', 'suspended', 'terminated'])],
            'onboarding_status' => ['required', Rule::in(['form_submitted', 'approved', 'live'])],
            'go_live_date' => ['nullable', 'date', 'after_or_equal:today'],
            'expiry_date' => ['nullable', 'date', 'after:go_live_date'],
        ];

        // Add database validation rules if user wants to change DB credentials
        if ($request->boolean('changeDbToggle') && in_array($action, ['approve', 'update_and_approve'])) {
            $rules = array_merge($rules, [
                'db_name' => ['required', 'string', 'regex:/^[a-zA-Z0-9_]+$/', 'max:64'],
                'db_host' => ['required', 'string', 'max:255'],
                'db_username' => ['required', 'string', 'max:255'],
                'db_password' => ['nullable', 'string', 'min:8', 'max:255'],
            ]);
        }

        $messages = [
            'hotel_name.required' => 'Hotel name is required.',
            'hotel_name.min' => 'Hotel name must be at least 3 characters.',
            'woner_name.required' => 'Owner name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.regex' => 'Mobile number must be exactly 10 digits.',
            'mobile.unique' => 'This mobile number is already registered.',
            'preferred_subdomain.required' => 'Subdomain is required.',
            'preferred_subdomain.regex' => 'Subdomain can only contain lowercase letters, numbers, and hyphens.',
            'preferred_subdomain.unique' => 'This subdomain is already taken.',
            'plan_id.required' => 'Please select a plan.',
            'plan_id.exists' => 'Selected plan does not exist.',
            'expiry_date.after' => 'Expiry date must be after go live date.',
            'db_name.regex' => 'Database name can only contain letters, numbers, and underscores.',
        ];

        return $request->validate($rules, $messages);
    }

    private function handleUpdate(array $validated, TenantApplication $application)
    {
        $application->status = 'submitted';
        $this->updateRequest($validated, $application);
        
        return redirect()->back()->with('success', 'Tenant application updated successfully!');
    }

    private function handleApprove(TenantApplication $application)
    {
        $this->approveRequest($application);
        
        return redirect()
            ->route('admin.tenants.list')
            ->with('success', 'Tenant approved and created successfully!');
    }

    private function handleUpdateAndApprove(array $validated, TenantApplication $application)
    {
        $this->updateAndApproveRequest($validated, $application);
        
        return redirect()
            ->route('admin.tenants.list')
            ->with('success', 'Tenant updated, approved, and created successfully!');
    }

    private function updateRequest(array $validated, TenantApplication $application): void
    {
        $application->update([
            'hotel_name' => $validated['hotel_name'],
            'legal_name' => $validated['legal_name'] ?? null,
            'woner_name' => $validated['woner_name'],
            'email' => $validated['email'],
            'mobile' => $validated['mobile'],
            'preferred_subdomain' => strtolower($validated['preferred_subdomain']),
            'plan_id' => $validated['plan_id'],
            'status' => $validated['status'],
            'onboarding_status' => $validated['onboarding_status'],
            'go_live_date' => $validated['go_live_date'] ?? null,
            'expiry_date' => $validated['expiry_date'] ?? null,
        ]);
    }

    private function approveRequest(TenantApplication $application, array $dbCredentials = []): void
    {
        DB::transaction(function () use ($application, $dbCredentials) {
            
            // Generate database credentials
            $dbName = $dbCredentials['db_name'] ?? 'tenant_db_' . strtolower($application->preferred_subdomain);
            $dbHost = $dbCredentials['db_host'] ?? config('database.connections.mysql.host');
            $dbUsername = $dbCredentials['db_username'] ?? config('database.connections.mysql.username');
            $dbPassword = $dbCredentials['db_password'] ?? config('database.connections.mysql.password');

            // Create tenant
            $tenant = Tenant::create([
                'id' => (string) Str::uuid(),
                'hotel_name' => $application->hotel_name,
                'legal_name' => $application->legal_name,
                'woner_name' => $application->woner_name,
                'email' => $application->email,
                'mobile' => $application->mobile,
                'subdomain' => strtolower($application->preferred_subdomain),
                
                'db_name' => $dbName,
                'db_host' => $dbHost,
                'db_username' => $dbUsername,
                'db_password' => encrypt($dbPassword),
                
                'plan_id' => $application->plan_id,
                'reseller_id' => null,
                
                'onboarding_status' => 'approved',
                'go_live_date' => $application->go_live_date ?? now(),
                'expiry_date' => $application->expiry_date ?? now()->addMonth(),
                
                'status' => 'active',
            ]);

            // Send welcome email
            try {
                \Mail::to($tenant->email)->send(new \App\Mail\TenantWelcomeMail($tenant));
            } catch (\Exception $e) {
                Log::warning('Failed to send welcome email', [
                    'tenant_id' => $tenant->id,
                    'error' => $e->getMessage()
                ]);
            }

            // Delete application after successful tenant creation
            $application->delete();
        });
    }

    private function updateAndApproveRequest(array $validated, TenantApplication $application): void
    {
        DB::transaction(function () use ($validated, $application) {
            // Update application first
            $this->updateRequest($validated, $application);
            
            // Prepare DB credentials if provided
            $dbCredentials = [];
            if (isset($validated['db_name'])) {
                $dbCredentials = [
                    'db_name' => $validated['db_name'],
                    'db_host' => $validated['db_host'],
                    'db_username' => $validated['db_username'],
                    'db_password' => $validated['db_password'] ?? config('database.connections.mysql.password'),
                ];
            }
            
            // Approve and create tenant
            $this->approveRequest($application, $dbCredentials);
        });
    }
}
