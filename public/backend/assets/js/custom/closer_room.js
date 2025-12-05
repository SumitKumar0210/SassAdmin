function check_room_closure() {

    $.ajax({
        url: roomClosureData,
        type: "GET",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                let closureData = response.data;
                var myvalue = document.getElementsByClassName('calcHeightWidth');
                let totalWidth = myvalue[0].offsetWidth;
                let ref_date = $('#datetime-local').val();
                let dateParts = ref_date.split('-');
                ref_date = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;
                closureData.forEach(function(value) {
                    let close_room = parseInt(value['room_number']);
                    let startDate_ur = new Date(value['start_date']);
                    let endDate_ur = new Date(value['end_date']);
                    let timeDiff_ur = endDate_ur - startDate_ur; // Calculate the difference in milliseconds.
                    let diffInDays_ur = timeDiff_ur / (1000 * 60 * 60 * 24); // Convert the difference to days.
                    let calculateMarginLeft = 0;
                    let calTotalWidth = 0;
                    calculateMarginLeft = totalWidth/2;
                    calTotalWidth = parseInt(totalWidth) * parseInt(diffInDays_ur);
                    let ns = '';
                   
                    if (ref_date > value['start_date']) {
                        ns = ref_date;
                        let startDate_ur1 = new Date(ref_date);
                        let endDate_ur1 = new Date(value['end_date']);
                        let timeDiff_ur1 = endDate_ur1 - startDate_ur1; 
                        let diffInDays_ur = timeDiff_ur1 / (1000 * 60 * 60 * 24);
                        calTotalWidth = parseInt(totalWidth) * parseInt(Math.round(diffInDays_ur)) + calculateMarginLeft;
                        calculateMarginLeft = 0;
                        if(value['status'] == "Closed"){
                            $.each(datesArray, function(key, dateValue){
                                columnValues = [];
                                for(k=key; k <= datesArray.length;k++){
                                    columnValues.push(k);
                                }
                                closerArea.push({
                                    'id':value['id'],
                                    'i':close_room,
                                    'j':key,
                                    'line':'490',
                                    'columnValues':columnValues,
                                    'status':value['status'],
                                });
                            });
                        }
                    } else {
                        ns = value['start_date'];
                        $.each(datesArray, function(key, dateValue){
                            if(dateValue['full_date'] == ns){
                                columnValues = [];
                                for(k=key; k <= datesArray.length;k++){
                                    columnValues.push(k);
                                }
                                closerArea.push({
                                    'id':value['id'],
                                    'i':close_room,
                                    'j':key,
                                    'line':'508',
                                    'columnValues':columnValues,
                                    'status':value['status'],
                                });
                            }
                        });
                    }
                    const alloted_cellIndices1 = findAllotedCellIndices(datesArray,ns, value['end_date']);
                    let set_bg=0;
                    let area_name='';
                    if(set_bg == 0){
                        area_name= value['closer_name'];
                        set_bg++;
                    }else{
                        area_name='';
                    }
                    $('td[data-key="' + close_room + '"][data-j="' + alloted_cellIndices1 + '"]').append(`
                        <div class="text-center d-flex" style="margin-left: ${calculateMarginLeft}px; width: ${calTotalWidth}px; padding: 6px; cursor:pointer; background-color:${value['closer_color']}">
                            <span class="text-truncate text-white text-center">
                                ${area_name}
                            </span>
                        </div>
                    `);
                });
            } else {
                alert("Error: Could not retrieve room closure data.");
            }
        },
        error: function(xhr, status, error) {
            console.error('Error: ' + error);
        }
    });

}

$('#room_closure').on("submit", function(event) {

    event.preventDefault();
    // let roomnum_closureValid = validateField("#roomnum_closure","select",".roomnum_closure_class");
    let value = $('input[name="roomnum_closure"]:checked').val();
    let reason_closureValid = validateField("#reason_closure","select",".reason_closure_class");
    if(value != true && reason_closureValid == true){
        let room_num = value;
        let start_date = $('#startdate_closure').val();
        let reason_closure = $('#reason_closure').val();
        let desc = $('#desc_closure').val();
        $.ajax({
            url: addRoomClosure,
            method: "POST",
            data: {
                room_num: room_num,
                start_date: start_date,
                reason_closure: reason_closure,
                desc: desc
            },
            success: function(data) {
                if(data.roomalready_close){
                    Swal.fire({ icon: "warning", title: "Already closed on these days!" });
                }else if(data.roomalready_reserve){
                    Swal.fire({ icon: "warning", title: "Already reserved on these days!" });
                } else {
                    $("#roomCloser").modal("hide");
                    //let reload_reservation_duration = $('.reload_reservation_duration').html();
                    // loadreservationdata(reload_reservation_duration, 2);
                    $('.alert_msg').html('Room closer added');
                    var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                    toast.show();
                    setTimeout(() => {
                        window.location.reload();
                    },2500);
                }
            },
            error: function() {
                Swal.fire({ icon: "error", title: "An error occurred while submitting room closure." });
            }
        });
    }

});

function clearCloser(){

    $('#roomnum_closure').val('');
    $('#reason_closure').val('');
    $('#desc_closure').val('');

}

function checkRoomClose(closer_id,type=0){

    Swal.fire({
        text: "Are you sure to remove this room closure?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Do it!"
      }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url:manageroomclose,
                type:"POST",
                data:{closer_id:closer_id},
                success:function(response){

                    Swal.fire({
                        title: "Room Closeure status updated successfully",
                        text: response.success,
                        icon: "success"
                    });
                    // if(type == 0){
                    //     let reload_reservation_duration = $(".reload_reservation_duration").html();
                    //     loadreservationdata(reload_reservation_duration, 2);
                    // }else{
                        window.location.reload();
                    // }
                }
            });

        }
    });
    
}

function getRoomCategory(x){
    let result = roomDetail.find(category => category.id == x);

    $('.room-closure-room-list-item').html('');
    if (result) {
        $('.room-closure-room-list').removeClass('d-none');
        result.rooms.forEach(room => {
            if(room.current_status == '-1'){
                $('.room-closure-room-list-item').append(`<li> 
                    <input class="form-check-input checkbox-shadow" id="checkbox-icon${room.id}" type="radio" name="roomnum_closure" value="${room.id}">
                    <label class="form-check-label" for="checkbox-icon"><span>${room.room_number}</span></label>
                </li>`);
            }
        });
    }else{
        $('.room-closure-room-list').addClass('d-none');
    }
}