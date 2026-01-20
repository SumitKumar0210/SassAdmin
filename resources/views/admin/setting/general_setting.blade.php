@extends('admin.layouts.app')
@section('title', 'Application Configuration')

@section('content')
<div class="page-body">
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="page-title mb-4">
            <h3 class="fw-bold">Application Configuration</h3>
            <p class="text-muted mb-0">Manage hotel, invoice & system settings</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST"
              action="{{ route('admin.settings.update') }}"
              enctype="multipart/form-data"
              class="needs-validation"
              novalidate
              id="configForm">
            @csrf

            {{-- BASIC DETAILS --}}
            <div class="card mb-4">
                <div class="card-header"><h5>Basic Details</h5></div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Hotel Name *</label>
                            <input type="text" name="name"
                                   value="{{ old('name', $config->name) }}"
                                   class="form-control" required minlength="3">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">GST Number</label>
                            <input type="text" name="gst"
                                   value="{{ old('gst', $config->gst) }}"
                                   class="form-control" maxlength="15">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $config->address) }}</textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input type="text" name="city"
                                   value="{{ old('city', $config->city) }}"
                                   class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input type="text" name="state"
                                   value="{{ old('state', $config->state) }}"
                                   class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Pincode</label>
                            <input type="text" name="pincode"
                                   value="{{ old('pincode', $config->pincode) }}"
                                   class="form-control" pattern="[0-9]{6}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Country</label>
                            <input type="text" name="country"
                                   value="{{ old('country', $config->country) }}"
                                   class="form-control">
                        </div>

                    </div>
                </div>
            </div>

            {{-- CONTACT DETAILS --}}
            <div class="card mb-4">
                <div class="card-header"><h5>Contact Details</h5></div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email"
                                   value="{{ old('email', $config->email) }}"
                                   class="form-control">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Mobile</label>
                            <input type="text" name="mobile"
                                   value="{{ old('mobile', $config->mobile) }}"
                                   class="form-control" pattern="[0-9]{10}">
                        </div>

                    </div>
                </div>
            </div>

            {{-- INVOICE SETTINGS --}}
            <div class="card mb-4">
                <div class="card-header"><h5>Invoice Settings</h5></div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Invoice Prefix *</label>
                            <input type="text" name="invoice_prefix"
                                   value="{{ old('invoice_prefix', $config->invoice_prefix) }}"
                                   class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Suffix Length *</label>
                            <input type="number" name="suffix_length"
                                   value="{{ old('suffix_length', $config->suffix_length) }}"
                                   class="form-control" min="1" max="6" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Starting Invoice No *</label>
                            <input type="number" name="invoice_no"
                                   value="{{ old('invoice_no', $config->invoice_no) }}"
                                   class="form-control" min="1" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">HSN Code</label>
                            <input type="text" name="hsn"
                                   value="{{ old('hsn', $config->hsn) }}"
                                   class="form-control">
                        </div>

                    </div>
                </div>
            </div>

            {{-- BRANDING & STATUS --}}
            <div class="card mb-4">
                <div class="card-header"><h5>Branding & Status</h5></div>
                <div class="card-body">
                    <div class="row g-3 align-items-center">

                        <div class="col-md-6">
                            <label class="form-label">Logo</label>
                            <input type="file" name="logo" class="form-control"
                                   accept="image/png,image/jpeg">
                            <small class="text-muted">PNG / JPG (Max 2MB)</small>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="1" {{ $config->status ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$config->status ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            @if($config->logo)
                                <label class="form-label d-block">Current Logo</label>
                                <img src="{{ asset('storage/'.$config->logo) }}"
                                     style="max-height:60px">
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            {{-- ACTION --}}
            <div class="text-end">
                <button class="btn btn-primary px-4">
                    <i class="fa fa-save me-1"></i> Save Configuration
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
@section('script')
<script>
(() => {
    'use strict';

    const form = document.getElementById('configForm');

    /* -------------------------------------------------
     | 1. BOOTSTRAP VALIDATION (REQUIRED)
     ------------------------------------------------- */
    form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    });

    /* -------------------------------------------------
     | 2. GST VALIDATION
     ------------------------------------------------- */
    const gstInput = document.querySelector('[name="gst"]');
    const gstRegex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/;

    gstInput?.addEventListener('input', function () {
        if (this.value && !gstRegex.test(this.value)) {
            this.setCustomValidity('Invalid GST format');
        } else {
            this.setCustomValidity('');
        }
    });

    /* -------------------------------------------------
     | 3. PINCODE VALIDATION (INDIA)
     ------------------------------------------------- */
    const pincodeInput = document.querySelector('[name="pincode"]');

    pincodeInput?.addEventListener('input', function () {
        if (this.value && !/^[0-9]{6}$/.test(this.value)) {
            this.setCustomValidity('Pincode must be 6 digits');
        } else {
            this.setCustomValidity('');
        }
    });

    /* -------------------------------------------------
     | 4. MOBILE NUMBER VALIDATION
     ------------------------------------------------- */
    const mobileInput = document.querySelector('[name="mobile"]');

    mobileInput?.addEventListener('input', function () {
        if (this.value && !/^[0-9]{10}$/.test(this.value)) {
            this.setCustomValidity('Mobile must be 10 digits');
        } else {
            this.setCustomValidity('');
        }
    });

    /* -------------------------------------------------
     | 5. LOGO FILE VALIDATION
     ------------------------------------------------- */
    const logoInput = document.querySelector('[name="logo"]');

    logoInput?.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const allowedTypes = ['image/png', 'image/jpeg'];
        const maxSize = 2 * 1024 * 1024; // 2MB

        if (!allowedTypes.includes(file.type)) {
            alert('Only JPG or PNG images are allowed');
            this.value = '';
            return;
        }

        if (file.size > maxSize) {
            alert('Image size must be less than 2MB');
            this.value = '';
            return;
        }
    });

    /* -------------------------------------------------
     | 6. AUTO-FOCUS FIRST INVALID FIELD
     ------------------------------------------------- */
    form.addEventListener('submit', function () {
        const firstInvalid = form.querySelector(':invalid');
        if (firstInvalid) {
            firstInvalid.focus();
        }
    });

})();
</script>
@endsection
