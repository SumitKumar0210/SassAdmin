@extends('backend.layouts.main')
@section('main-container')
@section('title')
Reservation Checkout Reports
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Reservation Checkout Reports</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="card height-equal">
                        <div class="card-body">
                            <form class="row g-3 needs-validation custom-input invoice-setting-form" novalidate="">
                                <div class="col-5">
                                    <label class="form-label">Room No</label>
                                    <input class="form-control" id="room_no" type="text">
                                </div>
                                <div class="col-5">
                                    <label class="form-label">Guest Name</label>
                                    <input class="form-control" id="guest_name" type="text">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-primary mt-4" type="button" onclick="searchReport()">Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
                                            <th>Reservation Number</th>
                                            <th>Guest Name</th>
                                            <th>Room Type</th>
                                            <th>Room Number</th>
                                            <th>Check-in Date</th>
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
@endsection
@section('extra-js')
    <script>
        let table;
        
        table = $('#reservation_room_table').DataTable({
            responsive: true, // Enable responsive feature when small display then + button enable to view all data
            processing: false,
            serverSide: true,
            ajax: {
                url: "{{ route('reservation-checkout-detail.reservationCheckoutReportView') }}",
                data: function(d) {
                    d.room = $('#room_no').val();
                    d.guest = $('#guest_name').val();
                },
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
                { data: 'reservation', name: 'reservation', orderable: false, searchable: true },
                { data: 'guest_name', name: 'guest_name', orderable: false, searchable: true },
                { data: 'room_type', name: 'room_type', orderable: false, searchable: true },
                { data: 'room_number', name: 'room_number', orderable: false, searchable: true },
                { data: 'checkin_date', name: 'checkin_date', orderable: false, searchable: true },
                { data: 'action', name: 'action'},
            ],     
        });
       
        function searchReport() {
            table.ajax.reload();
        }

        function edit_reservation(id, reservationid) {
            let res = 'reservation='+reservationid+'&reservation_room_id='+id;
            let url = '../../reservation/edit-reservation/'+res;
            window.location.href = url;
        }
    </script>
@endsection
