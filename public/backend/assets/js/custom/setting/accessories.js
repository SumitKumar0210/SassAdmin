
let table = $('#accessories_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
        url: accessoriesView,
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
            data: 'rate',
            name: 'rate'
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
        }
    ]
});
$('.accessories_Add').on('click',function(e){
    e.preventDefault();
        $('.accessoriesTitle').html('Add Accessories');
        $('.accessories_update').addClass('d-none');
        $('.accessories_submit').removeClass('d-none');
        $('.needs-validation').removeClass('was-validated');
});
$('#accessories_form').on('submit', function(e) {
    e.preventDefault();
    let id = $('#accessories_id').val();
    let name = $('#accessories').val();
    let rate = $('#rate').val();
    if (name == '') {
        $('needs-validation').addClass('was-validated');
    } else {
        if ($('.accessories_update').is(':visible')) {
                accessories_update(id); // Trigger update function when update btn is active
        } else {
            $.ajax({
                    url: accessoriesAdd,
                    type: "POST",
                    data: { name:name,rate:rate },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#accessoriesAdd').modal('hide');
                        toastSuccessAlert(response.success);
                        $('#accessories_table').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("An error occurred: " + error);
                    }
            });
        }
    }
});
function accessoriesSwitch(id) {
    $.ajax({
        url: accessoriesSwitchStatus,
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
            $('#accessories_table').DataTable().ajax.reload();
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
function accessoriesEdit(id){
    $.ajax({
        url:getAccessoriesData,
        type:"POST",
        data:{id:id},
        success:function(response){
            let getData = response.data;
            $('#accessories_id').val(getData[0].id);
            $('#accessories').val(getData[0].name);
            $('#rate').val(getData[0].rate);
            $('.accessoriesTitle').html('Update accessories');
            $('.accessories_submit').addClass('d-none');
            $('.accessories_update').removeClass('d-none');
            $('#accessoriesAdd').modal('show');
        },
        error:function(xhr,error,thrown){
            console.log(xhr.responseText);
            alert('error: '+ thrown);
        }
    });
}
function accessories_update(id){
    let name = $('#accessories').val();
    let rate = $('#rate').val();
    if (name == '' || rate == '') {
        $('.needs-validation').addClass('was-validated');
    } else {
        $.ajax({
                url: accessoriesUpdate,
                type: "POST",
                data: { id:id,name:name,rate:rate },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#accessoriesAdd').modal('hide');
                    toastSuccessAlert(response.success);
                    $('#accessories_table').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("An error occurred: " + error);
                }
            });
        }
}