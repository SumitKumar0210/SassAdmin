
$('.clearCacheBtn').on('click',function(){
    $.ajax({
        url: '/clear-cache',
        type: 'GET',
        success: function(response) {
            $('.alert_msg').html(response.success);
            var toast = new bootstrap.Toast(document.getElementById('liveToast'));
            toast.show();
        },
        error: function(xhr) {
            $('.alert_msg').html('An error occurred while clearing the cache.');
            var toast = new bootstrap.Toast(document.getElementById('liveToast'));
            toast.show();
        }
    });
});
// Initialize all tooltips on the page
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
});
// ----------------------------Bootstrap Validation-------------------
(() => {
    "use strict";

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll(".needs-validation");
    // Loop over them and prevent submission
    Array.from(forms).forEach((form) => {
        form.addEventListener(
            "submit",
            (event) => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add("was-validated");
            },
            false
        );
    });
})();

// Hide popup on close button click
$(".closeResbtn").click(function () {
    $(".resbox").hide();
});

// Hide popup on cancel button click
$("#cancelReservation").click(function () {
    $(".resbox").hide();
});

$('body').on('click', '.cell', function() {
    let row_target = $(this).data('key');
    let td_target = $(this).data('j');
    $.each(closerArea,function(key,value){
        if(value['status'] != 0){
            if(value['i'] == row_target){
                let columnValue = value['columnValues'];
                if(columnValue.includes(td_target)){
                   checkRoomClose(value['id']);
                }
            }
        }
    });
    $.each(reserveRoomArea, function(key,reservedRoom){
        if(reservedRoom['i'] == row_target){
            let columnValue = reservedRoom['columnValues'];
            if(columnValue.includes(td_target)){
                if(typeof(reservedRoom['i']) == "number"){
                    // edit_reservation(reservedRoom['id'],reservedRoom['reservation_id']);
                }
            }
        }
    });
});

function initDraggable() {
    $(".draggableTable .draggable").each(function () {
        $(this).attr("draggable", "true");
    });
    const draggableElements = document.querySelectorAll(".draggable");
    draggableElements.forEach((element) => {
        element.addEventListener("dragstart", (e) => {
            const key = $(e.target).closest("td").data("key");
            const j = $(e.target).closest("td").data("j");

            e.dataTransfer.setData("text/plain", e.target.id);
            e.dataTransfer.setData("key", key);
            e.dataTransfer.setData("j", j);
        });
    });
    const tableCells = document.querySelectorAll("td");
    tableCells.forEach((cell) => {
        cell.addEventListener("dragover", (e) => {
            e.preventDefault();
            const keyDropped = $(e.target).closest("td").data("key");
            if (!$(e.target).hasClass("drop-placeholder")) {
                $(e.target).addClass("drop-placeholder");
            }
        });
        cell.addEventListener("dragleave", (e) => {
            $(e.target).removeClass("drop-placeholder");
        });
        cell.addEventListener("drop", (e) => {
            e.preventDefault();
            $(e.target).removeClass("drop-placeholder");
            const data = e.dataTransfer.getData("text/plain");
            const draggedElement = document.getElementById(data);
            const draggedroomId = $(draggedElement).find(".reservationid_drag").text();
            const keyDragged = e.dataTransfer.getData("key");
            const jDragged = e.dataTransfer.getData("j");
            const keyDropped = $(e.target).closest("td").data("key");
            const jDropped = $(e.target).closest("td").data("j");
            let keyDraggedInt = parseInt(keyDragged);
            const textTarget = $(e.target)[0].innerText;
            let refdate = $("#datetime-local").val();
            let number_of_days = $("#selectDays").val();
            if(textTarget !== "" || (keyDraggedInt > 0 && String(keyDropped).includes("unallocated"))){
                Swal.fire({ icon: "error", title: "You can not drop here!" });
                return false;
            }
            let chkExits = false;
            $.each(closerArea,function(key,value){
                if(chkExits == false){
                    if(value['i'] == keyDropped){
                        let columnValue = value['columnValues'];
                        if(columnValue.includes(parseInt(jDragged))){
                            chkExits =true;
                        }
                    }
                }
            });
            if(chkExits){
                Swal.fire({ icon: "error", title: "You can not drop here!" });
                return false;
            }

            if(jDropped != currenct_date_area_key){
                Swal.fire({ icon: "error", title: "You can only drop on the current date!" });
                return false;
            }else{
                $.ajax({
                    url: reservationRoomDetailsUrl,
                    type: "POST",
                    data: {
                        id: draggedroomId,
                        draggedRoom:keyDragged,
                        room: keyDropped,
                        drop: jDropped,
                        refdate: refdate,
                        number_of_days: number_of_days,
                    },
                    success: function (response) {
                        // console.log(response);
                        if(response["error"] != undefined) {
                            Swal.fire({
                                icon: "error",
                                title: "Date Already is in Use",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    resetPage();
                                }
                            });
                        } else {
                            let responseData = response.reservationroomData[0];
                            let getRoomCategory = responseData.room_category;
                            let draggedCheckIn = responseData.checkin;
                            let draggedCheckOut = responseData.checkout;
                            let droppedCatID = response.draggedCategory?.category_id || 0;
                            let roomKeyDragged = String(keyDragged).includes("unallocated")? "unallocated-" + getRoomCategory: keyDragged;
                            const date1 = new Date(draggedCheckIn);
                            const date2 = new Date(draggedCheckOut);
                            const timeDiff = date2 - date1;
                            const dayDifference = timeDiff / (1000 * 60 * 60 * 24);
                            let dropped_date_checkin = datesArray[jDropped].full_date;
                            let dropped_date_new = new Date(dropped_date_checkin);
                            dropped_date_new.setDate(dropped_date_new.getDate() + dayDifference);
                            let dropped_date_checkout = dropped_date_new.toISOString().split("T")[0];
                            $('.checkin_dt').text(dropped_date_checkin);
                            $('.checkout_dt').text(dropped_date_checkout);
                            $("#changeReservation").modal("show");
                            $("#changeReservation .modal-body").html(`
                            <strong>Reservation ID: ${responseData.reservation_id} (${responseData.primary_name})</strong>
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr><th scope="col">From</th><th scope="col">To</th></tr>
                                </thead>
                                <tbody>
                                    <tr> 
                                        <td><span>Stay :</span> <span>${dayDifference} Night</span></td>
                                        <td><span>Stay :</span> <span>${dayDifference} Night</span></td>
                                    </tr>
                                    <tr>
                                        <td><span>Checkin:</span> <span>${response.checkin}</span></td>
                                        <td><span>Checkin:</span> <span>${formatDate(dropped_date_checkin)}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span>Checkout:</span> <span>${response.checkout}</span></td>
                                        <td><span>Checkout:</span> <span>${formatDate(dropped_date_checkout)}</span></td>
                                    </tr>
                                    <tr>
                                        <td><span>Room Category:</span> <span>${response.draggedCategory?.room_category || 'Unallocated'} </span></td>
                                        <td><span>Room Category:</span> <span>${response.droppedCategory?.room_category || 'Unallocated'} </span></td>
                                    </tr>
                                    <tr style="background-color:##d8f5f7">
                                        <td><span>Room No. :</span> <span>${response.draggedCategory?.room_number || 'Unallocated'}</span></td>
                                        <td><span>Room No. :</span> <span>${response.droppedCategory?.room_number || 'Unallocated'}</span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="modal-footer justify-content-between flex-nowrap border-0">
                                <button class="btn btn-outline-secondary w-50" type="button" data-bs-dismiss="modal" onclick="resetPage()">Cancel</button>
                                <button class="btn btn-primary w-50" type="button" onclick="reservation_location('${responseData.id}','${keyDragged}','${jDragged}','${keyDropped}','${jDropped}',${droppedCatID})">Confirm</button>
                            </div>`);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(xhr.responseText);
                    },
                });
            }
        });
    });
}

