@extends('admin.layouts.app')

@section('title', 'Edit Tenant')

@section('styles')
<style>
    .nav-pills .nav-link {
        color: #000000;
    }
    
    
</style>
@endsection

@section('content')
<div class="page-body">
    <div class="container-fluid">

        <div class="page-title">
            <h3>Edit Tenant (<strong>{{$tenant->hotel_name}}</strong>)</h3>
        </div>

        {{-- Display Errors --}}
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show text-danger" role="alert">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Success Message --}}
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Error Message --}}
        @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-danger" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h4>Tenant Details</h4>
            </div>

            <div class="card-body">
                <div class="row">
                    {{-- Vertical Tabs Navigation --}}
                    <div class="col-md-3 col-xs-12">
                        <div class="nav flex-column nav-pills" id="tenant-tabs" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active" 
                               id="basic-info-tab" 
                               data-bs-toggle="pill" 
                               href="#basic-info" 
                               role="tab" 
                               aria-controls="basic-info" 
                               aria-selected="true">
                                <i class="fa fa-building me-2"></i> Basic Information
                            </a>
                            <a class="nav-link" 
                               id="db-connection-tab" 
                               data-bs-toggle="pill" 
                               href="#db-connection" 
                               role="tab" 
                               aria-controls="db-connection" 
                               aria-selected="false">
                                <i class="fa fa-database me-2"></i> Database Connection
                            </a>
                            <a class="nav-link" 
                               id="app-setup-tab" 
                               data-bs-toggle="pill" 
                               href="#app-setup" 
                               role="tab" 
                               aria-controls="app-setup" 
                               aria-selected="false">
                                <i class="fa fa-cogs me-2"></i> Application Setup
                            </a>
                        </div>
                    </div>

                    {{-- Tab Content --}}
                    <div class="col-md-9 col-xs-12">
                        <div class="tab-content" id="tenant-tabs-content">
                            
                            {{-- Basic Information Tab --}}
                                @include('admin.components.tenants.tabs.basic-info', ['tenant' => $tenant, 'plans' => $plans])

                                {{-- Database Connection Tab --}}
                                @include('admin.components.tenants.tabs.db-connection', ['tenant' => $tenant])

                                {{-- Application Setup Tab --}}
                                @include('admin.components.tenants.tabs.app-setup', ['tenant' => $tenant])

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('admin/assets/js/tenant-form-validation.js') }}"></script>
@endsection