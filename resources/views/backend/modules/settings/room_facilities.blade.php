@extends('backend.layouts.main')
@section('title','Setting Room Facilities')
@section('main-container')
 <div class="page-body">
    <div class="container-fluid">
        <div class="page-title mt-2">
            <div class="row gx-0">
                <div class="col-12 col-sm-6">
                    <h3 class="d-block">Room Aminities & Facilities</h3>
                    {{-- <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">                                       
                        <svg class="stroke-icon">
                            <use href="backend/assets/svg/icon-sprite.svg#breadcrumb-home"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item active"> Room View</li>
                    </ol> --}}
                </div>
                <div class="col-12 col-sm-6">
                    <div class="float-end">
                        <button class="btn btn-primary px-2 facilitiesAmenities_Add" type="button" data-bs-toggle="modal" data-bs-target="#facilitiesAmenitiesModal"><span class="btn-icon"><i class="ri-add-line"></i></span> Add Aminities & Facilities</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <!-- Zero Configuration  Starts-->
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="hover row-border stripe" id="room_facilities_table">
                                <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Image Icon</th>
                                        <th>Amenities & Facilities</th> 
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- <tr>
                                        <td>1</td>
                                        <td>
                                            <img src="backend/assets/images/dashboard-2/selling/02.png">
                                        </td>
                                        <td>Air Condition</td>
                                        <td>
                                            <div class="flex-grow-1 icon-state switch-outline ">
                                                <label class="switch mb-0">
                                                <input type="checkbox" checked=""><span class="switch-state bg-success"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td> 
                                            <ul class="action"> 
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a></li>
                                                <li class="delete ms-1" id="deleteBtn"><i class="icon-trash"></i></li>
                                            </ul>
                                        </td>
                                    </tr> --}}
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Room View modal start -->
<div class="modal fade" id="facilitiesAmenitiesModal" tabindex="-1" role="dialog" aria-labelledby="facilitiesAmenitiesModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper  text-start dark-sign-up">
                <div class="modal-header">
                    <h4 class="modal-title facilities_Titile">Add Room Amenities & Facilities</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="facilitiesAmenities_form" class="mb-3 needs-validation" novalidate="">
                     <div class="modal-body">
                        <div class="col-md-12 mb-3">
                            <input type="hidden" id="facilitiesAmenities_id">
                            <label class="form-label" for="facilities">Amenities & Facilities</label>
                            <input class="form-control form-control-sm" id="facilities" type="text" placeholder="Enter Amenities & Facilities" style="background-image: none;" required>
                            <div class="invalid-feedback">
                                Enter Amenities & Facilities
                            </div>
                        </div>
                        <div class="form-label fs-14 img_class" style="display:none1;">
                            <img class="img_data" height="40px" width="40px">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="facilities_image">Upload Amenities & Facilities Image</label>
                            <input class="form-control" id="facilities_image" type="file" style="background-image: none;" required> 
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal"  onclick="resetmodel()">Cancel</button>
                        <button class="btn btn-primary facilities_submit" type="submit">Submit</button>
                                    <button class="btn btn-primary facilities_update d-none" type="button"
                                        onclick="facilitiesAme_update(document.getElementById('facilitiesAmenities_id').value)">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Room View modal end-->