function formatDate(dateString) {
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    const [year, month, day] = dateString.split("-");
    return `${day}-${months[parseInt(month) - 1]}-${year}`;
}

// Add the following CSS for visual indication
const style = document.createElement("style");
style.innerHTML = `
  .drop-placeholder {
      border: 2px dashed rgb(155, 153, 153) !important;
  }
`;
document.head.appendChild(style);

function findCellIndicesByDate(
    dates,
    checkin_targetDate,
    chechin_formattedMonth,
    checkout_targetDate,
    chechout_formattedMonth
) {
    let indices = [];
    for (let i = 0; i < dates.length; i++) {
        if (
            dates[i].date.includes(checkin_targetDate) &&
            dates[i].month.includes(chechin_formattedMonth)
        ) {
            indices.push(i);
        }
    }
    return indices;
}

function findAllotedCellIndices(dates, close_start_date, close_end_date) {
    const dateArray = [];
    let currentDate = new Date(close_start_date);
    while (currentDate <= new Date(close_end_date)) {
        const date = new Date(currentDate);
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, "0");
        const day = String(date.getDate()).padStart(2, "0");
        // Format the date as YYYY-MM-DD
        const formattedDate = `${year}-${month}-${day}`;
        dateArray.push(formattedDate);
        currentDate.setUTCDate(currentDate.getUTCDate() + 1);
    }
    let indice = "";
    let createBefore = "";
    for (let i = 0; i < dates.length; i++) {
        if (dateArray.includes(dates[i].full_date)) {
            if (createBefore == "") {
                indice = i;
                createBefore = "yes";
            }
        }
    }
    return indice;
}

function convertDate(inputDate) {
    // Define the month mappings
    const monthMappings = {
        Jan: "01",
        Feb: "02",
        Mar: "03",
        Apr: "04",
        May: "05",
        Jun: "06",
        Jul: "07",
        Aug: "08",
        Sep: "09",
        Oct: "10",
        Nov: "11",
        Dec: "12",
    };
    // Split the input date
    const [day, month, year] = inputDate.split("-");
    // Convert the date parts into the desired format
    const formattedDate = `${year}-${monthMappings[month]}-${String(
        day
    ).padStart(2, "0")}`;
    return formattedDate;
}

function reservation_location(id, keyDragged, jDragged, keydropped, jDropped,droppedCatID) {
    $.ajax({
        url: reservationRoomDetailData,
        type: "POST",
        data: { id: id },
        success: function (response) {
            if (response.success) {
                let response_Data = response.reservationroomDatas[0];
                let responseID = response_Data["id"];
                let reservationid = response_Data["reservation_id"];
                let dateAtIndex = findDateByIndex(datesArray, jDropped); // to find date where reservation box being dropped
                $.ajax({
                    url: reservatiionRommNumberUpdate,
                    type: "POST",
                    data: {
                        id: responseID,
                        keyDragged: keyDragged,
                        jDragged: jDragged,
                        keydropped: keydropped,
                        jDropped: jDropped,
                        droppedCatID:droppedCatID,
                        dateAtCheckinIndex: dateAtIndex,
                        reservationid: reservationid,
                    },
                    success: function (responseRoom) {
                        if (responseRoom.success) {
                           // updateRoomStatus(keyDragged,keydropped); //update room number status for 2nd View of reservation
                            $("#changeReservation").modal("hide");
                            let reload_reservation_duration = $(".reload_reservation_duration").html();
                            loadreservationdata(reload_reservation_duration, 2);
                        } else {
                            console.log("error");
                        }
                    },
                });
            }
        },
        error: function (xhr, status, error) {
            console.log(error);
        },
    });
}

function findDateByIndex(dates, index) {
    if (index >= 0 && index < dates.length) {
        return dates[index];
    } else {
        return null; // Return null if the index is out of bounds
    }
}

function updateRoomStatus(x,y){
    let checkin_to_date = $('.checkin_dt').text();
    let checkout_to_date = $('.checkout_dt').text();
    $.ajax({
        url:roomstatusupdate,
        type:"POST",
        data:{roomfrom:x,roomto:y,checkin_to:checkin_to_date,checkout_to:checkout_to_date},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(response){
        }
    });
}

function resetPage() {
    let reload_reservation_duration = $(".reload_reservation_duration").html();
    loadreservationdata(reload_reservation_duration, 2);
}

function docTypeValue(value){
    if(value === 'Other'){
        document.getElementById('otherdetail_resvncc').style.display = 'block';
    }else{
        document.getElementById('otherdetail_resvncc').style.display = 'none';
    }
}

function docTypeValue_dynmc(value){
    if(value === 'Other'){
        $('.otherdetail_resvncc').removeClass('d-none');
    }else{
        $('.otherdetail_resvncc').addClass('d-none');
    }
}

