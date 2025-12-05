let table = $('#booking_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
        url: viewBooking,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        error: function(xhr, error, thrown) {
            console.log(xhr.responseText);
            alert('Error: ' + thrown);
        }
    },
    columns: [
        {
            data: 'booking_id',
            name: 'booking_id'
        },
        {
            data: 'client',
            name: 'client'
        },
        {
            data: 'phone',
            name: 'phone'
        },
        {
            data: 'hall',
            name: 'hall'
        },
        {
            data: 'event',
            name: 'event'
        },
        {
            data: 'date',
            name: 'date'
        },
        {
            data: 'end_time',
            name: 'end_time'
        },
        {
            data: 'guest',
            name: 'guest'
        },
        {
            data: 'amount',
            name: 'amount'
        },
        {
            data: 'paid',
            name: 'paid'
        },
        {
            data: 'due',
            name: 'due'
        },
        {
            data: 'status',
            name: 'status'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },
    ]
});
function invoicePrint(id){
    window.open('/banquet/booking-invoice/' + id);
}
$('#banquet_booking_pmode').on('change',function(e){
    e.preventDefault();
    let pmode = $('#banquet_booking_pmode').val();
     if(pmode == '1' || pmode == ''){
        $('.txnVisibility').addClass('d-none');
     }else{
        $('.txnVisibility').removeClass('d-none');
     }
});
function addPayment(id,limit,grand_total){
    $('.banquet_booking_id').val(id);
    $('#banquet_paid_booking_amount').val(grand_total - limit);
    $('#banquet_booking_amount').val(limit);
    $('#banquet_booking_amount_limit').val(limit);
    $('#banquet_booking_pmode').val('');
    $('#banquet_booking_txn').val('');
}

$('#banquet_booking_payment_form').on('submit',function(e){
    e.preventDefault();
    let id = $('.banquet_booking_id').val();
    let amount = $('#banquet_booking_amount').val();
    let amount_limit = $('#banquet_booking_amount_limit').val();
    let pmode = $('#banquet_booking_pmode').val();
    let txn = $('#banquet_booking_txn').val();
    if(amount == '' || pmode == ''){
        $('.needs-validation').addClass('was-validated');
    }else if(parseFloat(amount) > parseFloat(amount_limit)){
        $('.needs-validation').addClass('was-validated');
        toastErrorAlert('Enter Amount is greater than Due Amount');
    }else{
        $.ajax({
            url:addBooingPayment,
            type:"POST",
            data:{id:id,amount:amount,pmode:pmode,txn:txn},
            success:function(response){
                if(response.success){
                    $('#booking_table').DataTable().ajax.reload();
                    $('#banquetBookingPaymentModel').modal('hide');
                    toastSuccessAlert(response.success);
                }else{
                    toastErrorAlert(response.error_success);
                }
            }
        });
    }
});

$('#banquet_booking_convert_form').on('submit',function(e){
    e.preventDefault();
    let id = $('.banquet_booking_id').val();
    let image = $('#document_upload').prop('files')[0];

    if(image == ''){
        $('.needs-validation').addClass('was-validated');
    }else{

        let formData = new FormData();
        formData.append('id', id);
        formData.append('image', image);

        $.ajax({
            url: convertDraftBooking,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {

                if(response.success){
                    $('#booking_table').DataTable().ajax.reload();
                    $('#banquetBookingDraftModel').modal('hide');
                    toastSuccessAlert(response.success);
                }else{
                    toastErrorAlert(response.error_success);
                }
            }
        });
    }
});



function cancelBooking(id){
     Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Cancel Booking!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: cancelBanquetBooking,
                type: "POST",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire("Canceled!", response.success, "success");
                        $('#booking_table').DataTable().ajax.reload();
                    } else {
                        Swal.fire("Error!", "Error", "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire("Error!", "An error occurred: " + error, "error");
                }
            });
        }
    });
}

function draftBooking(x){
    $('.banquet_booking_id').val(x);
}