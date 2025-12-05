let roomCheck_Ids = []; // stores id of room for payment and checkout
let currentReservationDetail = [];
let roomDetailAll = [];
let lastDays = 0;
let lastDate = '';
let timeConfiguration = [];

function edit_reservation(id, reservationid) {

    $('.reservation_id_checkout').text(reservationid);
    $('.room_id_checkout').text(id);
    $('.guest_room_id').text(id);
    let clicked_room_id = id; 
    roomCheck_Ids = []; // empity array for fresh entry on click on diffent rooms
    
    $.ajax({
        url: getRservationandRoomDetails,
        type: "GET",
        data: {
            id: id,
            reservationid: reservationid,
        },
        success: function(response) {
            console.log(response);
            if (response.success) {
                lastDate = '';
                let reservationMaster = response.reservationDetails[0];
                currentReservationDetail = reservationMaster;
                let roomDataAll = response.reservationroomAll;
                roomDetailAll = roomDataAll; 
                // Primary Contact
                $('.edit_reservation_id').html('Reservation '+reservationMaster.reservation_id+' For '+reservationMaster.first_name+' '+reservationMaster.last_name);
                
                // $('.reservation_durationEdit').html(reservationMaster.no_of_days+' Night');
                $('#first_name_resvn_edit').val(reservationMaster.first_name);
                $('#last_name_resvn_edit').val(reservationMaster.last_name);
                $('#mobile_resvn_edit').val(reservationMaster.mobile);
                $('#email_resvn_edit').val(reservationMaster.email);
                $('#gender_resvn_edit').val(reservationMaster.gender);

                $('#address_resvn_edit').val(reservationMaster.address);
                $('#city_resvn_edit').val(reservationMaster.city);
                $('#state_resvn_edit').val(reservationMaster.state);
                $('#pin_resvn_edit').val(reservationMaster.pincode);
                $('#country_resvn_edit').val(reservationMaster.country);
                $('#coming_from_resvn_edit').val(reservationMaster.coming_from);
                $('#going_to_resvn_edit').val(reservationMaster.going_to);
                $('#purpose_of_visit_resvn_edit').val(reservationMaster.purpose_for_visit);
                $('#arrivaltime_resvn_edit').val(reservationMaster.arrival_time);
                $('#documenttype_resvn_edit').val(reservationMaster.document_type);
                $('#otherdetail_resvn_edit').val(reservationMaster.other_document_type);
                $('#idnumber_resvn_edit').val(reservationMaster.id_number);

                $('#comments_resvn_edit').val(reservationMaster.guest_comment);
                $('#note_resvn_edit').val(reservationMaster.note);
                $('#guest_type_resvn_edit').val(reservationMaster.guest_type);
                $('#allergic_to_resvn_edit').val(reservationMaster.allergic_to);
                console.log(reservationMaster.company_gst);
                console.log(reservationMaster.company_name);
                console.log(reservationMaster.company_address);
                console.log(reservationMaster.company_state);
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

                    console.log(availableRoomDetail);
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
                                <button class="accordion-button ${(resRoomData['id'] == clicked_room_id) ? 'collapsed' : ''}" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne${resRoomData['id']}" aria-expanded="${(resRoomData['id'] == clicked_room_id) ? 'true' : 'false'}" aria-controls="flush-collapseOne">`;
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
                                        <select class="form-select form-select-sm" id="roomtype_resvn${resRoomData['id']}" name="roomtype_resvnEdit[]" onchange="getroomoccupancy(this.value,${resRoomData['id']})" ${resRoomData['status'] == 'Check-out'? 'disabled':''}>`;
                                            availableRoomDetail.forEach(function(r_cate) {
                                                roomDataHtml += `<option value="${r_cate['id']}" ${(resRoomData['room_category_id'] == r_cate['id']) ? 'selected' : ''}>${r_cate['name']}</option>`;
                                            });
                                        roomDataHtml += `</select>
                                    </div>
                                    <div class="mb-3 mb-lg-1">
                                        <label class="form-label">Tariff</label>
                                        <select class="form-select form-select-sm" id="roomtariff_resvn${resRoomData['id']}" name="roomtariff_resvnEdit[]" onchange="getRoomTariff(this.value,${resRoomData['id']},1)" ${resRoomData['status'] == 'Check-out'? 'disabled':''}>
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
                                        if (resRoomData['room_alloted'] == "NA") {
                                            roomDataHtml += `<option value="NA">NA</option>`;
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
                                        <select class="form-select form-select-sm" id="adults_resvn${resRoomData['id']}" name="adults_resvnEdit[]" ${resRoomData['status'] == 'Check-out'?'disabled':''}>`;
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
                                            <input class="form-control form-control-sm w-120" type="text" id="amount_resvn${resRoomData['id']}"  value="${resRoomData['amount']}" name="amount_resvnEdit[]" oninput="allCalculation(1)">
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

                        console.log($('.reservation_edit_status').html());
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

                        // console.log(checkin_record);
                        // console.log(checkout);
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

                let payment_log = '';
                response.resrvationpaymentdetails.forEach(function(reservation_payment){
                    total_received += parseInt(reservation_payment['amount']);
                    payment_log = `<tr>
                                    <td>${reservation_payment['date']}</td>
                                    <td>₹ ${reservation_payment['amount']}</td>
                                    <td>${reservation_payment['mode']}</td>
                                    <td>${reservation_payment['recorded_by']}</td>
                                </tr>`;
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

                // Guest Detail
                let guest_rooms = '';
                response.guestRoom.forEach(function(guestRooms){
                    guestRooms.guests.forEach(function(guestAll){
                        if(guestAll.isPrimary == 1){
                            $('#name_g_rsv_add_new').val(guestAll.first_name);
                            $('#mobile_g_rsv_add_new').val(guestAll.mobile);
                            $('#gender_g_rsv_add_new').val(guestAll.gender);
                            $('#doc_g_rsv_add_new').val(guestAll.document_type);
                            $('#idnum_g_rsv_add_new').val(guestAll.id_number);
                        }else{
                            guest_rooms +=`<div class="room-guest-bar border-radius-4 d-flex flex-wrap my-2 px-3 py-2 justify-content-between align-items-center bg-light g-tab-element addroomguest">
                            <div class="container me-2">
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3 mb-lg-1">
                                            <label class="form-label text-dark" for="name_g_rsv_add">Name</label>
                                            <input class="form-control form-control-sm" id="name_g_rsv_add${guestAll.id}" name="name_g_rsv_add[]" type="text" oninput="validateField('#name_g_rsv_add${guestAll.id}','input','.name_g_rsv_add_class')" required="" value="${guestAll.first_name}">
                                            <div class="name_g_rsv_add_class"></div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 mb-lg-1">
                                            <label class="form-label text-dark" for="mobile_g_rsv_add">Mobile Number</label>
                                            <input class="form-control form-control-sm" id="mobile_g_rsv_add${guestAll.id}" name="mobile_g_rsv_add[]" type="number" oninput="handleInput_mobile_g_rsv_add()" required="" value="${guestAll.mobile}">
                                            <div class="mobile_g_rsv_add_class"></div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 mb-lg-1">
                                            <label class="form-label text-dark">Gender</label>
                                                <select class="form-select" form-control-sm"="" id="gender_g_rsv_add${guestAll.id}" name="gender_g_rsv_add[]" type="text">
                                                <option value="">Select</option>
                                                <option value="Male" ${guestAll['gender'] == "Male" ? 'selected' : ''}>Male</option>
                                                <option value="Female" ${guestAll['gender'] == "Female" ? 'selected' : ''}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 mb-lg-1">
                                                <label class="form-label text-dark">Document Type</label>
                                                <select class="form-select form-select-sm" id="doc_g_rsv_add${guestAll.id}" name="doc_g_rsv_add[]" >
                                                <option value="">Select</option>
                                                <option value="Aadhar Card" ${guestAll['document_type'] == "Aadhar Card" ? 'selected' : ''}>Aadhar Card</option>
                                                <option value="Pan Card" ${guestAll['document_type'] == "Pan Card" ? 'selected' : ''}>Pan Card</option>
                                                <option value="Voter ID" ${guestAll['document_type'] == "Voter ID" ? 'selected' : ''}>Voter ID</option>
                                                <option value="Passport" ${guestAll['document_type'] == "Passport" ? 'selected' : ''}>Passport</option>
                                                <option value="Driving Licence" ${guestAll['document_type'] == "Driving Licence" ? 'selected' : ''}>Driving Licence</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 mb-lg-1">
                                            <label class="form-label text-dark">Id Number</label>
                                            <input class="form-control form-control-sm" id="idnum_g_rsv_add${guestAll.id}" name="idnum_g_rsv_add[]" type="text" maxlength="15" oninput="this.value=this.value.slice(0,15)" value="${guestAll.id_number}">
                                            <div class="email_g_rsv_class"></div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="mb-3 mb-lg-1">
                                            <label class="form-label text-dark">Id Proof 123</label>
                                            <input class="form-control form-control-sm" name="idproof_g_rsv_add[]" type="file" >
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center g-tab-remove1" style="width:20px;height:20px;margin-top: 33px;" onclick="deleteGuestRow(this)">
                                        <i class="icon-close bg-danger p-1 rounded-circle formclosebtn1" style="font-size:10px"></i>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                        }
                    })
                });
                $('.add_new_guest').html(guest_rooms);
                $('.recored-payment-log').html(payment_log);

                let log = '';
                response.activity_logs.forEach(function(activity_log){ 
                    log += `<li>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 bg-dark-color">
                                        <i class="fa fa-check-circle"></i>
                                    </div>
                                    <div class="flex-grow-1 d-flex">
                                        <div>
                                            <a href="">
                                                <h6 class="fw-normal"> ${activity_log.activity} </h6>
                                                <p> ${activity_log.activity_by} </p>
                                            </a>  
                                        </div>
                                        <div class="ms-5">
                                            <span> ${activity_log.date} </span>
                                        </div>
                                    </div>
                                </div>
                            </li>`;
                });
                $('.reservation-log').html(log);

                let kot_payment = '';
                let count_pending_payment = 0;
                response.kot_detail.forEach(function(kot_detail_view){
                    kot_payment +=`<tr>
                                    <td>${kot_detail_view.order_time}</td>
                                    <td class="text-end"><span class="me-1">₹</span>${kot_detail_view.sub_total} </td>
                                    <td class="text-end"><span class="me-1">₹</span>${kot_detail_view.total_gst}</td>
                                    <td class="text-end"><span class="me-1">₹</span>${kot_detail_view.grand_total}</td>
                                    <td class="text-end">`;
                                    if(kot_detail_view.payment_type == 'Due' || kot_detail_view.payment_type == 'Complete with Due'){
                                        count_pending_payment++;
                                        kot_payment +=`<button class="btn btn-primary" onClick="recordKotPayment(${kot_detail_view.id})">Record Payment</button>`;
                                    }
                                    kot_payment +=`</td>
                                </tr>`;
                });
                if(count_pending_payment > 1){
                    $('.kot-payments-record-all').removeClass('d-none');
                }else{
                    $('.kot-payments-record-all').addClass('d-none');
                }
                $('.kot-payments-table').html(kot_payment);
                $('.edit_room_reservation_detail').html();
                $('#EditReservation').modal('show');
            }
            else {
                console.log('errror');
            }
        }
    });
}