//-----------------New Reservation Field Validation
function validateField(fieldId, type, errorClass) {
    let value = $(fieldId).val();
    let field = $(fieldId); // Get the id from the jQuery object
    let field_ID = $(fieldId).attr('id'); // Get the id from the jQuery object
    let error = $(errorClass);
    let label = document.querySelector(`label[for="${field_ID}"]`); // Use the id
    let field_txt ='';
    if(label){
      field_txt = label.textContent; // Corrected property name
    }else{
        field_txt = ''; // Corrected property name
    }
    if (value === "") {
        field.focus();
        field.removeClass("dark-only");
        field.addClass("is_field_invalid");
        error.html(field_txt + " is required").addClass("is_invalid");
        return false;
    } else {
        if (type === "mobile") {
            let isValid = /^[0-9]{10}$/.test(value);
            if (!isValid) {
                field.addClass("is_field_invalid");
                error.text("Must be 10 digits").addClass("is_invalid");
                return false;
            } else {
                field.removeClass("is_field_invalid");
                error.html("");
                return true;
            }
        } else if (type === "select") {
            if (value !== "") {
                field.removeClass("is_field_invalid");
                error.text("");
                return true;
            } else {
                field.addClass("is_field_invalid");
                error.text("This field is required").addClass("is_invalid");
                return false;
            }
        } else if (type === "email") {
            let isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
            if (!isValid) {
                field.addClass("is_field_invalid");
                error.text("Invalid email format").addClass("is_invalid");
                return false;
            } else {
                field.removeClass("is_field_invalid");
                error.html("");
                return true;
            }
        } else if (type === "pin") {
            let isValid = /^[0-9]{6}$/.test(value);
            if (!isValid) {
                field.addClass("is_field_invalid");
                error.text("Must be 6 digits").addClass("is_invalid");
                return false;
            } else {
                field.removeClass("is_field_invalid");
                error.html("");
                return true;
            }
        } else if (type === "amount") {
            if (value !== undefined && value !== null) {
                let valueLength = value.length;
                if (valueLength < 1) {
                    field.addClass("is_field_invalid");
                    error.text("Input Minimum 1 digit").addClass("is_invalid");
                    return false;
                }else if(value <= 0){
                    field.addClass("is_field_invalid");
                    error.text("Amount Should be greater then 0").addClass("is_invalid");
                    return false;
                } else {
                    field.removeClass("is_field_invalid");
                    error.html("");
                    return true;
                }
            }
        } else {
            if (value !== undefined && value !== null) {
                let valueLength = value.length;
                if (valueLength < 3) {
                    field.addClass("is_field_invalid");
                    error.text("Input Minimum 3 characters").addClass("is_invalid");
                    return false;
                } else {
                    field.removeClass("is_field_invalid");
                    error.html("");
                    return true;
                }
            }
        }
    }
}

let newResSubmitBtn1 = false;
let mewResSubmitBtn2 = false;
let newResSubmitBtn3 = false;
let mewResSubmitBtn4 = false;
let newResSubmitBtn5 = false;
let mewResSubmitBtn6 = false;
let notesReservation = '';

// this function used to validate new reservation occupancy
function checkOccLimit(randNum){
    let roomcate_id = $('#roomcate_resvn'+randNum).val();
    let roomtype_id = $('#roomtype_resvn'+randNum).val();
    let mx_adult = $('#adults_resvn'+randNum).val();
    let mx_child = $('#childrens_resvn'+randNum).val();
    let mx_infant = $('#infants_resvn'+randNum).val();
    $.ajax({
        url: roomTypeDetails,
        type:"POST",
        data:{roomCateID:roomcate_id,roomTypeID:roomtype_id},
        success:function(response){
            let roomtypeData = response.checkRoomType[0];
            let max_occupancy = roomtypeData['max_occupancy'];
            let inputOccupancy = parseInt(mx_adult) + parseInt(mx_child) + parseInt(mx_infant);
            if(inputOccupancy > max_occupancy){
                $('#adults_resvn'+randNum).css('border-color','#dc3545');
                $('#childrens_resvn'+randNum).css('border-color','#dc3545');
                $('#infants_resvn'+randNum).css('border-color','#dc3545');
                $('.limit_excced'+randNum).html('Occupancy limit exceeded').addClass('text-danger');
                checkSubmitBtnVisibility(0,0);
            }else{
                $('#adults_resvn'+randNum).css('border-color','');
                $('#childrens_resvn'+randNum).css('border-color','');
                $('#infants_resvn'+randNum).css('border-color','');
                $('.limit_excced'+randNum).html('');
                checkSubmitBtnVisibility(1,1);
            }
        }
    });
}

function checkOccLimit_new(randNum){
    let roomcate_id = $('#roomcate_resvn'+randNum).val();
    let roomtype_id = $('#roomtype_resvn'+randNum).val();
    let mx_adult = $('#adults_resvn'+randNum).val();
    let mx_child = $('#childrens_resvn'+randNum).val();
    let mx_infant = $('#infants_resvn'+randNum).val();
    $.ajax({
        url: roomTypeDetails,
        type:"POST",
        data:{roomCateID:roomcate_id,roomTypeID:roomtype_id},
        success:function(response){
            let roomtypeData = response.checkRoomType[0];
            let max_occupancy = roomtypeData['max_occupancy'];
            let inputOccupancy = parseInt(mx_adult) + parseInt(mx_child) + parseInt(mx_infant);
            if(inputOccupancy > max_occupancy){
                $('#adults_resvn'+randNum).css('border-color','#dc3545');
                $('#childrens_resvn'+randNum).css('border-color','#dc3545');
                $('#infants_resvn'+randNum).css('border-color','#dc3545');
                $('.limit_excced'+randNum).html('Occupancy limit exceeded').addClass('text-danger');
                $('.add_res_btn').prop('disabled',true);
            }else{
                $('#adults_resvn'+randNum).css('border-color','');
                $('#childrens_resvn'+randNum).css('border-color','');
                $('#infants_resvn'+randNum).css('border-color','');
                $('.limit_excced'+randNum).html('');
                $('.add_res_btn').prop('disabled',false);
            }
        }
    });
}

function checkOccLimitEdit(id_num) {
    let roomcate_id = $('#category_resvn_Edit_' + id_num).val();
    let roomtype_id = $('#roomtype_resvn_Edit_' + id_num).val();
    let mx_adult = $('#adults_resvn_Edit_' + id_num).val();
    let mx_child = $('#childrens_resvn_Edit_' + id_num).val();
    let mx_infant = $('#infants_resvn_Edit_' + id_num).val();
    $.ajax({
        url: roomTypeDetails,
        type: "POST",
        data: { roomCateID: roomcate_id, roomTypeID: roomtype_id },
        success: function(response) {
            let roomtypeData = response.checkRoomType[0];
            let max_occupancy = roomtypeData['max_occupancy'];
            let inputOccupancy = parseInt(mx_adult) + parseInt(mx_child) + parseInt(mx_infant);
            if (inputOccupancy > max_occupancy) {
                $('#adults_resvn_Edit_'+ id_num).css('border-color','#dc3545');
                $('#childrens_resvn_Edit_'+ id_num).css('border-color','#dc3545');
                $('#infants_resvn_Edit_'+ id_num).css('border-color','#dc3545');
                $('.limit_excced_Edit' + id_num).html('Occupancy limit exceeded').addClass('text-danger');
                $('.update_res_div').addClass('d-none');
            } else {
                $('#adults_resvn_Edit_'+ id_num).css('border-color','');
                $('#childrens_resvn_Edit_'+ id_num).css('border-color','');
                $('#infants_resvn_Edit_'+ id_num).css('border-color','');
                $('.limit_excced_Edit' + id_num).html('').removeClass('text-danger');
                $('.update_res_div').removeClass('d-none');
            }
        }
    });
}

