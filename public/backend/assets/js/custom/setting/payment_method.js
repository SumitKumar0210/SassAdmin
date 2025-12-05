$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

let table = $('#paymentMethod_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
        url: paymentMethodView,
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

function addPaymentMethod(){

    let name = validateField("#paymentMethod_name","input",".paymentMethod_name");
    if (name == true) {
        let name = $('#paymentMethod_name').val();
        $.ajax({
            url: paymentMethodAdd,
            type: "POST",
            data: {name:name},
            success: function(response) {
                if (response.success) {
                    $('#paymentMethodModel').modal('hide');
                    $('.alert_msg').html('Payment Method Added Successfully');
                    var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                    toast.show();
                    $('#paymentMethod_table').DataTable().ajax.reload();
                } else if(response.alreadyfound_error){
                    Swal.fire({
                        title: "Already Exists",
                        text: response.alreadyfound_error,
                        icon: "warning"
                    });                    
                } else {
                    alert("Error");
                }
            }
        });
    } 
}

function paymentMethodSwitch(id){
    $.ajax({
        url: paymentMethodSwitchStatus,
        type: "POST",
        data: { id: id},
        success: function(response) {
            if (response.success) {
                $('.alert_msg').html('Status Changed Successfully');
                var toastElement = document.getElementById('liveToast');
                var toast = new bootstrap.Toast(toastElement);
                toast.show();                   
                $('#paymentMethod_table').DataTable().ajax.reload();
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

function editPaymentMethod(id){
    $.ajax({
        url: paymentMethodGet,
        type: "POST",
        data: {id: id},
        success: function(response) {
            if (response.success) {
                resetmodel();
                $('#paymentMethod_id').val(response.getData['id']);
                $('#paymentMethod_name').val(response.getData['name']);
                $('#paymentMethodModel').modal('show');
                $('.action-title').html('Edit');
                $('.addAction').addClass('d-none');
                $('.updateAction').removeClass('d-none');
            } else {
                alert("error");
            }
        }
    });
}

function updatePaymentMethod(){

    let name = validateField("#paymentMethod_name","input",".paymentMethod_name");

    if (name == true) {
        let id = $('#paymentMethod_id').val();
        let name = $('#paymentMethod_name').val();
        $.ajax({
            url: paymentMethodUpdate,
            type: "post",
            data: {
                id: id,
                name: name
            },
            success: function(response) {
                if (response.success) {
                    $('#paymentMethodModel').modal('hide');
                    $('.alert_msg').html('Payment Method Updated Successfully');
                    var toastElement = document.getElementById('liveToast');
                    var toast = new bootstrap.Toast(toastElement);
                    toast.show();
                    $('#paymentMethod_table').DataTable().ajax.reload(); // Reload DataTable
                } else {
                    alert("error");
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    } else {
        Swal.fire({
            title: "Invalid",
            text: "Name and Type is Required",
            icon: "warning"
        });  
    }
}

function deletePaymentMethod(id){
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: paymentMethodDelete,
                type: "POST",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire("Deleted!", response.success, "success");
                        $('#paymentMethod_table').DataTable().ajax.reload();
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

function resetmodel(){
    $('.action-title').html('Add');
    $('.addAction').removeClass('d-none');
    $('.updateAction').addClass('d-none');
    $('#paymentMethod_id').val('');
    $('#paymentMethod_name').val('');
}
