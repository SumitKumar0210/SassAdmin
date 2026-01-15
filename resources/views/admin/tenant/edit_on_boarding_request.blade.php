@extends('admin.layouts.app')

@section('title', 'Edit Tenant')

@section('content')
<div class="page-body">
    <div class="container-fluid">

        <div class="page-title">
            <h3>Edit Tenant / Onboarding Request</h3>
        </div>

        {{-- Display Errors --}}
        @if ($errors->any())
        <div class="alert alert-light-danger alert-dismissible fade show" role="alert">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Success Message --}}
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-success" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Error Message --}}
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-danger" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4>Tenant Details</h4>
            </div>

            <form id="tenantForm"
                  method="POST"
                  action=""
                  class="needs-validation"
                  novalidate>
                @csrf

                <div class="card-body">
                    <div class="row">

                        {{-- ================= BASIC INFO ================= --}}
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Hotel Name *</label>
                            <input type="text" 
                                   name="hotel_name" 
                                   class="form-control @error('hotel_name') is-invalid @enderror"
                                   value="{{ old('hotel_name', $tenant->hotel_name) }}" 
                                   required 
                                   minlength="3"
                                   maxlength="255">
                            @error('hotel_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Legal Name</label>
                            <input type="text" 
                                   name="legal_name" 
                                   class="form-control @error('legal_name') is-invalid @enderror"
                                   value="{{ old('legal_name', $tenant->legal_name) }}"
                                   maxlength="255">
                            @error('legal_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Owner Name *</label>
                            <input type="text" 
                                   name="woner_name" 
                                   class="form-control @error('woner_name') is-invalid @enderror"
                                   value="{{ old('woner_name', $tenant->woner_name) }}" 
                                   required
                                   minlength="2"
                                   maxlength="255">
                            @error('woner_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" 
                                   name="email" 
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $tenant->email) }}" 
                                   required
                                   maxlength="255">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Mobile *</label>
                            <input type="text" 
                                   name="mobile" 
                                   class="form-control @error('mobile') is-invalid @enderror"
                                   value="{{ old('mobile', $tenant->phone) }}"
                                   pattern="[0-9]{10}" 
                                   required
                                   maxlength="10"
                                   placeholder="10-digit mobile number">
                            @error('mobile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Preferred Subdomain *</label>
                            <div class="input-group">
                                <input type="text" 
                                       name="preferred_subdomain" 
                                       class="form-control @error('preferred_subdomain') is-invalid @enderror"
                                       value="{{ old('preferred_subdomain', $tenant->preferred_subdomain) }}"
                                       pattern="[a-z0-9\-]+" 
                                       required
                                       minlength="3"
                                       maxlength="63"
                                       placeholder="myhotel">
                                <span class="input-group-text">.yourdomain.com</span>
                                @error('preferred_subdomain')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Only lowercase letters, numbers, and hyphens</small>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Plan *</label>
                            <select name="plan_id" 
                                    class="form-select @error('plan_id') is-invalid @enderror" 
                                    required>
                                <option value="">Select Plan</option>
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}"
                                        {{ old('plan_id', $tenant->plan_id) == $plan->id ? 'selected' : '' }}>
                                        {{ $plan->name }} - {{ $plan->price }}/{{ $plan->billing_cycle }}
                                    </option>
                                @endforeach
                            </select>
                            @error('plan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Status *</label>
                            <select name="status" 
                                    class="form-select @error('status') is-invalid @enderror" 
                                    required>
                                @foreach(['pending','active','suspended','terminated'] as $st)
                                    <option value="{{ $st }}"
                                        {{ old('status', $tenant->status) === $st ? 'selected' : '' }}>
                                        {{ ucfirst($st) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Onboarding Status --}}
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Onboarding Status *</label>
                            <select name="onboarding_status" 
                                    class="form-select @error('onboarding_status') is-invalid @enderror" 
                                    required>
                                @foreach(['form_submitted','approved','live'] as $obs)
                                <option value="{{ $obs }}"
                                    {{ old('onboarding_status', $tenant->onboarding_status) === $obs ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_',' ',$obs)) }}
                                </option>
                                @endforeach
                            </select>
                            @error('onboarding_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dates --}}
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Go Live Date</label>
                            <input type="date" 
                                   name="go_live_date"
                                   class="form-control @error('go_live_date') is-invalid @enderror"
                                   value="{{ old('go_live_date', $tenant->go_live_date) }}"
                                   min="{{ date('Y-m-d') }}">
                            @error('go_live_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Expiry Date</label>
                            <input type="date" 
                                   name="expiry_date"
                                   class="form-control @error('expiry_date') is-invalid @enderror"
                                   value="{{ old('expiry_date', $tenant->expiry_date) }}">
                            @error('expiry_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- ================= DATABASE SECTION ================= --}}
                        <div class="col-12 mt-4">
                            <hr>
                            <h5>Database Configuration</h5>
                            <small class="text-muted">
                                Enable only if you want to change database credentials (applies only for Approve actions)
                            </small>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="changeDbToggle"
                                       name="changeDbToggle"
                                       value="1"
                                       {{ old('changeDbToggle') ? 'checked' : '' }}>
                                <label class="form-check-label" for="changeDbToggle">
                                    Update Database Credentials
                                </label>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">DB Name</label>
                            <input type="text" 
                                   name="db_name" 
                                   class="form-control db-field @error('db_name') is-invalid @enderror"
                                   value="{{ old('db_name', $tenant->db_name ?? 'tenant_db_' . strtolower($tenant->preferred_subdomain)) }}" 
                                   pattern="[a-zA-Z0-9_]+"
                                   maxlength="64"
                                   disabled>
                            @error('db_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">DB Host</label>
                            <input type="text" 
                                   name="db_host" 
                                   class="form-control db-field @error('db_host') is-invalid @enderror"
                                   value="{{ old('db_host', $tenant->db_host ?? config('database.connections.mysql.host')) }}" 
                                   disabled>
                            @error('db_host')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">DB Username</label>
                            <input type="text" 
                                   name="db_username" 
                                   class="form-control db-field @error('db_username') is-invalid @enderror"
                                   value="{{ old('db_username', $tenant->db_username ?? config('database.connections.mysql.username')) }}" 
                                   disabled>
                            @error('db_username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">DB Password</label>
                            <input type="password" 
                                   name="db_password"
                                   class="form-control"
                                   placeholder="Leave blank to keep existing"
                                   
                                   disabled>
                            <!-- @error('db_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimum 8 characters</small> -->
                        </div>

                        <div class="col-md-3 mb-3 d-flex align-items-end gap-2">
                            <button type="button" 
                                    class="btn btn-info" 
                                    id="checkDbBtn" 
                                    disabled>
                                <i class="fa fa-database"></i> Check Database
                            </button>
                            <span id="dbCheckStatus"></span>
                        </div>

                    </div>
                </div>

                {{-- ================= ACTION BUTTONS ================= --}}
                <div class="card-footer text-end">
                    <!-- <button type="submit" 
                            name="update" 
                            value="1" 
                            class="btn btn-primary">
                        <i class="fa fa-save"></i> Update Only
                    </button>

                    <button type="submit" 
                            name="approve" 
                            value="1" 
                            class="btn btn-success"
                            id="approveBtn">
                        <i class="fa fa-check"></i> Approve Only
                    </button> -->

                    <button type="submit" 
                            name="update_and_approve" 
                            value="1" 
                            class="btn btn-warning"
                            id="updateApproveBtn">
                        <i class="fa fa-check-double"></i> Update & Approve
                    </button>

                    <a href="{{ route('tenant.onBoardingList') }}" 
                       class="btn btn-light">
                        <i class="fa fa-times"></i> Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form     = document.getElementById('tenantForm');
    const toggle   = document.getElementById('changeDbToggle');
    const dbFields = document.querySelectorAll('.db-field');
    const checkBtn = document.getElementById('checkDbBtn');
    const statusEl = document.getElementById('dbCheckStatus');
    const approveBtn = document.getElementById('approveBtn');
    const updateApproveBtn = document.getElementById('updateApproveBtn');

    let dbVerified = true; // existing DB is trusted by default

    // Toggle database fields
    toggle.addEventListener('change', function () {
        const isChecked = this.checked;
        
        dbFields.forEach(el => {
            el.disabled = !isChecked;
            if (isChecked) {
                el.required = true;
            } else {
                el.required = false;
                el.classList.remove('is-invalid', 'is-valid');
            }
        });
        
        checkBtn.disabled = !isChecked;

        if (isChecked) {
            dbVerified = false;
            statusEl.innerHTML = '<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Verification required</span>';
        } else {
            dbVerified = true;
            statusEl.innerHTML = '<span class="text-muted">Using existing database</span>';
        }
    });

    // Check database connection
    checkBtn.addEventListener('click', function () {
        const dbHost = document.querySelector('[name="db_host"]').value;
        const dbName = document.querySelector('[name="db_name"]').value;
        const dbUser = document.querySelector('[name="db_username"]').value;
        const dbPass = document.querySelector('[name="db_password"]').value;

        if (!dbHost || !dbName || !dbUser) {
            statusEl.innerHTML = '<span class="text-danger">✖ Please fill all DB fields</span>';
            return;
        }

        statusEl.innerHTML = '<span class="text-warning"><i class="fa fa-spinner fa-spin"></i> Checking...</span>';
        checkBtn.disabled = true;

        fetch('{{ route("admin.tenants.check-db") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                host: dbHost,
                database: dbName,
                username: dbUser,
                password: dbPass || null,
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                statusEl.innerHTML = '<span class="text-success"><i class="fa fa-check-circle"></i> Connected</span>';
                dbVerified = true;
            } else {
                statusEl.innerHTML = '<span class="text-danger"><i class="fa fa-times-circle"></i> ' + data.message + '</span>';
                dbVerified = false;
            }
        })
        .catch(error => {
            statusEl.innerHTML = '<span class="text-danger"><i class="fa fa-times-circle"></i> Connection failed</span>';
            dbVerified = false;
        })
        .finally(() => {
            checkBtn.disabled = false;
        });
    });

    // Form submission validation
    form.addEventListener('submit', function (e) {
        // Check if form is valid
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
            form.classList.add('was-validated');

            // Scroll to first invalid field
            const firstInvalid = form.querySelector(':invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstInvalid.focus();
            }
            return false;
        }

        // Check database verification for approve actions
        const submitter = e.submitter;
        if (submitter && (submitter.name === 'approve' || submitter.name === 'update_and_approve')) {
            if (toggle.checked && !dbVerified) {
                e.preventDefault();
                alert('⚠️ Please verify database connection before approving!');
                statusEl.innerHTML = '<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Verification required</span>';
                return false;
            }
        }

        form.classList.add('was-validated');
    });

    // Real-time validation feedback
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });

        input.addEventListener('input', function() {
            if (this.classList.contains('was-validated') || this.classList.contains('is-invalid')) {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            }
        });
    });

    // Subdomain formatting
    const subdomainInput = document.querySelector('[name="preferred_subdomain"]');
    if (subdomainInput) {
        subdomainInput.addEventListener('input', function() {
            this.value = this.value.toLowerCase().replace(/[^a-z0-9\-]/g, '');
        });
    }

    // Mobile formatting
    const mobileInput = document.querySelector('[name="mobile"]');
    if (mobileInput) {
        mobileInput.addEventListener('input', function() {
            this.value = this.value.replace(/\D/g, '').substring(0, 10);
        });
    }

    // Expiry date validation
    const goLiveDate = document.querySelector('[name="go_live_date"]');
    const expiryDate = document.querySelector('[name="expiry_date"]');
    
    if (goLiveDate && expiryDate) {
        goLiveDate.addEventListener('change', function() {
            if (this.value) {
                expiryDate.min = this.value;
            }
        });
    }

});
</script>
@endsection