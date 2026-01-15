<?php
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\PlanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Tenant\TenantRegistrationController;

Route::get('/test', function () {
    return view('test');
});
Route::get('/test/{error}', function ($id) {
    return view('errors.'.$id);
});
Route::get('/admin', function () { return view('/admin/index'); })->name('admin.dashboard');
Route::post('/tenant/register-by-self', [ TenantRegistrationController::class, 'registerBySelf']);
Route::post('/tenants/check-db', [ TenantRegistrationController::class, 'checkDbConnection'])->name('admin.tenants.check-db');
Route::get('/tenant/register-by-admin', [ TenantRegistrationController::class, 'tenanteRegistrationForm'])->name('add.tenant');
Route::post('/tenant/register-by-admin', [ TenantRegistrationController::class, 'storeTenantByAdmin'])->name('register.tenant');
Route::get('/tenant/lists', [ TenantRegistrationController::class, 'tenantList'])->name('tenant.list');
Route::get('/tenant/{id}/edit', [ TenantRegistrationController::class, 'edit'])->name('edit.tenant');
Route::post('/tenant/{uuid}/edit', [ TenantRegistrationController::class, 'update'])->name('edit.tenant');
Route::get('/tenant/on-boarding-request-list', [ TenantRegistrationController::class, 'onBoardingList'])->name('tenant.onBoardingList');
Route::get('/tenant/edit/on-boarding-request/{id}', [ TenantRegistrationController::class, 'editOnBoardingRequest'])->name('tenant.editOnBoardingRequest');
Route::post('/tenant/edit/on-boarding-request/{id}', [ TenantRegistrationController::class, 'approveAndUpdate'])->name('tenant.approveAndUpdate');

Route::prefix('plans')->name('admin.plans.')->group(function () {
    Route::get('/', [PlanController::class, 'index'])->name('index');
    Route::get('/create', [PlanController::class, 'create'])->name('create');
    Route::post('/store', [PlanController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [PlanController::class, 'edit'])->name('edit');
    Route::post ('/update/{id}', [PlanController::class, 'update'])->name('update');
    Route::post('/delete/{id}', [PlanController::class, 'destroy'])->name('destroy');
});

Route::prefix('features')->name('admin.features.')->group(function () {
    Route::get('/', [FeatureController::class, 'index'])->name('index');
    Route::post('/store', [FeatureController::class, 'store'])->name('store');
    Route::post ('/update/{feature}', [FeatureController::class, 'update'])->name('update');
    Route::post('/delete/{feature}', [FeatureController::class, 'destroy'])->name('destroy');
});