// Add Guest Tab
function addNewGuest(){

    let newGuest = '';
    newGuest +=`<div class="room-guest-bar border-radius-4 d-flex flex-wrap my-2 px-3 py-2 justify-content-between align-items-center bg-light g-tab-element addroomguest">
                    <div class="container me-2">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3 mb-lg-1">
                                    <label class="form-label text-dark" for="name_g_rsv_add">Name</label>
                                    <input class="form-control form-control-sm" id="name_g_rsv_add" name="name_g_rsv_add[]" type="text" oninput="validateField('#name_g_rsv_add','input','.name_g_rsv_add_class')" required>
                                    <div class="name_g_rsv_add_class"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3 mb-lg-1">
                                    <label class="form-label text-dark" for="mobile_g_rsv_add">Mobile Number</label>
                                    <input class="form-control form-control-sm" id="mobile_g_rsv_add" name="mobile_g_rsv_add[]" type="number"  oninput="handleInput_mobile_g_rsv_add()" required>
                                    <div class="mobile_g_rsv_add_class"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3 mb-lg-1">
                                    <label class="form-label text-dark">Gender</label>
                                    <select class="form-select"form-control-sm" id="gender_g_rsv_add" name="gender_g_rsv_add[]" type="text">
                                        <option value="">Select</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3 mb-lg-1">
                                    <label class="form-label text-dark">Document Type</label>
                                    <select class="form-select form-select-sm" id="doc_g_rsv_add" name="doc_g_rsv_add[]">
                                        <option value="">Select</option>
                                        <option value="Aadhar Card">Aadhar Card</option>
                                        <option value="Pan Card">Pan Card</option>
                                        <option value="Voter ID">Voter ID</option>
                                        <option value="Passport">Passport</option>
                                        <option value="Driving Licence">Driving Licence</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3 mb-lg-1">
                                    <label class="form-label text-dark">Id Number</label>
                                    <input class="form-control form-control-sm" id="idnum_g_rsv_add" name="idnum_g_rsv_add[]" type="email" maxlength="15" oninput="this.value=this.value.slice(0,15)" >
                                    <div class="email_g_rsv_class"></div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3 mb-lg-1">
                                    <label class="form-label text-dark">Id Proof 55</label>
                                    <input class="form-control form-control-sm" name="idproof_g_rsv_add[]" type="file" accept="image/*">
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-center g-tab-remove1" style="width:20px;height:20px;margin-top: 33px;" onclick="deleteGuestRow(this)">
                                    <i class="icon-close bg-danger p-1 rounded-circle formclosebtn1" style="font-size:10px"></i>
                            </div>
                        </div>
                    </div>
                </div>`;
    $('.add_new_guest').append(newGuest);

}

