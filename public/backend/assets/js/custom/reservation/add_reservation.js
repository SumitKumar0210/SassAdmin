
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

$('#reservation_form #checkinSwitch').on('change', function() {
    if ($(this).is(':checked')) {
        // Bulk checkin selected
        $('#reservation_form .add-more-room').removeClass('d-none');
    } else {
        // Single checkin selected
        $('#reservation_form .add-more-room').addClass('d-none');
    }
});

let skipRoomRequired = false;

$('#reserveBtn').on('click', function () {
    $('select[name="roomno_resvn[]"]').each(function () {
        this.required = false;
    });
});

$('#checkinBtn').on('click', function () {
    $('select[name="roomno_resvn[]"]').each(function () {
        this.required = true;
    });
});

// -----------------------------------New Reservation Submit-----------------------------------------------
$("#reservation_form").on("submit", function (event) {
    event.preventDefault();
    
    let checkin = $("#checkin_resvn").val();
    const enteredDate = new Date(checkin);
    const today = new Date();
    const currentDate = new Date(today.getFullYear(), today.getMonth(), today.getDate());
    // Compare dates
    if (!(enteredDate.getFullYear() === currentDate.getFullYear() && enteredDate.getMonth() === currentDate.getMonth() && enteredDate.getDate() === currentDate.getDate())) {
        let room_number = $("select[name='roomno_resvn[]']").map(function () {return $(this).val();}).get();
        let chkValue = false;
        room_number.forEach(function(cate_rooms){
            if(cate_rooms != 'NA'){
                chkValue = true;
            }
        });
        if(chkValue){
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Only current date room number is allow",
                showConfirmButton: "OK",
                // timer: 3500
            });
            return;
        }
    }

    let isNameValid = validateField("#first_name_resvn", "text", ".first_name_resvn_class");
    let isMobileValid = validateField("#mobile_resvn","mobile",".mobile_resvn_class");
    let isAmount = false;
    if($("#amount_resvn0").val() > 0){
        isAmount = true;
    }
    if (isNameValid === true && isMobileValid === true && isAmount === true) {

        $('.add_res_btn_hide').addClass('d-none');
        $('.new_res_loader').removeClass('d-none');

        let state = $("#companystate_resvn option:selected").text();
        let id_proof = $('#photo_resvn').prop('files')[0];
        let bookingType = 'Single';
        if($('#checkinSwitch').prop('checked')){
            bookingType = 'Bulk';
        }
        var formData = new FormData(this);
        formData.append('room_total_amount', $('.room_total_amount').html());
        formData.append('no_of_nights', $('.no_of_nights').html());
        formData.append('extra_total_person', $('.extra_total_person').html());
        formData.append('total_final_res_amount', $('.total_final_res_amount').html());
        formData.append('total_discount_percentage', $('.total_discount_percentage').val());
        formData.append('total_subtotal', $('.total_subtotal').val());
        formData.append('total_advance_amount', $('.total_advance_amount').val());
        formData.append('total_received', $('.total_received').html());
        formData.append('total_outstanding', $('.total_outstanding').html());
        formData.append('state', state);
        formData.append('id_proof', id_proof);
        formData.append('bookingType', bookingType);

        $.ajax({
            url: reservationCreate, // PHP script to handle the upload
            type: 'POST',
            data: formData,
            contentType: false, // Important: Don't set content type
            processData: false, // Important: Don't process the data
            success: function(response) {
                $('#response').html(response); // Display response from PHP
                if(response.success){

                    $('#reservation').modal('hide');
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        text: "Reservation Created Successfully",
                        showConfirmButton: false,
                        timer: 4000,
                    });
                    setTimeout(() => {
                        window.location.href = '../../reservation-new';
                    }, 2500);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

    }else{
        toastErrorAlert('Room Amount is invalid ');
    }
});

// reservation notes
$("#edit_reservation_form").on("submit", function (event) {
    event.preventDefault();

    // edit_reservation_notes
    let form = document.getElementById("edit_reservation_form");
    let formData = new FormData(form);
    formData.append('reservation_id', $(".reservation_id_checkout").val());
    formData.append('gstAddr', $('#gstAddr_edit').val());

    $.ajax({
        url: editReservationUpdate,
        type: "POST",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (data) {
            if(data.success){
                toastSuccessAlert(data.success);
                setTimeout(() => {
                    window.location.reload();
                },2500);
            }
        }
    });
});

