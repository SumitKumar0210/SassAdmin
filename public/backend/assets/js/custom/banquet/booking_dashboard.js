let bookingDetail = [];
getDashboardData();

function getDashboardData(){
    $.ajax({
        url: bookingDashboard,
        type: "POST",
        data: { fetch:1},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if(response.success){
                response.hallDetail.forEach(function(item){
                    bookingDetail.push(item);
                });
                response.quarterly_detail.forEach(element => {
                    $('.quarterly_data').append(`<tr>
                        <td>${element.start_date} - ${element.end_date} </td>
                        <td>${element.total} </td>
                        <td>${element.amount} </td>
                        <td>${element.avg} </td>
                      </tr>`);
                });
                response.eventList.forEach(element => {
                    $('.event_collection').append(`
                        <tr>
                            <td>${element.name}</td>
                            <td>${element.count}</td>
                            <td>${element.booking}</td>
                        </tr>`);
                });
                response.banquets.forEach(element => {
                    $('#external-events-list').append(`
                        <div class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event">
                            <div class="fc-event-main"> <i class="fa fa-birthday-cake me-2"></i>${element.event_name}</div>
                        </div>
                    `);
                });
                drawHallDetail();
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("An error occurred: " + error);
        }
    });
}

function drawHallDetail(filter = '',btn = ''){
    $(".hallStatusFilter").css({ "background-color": "","color": ""});
    if (btn === '') {
        $(".hallStatusFilter.btn-outline-primary").css({
            "background-color": "#33bfbf",
            "color": "white"
        });
    } else {
        let $btn = $(btn);
        const colorMap = {
            "btn-outline-secondary": "#33bfbf",
            "btn-outline-success": "green",
            "btn-outline-danger": "red",
        };
        $.each(colorMap, function(className, bgColor) {
            if ($btn.hasClass(className)) {
                $(".hallStatusFilter." + className).css({
                "background-color": bgColor,
                "color": "white"
                });
            }
        });
    }
    $('.hall_booking_detail').empty();
    let output = '';
    let bookingDetailData = [];
    if(filter != ''){
        bookingDetailData = bookingDetail.filter(item => item.booking_status == filter);
    }else{
        bookingDetailData = bookingDetail;
    }
    bookingDetailData.forEach(function(item){
        
        output +=`<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-3">
                <div class="item-hall-type border rounded-3 p-3 h-100">
                    <div class="d-flex justify-content-between mb-2">
                    <h4>${item.name}</h4>
                    <span class="badge badge-${item.booking_status_color} rounded-0 fw-normal">${item.booking_status}</span>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold">Capacity:</span><span>${item.capacity}</span>
                            </div>
                        </div>
                    
                        <div class="col-12 col-lg-6">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold">Area:</span><span>${item.area}</span>
                            </div>
                        </div>
                    
                        <div class="col-12 col-lg-6">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold">Set Up Time:</span><span>${item.setup_time}</span>
                            </div>
                        </div>
                    
                        <div class="col-12 col-lg-6">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-semibold">Rate:</span><span>${item.rate}</span>
                            </div>
                        </div>
                    </div>
                    <div class="hall-features my-3">
                    <h4 class="fw-bold">Fatures:</h4>
                    <p class="mb-0">${item.features}</p>
                    </div>
                    <div class="hall-features mb-2">
                    <h4 class="mb-2 fw-bold">Schedules:</h4>
                    <ul>
                        <li>
                            <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0">Start date & Time:</p> 
                                <p class="mb-0">${item.booked_date}</p> 
                            </div>
                        </li>`;
                        item.menuList.forEach(function(menu){
                            output +=`
                            <li>
                                <div class="d-flex justify-content-between align-items-center">
                                <p class="mb-0">${menu.category}:</p> 
                                <p class="mb-0">${menu.time}</p> 
                                </div>
                            </li>`;
                        });
                    output +=`</ul>
                    </div>
                    
                    <div class="row mt-3 g-2">`;
                    if(item.booking_status == 'Occupied'){
                        output +=`<div class="col-12 col-lg-6">
                            <button class="btn btn-outline-primary btn-sm w-100" type="button" onclick="invoicePrint(${item.booking_id})">
                                View
                            </button>
                        </div>
                        <div class="col-12 col-lg-6">
                            <button class="btn btn-outline-danger btn-sm w-100" type="button" onclick="editBooking(${item.booking_id})">
                                Edit
                            </button>
                        </div>`;
                    }else if(item.booking_status == 'Maintainance'){
                        output +=`<div class="col-12 col-lg-6">
                            <button class="btn btn-outline-success btn-sm w-100" type="button" onclick="markMaintainance(${item.id})">
                                Available
                            </button>
                        </div>`;
                    }else{
                        output +=`<div class="col-12 col-lg-6">
                            <button class="btn btn-outline-primary btn-sm w-100" type="button" onclick="bookingPage()">
                                Book This
                            </button>
                        </div>
                    
                        <div class="col-12 col-lg-6">
                            <button class="btn btn-outline-danger btn-sm w-100" type="button" onclick="markMaintainance(${item.id})">
                                Maintainance
                            </button>
                        </div>`;
                    }
                    output +=`</div>
                </div>
            </div>`;
    });
    $('.hall_booking_detail').append(output);
}

function invoicePrint(id){
    window.open('/banquet/booking-invoice/' + id);
}

function editBooking(id){
    window.location.href ='/banquet/edit-booking/' + id;
}

function bookingPage(id){
    window.location.href ='/banquet/create-booking';
}

function markMaintainance(id){
    Swal.fire({
        text: "Are you sure to mark this as Maintainance?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Do it!"
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url:updateStatusHall,
                type:"POST",
                data:{id:id},
                success:function(response){
                    toastSuccessAlert(response.success);
                    setTimeout(function(){
                        window.location.reload();
                    },2500);
                }
            });
        }
    });
}