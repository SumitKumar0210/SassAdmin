@extends('backend.layouts.main')
@section('title','Setting Room View')
@section('main-container')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Room View</h3>
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
                            <button class="btn btn-primary px-2 roomView_Add" type="button" data-bs-toggle="modal"
                                data-bs-target="#roomViewModal"><span class="btn-icon"><i class="ri-add-line"></i></span>
                                Add Room View</button>
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
                                <table class="hover row-border stripe" id="room_view_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>View Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Single</td>
                                            <td>
                                                <div class="flex-grow-1 icon-state switch-outline ">
                                                    <label class="switch mb-0">
                                                        <input type="checkbox" checked=""><span
                                                            class="switch-state bg-success"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <ul class="action">
                                                    <li class="edit"> <a href="#"><i
                                                                class="icon-pencil-alt"></i></a></li>
                                                    <li class="delete ms-1" id="deleteBtn"><i class="icon-trash"></i></li>
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

    <!-- Room View modal start -->
    <div class="modal fade" id="roomViewModal" tabindex="-1" role="dialog" aria-labelledby="roomViewModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title roomViewTitle">Add Room View</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="room_view_form" class="needs-validation" novalidate="">
                        <div class="modal-body">
                            <div class="col-md-12">
                                <input type="hidden" id="room_view_id">
                                <label class="form-label" for="room_view">Room View Name</label>
                                <input class="form-control form-control-sm" id="room_view" type="text" placeholder="Enter Room View Name" style="background-image: none;"
                                    required>
                                <div class="invalid-feedback">
                                    Enter Room View Name
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary" type="button"
                                data-bs-dismiss="modal" onclick="resetmodel()">Cancel</button>
                            <button class="btn btn-primary roomView_submit" type="submit">Submit</button>
                            <button class="btn btn-primary roomView_update d-none" type="button"
                                onclick="roonView_update(document.getElementById('room_view_id').value)">Update</button>
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
        // document.getElementById("deleteBtn").addEventListener("click", () => {
        //     swal({
        //         title: "Are you sure?",
        //         text: "You won't be able to revert this!",
        //         icon: "warning",
        //         buttons: true,
        //         dangerMode: true,
        //     }).then((willDelete) => {
        //         if (willDelete) {
        //             swal("Your file has been deleted.", {
        //                 icon: "success",
        //             });
        //         } else {
        //             swal("Your imaginary file is safe!");
        //         }
        //     });
        // });
        $('.roomView_Add').click(function() {
            $('#room_view_id').val('');
            $('#room_view').val('');
            $('.roomViewTitle').html('Add Room View');
            $('.needs-validation').removeClass('was-validated');
            $('.roomView_submit').removeClass('d-none');
            $('.roomView_update').addClass('d-none');
        });
    $('#room_view_form').on('submit', function(e) {
    e.preventDefault();
    let id = $('#room_view_id').val();
    let room_view = $('#room_view').val();
    if (room_view == '') {
        $('#room_view').focus();
    } else {
          if ($('.roomView_update').is(':visible')) {
            roonView_update(id); // Trigger update function when update btn is active
        } else {
        $.ajax({
            url: "{{ route('roomview.store') }}",
            type: "post",
            data: {
                room_view: room_view
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#room_cate_form').removeClass('was-validated');
                    $('#room_view_form')[0].reset();
                    $('#roomViewModal').modal('hide');
                    $('.alert_msg').html('Room View Added Successfully');
                    var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                    toast.show();
                    $('#room_view_table').DataTable().ajax.reload();
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

        let table = $('#room_view_table').DataTable({
            processing: false,
            serverSide: true,
            ajax: {
                url: "{{ route('roomview.index') }}",
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
                    data: 'view_name',
                    name: 'view_name'
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

        function roomViewSwitch(id) {
            //  alert(id);
            $.ajax({
                url: "{{ route('room.roomViewSwitch') }}",
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
                    $('#room_view_table').DataTable().ajax.reload();
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

        function editRoomView(id) {
            $.ajax({
                url: "{{ route('room.get_roomViewDetails') }}",
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
                        let roomView = responseData['view_name'];
                        $('#room_view_id').val(id);
                        $('#room_view').val(roomView);
                        $('#roomViewModal').modal('show');
                        $('.roomViewTitle').html('Edit Room View');
                        $('.roomView_submit').addClass('d-none');
                        $('.roomView_update').removeClass('d-none');
                    } else {
                        alert("error");
                    }
                }
            });
        }

        function roonView_update(id) {
            let room_view = $('#room_view').val();
             if (room_view == '') {
        $('#room_view').focus();
    } else {
            $.ajax({
                url: "{{ route('room.rooomView_update') }}",
                type: "post",
                data: {
                    id: id,
                    room_view: room_view
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#roomViewModal').modal('hide');
                        $('#room_view_form')[0].reset(); // Ensure form reset is called correctly
                        $('.alert_msg').html('Room View Updated Successfully');
                        var toastElement = document.getElementById('liveToast');
                        var toast = new bootstrap.Toast(toastElement);
                        toast.show();
                        $('#room_view_table').DataTable().ajax.reload(); // Reload DataTable
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

        function delete_roomView(id) {
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
                        url: "{{ route('room.rooomView_delete') }}",
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
                                $('#room_view_table').DataTable().ajax.reload();
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
        $('#room_view_form')[0].reset();
        $('#room_view_form').removeClass('was-validated');
  }
    </script>
@endsection