@endsection
@section('extra-js')
<script>
    $('.facilitiesAmenities_Add').click(function() {
        $('#facilitiesAmenities_id').val('');
        $('#facilities').val('');
        $('#facilities_image').val('');
        $('.facilities_Titile').html('Add facilities & Amenities');
        $('.img_class').addClass('d-none');
        $('.needs-validation').removeClass('was-validated');
        $('.facilities_submit').removeClass('d-none');
        $('.facilities_update').addClass('d-none');
    });
    $('#facilitiesAmenities_form').on('submit', function(e) {
    e.preventDefault();
     let id = $('#facilitiesAmenities_id').val();
    let facilities = $('#facilities').val();
    let facilities_image = $('#facilities_image').prop('files')[0];
    if (facilities == '') {
        $('#facilities').focus();
    } else if (!facilities_image) {
        $('#facilities_image').css('border-color', 'red');
                $('#facilities_image').focus();
    } else {
          if ($('.facilities_update').is(':visible')) {
            facilitiesAme_update(id); // Trigger update function when update btn is active
        } else {
        let formData = new FormData();
        formData.append('facilities', facilities);
        formData.append('facilities_image', facilities_image);
        $.ajax({
            url: "{{ route('facilities.store') }}",
            type: "post",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    $('#facilitiesAmenities_form').removeClass('was-validated');
                    $('#facilitiesAmenities_form')[0].reset();
                    $('#facilitiesAmenitiesModal').modal('hide');
                    $('.alert_msg').html('Facilities & Amenities Added Successfully');
                        var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                        toast.show();
                    $('#room_facilities_table').DataTable().ajax.reload();
                } else if(response.alreadyfound_error){
                       $('.alert_msg_danger').html(response.alreadyfound_error);
                        var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                        toast.show();                
                        } else {
                        alert("Error");
                    }
            }
        });
    }
    }
});


    let table = $('#room_facilities_table').DataTable({
        processing: false,
        serverSide: true,
        ajax: {
            url: "{{ route('facilities.index') }}",
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
                data: 'image_icon',
                name: 'image_icon'
            },
            {
                data: 'facilities',
                name: 'facilities'
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

    function facilities_switch(id) {
        //  alert(id);
        $.ajax({
            url: "{{ route('facilities.facilities_switch') }}",
            type: "POST",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('.alert_msg').html('Status Updated Successfully');
                    var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                    toast.show();
                    $('#room_facilities_table').DataTable().ajax.reload();
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

    function edit_facilities(id) {
        $.ajax({
            url: "{{ route('facilities.get_facilitiesdetails') }}",
            type: "POST",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    let responseData = response.getData[0];
                    let facilities = responseData['facilities'];
                    let facilities_img = responseData['image_icon'];
                    $('#facilitiesAmenities_id').val(id);
                    $('#facilities').val(facilities);
                    $('#facilitiesAmenitiesModal').modal('show');
                    $('.img_class').removeClass('d-none');
                    let source = "backend/uploads/facilitiesAmenities/" + facilities_img;
                    $('.img_data').attr("src", source);
                    $('.facilities_Titile').html('Edit facilities & Amenities');
                    $('.facilities_submit').addClass('d-none');
                    $('.facilities_update').removeClass('d-none');
                } else {
                    alert("error");
                }
            }
        });
    }

    function facilitiesAme_update(id) {
        let facilities = $('#facilities').val();
        let facilities_image = $('#facilities_image').prop('files')[0];
        if (facilities == '') {
        $('#facilities').focus();
        } else {
        let formData = new FormData();
        formData.append('id', id);
        formData.append('facilities', facilities);
        formData.append('facilities_image', facilities_image);
        $.ajax({
            url: "{{ route('facilities.facilities_update') }}",
            type: "post",
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success) {
                    //  alert(response.success);
                    $('#facilitiesAmenitiesModal').modal('hide');
                    $('#facilitiesAmenities_form')[0].reset(); // Ensure form reset is called correctly
                    $('.alert_msg').html('Room Facilities & Amenities Updated Successfully');
                    var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                    toast.show();
                    $('#room_facilities_table').DataTable().ajax.reload(); // Reload DataTable
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

    function delete_facilities(id) {
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
                    url: "{{ route('facilities.facilities_delete') }}",
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
                            $('#room_facilities_table').DataTable().ajax.reload();
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
                $('#facilitiesAmenities_form')[0].reset();
                $('#facilitiesAmenities_form').removeClass('was-validated');
            }
</script>
@endsection
