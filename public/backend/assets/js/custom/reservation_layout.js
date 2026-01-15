let reserveRoomArea = [];
let closerArea = [];
let datesArray = []; // Global variable to store dates
let availableRoomDetail = [];
let tariff_data = [];
let currenct_date_area_key = 0;
let roomDetail = [];
let reservationCancelPer = 0;

function loadreservationdata(x = 0, y = 0, button = null) {
   
    if (button) {
        button.removeAttribute('aria-describedby');
        const tooltipInstance = bootstrap.Tooltip.getInstance(button);
        if (tooltipInstance) {
            tooltipInstance.hide();
        }
    }
    let currdates = $('.currdates_data').html(); // Get currdates from a hidden input field or other source
    let setdate = $('#datetime-local').val();
    let output = '';
    $.ajax({
        url: reservationData,
        method: "POST",
        data: {
            days: x,
            y: y,
            currdates: currdates,
            refdate: setdate,
        },
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            // console.log(data);
            reservationCancelPer = data.reservation_cancel;
            availableRoomDetail = data.roomCategoryNum;
            tariff_data = data.tariffs;
            let roomCategoryNum = data.roomCategoryNum;
            roomDetail = data.roomCategoryNum;
            let getResViewCount = data.getResViewCount;
            let roomEachData = data.roomeachDetail;
            let roomStatus = data.statusNameColor;
            x = getResViewCount;
            const newCurrdates = data.currdates; // Access currdates from the response and use it as needed 
            $('.currdates_data').html(newCurrdates); // Update the hidden input field with the new currdates value
            $('.currDisplay_data').html(data.currrDisplay); // Update the hidden input field with the new currrDisplay value
            let currDisplaydates = $('.currDisplay_data').html(); // Use .text() to get the value of the hidden input field
            $('#datetime-local').val(currDisplaydates); // Set the value of the input field
            datesArray = data.dates; // Store dates in the global variable for findDateByIndex().
            output +=`
            <div class="col-sm-12">
                <div class="reservation">
                    <div class="table-responsive overflow-hidden">
                        <table class="table table-bordered draggableTable" id="daysTable">
                            <thead>
                                <tr>
                                    <th class="text-start">
                                    </th>`;
                                        $.each(data.dates, function(key, value) {
                                            output += `<th class="text-center py-2">`;
                                            //check if current date is found in calender then mark red that current date.
                                            if (value.full_date == value.today) {
                                                currenct_date_area_key = key;
                                                output += `<span class="d-block text-danger fs-6 fw-semibold mb-1" >Today</span>
                                                <span class="d-block text-danger d-block fs-5 fw-semibold mb-1">${value.date}</span>`;
                                            } else {
                                                output += `<span class="d-block fs-6 fw-semibold mb-1">${value.day}</span>
                                                <span class="d-block d-block fs-5 fw-semibold mb-1">${value.date}</span>`;
                                            }
                                            output += `<span class="d-block fs-6 fw-normal text-muted text-uppercase">${value.month}</span></th>`;
                                        });
                                    output += `</tr>

                            </thead>
                            <tbody>`;
                                roomCategoryNum.forEach(function(room_category) {
                                    output +=`<tr class="room-title">
                                        <td colspan="${data.dates.length + 1}" class="fw-bold p-2">
                                            <div class="d-flex align-items-center">
                                                <span class="txt-primary toggle-section me-1"
                                                    data-section="${room_category.id}-room"><i class="icofont icofont-caret-down expand-icon toggle-section"></i>
                                                </span>${room_category.name} Room
                                            </div>
                                        </td>
                                    </tr>`;
                                    room_category.rooms.forEach(function(cate_rooms){
                                        output += `<tr class="${room_category.id}-room">
                                            <td>${cate_rooms.room_number}</td>`;
                                            for (let j = 0; j < data.dates.length; j++) {
                                                output += `<td class="cell calcHeightWidth remove-res-space" data-key="${cate_rooms.id}" data-j="${j}"></td>`;
                                            }
                                        output += `</tr>`;
                                    });
                                    output +=`<tr class="${room_category.id}-room unallocated-room">
                                            <td>Unallocated</td>`;
                                            for (let i = 0; i < data.dates.length; i++) {
                                                output += `<td class="cell calcHeightWidth remove-res-space" data-key="unallocated-${room_category.id}" data-j="${i}"></td>`;
                                            }
                                    output += `</tr>`;
                                });
                            output +=` </tbody>
                        </table>
                    </div>
                </div>
            </div>`;
            $('.append_reservation_data').html(output);
            processReservationData(data.reservation); // Process reservation data
            let roomStatusView = '';
            roomStatusView +=`<div class="d-flex align-items-center rooms-status-btn flex-column mx-5" onclick="allRoomFilter('All')">
                <div class="all-room w-40 border-radius-4" style="background-color:#000"></div>
                <h5>All</h5>
            </div>`;
            $.each(roomStatus, function(key,value){
                roomStatusView +=`<div class="d-flex align-items-center rooms-status-btn flex-column mx-5" onclick="allRoomFilter('${value.name}')">
                    <div class="all-room w-40 border-radius-4" style="background-color:${value.color}"></div>
                    <h5>${value.name}</h5>
                </div>`;
            });
            $('.roomStatusFilter').html(roomStatusView);
            // -------------------------------------row view data append to row-view-class div----------------------------------------------
            let output_row_view_room_view = '';
            let output_row_view = '<div class="text-center grid-date">';
            // Render the dates
            $.each(data.dates, function (key, value) {
                output_row_view += `<div class="fulldate my-2 border-radius-4 grid-rowss">
                    ${value.day} <br> <strong>${value.date}</strong><br> ${value.month}
                </div>`;
            });
            output_row_view += `</div><div class="grid-div">`;
            // Loop through each date and room
            $.each(roomEachData, function (roomKey, roomNum) {
                output_row_view_room_view +=`<div class=" d-block "> ${ roomNum.room_number }</div>`;
            });
            $.each(data.dates, function (key, value) {
                output_row_view += `<div class="grid-row d-flex py-2 border-top justify-content-between">`;
                $.each(roomEachData, function (roomKey, roomNum) {
                    let roomClass = '';
                    let statusClass = '';
                    $.each(roomNum.room_dates, function (dateKey, date) {
                        if (date === value.full_date) {
                            roomClass = roomNum.closer_name;
                            statusClass = roomNum.closer_color;
                        }
                    });
                    if(roomClass == ''){
                        roomClass = roomNum.closer_name_vacant;
                        statusClass = roomNum.closer_color_vacant;
                        chkDetail = '';
                    }
                    // Render the room
                    output_row_view += `<div class="w-40 h-40 m-2 grid">
                            <div class="${roomClass} roomFilterValue">
                                <div class="w-40 h-40 d-block border-radius-4 onhover-dropdown" style="background-color:${statusClass}">`;
                                if(roomNum.closer_name == 'Occupied'){
                                    let show_name, show_reservation, show_email, show_mobile, show_stay, show_arrival, show_guest, show_outstanding, show_total = '';
                                    $.each(data.reservation, function(key, reservationRoom){
                                        if(reservationRoom.status == 'Alloted'){
                                            if(roomNum.room_number == reservationRoom.roomData['room_number']){
                                                show_reservation = reservationRoom.reservation_id;
                                                show_name = reservationRoom.primary_name;
                                                show_email = reservationRoom.reservation_detail['email'];
                                                show_mobile = reservationRoom.reservation_detail['mobile'];
                                                show_stay = reservationRoom.stay;
                                                if(reservationRoom.stay > 1){
                                                    show_stay += ' Nights';
                                                }
                                                show_arrival = reservationRoom.reservation_detail['arrival_time'];
                                                show_guest = reservationRoom.guest;
                                                show_outstanding = reservationRoom.outstanding
                                                show_total = reservationRoom.total;
                                            }
                                        }
                                    });
                                    output_row_view += `<div class="grid-detals border rounded p-3 customer-details onhover-show-div text-dark" style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width:700px;">
                                        <div class="d-flex justify-content-between align-items-center ">
                                            <h4 class="modal-title">Reservation ${show_reservation} For ${show_name}</h4>
                                            <button class="btn px-0 customer-d-close">
                                            <i class="icon-close"></i>
                                            </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                            <table class="table table-borderless ">
                                                <tbody class="ui-sortable" style="">
                                                <tr>
                                                    <td colspan="3" class="px-0 py-2">
                                                    <h4>Primary Contact</h4>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="p-0">
                                                    <p class="mb-0">Guest Email</p>
                                                    <p class="mb-0 ">${show_email}</p>
                                                    </td>
                                                    <td class="py-0">
                                                    <p class="mb-0 ">Phone Number</p>
                                                    <p class="mb-0 ">${show_mobile}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="px-0 py-2">
                                                    <h4>Reservation Details55</h4>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" class="p-0">
                                                    <p class="mb-0">Stay </p>
                                                    <p class="mb-0 ">${show_stay}</p>
                                                    </td>
                                                    <td class="py-0">
                                                    <p class="mb-0">Arrival Time </p>
                                                    <p class="mb-0 ">${show_arrival}</p>
                                                    </td>
                                                    <td class="py-0">
                                                    <p class="mb-0 ">Source of reservation</p>
                                                    <p class="mb-0 ">By Hotel</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="p-0 py-2">
                                                    <p class="mb-0">Room Reservation </p>
                                                    <p class="mb-0  text-danger">${ roomNum.room_number }</p>
                                                    </td>
                                                    <td class="py-2">
                                                    <p class="mb-0 ">Guest</p>
                                                    <p class="mb-0 ">${show_guest}</p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            </div>
                                            <div class="col-md-4">
                                            <div class="rounded border p-3 bg-light text-muted outstanding-detail">
                                                <p class="mb-1 fw-bold">Paid</p>
                                                <p class="mb-0">Reservation Total</p>
                                                <p class="mb-0">${show_total}</p>
                                                <p class="mt-2 mb-0">Total Outstanding</p>
                                                <p class="mb-0">${show_outstanding}</p>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="text-end mt-2">
                                            <button class="btn btn-muted border mx-2" type="button" data-bs-toggle="modal" data-bs-target="#EditReservation">View Reservation</button>
                                        </div>
                                    </div>`;
                                }
                            output_row_view += `</div>
                        </div>
                    </div>`;
                });
                output_row_view += `</div>`;
            });
            output_row_view += `</div>`;
            $('.row-view-class').html(output_row_view); //append to html row-view-class class
            $('.room-number-view').html(output_row_view_room_view);
            // -----------------------------------------------------------------------------------
            // set dropdown 
            $('#roomtype_resvn0').empty();
            let roomCategoryView = $('#roomtype_resvn0');
            roomCategoryView.append(`<option value=""> Select Type</option>`);
            $.each(roomCategoryNum, function(key, availableRoom){
                roomCategoryView.append(
                    `<option value="${availableRoom.id}"> ${availableRoom.name}</option>`
                );
            });
            
            // let roomtariff = $('#roomtariff_resvn0');
            // $.each(tariff_data, function(key, tarif){
            //     roomtariff.append(`<option value="${tarif.id}"> ${tarif.tariff_type}</option>`);
            // });
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error: " + error);
        }
    });

    function selectGridCells() {
        // Process the first 20 rows (index 0 to 19)
        $('.grid-div .grid-row').slice(0, 20).each(function () {
            var gridCells = $(this).find(".grid");
            gridCells.html('Techie');
            gridCells.slice(0, 20).find(".grid-detals").addClass('left-grid top-grid');
            // Apply 'right-grid' and 'top-grid' to the next 20 cells (21st to 40th)
            gridCells.slice(20, 40).find(".grid-detals").addClass('right-grid top-grid');
        });

        // Process rows 21 to 30
        $('.grid-div .grid-row').slice(20, 30).each(function () {
            var gridCells = $(this).find(".grid");
            gridCells.slice(0, 20).find(".grid-detals").addClass('left-grid bottom-grid');
            gridCells.slice(20, 40).find(".grid-detals").addClass('right-grid bottom-grid');
        });
    }

    selectGridCells();
    $('.grid').mouseover(function () {
        $('.customer-details').show();
    });
}

