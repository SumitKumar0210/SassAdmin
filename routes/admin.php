<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Tenant\TenantRegistrationController;

Route::get('/test', function () {
    return view('test');
});
Route::get('/test/{error}', function ($id) {
    return view('errors.' . $id);
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('index');
    Route::get('/forgot-password', [AuthController::class, 'forget'])->name('forget');
    Route::post('logged_in', [AuthController::class, 'authenticate'])->name('backend.login');
    Route::get('/admin-forgetPassword', [AuthController::class, 'forgetpass'])->name('backend.forgetpass');
    Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('backend.sendOtp');
    Route::post('/admin-otpVerify', [AuthController::class, 'verifyotp'])->name('backend.verify_otp');
    Route::post('send-magic-link', [AuthController::class, 'magiclink'])->name('magiclink');

    Route::post('/admin-passwordChange', [AuthController::class, 'updatepass'])->name('backend.update_pass');
    Route::post('/tenant/register-by-self', [TenantRegistrationController::class, 'registerBySelf']);
    Route::get('/logout', [AuthController::class, 'destroy'])->name('logout');
});

Route::prefix('admin')->name('admin.')->middleware('auth:super_admin')->group(function () {
    Route::get('/admin', function () {
        return view('/admin/index');
    })->name('admin.dashboard');
    Route::post('/tenants/check-db', [TenantRegistrationController::class, 'checkDbConnection'])->name('tenants.check-db');
    Route::get('/tenant/register-by-admin', [TenantRegistrationController::class, 'tenanteRegistrationForm'])->name('add.tenant');
    Route::post('/tenant/register-by-admin', [TenantRegistrationController::class, 'storeTenantByAdmin'])->name('register.tenant');
    Route::get('/tenant/lists', [TenantRegistrationController::class, 'tenantList'])->name('tenant.list');
    Route::get('/tenant/{id}/edit', [TenantRegistrationController::class, 'edit'])->name('edit.tenant');
    Route::post('/tenant/{uuid}/destroy', [TenantRegistrationController::class, 'destroy'])->name('destroy.tenant');
    Route::post('/tenant/{uuid}/edit', [TenantRegistrationController::class, 'update'])->name('edit.tenant');
    Route::post('/tenant/{uuid}/dbUpdate', [TenantRegistrationController::class, 'dbUpdate'])->name('update.tenant.dbUpdate');
    Route::post('/tenant/{uuid}/setupUpdate', [TenantRegistrationController::class, 'setupUpdate'])->name('update.tenant.setupUpdate');
    Route::get('/tenant/on-boarding-request-list', [TenantRegistrationController::class, 'onBoardingList'])->name('tenant.onBoardingList');
    Route::get('/tenant/edit/on-boarding-request/{id}', [TenantRegistrationController::class, 'editOnBoardingRequest'])->name('tenant.editOnBoardingRequest');
    Route::post('/tenant/edit/on-boarding-request/{id}', [TenantRegistrationController::class, 'approveAndUpdate'])->name('tenant.approveAndUpdate');

    Route::prefix('plans')->name('plans.')->group(function () {
        Route::get('/', [PlanController::class, 'index'])->name('index');
        Route::get('/create', [PlanController::class, 'create'])->name('create');
        Route::post('/store', [PlanController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [PlanController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [PlanController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [PlanController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'showConfiguration'])->name('show');
        Route::post('/update', [SettingController::class, 'updateConfiguration'])->name('update');
    });

    Route::prefix('features')->name('features.')->group(function () {
        Route::get('/', [FeatureController::class, 'index'])->name('index');
        Route::post('/store', [FeatureController::class, 'store'])->name('store');
        Route::post('/update/{feature}', [FeatureController::class, 'update'])->name('update');
        Route::post('/delete/{feature}', [FeatureController::class, 'destroy'])->name('destroy');
    });
});
