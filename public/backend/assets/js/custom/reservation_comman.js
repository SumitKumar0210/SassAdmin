let newRoomAdd = [];

function addNewResFields(type='') {
    let checkAmount = true;
    let amount = $("input[name='amount_resvn"+type+"[]']").map(function () {return $(this).val();}).get();
    $.each(amount, function(key,amountValue){
        if(parseInt(amountValue) <= 0){
            checkAmount = false;
        }
    });

    if(checkAmount){
        let randomNum = Math.random() * 100000;
        let randNum = parseInt(randomNum);
        $("#newresID").val(randNum); // append rand number to hidden id for new room add
        let newResRows = "";
        let calculateValue = 0;
        if(type != ''){
            calculateValue = 1;
        }
        newResRows +=`<div class="${randNum}">
                        <div class="room-type-bar border-radius-4 d-flex flex-wrap my-2 px-3 py-4 justify-content-between bg-light" id="addReservation">
                            <div class="mb-3 mb-lg-1">
                                <label class="form-label" for="roomtype_resvn${randNum}">Room Type</label>
                                <select class="form-select form-select-sm" id="roomtype_resvn${randNum}" name="roomtype_resvn${type}[]" onchange="getroomoccupancy(document.getElementById('roomtype_resvn${randNum}').value,${randNum})" oninput="validateField('#roomtype_resvn${randNum}','select','.roomtype_resvn_class${randNum}')">
                                    <option value="">Select </option>`;
                                    availableRoomDetail.forEach(function (r_category) {
                                        newResRows += `<option value="${r_category["id"]}">${r_category["name"]}</option>`;
                                    });
                                    newResRows += `</select>
                                </select>
                                <div class="roomtype_resvn_class${randNum}"></div>
                            </div>
                            <div class="mb-3 mb-lg-1">
                                <label class="form-label">Tariff</label>
                                <select class="form-select form-select-sm" id="roomtariff_resvn${randNum}" name="roomtariff_resvn${type}[]" onchange="getRoomTariff(this.value,${randNum},${calculateValue})">
                                    <option value="">Select</option>`;
                                    tariff_data.forEach(function (r_category) {
                                        newResRows += `<option value="${r_category["id"]}">${r_category["tariff_type"]}</option>`;
                                    });
                                    newResRows += `
                                </select>
                            </div>
                            <div class="mb-3 mb-lg-1 reservation_checkin_confirmation_allow">
                                <label class="form-label">Room No</label>
                                <select class="form-select form-select-sm" id="roomno_resvn${randNum}" name="roomno_resvn${type}[]" onchange="checkRoomNum()" disabled>
                                    <option value="NA">Select</option>
                                </select>
                            </div>
                            <div class="mb-3 mb-lg-1">
                                <label class="form-label">Adults</label>
                                <select class="form-select form-select-sm" id="adults_resvn${randNum}" name="adults_resvn${type}[]" disabled>
                                    <option value="">Select</option>
                                </select>
                                <div class="limit_excced${randNum} position-absolute mt-1"></div>
                            </div>
                            <div class="mb-3 mb-lg-1">
                                <label class="form-label">Children</label>
                                <select class="form-select form-select-sm" id="childrens_resvn${randNum}" name="childrens_resvn${type}[]" disabled>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="mb-3 mb-lg-1">
                                <label class="form-label">Infants</label>
                                <select class="form-select form-select-sm" id="infants_resvn${randNum}" name="infants_resvn${type}[]" disabled>
                                    <option value=""> Select</option>
                                </select>
                            </div>
                            <div class="mb-3 mb-lg-1">
                                <label class="form-label">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text text-muted ">₹</span>
                                    <input class="form-control form-control-sm w-120" type="text" id="amount_resvn${randNum}" name="amount_resvn${type}[]" value="0" readonly>
                                </div>
                            </div>
                            <div class="mb-3 mb-lg-1">
                                <label class="form-label">Extra Pax</label>
                                <div class="input-group">
                                    <input class="form-control form-control-sm w-120" type="number" id="extraperson_resvn${randNum}" name="extraperson_resvn${type}[]" value="0" oninput="updateExtraPerson(${randNum},${calculateValue})">
                                </div>
                                <div class="extraperson_resvn_class${randNum} text-danger"></div>
                            </div>
                            <div class="mb-3 mb-lg-1">
                                <label class="form-label">Extra Pax Amount</label>
                                <div class="input-group">
                                    <input class="form-control form-control-sm w-120" type="number" id="extrapersonAmount_resvn${randNum}" name="extrapersonAmount_resvn${type}[]" value="" style="background-image:none;" oninput="allCalculation()">
                                </div>
                            </div>
                            <div class="mb-3 mb-lg-1">
                                <div class="d-flex align-items-center justify-content-center " style="width:20px;height:20px;" onclick="removeRoomRow(${randNum},${calculateValue})">
                                    <i class="icon-close bg-danger p-1 rounded-circle removeRoomBtn" style="font-size: 7px;margin-top: 50px;"></i>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    newRoomAdd.push(parseInt(randNum));
                    if(type == ''){
                        $(".addNewResField").append(newResRows);
                    }else{
                        $(".reservationNewRoomAdd").append(newResRows);
                    }
                    
    }else{
        console.log('Invalid Room Amount');
    }
}

let roomAmount = 0;
let roomAmountTot = 0;
let extra_pers_amount = [];

function updateExtraPerson(rand = 0,action ='') {
    let extra_charge = 0;
    let roomTariff = document.getElementById("roomtariff_resvn"+ rand).value;
    
    $.each(tariff_data, function(key,avaiableTariff){
        if(avaiableTariff.id == roomTariff){
            extra_charge = avaiableTariff.extra_person_tariff;
        }
    });
    let person_number = $('#extraperson_resvn'+rand).val();
    let maxperson = document.getElementById("adults_resvn"+ rand).value;
    if(parseInt(person_number) < parseInt(maxperson)){
        $('.extraperson_resvn_class'+rand).html('');
    }else{
        person_number = 0;
        $('#extraperson_resvn'+rand).val(person_number);
        $('.extraperson_resvn_class'+rand).html('Extra Pax cannot be more than max allow person');
    }
    let extra_amount = extra_charge * person_number;
    $('#extrapersonAmount_resvn'+ rand).val(extra_amount);
    allCalculation(action);
}

function removeRoomRow(randNum,action) {
    $('.' + randNum).remove();  // Remove the selected row
    allCalculation(action);
}

function updateTaxStatus() {
    // Check if the checkbox is checked
    if ($('#checkbox-primary-1').is(':checked')) {
        $('.txtStatusClass').text('%5');
    } else {
        $('.txtStatusClass').text('₹0');
    }
}

function allCalculation(action){
    let action_type = '';
    if(action == 1){
        action_type = 'Edit';
    }
    // extra person
    let extra_charge = 0;
    let extra_person_number = 0;
    let extra_person = $("input[name='extraperson_resvn"+action_type+"[]']");
    $.each(extra_person, function(key,person){
        if(action == 1){
            let id_with_string = $(person).attr('id');
            let numStr = id_with_string.replace(/\D/g,'');
            if (roomCheck_Ids.includes(parseInt(numStr))) {
                extra_person_number += parseInt($(person).val());
            }
            if(newRoomAdd.includes(parseInt(numStr))) {
                extra_person_number += parseInt($(person).val());
            }
        }else{
            extra_person_number += parseInt($(person).val());
        }
    });

    let extra_person_amount = $("input[name='extrapersonAmount_resvn"+action_type+"[]']");
    $.each(extra_person_amount, function(key,person_amount){
        if(action == 1){
            let id_with_string = $(person_amount).attr('id');
            let numStr = id_with_string.replace(/\D/g,'');
            if (roomCheck_Ids.includes(parseInt(numStr))) {
                extra_charge += parseInt($(person_amount).val());
            }
            if(newRoomAdd.includes(parseInt(numStr))) {
                if($(person_amount).val() != ""){
                    extra_charge += parseInt($(person_amount).val());
                }
            }
        }else{
            if($(person_amount).val() != ""){
                extra_charge += parseInt($(person_amount).val());
            }
        }
    });
    
    let totAmount = 0;
    let roomAmountTot = 0;
    let extra_person_total_amount = 0;
    let roomcateCount = $("input[name='amount_resvn"+action_type+"[]']");
    let total_no_of_nights = parseInt($('.no_of_nights').html());
    let no_of_nights = parseInt(total_no_of_nights) - parseInt(lastDays);
    $.each(roomcateCount, function(key,room){
        if(action == 1){
            let id_with_string = $(room).attr('id');
            let numStr = id_with_string.replace(/\D/g,'');
            if (roomCheck_Ids.includes(parseInt(numStr))) {
                totAmount += parseInt($(room).val()) * no_of_nights;
            }
            if(newRoomAdd.includes(parseInt(numStr))) {
                totAmount += parseInt($(room).val()) * no_of_nights;
            }
        }else{
            totAmount += parseInt($(room).val()) * no_of_nights;
        }
    });

    if(action == 1){
        let prevAmount = $("input[name='last_tariff_amount_resvnEdit[]']");
        $.each(prevAmount, function(key,re){
            let id_with_string = $(re).attr('id');
            let numStr = id_with_string.replace(/\D/g,'');
            if (roomCheck_Ids.includes(parseInt(numStr))) {
                totAmount += parseInt($(re).val());
            }
        });
    }

    extra_person_total_amount = parseFloat(extra_charge) * no_of_nights;
    $('.room_total_amount').html(Math.round(totAmount));
    $('.extra_total_person').html(extra_person_number);
    $('.extra_total_amount').html(Math.round(extra_person_total_amount));
    let total_received = 0;
    if(action == 1){
        let receive = $("input[name='advance_amount_resvnEdit[]']");

        $.each(receive, function(key,re){
            let id_with_string = $(re).attr('id');
            let numStr = id_with_string.replace(/\D/g,'');
            if (roomCheck_Ids.includes(parseInt(numStr))) {
                total_received += parseInt($(re).val());
            }
        });
        $('.total_received').html(total_received);
    }else{
        total_received = $('.total_received').html();
    }

    roomAmountTot = totAmount + extra_person_total_amount;
    let dis = $('.discount_percentage_reservation').val();
    let discount_amount = 0;
    if(dis != '' && dis > 0){
        let num = parseFloat(dis.replace(/[^\d.-]/g, ''));
        discount_amount = (parseFloat(num)/100) * parseFloat(roomAmountTot);
    }
    $('.discount_total_room').html(Math.round(discount_amount));
    roomAmountTot = roomAmountTot - discount_amount;
    let outstanding = roomAmountTot - parseFloat(total_received);
    $('.total_subtotal').val(roomAmountTot);
    $('.total_final_res_amount').html(Math.round(roomAmountTot));
    $('.total_outstanding').html(Math.round(outstanding));
}

function clearReservation(){
    // Reset specific dynamic fields if needed
    const currentDate = new Date();
    $('#checkin_resvn').val(currentDate);
    let curr_checkin = new Date($("#checkin_resvn").val());
    flatpickr("#checkin_resvn",{
        dateFormat: "d-M-Y",
        defaultDate: curr_checkin,
        minDate: curr_checkin
    });
    staycount_checkin();
    $("select[name='roomcate_resvn[]']").val("");
    $("select[name='roomtariff_resvn[]']").val("");
    $("select[name='roomtype_resvn[]']").val("");
    $("select[name='roomno_resvn[]']").val("");
    $("select[name='adults_resvn[]']").val("");
    $("select[name='childrens_resvn[]']").val("");
    $("select[name='infants_resvn[]']").val("");
    $("input[name='amount_resvn[]']").val(0);
    $("input[name='extraperson_resvn[]']").val(0);
    $("input[name='extrapersonAmount_resvn[]']").val(0);
    $('#roomno_resvn0').prop('disabled',true);
    $('#adults_resvn0').prop('disabled',true);
    $('#childrens_resvn0').prop('disabled',true);
    $('#infants_resvn0').prop('disabled',true);
    $(".addNewResField").html('');
    $('.extra_total_amount').html(0);
    $('.room_total_amount').html(0);
    $('.extra_total_person').html(0);
    $('.discount_total_room').html(0);
    $('.total_discount_percentage').val(0);
    $('.total_final_res_amount').html(0);
    $('.total_subtotal').val(0);
    $('.total_advance_amount').val(0);
    $('.total_received').html(0);
    $('.total_outstanding').html(0);
    $('#compnay_details_div').prop('checked',false);
    $('.company_d_d').addClass('d-none');
    $('.add_res_btn').prop('disabled',false);
    resetPrimaryForm();
}

function payAndCheckout() {
    let reservationID = $('.reservation_id_checkout').html();
    let currentOutstandingAmount = parseFloat($('.outstanding_amount').html());
    let clickedRoomID = $('.guest_room_id').text();
    if (roomCheck_Ids.length === 0) {
        Swal.fire({
            title: "No Rooms Selected",
            text: "Please select one room to proceed with Payment.",
            icon: "warning",
            confirmButtonText: "OK"
        });
        return;
    } else if (roomCheck_Ids.length > 1) {
        Swal.fire({
            title: "Select Only 1 Room",
            text: "Please select one room to proceed with Payment.",
            icon: "warning",
            confirmButtonText: "OK"
        });
        return;
    }
    // Validate the amount
    let amountValid = validateField("#amount_o_rsv", "amount", ".amount_o_rsv_class");
    if (!amountValid) {
        return;
    }
    let amount = parseFloat($("#amount_o_rsv").val());
    let displayAmt = currentOutstandingAmount - amount;
    // Check if the amount does not exceed the outstanding amount
    if (amount > currentOutstandingAmount) {
        $('.amount_o_rsv_class').text('Amount exceeds the outstanding balance.').addClass('text-danger');
        return;
    } else {
        $('.amount_o_rsv_class').text('');
    }
    // Gather payment details
    let paymentDate = $("#payment_date_outside_rsv").val();
    let paymentType = $("#payment_type_o_rsv").val();
    let deposite = $("#deposite_o_rsv").is(":checked") ? "Checked" : "Not Checked";
    let shownote = $("#shownote_outside_rsv").is(":checked") ? "Checked" : "Not Checked";
    let note = $("#note_o_rsv").val();
    let emailInvoice = $("#email_invoice_o_rsv").is(":checked") ? "Checked" : "Not Checked";
    let guestEmail = $("#guest_email_o_rsv").val();
    Swal.fire({
        title: "Confirm submission of ₹" + amount + " and proceed with room checkout?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
        // Send payment data via AJAX
            $.ajax({
                url: reservationPaymentSubmit,
                type: "POST",
                data: {
                    reservationid: reservationID,
                    roomID: roomCheck_Ids, // Assuming roomCheck_Ids contains the selected room ID
                    amount: amount,
                    payment_date: paymentDate,
                    payment_type: paymentType,
                    deposite: deposite, 
                    shownote: shownote,
                    note: note,
                    email_invoice: emailInvoice,
                    guest_email: guestEmail,
                },
                success:function(response) {
                    if (response.success) {
                        let paidAmount = parseFloat(response.res_payment[0].paid_amount);
                        let discountAmount = parseFloat(response.res_payment[0].discount);
                        let totalPaidAmount = paidAmount + discountAmount;
                        if (currentOutstandingAmount > totalPaidAmount) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: `Amount submitted. Pay due ₹${displayAmt.toFixed(2)} to complete checkout.`,
                                showConfirmButton: false,
                                timer: 4000,
                            });
                            setTimeout(() => {
                                edit_reservation(clickedRoomID, reservationID); // Reload reservation rooms
                            }, 4500);
                        } else {
                            // Proceed with checkout process whenn room due payment is cleared
                            $.ajax({
                                url: checkoutProcess,
                                type: "POST",
                                data: {
                                    reservationid: reservationID,
                                    room_id: roomCheck_Ids,
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            position: "center",
                                            icon: "success",
                                            text: "Payment processed successfully. Room checkout completed.",
                                            showConfirmButton: false,
                                            timer: 5000,
                                        });
                                        setTimeout(() => {
                                            let reloadReservationDuration = $(".reload_reservation_duration").html();
                                            loadreservationdata(reloadReservationDuration, 2); // Reset reservation page
                                            $('#EditReservation').modal('hide');
                                        }, 3500);
                                    }
                                },
                            });
                        }
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong!",
                    });
                },
            });
        }
    });
}

function resetPrimaryForm(x=0){
    let action = '';
    if(x > 0){
        action = '_edit';
    }
    
    $('#first_name_resvn'+action).val('');
    $('#last_name_resvn'+action).val('');
    $('#mobile_resvn'+action).val('');
    $('#allergic_to_resvn'+action).val('');
    $('#email_resvn'+action).val('');
    $('#address_resvn'+action).val('');
    $('#city_resvn'+action).val('');
    $('#state_resvn'+action).val('');
    $('#pin_resvn'+action).val('');
    $('#country_resvn'+action).val('India');
    $('#coming_from_resvn'+action).val('');
    $('#going_to_resvn'+action).val('');
    $('#purpose_of_visit_resvn'+action).val('');
    $('#arrivaltime_resvn'+action).val('');
    $('#documenttype_resvn'+action).val('');
    $('#otherdetail_resvn'+action).val('');
    $('#idnumber_resvn'+action).val('');
    $('#comments_resvn'+action).val('');
    $('#note_resvn'+action).val('');
    $('#companyname_resvn'+action).val('');
    $('#companygst_resvn'+action).val('');
    $('#companyaddress_resvn'+action).val(''); 
    $('#companypincode_resvn'+action).val(''); 
    $('#companystate_resvn'+action).val(''); 
    $('#itemCodeList'+action).empty(); // hide dorpdown which fetch thorugh mobile input
    if(x == 0){
        $('.alert_msg').html('Primary Contact Reset Succsessfully');
        var toast = new bootstrap.Toast(document.getElementById('liveToast'));
        toast.show();
    }
}

// $('body').on('shown.bs.modal', '#reservation', function () {
//     $('#mobile_resvn').focus();
// });

function discount_resvn_edit_click(value){
    if(value > 0){
        $('.discount-tick').removeClass('d-none');
    }else{
        $('.discount-tick').addClass('d-none');
    }
}

function update_discount_resvn_edit(id,value,reservationID){
    let clicked_room_id = $('.guest_room_id').text(); 
    $.ajax({
        url: updateDiscountEdit,
        type: "POST",
        data: {id:id,value:value},
        success:function(response){
            if(response.success){
                edit_reservation(clicked_room_id, reservationID); // ajax reload on reservation rooms
            }else{
                console.log('errorrr');
            }
        }
    });
}

function invoice_status(text,roomID){
    let clicked_room_id = $('.guest_room_id').text(); 
    let mark_text = text == 'mf'?'final':'cancel';
    Swal.fire({
        title: "Are you sure to mark as " +mark_text+"?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Proceed!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: reservationDetailData,
                type: "POST",
                data:{id:roomID},
                success:function(response){
                    let getResData = response.reservationData[0];
                    let getRoomData = response.reservationroomData[0];
                    let reservation_id = getRoomData.reservation_id;
                    let room_num = getRoomData.room_alloted;
                    let room_type = getRoomData.room_type;
                    let checkin = getRoomData.checkin;
                    let checkout = getRoomData.checkout;
                    let amount = getRoomData.amount;
                    let discount = getRoomData.discount;
                    let paid_amount = getRoomData.paid_amount;
                    let name = getResData.name;
                    let mobile = getResData.mobile;
                    let email = getResData.email;
                    let address = getResData.address;
                    let company_name = getResData.company_name;
                    let company_gst = getResData.company_gst;
                    if(response.success){
                        $.ajax({
                                url: paymentInvoiceStatus,
                                type: "POST",
                                data: {markText:mark_text,roomID:roomID,reservationID:reservation_id,room_num:room_num,room_type:room_type,checkin:checkin,checkout:checkout,amount:amount,discount:discount,paid_amount:paid_amount,name:name,mobile:mobile,email:email,address:address,company_name:company_name,company_gst:company_gst},
                                success:function(response){ 
                                    if(response.success){
                                        Swal.fire({
                                            position: "center",
                                            icon: "success",
                                            text: "Invoice status changed.",
                                            showConfirmButton: false,
                                            timer: 2000,
                                        }).then(() => {
                                            edit_reservation(clicked_room_id, reservation_id);
                                        });
                                    }else{
                                        console.log('invoice not updated');
                                    }
                                }
                            });
                    }else{
                        console.log('someting error in invoice generate');
                    }
                }
            });
        }
    });
}

function cancel_final_invoice(id){
Swal.fire({
    title: "Are you sure to cancel this invoice?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url:cancelFinalInvoice,
                type:"POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{id:id},
                success: function(response) {
                    if(response.success){
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        text: response.success,
                        showConfirmButton: false,
                        timer: 3000,
                    }).then(() => {
                        $('#reservation_invoice_final').DataTable().ajax.reload();
                    });
                }else{
                    alert('invoice_error');
                }
                }
            });
        }
    });
}

function getRoomTypeName(xx, randNumm) {

    $("#adults_resvn"+randNumm).prop('disabled',true);
    $("#childrens_resvn"+randNumm).prop('disabled',true);
    $("#infants_resvn"+randNumm).prop('disabled',true);
    $("#roomtype_resvn"+randNumm).prop('disabled',true);
    $("#amount_resvn"+randNumm).empty();
    $("#amount_resvn"+randNumm).prop('disabled',true);
    let roomtypeSelect = $("#roomtype_resvn"+randNumm);
    roomtypeSelect.empty();
    $("#roomno_resvn"+randNumm).html(`<option value="NA">Select</option>`);
    $.each(availableRoomDetail,function(key,avaiableRoom){
        if(avaiableRoom['id'] == xx){
            type = avaiableRoom['types'];
            roomtypeSelect.prop("disabled", false); // Clear previous options
            roomtypeSelect.append(`<option value="">Select</option>`);
            type.forEach(function (roomtypes) {
                roomtypeSelect.append(`<option value="${roomtypes["id"]}">${roomtypes["name"]}</option>`);
            });
        }
    });

    $("#roomNum_resvn"+randNumm).html(`<option value="">Select</option>`);
    $("#adults_resvn"+randNumm).html(`<option value="">Select</option>`);
    $("#childrens_resvn"+randNumm).html(`<option value="">Select</option>`);
    $("#infants_resvn"+randNumm).html(`<option value="">Select</option>`);
    $("#amount_resvn"+randNumm).val(0);
    $("#extra_person_resvn"+randNumm).val(0);
    $("#discount_resvn"+randNumm).val(0);
}

// hide room rnumber which has been seleced in previous row
let selectRoomNumber = []; // Keep track of selected rooms that should not display next row for room selection
function checkRoomNum() {
    selectRoomNumber = $("select[name='roomno_resvn[]'").map(function(){return $(this).val();}).get();
}

function getroomoccupancy(yy, randNumm) {
    
    availableRoomDetail.forEach(function (roomtypes) {
        if(roomtypes["id"] == yy){
            let roomNumbers = roomtypes['rooms'];
            let roomno_resvn = $("#roomno_resvn"+randNumm);
            roomno_resvn.prop('disabled', false);
            roomno_resvn.empty();
            roomno_resvn.append(`<option value="">Select</option>`);
            roomNumbers.forEach(function (r_num) {
                if(r_num['current_status'] == '-1'){
                    roomno_resvn.append(`<option value="${r_num['id']}">${r_num['room_number']}</option>`);
                }
            });

            let adults_resvn = $("#adults_resvn"+ randNumm);
            let childrens_resvn = $("#childrens_resvn"+ randNumm);
            let infants_resvn = $("#infants_resvn"+ randNumm);
            
            adults_resvn.empty();
            childrens_resvn.empty();
            infants_resvn.empty();
            adults_resvn.prop("disabled", false);
            childrens_resvn.prop("disabled", false);
            infants_resvn.prop("disabled", false);
            
            let maxAdult = roomtypes["max_adult"];
            let maxChild = roomtypes["max_child"];
            let maxInfant = roomtypes["max_infant"];
            
            childrens_resvn.append(`<option value="0">0</option>`);
            infants_resvn.append(`<option value="0">0</option>`);
            for (let i = 1; i <= maxAdult; i++) {
                adults_resvn.append(`<option value="${i}">${i}</option>`);
            }
            for (let j = 1; j <= maxChild; j++) {
                childrens_resvn.append(`<option value="${j}">${j}</option>`);
            }
            for (let k = 1; k <= maxInfant; k++) {
                infants_resvn.append(`<option value="${k}">${k}</option>`);
            }
            
            let roomTariff = $("#roomtariff_resvn"+ randNumm);
            roomTariff.empty();
            roomTariff.prop("disabled", false);
            roomTariff.append(`<option value="">Select</option>`);
            $.each(tariff_data, function(key,avaiableTariff){
                if(avaiableTariff.room_category_id == yy){
                    roomTariff.append(`<option value="${avaiableTariff.id}">${avaiableTariff.tariff_type}</option>`)
                }
            });
        }
    });
}

function getRoomTariff(value, randNum,action=0){
    if(value != ""){
        $.each(tariff_data, function(key,avaiableTariff){
            if(avaiableTariff.id == value){
                $("#amount_resvn"+ randNum).val(avaiableTariff.room_tariff);
            }
        });
    }else{
        $("#amount_resvn"+ randNum).val(0);
    }
    updateExtraPerson(randNum,action); // Update extra person if necessary
}

$(document).ready(function(){
    $(".nav-modal-edit").on("click", function(){
        $('.paymentRec-Dtab-detail').css({"right":"0%", "opacity":"0"});
        $('.paymentRec-Dtab-payment').css({"right":"0%", "opacity":"0"});
        $('.paymentRec-Dtab-notes').css({"right":"0%", "opacity":"0"});
        $('.paymentRec-Dtab-kot').css({"right":"0%", "opacity":"0"});
        $('#dtab-showbtn').css("opacity","0");
    });
});

function calculateHotelDays(checkinDate, checkoutDateTime,type = '') {
    // Convert to Date objects
    let checkin = new Date(checkinDate);
    let checkout = new Date(checkoutDateTime);
    
    // If only date is given for check-in, system adds current time
    if(type == ''){
        checkin.setHours(new Date().getHours(), new Date().getMinutes(), 0, 0);
    }else{
        checkin.setHours(checkinDate.getHours(), checkinDate.getMinutes(), 0, 0);
    }
    
    // Calculate day difference
    let diffMs = checkout - checkin;
    let diffDays = Math.floor(diffMs / (1000 * 60 * 60 * 24));
    
    let checkinHour = checkin.getHours() + checkin.getMinutes() / 60;
    let checkoutHour = checkout.getHours() + checkout.getMinutes() / 60;
    diffDays = Math.ceil(diffDays);
    if (diffDays <= 0) {
        if (checkinHour < 12 && checkoutHour > 14) {
            diffDays = diffDays + 2;
        } else {
            diffDays = diffDays + 1;
        }
    } else {
       if(type == ''){
            if (checkinHour < 12 && checkoutHour > 14) {
           diffDays = diffDays + 2;
            } else if (
                (checkinHour < 12 && checkoutHour < 14) ||
                (checkinHour > 12 && checkoutHour > 14)
            ) {
                diffDays = diffDays + 1;
            }
            else if((checkinHour > 12 && checkoutHour < 14)){
                diffDays = diffDays + 1;
            }
        }else{
            if (checkinHour < 12 && checkoutHour > 14) {
                diffDays = diffDays + 2;
            } else if (
                (checkinHour < 12 && checkoutHour < 14) ||
                (checkinHour > 12 && checkoutHour > 14)
            ) {
                diffDays = diffDays + 1;
            }
        }
    }

    return diffDays;
}

function checkGstCompany(type,x=0){
    let action = '';
    if(x > 0){
        action = '_edit';
    }
    const regex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][1-9A-Z]Z[0-9A-Z]$/
    if(regex.test(type)){
        $('.gst-fetch-detail'+action).removeAttr('disabled');
    }else{
        $('.gst-fetch-detail'+action).attr("disabled", "disabled");
    }
}

function checkGstRequest(x=0){
    action = '';
    if(x == 1){
        action = '_edit';
    }
    let number = $('#companygst_resvn'+action).val();
    const regex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][1-9A-Z]Z[0-9A-Z]$/
    if(regex.test(number)){
        $('.gst-fetch-detail').html('Please Wait');
        $('.gst-fetch-detail').attr("disabled",true);
        $.ajax({
            url: companyVerifyGst,
            type: "POST",
            data: {
                number:number,type:'Company'
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // console.log(response);
                $('.gst-fetch-detail').html('Fetch');
                $('.gst-fetch-detail').attr("disabled",true);
                if (response.status == 200) {
                    let data = response.data.data;
                    if(data == undefined){
                        
                        let a = JSON.parse(response.data.status_desc);
                        Swal.fire('Error-'+a[0].ErrorCode, a[0].ErrorMessage, 'error');
                    }else{

                        $('#gstLegalName'+action).val(data.LegalName);
                        $('#gstAddrBnm'+action).val(data.AddrBnm);
                        $('#gstAddrBno'+action).val(data.AddrBno);
                        $('#gstAddrFlno'+action).val(data.AddrFlno);
                        $('#gstAddrSt'+action).val(data.AddrSt);
                        $('#gstAddrLoc'+action).val(data.AddrLoc);
                        $('#gstTxpType'+action).val(data.TxpType);
                        $('#gstStatus'+action).val(data.Status);
                        $('#gstBlkStatus'+action).val(data.BlkStatus);
                        $('#gstDtReg'+action).val(data.DtReg);
                        $('#gstDtDReg'+action).val(data.DtDReg);
                        $('#gstTradeName'+action).val(data.TradeName);
                        $('#gstStateCode'+action).val(data.StateCode);
                        $('#gstAddrPncd'+action).val(data.AddrPncd);
                        let addr = data.AddrFlno +', '+ data.AddrBno +', '+ data.AddrBnm +', '+ data.AddrSt +', '+ data.AddrLoc;
                        $('#gstAddr'+action).val(addr);
                        $('.gst-address'+action).removeClass('d-none');
                        $('.gst-address'+action).html('');
                        $('.gst-address'+action).append(`<p class="mb-0">${data.TradeName}, ${addr} - ${data.AddrPncd} </p>`);
                    }
                } else if(response.alreadyfound){
                    if(x > 0){
                        $('.gst-fetch-update-view').addClass('d-none');
                        $('.last-company-detail').removeClass('d-none');
                        $('#updateGSTBtn').prop('checked',false);
                    }
                    $('#last_company_id').val(response.company_id);
                    $('#last_GST').val(number);
                    $('#last_company').val(response.company_name);
                    $('#last_addr').val(response.company_addr);
                    $('.alert_msg_danger').html('Gst already exists in record!');
                    var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                    toast.show();
                }else{             
                    alert("Error");
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    }else{
        $('.alert_msg_danger').html('Invalid GST Number');
        $('#companyname_resvn').val('');
        $('#companyaddress_resvn').val('');
        $('#companypincode_resvn').val('');
        $('#companystate_resvn').val('');
        var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
        toast.show();
    }
}

    $('#compnay_details_manually').on('click',function(){
        if($('#compnay_details_manually').is(':checked')) {
            $('.company_gst').hide();
            $('#companyname_resvn').prop('readonly',false);
            $('#companyaddress_resvn').prop('readonly',false);
            $('#companypincode_resvn').prop('readonly',false);
            $('#companystate_resvn').prop('disabled',false);
        } else {
            $('.company_gst').show();
            $('#companyname_resvn').prop('readonly',true);
            $('#companyaddress_resvn').prop('readonly',true);
            $('#companypincode_resvn').prop('readonly',true);
            $('#companystate_resvn').prop('disabled',true);
        }
        $('#companygst_resvn').val('');
        $('#companyname_resvn').val('');
        $('#companyaddress_resvn').val('');
        $('#companypincode_resvn').val('');
        $('#companystate_resvn').val('');
    });
    
    $('body').on('click', '#new_reservation_checkin_confirmation', function() {
        if ($('#new_reservation_checkin_confirmation').prop('checked')) {
            $('.reservation_checkin_confirmation_allow').removeClass('d-none');
            $('.add_res_btn').html('Check-in');
        } else {
            $('.reservation_checkin_confirmation_allow').addClass('d-none');
            $('.add_res_btn').html('Reserve');
        }
    });

    function time() {
        let d = new Date();
        let s = d.getSeconds();
        let m = d.getMinutes();
        let h = d.getHours();
        $('.reservation_checkin_show_time').html(("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2));
    }

    setInterval(time, 1000);