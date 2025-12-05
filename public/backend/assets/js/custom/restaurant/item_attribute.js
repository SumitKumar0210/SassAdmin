$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

let table = $('#restaurant_item_attribute').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
        url: itemAttributeView,
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
            data: 'attribute',
            name: 'attribute'
        },
        {
            data: 'type',
            name: 'type'
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

function addItemAttribute(){

    let name = validateField("#restaurant-item-attribute-name","input",".restaurant-item-attribute-name");
    let type = validateField("#restaurant-item-attribute-type","select",".restaurant-item-attribute-type");

    if (name == true && type == true) {
        let name = $('#restaurant-item-attribute-name').val();
        let type = $('#restaurant-item-attribute-type').val();
        $.ajax({
            url: itemAttributeAdd,
            type: "POST",
            data: {name:name,type:type},
            success: function(response) {
                if (response.success) {
                    $('#restaurantItemAttributeModal').modal('hide');
                    $('.alert_msg').html('Attribute Added Successfully');
                        var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                        toast.show();
                    $('#restaurant_item_attribute').DataTable().ajax.reload();
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
    } else {
        Swal.fire({
            title: "Invalid",
            text: "Name and Type is Required",
            icon: "warning"
        });  
    }
}

function restaurantItemAttributeSwitch(id){
    $.ajax({
        url: itemAttributeSwitchStatus,
        type: "POST",
        data: { id: id},
        success: function(response) {
            if (response.success) {
                $('.alert_msg').html('Status Changed Successfully');
                var toastElement = document.getElementById('liveToast');
                var toast = new bootstrap.Toast(toastElement);
                toast.show();                   
                $('#restaurant_item_attribute').DataTable().ajax.reload();
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

function editRestaurantItemAttribute(id){
    $.ajax({
        url: itemAttributeGet,
        type: "POST",
        data: {id: id},
        success: function(response) {
            if (response.success) {
                resetmodel();
                $('#restaurant-item-attribute-id').val(response.getData['id']);
                $('#restaurant-item-attribute-name').val(response.getData['name']);
                $('#restaurant-item-attribute-type').val(response.getData['type']);
                $('#restaurantItemAttributeModal').modal('show');
                $('.action-title').html('Edit');
                $('.addAction').addClass('d-none');
                $('.updateAction').removeClass('d-none');
            } else {
                alert("error");
            }
        }
    });
}

function updateRestaurantItemAttribute(){

    let name = validateField("#restaurant-item-attribute-name","input",".restaurant-item-attribute-name");
    let type = validateField("#restaurant-item-attribute-type","select",".restaurant-item-attribute-type");

    if (name == true && type == true) {
        let id = $('#restaurant-item-attribute-id').val();
        let name = $('#restaurant-item-attribute-name').val();
        let type = $('#restaurant-item-attribute-type').val();
        $.ajax({
            url: itemAttributeUpdate,
            type: "post",
            data: {
                id: id,
                name: name,
                type: type
            },
            success: function(response) {
                if (response.success) {
                    $('#restaurantItemAttributeModal').modal('hide');
                    $('.alert_msg').html('Item Attribute Updated Successfully');
                    var toastElement = document.getElementById('liveToast');
                    var toast = new bootstrap.Toast(toastElement);
                    toast.show();
                    $('#restaurant_item_attribute').DataTable().ajax.reload(); // Reload DataTable
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

function deleteRestaurantItemAttribute(id){
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
                url: itemAttributeDelete,
                type: "POST",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire("Deleted!", response.success, "success");
                        $('#restaurant_item_attribute').DataTable().ajax.reload();
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
    $('#restaurant-item-attribute-id').val('');
    $('#restaurant-item-attribute-name').val('');
    $('#restaurant-item-attribute-type').val('');
}