function deleteGuestRow(element){
    $(element).closest('.room-guest-bar').remove();
    if ($('.room-guest-bar').length === 0) {
        $('.submitNewroomguest_btn').addClass('d-none');
    }
}

function submitRoomGuests(id, resid){
    
    let name_guest_add = validateField("#name_g_rsv_add","input",".name_g_rsv_add_class");
    let mobile_guest_add = validateField("#mobile_g_rsv_add","mobile",".mobile_g_rsv_add_class");

    if(name_guest_add === true && mobile_guest_add == true){

        let form = document.getElementById("guestForm");
        let formData = new FormData(form);
        formData.append('reservation_id', resid);
        formData.append('roomid', id);

        $.ajax({
            url: submitroomguestData,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log(response);
            }
        });
    }

}

function submitRoomGuestNotes(resid) {
    
    let notes = $("#roomGuestNotes").val();
    
    $.ajax({
        url: roomguestnoteData,
        type: "POST",
        data: { reservationid: resid, notes: notes },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
        },
    });
}

function addPrimaryAsGuest(){

    $('#name_g_rsv_add_new').val(currentReservationDetail.first_name+' '+currentReservationDetail.last_name);
    $('#mobile_g_rsv_add_new').val(currentReservationDetail.mobile);
    $('#idnum_g_rsv_add_new').val(currentReservationDetail.id_number);
    $('#doc_g_rsv_add_new').html(` <option value="Adhar Card" ${currentReservationDetail['document_type'] == "Aadhar Card" ? 'selected' : ''}>Aadhar Card</option>
                            <option value="Pan Card" ${currentReservationDetail['document_type'] == "Pan Card" ? 'selected' : ''}>Pan Card</option>
                            <option value="Voter ID" ${currentReservationDetail['document_type'] == "Voter ID" ? 'selected' : ''}>Voter ID</option>
                            <option value="Passport" ${currentReservationDetail['document_type'] == "Passport" ? 'selected' : ''}>Passport</option>
                            <option value="Driving Licence" ${currentReservationDetail['document_type'] == "Driving Licence" ? 'selected' : ''}>Driving Licence</option>`);
    $('#gender_g_rsv_add_new').html(`<option value="">Select Gender</option>
                                    <option value="Male" ${currentReservationDetail['gender'] == "Male" ? 'selected' : ''}>Male</option>
                                    <option value="Female" ${currentReservationDetail['gender'] == "Female" ? 'selected' : ''}>Female</option>`);
 }

