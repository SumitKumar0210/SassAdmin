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
                                        <h3 class="d-block">Edit User</h3>
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
                                                        <input type="hidden" class="form-control form-control-sm" placeholder="Enter Name" name="user_id" value="{{$user[0]->id}}">
                                                        <input type="text" class="form-control form-control-sm" placeholder="Enter Name" name="user_name" value="{{$user[0]->name}}">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter Email <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control form-control-sm" placeholder="Enter Email" value="{{$user[0]->email}}" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter Mobile <span class="text-danger">*</span></label>
                                                        <input type="number" class="form-control form-control-sm" placeholder="Enter Mobile" name="user_mobile" value="{{$user[0]->mobile}}">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Select Usertype <span class="text-danger">*</span></label>
                                                        <select class="form-select form-select-sm" name="user_usertype" onchange="getPermission(this.value)">
                                                            <option value="">Select</option>
                                                            @if(sizeof($usertypes) > 0)
                                                                @foreach ($usertypes as $t)
                                                                    <option value="{{$t->id}}" @if($user[0]->usertype_id == $t->id) selected @endif>{{$t->name}}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter Address</label>
                                                        <input type="text" class="form-control form-control-sm" placeholder="Enter Address" name="user_address" value="{{$user[0]->address}}">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter City</label>
                                                        <input type="text" class="form-control form-control-sm" placeholder="Enter City" name="user_city" value="{{$user[0]->city}}">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter State</label>
                                                        <input type="text" class="form-control form-control-sm" placeholder="Enter State" name="user_state" value="{{$user[0]->state}}">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter Pincode</label>
                                                        <input type="number" class="form-control form-control-sm" placeholder="Enter Pincode" name="user_pincode" value="{{$user[0]->pincode}}">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Enter Country</label>
                                                        <input type="text" class="form-control form-control-sm" placeholder="Enter Country" name="user_country" value="India" value="{{$user[0]->country}}">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label fw-medium">Profile</label>
                                                        <input type="file" class="form-control form-control-sm" name="user_profile">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label">Document type</label>
                                                        <select class="form-select form-select-sm" id="user_documenttype" name="user_documenttype" onchange="docTypeValue(this.value)">
                                                            <option value="">Document type</option>
                                                            <option value="Aadhar Card" @if($user[0]->id_proof_type == 'Aadhar Card') selected @endif>Aadhar Card </option>
                                                            <option value="Pan Card" @if($user[0]->id_proof_type == 'Pan Card') selected @endif>Pan Card</option>
                                                            <option value="Driving Licence" @if($user[0]->id_proof_type == 'Driving Licence') selected @endif>Driving Licence</option>
                                                            <option value="Other" @if($user[0]->id_proof_type == 'Other') selected @endif>Other</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1 @if($user[0]->id_proof_type != 'Other') d-none @endif user_otherdetail">
                                                        <label class="form-label">Other Document Type</label>
                                                        <input class="form-control form-control-sm" type="text" id="user_otherdetail" name="user_otherdetail" placeholder="Other Details">
                                                    </div>
                                                    <div class="col-md-6 mb-2 mt-1">
                                                        <label class="form-label">ID Number</label>
                                                        <input class="form-control form-control-sm" type="text" placeholder="Document Number" maxlength="15" id="user_idnumber" name="user_idnumber" oninput="this.value=this.value.slice(0,15)" value="{{$user[0]->id_number}}">
                                                    </div>
                                                </div>
                                                <div class="row mt-4 mb-2">
                                                    <div class="col-12">
                                                        <h4 class="form-label fw-medium">Permissions</h4>
                                                    </div>
                                                </div>
                                                <div class="row mt-1 mb-1 permission-list">
                                                @foreach ($moduleLists as $mod)
                                                    <div class="col-4 mb-3">
                                                        <div class="card-wrapper border rounded-3 checkbox-checked">
                                                            <h5><label class="form-label fw-medium">{{$mod['module']}}</label></h5>
                                                            @foreach ($mod['items'] as $item)
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input check-size" name="permissions[]" id="flexSwitchCheckDefault{{$item->id}}" type="checkbox" role="switch" value="{{$item->id}}" 
                                                                    @if(in_array($item->module_option, (explode(',',$user[0]->permission)))) checked 
                                                                    @endif
                                                                    ><label class="form-check-label" for="flexCheckDefault{{$item->id}}">{{$item->module_option}}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                                <div class="col-md-12 d-flex justify-content-end mt-3 itemAddShow">
                                                    <button type="button" class="btn btn-success btn-sm fw-medium m-2 userAddSubmit" onclick="updateUser()">
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
    const userUpdate = "{{ route('user.update') }}";
    const getPermissionUser = "{{ route('usertype.getPermissionUser') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/user.js')}}"></script>
@endsection