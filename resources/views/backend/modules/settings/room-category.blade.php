@extends('backend.layouts.main')
@section('title','Setting Room Category')
@section('main-container')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title mt-2">
            <div class="row gx-0">
                <div class="col-12 col-sm-6">
                    <h3 class="d-block">Room Category</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <div class="float-end">
                        <button class="btn btn-primary ms-2 px-2 roomCate_add" type="button" data-bs-toggle="modal" data-bs-target="#roomCategoryModal"><span class="btn-icon"><i class="ri-add-line"></i>
                        </span>Add Room Category</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                                <table class="hover row-border stripe" id="room_category_table">
                                <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Category Name</th> 
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td> 
                                            <ul class="action"> 
                                                <li class="edit"> <a href="#"><i class="icon-pencil-alt"></i></a></li>
                                                <li class="delete ms-1 d-none" id="deleteBtn"><i class="icon-trash"></i></li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                              
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>     
    </div>
</div>
<div class="loader"></div>
    <!-- Room category modal start -->
    <div class="modal fade" id="roomCategoryModal" tabindex="-1" role="dialog" aria-labelledby="roomCategoryModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title roomCategory_title">Add Room Category</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="room_cate_form" class="needs-validation" novalidate>
                            <div class="modal-body">
                                <div class="col-md-12">
                                    <input type="hidden" id="room_category_id">
                                    <label class="form-label" for="room_cat">Room Category Name</label>
                                    <input class="form-control form-control-sm" id="room_cat" type="text" placeholder="Enter Room Category Name" style="background-image: none;" required>
                                    <div class="invalid-feedback">
                                        Enter Room Category Name
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" onclick="resetmodel()">Cancel</button>
                                <button class="btn btn-primary roomcat_submit" type="submit">Submit</button>
                                <button class="btn btn-primary roomcat_update d-none" type="button" onclick="roonCat_update(document.getElementById('room_category_id').value)">Update</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-js')

 <script>
    $('.roomCate_add').on('click',function(e){
    e.preventDefault();
        $('#room_category_id').val('');
        $('#room_cat').val('');
        $('.roomCategory_title').html('Add Room Category');
        $('.needs-validation').removeClass('was-validated');
        $('.roomcat_submit').removeClass('d-none');
        $('.roomcat_update').addClass('d-none');
    });
        //   ------------

    $('#room_cate_form').on('submit', function(event) {
        event.preventDefault();
        let id = $('#room_category_id').val();
        let room_category = $('#room_cat').val();
        if(room_category == ''){
            $('#room_cat').focus();
        } else {
            if ($('.roomcat_update').is(':visible')) {
            roonCat_update(id); // Trigger update function when update btn is active
        } else {
            $.ajax({
                url: "{{route('add_room_category')}}",
                method: "POST",
                data: {
                    room_category: room_category
                },
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    if (response.success) {
                        // Optionally close the modal and reset the form
                        $('#room_cate_form').removeClass('was-validated');
                        $('#roomCategoryModal').modal('hide');
                        $('#room_cate_form')[0].reset();
                        $('.alert_msg').html('New Category Added Successfully');
                        var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                        toast.show();
                        // Optionally reload the DataTable to show the new category
                        $('#room_category_table').DataTable().ajax.reload();
                    } else if(response.alreadyfound_error){
                        $('.alert_msg_danger').html(response.alreadyfound_error);
                        var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                        toast.show();
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
    }
        return false; // Ensure the form does not submit the default way
    });


    
   let table = $('#room_category_table').DataTable({
        processing: false,
        serverSide: true,
        ajax: {
            url: "{{ route('getRoomCategoryData') }}",
            // type: "GET",
            // headers: {
            //     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            // },
            // beforeSend: function() {
            // // Show the custom 
            // },
            // complete: function() {
            //     // Hide the custom loader$
            // },
            error: function(xhr, error, thrown) {
                console.log(xhr.responseText);
                alert('Error: ' + thrown);
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex'},
            { data: 'room_category', name: 'room_category' },
            { data: 'status', name: 'status',orderable:false, searchable:false},
            { data: 'action', name: 'action' ,orderable:false, searchable:false}
        ]
    });
    function myyfunction(){
        alert("slider");
    }
    // funciton deltee(){
    //     alert("deletee");
    // }
    // $('#deleteBtn').onclick();
    function editRoomCat(id){
        $.ajax({
            url:"{{route('room.get_roomCategoryDetails')}}",
            type:"GET",
            data:{id:id},
            success:function(response){
                if(response.success){
                    let responseData = response.getData[0];
                    let roomcat = responseData['room_category'];
                    $('#room_category_id').val(id);
                    $('#room_cat').val(roomcat);
                    $('#roomCategoryModal').modal('show');
                    $('.roomCategory_title').html('Edit Room Category');
                    $('.roomcat_submit').addClass('d-none');
                    $('.roomcat_update').removeClass('d-none');
                }
                else{
                    alert("error");
                }
            }
        });
    }
    function roonCat_update(id){
        let roomCategory = $('#room_cat').val();
          if(roomCategory == ''){
            $('#room_cat').focus();
        } else {
        $.ajax({
            url: "{{route('room.roomCategory_update')}}",
            type: "post",
            data: {id: id, roomCategory: roomCategory},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                if (response.success) {
                    // alert(response.success);
                    $('#roomCategoryModal').modal('hide');
                    $('#room_cate_form')[0].reset();
                    $('.alert_msg').html('Room Category Updated Successfully');
                    var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                    toast.show();
                    $('#room_category_table').DataTable().ajax.reload();
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
    }
    function room_cat_status(id){
      //  alert(id);
        $.ajax({
            url: "{{route('room.roomCategory_status')}}",
            type: "POST",
            data:{id:id},
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                if (response.success) {
                    $('.alert_msg').html('Status Changed Successfully');
                    var toastElement = document.getElementById('liveToast');
                    var toast = new bootstrap.Toast(toastElement);
                    toast.show();
                    $('#room_category_table').DataTable().ajax.reload();
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
            function delete_room_cat(id){
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
                url: "{{route('room.roomCategory_delete')}}",
                type: "POST",
                data: {id: id},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
               success: function(response) {
                    if (response.success) {
                        Swal.fire("Deleted!", response.success, "success");
                        $('#room_category_table').DataTable().ajax.reload();
                    } else if (response.error_success) { // Corrected key
                        Swal.fire("Warning!", response.error_success, "warning");
                    } else {
                        Swal.fire("Error!", "An unexpected error occurred", "error");
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
                $('#room_cate_form')[0].reset();
                $('#room_cate_form').removeClass('was-validated');
            }
</script>
@endsection