function processReservationData(reservations){
    var myvalue = document.getElementsByClassName('calcHeightWidth');
    let totalWidth = myvalue[0].offsetWidth;
    let totalHeight = myvalue[0].offsetHeight;
    let idCounter = 1; // Initialize a counter
    let ref_date = $('#datetime-local').val();
    let dateParts = ref_date.split('-');
    ref_date = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
    let checkUnallocated = [];
    $.each(reservations, function(key, value) {
        console.log(value);
        let reservation_detail = value['reservation_detail'];
        let room_data = value['roomData'];
        let checkin_date = value['checkin'];
        let checkout_date = value['checkout'];
        let roomtype = value['room_type'];
        let getroomCategory = value['room_category_id'];
        let checkin_dateObject = new Date(checkin_date); // Convert to Date object
        let checkout_dateObject = new Date(checkout_date); // Convert to Date object
        let checkin_day = checkin_dateObject.getDate(); // Extract the day
        let checkout_day = checkout_dateObject.getDate(); // Extract the day
        let checkin_month = checkin_dateObject.toLocaleString('default', {month: 'short'});
        let checkout_month = checkout_dateObject.toLocaleString('default', {month: 'short'});
        let chechin_formattedMonth = checkin_month.charAt(0).toUpperCase() + checkin_month.slice(1).toLowerCase(); // Extract the month name
        let chechout_formattedMonth = checkout_month.charAt(0).toUpperCase() + checkout_month.slice(1).toLowerCase(); // Extract the month name
        let checkin_formattedDay = String(checkin_day).padStart(2,'0'); // Convert to string with leading zero if needed
        let checkout_formattedDay = String(checkout_day).padStart(2,'0'); // Convert to string with leading zero if needed
        let checkin_targetDate = checkin_formattedDay;
        let checkout_targetDate = checkout_formattedDay;
        let res_status = value['status'];
        let startDate_ur = new Date(checkin_date);
        let endDate_ur = new Date(checkout_date);
        let timeDiff_ur = endDate_ur - startDate_ur; // Calculate the difference in milliseconds.
        let diffInDays_ur = timeDiff_ur / (1000 * 60 * 60 * 24); // Convert the difference to days.
        let calculateMarginLeft = 0;
        let calTotalWidth = 0;
        calculateMarginLeft = (totalWidth/2);
        calTotalWidth = parseInt(totalWidth) * parseInt(diffInDays_ur) - 8;
        let droppedkey = value['dropped_row'];
        let dropped_checkin_date = value['dropped_checkin_date'];
        
        let ns = '';
        if(ref_date > value['checkin']){
            ns = ref_date;
            let startDate_ur1 = new Date(ref_date);
            let endDate_ur1 = new Date(value['checkout']);
            let timeDiff_ur1 = endDate_ur1 - startDate_ur1; // Calculate the difference in milliseconds.
            let diffInDays_ur = timeDiff_ur1 / (1000 * 60 * 60 * 24);
            calTotalWidth = parseInt(totalWidth) * parseInt(Math.round(diffInDays_ur))+calculateMarginLeft - 8;
            calculateMarginLeft=0;
        }else{
            ns =  value['checkin'];
        }
        const alloted_cellIndices = findAllotedCellIndices(datesArray, ns, checkout_date);
        let new_droppedkey;
        // Ensure droppedkey is a valid number
        if (droppedkey != '') {
            new_droppedkey = droppedkey;
        } else {
            new_droppedkey = 'unallocated-'+ getroomCategory;
        }
        if (res_status == 'Reserved') {
            h = [];
            for(k = alloted_cellIndices; k < parseInt(diffInDays_ur); k++){
                h.push(k);
            }
            reserveRoomArea.push({
                'i':'unallocated-' + getroomCategory,
                'j':alloted_cellIndices,
                'columnValues':h,
                'diffInDays_ur': diffInDays_ur,
                'id': value['id'],
                'reservation_id': value['reservation_id'],
            });
            let cellIndices = findCellIndicesByDate(datesArray, checkin_targetDate,chechin_formattedMonth, checkout_targetDate, chechout_formattedMonth);
            if (Array.isArray(cellIndices) && cellIndices.length >= 0) {
                cellIndices.forEach(index => {
                    if (index !== -1) {
                        let tot = 5;
                        let tot1 = parseInt(checkUnallocated.length) * 48 + totalHeight;
                        tot += parseInt(checkUnallocated.length) * 48;
                        checkUnallocated.push(idCounter);
                        let reservation_cancel_class = '';
                        if(reservationCancelPer == 0){
                            reservation_cancel_class = 'd-none';
                        }
                        $('td[data-key="unallocated-' + getroomCategory + '"][data-j="' + index + '"]').addClass('position-relative').css("height", tot1 + "px").append(`
                        <div class="booked-details draggable top-0 start-0 mt-1 position-absolute bookedby" draggable="true" id="${idCounter}" style="margin-left:` + calculateMarginLeft + `px; width:` + calTotalWidth + `px; margin-top: `+tot+`px !important">
                            <span class="bg-dark py-2 px-1 bookedbysearch onhover-dropdown"><i class="icon-search"></i>
                                <div class=" border bg-white rounded p-2 px-3 text-dark customer-details onhover-show-div" style="width:700px;">
                                    <div class="d-flex justify-content-between align-items-center ">
                                        <h4 class="modal-title">Reservation ${value['reservation_id']} ${value['primary_name']}</h4>
                                        <button class="btn px-0 customer-d-close"><i class="icon-close"></i></button>
                                    </div>
                                    <div class="container-fluid gx-0 mt-2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table-borderless ">
                                                    <tbody class="ui-sortable" style="">
                                                        <tr>
                                                            <td colspan="4" class="px-0 py-2">
                                                            <h4>Primary Contact</h4>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" class="p-0">
                                                                <p class="mb-0">Guest Type </p>
                                                                <p class="mb-0 ">${value['guest_type']}</p>
                                                            </td>
                                                            <td colspan="1" class="p-0">
                                                                <p class="mb-0">Check-in</p>
                                                                <p class="mb-0 ">${value['reservation_checkin_date']} ${value['reservation_checkin_time']}</p>
                                                            </td>
                                                            <td class="py-0">
                                                                <p class="mb-0 ">Phone Number</p>
                                                                <p class="mb-0 ">${value['mobile']}</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3" class="px-0 py-2">
                                                            <h4>Reservation Details</h4>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" class="p-0">
                                                                <p class="mb-0">Room Reservation  </p>
                                                                <p class="mb-0  text-danger">${value['room_alloted']} </p>
                                                            </td>
                                                            <td colspan="1" class="p-0">
                                                                <p class="mb-0">No of Pax and Extra</p>
                                                                <p class="mb-0  text-danger">${value['adults']} + ${value['extra_person']}</p>
                                                            </td>
                                                            <td class="py-0">
                                                                <p class="mb-0 ">Source of reservation</p>
                                                                <p class="mb-0 ">By Hotel</p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end mt-2">
                                        <button class="btn btn-danger customer-d-close ${reservation_cancel_class}" type="button" onClick="cancelReservationData(${value['id']})">Cancel Reservation</button>
                                        <button class="btn btn-muted border mx-2" type="button" onclick="edit_reservation(${value['reservation_room_id']},'${value['reservation_id']}')">View Reservation</button>
                                    </div>
                                </div>
                            </span>
                            <span type="button" class="ms-1  text-truncate" onclick="edit_reservation(${value['reservation_room_id']},'${value['reservation_id']}')"> ${value['primary_name']}(${value['reservation_id']})</span><span class="reservationid_drag" style="display:none">${value['reservation_room_id']}</span>
                        </div>`);
                        idCounter++; // Increment the counter for the next ID
                    }
                });
            }
        }
        else if (res_status == 'Alloted') {
            h = [];
            for(k = alloted_cellIndices; k < parseInt(diffInDays_ur); k++){
                h.push(k);
            }
            reserveRoomArea.push({
                'i':parseInt(droppedkey),
                'j':alloted_cellIndices,
                'columnValues':h,
                'diffInDays_ur': diffInDays_ur,
                'id': value['id'],
                'reservation_id': value['reservation_id'],
            });
            new_droppedkey = droppedkey;
        }
        if(res_status == 'Alloted' || res_status == 'Check-out'){
            let color_status = '_checkout';
            let dragged_value = 'nodraggable';
            if(res_status == 'Alloted'){
                color_status = '_alt';
                dragged_value = 'draggable';
            }
            $('td[data-key="' + new_droppedkey + '"][data-j="' + alloted_cellIndices + '"]').addClass('position-relative').append(`
                <div class="booked-details${color_status} ${dragged_value} top-0 start-0 mt-1 position-absolute bookedby" draggable="false" id="${idCounter}" style="margin-left:` + calculateMarginLeft + `px; width:` + calTotalWidth + `px">
                    <span class="bg-dark py-2 px-1 bookedbysearch onhover-dropdown"><i class="icon-search"></i>
                        <div class=" border bg-white rounded p-2 px-3 text-dark customer-details onhover-show-div" style="width:700px;">
                            <div class="d-flex justify-content-between align-items-center ">
                                <h4 class="modal-title">Reservation ${value['reservation_id']} ${value['primary_name']}</h4>
                                <button class="btn px-0 customer-d-close"><i class="icon-close"></i></button>
                            </div>
                            <div class="container-fluid gx-0 mt-2">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table table-borderless ">
                                            <tbody class="ui-sortable" style="">
                                                <tr>
                                                    <td colspan="4" class="px-0 py-2">
                                                    <h4>Primary Contact</h4>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" class="p-0">
                                                        <p class="mb-0">Guest Type </p>
                                                        <p class="mb-0 ">${value['guest_type']}</p>
                                                    </td>
                                                    <td colspan="1" class="p-0">
                                                        <p class="mb-0">Check-in</p>
                                                        <p class="mb-0 ">${value['reservation_checkin_date']} ${value['reservation_checkin_time']}</p>
                                                    </td>
                                                    <td class="py-0">
                                                        <p class="mb-0 ">Phone Number</p>
                                                        <p class="mb-0 ">${value['mobile']}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="px-0 py-2">
                                                    <h4>Reservation Details</h4>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="1" class="p-0">
                                                        <p class="mb-0">Room Reservation  </p>
                                                        <p class="mb-0  text-danger">${value['room_alloted']} </p>
                                                    </td>
                                                    <td colspan="1" class="p-0">
                                                        <p class="mb-0">No of Pax and Extra</p>
                                                        <p class="mb-0  text-danger">${value['adults']} + ${value['extra_person']}</p>
                                                    </td>
                                                    <td class="py-0">
                                                        <p class="mb-0 ">Source of reservation</p>
                                                        <p class="mb-0 ">By Hotel</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end mt-2">
                                <button class="btn btn-muted border mx-2" type="button" onclick="edit_reservation(${value['reservation_room_id']},'${value['reservation_id']}')">View Reservation</button>
                            </div>
                        </div>
                    </span>
                    <span type="button" class="ms-1 text-truncate" onclick="edit_reservation(${value['reservation_room_id']},'${value['reservation_id']}')"> ${value['primary_name']}(${value['reservation_id']})</span><span class="reservationid_drag" style="display:none">${value['reservation_room_id']}</span>
                </div>`);
            idCounter++;
        }
    });
    initDraggable(); // Call the function to initialize draggable functionality
    check_room_closure(); // Call the function to check room closure data
}

