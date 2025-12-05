@extends('backend.layouts.main')
@section('title','Setting Room Type Name')
@section('main-container')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Room Type Name</h3>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="float-end">
                            <button class="btn btn-primary ms-2 px-2 roomTypeName_add" type="button" data-bs-toggle="modal"
                                data-bs-target="#roomCategoryModal"><span class="btn-icon"><i class="ri-add-line"></i></span> Add Room Type Name</button>
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
                                <table class="hover row-border stripe" id="roomtype_name_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Room Type Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Room Type Name modal start -->
    <div class="modal fade" id="roomCategoryModal" tabindex="-1" role="dialog" aria-labelledby="roomCategoryModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title roomTypeName_title">Add Room Type Name</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="room_type_name_form" class="needs-validation" novalidate="">
                        <div class="modal-body">
                            <div class="col-md-12">
                                <input type="hidden" id="roomtypeName_id">
                                <label class="form-label" for="room_type_name">Room Type Name</label>
                                <input class="form-control form-control-sm" id="room_type_name" type="text"
                                    placeholder="Enter Room Type Name" style="background-image: none;" required>
                                <div class="invalid-feedback">
                                    Enter Room Type Name
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary" type="button"
                                data-bs-dismiss="modal"onclick="resetmodel()">Cancel</button>
                            <button class="btn btn-primary roomTypeName_submit" type="submit">Submit</button>
                            <button class="btn btn-primary roomTypeName_update d-none" type="button"
                                onclick="roonTypeName_update(document.getElementById('roomtypeName_id').value)">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Room Type Name modal end-->
    <script>
        document.getElementById("deleteBtn").addEventListener("click", () => {
            swal({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    swal("Your file has been deleted.", {
                        icon: "success",
                    });
                } else {
                    swal("Your imaginary file is safe!");
                }
            });
        });
    </script>
@endsection
@section('extra-js')
    <script>
        $('.roomTypeName_add').click(function() {
            $('#roomtypeName_id').val('');
            $('#room_type_name').val('');
            $('.needs-validation').removeClass('was-validated');
            $('.roomTypeName_title').html('Add Room Type Name');
            $('.roomTypeName_submit').removeClass('d-none');
            $('.roomTypeName_update').addClass('d-none');
        });

        $('#room_type_name_form').on('submit', function(e) {
            e.preventDefault();
            let id = $('#roomtypeName_id').val();
            let room_data = $('#room_type_name').val();
            //    alert(room_data);
            if (room_data === '') {
                $('#room_type_name').focus();
            } else {
                if ($('.roomTypeName_update').is(':visible')) {
                    roonTypeName_update(id); // Trigger update function when update btn is active
                } else {
                $.ajax({
                    url: "{{ route('room.add_roomTypeName') }}",
                    type: "POST",
                    data: {
                        roomtype_name: room_data
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // alert(response.success);
                            $('#room_type_name_form').removeClass('was-validated');
                            $('#roomCategoryModal').modal('hide');
                            $('#room_type_name').val('');
                            $('.alert_msg').html('Room Type Name Added Successfully');
                            var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                            toast.show();
                            $('#roomtype_name_table').DataTable().ajax.reload();
                        }else if(response.alreadyfound_error){
                            $('.alert_msg_danger').html(response.alreadyfound_error);
                            var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                            toast.show();
                        } else {
                            alert(response.error_success);
                        }
                    }
                });
            }
            }
            return false;
        });

        let table = $('#roomtype_name_table').DataTable({
            processing: false,
            serverSide: true,
            ajax: {
                url: "{{ route('room.get_roomTypeNameData') }}",
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
                    data: 'room_name',
                    name: 'room_name'
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

        function roomTypeNameSwitch(id) {
            alert(x);
        }

        function editRoomTypeName(id) {
            $.ajax({
                url: "{{ route('room.get_roomTypeNameDetails') }}",
                type: "GET",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        let responseData = response.getData[0];
                        let roomnameType = responseData['room_name'];
                        $('#roomtypeName_id').val(id);
                        $('#room_type_name').val(roomnameType);
                        $('#roomCategoryModal').modal('show');
                        $('.roomTypeName_title').html('Edit Room Type Name');
                        $('.roomTypeName_submit').addClass('d-none');
                        $('.roomTypeName_update').removeClass('d-none');
                    } else {
                        alert("error");
                    }
                }
            });


        }

        function roonTypeName_update(id) {
            let roomTypeName = $('#room_type_name').val();
             if (roomTypeName === '') {
                $('#room_type_name').focus();
            } else {
            $.ajax({
                url: "{{ route('room.roomTypeName_update') }}",
                type: "post",
                data: {
                    id: id,
                    roomTypeName: roomTypeName
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        //  alert(response.success);
                        $('#roomCategoryModal').modal('hide');
                        $('.alert_msg').html('Room Type Name Successfully');
                        var toastElement = document.getElementById('liveToast');
                        var toast = new bootstrap.Toast(toastElement);
                        toast.show();
                        $('#room_type_name_form')[0].reset(); // Ensure form reset is called correctly
                        $('#roomtype_name_table').DataTable().ajax.reload(); // Reload DataTable
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

        function roomTypeNameSwitch(id) {
            //  alert(id);
            $.ajax({
                url: "{{ route('room.roomtype_name_status') }}",
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

        function delete_roomType_name(id) {
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
                        url: "{{ route('room.roomtypename_delete') }}",
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
                                $('#roomtype_name_table').DataTable().ajax.reload();
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
    $('#room_type_name_form')[0].reset();
    $('#room_type_name_form').removeClass('was-validated');
  }
    </script>
@endsection
