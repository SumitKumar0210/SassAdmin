<div class="tab-pane fade show active" 
     id="basic-info" 
     role="tabpanel" 
     aria-labelledby="basic-info-tab">
    
    <form id="basicInfoForm"
          method="POST"
          action="{{ route('admin.edit.tenant', $tenant->uuid) }}"
          class="needs-validation"
          novalidate>
        @csrf

        <h5 class="section-title">
            <i class="fa fa-info-circle text-info me-2"></i>
            Hotel & Owner Details
        </h5>

        <div class="row">
            {{-- Hotel Name --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Hotel Name *</label>
                <input type="text" 
                       name="hotel_name" 
                       class="form-control @error('hotel_name') is-invalid @enderror"
                       value="{{ old('hotel_name', $tenant->hotel_name) }}" 
                       required 
                       minlength="3"
                       maxlength="255"
                       placeholder="Enter hotel name">
                @error('hotel_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Legal Name --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Legal Name</label>
                <input type="text" 
                       name="legal_name" 
                       class="form-control @error('legal_name') is-invalid @enderror"
                       value="{{ old('legal_name', $tenant->legal_name) }}"
                       maxlength="255"
                       placeholder="Enter legal business name">
                @error('legal_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Owner Name --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Owner Name *</label>
                <input type="text" 
                       name="woner_name" 
                       class="form-control @error('woner_name') is-invalid @enderror"
                       value="{{ old('woner_name', $tenant->woner_name) }}" 
                       required
                       minlength="2"
                       maxlength="255"
                       placeholder="Enter owner name">
                @error('woner_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Email *</label>
                <input type="email" 
                       name="email" 
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email', $tenant->email) }}" 
                       required
                       maxlength="255"
                       placeholder="owner@example.com">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Mobile --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Mobile *</label>
                <input type="text" 
                       name="mobile" 
                       class="form-control mobile-input @error('mobile') is-invalid @enderror"
                       value="{{ old('mobile', $tenant->mobile) }}"
                       pattern="[0-9]{10}" 
                       required
                       maxlength="10"
                       placeholder="10-digit mobile number">
                @error('mobile')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Enter 10-digit mobile number</small>
            </div>

            {{-- Subdomain --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Subdomain *</label>
                <input type="text" 
                       name="subdomain" 
                       class="form-control subdomain-input @error('subdomain') is-invalid @enderror"
                       value="{{ old('subdomain', $tenant->subdomain) }}"
                       pattern="[a-z0-9\-.]+"
                       minlength="3"
                       maxlength="100"
                       required
                       placeholder="myhotel">
                @error('subdomain')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Only lowercase letters, numbers, and hyphens</small>
            </div>
        </div>

        <div class="section-divider"></div>

        <h5 class="section-title">
            <i class="fa fa-sliders text-success me-2"></i>
            Plan & Status Configuration
        </h5>

        <div class="row">
            {{-- Plan --}}
            <div class="col-md-6 mb-3">
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

            {{-- Status --}}
            <div class="col-md-6 mb-3">
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
            <div class="col-md-6 mb-3">
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

            {{-- Go Live Date --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Go Live Date</label>
                <input type="date" 
                       name="go_live_date"
                       class="form-control go-live-date @error('go_live_date') is-invalid @enderror"
                       value="{{ old('go_live_date', $tenant->go_live_date) }}"
                       min="{{ date('Y-m-d') }}">
                @error('go_live_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Expiry Date --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Expiry Date</label>
                <input type="date" 
                       name="expiry_date"
                       class="form-control expiry-date @error('expiry_date') is-invalid @enderror"
                       value="{{ old('expiry_date', $tenant->expiry_date) }}">
                @error('expiry_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="section-divider"></div>

        {{-- Submit Buttons --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.tenant.onBoardingList') }}" 
               class="btn btn-light">
                <i class="fa fa-times"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Save Basic Information
            </button>
        </div>

    </form>

</div>