//check the box of rooms for particular checkout
function roomCheckData(roomIDs) {
    if (roomCheck_Ids.includes(parseInt(roomIDs))) {
        let id_index = roomCheck_Ids.indexOf(roomIDs);
        roomCheck_Ids.splice(id_index, 1);
        allCalculation(1);
    } else {
        roomCheck_Ids.push(parseInt(roomIDs));
        allCalculation(1);
    }
}

function cancelReservationData(reservation_id=''){

    Swal.fire({
        title: "Are you sure to Cancel Reservation?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Cancel it",
    }).then((result) => {
        if (result.isConfirmed) {
            let id = reservation_id;
            if(reservation_id == ''){
                id = $('.room_id_checkout').html();
            }
            $.ajax({
                url: cancelReservation,
                type: "POST",
                data: {id: id},
                success: function (response) {
                    if(response.success){
                       // loadreservationdata();
                        $('#EditReservation').modal('hide');
                        $('.alert_msg').html('Selected Reservation Successfully Cancelled');
                        var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                        toast.show();
                        setTimeout(() => {
                            window.location.reload();
                        },2500);
                    }
                },
            });
        }
    });

}

function addNoteReservation(x){
    notesReservation = x;
}

function receiveReservationPayment(last,reservation,x){
    $('#audit_reservation_amount').val(0);
    let roomCheck = [];
    roomCheck.push(x) ;
    $('#auditCollectPayment').modal('show');
    $('.audit_reservation_id').val(x);
    $('#audit_reservation_paid_amount').val(last);
    $('#audit_reservation').val(reservation);
    
    $.ajax({
        url: getPaymentDetail,
        type: "POST",
        data: {reservation_id: reservation,roomCheck_Ids:roomCheck},
        success: function (response) {
            $('#audit_reservation_amount').val(response.amount);
        },
    });
    
}

