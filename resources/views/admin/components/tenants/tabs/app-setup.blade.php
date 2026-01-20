<div class="tab-pane fade" 
     id="app-setup" 
     role="tabpanel" 
     aria-labelledby="app-setup-tab">
    
    <form id="appSetupForm"
          method="POST"
          action="{{route('admin.update.tenant.setupUpdate', $tenant->uuid)}}"
          class="needs-validation"
          enctype="multipart/form-data"
          novalidate>
        @csrf

        <h5 class="section-title">
            <i class="fa fa-building-o text-warning me-2"></i>
            Company Profile Setup
        </h5>

        <div class="row">
            {{-- Name --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Name *</label>
                <input type="text" 
                       name="name" 
                       class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', $hotelDetails->name ?? $tenant->hotel_name) }}" 
                       required
                       maxlength="255"
                       placeholder="Company Name">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- GST --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">GST *</label>
                <input type="text" 
                       name="gst" 
                       class="form-control gst-input @error('gst') is-invalid @enderror"
                       value="{{ old('gst', $hotelDetails->gst) }}" 
                       required
                       pattern="[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}"
                       maxlength="15"
                       placeholder="e.g., 07AAJCS2781A1Z0">
                @error('gst')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">15-character GST number (e.g., 07AAJCS2781A1Z0)</small>
            </div>

            {{-- Email --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Email</label>
                <input type="email" 
                       name="email" 
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $hotelDetails->email ?? $tenant->email) }}"
                       maxlength="255"
                       placeholder="company@example.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Contact Number --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Contact Number</label>
                <input type="text" 
                       name="mobile" 
                       class="form-control contact-input @error('mobile') is-invalid @enderror"
                       value="{{ old('mobile', $hotelDetails->mobile ?? $tenant->mobile) }}"
                       pattern="[0-9]{10}"
                       maxlength="10"
                       placeholder="1234567890">
                @error('mobile')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">10-digit contact number</small>
            </div>

            {{-- Address --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Address</label>
                <input type="text" 
                       name="address" 
                       class="form-control @error('address') is-invalid @enderror"
                       value="{{ old('address', $hotelDetails->address) }}"
                       maxlength="255"
                       placeholder="Street address">
                @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- City --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">City</label>
                <input type="text" 
                       name="city" 
                       class="form-control @error('city') is-invalid @enderror"
                       value="{{ old('city', $hotelDetails->city) }}"
                       maxlength="100"
                       placeholder="City name">
                @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- State --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">State</label>
                <input type="text" 
                       name="state" 
                       class="form-control @error('state') is-invalid @enderror"
                       value="{{ old('state', $hotelDetails->state) }}"
                       maxlength="100"
                       placeholder="State name">
                @error('state')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Zip Code --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Zip Code</label>
                <input type="text" 
                       name="pincode" 
                       class="form-control zip-input @error('pincode') is-invalid @enderror"
                       value="{{ old('pincode', $hotelDetails->pincode) }}"
                       pattern="[0-9]{6}"
                       maxlength="6"
                       placeholder="844120">
                @error('pincode')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">6-digit PIN code</small>
            </div>

            {{-- Country --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Country</label>
                <input type="text" 
                       name="country" 
                       class="form-control @error('country') is-invalid @enderror"
                       value="{{ old('country', $hotelDetails->country ?? 'India') }}"
                       maxlength="100"
                       placeholder="Country name">
                @error('country')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Website --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Website</label>
                <input type="url" 
                       name="website" 
                       class="form-control @error('website') is-invalid @enderror"
                       value="{{ old('website', $hotelDetails->website) }}"
                       maxlength="255"
                       placeholder="https://www.example.com">
                @error('website')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Upload Logo --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Upload Logo</label>
                <input type="file" 
                       name="logo" 
                       class="form-control logo-input @error('logo') is-invalid @enderror"
                       accept="image/png,image/jpeg,image/jpg,image/svg+xml">
                @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Accepted formats: PNG, JPG, JPEG, SVG (Max: 2MB)</small>
                
                @if(isset($tenant->logo) && $tenant->logo)
                <div class="mt-2">
                    <img src="{{ asset('storage/' . $tenant->logo) }}" 
                         alt="Current Logo" 
                         class="img-thumbnail" 
                         style="max-height: 80px;">
                    <small class="d-block text-muted">Current logo</small>
                </div>
                @endif
            </div>
        </div>

        <div class="section-divider"></div>

        <div class="alert alert-success text-dark">
            <i class="fa fa-lightbulb-o me-2"></i>
            <strong>Tip:</strong> These details will be used throughout the application for invoices, receipts, and official communications. 
            Make sure all information is accurate.
        </div>

        {{-- Submit Buttons --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.tenant.onBoardingList') }}" 
               class="btn btn-light">
                <i class="fa fa-times"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Save Application Setup
            </button>
        </div>

    </form>

</div>