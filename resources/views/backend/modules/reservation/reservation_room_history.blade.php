@extends('backend.layouts.main')
@section('main-container')
@section('title')
Reservation Room Details
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Reservation Rooms</h3>
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
                                <table class="display" id="reservation_room_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Reservation ID</th>
                                            <th>Primary Name</th>
                                            <th>Booked On</th>
                                            <th>Status</th>
                                            <th>Room Alloted</th>
                                            <th>Check IN</th>
                                            <th>Check OUT</th>
                                            <th>Room Category</th>
                                            <th>Room Type</th>
                                            <th>Adults</th>
                                            <th>Childrens</th>
                                            <th>Infants</th>
                                            <th>Amount</th>
                                            <th>Extra Person</th>
                                            <th>Discount</th>
                                            <th>Paid Amount</th>
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
        let table = $('#reservation_room_table').DataTable({
                responsive: true, // Enable responsive feature when small display then + button enable to view all data
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('room.getAllRoomData') }}",
                    type: 'POST',
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
                    { data: 'reservation_id', name: 'reservation_id', orderable: false, searchable: true },
                    { data: 'primary_name', name: 'primary_name', orderable: true, searchable: true },
                    { data: 'created_at', name: 'created_at', orderable: false, searchable: true },
                    { data: 'status', name: 'status', orderable: false, searchable: true },
                    { data: 'room_alloted', name: 'room_alloted', orderable: false, searchable: true },
                    { data: 'checkin', name: 'checkin', orderable: false, searchable: true },
                    { data: 'checkout', name: 'checkout', orderable: false, searchable: true },
                    { data: 'room_category', name: 'room_category', orderable: false, searchable: true },
                    { data: 'room_type', name: 'room_type', orderable: false, searchable: true },
                    { data: 'adults', name: 'adults', orderable: false, searchable: true },
                    { data: 'childrens', name: 'childrens', orderable: false, searchable: true },
                    { data: 'infants', name: 'infants', orderable: false, searchable: true },
                    { data: 'amount', name: 'amount', orderable: false, searchable: true },
                    { data: 'extra_person', name: 'extra_person', orderable: false, searchable: true },
                    { data: 'discount', name: 'discount', orderable: false, searchable: true },
                    { data: 'paid_amount', name: 'paid_amount', orderable: false, searchable: true }
                ],     
        });
       
    </script>
@endsection
