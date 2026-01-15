@extends('backend.layouts.main')
@section('main-container')
@section('title')
Room Status
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Room Status</h3>
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
                                <table class="display" id="reservation_room_table123">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Room No</th>
                                            <th>Room Type</th>
                                            <th>Current Status</th>
                                            <th>Make Available</th>
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
@endsection
@section('extra-js')
    <script>
        let table = $('#reservation_room_table123').DataTable({
            responsive: true, // Enable responsive feature when small display then + button enable to view all data
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Room Status Report'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Room Status Report'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Room Status Report'
                }
            ],
            ajax: {
                url: "{{ route('roomStatus.roomStatusView') }}",
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                error: function(xhr, error, thrown) {
                    console.error(xhr.responseText); // Use console.error for better error logs
                    alert(`Error: ${thrown}`); // Template literals for readability
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: true },
                { data: 'room_number', name: 'room_number', orderable: false, searchable: true },
                { data: 'room_type', name: 'room_type', orderable: true, searchable: true },
                { data: 'room_status', name: 'room_status', orderable: false, searchable: true },
                { data: 'action', name: 'action', orderable: false, searchable: true },
            ],     
        });

        function makeItVacant(id){

            Swal.fire({
                text: "Are you sure to make it Vacant?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Do it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('roomStatus.roomStatusUpdate') }}",
                        type: "POST",
                        data: { id:id },
                        success: function (response) {
                            if(response.success == "success"){
                                $('.alert_msg').html('Room closer added');
                                var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                                toast.show();
                                setTimeout(() => {
                                    window.location.reload();
                                },2500);
                            }else {
                                Swal.fire({ icon: "warning", title: "Something went wrong!" });
                            }
                        }
                    });
                }
            });
        }
       
    </script>
@endsection
