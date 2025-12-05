@extends('backend.layouts.main')
@section('title','Setting Room Number')
@section('extra-css')
<style>
.image-container {
      display: inline-block;
      cursor: pointer;
    }
    .qr-big {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.8);
      justify-content: center;
      align-items: center;
    }
    .qr-big img {
      max-width: 90%;
      max-height: 90%;
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(255,255,255,0.3);
      transition: transform 0.3s ease;
    }
    .qr-big img:hover {
      transform: scale(1.1);
    }
</style>
@endsection
@section('main-container')

    <div class="page-body">
        <div class="container-fluid py-3">
            <div class="email-wrap bookmark-wrap">
                <div class="row">
                    <div class="col-xl-2 box-col-6">
                        @include('backend.layouts.sidebar_master')
                    </div>
                    <div class="col-xl-10 col-md-12 box-col-12">
                        <div class="container-fluid">
                            <div class="page-title mt-2">
                                <div class="row gx-0">
                                    <div class="col-12 col-sm-6">
                                        <h3 class="d-block">Room Number</h3>
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
                                                <table class="hover row-border stripe" id="room_Number_table">
                                                    <thead>
                                                        <tr>
                                                            <th>SL No.</th>
                                                            <th>Room Specification</th>
                                                            <th>Room Number</th>
                                                            <th>QR Code</th>
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
                </div>
            </div>
        </div>
    </div>

    <!-- Room Type Name modal start -->
    <div class="modal fade" id="roomNumberModal" tabindex="-1" role="dialog" aria-labelledby="roomNumberModal"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title roomName_title">Add Room Number</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="qr_code_data" style="display: none;"></div>
                    <form action="" id="room_number_form" class="needs-validation" novalidate="">
                            <div class="modal-body">
                                <input type="hidden" id="roomNum_id">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="room_specification_id">Select Room Category</label>
                                    <select class="form-control form-control-sm" id="room_specification_id" style="background-image: none;" required>
                                        <option value="">select</option>
                                        @foreach ($room_spec as $type )
                                        <option value="{{$type['id']}}">{{$type['room_category']}}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Select Room Specification
                                    </div>
                                </div> 
                                <div class="col-md-12">
                                    <label class="form-label" for="room_num">Room Number</label>
                                    <input class="form-control form-control-sm" id="room_num" type="number"
                                        placeholder="Enter Room Type Name" style="background-image: none;" required>
                                    <div class="invalid-feedback">
                                        Enter Room Number
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-outline-secondary" type="button"
                                    data-bs-dismiss="modal" onclick="resetmodel()">Cancel</button>
                                <button class="btn btn-primary roomNumber_submit" type="submit">Submit</button>
                                <button class="btn btn-primary roomNumber_update d-none" type="button"
                                    onclick="roonNum_update(document.getElementById('roomNum_id').value)">Update</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Room Type Name modal end-->

    <div class="qr-big" id="imageBigQR" onclick="closeModal()">
        <img id="qrModal" src="">
    </div>
@endsection
@section('extra-js')
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
<script>
    $('.roomNumber_add').click(function() {
        $("#room_number_form")[0].reset()
        $('#roomNum_id').val('');
        $('#roomNumberCat').val('');
        $('#roomNumberType').val('');
        $('#room_num').val('');
        $('.roomName_title').html('Add Room Number');
        $('.needs-validation').removeClass('was-validated');
        $('.roomNumber_submit').removeClass('d-none');
        $('.roomNumber_update').addClass('d-none');
    });

    $(document).ready(function() {
        $('#room_number_form').on('submit', function(e) {
            e.preventDefault();
            let id = $('#roomNum_id').val();
            let room_specification_id = $('#room_specification_id').val();
            let room_num = $('#room_num').val();

            if (room_specification_id == '') {
                $('#room_specification_id').focus();
            } else if (room_num == '') {
                $('#room_num').focus();
            }else {
                    if ($('.roomNumber_update').is(':visible')) {
                    roonNum_update(id); // Trigger update function when update btn is active
                } else {

                    $.ajax({
                        url: "{{ route('room.add_roomNumber') }}",
                        type: "POST",
                        data: {
                            room_specification_id: room_specification_id,room_num: room_num
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#room_number_form').removeClass('was-validated');
                                $('#roomNumberModal').modal('hide');
                                $('#room_number_form')[0].reset();
                                toastSuccessAlert(response.success);
                                $('#room_Number_table').DataTable().ajax.reload();
                            }else if(response.alreadyfound_error){
                                toastErrorAlert(response.alreadyfound_error);
                            } else {
                                alert(response.error_success);
                            }
                        }
                    });
                }
            }
            return false;
        });
    });


    let table = $('#room_Number_table').DataTable({
        processing: false,
        serverSide: true,
        ajax: {
            url: "{{ route('room.get_roomNumberData') }}",
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
                data: 'room_specification',
                name: 'room_specification'
            },
            {
                data: 'room_number',
                name: 'room_number'
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
            },
        ]
    });

    function roomTypeNameSwitch(id) {
        //  alert(x);
    }

    function editRoomNUm(id) {
        $.ajax({
            url: "{{ route('room.get_roomNumberDetails') }}",
            type: "GET",
            data: {
                id: id
            },
            success: function(response) {
                if (response.success) {
                    let responseData = response.getData[0];
                    $('#roomNum_id').val(id);
                    $('.qr_code_data').html(responseData.qr_code);
                    $('#room_specification_id').val(responseData.category_id);
                    $('#room_num').val(responseData.room_number);
                    $('#roomNumberModal').modal('show');
                    $('.roomName_title').html('Edit Room Number');
                    $('.roomNumber_submit').addClass('d-none');
                    $('.roomNumber_update').removeClass('d-none');
                } else {
                    alert("error");
                }
            }
        });
    }

    function roonNum_update(id) {
        let room_specification_id = $('#room_specification_id').val();
        let qr_code = $('.qr_code_data').html();
        let room_num = $('#room_num').val();
        if (room_specification_id == '') {
            $('#room_specification_id').focus();
        } else if (room_num == '') {
            $('#room_num').focus();
        } else {
            $.ajax({
                url: "{{ route('room.roomNumber_update') }}",
                type: "post",
                data: {
                    id: id,qr_code:qr_code,
                    room_specification_id: room_specification_id,
                    room_num: room_num
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        //  alert(response.success);
                        $('#roomNumberModal').modal('hide');
                        $('.alert_msg').html('Room Number Updated Successfully');
                        var toastElement = document.getElementById('liveToast');
                        var toast = new bootstrap.Toast(toastElement);
                        toast.show();
                        $('#room_number_form')[0].reset(); // Ensure form reset is called correctly
                        $('#room_Number_table').DataTable().ajax.reload(); // Reload DataTable
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

    function room_num_status(id) {
        //  alert(id);
        $.ajax({
            url: "{{ route('room.roomNumber_status') }}",
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
                    $('#room_Number_table').DataTable().ajax.reload();
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

    function delete_room_num(id) {
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
                    url: "{{ route('room.roomNumber_delete') }}",
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
                            $('#room_Number_table').DataTable().ajax.reload();
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
        $('#room_number_form')[0].reset();
        $('#room_number_form').removeClass('was-validated');
    }

    function openModal(src) {
        document.getElementById("qrModal").src = src;
        document.getElementById("imageBigQR").style.display = "flex";
    }

    function closeModal() {
        document.getElementById("imageBigQR").style.display = "none";
    }
</script>
@endsection
