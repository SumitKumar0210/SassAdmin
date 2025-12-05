let table = $('#hall_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
        url: hallView,
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
            data: 'name',
            name: 'name'
        },
        {
            data: 'capacity',
            name: 'capacity'
        },
        {
            data: 'area',
            name: 'area'
        },
        {
            data: 'setup_time',
            name: 'setup_time'
        },
        {
            data: 'rate',
            name: 'rate'
        },
        {
            data: 'no_of_room',
            name: 'no_of_room'
        },
        {
            data: 'feature',
            name: 'feature'
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
$('.addNewHall').on('click',function(e){
    e.preventDefault();
    $('#hallname').val('');
    $('#capacity').val('');
    $('#area').val('');
    $('#setup-time').val('');
    $('#rate').val('');
    $('#no_of_rooms').val('');
    $('input[id^="checkbox-icon"]').prop('checked',false);
    $('#addHallLabel').html('Create New Hall');
    $('.needs-validation').removeClass('was-validated');
    $('.hallUpdate').addClass('d-none');
    $('.hallSubmit').removeClass('d-none');
});

$('#hall_form').on('submit',function(e){
    e.preventDefault();
    let name = $('#hallname').val();
    let capacity = $('#capacity').val();
    let area = $('#area').val();
    let setup_time = $('#setup-time').val();
    let rate = $('#rate').val();
    let no_of_rooms = $('#no_of_rooms').val();
    let features = $('input[name="features[]"]:checked').map(function(){return $(this).val()}).get();
    if (name == '' || capacity == '' || area == '' || setup_time == '' || rate == '' || no_of_rooms == '' ) {
        $('needs-validation').addClass('was-validated');
    } else if(features == ''){
        toastErrorAlert('Select Feature');
    }else {
        $.ajax({
            url: hallAdd,
            type: "POST",
            data: { name:name,capacity:capacity,area:area,setup_time:setup_time, rate:rate,no_of_rooms:no_of_rooms,features:features },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // $('#addHall').modal('hide');
                // toastSuccessAlert(response.success);
                // $('#hall_table').DataTable().ajax.reload();
                if(response.success){
                    $('#addHall').modal('hide');
                    toastSuccessAlert(response.success);
                    $('#hall_table').DataTable().ajax.reload();
                }else if(response.error_success){
                    toastErrorAlert(response.error_success);
                }else if(response.alreadyfound){
                     toastErrorAlert(response.alreadyfound);
                }else{
                    toastErrorAlert('something went wrong!');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    }
});
function hallSwitch(id){
    $.ajax({
        url: hallSwitchStatus,
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
            $('#hall_table').DataTable().ajax.reload();
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
function hallEdit(id){
    $.ajax({
        url: hallGetData,
        type: "POST",
        data: {
            id: id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                $('input[id^="checkbox-icon"]').prop('checked',false);
                let getData = response.data[0];
                $('#hall_id').val(id);
                $('#hallname').val(getData.name);
                $('#capacity').val(getData.capacity);
                $('#area').val(getData.area);
                $('#setup-time').val(getData.setup_time);
                $('#rate').val(getData.rate);
                $('#no_of_rooms').val(getData.complimentary_rooms);
                let featureArray = getData.features.split(","); // converted string into array for foreach loop run
                featureArray.forEach(element => {
                    $('#checkbox-icon'+ element).prop('checked',true);
                });
                $('#addHall').modal('show');
                $('.addHallLabel').html('Edit Hall');
                $('.hallSubmit').addClass('d-none');
                $('.hallUpdate').removeClass('d-none');
            } else {
                alert("error");
            }
        }
    });
}
function hallUpdate(id){
    let name = $('#hallname').val();
    let capacity = $('#capacity').val();
    let area = $('#area').val();
    let setup_time = $('#setup-time').val();
    let rate = $('#rate').val();
    let no_of_rooms = $('#no_of_rooms').val();
    let features = $('input[name="features[]"]:checked').map(function(){return $(this).val()}).get();
    feature = features.toString();
    if (name == '' || capacity == '' || area == '' || setup_time == '' || rate == '' || no_of_rooms == '' || features == '') {
        $('needs-validation').addClass('was-validated');
    } else {
        $.ajax({
            url: hallDataUpdate,
            type: "POST",
            data: { id:id,name:name,capacity:capacity,area:area,setup_time:setup_time,rate:rate,no_of_rooms:no_of_rooms,features:feature },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success){
                    $('#addHall').modal('hide');
                    toastSuccessAlert(response.success);
                    $('#hall_table').DataTable().ajax.reload();
                }else if(response.error_success){
                    toastErrorAlert(response.error_success);
                }else{
                    toastErrorAlert('something went wrong!');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    }
}