function reservation_detail(x, y) {
    $(".resbox").removeClass('d-none').show();
}

function editresModelClose() {
    $('#EditReservation').modal('hide');
}

// Bind the function to the Close button
$('button[onclick="editresModelClose()"]').on('click', editresModelClose);
function reservationViewCount(x) {
    $.ajax({
        url: reservationCountView,
        method: "POST",
        data: {
            days: x,
        },
        success: function(data) {
            loadreservationdata(x, 2); //y=2 is for view count from current date
            // window.location.reload(); // Properly reload the page
        }
    });
}

function dateChange(){
    loadreservationdata(99,0);
}
//Bootsrtap tool tip for day shift
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});

function allRoomFilter(x){
    if(x == 'All'){
        $('.roomFilterValue').removeClass('hidden');
    }else{
        $('.roomFilterValue').addClass('hidden');
        let alls = document.querySelectorAll("."+x);
        alls.forEach(function(el){
            el.classList.remove("hidden");
        });
    }
}

function calculateReservation(){

    let total = parseFloat($('.total_final_res_amount').html()) || 0;
    let percent = $('.total_discount_percentage').val() || 0;
    if(percent > 100){
        $('.alert_msg_danger').html('Percentage cannot be greater than 100');
        var toast = new bootstrap.Toast(document.getElementById('liveToast'));
        toast.show();
        $('.total_discount_percentage').val(0);
        percent = 0
    }
    let percent_amount = (percent/100) * parseFloat(total);
    let subtotal = parseFloat(total) - parseFloat(percent_amount);
    $('.total_subtotal').val(subtotal.toFixed(2));
    let advance = $('.total_advance_amount').val() || 0;
    let total_received = parseFloat(subtotal) - parseFloat(advance);
    $('.total_received').html(total_received.toFixed(2));
    $('.total_outstanding').html(total_received.toFixed(2));
}