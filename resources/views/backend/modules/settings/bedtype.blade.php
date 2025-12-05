@extends('backend.layouts.main')
@section('title','Setting Bed Type')
@section('main-container')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Bed Type</h3>
                        {{-- <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">                                       
                        <svg class="stroke-icon">
                            <use href="backend/assets/svg/icon-sprite.svg#breadcrumb-home"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item active"> Bed Type</li>
                    </ol> --}}
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="float-end">
                            <button class="btn btn-primary px-2 bedType_Add" type="button" data-bs-toggle="modal"
                                data-bs-target="#bedTypeModel"><span class="btn-icon"><i class="ri-add-line"></i></span>
                                Add Bed Type</button>
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
                                <table class="hover row-border stripe" id="room_bedtype_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Bed Type</th>
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

    <!-- Bed Type modal start -->
    <div class="modal fade" id="bedTypeModel" tabindex="-1" role="dialog" aria-labelledby="bedTypeModel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title bedTypeTitle">Add Room View</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="bedType_form" class="g-3 needs-validation" novalidate="">
                        <div class="modal-body">
                            <div class="col-md-12">
                                <input type="hidden" id="bed_type_id">
                                <label class="form-label" for="bed_type">Bed Type Name</label>
                                <input class="form-control form-control-sm" id="bed_type" type="text" placeholder="Enter Bed Type Name" style="background-image: none;"
                                    required>
                                <div class="invalid-feedback">
                                    Enter Bed Type Name
                                </div>
                            </div>
                        </div>
                            <div class="modal-footer">
                                <button class="btn btn-outline-secondary" type="button"
                                    data-bs-dismiss="modal" onclick="resetmodel()">Cancel</button>
                                <button class="btn btn-primary bedType_submit" type="submit">Submit</button>
                                <button class="btn btn-primary bedType_update d-none" type="button"
                                    onclick="bedType_update(document.getElementById('bed_type_id').value)">Update</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bed Type modal end-->
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
        $('.bedType_Add').click(function() {
            $('#bed_type_id').val('');
            $('#bed_type').val('');
            $('.bedTypeTitle').html('Add Room Type Name');
            $('.needs-validation').removeClass('was-validated');
            $('.bedType_submit').removeClass('d-none');
            $('.bedType_update').addClass('d-none');
        });
        $('#bedType_form').on('submit', function(e) {
            e.preventDefault();
            let id = $('#bed_type_id').val();
            let bedtype = $('#bed_type').val();
            if (bedtype == '') {
                $('#bed_type').focus();
            } else {
                if ($('.bedType_update').is(':visible')) {
                bedType_update(id); // Trigger update function when update btn is active
                } else {
                    $.ajax({
                        url: "{{ route('bedtype.store') }}",
                        type: "post",
                        data: {
                            bedtype: bedtype
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#bedType_form').removeClass('was-validated');
                                $('#bedType_form')[0].reset();
                                $('#bedTypeModel').modal('hide');
                                $('.alert_msg').html('Bed Type Added Successfully');
                                var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                                toast.show();
                                $('#room_bedtype_table').DataTable().ajax.reload();
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

        let table = $('#room_bedtype_table').DataTable({
            processing: false,
            serverSide: true,
            ajax: {
                url: "{{ route('bedtype.index') }}",
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
                    data: 'bedtype',
                    name: 'bedtype'
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

        function bedtypeSwitch(id) {
            //  alert(id);
            $.ajax({
                url: "{{ route('bedtype.bedTypeSwitch') }}",
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
                        var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                        toast.show();             
                    $('#room_bedtype_table').DataTable().ajax.reload();
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

        function editbedType(id) {
            $.ajax({
                url: "{{ route('bedtype.get_bedtypeDetails') }}",
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
                        let bedtype = responseData['bedtype'];
                        $('#bed_type_id').val(id);
                        $('#bed_type').val(bedtype);
                        $('#bedTypeModel').modal('show');
                        $('.bedTypeTitle').html('Edit Room Type Name');
                        $('.bedType_submit').addClass('d-none');
                        $('.bedType_update').removeClass('d-none');
                    } else {
                        alert("error");
                    }
                }
            });
        }

        function bedType_update(id) {
            let bed_type = $('#bed_type').val();
            if (bed_type == '') {
                $('#bed_type').focus();
            } else {
                $.ajax({
                    url: "{{ route('bedtype.bedType_update') }}",
                    type: "post",
                    data: {
                        id: id,
                        bed_type: bed_type
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#bedTypeModel').modal('hide');
                            $('#bedType_form')[0].reset(); // Ensure form reset is called correctly
                            $('.alert_msg').html('Bed Type Updated Successfully');
                                var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                                toast.show();
                            $('#room_bedtype_table').DataTable().ajax.reload(); // Reload DataTable
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

        function delete_bedType(id) {
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
                        url: "{{ route('bedtype.bedType_delete') }}",
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
                                $('#room_bedtype_table').DataTable().ajax.reload();
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
                $('#bedType_form')[0].reset();
                $('#bedType_form').removeClass('was-validated');
            }
    </script>
@endsection