function checkOccLimitAdd(randRoomNum) {

    let roomcate_id = $('#roomcate_resvn_Add_' + randRoomNum).val();
    let roomtype_id = $('#roomtype_resvn_Add_' + randRoomNum).val();
    let mx_adult = $('#adults_resvn_Add_' + randRoomNum).val();
    let mx_child = $('#childrens_resvn_Add_' + randRoomNum).val();
    let mx_infant = $('#infants_resvn_Add_' + randRoomNum).val();
    $.ajax({
        url: roomTypeDetails,
        type: "POST",
        data: { roomCateID: roomcate_id, roomTypeID: roomtype_id },
        success: function(response) {
            let roomtypeData = response.checkRoomType[0];
            let max_occupancy = roomtypeData['max_occupancy'];
            let inputOccupancy = parseInt(mx_adult) + parseInt(mx_child) + parseInt(mx_infant);
            if (inputOccupancy > max_occupancy) {
                $('#adults_resvn_Add_'+ randRoomNum).css('border-color','#dc3545');
                $('#childrens_resvn_Add_'+ randRoomNum).css('border-color','#dc3545');
                $('#infants_resvn_Add_'+ randRoomNum).css('border-color','#dc3545');
                $('.limit_excced_Add' + randRoomNum).html('Occupancy limit exceeded').addClass('text-danger');
                $('.update_res_Btn').addClass('disabled');
                $('.checkout_res_Btn').addClass('disabled');
            } else {
                $('#adults_resvn_Add_'+ randRoomNum).css('border-color','');
                $('#childrens_resvn_Add_'+ randRoomNum).css('border-color','');
                $('#infants_resvn_Add_'+ randRoomNum).css('border-color','');
                $('.limit_excced_Add' + randRoomNum).html('').removeClass('text-danger');
                $('.update_res_Btn').removeClass('disabled');
                $('.checkout_res_Btn').removeClass('disabled');
            }
        }
    });

}

$('#reservation #checkinSwitch').on('change', function() {
    if ($(this).is(':checked')) {
        // Bulk checkin selected
        $('#reservation .add-more-room').removeClass('d-none');
    } else {
        // Single checkin selected
        $('#reservation .add-more-room').addClass('d-none');
    }
});

function outsidePaymentRecode(id){
    
    let current_outstanding_amount = parseFloat($('.outstanding_amount').html());
    let reservation_id = $('.reservation_id_checkout').val();
    let clicked_room_id = $('.guest_room_id').text(); 
    if (roomCheck_Ids.length === 0) {
        Swal.fire({
            title: "No Rooms Selected",
            text: "Please select one room to proceed with Payment.",
            icon: "warning",
            confirmButtonText: "OK"
        });
    }else{
        // let amount_o_rsv = false;
        // if(id )
        let amount_o_rsv = validateField("#amount_o_rsv_"+id+"","amount",".amount_o_rsv_"+id+"_class");
        if(amount_o_rsv == true){
            let amount = parseFloat($("#amount_o_rsv_"+id+"").val());
            if(amount > current_outstanding_amount){
                $('.amount_o_rsv_class').text('Amount exceeds the outstanding balance.').addClass('text-danger');
                return false;
            }else{
                $('.amount_o_rsv_class').text('');
            }

            let payment_date = $("#payment_date_outside_rsv_"+id+"").val();
            let payment_type = $("#payment_type_o_rsv_"+id+"").val();
            let deposite = $("#deposite_o_rsv").is(":checked")? "Checked": "Not Checked";
            let shownote = $("#shownote_outside_rsv").is(":checked")? "Checked": "Not Checked";
            let note = $("#note_o_rsv_"+id+"").val();
            let email_invoice = $("#email_invoice_o_rsv").is(":checked")? "Checked": "Not Checked";
            let guest_email = $("#guest_email_o_rsv").val();
            Swal.fire({
                title: "Confirm submission of ₹" + amount + "?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Proceed!",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: reservationPaymentSubmit,
                        type: "POST",
                        data: {
                            reservationid: reservation_id,
                            roomID: roomCheck_Ids,
                            amount: amount,
                            payment_date: payment_date,
                            payment_type: payment_type,
                            deposite: deposite,
                            shownote: shownote,
                            note: note,
                            email_invoice: email_invoice,
                            guest_email: guest_email,
                        },
                        success: function (response) {
                            if (response.success) {
                                $('.paymentRec-Dtab-detail').css({"right":"0%", "opacity":"0"});
                                $('.paymentRec-Dtab-payment').css({"right":"0%", "opacity":"0"});
                                $('.paymentRec-Dtab-notes').css({"right":"0%", "opacity":"0"});
                                $('.paymentRec-Dtab-kot').css({"right":"0%", "opacity":"0"});
                                $('#dtab-showbtn').css("opacity","1");
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "Amount submitted",
                                    showConfirmButton: false,
                                    timer: 1500,
                                }).then(() => {
                                    edit_reservation(clicked_room_id, reservation_id);
                                });
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Oops...",
                                    text: response.error,
                                });
                            }
                        },
                        error: function () {
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
    }
}

function getReservation(x,that) {
    // $('.reservationSummary').removeClass("d-none");
    $(".res_g_reservation_total").html(0);
    $(".res_g_outstanding").html(0);
    $(".alt_hover_element").removeClass("d-none");
    $(".res_hover_element").removeClass("d-none");
    $.ajax({
        url: getResDetails,
        method: "POST",
        data: {
            reservationid: x,
        },
        success: function (response) {
            let resData_res = response.reservation_Details[0];
            let res_payment = response.resrvationPayments;
            let res_room = response.resrvationroom;
            let totalPaidAmount = res_payment.reduce((total, payment) => {
                return total + parseFloat(payment.amount_paid);
            }, 0);
            let totalroomAmt = res_room.reduce((total, room_amount) => {
                return total + parseFloat(room_amount.amount);
            }, 0);
            let tot_outstanding_amt = totalroomAmt - totalPaidAmount;
            $(".res_g_email").text(resData_res["email"]);
            $(".res_g_mobile").text(resData_res["mobile"]);
            $(".res_g_arrivaltime").text(resData_res["arrival_time"]);
            $(".res_g_reservation_total").html(totalroomAmt);
            $(".res_g_outstanding").html(tot_outstanding_amt);
        }, 
    }); 
}

// function showAltHoverElement() {
//     // Show the hovered element
//     $(".alt_hover_element").removeClass("d-none");
//     $(".res_hover_element").removeClass("d-none");
// }

function hideAltHoverElement() {
    // Hide the hovered element
    $(".alt_hover_element").addClass("d-none");
    $(".res_hover_element").addClass("d-none");
}