$('#audit_collect_reservation_payment').on('submit', function(e) {
   
    e.preventDefault();
    let reservation_id = $('#audit_reservation').val();
    let id = $('.audit_reservation_id').val();
    let amount = $('#audit_reservation_amount').val();
    let mode = $('#audit_reservation_pmode').val();
    let txn = $('#audit_reservation_txn').val();

    if (amount <= 0) {
        toastErrorAlert('Invalid Amount');
        $('needs-validation').addClass('was-validated');
    }else if (mode == '') {
        $('needs-validation').addClass('was-validated');
    }else if (mode != '1' && txn == '') {
        $('needs-validation').addClass('was-validated');
    }else {
        $.ajax({
            url: recordReservationPayment,
            type: "POST",
            data: { reservationid:reservation_id,id:id,amount:amount,mode:mode,txn:txn },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#auditCollectPayment').modal('hide');
                toastSuccessAlert(response.success);
                setTimeout(() => {
                    window.location.reload();
                },2500);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    }

});

$('#audit_reservation_pmode').on('change',function(e){
    e.preventDefault();
    let pmode = $('#audit_reservation_pmode').val();
     if(pmode == '1' || pmode == ''){
        $('.txnVisibility').addClass('d-none');
     }else{
        $('.txnVisibility').removeClass('d-none');
     }
});

function recordKotPayment(x){
    Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, confirm it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: recordKotReservationPayment,
                type: "POST",
                data: {kot_id: x},
                success: function (response) {
                    // alert('recorded');
                    if(response.success){
                        toastSuccessAlert(response.success);
                        setTimeout(() => {
                            window.location.reload();
                        },2000);
                    }
                }
            });
        }
    });
}

function checkroomchecked(){

    if(roomCheck_Ids.length === 0) {
        $('.paymentRec-Dtab-detail').css({"right":"0px", "opacity":"0"});
        $('.paymentRec-Dtab-payment').css({"right":"0px", "opacity":"0"});
        $('.paymentRec-Dtab-notes').css({"right":"0px", "opacity":"0"});
        $('.paymentRec-Dtab-kot').css({"right":"0px", "opacity":"0"});
        $('#dtab-showbtn').css("opacity","0");
        
        Swal.fire({
            title: "No Rooms Selected",
            text: "Please select one room to proceed with Payment.",
            icon: "warning",
            confirmButtonText: "OK"
        });
    }else{
        let reservation_id = $('.reservation_id_checkout').html();
        $.ajax({
            url: getPaymentDetail,
            type: "POST",
            data: {reservation_id: reservation_id,roomCheck_Ids:roomCheck_Ids},
            success: function (response) {
                $('#payment_date_outside_rsv').val(response.date);
                if(response.amount > 0){
                    $('.amount_o_rsv').val(response.amount);
                    // $('.paymentRec-Dtab').css({"right":"100%", "opacity":"1"});
                    $('.paymentRec-Dtab-detail').css({"right":"100%", "opacity":"1"});
                    $('.paymentRec-Dtab-payment').css({"right":"100%", "opacity":"1"});
                    $('.paymentRec-Dtab-notes').css({"right":"100%", "opacity":"1"});
                    $('.paymentRec-Dtab-kot').css({"right":"100%", "opacity":"1"});
                    $('#dtab-showbtn').css("opacity","0");
                }else{
                    $('.paymentRec-Dtab-detail').css({"right":"0px", "opacity":"0"});
                    $('.paymentRec-Dtab-payment').css({"right":"0px", "opacity":"0"});
                    $('.paymentRec-Dtab-notes').css({"right":"0px", "opacity":"0"});
                    $('.paymentRec-Dtab-kot').css({"right":"0px", "opacity":"0"});
                    $('#dtab-showbtn').css("opacity","0");
                    $('.amount_o_rsv').val(0);
                }
            },
        });
    }
}

