const url = new URL(window.location.href);
const parts = url.pathname.split('/').filter(Boolean);
const lastPart = parts[parts.length - 1];

if(lastPart != 'create-reservation'){
    edit_reservation();
}

function edit_reservation() {
    let reservationid = $('.reservation_id_checkout').val();
    let id = $('.room_id_checkout').val();

    $.ajax({
        url: getRservationandRoomDetails,
        type: "GET",
        data: {
            id: id,
            reservationid: reservationid,
        },
        success: function(response) {
            console.log(response);
            availableRoomDetail = response.roomCategoryNum;
            tariff_data = response.tariffs;
            let reservationMaster = response.reservationDetails[0];
            currentReservationDetail = reservationMaster;
            let roomDataAll = response.reservationroomAll;
            roomDetailAll = roomDataAll;
            let clicked_room_id = id;

             let roomAmount = 0;
                let extraTotalPerson = 0;
                let extraTotalPersonAmount = 0;
                let room_discount = 0;
                let totalPaidAmount = 0;
                let daysDifference = 0;
                // Room Reservation Detail
            let roomDataHtml = '';
                let number_of_room = roomDataAll.length;
                roomDataAll.forEach(function(resRoomData) {

                    let lastAmount = 0;
                    
                    response.reservationTariffHistory.forEach(function(tariffLast) { 
                        if(tariffLast['reservation_room_id'] == resRoomData['id'] && tariffLast['current_status'] == 'In-Active'){
                            lastAmount += tariffLast['grand_total'];
                            lastDays = tariffLast['day_stay'];
                        }
                    });
                    let add = reservationMaster.advance_amount/number_of_room
                    if(resRoomData['id'] == id){
                        $('.reservation_edit_status').html(resRoomData.status);
                        if(resRoomData.status == 'Check-out'){
                            $('.update_res_Btn').addClass('d-none');
                            $('#addAnotherRoomEdit').addClass('d-none');
                        }else{
                            $('.update_res_Btn').removeClass('d-none');
                            $('#addAnotherRoomEdit').removeClass('d-none');
                        }
                        $('#res_checkin_Edit').val(resRoomData.checkin);
                        let dateStr = resRoomData.checkin;
                        let date = new Date(dateStr);
                        flatpickr("#res_checkin_Edit",{
                            dateFormat: "d-M-Y",
                            defaultDate: date,
                            minDate: date
                        });

                        $('#res_checkout_Edit').val(response.checkout_date);
                        let input1 = response.checkout_date;
                        let d1 = new Date(input1);
                        flatpickr("#res_checkout_Edit",{
                            dateFormat: "d-M-Y",
                            defaultDate: d1,
                            minDate: d1
                        });
                        
                        if(resRoomData.status == 'Alloted'){
                            $('.checkin_res_Btn').addClass('d-none');
                            $('.cancel_reservation').addClass('d-none');
                            $('.checkout_res_Btn').removeClass('d-none');
                        }else if(resRoomData.status == 'Reserved'){
                            $('.checkin_res_Btn').removeClass('d-none');
                            $('.cancel_reservation').removeClass('d-none');
                            $('.checkout_res_Btn').addClass('d-none');
                        }else{
                            $('.checkin_res_Btn').addClass('d-none');
                            $('.cancel_reservation').addClass('d-none');
                            $('.checkout_res_Btn').addClass('d-none');
                        }
                    }

                    let roomNumberAlloted ='';
                    if(resRoomData['room_alloted'] != 'NA'){
                        availableRoomDetail.forEach(function(roomCate){

                            if(roomCate['id'] == resRoomData['room_category_id']){
                                roomCate['rooms'].forEach(function(roomNum) {
                                    if(resRoomData['room_alloted_id'] == roomNum['id']){
                                        $('.selected-room-detail').html(roomCate['name']+' Room '+roomNumberAlloted);
                                        roomNumberAlloted = roomNum['room_number'];
                                    }
                                });
                            }

                        });
                    }
                    let max_adult = 0;
                    let max_child = 0;
                    let max_infant = 0;
                    availableRoomDetail.forEach(function(roomCate){

                        if(roomCate['id'] == resRoomData['room_category_id']){
                            max_adult = roomCate['max_adult'];
                            max_child = roomCate['max_child'];
                            max_infant = roomCate['max_infant'];
                        }

                    });

                    roomDataHtml += `<div class="col-md-12">
                        <div class="accordion-item border p-2 my-2 accrdn-border">
                            <h2 class="accordion-header " id="flush-headingOne">
                                <button class="accordion-button ${(resRoomData['id'] == clicked_room_id) ? '' : 'collapsed'}" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne${resRoomData['id']}" aria-expanded="${(resRoomData['id'] == clicked_room_id) ? 'true' : 'false'}" aria-controls="flush-collapseOne">`;
                                if(roomNumberAlloted ==''){
                                    roomDataHtml += ` <h5>Room No : Not Alloted</h5>`;
                                }else{
                                    roomDataHtml += `<h5>Room No : ${roomNumberAlloted}</h5>`;
                                }
                            roomDataHtml+=`</button>
                            </h2>
                            <div class="accordion-collapse collapse ${(resRoomData['id'] == clicked_room_id) ? 'show' : ''}" id="flush-collapseOne${resRoomData['id']}" aria-labelledby="flush-headingOne${resRoomData['id']}" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body room-type-bar border-radius-4 d-flex flex-wrap my-2 px-3 py-2 justify-content-between align-items-center bg-light d-tab-element">
                                    <div class="mb-3 mb-lg-1">
                                        <label class="form-label">Room Type</label>
                                        <select class="form-select form-select-sm" id="roomtype_resvn${resRoomData['id']}" name="roomtype_resvnEdit[]" onchange="getroomoccupancy(this.value,${resRoomData['id']})" ${resRoomData['status'] == 'Check-out'? 'disabled':''} required>`;
                                            availableRoomDetail.forEach(function(r_cate) {
                                                roomDataHtml += `<option value="${r_cate['id']}" ${(resRoomData['room_category_id'] == r_cate['id']) ? 'selected' : ''}>${r_cate['name']}</option>`;
                                            });
                                        roomDataHtml += `</select>
                                    </div>
                                    <div class="mb-3 mb-lg-1">
                                        <label class="form-label">Tariff</label>
                                        <select class="form-select form-select-sm" id="roomtariff_resvn${resRoomData['id']}" name="roomtariff_resvnEdit[]" onchange="getRoomTariff(this.value,${resRoomData['id']},1)" ${resRoomData['status'] == 'Check-out'? 'disabled':''} required>
                                            <option value="">Select</option>`;
                                            tariff_data.forEach(function(tariff) {
                                                if(tariff.room_category_id == resRoomData['room_category_id']){
                                                    roomDataHtml += `<option value="${tariff['id']}" ${(tariff['id'] == resRoomData['tariff_id']) ? 'selected' : ''}>${tariff['tariff_type']}</option>`;
                                                }
                                            });
                                            roomDataHtml += `</select>
                                    </div>
                                    <div class="mb-3 mb-lg-1">
                                        <label class="form-label">Room No.</label>
                                        <select class="form-select form-select-sm" id="roomno_resvn${resRoomData['id']}" name="roomno_resvnEdit[]" ${resRoomData['status'] == 'Check-out'? 'disabled':''}>`;
                                        if (resRoomData['room_alloted'] == "") {
                                            roomDataHtml += `<option value="">NA</option>`;
                                        }else{
                                            
                                            availableRoomDetail.forEach(function(r_cate) {
                                                if(r_cate['id'] == resRoomData['room_category_id']){
                                                    r_cate['rooms'].forEach(function(number) {
                                                        if(number['id'] == resRoomData['room_alloted_id']){
                                                            roomDataHtml += `<option value="${number['id']}" ${(number['id'] == resRoomData['room_alloted']) ? 'selected' : ''}>${number['room_number']}</option>`;
                                                        }
                                                    });
                                                }
                                            });
                                        }

                                        availableRoomDetail.forEach(function(r_cate) {
                                            if(r_cate['id'] == resRoomData['room_category_id']){
                                                r_cate['rooms'].forEach(function(number) {
                                                    if(number['current_status'] == '-1'){

                                                        roomDataHtml += `<option value="${number['id']}" ${(number['id'] == resRoomData['room_alloted']) ? 'selected' : ''}>${number['room_number']}</option>`;
                                                    }
                                                });
                                            }
                                        });
                                        roomDataHtml += ` </select>
                                    </div>
                                    <div class="mb-3 mb-lg-1">
                                        <label class="form-label">Adults</label>
                                        <select class="form-select form-select-sm" id="adults_resvn${resRoomData['id']}" name="adults_resvnEdit[]" ${resRoomData['status'] == 'Check-out'?'disabled':''} required>`;
                                            for (let i = 0; i <= max_adult; i++) {  // Change this value to adjust the maximum number of adults
                                                roomDataHtml += `<option value="${i}" ${(i == resRoomData['adults']) ? 'selected' : ''}>${i}</option>`;
                                            }
                                            roomDataHtml += `</select>
                                        <div class="limit_excced${resRoomData['id']} position-absolute mt-1"></div>
                                    </div>
                                    <div class="mb-3 mb-lg-1">
                                        <label class="form-label">Children</label>
                                        <select class="form-select form-select-sm" id="childrens_resvn${resRoomData['id']}" name="childrens_resvnEdit[]" ${resRoomData['status'] == 'Check-out'?'disabled':''}>`;
                                        for (let i = 0; i <= max_child; i++) {  // Change this value to adjust the maximum number of child
                                            roomDataHtml += `<option value="${i}" ${(i == resRoomData['childrens']) ? 'selected' : ''}>${i}</option>`;
                                        }
                                    roomDataHtml += ` </select>
                                    </div>
                                    <div class="mb-3 mb-lg-1">
                                        <label class="form-label">Infants</label>
                                        <select class="form-select form-select-sm" id="infants_resvn${resRoomData['id']}" name="infants_resvnEdit[]" ${resRoomData['status'] == 'Check-out'?'disabled':''}>`;
                                        for (let i = 0; i <= max_infant; i++) {  // Change this value to adjust the maximum number of infant
                                            roomDataHtml += `<option value="${i}" ${(i == resRoomData['infants']) ? 'selected' : ''}>${i}</option>`;
                                        }
                                    roomDataHtml += ` </select>
                                    </div>
                                    <div class="mb-3 mb-lg-1">
                                        <label class="form-label">Amount</label>
                                        <div class="input-group">
                                            <span class="input-group-text text-muted">₹</span>
                                            <input class="form-control form-control-sm w-120" type="text" id="amount_resvn${resRoomData['id']}"  value="${resRoomData['amount']}" name="amount_resvnEdit[]" oninput="allCalculation(1)" required>
                                        </div>
                                    </div>
                                    <div class="mb-3 mb-lg-1 d-none">
                                        <label class="form-label">Advance & Last Amount</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm w-120" type="number" value="${add}" name="advance_amount_resvnEdit[]" id="advance_amount_resvn${resRoomData['id']}">
                                            <input class="form-control form-control-sm w-120" type="number" value="${lastAmount}" name="last_tariff_amount_resvnEdit[]" id="last_tariff_amount_resvn${resRoomData['id']}">
                                        </div>
                                    </div>
                                    <div class="mb-3 mb-lg-1">
                                        <label class="form-label">Extra Pax</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm w-120" type="number" value="${resRoomData['extra_person']}" id="extraperson_resvn${resRoomData['id']}" name="extraperson_resvnEdit[]" oninput="updateExtraPerson(${resRoomData['id']},1)" ${resRoomData['status'] == 'Check-out'?'readonly':''}>
                                        </div>
                                    </div>
                                    <div class="mb-3 mb-lg-1">
                                        <label class="form-label">Extra Pax Amount</label>
                                        <div class="input-group">
                                            <input class="form-control form-control-sm w-120" type="number" id="extrapersonAmount_resvn${resRoomData['id']}"name="extrapersonAmount_resvnEdit[]" value="${resRoomData['extra_person_amount']}" oninput="allCalculation(1)">
                                        </div>
                                    </div>
                                    <div class="mb-3 mb-lg-1">
                                        <input type="hidden" id="${resRoomData['id']}" name="room_idEdit[]" value="${resRoomData['id']}">
                                        <div class="form-check" style="margin-top:25px;">`;
                                        if(resRoomData['status'] == 'Check-out'){
                                            roomDataHtml += `<input class="form-check-input bg-danger" type="checkbox" id="${resRoomData['id']}" onclick="roomCheckData(this.id)" checked disabled>`;
                                        }else{
                                           
                                            if(resRoomData['id'] == clicked_room_id){
                                                roomCheck_Ids.push(resRoomData['id']);
                                            }
                                            roomDataHtml += `<input class="form-check-input room_checked-element" type="checkbox" id="${resRoomData['id']}" onclick="roomCheckData(this.id)" ${(resRoomData['id'] == clicked_room_id) ? 'checked disabled' : ''}>`;
                                        }
                                    roomDataHtml += `</div></div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                    if(roomCheck_Ids.includes(resRoomData['id'])){
                        
                        let now = new Date();
                        let checkin = new Date(response.checkedin_at);
                        let checkin_record = new Date(response.checkedin_at);
                        let datetime = response.checkedin_at;
                        let lastAmountCal = 0;
                        response.reservationTariffHistory.forEach(function(tariffLast) { 
                            if(tariffLast['reservation_room_id'] == resRoomData['id'] && tariffLast['current_status'] == 'Active'){
                                datetime = tariffLast.date;
                                checkin_record = new Date(tariffLast.date);
                                lastDate = checkin_record;
                            }
                            if(tariffLast['reservation_room_id'] == resRoomData['id'] && tariffLast['current_status'] == 'In-Active'){
                                lastAmountCal += tariffLast['grand_total'];
                            }
                        });

                        $('.reservation_edit_status').html();
                        if($('.reservation_edit_status').html() == 'Reserved'){
                            $('.addNewRoomClass').removeClass('d-none');
                        }else{
                            $('.addNewRoomClass').addClass('d-none');
                        }

                        roomAmount = lastAmountCal;
                         // make sure this is defined
                        if(datetime){
                            
                            let date = new Date(datetime.replace(" ", "T"));
                            let hours = String(date.getHours()).padStart(2, '0');
                            let minutes = String(date.getMinutes()).padStart(2, '0');
                            checkin_record.setHours(hours, minutes, 0, 0);

                            let datetimePrev = response.checkedin_at;
                            let datePrev = new Date(datetimePrev.replace(" ", "T"));
                            let hoursPrev = String(datePrev.getHours()).padStart(2, '0');
                            let minutesPrev = String(datePrev.getMinutes()).padStart(2, '0');
                            checkin.setHours(hoursPrev, minutesPrev, 0, 0);
                        }else{
                            checkin = new Date(response.checkin)
                            checkin_record = new Date(response.checkin)
                            checkin.setHours(now.getHours(), now.getMinutes(), 0, 0);
                            checkin_record.setHours(now.getHours(), now.getMinutes(), 0, 0);
                        }

                        let checkout = new Date(response.checkout);
                        
                        if(checkout > now){
                            checkout.setHours(12, 0, 0, 0);
                        }else{
                            if(12 > now.getHours()){
                                checkout.setHours(12, 0, 0, 0);
                            }else{
                                checkout.setHours(now.getHours(), now.getMinutes(), 0, 0);
                            }
                        }

                        let totalDays = calculateHotelDays(checkin_record, checkout,1);
                        let totalDaysAll = parseInt(lastDays) + parseInt(totalDays);

                        roomAmount += (parseInt(resRoomData['amount']) * totalDays);
                        extraTotalPerson += parseInt(resRoomData['extra_person']);
                        extraTotalPersonAmount += parseInt(resRoomData['extra_person_amount']) * totalDays;

                        let nits = totalDaysAll <= 1 ? "Night" : "Nights";
                        $(".reservation_durationEdit").html(Math.round(totalDaysAll) + " " + nits);
                        $(".no_of_stay").html('('+Math.round(totalDaysAll) + " " + nits+')');
                        $('.no_of_nights').html(totalDaysAll);
                    }
                });

                let total_received = 0;
                let advance = reservationMaster.advance_amount/number_of_room;
                total_received += advance;

                response.resrvationpaymentdetails.forEach(function(reservation_payment){
                    total_received += parseInt(reservation_payment['amount']);
                });
                let tot_before_discount = parseFloat(roomAmount + extraTotalPersonAmount);
                let dis = 0;
                if(reservationMaster.discount > 0){
                    $('.discount_percentage_reservation').html('('+reservationMaster.discount+'%)');
                    dis = (parseFloat(reservationMaster.discount)/100) * parseFloat(tot_before_discount);
                }
                disc_amount = tot_before_discount - dis;
                room_discount = parseFloat(disc_amount);
                let total_to_pay = parseFloat(room_discount);
                
                let outStanding_amount = parseInt(total_to_pay) - parseInt(total_received);
                
                $('.room_total_amount').html(Math.round(roomAmount));
                $('.extra_total_person').html(extraTotalPerson);
                $('.extra_total_amount').html(Math.round(extraTotalPersonAmount));
                $('.total_final_res_amount').html(Math.round(total_to_pay));
                
                $('.discount_total_room').html(Math.round(dis));
                $('.total_received').html(Math.round(total_received));
                $('.total_outstanding').html(Math.round(outStanding_amount));
                $('.roomsDataSubmited').html(roomDataHtml);

                if(reservationMaster.company_gst != ''){
                    $('#b2bCompanyEdit').css('display','block');
                    $('#b2cCompanyEdit').css('display','none');
                    $('#companygst_resvn_edit').val(reservationMaster.company_gst);
                    $('.gst-address_edit').html('');
                    $('.gst-address_edit').removeClass('d-none');
                    $('.gst-address_edit').html(`<p class="mb-0">${reservationMaster.company_name},${reservationMaster.company_address},${reservationMaster.company_state}, ${reservationMaster.company_pincode}</p>`);
                    $('#companyname_resvn_edit').val('');
                    $('#companyaddress_resvn_edit').val('');
                    $('#companypincode_resvn_edit').val('');
                    $('#companystate_resvn_edit').val('');
                    $('#b2bEdit').prop('checked',true);
                }else if(reservationMaster.company_gst == '' && reservationMaster.company_name != ""){
                    $('#b2cCompanyEdit').css('display','block');
                    $('#b2bCompanyEdit').css('display','none');
                    $('#companyname_resvn_edit').val(reservationMaster.company_name);
                    $('#companyaddress_resvn_edit').val(reservationMaster.company_address);
                    $('#companypincode_resvn_edit').val(reservationMaster.company_pincode);
                    $('#companystate_resvn_edit').val(reservationMaster.company_state);
                    $('#b2cEdit').prop('checked',true);
                }else{
                    $('#b2cCompanyEdit').css('display','none');
                    $('#b2bCompanyEdit').css('display','none');
                    $('#companygst_resvn_edit').val('');
                    $('#companyname_resvn_edit').val('');
                    $('#companyaddress_resvn_edit').val('');
                    $('#companypincode_resvn_edit').val('');
                    $('#companystate_resvn_edit').val('');
                    $('#freeEdit').prop('checked',true);
                }
        }
    });
}



function printSingleVoucher(type,id){
    let url = '../../reservation/print-payment-receipt/type='+type+'&payment='+id;
    window.open(url,'_blank');
}

function printReceipt(){
    var selectedSports = [];
    $('input[name="paymentId[]"]:checked').each(function() {
        selectedSports.push($(this).val());
    });

    const result = { payment: [], advance: [] };

    selectedSports.forEach(item => {
        const [type, value] = item.split('-');
        result[type.toLowerCase()].push(value);
    });

    if(result.payment.length > 0 || result.advance.length > 0){

        const params = new URLSearchParams();
        params.append('payment', result.payment.join(','));
        params.append('advance', result.advance.join(','));
    
        // redirect OR use URL
        const url = `../../reservation/print-payment-receipt-all/calculate?${params.toString()}`;
        window.open(url,'_blank');
    }else{
        toastErrorAlert("Select atleast one bill");
    }
}

function exitGuest(id){

    Swal.fire({
        text: "Are you sure to exit Guest?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Do it!"
      }).then((result) => {
        if (result.isConfirmed) {
            
            $.ajax({
                url: reservationExitGuest,
                type: "POST",
                data: {
                    id: id,
                },
                success: function(response) {
                    console.log(response);
                    if(response.success){
                        
                        
                        Swal.fire({
                            text: "Guest Exit Successfully. Do you want to change tariff?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, Do it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#change_tariff_list').empty();
                                $('#prev_change_tariff_list').empty();
                                let output = '';
                                output += `<option value=""> Select</option>`;
                                response.tariffs.forEach(function(tariff){
                                    output += `<option value="${tariff.id}" data-amount="${tariff.room_tariff}"`; if(tariff.id == response.tariff_id){ output +=` selected`; } output +=`>${tariff.tariff_type}</option>`;

                                });
                                $('#change_tariff_list').html(output);
                                $('#prev_change_tariff_list').html(output);
                                $('#prev_change_tariff_amount').val(response.amount);
                                $('#change_tariff_amount').val(response.amount);
                                $('.change_tariff_reservation_room_id').val(response.room_id);
                                $('#changeTariffModel').modal('show');
                            }else{
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2500);
                            }
                        });
                    }
                }
            });
        }
    });
}

function changeTariffAmount(){
    let selectedOptionDataValue = $('#change_tariff_list option:selected').data('amount');
    $('#change_tariff_amount').val(selectedOptionDataValue);
}

// select and unselect all
$('#selectAllPayment').on('change', function () {
    $('.paymentId').prop('checked', this.checked);
});

$('.paymentId').on('change', function () {
    const allChecked = $('.paymentId').length === $('.paymentId:checked').length;
    $('#selectAllPayment').prop('checked', allChecked);
});

$('#change_tariff_form').on('submit', function (e) {
    e.preventDefault();

    let form = document.getElementById("change_tariff_form");
    let formData = new FormData(form);

    $.ajax({
        url: reservationTariffUpdate,
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            // console.log(response);
        }
    });
    
});

function setBtn(x){
    $('.note-update').addClass('d-none');
    $('.update-guest-detail-btn').addClass('d-none');
    $('.update-detail-btn').addClass('d-none');

    if(x == 'detail'){
        $('.update-detail-btn').removeClass('d-none');
    }else if(x == 'guest'){
        $('.update-guest-detail-btn').removeClass('d-none');
    }else if(x == 'note'){
        $('.note-update').removeClass('d-none');
    }
}