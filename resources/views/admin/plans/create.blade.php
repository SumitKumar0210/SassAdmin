@extends('admin.layouts.app')

@section('title', 'Plan Creation')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{asset('admin/assets//css/vendors/tagify.css')}}">
@endsection

@section('content')
<div class="page-body">
    <div class="container-fluid">

        {{-- Page Title --}}
        <div class="page-title">
            <h3>Plan Creation</h3>
        </div>

        <div class="row">
            <div class="col-xl-12">
                {{-- Success --}}
                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                {{-- Errors --}}
                @if ($errors->any())
                <!-- <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div> -->
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Create New Plan</h4>
                        <p class="f-m-light mt-1">Configure subscription plan details and available modules</p>
                    </div>

                    <form id="planForm"
                        method="POST"
                        action="{{ route('admin.plans.store') }}"
                        class="needs-validation custom-input"
                        novalidate>
                        @csrf

                        <div class="card-body">
                            <div class="row">

                                {{-- Plan Name --}}
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Plan Name <span class="text-danger">*</span></label>
                                    <input type="text"
                                        name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}"
                                        required
                                        minlength="3"
                                        maxlength="100"
                                        pattern="[A-Za-z0-9\s\-&.]+">
                                    @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Please enter a valid plan name (3–100 characters)</div>
                                    @enderror
                                </div>

                                {{-- Price --}}
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Price <span class="text-danger">*</span></label>
                                    <input type="number"
                                        step="0.01"
                                        min="0"
                                        name="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price') }}"
                                        required>
                                    @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Please enter a valid price</div>
                                    @enderror
                                </div>

                                {{-- Billing Cycle --}}
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Billing Cycle <span class="text-danger">*</span></label>
                                    <select name="billing_cycle" class="form-select @error('billing_cycle') is-invalid @enderror" required>
                                        <option value="">Select Billing Cycle</option>
                                        <option value="monthly" {{ old('billing_cycle') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        <option value="quarterly" {{ old('billing_cycle') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                        <option value="half_yearly" {{ old('billing_cycle') == 'half_yearly' ? 'selected' : '' }}>Half Yearly</option>
                                        <option value="yearly" {{ old('billing_cycle') == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                    </select>
                                    @error('billing_cycle')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Please select billing cycle</div>
                                    @enderror
                                </div>

                                {{-- Modules --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Modules <span class="text-danger">*</span></label>
                                    <input id="modulesInput"
                                    value="{{ old('modules') }}"
                                        name="modules_tagify"
                                        class="form-control @error('modules') is-invalid @enderror"
                                        placeholder="Select modules"
                                        required>

                                    <input type="hidden" name="modules" id="modulesHidden">
                                    @error('modules')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Please select at least one module</div>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Create Plan
                            </button>
                            <a href="{{ route('admin.plans.index') }}" class="btn btn-light">
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

<script src="{{asset('admin/assets//js/select2/tagify.js')}}"></script>
<script src="{{asset('admin/assets//js/select2/tagify.polyfills.min.js')}}"></script>
<script src="{{asset('admin/assets//js/select2/intltelinput.min.js')}}"></script>
<script src="{{asset('admin/assets//js/select2/telephone-input.js')}}"></script>
<script src="{{asset('admin/assets//js/select2/custom-inputsearch.js')}}"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const input = document.getElementById('modulesInput');
    const hiddenInput = document.getElementById('modulesHidden');
    const form = document.getElementById('planForm');

    const tagify = new Tagify(input, {
        whitelist: [
            "Dashboard","Room Management","Booking System","Front Desk",
            "Housekeeping","Restaurant/POS","Inventory Management",
            "Account Management","HR & Payroll","Reports & Analytics",
            "Customer Management (CRM)","Channel Manager","Rate Management",
            "Revenue Management","Maintenance","Laundry Management",
            "Spa Management","Event Management","Loyalty Program",
            "Mobile App","Online Booking Engine","Payment Gateway",
            "SMS/Email Notifications","Multi-Property","Multi-Currency",
            "Multi-Language","API Access","Custom Reports",
            "Backup & Restore","Security & Access Control"
        ],
        enforceWhitelist: true,
        dropdown: {
            maxItems: Infinity,
            enabled: 0,
            closeOnSelect: false
        }
    });

    @if(old('modules'))
        tagify.addTags(@json(old('modules')));
    @endif

    form.addEventListener('submit', function (e) {

        let valid = true;

        if (!form.checkValidity()) {
            valid = false;
        }
        if (tagify.value.length === 0) {
            input.classList.add('is-invalid');
            input.setCustomValidity('Please select at least one module');
            valid = false;
        } else {
            input.classList.remove('is-invalid');
            input.setCustomValidity('');

            hiddenInput.value = JSON.stringify(
                tagify.value.map(item => item.value)
            );
        }

        if (!valid) {
            e.preventDefault();
            e.stopPropagation();
        }

        form.classList.add('was-validated');
    });

});
</script>


@endsection