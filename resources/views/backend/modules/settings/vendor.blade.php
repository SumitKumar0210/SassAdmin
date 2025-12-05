@extends('backend.layouts.main')
@section('title','Setting Vendor')
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
                                        <h3 class="d-block">Vendor</h3>
                                    </div>
                                    <div class="col-12 col-sm-6">
                                        <div class="float-end">
                                            <button class="btn btn-primary px-2 vendor_add" type="button" data-bs-toggle="modal"
                                                data-bs-target="#vendorModel"><span class="btn-icon"><i class="ri-add-line"></i></span>
                                                Add Vendor</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <!-- Zero Configuration  Starts-->
                                <div class="col-lg-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="hover row-border stripe" id="vendor_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr.No.</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Address</th>
                                                            <th>GST</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Bed Type modal start -->
    <div class="modal fade" id="vendorModel" tabindex="-1" role="dialog" aria-labelledby="vendorModel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title vendorTitle">Add Vendor</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="vendor_form" class="g-3 needs-validation" novalidate="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 mb-3 gst_change_detail">
                                    <div class="form-check form-switch ms-2">
                                        <input class="form-check-input" type="checkbox" id="vendor_details_manually">
                                        <label class="form-check-label" for="vendor_details_manually">Add Vendor Manually</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 vendor_gst">
                                    <label class="form-label" for="vendor_gst">GST</label>
                                    <input class="form-control form-control-sm" id="vendor_gst" type="text" placeholder="Enter GST No" style="background-image: none;" required onchange="checkGstRequest(this.value)" maxlength="15">
                                    <div class="invalid-feedback">
                                        Enter GST
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <input type="hidden" id="vendorId">
                                    <label class="form-label" for="vendor_name">Name</label>
                                    <input class="form-control form-control-sm" id="vendor_name" type="text" placeholder="Enter Vendor Name" style="background-image: none;"
                                        required readonly>
                                    <div class="invalid-feedback">
                                        Enter Name
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="vendor_address">Registered Address</label>
                                    <input class="form-control form-control-sm" id="vendor_address" type="text" placeholder="Enter Address" style="background-image: none;"
                                        required readonly>
                                    <div class="invalid-feedback">
                                        Enter Address
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 d-none">
                                    <input class="form-control form-control-sm" id="gstLegalName" type="text" placeholder="gstLegalName" >
                                    <input class="form-control form-control-sm" id="gstAddrBnm" type="text" placeholder="gstAddrBnm">
                                    <input class="form-control form-control-sm" id="gstAddrBno" type="text" placeholder="gstAddrBno">
                                    <input class="form-control form-control-sm" id="gstAddrFlno" type="text" placeholder="gstAddrFlno">
                                    <input class="form-control form-control-sm" id="gstAddrSt" type="text" placeholder="gstAddrSt">
                                    <input class="form-control form-control-sm" id="gstAddrLoc" type="text" placeholder="gstAddrLoc">
                                    <input class="form-control form-control-sm" id="gstTxpType" type="text" placeholder="gstTxpType">
                                    <input class="form-control form-control-sm" id="gstStatus" type="text" placeholder="gstStatus">
                                    <input class="form-control form-control-sm" id="gstBlkStatus" type="text" placeholder="gstBlkStatus">
                                    <input class="form-control form-control-sm" id="gstDtReg" type="text" placeholder="gstDtReg" >
                                    <input class="form-control form-control-sm" id="gstDtDReg" type="text" placeholder="gstDtDReg">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="gstAddrPncd">Pincode <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm" id="gstAddrPncd" type="number" placeholder="Enter Pincode" style="background-image: none;"
                                        readonly>
                                    <div class="invalid-feedback">
                                        Enter Pincode
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="gstStateCode">State <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm" id="gstStateCode" style="background-image: none;" disabled>
                                        <option value="">Select State</option>
                                        @foreach ($states as $item)
                                            <option value="{{$item->gst_code}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Select State
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="vendor_mobile">Mobile</label>
                                    <input class="form-control form-control-sm" id="vendor_mobile" type="number" placeholder="Enter Mobile No." style="background-image: none;" oninput="this.value=this.value.slice(0,10)" required>
                                    <div class="invalid-feedback">
                                        Enter Mobile
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input check_address_billing" type="checkbox" id="1" checked="">
                                        <label class="form-check-label" for="1">Same as Registered Address </label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 billing-detail d-none">
                                    <label class="form-label" for="vendor_billing_address">Billing Address <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm" id="vendor_billing_address" type="text" placeholder="Enter Address" style="background-image: none;" >
                                    <div class="invalid-feedback">
                                        Enter Billing Address
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 billing-detail d-none">
                                    <label class="form-label" for="vendor_billing_pincode">Pincode <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm" id="vendor_billing_pincode" type="number" placeholder="Enter Pincode" style="background-image: none;" maxlength="6">
                                    <div class="invalid-feedback">
                                        Enter Pincode
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 billing-detail d-none">
                                    <label class="form-label" for="vendor_billing_state">State <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm" id="vendor_billing_state" style="background-image: none;">
                                        <option value="">Select State</option>
                                        @foreach ($states as $item)
                                            <option value="{{$item->gst_code}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Select State
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary vendorSubmit" type="submit">Submit</button>
                            <button class="btn btn-primary vendorUpdate d-none" type="button" onclick="vendorUpdate(document.getElementById('vendorId').value)">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bed Type modal end-->
@endsection
@section('extra-js')
<script>
    const vendorView = "{{ route('vendor.view') }}";
    const vendorAdd = "{{ route('vendor.add') }}";
    const vendorSwitchStatus = "{{ route('vendor.switchStatus') }}";
    const vendorGetData = "{{ route('vendor.getDetails') }}";
    const vendorDataUpdate = "{{ route('vendor.update') }}";
    const companyVerifyGst = "{{ route('company.verifyGst') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/vendor.js')}}"></script>
@endsection
