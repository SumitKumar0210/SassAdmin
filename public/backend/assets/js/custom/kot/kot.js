setRoom();
function setRoom(){
    $.ajax({
        url: kotGetRoomDetail,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            response.roomList.forEach(element => {
                $('#convert_room_number').append(`<option value="${element.id}">${element.number}</option>`);
            });
        }
    });
}

// getKotId
function getKotId(id){
    $('#kotModal').modal('show');
    $('#convert_kot_id').val(id);
}

function cancelKotDetail(){
    let reason = $('#kot_cancel_reason').val();
    if(reason == ''){
        toastErrorAlert('Reason is Required');
        return;
    }
    let kot_id = '';
    $.each(kotItemList[0], function(key, kotItem){
        kot_id = kotItem.id;
    });
    $.ajax({
        url: kotCancel,
        type: "POST",
        data: {kot_id:kot_id,reason:reason},
        success:function(response){
            if(response.success){
                Swal.fire({
                    text: "KOT Cancel Successfully",
                    icon: "success"
                }); 
                setTimeout(function() {
                    location.reload();
                }, 2500);
            }else{
                toastErrorAlert('Something Went Wrong');
                return;
            }
        }
    });
}

function printKot(x){
    let url = '../kot/print-kot-invoice/'+x;
    window.open(url,'_blank');
}

function cancelKot(){
    Swal.fire({
        text: "Are you sure to Cancel the KOT?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Do it!"
      }).then((result) => {
        if (result.isConfirmed) {
            $('#kot_cancel_reason').val('');
            $('#kotModalCancel').modal('show');
        }
    });
}

function convertToRoom(){
    Swal.fire({
        text: "Are you sure to convert Table Kot to Room Kot?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Do it!"
      }).then((result) => {
        if (result.isConfirmed) {
            let id = $('#convert_kot_id').val();
            let room = $('#convert_room_number').val();
            let number = $('#convert_room_number option:selected').text();
            $.ajax({
                url: kotTableRoom,
                type: "POST",
                data: {id:id,room:room,number:number},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire({
                        title: "Successfully Convert To Room KOT",
                        text: response.success,
                        icon: "success"
                    });
                    setTimeout(() => {
                        location.reload();
                    }, 2500);
                }
            });
        }
    });
}

$('#kot_collect_pmode').on('change',function(e){
    e.preventDefault();
    let pmode = $('#kot_collect_pmode').val();
     if(pmode == '1' || pmode == ''){
        $('.txnVisibility').addClass('d-none');
     }else{
        $('.txnVisibility').removeClass('d-none');
     }
});

function kotRecordPayment(id,grand,total){
    $('#kotModalPayment').modal('show');
    $('.kot_collect_id').val(id);
    $('#kot_collect_paid_amount').val(total);
    let due = 0;
    due = grand - total;
    $('#kot_collect_amount').val(due);
}

$('#kot_due_payment_collect').on('submit', function(e) {
    e.preventDefault();
    let id = $('.kot_collect_id').val();
    let amount = $('#kot_collect_amount').val();
    let mode = $('#kot_collect_pmode').val();
    let txn = $('#kot_collect_txn').val();

    if (amount <= 0) {
        toastErrorAlert('Invalid Amount');
        $('needs-validation').addClass('was-validated');
    }else if (mode == '') {
        $('needs-validation').addClass('was-validated');
    }else if (mode != '1' && txn == '') {
        $('needs-validation').addClass('was-validated');
    }else {
        $.ajax({
            url: kotCollectPayment,
            type: "POST",
            data: { id:id,amount:amount,mode:mode,txn:txn },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response);
                $('#kotModalPayment').modal('hide');
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