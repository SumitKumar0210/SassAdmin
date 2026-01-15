@extends('admin.layouts.app')

@section('title', 'Create New Tenant')

@section('styles')
{{-- Page-specific CSS --}}
@endsection

@section('content')
<div class="page-body">
    <div class="container-fluid">

        {{-- Page Title --}}
        <div class="page-title">
            <h3>Tenant Registration</h3>
        </div>

        <div class="row">
            <div class="col-xl-12">
                {{-- Success --}}
                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Errors --}}
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show text-danger" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Create New Tenant</h4>
                    </div>

                    <form id="tenantForm" method="POST" action="{{route('register.tenant')}}" class="needs-validation custom-input" novalidate="">
                        @csrf

                        <div class="card-body">
                            <div class="row">

                                {{-- Basic Info --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Hotel Name <span class="text-danger">*</span></label>
                                    <input type="text" name="hotel_name"
                                        class="form-control @error('hotel_name') is-invalid @enderror"
                                        value="{{ old('hotel_name') }}"
                                        required
                                        minlength="3"
                                        maxlength="100"
                                        pattern="[A-Za-z0-9\s\-&.]+"
                                        title="Hotel name should contain only letters, numbers, spaces, hyphens, ampersands, and periods">
                                    @error('hotel_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Please enter a valid hotel name (3-100 characters)</div>

                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Legal Name</label>
                                    <input type="text" name="legal_name"
                                        class="form-control"
                                        value="{{ old('legal_name') }}"
                                        minlength="3"
                                        maxlength="150">

                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Owner Name <span class="text-danger">*</span></label>
                                    <input type="text" name="woner_name"
                                        class="form-control @error('woner_name') is-invalid @enderror"
                                        value="{{ old('woner_name') }}"
                                        required
                                        minlength="3"
                                        maxlength="100"
                                        pattern="[A-Za-z\s.]+"
                                        title="Owner name should contain only letters, spaces, and periods">
                                    @error('woner_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Please enter a valid owner name (3-100 characters, letters only)</div>

                                    @enderror
                                </div>

                                {{-- Contact --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}"
                                        required
                                        pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                                        title="Please enter a valid email address">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Please enter a valid email address</div>

                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Mobile <span class="text-danger">*</span></label>
                                    <input type="text" name="mobile"
                                        class="form-control @error('mobile') is-invalid @enderror"
                                        value="{{ old('mobile') }}"
                                        required
                                        pattern="[0-9]{10}"
                                        minlength="10"
                                        maxlength="10"
                                        title="Please enter a valid mobile number (10 digits)">
                                    @error('mobile')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Please enter a valid mobile number (10 digits)</div>

                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Subdomain <span class="text-danger">*</span></label>
                                    <input type="text" name="subdomain"
                                        class="form-control @error('subdomain') is-invalid @enderror"
                                        value="{{ old('subdomain') }}"
                                        required
                                        pattern="[a-z0-9\-.]+"
                                        minlength="3"
                                        maxlength="100"
                                        title="Subdomain should contain only lowercase letters, numbers, hyphens, and periods">
                                    @error('subdomain')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Please enter a valid subdomain (3-100 characters, lowercase letters, numbers, hyphens, and periods only)</div>
                                    @enderror
                                </div>

                                {{-- DB --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">DB Name <span class="text-danger">*</span></label>
                                    <input type="text" name="db_name"
                                        class="form-control @error('db_name') is-invalid @enderror"
                                        value="{{ old('db_name') }}"
                                        required
                                        pattern="[a-zA-Z0-9_]+"
                                        minlength="3"
                                        maxlength="64"
                                        title="Database name should contain only letters, numbers, and underscores">
                                    @error('db_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Please enter a valid database name (3-64 characters, letters, numbers, and underscores only)</div>

                                    @enderror
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">DB Host <span class="text-danger">*</span></label>
                                    <input type="text" name="db_host"
                                        class="form-control"
                                        value="{{ old('db_host','127.0.0.1') }}"
                                        required
                                        title="Database host (IP address or hostname)">
                                    <div class="invalid-feedback">Please enter a valid database host</div>

                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">DB Username <span class="text-danger">*</span></label>
                                    <input type="text" name="db_username"
                                        class="form-control"
                                        required
                                        minlength="3"
                                        maxlength="32"
                                        pattern="[a-zA-Z0-9_]+"
                                        title="Database username should contain only letters, numbers, and underscores">
                                    <div class="invalid-feedback">Please enter a valid database username (3-32 characters, letters, numbers, and underscores only)</div>

                                </div>

                                <div class="col-md-3 mb-3">
                                    <label class="form-label">DB Password</label>
                                    <input type="password" name="db_password"
                                        class="form-control"
                                        minlength="6"
                                        maxlength="255"
                                        title="Database password (optional, minimum 6 characters if provided)">
                                    <div class="invalid-feedback">Password should be at least 6 characters</div>

                                </div>

                                {{-- DB Check Button --}}
                                <div class="col-md-3 mb-3 d-flex align-items-end gap-2">
                                    <button type="button" class="btn btn-info" id="checkDbBtn">
                                        <i class="fa fa-database"></i> Check Database
                                    </button>
                                    <span id="dbCheckStatus"></span>
                                </div>

                                {{-- State --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">State <span class="text-danger">*</span></label>
                                    <select name="state_id"
                                        class="form-select @error('state_id') is-invalid @enderror"
                                        required>
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->id }}"
                                                {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                                {{ $state->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('state_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback">Please select a state</div>
                                    @enderror
                                </div>

                                {{-- City --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">City <span class="text-danger">*</span></label>
                                    <input type="text"
                                        name="city"
                                        class="form-control @error('city') is-invalid @enderror"
                                        value="{{ old('city') }}"
                                        required
                                        minlength="2"
                                        maxlength="100"
                                        pattern="[A-Za-z\s.]+"
                                        title="City name should contain only letters and spaces">

                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback">Please enter a valid city name</div>
                                    @enderror
                                </div>


                                {{-- Source --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Source <span class="text-danger">*</span></label>
                                    <select name="source"
                                        class="form-select @error('source') is-invalid @enderror"
                                        required>
                                        <option value="">Select Source</option>
                                        <option value="website" {{ old('source') == 'website' ? 'selected' : '' }}>Website</option>
                                        <option value="reseller" {{ old('source') == 'reseller' ? 'selected' : '' }}>Reseller</option>
                                        <option value="referral" {{ old('source') == 'referral' ? 'selected' : '' }}>Referral</option>
                                    </select>

                                    @error('source')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback">Please select a source</div>
                                    @enderror
                                </div>


                                {{-- Plan --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Plan <span class="text-danger">*</span></label>
                                    <select name="plan_id" class="form-select" required>
                                        <option value="">Select Plan</option>
                                        @foreach($plans as $plan)
                                        <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                            {{ $plan->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a plan</div>

                                </div>

                                {{-- Status --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select" required>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                    </select>
                                    <div class="invalid-feedback">Please select a status</div>

                                </div>

                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" id="submitTenantBtn" class="btn btn-primary" disabled>
                                <i class="fa fa-save"></i> Create Tenant
                            </button>
                            <a href="/" class="btn btn-light">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    // Existing vanilla JS for database check
    document.addEventListener('DOMContentLoaded', function() {

        const checkBtn = document.getElementById('checkDbBtn');
        const submitBtn = document.getElementById('submitTenantBtn');
        const statusEl = document.getElementById('dbCheckStatus');

        submitBtn.disabled = true;

        checkBtn.addEventListener('click', function() {

            statusEl.innerHTML = '<span class="text-warning"><i class="fa fa-spinner fa-spin"></i> Checking...</span>';
            checkBtn.disabled = true;

            fetch('{{ route("admin.tenants.check-db") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        host: document.querySelector('[name="db_host"]').value,
                        database: document.querySelector('[name="db_name"]').value,
                        username: document.querySelector('[name="db_username"]').value,
                        password: document.querySelector('[name="db_password"]').value,
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        statusEl.innerHTML = '<span class="text-success">✔ Connected</span>';
                        submitBtn.disabled = false;
                    } else {
                        statusEl.innerHTML = '<span class="text-danger"><i class="fa fa-times-circle"></i> ' + data.message + '</span>';
                        submitBtn.disabled = true;
                    }
                    checkBtn.disabled = false;
                })
                .catch(() => {
                    statusEl.innerHTML = '<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Error checking DB</span>';
                    submitBtn.disabled = true;
                    checkBtn.disabled = false;
                });
        });
    });

    // jQuery validation
    $(document).ready(function() {

        // Convert subdomain to lowercase on input
        $('[name="subdomain"]').on('input', function() {
            $(this).val($(this).val().toLowerCase());
        });

        // Format mobile number (remove non-digits)
        $('[name="mobile"]').on('input', function() {
            $(this).val($(this).val().replace(/\D/g, ''));
        });

        // Custom jQuery validation for the form
        $('#tenantForm').on('submit', function(event) {
            var form = $(this)[0];

            // Check if submit button is disabled (DB not checked)
            if ($('#submitTenantBtn').prop('disabled')) {
                event.preventDefault();
                event.stopPropagation();
                alert('Please check the database connection first!');
                return false;
            }

            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
                $(form).addClass('was-validated');

                // Scroll to first invalid field
                var firstInvalid = $(form).find(':invalid').first();
                if (firstInvalid.length) {
                    $('html, body').animate({
                        scrollTop: firstInvalid.offset().top - 100
                    }, 500);
                    firstInvalid.focus();
                }

                return false;
            }

            $(form).addClass('was-validated');
            // Allow form to submit normally
        });

        // Real-time validation feedback on input
        $('#tenantForm input, #tenantForm select, #tenantForm textarea').on('blur change', function() {
            if (this.checkValidity()) {
                $(this).addClass('is-valid').removeClass('is-invalid');
            } else {
                $(this).addClass('is-invalid').removeClass('is-valid');
            }
        });

        // Additional custom validations

        // Email validation
        $('[name="email"]').on('blur', function() {
            var email = $(this).val();
            var emailPattern = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;

            if (email && !emailPattern.test(email)) {
                this.setCustomValidity('Please enter a valid email address');
            } else {
                this.setCustomValidity('');
            }
        });

        // Subdomain validation - allow dots for full domains
        $('[name="subdomain"]').on('blur', function() {
            var subdomain = $(this).val();
            var subdomainPattern = /^[a-z0-9\-.]+$/;

            if (subdomain && !subdomainPattern.test(subdomain)) {
                this.setCustomValidity('Subdomain should contain only lowercase letters, numbers, hyphens, and periods');
            } else if (subdomain && subdomain.length < 3) {
                this.setCustomValidity('Subdomain must be at least 3 characters');
            } else {
                this.setCustomValidity('');
            }
        });

        // Database name validation
        $('[name="db_name"]').on('blur', function() {
            var dbName = $(this).val();
            var dbNamePattern = /^[a-zA-Z0-9_]+$/;

            if (dbName && !dbNamePattern.test(dbName)) {
                this.setCustomValidity('Database name should contain only letters, numbers, and underscores');
            } else {
                this.setCustomValidity('');
            }
        });

        // Mobile number validation
        $('[name="mobile"]').on('blur', function() {
            var mobile = $(this).val();

            if (mobile && mobile.length !== 10) {
                this.setCustomValidity('Mobile number should be exactly 10 digits');
            } else if (mobile && !/^[0-9]+$/.test(mobile)) {
                this.setCustomValidity('Mobile number should contain only digits');
            } else {
                this.setCustomValidity('');
            }
        });
    });
</script>

@endsection