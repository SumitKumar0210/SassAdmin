@extends('admin.layouts.app')

@section('title', 'Edit Plan')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/vendors/tagify.css') }}">
@endsection

@section('content')
<div class="page-body">
    <div class="container-fluid">

        <div class="page-title">
            <h3>Edit Plan</h3>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card">

                    <div class="card-header">
                        <h4>Edit Plan</h4>
                        <p class="f-m-light mt-1">Update subscription plan details and modules</p>
                    </div>

                    <form id="planForm"
                          method="POST"
                          action="{{ route('admin.plans.update', $plan->id) }}"
                          class="needs-validation custom-input"
                          novalidate>
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="row">

                                {{-- Plan Name --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Plan Name <span class="text-danger">*</span></label>
                                    <input type="text"
                                           name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $plan->name) }}"
                                           required minlength="3" maxlength="100">
                                    @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Please enter a valid plan name</div>
                                    @enderror
                                </div>

                                {{-- Price --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Price <span class="text-danger">*</span></label>
                                    <input type="number"
                                           step="0.01"
                                           min="0"
                                           name="price"
                                           class="form-control @error('price') is-invalid @enderror"
                                           value="{{ old('price', $plan->price) }}"
                                           required>
                                    @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Please enter a valid price</div>
                                    @enderror
                                </div>

                                {{-- Billing Cycle --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Billing Cycle <span class="text-danger">*</span></label>
                                    <select name="billing_cycle"
                                            class="form-select @error('billing_cycle') is-invalid @enderror"
                                            required>
                                        <option value="">Select Billing Cycle</option>
                                        <option value="monthly" @selected(old('billing_cycle', $plan->billing_cycle) === 'monthly')>Monthly</option>
                                        <option value="quarterly" @selected(old('billing_cycle', $plan->billing_cycle) === 'quarterly')>Quarterly</option>
                                        <option value="half_yearly" @selected(old('billing_cycle', $plan->billing_cycle) === 'half_yearly')>Half Yearly</option>
                                        <option value="yearly" @selected(old('billing_cycle', $plan->billing_cycle) === 'yearly')>Yearly</option>
                                    </select>
                                    @error('billing_cycle')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Please select billing cycle</div>
                                    @enderror
                                </div>
                                
                                {{-- Status --}}
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status"
                                            class="form-select @error('status') is-invalid @enderror"
                                            required>
                                        <option value="">Choose...</option>
                                        <option value="active" @selected(old('status', $plan->status) === 'active')>Active</option>
                                        <option value="inactive" @selected(old('status', $plan->status) === 'inactive')>Inactive</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @else
                                    <div class="invalid-feedback">Please select status</div>
                                    @enderror
                                </div>

                                {{-- Modules --}}
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Modules <span class="text-danger">*</span></label>
                                    <input id="modulesInput"
                                           class="form-control @error('modules') is-invalid @enderror"
                                           placeholder="Select modules">
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
                                <i class="fa fa-save"></i> Update Plan
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
<script src="{{ asset('admin/assets/js/select2/tagify.js') }}"></script>
<script src="{{ asset('admin/assets/js/select2/tagify.polyfills.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('planForm');
    const modulesInput = document.getElementById('modulesInput');
    const modulesHidden = document.getElementById('modulesHidden');

    // Tagify init
    const tagify = new Tagify(modulesInput, {
        whitelist: [
            "Dashboard", "Room Management", "Booking System", "Front Desk",
            "Housekeeping", "Restaurant/POS", "Inventory Management",
            "Account Management", "HR & Payroll", "Reports & Analytics",
            "Customer Management (CRM)", "Channel Manager", "Rate Management",
            "Revenue Management", "Maintenance", "Laundry Management",
            "Spa Management", "Event Management", "Loyalty Program",
            "Mobile App", "Online Booking Engine", "Payment Gateway",
            "SMS/Email Notifications", "Multi-Property", "Multi-Currency",
            "Multi-Language", "API Access", "Custom Reports",
            "Backup & Restore", "Security & Access Control"
        ],
        enforceWhitelist: true,
        dropdown: { enabled: 0 }
    });

    // Load existing modules
    const existingModules = @json(old('modules', $plan->modules ?? []));
    if (existingModules.length) {
        tagify.addTags(existingModules);
        modulesHidden.value = JSON.stringify(existingModules);
    }

    // Bootstrap + custom validation
    form.addEventListener('submit', function (e) {

        let isValid = true;

        // Bootstrap validation
        if (!form.checkValidity()) {
            isValid = false;
        }

        // Tagify validation
        if (tagify.value.length === 0) {
            modulesInput.classList.add('is-invalid');
            isValid = false;
        } else {
            modulesInput.classList.remove('is-invalid');
            modulesHidden.value = JSON.stringify(
                tagify.value.map(tag => tag.value)
            );
        }

        if (!isValid) {
            e.preventDefault();
            e.stopPropagation();
        }

        form.classList.add('was-validated');
    });

});
</script>
@endsection

