$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

let table = $('#taxslab_table').DataTable({
    processing: false,
    serverSide: true,
    ajax: {
        url: taxSlabView,
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
            data: 'category',
            name: 'category'
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'rate',
            name: 'rate'
        },
        {
            data: 'default',
            name: 'default',
            orderable: false,
            searchable: false
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

function addTaxSlab(){
    let category = $('#tax_slab_catgory').val();
    let name = $('#tax_slab_name').val();
    let rate = $('#tax_slab_rate').val();
    let releted_to = $('#tax_slab_releted_to').val();
    // let set_default = 0;
    
    // if($("#tax_slab_mark_as_default").prop('checked') == true){
    //     set_default = 1;
    // }
    if (category == '') {
        $('#tax_slab_catgory').focus();
    }else if(name == ''){
        $('#tax_slab_name').focus();
    }else if(rate == ''){
        $('#tax_slab_rate').focus();
    }else{
        $.ajax({
            url: taxSlabAdd,
            type: "post",
            data: {
                name:name,rate:rate,category:category,releted_to:releted_to
            },
            success: function(response) {
                if (response.success) {
                    $('#taxslab_form').removeClass('was-validated');
                    $('#taxslab_form')[0].reset();
                    $('#taxslabModel').modal('hide');
                    $('.alert_msg').html('Tax Slab Added Successfully');
                    var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                    toast.show();
                    $('#taxslab_table').DataTable().ajax.reload();
                } else if(response.alreadyfound_error){
                Swal.fire({
                    title: "Already Found",
                    text: response.alreadyfound_error,
                    icon: "warning"
                    });                    
                } else {
                    //alert("Error");
                }
            }
        });
    }
}

function taxSlabSwitch(id){
    $.ajax({
        url: taxSlabSwitchStatus,
        type: "POST",
        data: {id: id},
        success: function(response) {
            if (response.success) {
                $('.alert_msg').html('Status Changed Successfully');
                var toastElement = document.getElementById('liveToast');
                var toast = new bootstrap.Toast(toastElement);
                toast.show();                   
                $('#taxslab_table').DataTable().ajax.reload();
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

function editTaxSlab(id){
    $.ajax({
        url: taxSlabGet,
        type: "POST",
        data: {id: id},
        success: function(response) {
            if (response.success) {
                resetmodel();
                $('#tax_slab_id').val(response.getData['id']);
                $('#tax_slab_name').val(response.getData['name']);
                $('#tax_slab_rate').val(response.getData['rate']);
                $('#tax_slab_catgory').val(response.getData['category_id']);
                $('#tax_slab_releted_to').val(response.getData['belongs_to']);
                if(response.getData['belongs_to'] > 0){
                    $('#tax_slab_set_relation').prop('checked',true);
                    $('.set_relation').removeClass('d-none');
                }
                $('#taxslabModel').modal('show');
                $('.action-title').html('Edit');
                $('.addAction').addClass('d-none');
                $('.updateAction').removeClass('d-none');
            } else {
                alert("error");
            }
        }
    });
}

function updateTaxSlab(){
    let id = $('#tax_slab_id').val();
    let category = $('#tax_slab_catgory').val();
    let name = $('#tax_slab_name').val();
    let rate = $('#tax_slab_rate').val();
    let releted_to = $('#tax_slab_releted_to').val();
    
    if (category == '') {
        $('#tax_slab_catgory').focus();
    }else if(name == ''){
        $('#tax_slab_name').focus();
    }else if(rate == ''){
        $('#tax_slab_rate').focus();
    }else{
        $.ajax({
            url: taxSlabUpdate,
            type: "POST",
            data: {
                id: id,name:name,rate:rate,category:category,releted_to:releted_to
            },
            success: function(response) {
                if (response.success) {
                    $('#taxslabModel').modal('hide');
                    $('#taxslab_form')[0].reset(); // Ensure form reset is called correctly
                    $('.alert_msg').html('Tax Slab Updated Successfully');
                    var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                    toast.show();
                    $('#taxslab_table').DataTable().ajax.reload(); // Reload DataTable
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
}

function deleteTaxSlab(id){
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
                url: taxCategoryDelete,
                type: "POST",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire("Deleted!", response.success, "success");
                        $('#taxslab_table').DataTable().ajax.reload();
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
    $('#taxCategory_id').val('');
    $('#taxCategory_name').val('');
    $('#tax_slab_set_relation').val('');
    $('#tax_slab_rate').val('');
    $('.set_relation').addClass('d-none');
}

// function resetmodel(){
//     $('.action-title').html('Add');
//     $('.addAction').removeClass('d-none');
//     $('.updateAction').addClass('d-none');
//     $('#taxslab_form')[0].reset();
//     $('#taxslab_form').removeClass('was-validated');
// }

function setCheckRelation(){
    if($("#tax_slab_set_relation").prop('checked') == true){
        $('.set_relation').removeClass('d-none');
    }else{
        $('.set_relation').addClass('d-none');
    }
}

function switchDefaultTax(id){
    $.ajax({
        url: taxSlabSwitchDefaultTax,
        type: "POST",
        data: { id: id},
        success: function(response) {
            if (response.success) {
                $('.alert_msg').html('Status Changed Successfully');
                var toastElement = document.getElementById('liveToast');
                var toast = new bootstrap.Toast(toastElement);
                toast.show();                   
                $('#taxslab_table').DataTable().ajax.reload();
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
