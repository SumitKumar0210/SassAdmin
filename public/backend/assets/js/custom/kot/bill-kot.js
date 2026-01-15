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
        url: getBillKot,
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
            data: 'select',
            name: 'select'
        },
        {
            data: 'kot',
            name: 'kot'
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
        }
    ]
});

function searchReport(){
    table.ajax.reload();
}

function generateBill(){
    let hobbiesArray = $('input[name="kotsSelect[]"]:checked').map(function() {
        return this.value;
    }).get();

    let x = hobbiesArray.join(",");
    let url = '../kot/kot-generate-bill-show/'+x;
    window.open(url,'_blank');
}
// 