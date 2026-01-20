document.addEventListener('DOMContentLoaded', function () {

    // Get all forms
    const basicInfoForm = document.getElementById('basicInfoForm');
    const dbConnectionForm = document.getElementById('dbConnectionForm');
    const appSetupForm = document.getElementById('appSetupForm');

    // Database connection elements
    const toggle = document.getElementById('changeDbToggle');
    const dbFields = document.querySelectorAll('.db-field');
    const checkBtn = document.getElementById('checkDbBtn');
    const statusEl = document.getElementById('dbCheckStatus');
    const saveDbBtn = document.getElementById('saveDbBtn');

    let dbVerified = true; // existing DB is trusted by default

    // Application Setup - Data Fetching
    let appDataLoaded = false;
    const tenantUuid = document.querySelector('[name="uuid"]')?.value || getTenantUuidFromUrl();

    // ==================== Tab Navigation Memory ====================
    const savedTab = localStorage.getItem('tenantEditActiveTab');

    if (savedTab) {
        const tabTrigger = document.querySelector(`[href="${savedTab}"]`);

        if (tabTrigger) {
          
            const tab = bootstrap.Tab.getInstance(tabTrigger)
                || new bootstrap.Tab(tabTrigger);

            tab.show();
        }
    }

    // Save active tab on change
    const tabLinks = document.querySelectorAll('#tenant-tabs a[data-bs-toggle="pill"]');
    tabLinks.forEach(tabLink => {
        tabLink.addEventListener('shown.bs.tab', function (event) {
            const targetTab = event.target.getAttribute('href');
            localStorage.setItem('tenantEditActiveTab', targetTab);

            // Fetch application details when app-setup tab is shown
            if (targetTab === '#app-setup' && !appDataLoaded && tenantUuid) {
                fetchApplicationDetails(tenantUuid);
            }
        });
    });

    // Check if app-setup tab is active on page load
    const appSetupPane = document.getElementById('app-setup');
    if (appSetupPane && appSetupPane.classList.contains('active') && !appDataLoaded && tenantUuid) {
        // Small delay to ensure DOM is fully loaded
        setTimeout(() => {
            fetchApplicationDetails(tenantUuid);
        }, 100);
    }

    // ==================== FETCH APPLICATION DETAILS ====================
    function fetchApplicationDetails(uuid) {
        if (!uuid) {
            console.warn('No tenant UUID found');
            return;
        }
        console.log('Fetching application details for tenant UUID:', uuid);

        // Show loading state
        showAppSetupLoading(true);

        fetch(`/admin/settings/show`, {
            method: 'GET',
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                console.log(response);
                return response.json();
            })
            .then(data => {
                if (data.success && data.data) {
                    populateApplicationFields(data.data);
                    appDataLoaded = true;
                    console.log('Application details loaded successfully');
                } else {
                    console.warn('No application details found');
                    appDataLoaded = true;
                }
            })
            .catch(error => {
                console.error('Error fetching application details:', error);
                showNotification('Unable to load application details. Using default values.', 'warning');
                appDataLoaded = true;
            })
            .finally(() => {
                showAppSetupLoading(false);
            });
    }

    function populateApplicationFields(data) {
        const fieldMapping = {
            'name': 'name',
            'gst': 'gst',
            'email': 'email',
            'mobile': 'mobile',
            'address': 'address',
            'city': 'city',
            'state': 'state',
            'pincode': 'pincode',
            'country': 'country',
            'website': 'website'
        };

        Object.keys(fieldMapping).forEach(dataKey => {
            const inputName = fieldMapping[dataKey];
            const element = appSetupForm.querySelector(`[name="${inputName}"]`);

            if (element && data[dataKey] !== null && data[dataKey] !== undefined && data[dataKey] !== '') {
                element.value = data[dataKey];

                // Trigger validation
                element.dispatchEvent(new Event('input', { bubbles: true }));

                // Add subtle animation
                element.style.transition = 'background-color 0.3s';
                element.style.backgroundColor = '#fff3cd';
                setTimeout(() => {
                    element.style.backgroundColor = '';
                }, 300);
            }
        });

        // Handle logo if exists
        if (data.logo) {
            displayCurrentLogo(data.logo);
        }
    }

    function displayCurrentLogo(logoPath) {
        const logoContainer = appSetupForm.querySelector('.mt-2');
        if (!logoContainer) {
            // Create logo display container
            const logoInput = appSetupForm.querySelector('[name="logo"]');
            if (logoInput) {
                const container = document.createElement('div');
                container.className = 'mt-2';
                container.innerHTML = `
                    <img src="${getLogoUrl(logoPath)}" 
                         alt="Current Logo" 
                         class="img-thumbnail" 
                         style="max-height: 80px;">
                    <small class="d-block text-muted">Current logo</small>
                `;
                logoInput.parentElement.appendChild(container);
            }
        } else {
            // Update existing logo
            const img = logoContainer.querySelector('img');
            if (img) {
                img.src = getLogoUrl(logoPath);
            }
        }
    }

    function getLogoUrl(logoPath) {
        if (!logoPath) return '';
        // Check if it's already a full URL
        if (logoPath.startsWith('http')) {
            return logoPath;
        }
        // Construct storage URL
        return `/storage/${logoPath}`;
    }

    function showAppSetupLoading(show) {
        if (!appSetupForm) return;

        if (show) {
            appSetupForm.style.opacity = '0.5';
            appSetupForm.style.pointerEvents = 'none';

            // Add spinner if not exists
            if (!document.getElementById('appSetupSpinner')) {
                const spinner = document.createElement('div');
                spinner.id = 'appSetupSpinner';
                spinner.className = 'text-center py-3';
                spinner.innerHTML = `
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading application details...</p>
                `;
                appSetupForm.insertBefore(spinner, appSetupForm.firstChild);
            }
        } else {
            appSetupForm.style.opacity = '1';
            appSetupForm.style.pointerEvents = 'auto';

            const spinner = document.getElementById('appSetupSpinner');
            if (spinner) {
                spinner.remove();
            }
        }
    }

    function getTenantUuidFromUrl() {
        // Try to extract UUID from URL path
        const pathParts = window.location.pathname.split('/');
        const editIndex = pathParts.indexOf('edit');
        if (editIndex > -1 && pathParts[editIndex + 1]) {
            return pathParts[editIndex + 1];
        }
        return null;
    }

    function getCSRFToken() {
        const tokenMeta = document.querySelector('meta[name="csrf-token"]');
        if (tokenMeta) {
            return tokenMeta.content;
        }
        const tokenInput = document.querySelector('[name="_token"]');
        if (tokenInput) {
            return tokenInput.value;
        }
        return '';
    }

    function showNotification(message, type = 'info') {
        // Try Bootstrap toast first
        if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
            const bgClass = type === 'warning' ? 'bg-warning' : type === 'danger' ? 'bg-danger' : 'bg-info';
            const toastHTML = `
                <div class="toast align-items-center text-white ${bgClass} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            <i class="fa fa-${type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            `;

            let toastContainer = document.querySelector('.toast-container');
            if (!toastContainer) {
                toastContainer = document.createElement('div');
                toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                document.body.appendChild(toastContainer);
            }

            toastContainer.insertAdjacentHTML('beforeend', toastHTML);
            const toastElement = toastContainer.lastElementChild;
            const toast = new bootstrap.Toast(toastElement, { delay: 5000 });
            toast.show();

            toastElement.addEventListener('hidden.bs.toast', () => toastElement.remove());
        } else {
            console.log(message);
        }
    }

    // ==================== BASIC INFO FORM VALIDATION ====================
    if (basicInfoForm) {
        setupFormValidation(basicInfoForm);

        // Mobile number formatting
        const mobileInput = basicInfoForm.querySelector('.mobile-input');
        if (mobileInput) {
            mobileInput.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').substring(0, 10);
            });
        }

        // Subdomain formatting
        const subdomainInput = basicInfoForm.querySelector('.subdomain-input');
        if (subdomainInput) {
            subdomainInput.addEventListener('input', function () {
                this.value = this.value.toLowerCase().replace(/[^a-z0-9\-.]/g, '');
            });

            subdomainInput.addEventListener('blur', function () {
                const subdomain = this.value;
                const subdomainPattern = /^[a-z0-9\-.]+$/;

                if (subdomain && !subdomainPattern.test(subdomain)) {
                    this.setCustomValidity('Subdomain should contain only lowercase letters, numbers, hyphens, and periods');
                } else if (subdomain && subdomain.length < 3) {
                    this.setCustomValidity('Subdomain must be at least 3 characters');
                } else {
                    this.setCustomValidity('');
                }
            });
        }

        // Date validation
        const goLiveDate = basicInfoForm.querySelector('.go-live-date');
        const expiryDate = basicInfoForm.querySelector('.expiry-date');

        if (goLiveDate && expiryDate) {
            goLiveDate.addEventListener('change', function () {
                if (this.value) {
                    expiryDate.min = this.value;

                    if (expiryDate.value && expiryDate.value < this.value) {
                        expiryDate.value = '';
                    }
                }
            });
        }
    }

    // ==================== DATABASE CONNECTION FORM ====================
    if (dbConnectionForm) {
        setupFormValidation(dbConnectionForm);

        // Database Toggle
        if (toggle) {
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
                    statusEl.innerHTML = '<span class="text-muted"><i class="fa fa-info-circle"></i> Using existing database configuration</span>';
                }
            });
        }

        // Check database connection
        if (checkBtn) {
            checkBtn.addEventListener('click', function () {
                const dbHost = document.querySelector('[name="db_host"]').value;
                const dbName = document.querySelector('[name="db_name"]').value;
                const dbUser = document.querySelector('[name="db_username"]').value;
                const dbPass = document.querySelector('[name="db_password"]').value;
                const token = document.querySelector('[name="_token"]').value;

                if (!dbHost || !dbName || !dbUser) {
                    statusEl.innerHTML = '<span class="text-danger"><i class="fa fa-times-circle"></i> Please fill all DB fields</span>';
                    return;
                }

                statusEl.innerHTML = '<span class="text-warning"><i class="fa fa-spinner fa-spin"></i> Checking connection...</span>';
                checkBtn.disabled = true;

                fetch('/admin/tenants/check-db', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
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
                            statusEl.innerHTML = '<span class="text-success"><i class="fa fa-check-circle"></i> Connection successful!</span>';
                            dbVerified = true;
                        } else {
                            statusEl.innerHTML = '<span class="text-danger"><i class="fa fa-times-circle"></i> ' + data.message + '</span>';
                            dbVerified = false;
                        }
                    })
                    .catch(error => {
                        statusEl.innerHTML = '<span class="text-danger"><i class="fa fa-times-circle"></i> Connection failed</span>';
                        dbVerified = false;
                        console.error('Database check error:', error);
                    })
                    .finally(() => {
                        checkBtn.disabled = false;
                    });
            });
        }

        // Validate database before submission
        dbConnectionForm.addEventListener('submit', function (e) {
            if (toggle && toggle.checked && !dbVerified) {
                e.preventDefault();
                alert('⚠️ Please verify database connection before saving!');
                statusEl.innerHTML = '<span class="text-danger"><i class="fa fa-exclamation-triangle"></i> Verification required</span>';
                return false;
            }
        });
    }

    // ==================== APPLICATION SETUP FORM ====================
    if (appSetupForm) {
        setupFormValidation(appSetupForm);

        // Contact number formatting
        const contactInput = appSetupForm.querySelector('.contact-input');
        if (contactInput) {
            contactInput.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').substring(0, 10);
            });
        }

        // GST formatting
        const gstInput = appSetupForm.querySelector('.gst-input');
        if (gstInput) {
            gstInput.addEventListener('input', function () {
                this.value = this.value.toUpperCase();
            });
        }

        // Zip code formatting
        const zipInput = appSetupForm.querySelector('.zip-input');
        if (zipInput) {
            zipInput.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').substring(0, 6);
            });
        }

        // Logo validation and preview
        const logoInput = appSetupForm.querySelector('.logo-input');
        if (logoInput) {
            logoInput.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Logo file size must be less than 2MB');
                        this.value = '';
                        return;
                    }

                    // Validate file type
                    const validTypes = ['image/png', 'image/jpeg', 'image/jpg', 'image/svg+xml'];
                    if (!validTypes.includes(file.type)) {
                        alert('Please upload a valid image file (PNG, JPG, JPEG, or SVG)');
                        this.value = '';
                        return;
                    }

                    // Preview the new logo
                    previewLogo(file);
                }
            });
        }
    }

    // ==================== LOGO PREVIEW ====================
    function previewLogo(file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const logoContainer = appSetupForm.querySelector('.mt-2');
            if (logoContainer) {
                const img = logoContainer.querySelector('img');
                if (img) {
                    img.src = e.target.result;
                }
            } else {
                // Create preview if doesn't exist
                const logoInput = appSetupForm.querySelector('[name="logo"]');
                if (logoInput) {
                    const container = document.createElement('div');
                    container.className = 'mt-2';
                    container.innerHTML = `
                        <img src="${e.target.result}" 
                             alt="Logo Preview" 
                             class="img-thumbnail" 
                             style="max-height: 80px;">
                        <small class="d-block text-muted">Logo preview</small>
                    `;
                    logoInput.parentElement.appendChild(container);
                }
            }
        };
        reader.readAsDataURL(file);
    }

    // ==================== GENERIC FORM VALIDATION SETUP ====================
    function setupFormValidation(form) {
        if (!form) return;

        form.addEventListener('submit', function (e) {
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

            form.classList.add('was-validated');
        });

        // Real-time validation
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('blur', function () {
                if (this.checkValidity()) {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                }
            });

            input.addEventListener('input', function () {
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
    }

    // ==================== SUCCESS MESSAGE AUTO-HIDE ====================
    const alerts = document.querySelectorAll('.alert-success, .alert-danger');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000); // Auto-hide after 5 seconds
    });

});