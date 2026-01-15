@extends('backend.layouts.main')
@section('title','Edit Reservation')
@section('main-container')
@section('extra-css')
<style>
	.onhover-show-div {
	  top: 35px;
	}
    .update-detail-btn {
        position: absolute;
        bottom: -59px;
        right: 140px; 
    }
    .update-guest-detail-btn {
        position: absolute;
        bottom: -76px;
        right: 140px; 
    }
    .update-note-btn {
        position: absolute;
        bottom: -59px;
        right: 140px;  
    }
    .cancel_reservation:hover{
        color: #fff !important;
    }
</style>
@endsection
<link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/dynamic-toggle-style.css')}}">
@php
    $permission_allow = explode(',',auth()->user()->permission);
@endphp
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title position-relative">
            <div class="row">
                <div class="col-6 col-sm-6 p-0">
                    <h3 class="edit_reservation_id">Edit Reservation {{$resrvationdetails[0]->reservation_id}} {{$resrvationdetails[0]->first_name}} {{$resrvationdetails[0]->last_name}}<span class="guest_room_id d-none"></span> 
                       
                    </h3>
                </div>
                 <div class="col-lg-6 col-sm-6 col-6">
                    @if(in_array('Reservation Cancel', $permission_allow))
                        <button class="btn btn-outline-danger text-danger cancel_reservation d-none me-2 pull-right" onclick="cancelReservationData()"><i class="icon-close px-2"></i> Cancel Booking</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" class="reservation_id_checkout" value="{{ $reservation_id }}"/>
    <input type="hidden" class="room_id_checkout" value="{{ $resid }}"/>
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="modal-body p-0">
                            <ul class="simple-wrapper nav nav-tabs bg-secondary pt-2 px-2 reservationTab" role="tablist">
                                <li class="nav-item"><a class="nav-link fw-normal text-uppercase active nav-modal-edit" id="detailTab" data-bs-toggle="tab" href="#detail" role="tab" aria-controls="detail" aria-selected="true">Details</a></li>
                                <li class="nav-item "><a class="nav-link  fw-normal text-uppercase nav-modal-edit" id="guestsTab" data-bs-toggle="tab" href="#guests" role="tab" aria-controls="profile" aria-selected="false">Guests</a></li>
                                <li class="nav-item"><a class="nav-link fw-normal text-uppercase nav-modal-edit" id="payment-tab" data-bs-toggle="tab" href="#payments" role="tab" aria-controls="payment" aria-selected="false">Payments</a></li>
                                <li class="nav-item"><a class="nav-link  fw-normal text-uppercase nav-modal-edit" id="Notes-tabs" data-bs-toggle="tab" href="#notes" role="tab" aria-controls="profile" aria-selected="false">Notes</a></li>
                                {{-- <li class="nav-item"><a class="nav-link fw-normal text-uppercase" id="invoice-tab" data-bs-toggle="tab" href="#invoice" role="tab" aria-controls="invoice" aria-selected="false">Invoice</a></li> --}}
                                <li class="nav-item"><a class="nav-link fw-normal text-uppercase nav-modal-edit" id="activity-tab" data-bs-toggle="tab" href="#activity" role="tab" aria-controls="activity" aria-selected="false">Activity</a></li>
                                <li class="nav-item"><a class="nav-link fw-normal text-uppercase nav-modal-edit" id="kot-tab" data-bs-toggle="tab" href="#kot" role="tab" aria-controls="kot" aria-selected="false">Kot</a></li>
                            </ul>
                            <div class="tab-content mt-3" id="myTabContent">
                                <!-- details start -->
                                <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="home-tab">
                                    <form id="edit_reservation_form" enctype="multipart/form-data">
                                        <div class="">
                                            
                                            <div class="row">
                                                <input type="hidden" id="newresID">
                                                <div class="col-lg-3 col-sm-12 col-12">
                                                    <div class="checkinbox mb-1">
                                                        <label class="form-label">Checkin</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text text-muted"><i class="icofont icofont-ui-calendar"></i></span>
                                                            {{-- <input class="form-control form-control-sm" id="res_checkin_Edit" name="res_checkin_Edit" type="date" value="{{$checkin}}" onchange="staycount_checkin(1)" style="background-color: #fff;">  --}}
                                                            <input class="form-control form-control-sm" id="res_checkin_Edit" name="res_checkin_Edit" type="date" value="{{$checkin}}" onchange="staycount_checkin()" style="background-color: #fff;" required> 
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-sm-12 col-12">
                                                    <div class="checkinbox mb-1">
                                                        <label class="form-label">Checkout</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text text-muted"><i class="icofont icofont-ui-calendar"></i></span><input class="form-control form-control-sm" id="res_checkout_Edit" name="res_checkout_Edit" type="date" value="{{$checkout}}" onchange="staycount_checkout(2)" style="background-color: #fff;">
                                                        </div>
                                                        <div class="date_format_err"></div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-sm-12 col-12">
                                                    <div class="mt-lg-4 mt-0 pt-2">
                                                        <label>
                                                            {{-- Length of stay: <strong><span class="reservation_durationEdit"><span>1 Night</strong><span class="px-1">|</span> --}}
                                                            Booking status: <span class="text-success reservation_edit_status"></span> </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 d-tab-wrapper edit_room_reservation_detail">
                                                    <div class="roomsDataSubmited"></div>
                                                    <div class="reservationNewRoomAdd"></div>
                                                    {{-- <div class="add-extra-room text-end addNewRoomClass">
                                                        <button class="btn btn-primary active px-2" type="button" id="addAnotherRoomEdit" onclick="addNewResFields('Edit')"><span class="btn-icon"><i class="ri-add-fill"></i></span>
                                                            Add Another Room</button>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-lg-12 col-sm-12 col-12">
                                                    <div class="border-top w-100">
                                                        <div class="d-flex align-items-center justify-content-start">
                                                            <h4 class="pt-3 mb-3 text-uppercase txt-secondary">Primary Contact</h4>&nbsp;&nbsp;
                                                            {{-- <div onclick="resetPrimaryForm(1)"><i class="ri-loop-right-line reset-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Contact Fields"></i></div> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-sm-12 col-12">
                                                    <div class="col-12">
                                                        <div class="row">
                                                            <div class="col-lg-3 col-sm-12">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="mobile_resvn_edit">Phone</label>
                                                                    <input class="form-control form-control-sm" type="number" id="mobile_resvn_edit" name="mobile_resvn_edit" placeholder="Phone" maxlength="10" oninput="handleInput_mobile_resvn()" readonly  value="{{$resrvationdetails[0]->mobile}}" required>
                                                                    <div id="itemCodeList d-none"></div>
                                                                    <div class="mobile_resvn_edit_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="first_name_resvn_edit">First Name <span class="text-danger">*</span></label>
                                                                    <input class="form-control form-control-sm" type="text" id="first_name_resvn_edit" name="first_name_resvn_edit" placeholder="First Name" oninput="handleInput_name_resvn()" value="{{$resrvationdetails[0]->first_name}}" required>
                                                                    <div class="first_name_resvn_edit_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="last_name_resvn_edit">Last Name</label>
                                                                    <input class="form-control form-control-sm" type="text" id="last_name_resvn_edit" name="last_name_resvn_edit" placeholder="Last Name" value="{{$resrvationdetails[0]->last_name}}">
                                                                    <div class="last_name_resvn_edit_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="gender_resvn_edit">Gender</label>
                                                                    <select class="form-select form-select-sm" id="gender_resvn_edit" name="gender_resvn_edit">
                                                                        <option value="">Select</option>
                                                                        <option value="Male" @if($resrvationdetails[0]->gender == 'Male') selected @endif>Male </option>
                                                                        <option value="Female" @if($resrvationdetails[0]->gender == 'Female') selected @endif>Female </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="email_resvn_edit">Email <span class="text-danger">*</span></label>
                                                                    <input class="form-control form-control-sm" type="email" id="email_resvn_edit" name="email_resvn_edit" placeholder="Email" value="{{$resrvationdetails[0]->email}}">
                                                                    <div class="email_resvn_edit_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="guest_type_resvn_edit">Guest Type <span class="text-danger">*</span></label>
                                                                    <select class="form-select form-select-sm" id="guest_type_resvn_edit" name="guest_type_resvn_edit">
                                                                        <option value="Normal" @if($resrvationdetails[0]->guest_type == 'Normal') selected @endif>Normal </option>
                                                                        <option value="VIP" @if($resrvationdetails[0]->guest_type == 'VIP') selected @endif>VIP </option>
                                                                        <option value="Corporate" @if($resrvationdetails[0]->guest_type == 'Corporate') selected @endif>Corporate </option>
                                                                    </select>
                                                                    <div class="guest_type_resvn_edit_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="allergic_to_resvn_edit">Allergic To</label>
                                                                    <input class="form-control form-control-sm" type="text" id="allergic_to_resvn_edit" name="allergic_to_resvn_edit" placeholder="Allergic" value="{{$resrvationdetails[0]->allergic_to}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="address_resvn_edit">Address <span class="text-danger">*</span></label>
                                                                    <input class="form-control form-control-sm" type="text" id="address_resvn_edit" name="address_resvn_edit" placeholder="Address" value="{{$resrvationdetails[0]->address}}">
                                                                    <div class="address_resvn_edit_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="city_resvn_edit">City</label>
                                                                    <input class="form-control form-control-sm" type="text" id="city_resvn_edit" name="city_resvn_edit" placeholder="City" value="{{$resrvationdetails[0]->city}}">
                                                                    <div class="city_resvn_edit_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="state_resvn_edit">State <span class="text-danger">*</span></label>
                                                                    <input class="form-control form-control-sm" type="text" id="state_resvn_edit" name="state_resvn_edit" placeholder="State" value="{{$resrvationdetails[0]->state}}">
                                                                    <div class="state_resvn_edit_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="pin_resvn_edit">PIN / ZIP </label>
                                                                    <input class="form-control form-control-sm" type="number" id="pin_resvn_edit" name="pin_resvn_edit" placeholder="PIN / ZIP" maxlength="6" oninput="this.value=this.value.slice(0,6)" value="{{$resrvationdetails[0]->pincode}}">
                                                                    <div class="pin_resvn_edit_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="country_resvn_edit">Country <span class="text-danger">*</span></label>
                                                                    <input class="form-control form-control-sm" type="text" id="country_resvn_edit" name="country_resvn_edit" placeholder="Country" value="{{$resrvationdetails[0]->country}}">
                                                                    <div class="country_resvn_edit_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="coming_from_resvn_edit">Coming From <span class="text-danger">*</span></label>
                                                                    <input class="form-control form-control-sm" type="text" id="coming_from_resvn_edit" name="coming_from_resvn_edit" placeholder="Coming From" value="{{$resrvationdetails[0]->coming_from}}">
                                                                    <div class="coming_from_resvn_edit_class text-danger validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="going_to_resvn_edit">Going To <span class="text-danger">*</span></label>
                                                                    <input class="form-control form-control-sm" type="text" id="going_to_resvn_edit" name="going_to_resvn_edit" placeholder="Going To" value="{{$resrvationdetails[0]->going_to}}">
                                                                    <div class="going_to_resvn_edit_class text-danger validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="purpose_of_visit_resvn_edit">Purpose Of Visit <span class="text-danger">*</span></label>
                                                                    <input class="form-control form-control-sm" type="text" id="purpose_of_visit_resvn_edit" name="purpose_of_visit_resvn_edit" placeholder="Purpose Of Visit" value="{{$resrvationdetails[0]->purpose_for_visit}}">
                                                                    <div class="purpose_of_visit_resvn_edit_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="arrivaltime_resvn_edit">Arrival Time</label>
                                                                    <select class="form-select form-select-sm" id="arrivaltime_resvn_edit" name="arrivaltime_resvn_edit">
                                                                        <option value=""> Select Arrival Time</option>
                                                                        <option value="Morning" @if($resrvationdetails[0]->arrival_time == 'Morning') selected @endif> Morning</option>
                                                                        <option value="Afternoon" @if($resrvationdetails[0]->arrival_time == 'Afternoon') selected @endif> Afternoon</option>
                                                                        <option value="Evening" @if($resrvationdetails[0]->arrival_time == 'Evening') selected @endif> Evening</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="documenttype_resvn_edit">Document type </label>
                                                                    <select class="form-select form-select-sm" id="documenttype_resvn_edit" name="documenttype_resvn_edit" onchange="docTypeValue(this.value)">
                                                                        <option value="">Document type</option>
                                                                        <option value="Aadhar Card" @if($resrvationdetails[0]->document_type == 'Aadhar Card') selected @endif>Aadhar Card </option>
                                                                        <option value="Pan Card" @if($resrvationdetails[0]->document_type == 'Pan Card') selected @endif>Pan Card</option>
                                                                        <option value="Driving Licence" @if($resrvationdetails[0]->document_type == 'Driving Licence') selected @endif>Driving Licence</option>
                                                                        <option value="Other" @if($resrvationdetails[0]->document_type == 'Other') selected @endif>Other</option>
                                                                    </select>
                                                                    <div class="documenttype_resvn_edit_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12" id="otherdetail_resvncc" style="display:none">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" id="otherdetail_resvn_edit">Other Document Type</label>
                                                                    <input class="form-control form-control-sm" type="text" id="otherdetail_resvn_edit" name="otherdetail_resvn_edit" placeholder="Other Details" value="{{$resrvationdetails[0]->other_document_type}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-6" >
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="idnumber_resvn_edit">ID Number </label>
                                                                    <input class="form-control form-control-sm" type="text" placeholder="Document Number" maxlength="15" id="idnumber_resvn_edit" name="idnumber_resvn_edit" oninput="this.value=this.value.slice(0,15)" value="{{$resrvationdetails[0]->id_number}}">
                                                                    <div class="idnumber_resvn_edit_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-sm-12">
                                                                <div class="form-group mb-1">
                                                                    <label class="form-label" for="photo_resvn_edit">ID Proof <span class="text-danger">*</span></label>
                                                                    <input class="form-control form-control-sm" type="file" id="photo_resvn_edit" name="photo_resvn_edit"/>
                                                                    <div class="photo_resvn_edit_class text-danger validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-sm-12 col-12">
                                                            <div class="mb-1">
                                                                <label class="form-label" for="comments_resvn_edit">Guest Comments</label>
                                                                <textarea class="form-control" id="comments_resvn_edit" name="comments_resvn_edit" rows="1" >{{$resrvationdetails[0]->guest_comment}}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-sm-12 col-12 d-none">
                                                            <div class="mb-1">
                                                                <label class="form-label" for="note_resvn_edit">Notes</label>
                                                                <textarea class="form-control" id="note_resvn_edit" name="note_resvn_edit" rows="1" >{{$resrvationdetails[0]->note}}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 mb-1 d-none">
                                                            <input class="form-control form-control-sm" id="gstLegalName_edit" name="gstLegalName" type="text" placeholder="gstLegalName" >
                                                            <input class="form-control form-control-sm" id="gstAddrBnm_edit" name="gstAddrBnm" type="text" placeholder="gstAddrBnm">
                                                            <input class="form-control form-control-sm" id="gstAddrBno_edit" name="gstAddrBno" type="text" placeholder="gstAddrBno">
                                                            <input class="form-control form-control-sm" id="gstAddrFlno_edit" name="gstAddrFlno" type="text" placeholder="gstAddrFlno">
                                                            <input class="form-control form-control-sm" id="gstAddrSt_edit" name="gstAddrSt" type="text" placeholder="gstAddrSt">
                                                            <input class="form-control form-control-sm" id="gstAddrLoc_edit" name="gstAddrLoc" type="text" placeholder="gstAddrLoc">
                                                            <input class="form-control form-control-sm" id="gstTxpType_edit" name="gstTxpType" type="text" placeholder="gstTxpType">
                                                            <input class="form-control form-control-sm" id="gstStatus_edit" name="gstStatus" type="text" placeholder="gstStatus">
                                                            <input class="form-control form-control-sm" id="gstBlkStatus_edit" name="gstBlkStatus" type="text" placeholder="gstBlkStatus">
                                                            <input class="form-control form-control-sm" id="gstDtReg_edit" name="gstDtReg" type="text" placeholder="gstDtReg" >
                                                            <input class="form-control form-control-sm" id="gstDtDReg_edit" name="gstDtDReg" type="text" placeholder="gstDtDReg">
                                                            <input class="form-control form-control-sm" id="gstTradeName_edit" name="gstTradeName" type="text" placeholder="gstTradeName">
                                                            <input class="form-control form-control-sm" id="gstStateCode_edit" name="gstStateCode" type="text" placeholder="gstStateCode">
                                                            <input class="form-control form-control-sm" id="gstAddrPncd_edit" name="gstAddrPncd" type="text" placeholder="gstAddrPncd">
                                                            <input class="form-control form-control-sm" id="gstAddr_edit" name="gstAddr" type="text" placeholder="gstAddr">
                                                        </div>
                                                        @if($last_company != '')
                                                        <div class="col-12 py-2 last-company-detail bg-light">
                                                            <h5 class="my-2">Company Detail</h5>
                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <label class="form-label">Company Name</label>
                                                                    <input class="form-control form-control-sm" id="last_company_id" name="last_company_id" type="hidden" placeholder="Search Company" value="{{$last_company_id}}" readonly>
                                                                    <input class="form-control form-control-sm" id="last_company" type="text" placeholder="Search Company" onkeyup="getCompanyList()" value="{{$last_company}}">
                                                                    <div id="itemCompanyList"></div>
                                                                    <div class="company_name_error_class text-danger"></div>
                                                                </div>
                                                                <div class="col-3">
                                                                    <label class="form-label">GstIn</label>
                                                                    <input class="form-control form-control-sm" id="last_GST" type="text" placeholder="GST" value="{{$gst_last}}" readonly>
                                                                </div>
                                                                <div class="col-5">
                                                                    <label class="form-label">Address</label>
                                                                    <input class="form-control form-control-sm" id="last_addr" type="text" placeholder="Address" value="{{$last_company_addr}}" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        <div class="col-12 py-2">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" id="updateGSTBtn" name="updateGSTBtn">
                                                                <label for="updateGSTBtn">Do you want to update Company Detail ?</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 py-2 gst-fetch-update-view d-none">
                                                            <h5 class="my-2">Billing Type</h5>
                                                            <div class="control ms-4">
                                                                <div class="control__track">
                                                                    <div class="indicator"></div>
                                                                        <label for="freeEdit">Individual</label>
                                                                        <input class="sr-only" type="radio" name="billtype" id="freeEdit" value="individual" checked />
                                                                    <div class="premium">
                                                                    <div class="indicator"></div>
                                                                        <label for="b2bEdit"><span>B2B</span><span class="sr-only">Company B2B</span></label>
                                                                        <input class="sr-only" type="radio" name="billtype" id="b2bEdit" value="b2b"/>
                                                                        <label for="b2cEdit"><span>B2C</span><span class="sr-only">Company B2C</span></label>
                                                                        <input class="sr-only" type="radio" name="billtype" id="b2cEdit" value="b2c"/>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- B2B Company --}}
                                                            <div id="b2bCompanyEdit" class="b2b-company">
                                                                <div class="d-flex flex-wrap gap-3 my-4">
                                                                    <div class="form-group ">
                                                                        {{-- <label class="form-label">GSTIN</label> --}}
                                                                        <input class="form-control form-control-sm" type="text" placeholder="Enter GSTIN" id="companygst_resvn_edit" name="companygst_resvn_edit" maxlength="15" onkeyup="checkGstCompany(this.value,1)">
                                                                    </div>
                                                                    <button class="btn btn-primary gst-fetch-detail_edit" type="button" onclick="checkGstRequest(1)" disabled>Fetch</button>
                                                                    <div class="gst-address_edit d-none"></div>
                                                                </div>
                                                            </div>
                                                            {{-- B2C Company --}}
                                                            <div id="b2cCompanyEdit" class="b2b-company my-4">
                                                                <div class="row">
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group ">
                                                                            <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                                                            <input class="form-control form-control-sm" type="text" id="companyname_resvn_edit" name="companyname_resvn_edit" placeholder="Company Name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group ">
                                                                            <label class="form-label">Company Address <span class="text-danger">*</span></label>
                                                                            <input class="form-control form-control-sm" type="text" id="companyaddress_resvn_edit" name="companyaddress_resvn_edit" placeholder="Company Address">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group ">
                                                                            <label class="form-label"> Pincode <span class="text-danger">*</span></label>
                                                                            <input class="form-control form-control-sm" type="number" id="companypincode_resvn_edit" name="companypincode_resvn_edit" placeholder="Company Pincode" maxlength="6" pattern="[0-9]*">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-12">
                                                                        <div class="form-group ">
                                                                            <label class="form-label" for="companystate_resvn">State <span class="text-danger">*</span></label>
                                                                            <select class="form-control form-control-sm" id="companystate_resvn_edit" name="companystate_resvn" style="background-image: none;">
                                                                                <option value="">Select State</option>
                                                                                @foreach ($states as $item)
                                                                                    <option value="{{$item->gst_code}}">{{$item->name}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="col-lg-4 col-sm-12 col-12 position-relative rsummary">
                                                    @include('backend.modules.models.bookingPaymentModel')
                                                    <!-- payment Records start -->
                                                    <div class="paymentRec-Dtab paymentRec-Dtab-detail position-absolute  top-0 px-3 py-2  text-dark bg-primary">
                                                        <div class="summary-btn position-absolute bg-primary d-block p-2 rounded-start" id="dtab-hidebtn"><i class="icon-angle-right"></i></div>
                                                        <h4 class="text-uppercase my-1">Booking Summary</h4>
                                                        <p class="mb-1"> Manually record a payment that has been taken outside of Hotel.</p>
                                                        <div class="container-fluid gx-0">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label class="form-label" for="amount_o_rsv_detail">Amount</label>
                                                                    <input class="form-control form-control-sm py-1 amount_o_rsv" id="amount_o_rsv_detail" value="0" type="number" placeholder="Enter Amount" oninput="validateField('#amount_o_rsv_detail','amount','.amount_o_rsv_detail_class')">
                                                                    <div class="amount_o_rsv_class"></div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label  ">Payment Date</label>
                                                                    <div class="input-group mb-3">
                                                                        <input class="form-control form-control-sm py-1 flatpickr-input active" id="payment_date_outside_rsv_detail" type="date" placeholder="0000-00-00" value="{{date('Y-m-d')}}">
                                                                        <span class="input-group-text rounded-end py-1"><i class="icofont icofont-ui-calendar"></i></span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="form-label  ">Payment Type</label>
                                                                    <select class="form-select form-select-sm py-1" id="payment_type_o_rsv_detail" onchange="payment_id_type(this.value)" aria-label=".form-select-sm example">
                                                                        @foreach($payments as $pay)
                                                                            <option value="{{$pay->id}}">{{$pay->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 payment_id_number_class d-none">
                                                                    <label class="form-label payment_id_number_label ">Payment Type Detail</label>
                                                                    <input class="form-control form-control-sm py-1" id="payment_id_number_detail" value="" type="text" placeholder="Enter Details">
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="d-flex align-items-center justify-content-between">
                                                                        <span>Note</span>
                                                                        {{-- <div class="form-check checkbox-checked ">
                                                                            <input class="form-check-input shadow-none" id="shownote_outside_rsv" type="checkbox">
                                                                            <label class="form-check-label shadow-none" for="showinvoice">Show note on invoice</label>
                                                                        </div> --}}
                                                                    {{-- </div>
                                                                    <textarea class="form-control btn-square" id="note_o_rsv_detail" rows="1"></textarea>
                                                                </div>
                                                                <div class="col-md-12 guestEmail">
                                                                    <label class="form-label">Guest Email</label>
                                                                    <input class="form-control form-control-sm py-1 " id="guest_email_o_rsv" type="email" value="">
                                                                </div>
                                                                <div class="col-md-12 mt-2">
                                                                    <div class="d-flex justify-content-between gap-3">
                                                                        <div class="btn-group w-50" role="group" aria-label="Button group with nested dropdown">
                                                                            <button class="btn btn-warning confirmStatusbtn" onclick="outsidePaymentRecode(`detail`)">Submit</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    <!-- payment Records end -->
                                                {{-- </div> --}} 
                                            </div>
                                        </div>
                                        
                                        <button class="btn btn-info confirmStatusbtn update_res_Btn mx-1 update-detail-btn" type="submit">Update Detail</button>
                                        {{-- <div class="row mt-3">
                                            <div class="col-12">
                                                <button class="btn btn-info res_update_loader d-none" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please Wait... </button>
                                                <button class="btn btn-info confirmStatusbtn update_res_Btn mx-1" type="submit">Update Detail</button>
                                            </div>
                                        </div> --}}
                                    </form>
                                </div>
                                <!-- details end -->
                                <!-- guests start -->
                                @php
                                    $isPrimary = 0;
                                    $primary_id = '';
                                    $primary_name = '';
                                    $primary_mobile = '';
                                    $primary_gender = '';
                                    $primary_document_type = '';
                                    $primary_idnumber = '';
                                    $guest_count = 1;
                                foreach($guestRoom as $guest){
                                    $guest_count = count($guest['guests']);
                                    foreach($guest['guests'] as $guestList){
                                        if($isPrimary == 0){
                                            if($guestList['isPrimary'] == 1){
                                                $isPrimary = 1;
                                                $primary_id = $guestList['id'];
                                                $primary_name = $guestList['first_name'].' '.$guestList['last_name'];
                                                $primary_mobile = $guestList['mobile'];
                                                $primary_gender = $guestList['gender'];
                                                $primary_document_type = $guestList['document_type'];
                                                $primary_idnumber = $guestList['id_number'];
                                            }
                                        }
                                    }
                                }
                                @endphp
                                <div class="tab-pane fade " id="guests" role="tabpanel">
                                    <div class="row mt-2">
                                        <div class="col-md-12 g-tab-wrapper" id="">
                                            <div class="add-extra-room text-end d-flex justify-content-between align-items-center">
                                                <h4 class="txt-secondary selected-room-detail"></h4>
                                                <div>
                                                    {{-- <button class="btn btn-light active px-2 me-3 primary_as_guest" type="button" onclick="addPrimaryAsGuest()">
                                                        <span class="btn-icon"><i class="icon-plus me-1" style="font-size:10px"></i></span>
                                                        Add Primary As Guests
                                                    </button> --}}
                                                    <button class="btn btn-light active px-2 g-tab-clone# " type="button" onclick="addNewGuest()">
                                                        <span class="btn-icon">
                                                            <i class="icon-plus me-1" style="font-size:10px"></i></span>
                                                        Add New Guests
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="addGuestsTitle">
                                                <span>No Guest</span>
                                            </div>
                                            <form id="guestForm" enctype="multipart/form-data">
                                                <div class="" id="guestTabCol1">
                                                    <div class="room-type-bar border-radius-4 my-2 px-3 py-2 bg-light g-tab-element">
                                                        
                                                        <div class="row">
                                                            <div class="col">
                                                                <div class="mb-3 mb-lg-1">
                                                                    <label class="form-label text-dark">Name</label>
                                                                    <input class="form-control form-control-sm" id="name_g_rsv_add_new" name="name_g_rsv_add[]" type="text" required="" value="{{$primary_name}}">
                                                                    <div class="name_g_rsv_add_new_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="mb-3 mb-lg-1">
                                                                    <label class="form-label text-dark">Mobile Number</label>
                                                                    <input class="form-control form-control-sm" id="mobile_g_rsv_add_new" name="mobile_g_rsv_add[]" type="number" maxlength="10" autocomplete="off" pattern="[1-9]{1}[0-9]{9}" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required title="Please enter exactly 10 digits" value="{{$primary_mobile}}">
                                                                    <div class="mobile_g_rsv_add_new_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="mb-3 mb-lg-1">
                                                                    <label class="form-label text-dark ">Gender</label>
                                                                    <select class="form-select form-select-sm" id="gender_g_rsv_add_new" name="gender_g_rsv_add[]" required>
                                                                        <option value="">Select</option>
                                                                        <option value="Male" @if($primary_gender == 'Male') selected @endif>Male</option>
                                                                        <option value="Female" @if($primary_gender == 'Female') selected @endif>Female</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="mb-3 mb-lg-1">
                                                                    <label class="form-label text-dark">Document Type</label>
                                                                    <select class="form-select form-select-sm" id="doc_g_rsv_add_new" name="doc_g_rsv_add[]" required>
                                                                    <option value="">Select</option>
                                                                        <option value="Aadhar Card" @if($primary_document_type == 'Aadhar Card') selected @endif>Aadhar Card</option>
                                                                        <option value="Pan Card" @if($primary_document_type == 'Pan Card') selected @endif>Pan Card</option>
                                                                        <option value="Voter ID" @if($primary_document_type == 'Voter ID"') selected @endif>Voter ID</option>
                                                                        <option value="Passport" @if($primary_document_type == 'Passport') selected @endif>Passport</option>
                                                                        <option value="Driving Licence" @if($primary_document_type == 'Driving Licence') selected @endif>Driving Licence</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="mb-3 mb-lg-1">
                                                                    <label class="form-label text-dark">Id Number</label>
                                                                    <input class="form-control form-control-sm" id="idnum_g_rsv_add_new" name="idnum_g_rsv_add[]" type="text" maxlength="15" oninput="this.value=this.value.slice(0,15)" required value="{{$primary_idnumber}}">
                                                                    <div class="email_g_rsv_add_new_class validation_error_msg"></div>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="mb-3 mb-lg-1">
                                                                    <div class="d-flex justify-content-between">
                                                                        <div>
                                                                            <label class="form-label text-dark">Id Proof</label>
                                                                            <input class="form-control form-control-sm" name="idproof_g_rsv_add[]" type="file" accept="image/*">
                                                                        </div>
                                                                        @if($guest_count > 1)
                                                                        <div class="ms-2 mt-4">
                                                                            <span title="Exit Guest" onclick="exitGuest({{$primary_id}})"><i class="ri-logout-box-r-line text-danger" style="font-size: 20px;"></i></span>
                                                                        </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @foreach($guestRoom as $guest)
                                                            @foreach($guest['guests'] as $guestList)
                                                                @if($guestList['isPrimary'] == 0)
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="mb-3 mb-lg-1">
                                                                            <label class="form-label text-dark">Name</label>
                                                                            <input class="form-control form-control-sm" id="name_g_rsv_add_new" name="name_g_rsv_add[]" type="text" required="" value="{{$guestList['first_name']}} {{$guestList['last_name']}}">
                                                                            <div class="name_g_rsv_add_new_class validation_error_msg"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="mb-3 mb-lg-1">
                                                                            <label class="form-label text-dark">Mobile Number</label>
                                                                            <input class="form-control form-control-sm" id="mobile_g_rsv_add_new" name="mobile_g_rsv_add[]" type="number" maxlength="10" autocomplete="off" pattern="[1-9]{1}[0-9]{9}" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" required title="Please enter exactly 10 digits" value="{{$guestList['mobile']}}">
                                                                            <div class="mobile_g_rsv_add_new_class validation_error_msg"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="mb-3 mb-lg-1">
                                                                            <label class="form-label text-dark ">Gender</label>
                                                                            <select class="form-select form-select-sm" id="gender_g_rsv_add_new" name="gender_g_rsv_add[]" required>
                                                                                <option value="">Select</option>
                                                                                <option value="Male" @if($guestList['gender'] == 'Male') selected @endif>Male</option>
                                                                                <option value="Female" @if($guestList['gender'] == 'Female') selected @endif>Female</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="mb-3 mb-lg-1">
                                                                            <label class="form-label text-dark">Document Type</label>
                                                                            <select class="form-select form-select-sm" id="doc_g_rsv_add_new" name="doc_g_rsv_add[]" required>
                                                                            <option value="">Select</option>
                                                                                <option value="Aadhar Card" @if($guestList['document_type'] == 'Aadhar Card') selected @endif>Aadhar Card</option>
                                                                                <option value="Pan Card" @if($guestList['document_type'] == 'Pan Card') selected @endif>Pan Card</option>
                                                                                <option value="Voter ID" @if($guestList['document_type'] == 'Voter ID"') selected @endif>Voter ID</option>
                                                                                <option value="Passport" @if($guestList['document_type'] == 'Passport') selected @endif>Passport</option>
                                                                                <option value="Driving Licence" @if($guestList['document_type'] == 'Driving Licence') selected @endif>Driving Licence</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="mb-3 mb-lg-1">
                                                                            <label class="form-label text-dark">Id Number</label>
                                                                            <input class="form-control form-control-sm" id="idnum_g_rsv_add_new" name="idnum_g_rsv_add[]" type="text" maxlength="15" oninput="this.value=this.value.slice(0,15)" required value="{{$guestList['id_number']}}">
                                                                            <div class="email_g_rsv_add_new_class validation_error_msg"></div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="mb-3 mb-lg-1">
                                                                            <div class="d-flex justify-content-between">
                                                                                <div>
                                                                                    <label class="form-label text-dark">Id Proof</label>
                                                                                    <input class="form-control form-control-sm" name="idproof_g_rsv_add[]" type="file" accept="image/*">
                                                                                </div>
                                                                                @if($guest_count > 1)
                                                                                <div class="ms-2 mt-4">
                                                                                    <span title="Exit Guest" onclick="exitGuest({{$guestList['id']}})"><i class="ri-logout-box-r-line text-danger" style="font-size: 20px;"></i></span>
                                                                                </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                </div>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                        
                                                    </div>
                                                    <div class="add_new_guest"></div>
                                                </div>
                                                <button class="btn btn-info confirmStatusbtn update-guest-detail-btn update_res_Btn mx-1" type="submit">Update Guest</button>
                                            </form>
                                            <div class="g-tab-results"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- guests end -->
                                <!-- payments start -->
                                <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="modal-body">
                                        <div class="row mt-3">
                                            <div class="col-lg-8 col-sm-12 col-12">
                                                <div class="d-flex justify-content-between" >
                                                    <div>
                                                        <h4 class="txt-secondary mt-2">COMPLETED PAYMENTS</h4>
                                                    </div>
                                                    <div class="text-end pull-right">
                                                        <button class="btn btn-primary" onclick="printReceipt()">Print Receipt</button>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <table class="table mt-4 border payments-table">
                                                        <thead>
                                                            <tr class="bg-light">
                                                                <td>Select<input class="form-check-input ms-1" type="checkbox" id="selectAllPayment"></td>
                                                                <td>Date</td>
                                                                <td>Amount</td>
                                                                <td>Mode</td>
                                                                <td>Recorded By</td>
                                                                <td>Action</td>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="recored-payment-log">
                                                            @foreach($payment_log as $log)
                                                                <tr>
                                                                    <td>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input paymentId" type="checkbox" name="paymentId[]" value="{{$log['type']}}-{{$log['id']}}">
                                                                        </div>
                                                                    </td>
                                                                    <td>{{$log['date']}}</td>
                                                                    <td>₹ {{$log['amount']}}</td>
                                                                    <td>{{$log['mode']}}</td>
                                                                    <td>{{$log['recorded_by']}}</td>
                                                                    <td><button class="btn btn-outline-primary" onclick="printSingleVoucher(`{{$log['type']}}`,{{$log['id']}})"><i class="ri-printer-line"></i></button></td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12 col-12 position-relative rsummary mb-5">
                                                @include('backend.modules.models.bookingPaymentModel')
                                                <!-- payment Records start -->
                                                <div class="paymentRec-Dtab paymentRec-Dtab-payment position-absolute  top-0 px-3 py-2  text-dark bg-primary">
                                                    <div class="summary-btn position-absolute bg-primary d-block p-2 rounded-start" id="dtab-hidebtn"><i class="icon-angle-right"></i></div>
                                                    <h4 class="text-uppercase my-1">Booking Summary</h4>
                                                    <p class="mb-1"> Manually record a payment that has been taken outside of Hotel.</p>
                                                    <div class="container-fluid gx-0">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <label class="form-label" for="amount_o_rsv_payment">Amount</label>
                                                                <input class="form-control form-control-sm py-1 amount_o_rsv" id="amount_o_rsv_payment" value="0" type="number" placeholder="Enter Amount" oninput="validateField('#amount_o_rsv_payment','amount','.amount_o_rsv_payment_class')">
                                                                <div class="amount_o_rsv_payment_class"></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Payment Date</label>
                                                                <div class="input-group mb-3">
                                                                    <input class="form-control form-control-sm py-1 flatpickr-input active" id="payment_date_outside_rsv_payment" type="date" placeholder="0000-00-00" value="{{date('Y-m-d')}}">
                                                                    <span class="input-group-text rounded-end py-1"><i class="icofont icofont-ui-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label">Payment Type</label>
                                                                <select class="form-select form-select-sm py-1" id="payment_type_o_rsv_payment" onchange="payment_id_type(this.value)" aria-label=".form-select-sm example">
                                                                    @foreach($payments as $pay)
                                                                        <option value="{{$pay->id}}">{{$pay->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 payment_id_number_payment_class d-none">
                                                                <label class="form-label payment_id_number_payment_label ">Payment Type Detail</label>
                                                                <input class="form-control form-control-sm py-1" id="payment_id_number_payment" value="" type="text" placeholder="Enter Details">
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="d-flex align-items-center justify-content-between">
                                                                    <span>Note</span>
                                                                    <div class="form-check checkbox-checked ">
                                                                        <input class="form-check-input shadow-none" id="shownote_outside_rsv" type="checkbox">
                                                                        <label class="form-check-label shadow-none" for="showinvoice">Show note on invoice</label>
                                                                    </div>
                                                                </div>
                                                                <textarea class="form-control btn-square" id="note_o_rsv_payment" rows="1"></textarea>
                                                            </div>
                                                            <div class="col-md-6 mt-2">
                                                                <div class="form-check checkbox-checked ">
                                                                    <input class="form-check-input shadow-none" id="email_invoice_o_rsv" type="checkbox" value="">
                                                                    <label class="form-check-label shadow-none" for="Email invoice">Email invoice</label>
                                                                </div>
                                                            </div>
                                                            {{-- <div class="col-md-6 mt-2">
                                                                <div class="d-flex justify-content-between p-2 bg-light text-dark rounded sub-charge">
                                                                    <div class="">
                                                                        <p class="mb-0">Sucharge</p>
                                                                        <p class="mb-0">₹0</p>
                                                                    </div>
                                                                    <div class="">
                                                                        <p class="mb-0">Total</p>
                                                                        <p class="mb-0">₹0</p>
                                                                    </div>
                                                                </div>
                                                            </div> --}}
                                                            <div class="col-md-12 guestEmail">
                                                                <label class="form-label">Guest Email</label>
                                                                <input class="form-control form-control-sm py-1 " id="guest_email_o_rsv" type="email" value="">
                                                            </div>
                                                            <div class="col-md-12 mt-2">
                                                                <div class="d-flex justify-content-between gap-3">
                                                                    {{-- <button class="btn btn-danger w-50 cancelslide-Dtab">Cancel</button> --}}
                                                                    <div class="btn-group w-50" role="group" aria-label="Button group with nested dropdown">
                                                                        <button class="btn btn-warning confirmStatusbtn" onclick="outsidePaymentRecode(`payment`)">Submit</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- payment Records end -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- payments end -->
                                <!-- notes start -->
                                <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="contact-tab">
                                    <form id="edit_reservation_form_note" action="javascript:void(0)">
                                        <div class="row mt-3">
                                            <div class="col-lg-12 col-sm-12 col-12">
                                                <div class="notes-form">
                                                    <label class="form-label text-dark ">Notes</label>
                                                    <textarea class="form-control btn-square" id="roomGuestNotes" name="edit_reservation_notes" rows="12" required>{{$resrvationdetails[0]->note}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-info mx-1 update-note-btn" type="submit">Update Note</button>
                                    </form>
                                </div>
                                <!-- notes end -->
                                <!-- Activity start -->
                                <div class="tab-pane fade " id="activity" role="tabpanel" aria-labelledby="contact-tab">
                                    <div class="ecommerce-dashboard mt-3">
                                        <ul class="message-box custom-scrollbar px-3 py-3 reservation-log">
                                            @foreach($activity_logs as $activity_log)
                                            <li>
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 bg-dark-color">
                                                        <i class="fa fa-check-circle"></i>
                                                    </div>
                                                    <div class="flex-grow-1 d-flex">
                                                        <div>
                                                            <a href="">
                                                                <h6 class="fw-normal"> {{$activity_log['activity']}} </h6>
                                                                <p> {{$activity_log['activity_by']}} </p>
                                                            </a>  
                                                        </div>
                                                        <div class="ms-5">
                                                            <span> {{$activity_log['date']}} </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <!-- Activity end -->
                                <!-- Activity start -->
                                <div class="tab-pane fade " id="kot" role="tabpanel" aria-labelledby="kot-tab">
                                    <div class="row mt-3">
                                        <div class="col-lg-12 col-sm-12 col-12">
                                            <h4 class="txt-secondary mt-2">COMPLETED KOT PAYMENTS</h4>
                                            <div class="col-12">
                                                <table class="table mt-4 border">
                                                    <thead>
                                                        <tr>
                                                            <td>Order Date & Time</td>
                                                            <td class="text-end">Sub Total</td>
                                                            <td class="text-end">Gst Amount</td>
                                                            <td class="text-end">Grand Total</td>
                                                            <td class="text-end">Action</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="kot-payments-table">
                                                        @php
                                                            $pending_kot = 0;
                                                        @endphp
                                                        @foreach($kotList as $kot)
                                                        <tr>
                                                            <td>{{$kot['order_time']}}</td>
                                                            <td class="text-end"><span class="me-1">₹</span> {{$kot['sub_total']}} </td>
                                                            <td class="text-end"><span class="me-1">₹</span> {{$kot['total_gst']}} </td>
                                                            <td class="text-end"><span class="me-1">₹</span> {{$kot['grand_total']}}</td>
                                                            <td class="text-end">
                                                                @if($kot['payment_type'] == 'Due' || $kot['payment_type'] == 'Complete with Due')
                                                                @php
                                                                    $pending_kot++;
                                                                @endphp
                                                                    <button class="btn btn-primary" onClick="recordKotPayment({{$kot['id']}},{{$kot['grand_total']}})">Record Payment</button>
                                                                @else
                                                                    <button class="btn btn-outline-info" onClick="printKotRes('{{$kot['kot_id']}}')">Print</button>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                    @if($pending_kot > 1)
                                                    <tfoot class="kot-payments-record-all d-none">
                                                        <tr>
                                                            <td colspan="4"></td>
                                                            <td class="text-end"><button class="btn btn-primary ">Record All Payment</button></td>
                                                        </tr>
                                                    </tfoot>
                                                    @endif
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-sm-12 col-12 mt-3 border-top">
                                <div class="mt-4">
                                    <button class="btn btn-info res_update_loader d-none" type="button" disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please Wait... </button>
                                    <button class="btn btn-primary confirmStatusbtn checkin_res_Btn pull-right" onclick="checkinBtn(`{{ $reservation_id }}`,{{ $resid }})">Checkin</button>
                                    <button class="btn btn-warning confirmStatusbtn checkout_res_Btn pull-right" onclick="checkoutBtn()">Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
    @include('backend.modules.models.editReservationModel')
    @include('backend.modules.models.collectPaymentModel')
    @include('backend.modules.models.changeTariffModel')
@endsection
@section('extra-js') 
<script>
    const reservationViewLayout = "{{ route('reservation-layout.reservationViewLayout') }}";
	const getRservationandRoomDetails = "{{ route('reservation.getRservationandRoomDetails') }}";
	const checkinProcess = "{{ route('reservation.roomcheckIn') }}";
    const checkoutProcess = "{{ route('reservation.roomcheckOut') }}";
	const checkoutData = "{{ route('checkout.checkoutReservationPreview',':id')}}";
	const getDetailsWithPhone = "{{route('reservation.getDetailsWithPhone')}}";
	const addDataUsingPhone = "{{route('reservation.addDataUsingPhone')}}";
	const roomClosureData = "{{ route('room.getRoomclosuredata') }}";
    const addRoomClosure = "{{ route('backend.add_roomClosure') }}";
	const manageroomclose = "{{route('room.manageroomclose')}}";
	const reservatiionAdd = "{{ route('reservation.add_reservation') }}";
	const cancelReservation = "{{ route('reservation.cancelReservation') }}";
    const getPaymentDetail = "{{ route('reservation.getPaymentDetail') }}";
	const editReservationUpdate = "{{ route('reservation.editReservationUpdate') }}";
	const roomguestnoteData = "{{ route('reservation.roomguestnoteData') }}";
	const updateroomguestData = "{{ route('reservation.updateroomguestData') }}";
	const submitroomguestData = "{{ route('reservation.submitroomguestData') }}";
	const reservationPaymentSubmit = "{{ route('reservation.reservationPayment') }}";
	const reservatiionEditAdd = "{{ route('reservation.edit_add_reservation') }}";
	const companyVerifyGst = "{{ route('company.verifyGst') }}";
	const companyGstList = "{{ route('company.companyList') }}";
	const recordKotReservationPayment = "{{ route('record-reservation-payment.recordPayment')}}";
	const reservationExitGuest = "{{ route('reservation-guest-exit.reservationExitGuest')}}";
	const reservationTariffUpdate = "{{ route('reservation-tariff-update.reservationTariffUpdate')}}";
</script>
<script>
	$(document).ready(function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

        $('input[name="updateGSTBtn"]').on('change', function() {
            if ($(this).is(':checked')) {
                $('.gst-fetch-update-view').removeClass('d-none'); // or .fadeIn(), .slideDown()
                $('.last-company-detail').addClass('d-none');
            } else {
                $('.gst-fetch-update-view').addClass('d-none'); // or .fadeOut(), .slideUp()
                $('.last-company-detail').removeClass('d-none');
            }
        });
	});

    document.addEventListener("DOMContentLoaded", function () {

        const b2bDivEdit = document.getElementById("b2bCompanyEdit");
        const b2cDivEdit = document.getElementById("b2cCompanyEdit");

        const rIndividualEdit = document.getElementById("freeEdit");
        const rB2BEdit = document.getElementById("b2bEdit");
        const rB2CEdit = document.getElementById("b2cEdit");

        function updateBillingEdit() {
            if (rB2BEdit.checked) {
                
                b2bDivEdit.style.display = "block";
                b2cDivEdit.style.display = "none";
            } 
            else if (rB2CEdit.checked) {
                
                b2bDivEdit.style.display = "none";
                b2cDivEdit.style.display = "block";
            } 
            else {
                b2bDivEdit.style.display = "none";
                b2cDivEdit.style.display = "none";
            }
        }

        // Attach listeners
        rIndividualEdit.addEventListener("change", updateBillingEdit);
        rB2BEdit.addEventListener("change", updateBillingEdit);
        rB2CEdit.addEventListener("change", updateBillingEdit);

        // Initial state
        updateBillingEdit();
    });
</script>
<script src="{{asset('backend/assets/js/custom/custom_backend.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/reservation.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/reservation_comman.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/closer_room.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/reservation_layout.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/reservation_side_layout.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/reservation/add_reservation.js')}}"></script> 
<script src="{{asset('backend/assets/js/custom/reservation/edit_reservation.js')}}"></script> 
<script src="{{asset('backend/assets/js/dynamic-toggle-script.js')}}"></script>
@endsection