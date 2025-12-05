$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});
$('.event_Add').on('click',function(e){
    e.preventDefault();
        $('.eventTitle').html('Add Event');
        $('.event_update').addClass('d-none');
        $('.event_submit').removeClass('d-none');
        $('.needs-validation').removeClass('was-validated');
});
let table = $('#event_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
        url: eventView,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        error: function(xhr, error, thrown) {
            console.log(xhr.responseText);
            alert('Error: ' + thrown);
        }
    },
    columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'status',
            name: 'status',
            orderable: false,
            searchable: false
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },
    ]
});


 $('#event_form').on('submit', function(e) {
    e.preventDefault();
    let id = $('#event_id').val();
    let name = $('#event').val();
    if (name == '') {
        $('.needs-validation').addClass('was-validated');
    } else {
        if ($('.event_update').is(':visible')) {
                event_update(id); // Trigger update function when update btn is active
        } else {
            $.ajax({
                    url: eventAdd,
                    type: "POST",
                    data: { name:name },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#eventAdd').modal('hide');
                        toastSuccessAlert(response.success);
                        $('#event_table').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("An error occurred: " + error);
                    }
            });
        }
    }
});
function eventSwitch(id) {
    $.ajax({
        url: eventSwitchStatus,
        type: "POST",
        data: {
            id: id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                toastSuccessAlert(response.success);
            $('#event_table').DataTable().ajax.reload();
            } else {
                alert("Error");
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("An error occurred: " + error);
        }
    });
}
function eventEdit(id){
    $.ajax({
        url:getEventData,
        type:"POST",
        data:{id:id},
        success:function(response){
            let getData = response.data;
            $('#event_id').val(getData[0].id);
            $('#event').val(getData[0].name);
            $('.eventTitle').html('Update Event');
            $('.event_submit').addClass('d-none');
            $('.event_update').removeClass('d-none');
            $('#eventAdd').modal('show');
        },
        error:function(xhr,error,thrown){
            console.log(xhr.responseText);
            alert('error: '+ thrown);
        }
    });
}
function event_update(id){
    let name = $('#event').val();
    if (name == '') {
        $('.needs-validation').addClass('was-validated');
    } else {
        $.ajax({
                url: eventUpdate,
                type: "POST",
                data: { id:id,name:name },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#eventAdd').modal('hide');
                    toastSuccessAlert(response.success);
                    $('#event_table').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("An error occurred: " + error);
                }
            });
        }
}