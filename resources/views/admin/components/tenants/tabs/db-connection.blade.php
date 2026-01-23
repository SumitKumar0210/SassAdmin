<div class="tab-pane fade" 
     id="db-connection" 
     role="tabpanel" 
     aria-labelledby="db-connection-tab">
    
    <form id="dbConnectionForm"
          method="POST"
          action="{{route('admin.update.tenant.dbUpdate', $tenant->uuid)}}"
          class="needs-validation"
          novalidate>
        @csrf

        <h5 class="section-title">
            <i class="fa fa-database text-info me-2"></i>
            Database Configuration
        </h5>

        <div class="alert alert-info text-dark">
            <i class="fa fa-info-circle me-2"></i>
            <strong>Important:</strong> Enable the checkbox below only if you want to update database credentials. 
            This applies when approving tenant accounts.
        </div>

        <div class="row">
            {{-- Enable DB Update Toggle --}}
            <div class="col-12 mb-4">
                <div class="form-check form-switch">
                    <input class="form-check-input" 
                           type="checkbox" 
                           id="changeDbToggle"
                           name="changeDbToggle"
                           value="1"
                           style="width: 3em; height: 1.5em;"
                           {{ old('changeDbToggle') ? 'checked' : '' }}>
                    <label class="form-check-label ms-2" for="changeDbToggle" style="font-size: 1.1em;">
                        <strong>Update Database Credentials</strong>
                    </label>
                </div>
            </div>

            {{-- DB Name --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Database Name</label>
                <input type="text" 
                       name="db_name" 
                       class="form-control db-field @error('db_name') is-invalid @enderror"
                       value="{{ old('db_name', $tenant->db_name ?? 'tenant_db_' . strtolower($tenant->subdomain)) }}" 
                       pattern="[a-zA-Z0-9_]+"
                       maxlength="64"
                       placeholder="tenant_db_name"
                       disabled>
                @error('db_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Only alphanumeric and underscores allowed</small>
            </div>

            {{-- DB Host --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Database Host</label>
                <input type="text" 
                       name="db_host" 
                       class="form-control db-field @error('db_host') is-invalid @enderror"
                       value="{{ old('db_host', $tenant->db_host ?? config('database.connections.mysql.host')) }}" 
                       placeholder="localhost or 127.0.0.1"
                       disabled>
                @error('db_host')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- DB Username --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Database Username</label>
                <input type="text" 
                       name="db_username" 
                       class="form-control db-field @error('db_username') is-invalid @enderror"
                       value="{{ old('db_username', $tenant->db_username ?? config('database.connections.mysql.username')) }}" 
                       placeholder="database_user"
                       disabled>
                @error('db_username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- DB Password --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">Database Password</label>
                <input type="password" 
                       name="db_password"
                       class="form-control @error('db_password') is-invalid @enderror"
                       placeholder="Leave blank to keep existing"
                       minlength="8"
                       disabled>
                @error('db_password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Minimum 8 characters. Leave blank to keep existing password.</small>
            </div>

            {{-- Database Connection Test --}}
            <div class="col-12 mb-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                            <div>
                            <h6 class="mb-1 text-dark">Test Database Connection</h6>
                                <p class="text-muted mb-0" id="dbCheckStatus">
                                    <span class="text-muted">
                                        <i class="fa fa-info-circle me-1"></i>
                                        Using existing database configuration
                                    </span>
                                </p>
                            </div>
                            <button type="button" 
                                    class="btn btn-info" 
                                    id="checkDbBtn" 
                                    disabled>
                                <i class="fa fa-plug"></i> Check Connection
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="section-divider"></div>

        <div class="alert alert-warning text-dark">
            <i class="fa fa-exclamation-triangle me-2"></i>
            <strong>Note:</strong> Database credentials cannot be changed after initial setup unless you enable the update toggle above. 
            Always verify the connection before saving changes.
        </div>

        {{-- Submit Buttons --}}
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('admin.tenant.onBoardingList') }}" 
               class="btn btn-light">
                <i class="fa fa-times"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary" id="saveDbBtn">
                <i class="fa fa-save"></i> Save Database Configuration
            </button>
        </div>

    </form>

</div>