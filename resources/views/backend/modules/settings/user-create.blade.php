@extends('backend.layouts.main')
@section('title','Create User')
@section('main-container')
    <div class="page-body">
        <div class="container-fluid py-3">
            <div class="email-wrap bookmark-wrap">
                <div class="row">
                    <div class="col-xl-2 box-col-6">
                        @include('backend.layouts.sidebar_master')
                    </div>
                    <div class="col-xl-10 col-md-12 box-col-12">
                        <div class="container-fluid">
                            <div class="page-title mt-2">
                                <div class="row gx-0">
                                    <div class="col-12 col-sm-6">
                                        <h3 class="d-block">Add User</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <!-- Zero Configuration  Starts-->
                                <div class="col-lg-12 col-sm-12">
                                    <form id="guestForm" enctype="multipart/form-data">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter Name <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" placeholder="Enter Name" name="user_name">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter Email <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" placeholder="Enter Email" name="user_email">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter Password <span class="text-danger">*</span></label>
                                                        <input type="password" class="form-control form-control-sm" placeholder="Enter Password" name="user_password" onkeyup="checkPassword()">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter Confirm Password</label>
                                                        <input type="password" class="form-control form-control-sm" placeholder="Enter Confirm Password" name="user_confirm_password" onkeyup="checkPassword()">
                                                        <div><small class="text-danger confirm_password"></small></div>
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter Mobile <span class="text-danger">*</span></label>
                                                        <input type="number" class="form-control form-control-sm" placeholder="Enter Mobile" name="user_mobile">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Select Usertype <span class="text-danger">*</span></label>
                                                        <select class="form-select form-select-sm" id="user_usertype" name="user_usertype" onchange="getPermission(this.value)">
                                                            <option value="">Select</option>
                                                            @if(sizeof($usertypes) > 0)
                                                                @foreach ($usertypes as $t)
                                                                    <option value="{{$t->id}}">{{$t->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter Address</label>
                                                        <input type="text" class="form-control form-control-sm" placeholder="Enter Address" name="user_address">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter City</label>
                                                        <input type="text" class="form-control form-control-sm" placeholder="Enter City" name="user_city">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter State</label>
                                                        <input type="text" class="form-control form-control-sm" placeholder="Enter State" name="user_state">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter Pincode</label>
                                                        <input type="number" class="form-control form-control-sm" placeholder="Enter Pincode" name="user_pincode">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter Country</label>
                                                        <input type="text" class="form-control form-control-sm" placeholder="Enter Country" name="user_country" value="India">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Profile</label>
                                                        <input type="file" class="form-control form-control-sm" name="user_profile">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label">Document type</label>
                                                        <select class="form-select form-select-sm" id="user_documenttype" name="user_documenttype" onchange="docTypeValue(this.value)">
                                                            <option value="">Document type</option>
                                                            <option value="Aadhar Card">Aadhar Card </option>
                                                            <option value="Pan Card">Pan Card</option>
                                                            <option value="Driving Licence">Driving Licence</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1 d-none user_otherdetail">
                                                        <label class="form-label">Other Document Type</label>
                                                        <input class="form-control form-control-sm" type="text" id="user_otherdetail" name="user_otherdetail" placeholder="Other Details">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label">ID Number</label>
                                                        <input class="form-control form-control-sm" type="text" placeholder="Document Number" maxlength="15" id="user_idnumber" name="user_idnumber" oninput="this.value=this.value.slice(0,15)">
                                                    </div>
                                                </div>
                                                <div class="row mt-4 mb-2">
                                                    <div class="col-12">
                                                        <h4 class="form-label fw-medium">Permissions</h4>
                                                    </div>
                                                </div>
                                                <div class="row mt-1 mb-1 permission-list"></div>
                                                <div class="col-md-12 d-flex justify-content-end mt-3 itemAddShow">
                                                    <button type="button" class="btn btn-success btn-sm fw-medium m-2 userAddSubmit" onclick="addUser()">
                                                    Submit
                                                    </button>
                                                    <button class="btn btn-success btn-sm fw-medium m-2 userAddSpinn d-none" type="button">
                                                        Please Wait...
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('extra-js')
<script>
    const userAdd = "{{ route('user.store') }}";
    const getPermissionUser = "{{ route('usertype.getPermissionUser') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/user.js')}}"></script>
@endsection