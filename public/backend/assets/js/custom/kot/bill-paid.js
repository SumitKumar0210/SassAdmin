$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

let table = $('#kot_for_bill_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
        url: getBilledKot,
        data: function(d) {
            d.table = $('#bill_table').val();
            d.room = $('#bill_room').val();
        },
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
            data: 'bill',
            name: 'bill'
        },
        {
            data: 'table',
            name: 'table'
        },
        {
            data: 'room',
            name: 'room'
        },
        {
            data: 'kot_type',
            name: 'kot_type'
        },
        {
            data: 'guest_name',
            name: 'guest_name'
        },
        {
            data: 'assisted_by',
            name: 'assisted_by'
        },
        {
            data: 'date_time',
            name: 'date_time'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },
    ]
});

function searchReport(){
    table.ajax.reload();
}

function cancelKotBill(id){

    Swal.fire({
        text: "Are you sure to cancel Paid Bill?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Do it!"
      }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url:cancelBill,
                type:"POST",
                data:{id:id},
                success:function(response){

                    Swal.fire({
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

function kotPrintBill(id){
    let url = '../kot/kot-generated-bill-invoice/'+id;
    window.open(url,'_blank');
}