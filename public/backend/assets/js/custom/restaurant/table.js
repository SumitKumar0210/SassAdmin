$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

let table = $('#restaurant_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: tableView,
    columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'number',
            name: 'number'
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
            data: 'qr_code',
            name: 'qr_code'
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

function addTable(){

    let number = validateField("#restaurant-table-number","select",".restaurant-table-number");
    let capacity = validateField("#restaurant-table-capacity","amount",".restaurant-table-capacity");
    let area = validateField("#restaurant-area","select",".restaurant-area");

    if (number == true && capacity == true && area == true) {
        let number = $('#restaurant-table-number').val();
        let capacity = $('#restaurant-table-capacity').val();
        let area = $('#restaurant-area').val();
        $.ajax({
            url: tableAdd,
            type: "POST",
            data: {number:number,capacity:capacity,area:area},
            success: function(response) {
                if (response.success) {
                    $('#restaurantTableModal').modal('hide');
                    $('.alert_msg').html('Table Added Successfully');
                        var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                        toast.show();
                    $('#restaurant_table').DataTable().ajax.reload();
                } else if(response.alreadyfound_error){
                    Swal.fire({
                        title: "Already Found",
                        text: response.alreadyfound_error,
                        icon: "warning"
                    });                    
                } else {
                    alert("Error");
                }
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

function restaurantTableSwitch(id){
    $.ajax({
        url: tableSwitchStatus,
        type: "POST",
        data: {id: id},
        success: function(response) {
            if (response.success) {
                $('.alert_msg').html('Status Changed Successfully');
                var toastElement = document.getElementById('liveToast');
                var toast = new bootstrap.Toast(toastElement);
                toast.show();                   
                $('#restaurant_table').DataTable().ajax.reload();
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

function editRestaurantTable(id){
    $.ajax({
        url: tableGet,
        type: "POST",
        data: {id: id},
        success: function(response) {
            if (response.success) {
                resetmodel();
                $('#restaurant-table-id').val(response.getData['id']);
                $('.qr_code_table').val(response.getData['qr_code']);
                $('#restaurant-table-number').val(response.getData['number']);
                $('#restaurant-table-capacity').val(response.getData['capacity']);
                $('#restaurant-area').val(response.getData['area']);
                $('#restaurantTableModal').modal('show');
                $('.action-title').html('Edit');
                $('.addAction').addClass('d-none');
                $('.updateAction').removeClass('d-none');
            } else {
                alert("error");
            }
        }
    });
}

function updateRestaurantTable(){

    let number = validateField("#restaurant-table-number","select",".restaurant-table-number");
    let capacity = validateField("#restaurant-table-capacity","amount",".restaurant-table-capacity");
    let area = validateField("#restaurant-area","select",".restaurant-area");

    if (number == true && capacity == true && area == true) {
        let id = $('#restaurant-table-id').val();
        let number = $('#restaurant-table-number').val();
        let capacity = $('#restaurant-table-capacity').val();
        let area = $('#restaurant-area').val();
         let qr_code = $('.qr_code_table').html();
        $.ajax({
            url: tableUpdate,
            type: "post",
            data: {id:id,qr_code:qr_code,number:number,capacity:capacity,area:area},
            success: function(response) {
                if (response.success) {
                    $('#restaurantTableModal').modal('hide');
                    $('.alert_msg').html('Table Updated Successfully');
                    var toastElement = document.getElementById('liveToast');
                    var toast = new bootstrap.Toast(toastElement);
                    toast.show();
                    $('#restaurant_table').DataTable().ajax.reload(); // Reload DataTable
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

function deleteRestaurantTable(id){
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
                url: tableDelete,
                type: "POST",
                data: {id: id},
                success: function(response) {
                    if (response.success) {
                        Swal.fire("Deleted!", response.success, "success");
                        $('#restaurant_table').DataTable().ajax.reload();
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
    $('#restaurant-table-id').val('');
    $('#restaurant-table-number').val('');
    $('#restaurant-table-capacity').val('');
    $('#restaurant-area').val('');
}