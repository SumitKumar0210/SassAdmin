
let table = $('#feature_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
        url: featureView,
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

$('.feature_Add').on('click',function(e){
    e.preventDefault();
        $('.featureTitle').html('Add Feature');
        $('.feature_update').addClass('d-none');
        $('.feature_submit').removeClass('d-none');
        $('.needs-validation').removeClass('was-validated');
});
 $('#feature_form').on('submit', function(e) {
    e.preventDefault();
    let id = $('#feature_id').val();
    let name = $('#feature').val();
    if (name == '') {
        $('needs-validation').addClass('was-validated');
    } else {
        if ($('.feature_update').is(':visible')) {
                feature_update(id); // Trigger update function when update btn is active
        } else {
            $.ajax({
                    url: featureAdd,
                    type: "POST",
                    data: { name:name },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#featureAdd').modal('hide');
                        toastSuccessAlert(response.success);
                        $('#feature_table').DataTable().ajax.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert("An error occurred: " + error);
                    }
                });
            }
        }   
});
function featureSwitch(id){
    $.ajax({
        url: featureSwitchStatus,
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
            $('#feature_table').DataTable().ajax.reload();
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
function featureEdit(id){
    $.ajax({
        url:getFeatureData,
        type:"POST",
        data:{id:id},
        success:function(response){
            let getData = response.data;
            $('#feature_id').val(getData[0].id);
            $('#feature').val(getData[0].name);
            $('.featureTitle').html('Update Feature');
            $('.feature_submit').addClass('d-none');
            $('.feature_update').removeClass('d-none');
            $('#featureAdd').modal('show');
        },
        error:function(xhr,error,thrown){
            console.log(xhr.responseText);
            alert('error: '+ thrown);
        }
    });
}
function feature_update(id){
    let name = $('#feature').val();
    if (name == '') {
        $('.needs-validation').addClass('was-validated');
    } else {
        $.ajax({
                url: featureUpdate,
                type: "POST",
                data: { id:id,name:name },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#featureAdd').modal('hide');
                    toastSuccessAlert(response.success);
                    $('#feature_table').DataTable().ajax.reload();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("An error occurred: " + error);
                }
            });
        }
}