function activity_log_Details(res_id,room_id, callback) {

    $.ajax({
        url: getActivityLogData,
        type: "GET",
        data: {
            reservationid: res_id,roomID:room_id
        },
        success: function (response) {
            let activitydetailsData = response.activitydetails;
            callback(activitydetailsData); // return to the activity_log_Details funciton
        },
        error: function (error) {
            console.error("There was an error with the AJAX request", error);
        },
    });

}

function checkinBtn(res_id,roonID) {
    
    let checkFirst = true;
    roomCheck_Ids.forEach(function(element,key){
        let val = $('#roomno_resvn'+element).val();
        if(val == ''){
            checkFirst = false;
            $('#roomno_resvn'+element).focus();
            return;
        }
    });
    
    if(checkFirst){

        Swal.fire({
            title: "Are you sure to checkin?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, Checkin",
        }).then((result) => {
            if (result.isConfirmed) {
                let check = true;
                let roomDetail = [];
                roomCheck_Ids.forEach(function(element,key){

                    let val = $('#roomno_resvn'+element).val();
                    if(val == 'NA'){
                        check = false;
                        return;
                    }else{
                        roomDetail.push({
                            'id' : element,
                            'room' : val,
                            'room_number' :  $('#roomno_resvn'+element+' option:selected').text(),
                        });
                    }

                });
                
                if(check){

                    let first_name = $('#first_name_resvn_edit').val();
                    let last_name = $('#last_name_resvn_edit').val();
                    let gender = $('#gender_resvn_edit').val();
                    let email = $('#email_resvn_edit').val();
                    let guest = $('#guest_type_resvn_edit').val();
                    let allergic_to = $('#allergic_to_resvn_edit').val();
                    let address = $('#address_resvn_edit').val();
                    let city = $('#city_resvn_edit').val();
                    let state = $('#state_resvn_edit').val();
                    let pincode = $('#pin_resvn_edit').val();
                    let country = $('#country_resvn_edit').val();
                    let coming_from = $('#coming_from_resvn_edit').val();
                    let going_to = $('#going_to_resvn_edit').val();
                    let purpose_of_visit = $('#purpose_of_visit_resvn_edit').val();
                    let document_type = $('#documenttype_resvn_edit').val();
                    let other_detail = $('#otherdetail_resvn_edit').val();
                    let id_number = $('#idnumber_resvn_edit').val();
                    // let company_name = $('#companyname_resvn_edit').val();
                    // let company_gst = $('#companygst_resvn_edit').val();
                    // let company_address = $('#companyaddress_resvn_edit').val();
                    // let company_pincode = $('#companypincode_resvn_edit').val();
                    // let company_state = $('#companystate_resvn_edit').val();

                    $.ajax({
                        url: checkinProcess,
                        type: "POST",
                        data: {
                            reservationid: res_id,
                            clicked_room_id: roonID,
                            roomDetail: roomDetail, first_name:first_name,last_name:last_name,gender:gender,email:email,guest:guest,allergic_to:allergic_to,address:address,city:city,state:state,pincode:pincode,country:country,coming_from:coming_from,going_to:going_to,purpose_of_visit:purpose_of_visit,document_type:document_type,other_detail:other_detail,id_number:id_number
                        },
                        success: function (response) {

                            if (response.success) {
                                
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    text: "The room has been successfully checked in.",
                                    showConfirmButton: false,
                                    timer: 2000,
                                });
                                
                                $('#EditReservation').modal('hide');
                                setTimeout(() => {
                                    window.location.reload();
                                }, 2500);
                            }

                        },
                    });

                }else{
                    
                    Swal.fire({
                        text: "Please select room number to proceed",
                        icon: "warning",
                    });

                }
            }
        });
    }else{
        Swal.fire({
            text: "Please select room number to proceed",
            icon: "warning",
        });
    }
  
}

function checkoutBtn(res_id,roonID) {
    if (roomCheck_Ids.length === 0) {
        Swal.fire({
            title: "No Rooms Selected",
            text: "Please select at least one room to proceed with checkout.",
            icon: "warning",
            confirmButtonText: "OK"
        });
    }else{
        let chk = true;
        roomCheck_Ids.forEach(function(element,key){
            if($('#roomno_resvn'+element).val() == 'NA'){
                chk = false;
            }
        });
        if(chk){
            
            let isStateValid = validateField("#state_resvn_edit", "text", ".state_resvn_edit_class");
            let isCountryValid = validateField("#country_resvn_edit", "text", ".country_resvn_edit_class");
            let isComingFromResvnValid = validateField("#coming_from_resvn_edit", "text", ".coming_from_resvn_edit_class");
            let isGoingToResvnValid = validateField("#going_to_resvn_edit", "text", ".going_to_resvn_edit_class");
            let isPurposeOfVisitResvnValid = validateField("#purpose_of_visit_resvn_edit", "text", ".purpose_of_visit_resvn_edit_class");
            let id_proof = $('#photo_resvn_edit').prop('files')[0];

            if(isStateValid == true && isCountryValid == true && isComingFromResvnValid == true && isGoingToResvnValid == true && isPurposeOfVisitResvnValid == true){
                
                    let roomcate = $("select[name='roomtype_resvnEdit[]']").map(function () { return $(this).val();}).get();
                    let tariff = $("select[name='roomtariff_resvnEdit[]']").map(function () { return $(this).val();}).get();
                    let room_no = $("select[name='roomno_resvnEdit[]']").map(function () { return $(this).val();}).get();
                    let adults = $("select[name='adults_resvnEdit[]']").map(function () { return $(this).val();}).get();
                    let childrens = $("select[name='childrens_resvnEdit[]']").map(function () { return $(this).val();}).get();
                    let infants = $("select[name='infants_resvnEdit[]']").map(function () { return $(this).val();}).get();
                    let amount = $("input[name='amount_resvnEdit[]']").map(function () { return $(this).val();}).get();
                    let extra_person = $("input[name='extraperson_resvnEdit[]']").map(function () { return $(this).val();}).get();
                    let extra_person_amount = $("input[name='extrapersonAmount_resvnEdit[]']").map(function () { return $(this).val();}).get();
                    
                    var formData = new FormData();
                    formData.append('reservationid', $('.reservation_id_checkout').val());
                    formData.append('first_name', $('#first_name_resvn_edit').val());
                    formData.append('last_name', $('#last_name_resvn_edit').val());
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
                    roomCheck_Ids.forEach(function(element,key){
                        formData.append('room_id[]', element);
                    });
                    formData.append('id_proof', id_proof);
                    formData.append('room_total_amount', $('.room_total_amount').html());
                    formData.append('no_of_nights', $('.no_of_nights').html());
                    formData.append('extra_total_person', $('.extra_total_person').html());
                    formData.append('extra_total_amount', $('.extra_total_amount').html());
                    formData.append('discount_total_room', $('.discount_total_room').html());
                    
                    formData.append('total_final_res_amount', $('.total_final_res_amount').html());
                    formData.append('total_discount_percentage', $('.total_discount_percentage').val());
                    formData.append('total_received', $('.total_received').html());
                    formData.append('total_outstanding', $('.total_outstanding').html());
                    $('.photo_resvn_edit_class').html();
                    formData.append('roomcate[]', roomcate);
                    formData.append('tariff[]', tariff);
                    formData.append('room_no[]', room_no);
                    formData.append('adults[]', adults);
                    formData.append('childrens[]', childrens);
                    formData.append('infants[]', infants);
                    formData.append('amount[]', amount);
                    formData.append('extra_person[]', extra_person);
                    formData.append('extra_person_amount[]', extra_person_amount);

                    $.ajax({
                        url: checkoutProcess,
                        type: "POST",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if (response.success) {
                                window.location.href = checkoutData.replace(':id', response.random);
                            }else{
                                Swal.fire({
                                    title: "Warning",
                                    text: response.error,
                                    icon: "warning",
                                });
                            }
                        },
                    });

            }else{
                toastErrorAlert('Fill All required field of Detail section');
                $("#detailTab").tabs("option", "active", 1);
            }
        }else{
            Swal.fire({
                title: "Room Number cann't be empty",
                icon: "warning",
                confirmButtonText: "OK"
            });
        }
    }
}

