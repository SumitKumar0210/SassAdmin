@extends('backend.layouts.main')
@section('title','New Reservation')
@section('main-container')
@section('extra-css')
<style>
	.onhover-show-div {
	  top: 35px;
	}
</style>
@endsection
<link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/dynamic-toggle-style.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/toggle-style.css')}}">
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-12 p-0">
                    <h3>New Reservation</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="" id="reservation_form" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-lg-9 col-sm-9 col-9">
                                    <div class="d-flex align-items-center justify-content-start">
                                        <div><h5>Booking Type </h5></div>
                                        {{-- <div class="ms-3 d-flex align-items-center">
                                            <label class="me-2">Single</label>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="checkinSwitch">
                                            </div>
                                            <label class="ms-0 mt-1">Bulk</label>
                                        </div> --}}
                                    </div>
                                </div>
                                {{-- <div class="col-lg-3 col-sm-3 col-3">
                                    <button class="btn btn-primary add_res_btn_hide pull-right" type="submit">Reserve</button>
                                    <button class="btn btn-primary new_res_loader d-none pull-right" type="button"> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please Wait </button>
                                </div> --}}
                            </div>
                            <div class="row">
                                <input type="hidden" id="newresID">
                                <div class="col-lg-3 col-sm-12 col-12">
                                    <div class="checkinbox mb-1">
                                        <label class="form-label">Checkin <span class="text-danger">*</span></label>
                                        <label class="form-label pull-right text-success reservation_checkin_show_time reservation_checkin_confirmation_allow d-none"> --:-- </label>
                                        <div class="input-group">
                                            <span class="input-group-text text-muted"><i class="icofont icofont-ui-calendar"></i></span>
                                            <input class="form-control form-control-sm" id="checkin_resvn" name="checkin_resvn" type="date" value="" onchange="staycount_checkin()" style="background-color: #fff;" required> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-12 col-12">
                                    <div class="checkinbox mb-1">
                                        <label class="form-label">Checkout <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text text-muted"><i class="icofont icofont-ui-calendar"></i></span>
                                            <input class="form-control form-control-sm" id="checkout_resvn" name="checkout_resvn" type="date" value="" style="background-color: #fff;" onchange="staycount_checkout()" required> 
                                        </div>
                                        <div class="date_format_err"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-12 col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="mt-lg-4 mt-0 pt-2 ">
                                            <label>Length of stay: <strong><span class="reservation_duration"><span>1 Night</strong><span class="px-1">
                                                |</span>Booking status: <span class="text-success reservation_booking_status">New Reservation</span> </label>
                                        </div>
                                        <div class="add-extra-room text-end pt-2 add-more-room">
                                            <button class="btn btn-primary active px-2 addAnotherRoom" type="button" id="" onclick="addNewResFields()"><span  class="btn-icon"><i class="icon-plus me-1" style="font-size:10px"></i></span>Add Another Room</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 border-top border-bottom mb-2">
                                    <div class="row my-2">

                                        <div class="col-lg-4 col-sm-12">
                                            <label class="form-label" for="mobile_resvn">Search By Phone</label>
                                            <div class="input-group">
                                                <input class="form-control form-control-sm" type="number" id="search_mobile_resvn" placeholder="Phone" maxlength="10" autocomplete="off" pattern="[1-9]{1}[0-9]{9}" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); chkMobile(this.value)" style="height: 30px;">
                                                <button class="btn btn-primary chk-customer border" type="button" onclick="searchCustomer()" disabled style="height: 30px; line-height:1">Search</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-sm-12">
                                            <div class="form-group mb-1 mt-4">
                                                <label class="text-success new-user-reservation ms-2" style="vertical-align: bottom;"></label>    
                                            </div>
                                        </div> 
                                    </div>
                                    
                                </div>
                                <div class="col-md-12 border-top previous-checkin-detail mb-2"></div>
                                <div class="col-md-12" id="roomReserve">
                                    <div class="room-type-bar border-radius-4 d-flex flex-wrap my-1 px-2 py-1 justify-content-between bg-light"
                                        id="addReservation">
                                        <div class="mb-1 mb-lg-1">
                                            <label class="form-label" for="roomtype_resvn0">Room Type <span class="text-danger">*</span></label>
                                            <select class="form-select form-select-sm" id="roomtype_resvn0" name="roomtype_resvn[]" onchange="getroomoccupancy(this.value,0)" oninput="handleInput_roomtype_resvn()" required>
                                                <option value="">Select Type</option>
                                            </select>
                                            <div class="roomtype_resvn_class0"></div>
                                        </div>
                                        <div class="mb-1 mb-lg-1">
                                            <label class="form-label">Tariff <span class="text-danger">*</span></label>
                                            <select class="form-select form-select-sm" id="roomtariff_resvn0" name="roomtariff_resvn[]" onchange="getRoomTariff(this.value,0)" required>
                                                <option value="">Select Tariff</option>
                                            </select>
                                        </div>
                                        <div class="mb-1 mb-lg-1 reservation_checkin_confirmation_allow">
                                            <label class="form-label">Room No</label>
                                            <select class="form-select form-select-sm" id="roomno_resvn0" name="roomno_resvn[]" onchange="checkRoomNum()" disabled required>
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        <div class="mb-1 mb-lg-1">
                                            <label class="form-label">Adults <span class="text-danger">*</span></label>
                                            <select class="form-select form-select-sm" id="adults_resvn0" name="adults_resvn[]" disabled required>
                                                <option value="">Select</option>
                                            </select>
                                            <div class="limit_excced0 position-absolute mt-1"></div>
                                        </div>
                                        <div class="mb-1 mb-lg-1">
                                            <label class="form-label">Children</label>
                                            <select class="form-select form-select-sm" id="childrens_resvn0" name="childrens_resvn[]" disabled>
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                        <div class="mb-1 mb-lg-1">
                                            <label class="form-label">Infants</label>
                                            <select class="form-select form-select-sm" id="infants_resvn0" name="infants_resvn[]" disabled>
                                                <option value=""> Select</option>
                                            </select>
                                        </div>
                                        <div class="mb-1 mb-lg-1">
                                            <label class="form-label">Amount <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <span class="input-group-text text-muted ">₹</span>
                                                <input class="form-control form-control-sm w-120" type="text" id="amount_resvn0" name="amount_resvn[]" value="0" oninput="allCalculation()" min="1">
                                            </div>
                                        </div>
                                        <div class="mb-1 mb-lg-1">
                                            <label class="form-label">Extra Pax</label>
                                            <div class="input-group">
                                                <input class="form-control form-control-sm w-120" type="number" id="extraperson_resvn0" name="extraperson_resvn[]" value="0" oninput="updateExtraPerson(0)" required>
                                            </div>
                                            <div class="extraperson_resvn_class0 text-danger"></div>
                                        </div>
                                        <div class="mb-1 mb-lg-1">
                                            <label class="form-label">Extra Pax Amount</label>
                                            <div class="input-group">
                                                <input class="form-control form-control-sm w-120" type="number" id="extrapersonAmount_resvn0" name="extrapersonAmount_resvn[]" value="" style="background-image:none;" oninput="allCalculation()">
                                            </div>
                                        </div>
                                        <div class="mb-1 mb-lg-1 formcloseclass">
                                            <div class="d-flex align-items-center justify-content-center remove " style="width:20px;height:20px;">
                                                <i class="icon-close bg-danger p-1 rounded-circle formclosebtn" style="font-size:10px;margin-top: 25px;"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="addNewResField"></div>
                                
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <div class="border-top w-100">
                                        <div class="d-flex align-items-center justify-content-start">
                                            <h4 class="pt-3 mb-3 text-uppercase txt-secondary">Primary Contact</h4>
                                            {{-- <div onclick="resetPrimaryForm()"><i class="ri-loop-right-line reset-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Contact Fields"></i></div> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-sm-12 col-12 mb-2">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group mb-1">
                                                    <label class="form-label" for="mobile_resvn">Phone <span class="text-danger">*</span></label>
                                                    <input class="form-control form-control-sm" type="number" id="mobile_resvn" name="mobile_resvn" placeholder="Phone" maxlength="10" autocomplete="off" required pattern="[1-9]{1}[0-9]{9}" onkeyup="setBookingBy()" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                                                    <div class="mobile_resvn_class"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group mb-1">
                                                    <label class="form-label" for="name_resvn">First Name <span class="text-danger">*</span></label>
                                                    <input class="form-control form-control-sm" type="text" id="first_name_resvn" name="first_name_resvn" placeholder="First Name" oninput="handleInput_name_resvn()" onkeyup="setBookingBy()" style="text-transform: capitalize;" autofocus required>
                                                    <div class="first_name_resvn_class"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group mb-1">
                                                    <label class="form-label" for="name_resvn">Last Name</label>
                                                    <input class="form-control form-control-sm" type="text" id="last_name_resvn" name="last_name_resvn" placeholder="Last Name">
                                                    <div class="last_name_resvn_class"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-label">Gender</label>
                                                    <select class="form-select form-select-sm" id="gender_resvn" name="gender_resvn">
                                                        <option value="">Select</option>
                                                        <option value="Male">Male </option>
                                                        <option value="Female">Female </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group mb-1">
                                                    <label class="form-label" for="email_resvn">Email</label>
                                                    <input class="form-control form-control-sm" type="email" id="email_resvn" name="email_resvn" placeholder="Email" onkeyup="setBookingBy()">
                                                    <div class="email_resvn_class"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-label">Guest Type</label>
                                                    <select class="form-select form-select-sm" id="guest_type_resvn" name="guest_type_resvn">
                                                        <option value="Normal">Normal </option>
                                                        <option value="VIP">VIP </option>
                                                        <option value="Corporate">Corporate </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group mb-1">
                                                    <label class="form-label">Allergic To</label>
                                                    <input class="form-control form-control-sm" type="text" id="allergic_to_resvn" name="allergic_to_resvn" placeholder="Allergic">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group mb-1">
                                                    <label class="form-label">Address</label>
                                                    <input class="form-control form-control-sm" type="text" id="address_resvn" name="address_resvn" placeholder="Address">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group mb-1">
                                                    <label class="form-label">City</label>
                                                    <input class="form-control form-control-sm" type="text" id="city_resvn" name="city_resvn" placeholder="City">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-label">State</label>
                                                    <input class="form-control form-control-sm" type="text" id="state_resvn" name="state_resvn" placeholder="State">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-label">PIN / ZIP</label>
                                                    <input class="form-control form-control-sm" type="number" id="pin_resvn" name="pin_resvn" placeholder="PIN / ZIP" maxlength="6" oninput="this.value=this.value.slice(0,6)">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-label">Country</label>
                                                    <input class="form-control form-control-sm" type="text" id="country_resvn" name="country_resvn" placeholder="Country" value="India">
                                                </div>
                                            </div>
                                            {{-- <div class="col-lg-4 col-sm-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-label">Coming From</label>
                                                    <input class="form-control form-control-sm" type="text" id="coming_from_resvn" name="coming_from_resvn" placeholder="Coming From" pattern="[A-Za-z]*" onkeyup="checkString(`coming_from_resvn`,this.value)">
                                                    <div class="coming_from_resvn_class text-danger"></div>
                                                </div>
                                            </div> --}}
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-label">Going To</label>
                                                    <input class="form-control form-control-sm" type="text" id="going_to_resvn" name="going_to_resvn" placeholder="Going To" pattern="[A-Za-z]*"  onkeyup="checkString(`going_to_resvn`,this.value)">
                                                    <div class="going_to_resvn_class text-danger"></div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-label">Purpose Of Visit</label>
                                                    <input class="form-control form-control-sm" type="text" id="purpose_of_visit_resvn" name="purpose_of_visit_resvn" placeholder="Purpose Of Visit">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-label">Arrival Time</label>
                                                    <select class="form-select form-select-sm" id="arrivaltime_resvn" name="arrivaltime_resvn">
                                                        <option value=""> Select Arrival Time</option>
                                                        <option value="Morning"> Morning</option>
                                                        <option value="Afternoon"> Afternoon</option>
                                                        <option value="Evening"> Evening</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6">
                                                <div class="form-group mb-1">
                                                    <label class="form-label">Document type</label>
                                                    <select class="form-select form-select-sm" id="documenttype_resvn" name="documenttype_resvn" onchange="docTypeValue(this.value)">
                                                        <option value="">Document type</option>
                                                        <option value="Aadhar Card">Aadhar Card </option>
                                                        <option value="Pan Card">Pan Card</option>
                                                        <option value="Driving Licence">Driving Licence</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12" id="otherdetail_resvncc" style="display:none">
                                                <div class="form-group mb-1">
                                                    <label class="form-label">Other Document Type</label>
                                                    <input class="form-control form-control-sm" type="text" id="otherdetail_resvn" name="otherdetail_resvn" placeholder="Other Details">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-6" >
                                                <div class="form-group mb-1">
                                                    <label class="form-label">ID Number</label>
                                                    <input class="form-control form-control-sm" type="text" placeholder="Document Number" maxlength="15" id="idnumber_resvn" name="idnumber_resvn" oninput="this.value=this.value.slice(0,15)">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-sm-12">
                                                <div class="form-group mb-1">
                                                    <label class="form-label" for="photo_resvn">Photo</label>
                                                    <input class="form-control form-control-sm" type="file" id="photo_resvn" name="photo_resvn"/>
                                                    <div class="photo_resvn_class"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-12">
                                            <div class="mb-1">
                                                <label class="form-label" for="comments_resvn">Guest Comments</label>
                                                <textarea class="form-control" id="comments_resvn" name="comments_resvn" rows="1" ></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 col-sm-12 col-12 d-none">
                                            <div class="mb-1">
                                                <label class="form-label" for="note_resvn">Notes</label>
                                                <textarea class="form-control" id="note_resvn" name="note_resvn" rows="1" ></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12 mb-1 d-none">
                                            <input class="form-control form-control-sm" id="gstLegalName" name="gstLegalName" type="text" placeholder="gstLegalName" >
                                            <input class="form-control form-control-sm" id="gstAddrBnm" name="gstAddrBnm" type="text" placeholder="gstAddrBnm">
                                            <input class="form-control form-control-sm" id="gstAddrBno" name="gstAddrBno" type="text" placeholder="gstAddrBno">
                                            <input class="form-control form-control-sm" id="gstAddrFlno" name="gstAddrFlno" type="text" placeholder="gstAddrFlno">
                                            <input class="form-control form-control-sm" id="gstAddrSt" name="gstAddrSt" type="text" placeholder="gstAddrSt">
                                            <input class="form-control form-control-sm" id="gstAddrLoc" name="gstAddrLoc" type="text" placeholder="gstAddrLoc">
                                            <input class="form-control form-control-sm" id="gstTxpType" name="gstTxpType" type="text" placeholder="gstTxpType">
                                            <input class="form-control form-control-sm" id="gstStatus" name="gstStatus" type="text" placeholder="gstStatus">
                                            <input class="form-control form-control-sm" id="gstBlkStatus" name="gstBlkStatus" type="text" placeholder="gstBlkStatus">
                                            <input class="form-control form-control-sm" id="gstDtReg" name="gstDtReg" type="text" placeholder="gstDtReg" >
                                            <input class="form-control form-control-sm" id="gstDtDReg" name="gstDtDReg" type="text" placeholder="gstDtDReg">
                                            <input class="form-control form-control-sm" id="gstTradeName" name="gstTradeName" type="text" placeholder="gstTradeName">
                                            <input class="form-control form-control-sm" id="gstStateCode" name="gstStateCode" type="text" placeholder="gstStateCode">
                                            <input class="form-control form-control-sm" id="gstAddrPncd" name="gstAddrPncd" type="text" placeholder="gstAddrPncd">
                                            <input class="form-control form-control-sm" id="gstAddr" name="gstAddr" type="text" placeholder="gstAddr">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-sm-12 col-12">
                                    <div class="reservation-summary px-3 py-2 bg-light">
                                        <h4 class="text-uppercase my-2">Booking Summary</h4>
                                        <div class="my-2">
                                            <label class="d-flex justify-content-between ">
                                                <div><span>Room Total</span></div>
                                                <div><span class="me-1">₹</span><span class="room_total_amount">0</span> <span class="no_of_nights d-none">1</span><span class="no_of_stay">(1 Night)</span></div>
                                            </label>
                                            <label class="d-flex justify-content-between">
                                                <div><span>Extra Person Total</span></div>
                                                <div><span class="extra_total_person">0</span></div>
                                            </label>
                                            <label class="d-flex justify-content-between">
                                                <div><span>Extra Total</span></div>
                                                <div><span class="me-1">₹</span><span class="extra_total_amount">0</span></div>
                                            </label>
                                            <label class="d-flex justify-content-between">
                                                <div><span>Total</span></div>
                                                <div><span class="me-1">₹</span><span class="total_final_res_amount">0</span></div>
                                            </label>
                                            <label class="d-flex justify-content-between">
                                                <div><span>Discount (%)</span></div>
                                                <div><input class="form-control form-control-sm  total_discount_percentage" type="number" placeholder="Discount (%)" step="0.01" onkeyup="calculateReservation()" maxlength="2" value="0"></div>
                                            </label>
                                            <label class="d-flex justify-content-between">
                                                <div><span>Subtotal</span></div>
                                                <div><input class="form-control form-control-sm total_subtotal" type="text" value="0" required></div>
                                            </label>
                                            <label class="d-flex justify-content-between">
                                                <div><span>Advance Amount</span></div>
                                                <div><input class="form-control form-control-sm total_advance_amount" type="number" placeholder="Advance Amount" onkeyup="calculateReservation()" value="0"></div>
                                            </label>
                                            <label class="d-flex justify-content-between">
                                                <div><span>Mode</span></div>
                                                <div>
                                                    <select class="form-select form-select-sm" id="reservation_mode" name="reservation_mode" onchange="reservationAdvMode(this.value)" style="width:153px;">
                                                        <option value="">Select Mode</option>
                                                        @foreach ($payments as $pay)
                                                            <option value="{{$pay->id}} ">{{$pay->name}} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </label>
                                            <label class="d-flex justify-content-between d-none reservation-Adv-Mode">
                                                <div><span>Reference Code</span></div>
                                                <div><input class="form-control form-control-sm" name="reservation_reference_code" type="text" placeholder="Reference Code"></div>
                                            </label>
                                            <div class="my-2">
                                                <label class="d-flex justify-content-between border-bottom pb-2">
                                                    <div><span>Total Received</span></div>
                                                    <div><span class="me-1">₹</span><span class="total_received"> 0</span></div>
                                                </label>
                                            </div>
                                            <div class="my-2">
                                                <h4 class="d-flex justify-content-between text-danger">
                                                    <div><span>Total Outstanding</span></div>
                                                    <div><span class="me-1">₹</span><span class="total_outstanding"> 0</span></div>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-12 py-2 last-company-detail bg-light">
                                    <h5 class="my-2">Company Detail <button class="btn btn-primary ms-2" onclick="addNewCompany()" type="button"><i class="icon-plus me-1" style="font-size:10px"></i> Add New</button></h5>
                                    <div class="row">
                                        <div class="col-4">
                                            <label class="form-label">Company Name</label>
                                            <input class="form-control form-control-sm" id="last_company_id" name="last_company_id" type="hidden" placeholder="Search Company" value="" readonly>
                                            <input class="form-control form-control-sm" id="last_company" type="text" placeholder="Search Company" onkeyup="getCompanyList()">
                                            <div id="itemCompanyList"></div>
                                            <div class="company_name_error_class text-danger"></div>
                                        </div>
                                        <div class="col-3">
                                            <label class="form-label">GstIn</label>
                                            <input class="form-control form-control-sm" id="last_GST" type="text" placeholder="GST" value="" readonly>
                                        </div>
                                        <div class="col-5">
                                            <label class="form-label">Address</label>
                                            <input class="form-control form-control-sm" id="last_addr" type="text" placeholder="Address" value="" readonly>
                                        </div>
                                    </div>
                                </div>
                               
                                <div class="col-12 py-1 mb-4 add-new-company d-none">

                                    <h5 class="my-2">Billing Type</h5>
                                    <div class="switch-toggle-type">
                                        <input class="switch-toggle-type-checkbox" type="checkbox" id="pricing-plan-switch" />
                                        <label class="switch-toggle-type-label mb-0" for="pricing-plan-switch">
                                            <span>B2B</span>
                                            <span>B2C</span>
                                        </label>
                                    </div>
                                    {{-- <div class="control ms-4 mt-3">
                                        <div class="control__track">
                                            <div class="indicator"></div>
                                                <label for="free">Individual</label>
                                                <input class="sr-only" type="radio" name="billtype" id="free" value="individual" checked />
                                            <div class="premium">
                                            <div class="indicator"></div>
                                                <label for="b2b"><span>B2B</span><span class="sr-only">Company B2B</span></label>
                                                <input class="sr-only" type="radio" name="billtype" id="b2b" value="b2b"/>
                                                <label for="b2c"><span>B2C</span><span class="sr-only">Company B2C</span></label>
                                                <input class="sr-only" type="radio" name="billtype" id="b2c" value="b2c"/>
                                            </div>
                                        </div>
                                    </div> --}}
                                    {{-- B2B Company --}}
                                    <div id="b2bCompany" class="b2b-company">
                                        <label class="form-label mt-4">Gst Number<span class="text-danger">*</span></label>
                                        <div class="d-flex flex-wrap gap-3 mb-1">
                                            <div class="input-group w-25">
                                                <input class="form-control form-control-sm" type="text" placeholder="Enter GSTIN" id="companygst_resvn" name="companygst_resvn" maxlength="15" onkeyup="checkGstCompany(this.value)" >
                                                <button class="btn btn-primary gst-fetch-detail" type="button" onclick="checkGstRequest()" disabled>Fetch</button>
                                            </div>
                                            <div class="gst-address d-none"></div>
                                        </div>
                                    </div>
                                    {{-- B2C Company --}}
                                    <div id="b2cCompany" class="b2b-company my-4">
                                        <div class="row">
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group ">
                                                    <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                                    <input class="form-control form-control-sm" type="text" id="companyname_resvn" name="companyname_resvn" placeholder="Company Name">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group ">
                                                    <label class="form-label">Company Address <span class="text-danger">*</span></label>
                                                    <input class="form-control form-control-sm" type="text" id="companyaddress_resvn" name="companyaddress_resvn" placeholder="Company Address">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group ">
                                                    <label class="form-label"> Pincode <span class="text-danger">*</span></label>
                                                    <input class="form-control form-control-sm" type="number" id="companypincode_resvn" name="companypincode_resvn" placeholder="Company Pincode" maxlength="6" pattern="[0-9]*">
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group ">
                                                    <label class="form-label" for="companystate_resvn">State <span class="text-danger">*</span></label>
                                                    <select class="form-control form-control-sm" id="companystate_resvn" name="companystate_resvn" style="background-image: none;">
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
                                
                                <div class="col-12 mb-2 py-2 bg-light">
                                    <div class="d-flex">
                                        <div>
                                            <h5 class="my-2">Booking Made By  <span class="text-danger">*</span></h5>
                                        </div>
                                        <div class="form-check mx-3 my-2">
                                            <input class="form-check-input" id="reservation_book_by1" type="radio" name="bookingBy" value="Company" required>
                                            <label class="form-check-label" for="reservation_book_by1">Company</label>
                                        </div>
                                        <div class="form-check mx-3 my-2">
                                            <input class="form-check-input" id="reservation_book_by2" type="radio" name="bookingBy" value="Agent" required>
                                            <label class="form-check-label" for="reservation_book_by2">Agent</label>
                                        </div>
                                        <div class="form-check mx-3 my-2">
                                            <input class="form-check-input" id="reservation_book_by3" type="radio" name="bookingBy" value="Self" required checked>
                                            <label class="form-check-label" for="reservation_book_by3">Self</label>
                                        </div>
                                    </div>
                                    <div class="row booking_madeby_detail d-none">
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group ">
                                                <label class="form-label"> Name <span class="text-danger">*</span></label>
                                                <input class="form-control form-control-sm" type="text" id="reservation_booked_by_name" name="reservation_booked_by_name" placeholder=" Name" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group ">
                                                <label class="form-label">Mobile <span class="text-danger">*</span></label>
                                                <input class="form-control form-control-sm" type="text" id="reservation_booked_by_mobile" name="reservation_booked_by_mobile" placeholder="Mobile" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12">
                                            <div class="form-group ">
                                                <label class="form-label"> Email </label>
                                                <input class="form-control form-control-sm" type="text" id="reservation_booked_by_email" name="reservation_booked_by_email" placeholder=" Email">
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group ">
                                                <label class="form-label"> Remark </label>
                                                <textarea class="form-control form-control-sm" id="reservation_booked_by_remark" name="reservation_booked_by_remark" placeholder="Remark"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-lg-12 col-sm-12 col-12 mt-3">
                                    <div>
                                        <button class="btn btn-primary add_res_btn_hide pull-right ms-2" style="margin: 0 auto;" type="submit" id="reserveBtn">Reserve</button>
                                        <button class="btn btn-warning add_res_btn_hide pull-right" style="margin: 0 auto;" type="submit" id="checkinBtn">Check-in</button>
                                        <button class="btn btn-primary new_res_loader d-none pull-right" type="button"> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please Wait </button>
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
	const reservationCreate = "{{ route('reservation.add_reservation') }}";
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
</script>
<script>
	$(document).ready(function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
        $('#mobile_resvn').focus();
	});

    function chkMobile(x){
		if(x.length == 10){
            $('.chk-customer').prop('disabled',false);
        }else{
            $('.chk-customer').prop('disabled',true);
        }
	}

    $(document).ready(function () {

        $('#pricing-plan-switch').on('change', function () {

            if ($(this).is(':checked')) {
                // B2C selected
                $('#b2bCompany').hide();
                $('#b2cCompany').show();
            } else {
                // B2B selected
                $('#b2cCompany').hide();
                $('#b2bCompany').show();
            }

        });

    });
</script>
<script src="{{asset('backend/assets/js/custom/closer_room.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/reservation.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/reservation_comman.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/custom_backend.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/reservation/add_reservation.js')}}"></script>
<script src="{{asset('backend/assets/js/dynamic-toggle-script.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/reservation_layout.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/reservation_side_layout.js')}}"></script>
@endsection