// reservation notes
$("#edit_reservation_form_note").on("submit", function (event) {
    event.preventDefault();

    // edit_reservation_notes
    let notes = $("#roomGuestNotes").val();
    let resid = $(".reservation_id_checkout").val();
    
    $.ajax({
        url: roomguestnoteData,
        type: "POST",
        data: { reservationid: resid, notes: notes },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if(response.success){
                toastSuccessAlert(response.success);
            }
        },
    });
});

// reservation guest
$("#guestForm").on("submit", function (event) {
    event.preventDefault();

    let resid = $(".reservation_id_checkout").val();
    let id = $(".room_id_checkout").val();
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
            if(response.success){
                toastSuccessAlert(response.success);
                setTimeout(() => {
                    window.location.reload();
                },2500);
            }
        }
    });
});

function printKotRes(x){
    let url = '../../kot/print-kot-invoice/'+x;
    window.open(url,'_blank');
}

function reservationAdvMode(x){
    if(x > 1){
        $('.reservation-Adv-Mode').removeClass('d-none');
    }else{
        $('.reservation-Adv-Mode').addClass('d-none');
    }
}
// 5656789098
function searchCustomer(){
    $('#first_name_resvn').val('');
    $('#last_name_resvn').val('');
    $('.name_resvn_class').html('');
    $('#mobile_resvn').val('');
    $('#email_resvn').val('');
    $('#gender_resvn').val('');
    $('#allergic_to_resvn').val('');
    
    $('#address_resvn').val('');
    $('#city_resvn').val('');
    $('#state_resvn').val('');
    $('#pin_resvn').val('');
    $('#country_resvn').val('');
    
    $('#documenttype_resvn').val('');
    $('#idnumber_resvn').val('');
    $('#companyname_resvn').val('');
    
    $('#companygst_resvn').val('');
    $('#companyaddress_resvn').val('');
    $('#companypincode_resvn').val('');
    $('#companystate_resvn').val('');
    $('#roomtype_resvn0').val('');

    let mobile = $('#search_mobile_resvn').val();
    $.ajax({
        url: addDataUsingPhone,
        type: "POST",
        data: {
            mobile: mobile,
        },
        success: function(response) {
            console.log(response);
            let output = ``;
            $('.new-user-reservation').empty();
            $('.previous-checkin-detail').empty();
            if(response.last_reservation.length > 0){
                
                output +=`<table class="table">
                <thead>
                    <tr>
                        <th>Sl. No</th>
                        <th>Reservation</th>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Tariff Type</th>
                        <th>Checkin Date</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>`;
                response.last_reservation.forEach(function(element,key) {
                    output +=`<tr>
                        <td>${++key}</td>
                        <td>${element.reservation}</td>
                        <td>${element.room}</td>
                        <td>${element.category}</td>
                        <td>${element.tariff}</td>
                        <td>${element.checkin}</td>
                        <td>
                            <div class="form-check radio radio-secondary radio-in-square">
                                <input class="form-check-input" type="radio" id="radio${key}" name="radio1" value="option1" onClick="setTypeTariff(${element.category_id},${element.tariff_id})" style="border-radius:0%;">
                                <label class="form-check-label " for="radio${key}" ></label>
                            </div>
                        </td>
                    </tr>`;
                });
                output +=`</tbody></table>`;
            }
            if(response.resDetails.length > 0){
                let getData = response.resDetails[0];
                $('#first_name_resvn').val(getData['first_name']).removeClass("is_field_invalid");
                $('#last_name_resvn').val(getData['last_name']).removeClass("is_field_invalid");
                
                $('.name_resvn_class').html('');
                $('#mobile_resvn').val(getData['mobile']);
                $('#email_resvn').val(getData['email']);
                $('#gender_resvn').val(getData['gender']);
                $('#allergic_to_resvn').val(getData['allergic_to']);
                
                $('#address_resvn').val(getData['address']);
                $('#city_resvn').val(getData['city']);
                $('#state_resvn').val(getData['state']);
                $('#pin_resvn').val(getData['pincode']);
                $('#country_resvn').val(getData['country']);
                
                $('#documenttype_resvn').val(getData['proof_type']);
                $('#idnumber_resvn').val(getData['id_proof']);
                $('#companyname_resvn').val(getData['company_name']);
                if(response.company.length > 0){
                    let getDataC = response.company[0];
                    $('#last_company_id').val(getDataC['id']);
                    $('#last_company').val(getDataC['name']);
                    $('#last_GST').val(getDataC['Gstin']);
                    $('#last_addr').val(getDataC['address']);
                }

                $('.custom-dropdown-item').css('display','none');
            }else{
                $('#mobile_resvn').val(mobile);
                $('.new-user-reservation').html('<i>Looks like this is a new customer.</i>');
            }
            $('.previous-checkin-detail').html(output);
        }
    });
}

