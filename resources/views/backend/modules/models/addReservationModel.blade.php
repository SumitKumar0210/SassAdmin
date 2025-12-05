<div class="modal fade" id="reservation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <form action="" id="reservation_form" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">New Reservation <div class="form-check"><input class="form-check-input room_checked-element" type="checkbox" id="new_reservation_checkin_confirmation"> Check-in </div></h5>
                    <button class="btn btn-primary add_res_btn" type="submit" disabled>Reserve</button>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="newresID">
                        <div class="col-lg-3 col-sm-12 col-12">
                            <div class="checkinbox mb-3">
                                <label class="form-label">Checkin <span class="text-danger">*</span></label>
                                <label class="form-label pull-right text-success reservation_checkin_show_time reservation_checkin_confirmation_allow d-none"> --:-- </label>
                                <div class="input-group">
                                    <input class="form-control form-control-sm" id="checkin_resvn" name="checkin_resvn" type="date" value="" onchange="staycount_checkin()"> <span class="input-group-text text-muted"><i class="icofont icofont-ui-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-12 col-12">
                            <div class="checkinbox mb-3">
                                <label class="form-label">Checkout <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input class="form-control form-control-sm" id="checkout_resvn" name="checkout_resvn" type="date" value="" onchange="staycount_checkout()"> <span class="input-group-text text-muted"><i class="icofont icofont-ui-calendar"></i></span>
                                </div>
                                <div class="date_format_err"></div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-12 col-12">
                            <div class="mt-lg-4 mt-0 pt-3">
                                <label>Length of stay: <strong><span class="reservation_duration"><span>1 Night</strong><span class="px-1">
                                    |</span>Booking status: <span class="text-success reservation_booking_status">New Reservation</span> </label>
                            </div>
                        </div>
                        <div class="col-md-12" id="roomReserve">
                            <div class="room-type-bar border-radius-4 d-flex flex-wrap my-2 px-3 py-4 justify-content-between bg-light"
                                id="addReservation">
                                <div class="mb-3 mb-lg-1">
                                    <label class="form-label" for="roomtype_resvn0">Room Type <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm" id="roomtype_resvn0" name="roomtype_resvn[]" onchange="getroomoccupancy(this.value,0)" oninput="handleInput_roomtype_resvn()">
                                        <option value="">Select Type</option>
                                    </select>
                                    <div class="roomtype_resvn_class0"></div>
                                </div>
                                <div class="mb-3 mb-lg-1">
                                    <label class="form-label">Tariff <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm" id="roomtariff_resvn0" name="roomtariff_resvn[]" onchange="getRoomTariff(this.value,0)">
                                        <option value="">Select Tariff</option>
                                    </select>
                                </div>
                                <div class="mb-3 mb-lg-1 reservation_checkin_confirmation_allow d-none">
                                    <label class="form-label">Room No</label>
                                    <select class="form-select form-select-sm" id="roomno_resvn0" name="roomno_resvn[]" onchange="checkRoomNum()" disabled>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="mb-3 mb-lg-1">
                                    <label class="form-label">Adults <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm" id="adults_resvn0" name="adults_resvn[]" disabled>
                                        <option value="">Select</option>
                                    </select>
                                    <div class="limit_excced0 position-absolute mt-1"></div>
                                </div>
                                <div class="mb-3 mb-lg-1">
                                    <label class="form-label">Children</label>
                                    <select class="form-select form-select-sm" id="childrens_resvn0" name="childrens_resvn[]" disabled>
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <div class="mb-3 mb-lg-1">
                                    <label class="form-label">Infants</label>
                                    <select class="form-select form-select-sm" id="infants_resvn0" name="infants_resvn[]" disabled>
                                        <option value=""> Select</option>
                                    </select>
                                </div>
                                <div class="mb-3 mb-lg-1">
                                    <label class="form-label">Amount <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text text-muted ">₹</span>
                                        <input class="form-control form-control-sm w-120" type="text" id="amount_resvn0" name="amount_resvn[]" value="0" oninput="allCalculation()">
                                    </div>
                                </div>
                                <div class="mb-3 mb-lg-1">
                                    <label class="form-label">Extra Pax</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm w-120" type="number" id="extraperson_resvn0" name="extraperson_resvn[]" value="0" oninput="updateExtraPerson(0)" required>
                                    </div>
                                    <div class="extraperson_resvn_class0 text-danger"></div>
                                </div>
                                <div class="mb-3 mb-lg-1">
                                    <label class="form-label">Extra Pax Amount</label>
                                    <div class="input-group">
                                        <input class="form-control form-control-sm w-120" type="number" id="extrapersonAmount_resvn0" name="extrapersonAmount_resvn[]" value="" style="background-image:none;" oninput="allCalculation()">
                                    </div>
                                </div>
                                <div class="mb-3 mb-lg-1 formcloseclass">
                                    <div class="d-flex align-items-center justify-content-center remove " style="width:20px;height:20px;">
                                        <i class="icon-close bg-danger p-1 rounded-circle formclosebtn" style="font-size:10px;margin-top: 25px;"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="addNewResField"></div>
                            <div class="add-extra-room text-end pt-2">
                                <button class="btn btn-primary active px-2 addAnotherRoom" type="button" id="" onclick="addNewResFields()"><span  class="btn-icon"><i class="icon-plus me-1" style="font-size:10px"></i></span>Add Another Room</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-lg-12 col-sm-12 col-12">
                            <div class="border-top w-100">
                                <div class="d-flex align-items-center justify-content-start">
                                    <h4 class="pt-3 mb-3 text-uppercase txt-secondary">Primary Contact</h4>&nbsp;&nbsp;
                                    <div onclick="resetPrimaryForm()"><i class="ri-loop-right-line reset-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Reset Contact Fields"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-sm-12 col-12">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="mobile_resvn">Phone <span class="text-danger">*</span></label>
                                            <input class="form-control form-control-sm" type="number" id="mobile_resvn" name="mobile_resvn" placeholder="Phone" maxlength="10" oninput="handleInput_mobile_resvn()">
                                            <div id="itemCodeList"></div>
                                            <div class="mobile_resvn_class"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="name_resvn">First Name <span class="text-danger">*</span></label>
                                            <input class="form-control form-control-sm" type="text" id="first_name_resvn" name="first_name_resvn" placeholder="First Name" oninput="handleInput_name_resvn()">
                                            <div class="first_name_resvn_class"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="name_resvn">Last Name</label>
                                            <input class="form-control form-control-sm" type="text" id="last_name_resvn" name="last_name_resvn" placeholder="Last Name">
                                            <div class="last_name_resvn_class"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Gender</label>
                                            <select class="form-select form-select-sm" id="gender_resvn" name="gender_resvn">
                                                <option value="">Select</option>
                                                <option value="Male">Male </option>
                                                <option value="Female">Female </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="email_resvn">Email</label>
                                            <input class="form-control form-control-sm" type="email" id="email_resvn" name="email_resvn" placeholder="Email">
                                            <div class="email_resvn_class"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Guest Type</label>
                                            <select class="form-select form-select-sm" id="guest_type_resvn" name="guest_type_resvn">
                                                <option value="Normal">Normal </option>
                                                <option value="VIP">VIP </option>
                                                <option value="Corporate">Corporate </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Allergic To</label>
                                            <input class="form-control form-control-sm" type="text" id="allergic_to_resvn" name="allergic_to_resvn" placeholder="Allergic">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Address</label>
                                            <input class="form-control form-control-sm" type="text" id="address_resvn" name="address_resvn" placeholder="Address">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label">City</label>
                                            <input class="form-control form-control-sm" type="text" id="city_resvn" name="city_resvn" placeholder="City">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">State</label>
                                            <input class="form-control form-control-sm" type="text" id="state_resvn" name="state_resvn" placeholder="State">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">PIN / ZIP</label>
                                            <input class="form-control form-control-sm" type="number" id="pin_resvn" name="pin_resvn" placeholder="PIN / ZIP" maxlength="6" oninput="this.value=this.value.slice(0,6)">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Country</label>
                                            <input class="form-control form-control-sm" type="text" id="country_resvn" name="country_resvn" placeholder="Country" value="India">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Coming From</label>
                                            <input class="form-control form-control-sm" type="text" id="coming_from_resvn" name="coming_from_resvn" placeholder="Coming From" pattern="[A-Za-z]*" onkeyup="checkString(`coming_from_resvn`,this.value)">
                                            <div class="coming_from_resvn_class text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Going To</label>
                                            <input class="form-control form-control-sm" type="text" id="going_to_resvn" name="going_to_resvn" placeholder="Going To" pattern="[A-Za-z]*"  onkeyup="checkString(`going_to_resvn`,this.value)">
                                            <div class="going_to_resvn_class text-danger"></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label">Purpose Of Visit</label>
                                            <input class="form-control form-control-sm" type="text" id="purpose_of_visit_resvn" name="purpose_of_visit_resvn" placeholder="Purpose Of Visit">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6">
                                        <div class="form-group mb-3">
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
                                        <div class="form-group mb-3">
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
                                        <div class="form-group mb-3">
                                            <label class="form-label">Other Document Type</label>
                                            <input class="form-control form-control-sm" type="text" id="otherdetail_resvn" name="otherdetail_resvn" placeholder="Other Details">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-6" >
                                        <div class="form-group mb-3">
                                            <label class="form-label">ID Number</label>
                                            <input class="form-control form-control-sm" type="text" placeholder="Document Number" maxlength="15" id="idnumber_resvn" name="idnumber_resvn" oninput="this.value=this.value.slice(0,15)">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-sm-12">
                                        <div class="form-group mb-3">
                                            <label class="form-label" for="photo_resvn">Photo</label>
                                            <input class="form-control form-control-sm" type="file" id="photo_resvn" name="photo_resvn"/>
                                            <div class="photo_resvn_class"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="comments_resvn">Guest Comments</label>
                                        <textarea class="form-control" id="comments_resvn" name="comments_resvn" rows="1" ></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12 col-12 d-none">
                                    <div class="mb-3">
                                        <label class="form-label" for="note_resvn">Notes</label>
                                        <textarea class="form-control" id="note_resvn" name="note_resvn" rows="1" ></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3 d-none">
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
                                        <div><input class="form-control form-control-sm  total_discount_percentage" type="number" placeholder="Discount (%)" step="0.01" onkeyup="calculateReservation()" maxlength="2"></div>
                                    </label>
                                    <label class="d-flex justify-content-between">
                                        <div><span>Subtotal</span></div>
                                        <div><input class="form-control form-control-sm total_subtotal" type="text"></div>
                                    </label>
                                    <label class="d-flex justify-content-between">
                                        <div><span>Advance Amount</span></div>
                                        <div><input class="form-control form-control-sm total_advance_amount" type="number" placeholder="Advance Amount" onkeyup="calculateReservation()"></div>
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
                        <hr>
                        <div class="col-12 py-2">
                            <h5 class="my-2">Billing Type</h5>
                            <div class="control ms-4">
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
                            </div>
                            {{-- B2B Company --}}
                            <div id="b2bCompany" class="b2b-company">
                                <div class="d-flex flex-wrap gap-3 my-4">
                                    <div class="form-group ">
                                        {{-- <label class="form-label">GSTIN</label> --}}
                                        <input class="form-control form-control-sm" type="text" placeholder="Enter GSTIN" id="companygst_resvn" name="companygst_resvn" maxlength="15">
                                    </div>
                                    <button class="btn btn-primary" type="button" onclick="checkGstRequest()">Fetch</button>
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

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary add_res_btn" type="submit" disabled>Reserve</button>
                    <button class="btn btn-primary new_res_loader d-none" type="button"> <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please Wait </button>
                </div>
            </div>
        </form>
    </div>
</div>