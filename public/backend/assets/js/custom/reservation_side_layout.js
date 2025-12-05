
reservationLayoutStructure();
// let roomDetail = [];
let reservationRoomDetail = [];
let roomCloser = [];
let statusNameColor = [];


function reservationLayoutStructure(){

    $.ajax({
        url: reservationViewLayout,
        method: "POST",
        data: { days: 1},
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            console.log(data);
            timeConfiguration.push(data.time_configuration);
            availableRoomDetail = [];
            tariff_data = [];
            availableRoomDetail = data.roomDetails;
            roomDetail = data.roomDetails;
            tariff_data = data.tariffs;
            reservationRoomDetail = data.reservationRoomDetail;
            statusNameColor = data.statusNameColor;
            roomCloser = data.roomCloser;
            $('.filter-parameter').html('');
            let colorArea = `<div class="d-flex align-items-center rooms-status-btn flex-column mx-4" onclick="roomDetailDesign('')">
                            <div class="all-room w-40  bg-success border-radius-4"></div>
                            <h5>All</h5>
                        </div>`;
            statusNameColor.forEach(reason => {
                colorArea += `<div class="d-flex align-items-center rooms-status-btn flex-column mx-3" onclick="roomDetailDesign('${reason.id}')">
                            <div class="vacant-room w-40 border-radius-4" style="background-color:${reason.color}" ></div>
                            <h5> ${reason.name}</h5>
                        </div>`;
            });
            $('.filter-parameter').html(colorArea);
            roomDetailDesign();
        }
    });
}

function roomDetailDesign(type = ''){
    
    $('.room_detail_views').html();
    $('#roomtype_resvn0').empty();
    let roomCategoryView = $('#roomtype_resvn0');
    roomCategoryView.append(`<option value=""> Select Type</option>`);
    let room_detail = '';

    roomDetail.forEach(category => {

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
                <td class="fs-5 reservation-room-type">${category.name} Room</td>
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
                                                    <div class="d-flex justify-content-between align-items-center ">
                                                        <h4 class="modal-title">Reservation ${reservation.reservation_id} for ${reservation.first_name} ${reservation.last_name}</h4>
                                                    </div>
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
                                                                            <p class="mb-0 ">${reservation.guest_type}</p>
                                                                        </td>
                                                                        <td colspan="1" class="p-0">
                                                                            <p class="mb-0">Check-in</p>
                                                                            <p class="mb-0 ">${reservation.reservation_checkin_date} ${reservation.reservation_checkin_time}</p>
                                                                        </td>
                                                                        <td class="py-0">
                                                                            <p class="mb-0 ">Phone Number</p>
                                                                            <p class="mb-0 ">${reservation.mobile}</p>
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
                                                                            <p class="mb-0  text-danger">${reservation.room_alloted} </p>
                                                                        </td>
                                                                        <td colspan="1" class="p-0">
                                                                            <p class="mb-0">No of Pax and Extra</p>
                                                                            <p class="mb-0  text-danger">${reservation.adults} + ${reservation.extra_person}</p>
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
                                                    <div class="text-end mt-2">`;
                                                        if(reservation.status == 'Reserved'){
                                                            room_detail +=`<button class="btn btn-danger customer-d-close" type="button" onClick="cancelReservationData(${reservation.id})">Cancel Reservation</button>`;
                                                        }
                                                        room_detail +=`<button class="btn btn-muted border mx-2" type="button" onClick="edit_reservation(${reservation.reservation_room_id}, '${reservation.reservation_id}')">View Reservation</button>
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
}