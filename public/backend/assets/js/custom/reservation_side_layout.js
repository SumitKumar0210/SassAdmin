
reservationLayoutStructure();
// let roomDetail = [];
let reservationRoomDetail = [];
let roomCloser = [];
let statusNameColor = [];
let categorySet = 'All';
let typeSet = '';

function reservationLayoutStructure(){

    $.ajax({
        url: reservationViewLayout,
        method: "POST",
        data: { days: 1},
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            // timeConfiguration.push(data.time_configuration);
            availableRoomDetail = [];
            tariff_data = [];
            availableRoomDetail = data.roomDetails;
            roomDetail = data.roomDetails;
            tariff_data = data.tariffs;
            reservationRoomDetail = data.reservationRoomDetail;
            statusNameColor = data.statusNameColor;
            roomCloser = data.roomCloser;
            $('.filter-parameter').html('');
            let colorArea = `<button class="btn btn-primary ms-2 d-flex justify-content-between" type="button" onclick="roomDetailDesign('')" style="width:200px;"> All </button>`;
            statusNameColor.forEach(reason => {
                colorArea += `<button class="btn ms-2 text-white d-flex justify-content-between" type="button" onclick="roomDetailDesign('${reason.id}')" style="background-color:${reason.color}; width:200px;"><span> ${reason.name} </span><span class="text-end">${reason.count}</span></button>`;
            });
            $('.filter-parameter').html(colorArea);
            roomDetailDesign();
        }
    });
}

function roomDetailDesign(type = ''){
    typeSet = type;
    $('.room_detail_views').html();
    $('#roomtype_resvn0').empty();
    let roomCategoryView = $('#roomtype_resvn0');
    roomCategoryView.append(`<option value=""> Select Type</option>`);
    let room_detail = '';
    let room_category_detail = '';
    let class_filter_all = 'btn-outline-primary';
    if(categorySet == 'All'){
        class_filter_all = 'btn-primary';
    }
    room_category_detail += `<button class="btn ${class_filter_all} ms-2 filter-category-btn" type="button" onClick="categoryFilter('All')"> All </button>`;    
    roomDetail.forEach(category => {
        $('.filter-category-btn').removeClass('btn-primary');
        let class_filter = 'btn-outline-primary';
        if(category.id == categorySet){
            class_filter = 'btn-primary';
        }
        room_category_detail += `<button class="btn ${class_filter} ms-2 filter-category-btn" type="button" onClick="categoryFilter(${category.id})"> ${category.name} </button>`;

        // Filter category
        if (categorySet && categorySet !== 'All' && category.id != categorySet) {
            return; 
        }

        // Filter rooms by status
        const filteredRooms = type === '' 
            ? category.rooms 
            : category.rooms.filter(r => r.current_status == type);

        // Filter unallocated reservations of this category
        const unallocated = reservationRoomDetail.filter(
            r => r.status === 'Reserved' && r.room_category_id == category.id
        );

        if (filteredRooms.length === 0 && unallocated.length === 0) {
            return; // skip the row
        }

        // Build row
        room_detail += `
            <tr>
                <td class="fs-5 reservation-room-type">${category.name}</td>
                <td>
                    <div class="reservation-itemlist-wrapper p-3">`;

                        filteredRooms.forEach(room => {
                            let bg = '';
                            let hoverClass = '';
                            if (room.current_status != '-1') {
                                const match = statusNameColor.find(x => x.id == room.current_status);
                                if (match) {
                                    bg = `color:#fff; background-color:${match.color}`;
                                    hoverClass = 'onhover-dropdown';
                                }
                            }

                            // Click event
                            let clickEvent = '';
                            if (room.current_status > 0) {
                                const closeMatch = roomCloser.find(c => c.room_number == room.id);
                                if (closeMatch) {
                                    clickEvent = `onClick="checkRoomClose(${closeMatch.id})"`;
                                }
                            }

                            room_detail += `
                                <div class="reservation-reserved-item room-reserved ${hoverClass}"
                                    style="${bg}" ${clickEvent}>
                                    <h5 class="mb-0 text-center">${room.room_number}</h5>`;

                                // Reservation details
                                const reservation = category.room_reservation_detail.find(res => res.room_id == room.id);
                                if (reservation) {
                                    room_detail +=`<div class="grid-detals border rounded p-3 customer-details onhover-show-div text-dark" style=" box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); width:700px;">
                                        <div class="d-flex justify-content-between align-items-center mb-3 custom-border-hotlr">
                                            <button class="btn-outline-primary btn" onClick="edit_reservation(${reservation.reservation_room_id}, '${reservation.reservation_id}')">View Reservation</button>`;
                                            if(reservation.status == 'Reserved'){
                                                room_detail +=`<button class="btn btn-outline-danger customer-d-close" type="button" onClick="cancelReservationData(${reservation.id})">Cancel Reservation</button>`;
                                            }
                                            room_detail +=`<div class="text-end">
                                                <div class="fw-bold">Room No. ${reservation.room_alloted}</div>
                                                <span class="badge bg-success" style="padding: 7px 10px;">${reservation.status}</span>
                                            </div>
                                        </div>

                                        <div class="row mb-3 ">
                                            <div class="row">
                                            <div class="title col-md-3 mb-2">Guest Info</div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row custom-border-2-hotlr">
                                                    <div class="col-md-6">
                                                        <p class="mb-1">Guest Name: ${reservation.first_name} ${reservation.last_name ?? ''}</p>
                                                        <p class="mb-1">Phone No.: ${reservation.mobile}</p>
                                                    </div>

                                                    <div class="company-hotlr col-md-6" style="padding-left: 60px;">
                                                        <p class="mb-1">Company: ${reservation.company_name.substring(0, 20)}</p>
                                                        <p class="mb-1">GST: ${reservation.company_gst}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="title mb-2">Reservation Details</div>

                                                <p class="mb-1">Reservation ID: ${reservation.reservation_id} </p>
                                                <p class="mb-1">Room Type: ${category.name}</p>
                                                <p class="mb-1">Room Tariff: ${reservation.tariff_cost}</p>
                                            </div>

                                            <!-- Divider for large screen -->
                                            <div class="col-md-1 d-none d-md-flex justify-content-center">
                                                <div style="border-right:1px solid #000; height:100%;"></div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="title mb-2">Check-In Details</div>

                                                <p class="mb-1">Check-in Date: ${reservation.reservation_checkin_date} </p>
                                                <p class="mb-1">Room Time: ${reservation.reservation_checkin_time} </p>
                                                <p class="mb-1">Tariff Plan: ${reservation.tariff}</p>
                                            </div>
                                        </div>
                                    </div>`;
                                }
                            room_detail += `</div>`;
                        });

                        room_detail += `
                    </div>
                </td>
                <td class="w-33 connectedSortable">
                    <div class="unallocated-itemlist-wrapper p-3">`;

                        unallocated.forEach(r => {
                            room_detail += `<div class="unallocated-reserved-item room-reserved"
                                    onClick="edit_reservation(${r.id}, '${r.reservation_id}')">
                                    <div>
                                        <h5 class="mb-0">${r.reservation_id}
                                            <br><small class="text-clip">${r.primary_name}</small>
                                        </h5>
                                    </div>
                                </div>`;
                        });

                    room_detail += `</div>
                </td>
            </tr>
        `;

        roomCategoryView.append(`<option value="${category.id}">${category.name}</option>`);
    });

    $('.room_detail_views').html(room_detail);
    $('.category-filter-list').html(room_category_detail);
}

function categoryFilter(name){
    categorySet = name;
    roomDetailDesign(typeSet);
}