// -----------------------------------Edit New Reservation Submit-----------------------------------------------
function EditRoomResSubmit(reservationID) {

    let ids = $("input[name='room_idEdit[]']").length;
    let checkin = $("#res_checkin_Edit").val();
    let checkout = $("#res_checkout_Edit").val();
    let primary_name = $("#first_name_resvn_edit").val()+' '+$("#last_name_resvn_edit").val();
    let room_type = $("select[name='roomtype_resvnEdit[]']").map(function () {
        return $(this).val();
    }).get().slice(ids);
    let roomTariff = $("select[name='roomtariff_resvnEdit[]']").map(function () {
            return $(this).val();
    }).get().slice(ids);
    let roomNo = $("select[name='roomno_resvnEdit[]']").map(function () {
        return $(this).val();
    }).get().slice(ids);
    let adults = $("select[name='adults_resvnEdit[]']").map(function () {
        return $(this).val();
    }).get().slice(ids);
    let childrens = $("select[name='childrens_resvnEdit[]']").map(function () {
        return $(this).val();
    }).get().slice(ids);
    let infants = $("select[name='infants_resvnEdit[]']").map(function () {
        return $(this).val();
    }).get().slice(ids);
    let amount = $("input[name='amount_resvnEdit[]']").map(function () {
        return $(this).val();
    }).get().slice(ids);
    let extra_person = $("input[name='extraperson_resvnEdit[]']").map(function () {
        return $(this).val();
    }).get().slice(ids);
    let extra_person_amount = $("input[name='extrapersonAmount_resvnEdit[]']").map(function () {
        return $(this).val();
    }).get().slice(ids);

    if (room_type == "") {
        return
    } else {

        $.ajax({
            url: reservatiionEditAdd,
            method: "POST",
            data: {
                reservationid: reservationID,
                checkin: checkin,
                checkout: checkout,
                room_type: room_type,
                roomTariff: roomTariff,
                adults: adults,
                childrens: childrens,
                infants: infants,
                amount: amount,
                extra_person: extra_person,
                extra_person_amount: extra_person_amount,
                primary_name: primary_name,
                roomNo:roomNo
            },
            cache: false,
            datatype: "json",
            success: function (data) {
                // console.log(data);
                if (data.success) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: data.success,
                        showConfirmButton: false,
                        timer: 1500,
                    });
                    // let reload_reservation_duration = $(".reload_reservation_duration").html();
                    //loadreservationdata(reload_reservation_duration, 2);
                    $("#EditReservation .modal-body").html(""); // Clear previous content
                    $("#EditReservation").modal("hide");
                    setTimeout(() => {
                        window.location.reload();
                    },2500);
                } else if (data.error_success) {
                    alert(data.error_success);
                    $('.res_update_loader').addClass('d-none');
                    $('.update_res_Btn').removeClass('d-none');
                } else {
                    alert("something went wrong");
                    $('.res_update_loader').addClass('d-none');
                    $('.update_res_Btn').removeClass('d-none');
                }
            },
        });

    }
}

function getRoomTypeNameUpdateAuto(catID, roomID) {
    $.ajax({
        url: getRoomTypeDataEditUrl,
        type: "GET",
        data: { catID: catID, roomID: roomID },
        success: function (response) {
            let roomtypeEditData = response.roomtypeEditData;
            let roomDetails = response.roomDetails[0];
            if (response.success) {
                let roomtypeSelectEdit = $("#roomtype_resvn_Edit_" + roomID);
                roomtypeSelectEdit.empty(); // Clear previous options
                roomtypeSelectEdit.append(`<option value="">Select</option>`);
                roomtypeEditData.forEach(function (roomtypes) {
                    roomtypeSelectEdit.append(`<option value="${roomtypes["roomtype_name_id"]}" ${roomtypes["roomtype_name_id"] == roomDetails['room_type_id'] ? 'selected':''}>${roomtypes["roomtype_name"]}</option>`
                    );
                });
            }
        },
    });
}

function getroomoccupancyUpdate(roomTypeID, roomID) {
    let roomCategoryEdit = document.getElementById("category_resvn_Edit_" + roomID).value;
    $.ajax({
        url: getOccupancyUrl,
        type: "GET",
        data: { roomCat: roomCategoryEdit, roomType: roomTypeID },
        success: function (response) {
            let roomtypesdatas = response.roomtypeDatas[0];
            let roomNum = response.roomNum;
            let adults_resvn_Edit = $("#adults_resvn_Edit_" + roomID);
            let childrens_resvn_Edit = $("#childrens_resvn_Edit_" + roomID);
            let infants_resvn_Edit = $("#infants_resvn_Edit_" + roomID);
            let amount_resvn_Edit = $("#amount_resvn_Edit_"+ roomID);
            let roomNum_resvn_Edit = $("#roomNum_resvn_Edit_" + roomID);
            roomNum_resvn_Edit.empty(); // Clear previous options
            roomNum_resvn_Edit.append(`<option value="">Select</option>`);
            roomNum.forEach(function (r_num) {
                roomNum_resvn_Edit.append(`<option value="${r_num["id"]}">${r_num["room_number"]}</option>`);
            });
           amount_resvn_Edit.empty();
           adults_resvn_Edit.empty();
           childrens_resvn_Edit.empty();
           infants_resvn_Edit.empty();
            let maxAdult = roomtypesdatas["max_adult"];
            let maxChild = roomtypesdatas["max_child"];
            let maxInfant = roomtypesdatas["max_infant"];
            let roomAmountValue = roomtypesdatas["room_amount"];
            childrens_resvn_Edit.append(`<option value="0">0</option>`);
            infants_resvn_Edit.append(`<option value="0">0</option>`);
            for (i = 1; i <= maxAdult; i++) {
                adults_resvn_Edit.append(`<option value="${i}">${i}</option>`);
            }
            for (j = 1; j <= maxChild; j++) {
                childrens_resvn_Edit.append(`<option value="${j}">${j}</option>`);
            }
            for (k = 1; k <= maxInfant; k++) {
                infants_resvn_Edit.append(`<option value="${k}">${k}</option>`);
            }
            amount_resvn_Edit.val(roomAmountValue);
        },
    });
}

