$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

let table = $('#user_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
        url: userView,
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
            data: 'email',
            name: 'email'
        },
        {
            data: 'mobile',
            name: 'mobile'
        },
        {
            data: 'usertype',
            name: 'usertype'
        },
        {
            data: 'address',
            name: 'address'
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

function getPermission(id){

    $.ajax({
        url: getPermissionUser,
        type: "POST",
        data: { id:id },
        success: function(response) {
            const arrayPermission = response.permissions.split(",").map(Number);
            let output = '';
            response.moduleLists.forEach(function(element,key){
                output +=`<div class="col-4">
                    <div class="card-wrapper border rounded-3 checkbox-checked">
                        <h5><label class="form-label fw-medium">${element.module}</label></h5>`;
                        element.items.forEach(function(item,key){
                            let prop = '';
                            if (arrayPermission.includes(item.id)) {
                                prop = 'checked';
                            } 
                            output +=`<div class="form-check form-switch">
                                <input class="form-check-input check-size" name="permissions[]" id="flexSwitchCheckDefault${item.id}" type="checkbox" role="switch" value="${item.id}" ${prop}><label class="form-check-label" for="flexCheckDefault${item.id}">${item.module_option}</label>
                            </div>`;
                        });
                    output +=`</div>
                </div>`;
            });
            $('.permission-list').html(output);
        }
    });
}

function addUser(){

    let name = $('input[name="user_name"]').val();
    let email = $('input[name="user_email"]').val();
    let mobile = $('input[name="user_mobile"]').val();
    let usertype = $('input[name="user_usertype"]').val();
    let password = $('input[name="user_password"]').val();
    let permissions = $('input[name="permissions[]"]:checked').map(function(){
        return $(this).val();
    }).length;

    if(name == '' && email == '' && mobile == '' && usertype == '' && password == ''){
        toastErrorAlert('Fill all required field'); 
    }else if(permissions == 0){
        toastErrorAlert('Check Permission'); 
    }else{

        let form = document.getElementById("guestForm");
        let formData = new FormData(form);
        
        $.ajax({
            url: userAdd,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                // console.log(response);
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

function docTypeValue(value){
    if(value === 'Other'){
        $('.user_otherdetail').removeClass('d-none');
    }else{
        $('.user_otherdetail').addClass('d-none');
    }
}

function checkPassword(){
    let password = $('input[name="user_password"]').val();
    let cpassword = $('input[name="user_confirm_password"]').val();
    if (password != cpassword) {
       $('.confirm_password').html('Password Not Match!');
    }else{
        $('.confirm_password').html('');
    }
}

function userSwitch(id) {
    $.ajax({
        url: userSwitchStatus,
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
                $('#user_table').DataTable().ajax.reload();
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



function updateUser(){

    let name = $('input[name="user_name"]').val();
    let mobile = $('input[name="user_mobile"]').val();
    let usertype = $('input[name="user_usertype"]').val();
    let permissions = $('input[name="permissions[]"]:checked').map(function(){
        return $(this).val();
    }).length;

    if(name == '' && mobile == '' && usertype == ''){
        toastErrorAlert('Fill all required field'); 
    }else if(permissions == 0){
        toastErrorAlert('Check Permission'); 
    }else{

        let form = document.getElementById("guestForm");
        let formData = new FormData(form);
        
        $.ajax({
            url: userUpdate,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                // console.log(response);
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