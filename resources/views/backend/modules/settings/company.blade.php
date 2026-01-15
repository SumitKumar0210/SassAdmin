@extends('backend.layouts.main')
@section('title','Setting Company')
@section('main-container')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid py-3">
            <div class="email-wrap bookmark-wrap">
                <div class="row">
                    <div class="col-xl-12 col-md-12 box-col-12">
                        <div> 
                            @include('backend.layouts.sidebar_master')
                        </div>
                        <div style=" padding-left:220px;">
                            <div class="container-fluid">
                                <div class="page-title mt-2">
                                    <div class="row gx-0">
                                        <div class="col-12 col-sm-6">
                                            <h3 class="d-block">Company</h3>
                                        </div>
                                        @if(in_array('Setting Add', (explode(',',auth()->user()->permission))))
                                            <div class="col-12 col-sm-6">
                                                <div class="float-end">
                                                    <button class="btn btn-primary px-2 add_company_modal" type="button" data-bs-toggle="modal"
                                                        data-bs-target="#companyModel"><span class="btn-icon"><i class="ri-add-line"></i></span>
                                                        Add Company</button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="container-fluid">
                                <div class="row">
                                    <!-- Zero Configuration  Starts-->
                                    <div class="col-xl-12 col-md-12 box-col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="hover row-border stripe" id="company_table">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr.No.</th>
                                                                <th>Name</th>
                                                                <th>GST </th>
                                                                <th>State</th>
                                                                <th>Mobile</th>
                                                                <th>Email</th>
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
        <!-- Container-fluid Ends-->
    </div>

    <!-- Bed Type modal start -->
    <div class="modal fade" id="companyModel" tabindex="-1" role="dialog" aria-labelledby="comapanyModel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title companyTitle">Add Company</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="company_form" class="g-3 needs-validation" novalidate="">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 mb-3 gst_change_detail">
                                    <div class="form-check form-switch ms-2">
                                        <input class="form-check-input" type="checkbox" id="compnay_details_manually">
                                        <label class="form-check-label" for="compnay_details_manually">Add Company Manually</label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 company_gst">
                                    <label class="form-label" for="company_gst">GST No <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm" id="company_gst" type="text" placeholder="Enter Company GST Number" style="background-image: none;" required onkeyup="checkGstRequest(this.value)" maxlength="15">
                                    <div class="invalid-feedback">
                                        Enter GST Number
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="company_name">Trade Name <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm" id="company_name" type="text" placeholder="Enter Trade Name" style="background-image: none;" readonly>
                                    <div class="invalid-feedback">
                                        Enter Trade Name
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="company_address">Registered Address <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm" id="company_address" type="text" placeholder="Enter Address" style="background-image: none;" readonly>
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
                                    <input type="hidden" id="company_id">
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
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="comapny_mobile">Mobile</label>
                                    <input class="form-control form-control-sm" id="company_mobile" type="number" placeholder="Enter Company Contact No" style="background-image: none;" required onkeyup='validateField("#company_mobile","mobile",".company_mobile_class")'>
                                    <div class="company_mobile_class"></div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="company_email">Email</label>
                                    <input class="form-control form-control-sm" id="company_email" type="email" placeholder="Enter Company Email" style="background-image: none;" required onkeyup="checkEmailValid('company_email',this.value)">
                                    <div class="company_email_class"></div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input check_address_billing" type="checkbox" id="1" checked="">
                                        <label class="form-check-label" for="1">Same as Registered Address </label>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 billing-detail d-none">
                                    <label class="form-label" for="company_billing_address">Billing Address <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm" id="company_billing_address" type="text" placeholder="Enter Address" style="background-image: none;" >
                                    <div class="invalid-feedback">
                                        Enter Billing Address
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 billing-detail d-none">
                                    <label class="form-label" for="company_billing_pincode">Pincode <span class="text-danger">*</span></label>
                                    <input class="form-control form-control-sm" id="company_billing_pincode" type="number" placeholder="Enter Pincode" style="background-image: none;" maxlength="6">
                                    <div class="invalid-feedback">
                                        Enter Pincode
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 billing-detail d-none">
                                    <label class="form-label" for="company_billing_state">State <span class="text-danger">*</span></label>
                                    <select class="form-control form-control-sm" id="company_billing_state" style="background-image: none;">
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
                            <button class="btn btn-outline-secondary" type="button"
                                data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary companySubmit" type="submit">Submit</button>
                            <button class="btn btn-primary companyUpdate d-none" type="button"
                                onclick="companyUpdate(document.getElementById('company_id').value)">Update</button>
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
    const companyView = "{{ route('company.view') }}";
    const companyAdd = "{{ route('company.add') }}";
    const companySwitchStatus = "{{ route('company.switchStatus') }}";
    const companyGetData = "{{ route('company.getDetails') }}";
    const companyDataUpdate = "{{ route('company.update') }}";
    const companyVerifyGst = "{{ route('company.verifyGst') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/company.js')}}"></script>
@endsection
