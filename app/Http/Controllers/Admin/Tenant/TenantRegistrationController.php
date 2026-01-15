<?php

namespace App\Http\Controllers\Admin\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Tenant;
use App\Models\Admin\State;
use App\Models\Admin\TenantApplication;
use App\Models\Admin\Plan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use App\Helpers\Admin\DatabaseHelper;
use App\Jobs\SendWelcomeMailJob;
use App\Jobs\SendWelcomeMailByAdminJob;
use App\Mail\TenantWelcomeMail;
use App\Mail\TenantLiveMail;
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

                'phone' => [
                    'required',
                    'digits:10',
                    'unique:tenant_applications,phone',
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
                'phone'              => $validated['phone'],
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
        $states = State::all();
        return view('admin.tenant.registration', compact('plans', 'states'));
    }

    public function storeTenantByAdmin(Request $request)
    {
        try {

            $validated = $request->validate(
                [
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
                    'state_id' => 'required|exists:states,id',
                    'city' => 'required|string|min:2|max:100',
                    'source' => 'nullable|in:website,reseller,referral',

                    'reseller_id' => 'nullable|integer|exists:resellers,id',

                    'onboarding_status' => 'nullable|boolean',
                    'expiry_date'       => 'nullable|date|after:today',
                    'go_live_date'      => 'nullable|date',
                    'status'            => 'required|in:active,inactive,suspended',
                ],
                [
                    'hotel_name.required' => 'Hotel name is required.',
                    'hotel_name.string'   => 'Hotel name must be a valid text.',
                    'hotel_name.max'      => 'Hotel name may not be greater than :max characters.',

                    'legal_name.string'   => 'Legal name must be a valid text.',
                    'legal_name.max'      => 'Legal name may not be greater than :max characters.',

                    'woner_name.required' => 'Owner name is required.',
                    'woner_name.string'   => 'Owner name must be a valid text.',
                    'woner_name.max'      => 'Owner name may not be greater than :max characters.',


                    'email.required' => 'Email address is required.',
                    'email.email'    => 'Please enter a valid email address.',
                    'email.max'      => 'Email address may not be greater than :max characters.',
                    'email.unique'   => 'This email address is already registered.',

                    'mobile.required'       => 'Mobile number is required.',
                    'mobile.digits_between' => 'Mobile number must be between :min and :max digits.',
                    'mobile.unique'         => 'This mobile number is already registered.',

                    'subdomain.required' => 'Subdomain is required.',
                    'subdomain.string'   => 'Subdomain must be a valid text.',
                    'subdomain.min'      => 'Subdomain must be at least :min characters.',
                    'subdomain.max'      => 'Subdomain may not be greater than :max characters.',
                    'subdomain.unique'   => 'This subdomain is already taken.',
                    'subdomain.regex'    => 'Subdomain may contain only lowercase letters, numbers, hyphens, and dots and must not start or end with a special character.',

                    'db_name.required' => 'Database name is required.',
                    'db_name.string'   => 'Database name must be a valid text.',
                    'db_name.unique'   => 'This database name is already in use.',

                    'db_host.required' => 'Database host is required.',
                    'db_host.string'   => 'Database host must be a valid text.',

                    'db_username.required' => 'Database username is required.',
                    'db_username.string'   => 'Database username must be a valid text.',
                    'db_username.min'      => 'Database username must be at least :min characters.',
                    'db_username.max'      => 'Database username may not be greater than :max characters.',

                    'db_password.string' => 'Database password must be a valid text.',
                    'db_password.min'    => 'Database password must be at least :min characters.',

                    'plan_id.required' => 'Please select a plan.',
                    'plan_id.integer'  => 'Invalid plan selected.',
                    'plan_id.exists'   => 'The selected plan does not exist.',

                    'state_id.required' => 'Please select a state.',
                    'state_id.exists'   => 'The selected state is invalid.',

                    'city.required' => 'City name is required.',
                    'city.string'   => 'City name must be a valid text.',
                    'city.min'      => 'City name must be at least :min characters.',
                    'city.max'      => 'City name may not be greater than :max characters.',

                    'source.required' => 'Please select a source.',
                    'source.in'       => 'Source must be Website, Reseller, or Referral.',

                    'reseller_id.integer' => 'Invalid reseller selected.',
                    'reseller_id.exists'  => 'The selected reseller does not exist.',

                    'onboarding_status.boolean' => 'Onboarding status must be true or false.',

                    'expiry_date.date'  => 'Expiry date must be a valid date.',
                    'expiry_date.after' => 'Expiry date must be a future date.',

                    'go_live_date.date' => 'Go live date must be a valid date.',

                    'status.required' => 'Please select a status.',
                    'status.in'       => 'Status must be Active, Inactive, or Suspended.',
                ]
            );

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
                'state_id'          => $validated['state_id'],
                'city'              => $validated['city'],
                'source'            => $validated['source'],
                'reseller_id'       => $validated['reseller_id'] ?? null,

                'onboarding_status' => 'approved',
                'go_live_date'      => $validated['go_live_date'] ?? null,
                'expiry_date'       => $validated['expiry_date'] ?? null,

                'status'            => $validated['status'],
            ]);

            SendWelcomeMailByAdminJob::dispatch($tenant->uuid);
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
    public function edit(Request $request, $uuid)
    {
        try {
            $tenant = Tenant::with('plan')->where('uuid', $uuid)->firstOrFail();
            $plans  = Plan::get();

            return view('admin.tenant.edit_tenant', compact('tenant', 'plans'));
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Tenant not found.');
        }
    }

    public function update(Request $request, $uuid)
    {
        // dd($request->all());

        try {
            $tenant = Tenant::where('uuid', $uuid)->firstOrFail();

            $validated = $request->validate([
                'hotel_name' => 'required|string|max:255',
                'legal_name' => 'nullable|string|max:255',
                'woner_name' => 'required|string|max:255',

                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('tenants', 'email')->ignore($tenant->id),
                ],

                'mobile' => [
                    'required',
                    'digits_between:10,15',
                    Rule::unique('tenants', 'mobile')->ignore($tenant->id),
                ],

                'subdomain' => [
                    'required',
                    'string',
                    'min:3',
                    'max:100',
                    'regex:/^[a-z0-9][a-z0-9\-.]*[a-z0-9]$/',
                    Rule::unique('tenants', 'subdomain')->ignore($tenant->id),
                ],

                'plan_id' => 'required|exists:plans,id',
                'reseller_id' => 'nullable|exists:resellers,id',

                'go_live_date' => 'nullable|date',
                'expiry_date' => 'nullable|date|after:today',
                'status' => 'required|in:active,inactive,suspended',
            ]);

            DB::beginTransaction();

            $tenant->update([
                'hotel_name' => $validated['hotel_name'],
                'legal_name' => $validated['legal_name'] ?? null,
                'woner_name' => $validated['woner_name'],
                'email' => $validated['email'],
                'mobile' => $validated['mobile'],
                'subdomain' => strtolower($validated['subdomain']),
                'plan_id' => $validated['plan_id'],
                'reseller_id' => $validated['reseller_id'] ?? null,
                'go_live_date' => $validated['go_live_date'] ?? null,
                'expiry_date' => $validated['expiry_date'] ?? null,
                'status' => $validated['status'],
                'onboarding_status' => $request->onboarding_status,
            ]);

            DB::commit();

            return redirect()
                ->route('tenant.list')
                ->with('success', 'Tenant updated successfully!');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Throwable $e) {

            DB::rollBack();

            Log::error('Tenant update failed', [
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->with('error', 'Failed to update tenant.')
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
            $states = State::all();

            $tenant = TenantApplication::with('plan')->find($id);

            if (!$tenant) {
                return redirect()->back()
                    ->with('error', 'Request not found.');
            }

            return view('admin.tenant.edit_on_boarding_request', compact('tenant', 'plans', 'states'));
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

    // public function approveTenantApplication($applicationId)
    // {
    //     try {
    //         DB::beginTransaction();

    //         $application = TenantApplication::findOrFail($applicationId);

    //         if ($application->status == 2) {
    //             return redirect()->back()
    //                 ->with('error', 'Tenant already approved.');
    //         }

    //         $tenant = Tenant::create([
    //             'uuid'                => (string) Str::uuid(),
    //             'hotel_name'          => $application->hotel_name,
    //             'woner_name'          => $application->woner_name,
    //             'email'               => $application->email,
    //             'mobile'              => $application->phone,
    //             'subdomain'           => strtolower($application->preferred_subdomain),
    //             'plan_id'             => $application->plan_id,
    //             'onboarding_status'   => 'approved',
    //             'status'              => 'active',
    //         ]);

    //         $application->update([
    //             'status' => 2,
    //         ]);

    //         DB::commit();

    //         return redirect()->back()
    //             ->with('success', 'Tenant approved and onboarded successfully.');
    //     } catch (\Throwable $e) {

    //         DB::rollBack();

    //         Log::error('Tenant approval failed', [
    //             'error' => $e->getMessage(),
    //         ]);

    //         return redirect()->back()
    //             ->with('error', 'Failed to approve tenant.');
    //     }
    // }


    public function approveAndUpdate(Request $request, $id)
    {
        // dd($request->all());
        $validated = $request->validate([
            'hotel_name' => 'required|string|max:255',
            'legal_name' => 'nullable|string|max:255',
            'woner_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|digits_between:10,15',
            'preferred_subdomain' => 'required|string|min:3|max:100',
            'plan_id' => 'required|exists:plans,id',
            'changeDbToggle' => 'nullable|boolean',
            'db_name' => 'required_if:changeDbToggle,1|string|max:64',
            'db_host' => 'required_if:changeDbToggle,1|string',
            'db_username' => 'required_if:changeDbToggle,1|string|max:32',
            'status' => 'required|in:pending,approved,rejected',
            'go_live_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:go_live_date',
        ]);

        DB::beginTransaction();

        try {
            // Find the tenant request with a lock to prevent race conditions
            $tenantRequest = TenantApplication::lockForUpdate()->findOrFail($id);

            // Check if the status transition is valid
            if (!in_array($validated['status'], ['approved', 'rejected', 'pending'])) {
                throw new \Exception('Invalid status transition');
            }

            // Prepare common update data
            $updateData = [
                'hotel_name' => $validated['hotel_name'],
                'legal_name' => $validated['legal_name'] ?? null,
                'woner_name' => $validated['woner_name'],
                'email' => $validated['email'],
                'mobile' => $validated['mobile'],
                'preferred_subdomain' => $validated['preferred_subdomain'],
                'plan_id' => $validated['plan_id'],

            ];

            // Add date fields if provided
            if ($request->has('go_live_date')) {
                $updateData['go_live_date'] = $request->go_live_date;
            }

            if ($request->has('expiry_date')) {
                $updateData['expiry_date'] = $request->expiry_date;
            }

            // Update tenant application
            $tenantRequest->update($updateData);

            $tenant = null;

            $uuid = (string) Str::uuid();
            if ($request->db_name) {
                // Prepare tenant data
                $tenantData = array_merge($updateData, [
                    'uuid' => $uuid,
                    'city' => $tenantRequest->city,
                    'state_id' => $tenantRequest->state_id,
                    'source' => $tenantRequest->source,
                    'room_count' => $tenantRequest->room_count,
                    'subdomain' => $validated['preferred_subdomain'],
                    'status' => 'active',
                    'onboarding_status' => 'approved',
                ]);

                // Add database credentials if toggled
                if ($request->boolean('changeDbToggle')) {
                    $tenantData = array_merge($tenantData, [
                        'db_name' => $validated['db_name'],
                        'db_host' => $validated['db_host'],
                        'db_username' => $validated['db_username'],
                    ]);
                }

                // Update or create tenant
                $tenant = Tenant::updateOrCreate(
                    ['email' => $validated['email']],
                    $tenantData
                );

                // Update tenant request with approval metadata
                $tenantRequest->update([
                    'status' => 'approved',
                    // 'approved_at' => now(),
                    // 'approved_by' => auth()->id(),
                ]);
            }

            DB::commit();

            // Send welcome email only if tenant was approved and created
            if ($tenant) {
                // SendWelcomeMailByAdminJob::dispatch($tenant->uuid)
                //     ->onQueue('emails');
                Mail::to('sumitkrtechie@gmail.com')->send(
                    new TenantLiveMail($tenant)
                );
                \Log::info('Tenant live email sent to ' . $tenant->email);
            }

            $message = $validated['status'] === 'approved'
                ? 'Tenant approved and onboarded successfully.'
                : 'Tenant application updated.';

            return redirect()
                ->back()
                ->with('success', $message);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Tenant application not found.');
        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Tenant approval failed', [
                'application_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to process the request: ' . $e->getMessage());
        }
    }
}