//-------------New Reservation Duration Day----------------------------
function staycount_checkin(action='') {
    let curr_checkin = new Date($("#checkin_resvn").val());
    curr_checkin.setDate(curr_checkin.getDate() + 1); // increase one day in current checkin for display date later ther checkin
    // here apply checkout date display later then checkin date after select checkin date.
    flatpickr("#checkout_resvn",{
        dateFormat: "d-M-Y",
        defaultDate: curr_checkin,
        minDate: curr_checkin
    });
    staycount_checkout(action); // to manage display days count correctly.
}

function staycount_checkout(action=''){
    let checkin_resvn = '';
    let checkout_resvn = '';
    if(action == ''){
        checkin_resvn = $("#checkin_resvn").val();
        checkout_resvn = $("#checkout_resvn").val();
    }else{
        checkin_resvn = $("#res_checkin_Edit").val();
        checkout_resvn = $("#res_checkout_Edit").val();
        if(checkin_resvn == checkout_resvn){
            
            let curr_checkin = new Date($("#res_checkin_Edit").val());
            curr_checkin.setDate(curr_checkin.getDate() + 1); 
            flatpickr("#res_checkout_Edit",{
                dateFormat: "d-M-Y",
                defaultDate: curr_checkin,
                minDate: curr_checkin
            });

        }
        checkout_resvn = $("#res_checkout_Edit").val();
    }
    
    let now = new Date();
    let checkin = new Date(checkin_resvn);
    if(action != '' && lastDate != ''){
        checkin = new Date(lastDate);
        checkin.setHours(checkin.getHours(), checkin.getMinutes(), 0, 0);
    }else{
        checkin.setHours(now.getHours(), now.getMinutes(), 0, 0);
    }
    let checkout = new Date(checkout_resvn);
    let totalDays = calculateHotelDays(checkin, checkout);
    if(action == ''){
        checkout.setHours(12, 0, 0, 0);
    }else{
        if(12 > now.getHours()){
            checkout.setHours(12, 0, 0, 0);
        }else{
            checkout.setHours(now.getHours(), now.getMinutes(), 0, 0);
        }
        totalDays = calculateHotelDays(checkin, checkout,1);
    }

    totalDays = totalDays + lastDays;
    let nits = totalDays <= 1 ? "Night" : "Nights";
    if(action == ''){
        $(".reservation_duration"+action).html(Math.round(totalDays) + " " + nits);
    }else{
        $(".reservation_durationEdit").html(Math.round(totalDays) + " " + nits);
    }
   
    $(".no_of_nights").html(Math.round(totalDays));
    $(".no_of_stay").html('('+Math.round(totalDays) + " " + nits+')');
    let action_value = 0;
    if(action != ''){
        action_value = 1;
    }
    allCalculation(action_value);
}

function staycountEdit_checkin() {
    let curr_checkin = new Date($("#res_checkin_Edit").val());
    curr_checkin.setDate(curr_checkin.getDate() + 1); // increase one day in current checkin for display date later ther checkin
    // here apply checkout date display later then checkin date after select checkin date.
    flatpickr("#res_checkout_Edit",{
        dateFormat: "d-M-Y",
        defaultDate: curr_checkin,
        minDate: curr_checkin
    });
    
    staycount_checkout('Edit'); // to manage display days count correctly.
}

$("#newresID").val("0"); // append o to hidden id

function confirm_res(room_id){
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
                url:res_confirm_status,
                type:"POST",
                data:{room_id:room_id},
                success:function(response){
                    Swal.fire({
                        title: "Confirmed!",
                        text: response.success,
                        icon: "success"
                    });
                }
            });
        
        }
    });
}

function payment_id_type(type){
    type = $('#payment_type_o_rsv_detail option:selected').text();
    if(type == 'Cash'){
        $('.payment_id_number_class').addClass('d-none');
    }else{
        $('.payment_id_number_class').removeClass('d-none');
        $('.payment_id_number_label').text('Enter '+type+' Detail');
    }
}

function checkdiscount(id){
    let discount = $('#'+id).val();
    if(discount === null || discount === ''){
        $('#'+id).val('0');
    }
}

function displayTimes() {
    for (let hour = 0; hour < 24; hour++) {
        for (let minute = 0; minute < 60; minute += 30) {
            let period = hour < 12 ? "AM" : "PM";
            let displayHour = hour % 12 === 0 ? 12 : hour % 12;
            let displayMinute = minute.toString().padStart(2, "0");
            $('#arrivaltime_resvn').append(`<option value="${displayHour}:${displayMinute} ${period}">${displayHour}:${displayMinute} ${period}</option>`);
            $('#arrivaltime_resvn_edit').append(`<option value="${displayHour}:${displayMinute} ${period}">${displayHour}:${displayMinute} ${period}</option>`);
        }
    }
}
//enable submit button if all validation inputs are true only starts
let isResRoomCatValid = true;
let isResRoomTypeValid = false;
let isResMobileValid = false;
let isResNameValid = false;

// function handleInput_roomcate_resvn(){
//     isResRoomCatValid = validateField('#roomcate_resvn0','select','.roomcate_resvn_class0');
//     checkSubmitBtnVisibility(0,1);
// }

function handleInput_roomtype_resvn(){
    isResRoomTypeValid =  validateField('#roomtype_resvn0','select','.roomtype_resvn_class0');
    checkSubmitBtnVisibility(0,1);
}

function handleInput_mobile_resvn(){
    const input = document.getElementById('mobile_resvn');
    check_res_details_phone(input.value); //fetch all data using mobile number
    input.value = input.value.slice(0, 10);
    isResMobileValid = validateField('#mobile_resvn', 'mobile', '.mobile_resvn_class');
    checkSubmitBtnVisibility(0,1);
}

function handleInput_name_resvn(){  
    isResNameValid = validateField('#first_name_resvn','text','.first_name_resvn_class');
    checkSubmitBtnVisibility(0,1);
}

function checkSubmitBtnVisibility(x=0,y){
    // Enable submit button only if all inputs are valid true AND y equals 1
    $('.add_res_btn').prop('disabled', !(isResRoomTypeValid && isResMobileValid && isResNameValid && y === 1)); 
}
//enable submit button if all validation inputs are true only ends