// set predefine tariff
function setTypeTariff(category,tariff){
    $('#roomtype_resvn0').val(category);
    if(category != ''){
        getroomoccupancy(category,0)
    }
    $('#roomtariff_resvn0').val(tariff);
    if(tariff != ''){
        getRoomTariff(tariff,0);
    }
}

$('input[name="bookingBy"]').on("click", function (event) {
    //event.preventDefault();
    let type = $('input[name="bookingBy"]:checked').val();
    $('#reservation_booked_by_name').val('');
    $('#reservation_booked_by_mobile').val('');
    $('#reservation_booked_by_email').val('');
    $('#reservation_booked_by_remark').val('');
    if(type == 'Company'){
        let company_name = '';
        if($('#gstLegalName').val() != ''){
            company_name = $('#gstLegalName').val();
        }else if($('#companyname_resvn').val() != ''){
            company_name = $('#companyname_resvn').val();
        }else if($('#last_company').val() != ''){
            company_name = $('#last_company').val();
        }
        $('#reservation_booked_by_name').val(company_name);
    }else if(type == 'Self'){
        $('.booking_madeby_detail').addClass('d-none');
        $('#reservation_booked_by_name').val($('#first_name_resvn').val());
        $('#reservation_booked_by_mobile').val($('#mobile_resvn').val());
        $('#reservation_booked_by_email').val($('#email_resvn').val());
    }
    if(type != 'Self'){
        $('.booking_madeby_detail').removeClass('d-none');
    }
});

function setBookingBy(){
    let type = $('input[name="bookingBy"]:checked').val();
    if(type == 'Self'){
        $('#reservation_booked_by_name').val($('#first_name_resvn').val());
        $('#reservation_booked_by_mobile').val($('#mobile_resvn').val());
        $('#reservation_booked_by_email').val($('#email_resvn').val());
    }
}
let companyLists = [];
function getCompanyList(){

    let company_name = $('#last_company').val();
    if(company_name.length > 5){
        
        $.ajax({
            url: companyGstList,
            type: "POST",
            data: {
                company_name: company_name,
            },
            success: function(response) {
                // console.log(response);
                companyLists = [];
                let itemCompanyList = $('#itemCompanyList');
                itemCompanyList.empty(); // Clear previous options
                if (response.length > 0) {
                    const dropdownContainer = $('<div>', { class: 'custom-dropdown' });

                    response.forEach(resData => {
                        companyLists.push(resData);
                        $('<div>', {
                            class: 'custom-dropdown-item',
                            text: `${resData.name}`,
                            click: () => {
                                getAllDetailCompany(resData.id); // Fetch and append reservation data for the selected item
                            }
                        }).appendTo(dropdownContainer);
                    });

                    itemCompanyList.append(dropdownContainer);
                }
            }
        });
    }else{
        $('#last_company_id').val('');
        // $('#last_company').val('');
        $('#last_GST').val('');
        $('#last_addr').val('');
        $('.company_name_error_class').html('Minimum 5 character');
    }
}

function addNewCompany(){
    $('.add-new-company').removeClass('d-none');
    $('#b2bCompany').show();
}

function getAllDetailCompany(id){

    $('#itemCompanyList').empty();
    $('.company_name_error_class').html('');
    companyLists.forEach(resData => {
        if(id == resData.id){
            
            $('#last_company_id').val(id);
            $('#last_company').val(resData.name);
            $('#last_GST').val(resData.Gstin);
            $('#last_addr').val(resData.address);
        }
    });
}