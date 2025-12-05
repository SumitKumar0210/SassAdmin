$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

let table = $('#restaurant_raw_material').DataTable({
    processing: false,
    serverSide: true,
    ajax: rawMaterialView,
    columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'code',
            name: 'code'
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'uom',
            name: 'uom'
        },
        {
            data: 'min_qty',
            name: 'min_qty'
        },
        {
            data: 'max_qty',
            name: 'max_qty'
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

function addRawMaterial(){

    let itemcode = validateField("#restaurant-raw-material-itemcode","input",".restaurant-raw-material-itemcode");
    let name = validateField("#restaurant-raw-material-name","input",".restaurant-raw-material-name");
    let uom = validateField("#restaurant-raw-material-uom","select",".restaurant-raw-material-uom");
    let min_capping = validateField("#restaurant-raw-material-min-capping","amount",".restaurant-raw-material-min-capping");
    let max_capping = validateField("#restaurant-raw-material-max-capping","amount",".restaurant-raw-material-max-capping");
    
    if (itemcode == true && name == true && uom == true && min_capping == true && max_capping == true) {
        let itemcode = $('#restaurant-raw-material-itemcode').val();
        let name = $('#restaurant-raw-material-name').val();
        let uom = $('#restaurant-raw-material-uom').val();
        let min_capping = $('#restaurant-raw-material-min-capping').val();
        let max_capping = $('#restaurant-raw-material-max-capping').val();

        if(parseInt(min_capping) > parseInt(max_capping)){
            $('.alert_msg_danger').html('Min Capping is always less than Max Capping');
            var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
            toast.show();
        }else{
            $.ajax({
                url: rawMaterialAdd,
                type: "POST",
                data: {itemcode:itemcode,name:name,uom:uom,min_qty:min_capping,max_qty:max_capping},
                success: function(response) {
                    if (response.success) {
                        $('#restaurantRawMaterialModal').modal('hide');
                        $('.alert_msg').html('Raw Material Added Successfully');
                            var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                            toast.show();
                        $('#restaurant_raw_material').DataTable().ajax.reload();
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
        }
    } else {
        Swal.fire({
            title: "Invalid",
            text: "Name and Type is Required",
            icon: "warning"
        });  
    }
}

function RawMaterialSwitch(id){
    $.ajax({
        url: rawMaterialSwitchStatus,
        type: "POST",
        data: { id: id},
        success: function(response) {
            if (response.success) {
                $('.alert_msg').html('Status Changed Successfully');
                var toastElement = document.getElementById('liveToast');
                var toast = new bootstrap.Toast(toastElement);
                toast.show();                   
                $('#restaurant_raw_material').DataTable().ajax.reload();
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

function editRawMaterial(id){
    $.ajax({
        url: rawMaterialGet,
        type: "POST",
        data: {id: id},
        success: function(response) {
            if (response.success) {
                resetmodel();
                $('#restaurant-raw-material-id').val(response.getData['id']);
                $('#restaurant-raw-material-itemcode').val(response.getData['code']);
                $('#restaurant-raw-material-name').val(response.getData['name']);
                $('#restaurant-raw-material-uom').val(response.getData['uom']);
                $('#restaurant-raw-material-min-capping').val(response.getData['min_qty']);
                $('#restaurant-raw-material-max-capping').val(response.getData['max_qty']);
                $('#restaurantRawMaterialModal').modal('show');
                $('.action-title').html('Edit');
                $('.addAction').addClass('d-none');
                $('.updateAction').removeClass('d-none');
            } else {
                alert("error");
            }
        }
    });
}

function updateRawMaterial(){

    let itemcode = validateField("#restaurant-raw-material-itemcode","input",".restaurant-raw-material-itemcode");
    let name = validateField("#restaurant-raw-material-name","input",".restaurant-raw-material-name");
    let uom = validateField("#restaurant-raw-material-uom","select",".restaurant-raw-material-uom");
    let min_capping = validateField("#restaurant-raw-material-min-capping","amount",".restaurant-raw-material-min-capping");
    let max_capping = validateField("#restaurant-raw-material-max-capping","amount",".restaurant-raw-material-max-capping");

    if (itemcode == true && name == true && uom == true && min_capping == true && max_capping == true) {
        let id = $('#restaurant-raw-material-id').val();
        let itemcode = $('#restaurant-raw-material-itemcode').val();
        let name = $('#restaurant-raw-material-name').val();
        let uom = $('#restaurant-raw-material-uom').val();
        let min_capping = $('#restaurant-raw-material-min-capping').val();
        let max_capping = $('#restaurant-raw-material-max-capping').val();
        if(parseInt(min_capping) > parseInt(max_capping)){
            $('.alert_msg_danger').html('Min Capping is always less than Max Capping');
            var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
            toast.show();
        }else{
            $.ajax({
                url: rawMaterialUpdate,
                type: "post",
                data: {id:id,code:itemcode,name:name,uom:uom,min_qty:min_capping,max_qty:max_capping},
                success: function(response) {
                    if (response.success) {
                        $('#restaurantRawMaterialModal').modal('hide');
                        $('.alert_msg').html('Raw Material Updated Successfully');
                        var toastElement = document.getElementById('liveToast');
                        var toast = new bootstrap.Toast(toastElement);
                        toast.show();
                        $('#restaurant_raw_material').DataTable().ajax.reload(); // Reload DataTable
                    } else {
                        alert("error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("An error occurred: " + error);
                }
            });
        }
    } else {
        Swal.fire({
            title: "Invalid",
            text: "Name and Type is Required",
            icon: "warning"
        });  
    }
}

function deleteRawMaterial(id){
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
                url: rawMaterialDelete,
                type: "POST",
                data: {id: id},
                success: function(response) {
                    if (response.success) {
                        Swal.fire("Deleted!", response.success, "success");
                        $('#restaurant_raw_material').DataTable().ajax.reload();
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
    $('#restaurant-raw-material-id').val('');
    $('#restaurant-raw-material-itemcode').val('');
    $('#restaurant-raw-material-name').val('');
    $('#restaurant-raw-material-uom').val('');
    $('#restaurant-raw-material-min-capping').val('');
    $('#restaurant-raw-material-max-capping').val('');
}

function chkCappping(){
    let min_capping = $('#restaurant-raw-material-min-capping').val();
    let max_capping = $('#restaurant-raw-material-max-capping').val();
    if(parseInt(min_capping) > parseInt(max_capping)){
        $('.restaurant-raw-material-min-capping').html('Min is less than Maximum Capping');
    }else{
         $('.restaurant-raw-material-min-capping').html('');
    }
}