function handleInput_mobile_resvn_Edit(){
    const input = document.getElementById('mobile_resvn_Edit');
    input.value = input.value.slice(0, 10);
    validateField('#mobile_resvn_Edit', 'mobile', '.mobile_resvn_Edit_class');
}
function handleInput_pin_resvn_Edit() {
    const input = document.getElementById('pin_resvn_Edit');
    input.value = input.value.slice(0, 6);
    validateField('#pin_resvn_Edit', 'pin', '.pin_resvn_Edit_class');
}
function handleInput_mobile_g_rsv_add(){
    const input = document.getElementById('mobile_g_rsv_add');
    input.value = input.value.slice(0, 10);
    validateField('#mobile_g_rsv_add','mobile','.mobile_g_rsv_add_class');
}
function checkEmailValid(id,value){
    let isEmailValid = true;
    if(value.length > 0){
        isEmailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
    }
    if(isEmailValid === false){
        $('#'+ id).addClass("is_field_invalid");
        $('.'+id+'_class').text("invalid email id").addClass("is_invalid");
    }else{
        $('#'+ id).removeClass("is_field_invalid");
        $('.'+id+'_class').text("");
    }
}

function send_Invoice_Email() {
    var roomId = document.getElementsByClassName('room_id_checkout')[0].innerText;
    var url = 'invoice/send-payment-invoice/' + roomId;
    window.open(url, '_blank');
}

function print_Invoice(){
    var roomId = document.getElementsByClassName('room_id_checkout')[0].innerText;
    var url = 'invoice/print-payment-invoice/' + roomId;
    window.open(url, '_blank');
}

$('.customer-d-close').click(function () {
    $('.customer-details').hide();
});

function checkoutGuest(gID,name){
    Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Checkout this guest!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url:guestCheckout,
                    type:"POST",
                    data:{id:gID,name:name},
                    success:function(response){
                        if (response.success) {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                text: response.success,
                                showConfirmButton: false,
                                timer: 4000,
                            });
                            setTimeout(() => {
                                let reloadReservationDuration = $(".reload_reservation_duration").html();
                                loadreservationdata(reloadReservationDuration, 2); // Reset reservation page
                                $('#EditReservation').modal('hide');
                            }, 3000);
                        }
                    }
                });
            }
        });
}
// toggle new reservation company details
$('#compnay_details_div').on('click',function(){
    $('.company_d_d').toggleClass('d-none');
})

$('#compnay_details_div_edit').on('click',function(){
    $('.company_d_d').toggleClass('d-none');
})

$('body').on('click','#compnay_details_update',function(){
    $('.company_d_d').toggleClass('d-none');
    // alert();
})

function check_res_details_phone(phone) {
    let newPhone;
    // Validate phone number length
    if (phone.length < 10) {
        $('#itemCodeList').empty(); // Clear if phone number is invalid
        return;
    }else{
      newPhone = phone.slice(0,10); // if mobile more then 10 digit then make it 10 digit.
    }

    $.ajax({
        url: getDetailsWithPhone,
        type: "POST",
        data: { phone:newPhone },
        success: function (response) {
            const getData = response.customer || [];
            const itemCodeList = $('#itemCodeList');
            itemCodeList.empty(); // Clear previous options
            if (getData.length > 0) {
                const dropdownContainer = $('<div>', { class: 'custom-dropdown' });

                getData.forEach(resData => {
                    $('<div>', {
                        class: 'custom-dropdown-item',
                        text: `${resData.first_name} ${resData.last_name}`,
                        click: () => {
                            getAllDataViaPhone(resData.guest_id); // Fetch and append reservation data for the selected item
                        }
                    }).appendTo(dropdownContainer);
                });

                itemCodeList.append(dropdownContainer);
            } else {
                //itemCodeList.append('<p>No previous data found.</p>');
            }
        },
        error: function () {
            console.error("Error retrieving data.");
            $('#itemCodeList').empty().append('<p>Error fetching data.</p>');
        }
    });
}

function getAllDataViaPhone(id) {

    $.ajax({
        url: addDataUsingPhone,
        type: "POST",
        data: { id: id },
        success: function (response) {
            let getData = response.resDetails[0];
            $('#itemCodeList').addClass('d-none');
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
            
            if (getData['company_name'] != null && getData['company_name'] != '') {
                $('#compnay_details_div').prop('checked', true);
                $('.company_d_d').removeClass('d-none');
            } else {
                $('#compnay_details_div').prop('checked', false);
                $('.company_d_d').addClass('d-none');
            }
            $('#companygst_resvn').val(getData['company_gst']);
            $('#companyaddress_resvn').val(getData['company_address']);
            $('#companypincode_resvn').val(getData['company_pincode']);
            $('#companystate_resvn').val(getData['company_state']);
            $('.custom-dropdown-item').css('display','none');
            handleInput_name_resvn(); // called to enable submit btn when click on dropdown name
        },
        error: function () {
            console.error("Error found");
        }
    });

}
// hide .custom-dropdown-item on click on model body anywhere
$('#reservation').on('click',function(){
   $('.custom-dropdown-item').css('display','none');
});

// ----------------------accordian-----------------------
$(document).ready(function() {
  $(".accordion-button").on("click", function() {
    $(this).toggleClass("expanded");
  });
});

 function handleMobileGuestNew(input) {
    input.value = input.value.slice(0, 10);
    validateField('#mobile_g_rsv_add_new', 'mobile', '.mobile_g_rsv_add_new_class');
}

function handleIdResvnEdit(input){
    input.value = input.value.slice(0, 15);
    validateField('#id_num_resvn_Edit', 'input', '.id_num_resvn_Edit_class');
}

function getPaymentDetailRemaining(){
    $('#amount_o_rsv').val(0);
    $('#note_o_rsv').val('');
    const currentDate = new Date();
    $('#payment_date_outside_rsv').val(currentDate);
    // checkroomchecked();
}

function checkString(name,value){
    let hasNumber = /\d/.test(value); 
    if(hasNumber){
        $('.'+name+'_class').html('Invalid string');
    }else{
        $('.'+name+'_class').html('');
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const b2bDiv = document.getElementById("b2bCompany");
    const b2cDiv = document.getElementById("b2cCompany");

    const rIndividual = document.getElementById("free");
    const rB2B = document.getElementById("b2b");
    const rB2C = document.getElementById("b2c");

    function updateBilling() {
        if (rB2B.checked) {
            
            b2bDiv.style.display = "block";
            b2cDiv.style.display = "none";
        } 
        else if (rB2C.checked) {
            
            b2bDiv.style.display = "none";
            b2cDiv.style.display = "block";
        } 
        else {
            b2bDiv.style.display = "none";
            b2cDiv.style.display = "none";
        }
    }

    // Attach listeners
    rIndividual.addEventListener("change", updateBilling);
    rB2B.addEventListener("change", updateBilling);
    rB2C.addEventListener("change", updateBilling);

    // Initial state
    updateBilling();
});