$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

let table = $('#usertype_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
        url: usertypeView,
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

function addUsertype(){
    let name = $('input[name="usertype_name"]').val();
    let permissions = $('input[name="permissions[]"]:checked').map(function(){
        return $(this).val();
    }).get();
     
    if (name == '') {
        $('input[name="usertype_name"]').focus();
    }else if(permissions.length == 0){
        toastErrorAlert('Check Permission');    
    }else{
        $.ajax({
            url: usertypeAdd,
            type: "POST",
            data: { name:name,permissions:permissions },
            success: function(response) {
                if (response.success) {
                    toastSuccessAlert(response.success);
                    setTimeout(() => {
                        window.location.reload();
                    },2500);
                } else if(response.alreadyfound_error){
                    toastWarningAlert(response.alreadyfound_error);                 
                } else {
                    toastErrorAlert(response.error);  
                }
            }
        });
    }
}

function usertypeSwitch(id) {
    $.ajax({
        url: usertypeSwitchStatus,
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
                $('#usertype_table').DataTable().ajax.reload();
            } else {
                toastErrorAlert('Error');  
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("An error occurred: " + error);
        }
    });
}

function updateUsertype(){
    let id = $('input[name="usertype_id"]').val();
    let name = $('input[name="usertype_name"]').val();
    let permissions = $('input[name="permissions[]"]:checked').map(function(){
        return $(this).val();
    }).get();
     
    if (name == '') {
        $('input[name="usertype_name"]').focus();
    }else if(permissions.length == 0){
        toastErrorAlert('Check Permission');    
    }else{
        $('.usertypeAddSubmit').addClass('d-none');
        $('.usertypeAddSpinn').removeClass('d-none');

        $.ajax({
            url: usertypeUpdate,
            type: "POST",
            data: { id:id,name:name,permissions:permissions },
            success: function(response) {
                if (response.success) {
                    toastSuccessAlert(response.success);
                    setTimeout(() => {
                        window.location.reload();
                    },2500);
                } else if(response.alreadyfound_error){
                    toastWarningAlert(response.alreadyfound_error);                 
                } else {
                    toastErrorAlert(response.error);  
                }
            }
        });
    }
}