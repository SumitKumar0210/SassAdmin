$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

let table = $('#restaurant_item_category').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
        url: itemCategoryView,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        error: function(xhr, error, thrown) {
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
            data: 'parent',
            name: 'parent'
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

function addItemCategory(){

    let name = validateField("#restaurant-category-name","input",".restaurant-category-name");
    let type = validateField("#restaurant-category-type","select",".restaurant-category-type");

    if (name == true && type == true) {
        let name = $('#restaurant-category-name').val();
        let type = $('#restaurant-category-type').val();
        $.ajax({
            url: itemCategoryAdd,
            type: "POST",
            data: {name:name,type:type},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#restaurantCategoryModal').modal('hide');
                    $('.alert_msg').html('Category Added Successfully');
                    var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                    toast.show();
                    $('#restaurant_item_category').DataTable().ajax.reload();
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

function restaurantCategorySwitch(id){
    $.ajax({
        url: itemCategorySwitchStatus,
        type: "POST",
        data: {
            id: id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                $('.alert_msg').html('Status Changed Successfully');
                var toastElement = document.getElementById('liveToast');
                var toast = new bootstrap.Toast(toastElement);
                toast.show();                   
                $('#restaurant_item_category').DataTable().ajax.reload();
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

function editRestaurantCategory(id){
    $.ajax({
        url: itemCategoryGet,
        type: "POST",
        data: {
            id: id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                resetmodel();
                $('#restaurant-category-id').val(response.getData['id']);
                $('#restaurant-category-name').val(response.getData['name']);
                $('#restaurant-category-type').val(response.getData['type']);
                $('#restaurantCategoryModal').modal('show');
                $('.action-title').html('Edit');
                $('.addAction').addClass('d-none');
                $('.updateAction').removeClass('d-none');
            } else {
                alert("error");
            }
        }
    });
}

function updateItemCategory(){

    let name = validateField("#restaurant-category-name","input",".restaurant-category-name");
    let type = validateField("#restaurant-category-type","select",".restaurant-category-type");

    if (name == true && type == true) {
        let id = $('#restaurant-category-id').val();
        let name = $('#restaurant-category-name').val();
        let type = $('#restaurant-category-type').val();
        $.ajax({
            url: itemCategoryUpdate,
            type: "post",
            data: {
                id: id,
                name: name,
                type: type
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#restaurantCategoryModal').modal('hide');
                    $('.alert_msg').html('Item Category Updated Successfully');
                    var toastElement = document.getElementById('liveToast');
                    var toast = new bootstrap.Toast(toastElement);
                    toast.show();
                    $('#restaurant_item_category').DataTable().ajax.reload(); // Reload DataTable
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

function deleteRestaurantCategory(id){
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
                url: itemCategoryDelete,
                type: "POST",
                data: {
                    id: id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire("Deleted!", response.success, "success");
                        $('#restaurant_item_category').DataTable().ajax.reload();
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
    $('#restaurant-category-id').val('');
    $('#restaurant-category-name').val('');
    $('#restaurant-category-type').val('');
}