// -----------------------------------Edit Reservation Details Update-----------------------------------------------

function updateReservation() {
    let checkin = $("#res_checkin_Edit").val();
    
    let name_resvn_EditValid = validateField("#first_name_resvn_edit","inut",".first_name_resvn_edit_class");
    let mobile_resvn_EditValid = validateField("#mobile_resvn_edit","mobile",".mobile_resvn_edit_class");
    let state_resvn_EditValid = validateField("#state_resvn_edit","input",".state_resvn_edit_class");
    let pin_resvn_EditValid = validateField("#pin_resvn_edit","pin",".pin_resvn_edit_class");
    let doc_type_resvn_EditValid = validateField("#documenttype_resvn_edit","select",".documenttype_resvn_edit_class");
    let id_num_resvn_EditValid = validateField("#idnumber_resvn_edit","input",".idnumber_resvn_edit_class");

    if (name_resvn_EditValid === true && mobile_resvn_EditValid === true && state_resvn_EditValid === true && pin_resvn_EditValid === true && doc_type_resvn_EditValid === true && id_num_resvn_EditValid === true){
        $('.update_res_Btn').addClass('d-none');
        $('.res_update_loader').removeClass('d-none');

        let roomEditID = $("input[name='room_idEdit[]']").map(function () {return $(this).val();}).get();
        let roomcateEdit = $("select[name='roomcate_resvnEdit[]']").map(function () {return $(this).val();}).get(); 
        let room_typeEdit = $("select[name='roomtype_resvnEdit[]']").map(function () {return $(this).val();}).get();
        let room_tariffEdit = $("select[name='roomtariff_resvnEdit[]']").map(function () {return $(this).val();}).get();
        let roomNumEdit = $("select[name='roomno_resvnEdit[]']").map(function () {return $(this).val();}).get();
        let adultsEdit = $("select[name='adults_resvnEdit[]']").map(function () {return $(this).val();}).get();
        let childrensEdit = $("select[name='childrens_resvnEdit[]']").map(function () {return $(this).val();}).get();
        let infantsEdit = $("select[name='infants_resvnEdit[]']").map(function () {return $(this).val();}).get();
        let amountEdit = $("input[name='amount_resvnEdit[]']").map(function () {return $(this).val();}).get();
        let extraPerEdit = $("input[name='extraperson_resvnEdit[]']").map(function () {return $(this).val();}).get();
        let extraPerEditAmount = $("input[name='extrapersonAmount_resvnEdit[]']").map(function () {return $(this).val();}).get();
        let id_proof = $('#photo_resvn_edit').prop('files')[0];

        var formData = new FormData();
        formData.append('reservation_id', $('.reservation_id_checkout').html());
        formData.append('checkout', $('#res_checkout_Edit').val());
        formData.append('checkin', $('#res_checkin_Edit').val());
        formData.append('first_name', $('#first_name_resvn_edit').val());
        formData.append('last_name', $('#last_name_resvn_edit').val());
        formData.append('mobile', $('#mobile_resvn_Edit').val());
        formData.append('gender', $('#gender_resvn_edit').val());
        formData.append('email', $('#email_resvn_edit').val());
        formData.append('guest', $('#guest_type_resvn_edit').val());
        formData.append('allergic_to', $('#allergic_to_resvn_edit').val());
        formData.append('address', $('#address_resvn_edit').val());
        formData.append('city', $('#city_resvn_edit').val());
        formData.append('state', $('#state_resvn_edit').val());
        formData.append('pincode', $('#pin_resvn_edit').val());
        formData.append('country', $('#country_resvn_edit').val());
        formData.append('coming_from', $('#coming_from_resvn_edit').val());
        formData.append('going_to', $('#going_to_resvn_edit').val());
        formData.append('purpose_of_visit', $('#purpose_of_visit_resvn_edit').val());
        formData.append('document_type', $('#documenttype_resvn_edit').val());
        formData.append('other_detail', $('#otherdetail_resvn_edit').val());
        formData.append('id_number', $('#idnumber_resvn_edit').val());
        formData.append('company_name', $('#companyname_resvn_edit').val());
        formData.append('company_gst', $('#companygst_resvn_edit').val());
        formData.append('company_address', $('#companyaddress_resvn_edit').val());
        formData.append('company_pincode', $('#companypincode_resvn_edit').val());
        formData.append('company_state', $('#companystate_resvn_edit').val());

        formData.append('gstLegalName', $('#gstLegalName_edit').val());
        formData.append('gstAddrBnm', $('#gstAddrBnm_edit').val());
        formData.append('gstAddrBno', $('#gstAddrBno_edit').val());
        formData.append('gstAddrFlno', $('#gstAddrFlno_edit').val());
        formData.append('gstAddrSt', $('#gstAddrSt_edit').val());
        formData.append('gstAddrLoc', $('#gstAddrLoc_edit').val());
        formData.append('gstTxpType', $('#gstTxpType_edit').val());
        formData.append('gstStatus', $('#gstStatus_edit').val());
        formData.append('gstBlkStatus', $('#gstBlkStatus_edit').val());
        formData.append('gstDtReg', $('#gstDtReg_edit').val());
        formData.append('gstDtDReg', $('#gstDtDReg_edit').val());
        formData.append('gstTradeName', $('#gstTradeName_edit').val());
        formData.append('gstStateCode', $('#gstStateCode_edit').val());
        formData.append('gstAddrPncd', $('#gstAddrPncd_edit').val());
        formData.append('gstAddr', $('#gstAddr_edit').val());
        
        formData.append('arrival_time', $('#arrivaltime_resvn_edit').val());
        formData.append('id_proof', id_proof);
        formData.append('room_id[]', roomCheck_Ids);
        
        for(i = 0; i < roomEditID.length; i++){
            formData.append('roomEditID[]', roomEditID[i]);
            formData.append('roomcateEdit[]', roomcateEdit[i]);
            formData.append('room_typeEdit[]', room_typeEdit[i]);
            formData.append('room_tariffEdit[]', room_tariffEdit[i]);
            formData.append('roomNumEdit[]', roomNumEdit[i]);
            formData.append('adultsEdit[]', adultsEdit[i]);
            formData.append('childrensEdit[]', childrensEdit[i]);
            formData.append('infantsEdit[]', infantsEdit[i]);
            formData.append('amountEdit[]', amountEdit[i]);
            formData.append('extraPerEdit[]', extraPerEdit[i]);
            formData.append('extraPerEditAmount[]', extraPerEditAmount[i]);
        }

        $.ajax({
            url: editReservationUpdate,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {

                let reservationID = $('.reservation_id_checkout').html();
                let ids = $("input[name='room_idEdit[]']").length;
                let room_type = $("select[name='roomtype_resvnEdit[]']").length;

                if(ids != room_type){
                    EditRoomResSubmit(reservationID);
                }

                let guest_room_id = $('.guest_room_id').text();
                if(notesReservation != ''){
                    submitRoomGuestNotes(reservationID); // update notes
                }
                let name = $("input[name='name_g_rsv_add[]']").map(function () {return $(this).val();}).get();
                if(name.length > 0){
                    submitRoomGuests(guest_room_id,reservationID);
                }

                if (data.success) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: data.success,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    // let reload_reservation_duration = $(".reload_reservation_duration").html();
                    // loadreservationdata(reload_reservation_duration, 2);
                    // $("#EditReservation .modal-body").html(""); // Clear previous content
                    $("#EditReservation").modal("hide");
                    $('.res_update_loader').addClass('d-none');
                    $('.update_res_Btn').removeClass('d-none');
                } else if (data.error_success) {
                    alert(data.error_success);
                    $('.res_update_loader').addClass('d-none');
                    $('.update_res_Btn').removeClass('d-none');
                } else {
                    alert("Something went wrong");
                    $('.res_update_loader').addClass('d-none');
                    $('.update_res_Btn').removeClass('d-none');
                }
            },
        });
    }else{
        Swal.fire({
            icon: "error",
            title: "Required Field",
            text: "Fill all required field",
        });
        return;
    }
}
