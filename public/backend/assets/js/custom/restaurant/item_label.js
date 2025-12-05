$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

let table = $('#item_label_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
        url: itemLabelView,
    },
    columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'image',
            name: 'image'
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


function addItemLabel(){

    let name = validateField("#restaurant-label-name","input",".restaurant-label-name");
    // let image = validateField("#restaurant-label-image","mobile",".restaurant-label-image");

    if (name == true ) {
        let label_name = $('#restaurant-label-name').val();
        let label_image = $('#restaurant-label-image').prop('files')[0];
        let formData = new FormData();
        formData.append('name', label_name);
        formData.append('image', label_image);
        $.ajax({
            url: itemLabelAdd,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $('#restaurantItemLabelModal').modal('hide');
                    $('.alert_msg').html('Label Added Successfully');
                        var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                        toast.show();
                    $('#item_label_table').DataTable().ajax.reload();
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

function restaurantItemLabelSwitch(id){
    $.ajax({
        url: itemLabelSwitchStatus,
        type: "POST",
        data: {id: id},
        success: function(response) {
            if (response.success) {
                $('.alert_msg').html('Status Changed Successfully');
                var toastElement = document.getElementById('liveToast');
                var toast = new bootstrap.Toast(toastElement);
                toast.show();                   
                $('#item_label_table').DataTable().ajax.reload();
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

function editRestaurantItemLabel(id){
    $.ajax({
        url: itemLabelGet,
        type: "POST",
        data: {id: id},
        success: function(response) {
            if (response.success) {
                resetmodel();
                $('#restaurant-label-id').val(response.getData['id']);
                $('#restaurant-label-name').val(response.getData['name']);
                // $('#restaurant-category-type').val(response.getData['type']);
                $('#restaurantItemLabelModal').modal('show');
                $('.action-title').html('Edit');
                $('.addAction').addClass('d-none');
                $('.updateAction').removeClass('d-none');
            } else {
                alert("error");
            }
        }
    });
}

function updateRestaurantItemLabel(){

    let name = validateField("#restaurant-label-name","input",".restaurant-label-name");

    if (name == true) {
        let id = $('#restaurant-label-id').val();
        let label_name = $('#restaurant-label-name').val();
        let label_image = $('#restaurant-label-image').prop('files')[0];
        let formData = new FormData();
        formData.append('id', id);
        formData.append('name', label_name);
        formData.append('image', label_image);
        $.ajax({
            url: itemLabelUpdate,
            type: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $('#restaurantItemLabelModal').modal('hide');
                    $('.alert_msg').html('Label Updated Successfully');
                    var toastElement = document.getElementById('liveToast');
                    var toast = new bootstrap.Toast(toastElement);
                    toast.show();
                    $('#item_label_table').DataTable().ajax.reload(); // Reload DataTable
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

function deleteRestaurantItemLabel(id){
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
                url: itemLabelDelete,
                type: "POST",
                data: { id: id},
                success: function(response) {
                    if (response.success) {
                        Swal.fire("Deleted!", response.success, "success");
                        $('#item_label_table').DataTable().ajax.reload();
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
    $('#restaurant-label-id').val('');
    $('#restaurant-label-name').val('');
}