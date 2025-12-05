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
                <div class="col-lg-12 col-sm-12">
                    <div class="card height-equal">
                        <div class="card-body">
                            <form class="row g-3 needs-validation custom-input invoice-setting-form" novalidate="">
                                <div class="col-5">
                                    <select class="form-control" id="type">
                                        <option value="All">All</option>
                                        <option value="checkin">Checked-in</option>
                                        <option value="checkout">Check-out</option>
                                    </select>
                                </div>
                                <div class="col-5">
                                    <input class="form-control" id="date" type="date" required="" value="{{date('Y-m-d')}}">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-primary" type="button" onclick="searchReport()">Search</button>
                                    <button class="btn btn-warning" type="button" onclick="printReport()">Print</button>
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
                                            <th>Booking Date</th>
                                            <th>Booking Time</th>
                                            <th>Primary Guest Name</th>
                                            <th>Guest Type</th>
                                            <th>Contact Number</th>
                                            <th>Email Address</th>
                                            <th>Address</th>
                                            <th>Nationality</th>
                                            <th>ID Type</th>
                                            <th>ID Number</th>
                                            <th>Company Name</th>
                                            <th>Check-in Date</th>
                                            <th>Check-out Date</th>
                                            <th>Number of Nights</th>
                                            <th>Number of Rooms</th>
                                            <th>Room Type Requested</th>
                                            <th>Number of Adults</th>
                                            <th>Number of Children</th>
                                            <th>Extra Bed Required</th>
                                            <th>Smoking Preference</th>
                                            <th>Bed Type Preference</th>
                                            <th>Rate Plan</th>
                                            <th>Base Rate</th>
                                            <th>Discounts Applied</th>
                                            <th>Total Room Charges</th>
                                            <th>Tax Amount</th>
                                            <th>Total Amount</th>
                                            <th>Payment Status</th>
                                            <th>Reservation Status</th>
                                            <th>Check-in Status</th>
                                            <th>Check-out Status</th>
                                            <th>Last Modified Date</th>
                                            <th>Cancellation Date</th>
                                            <th>Cancellation Reason</th>
                                            <th>No-show Flag</th>
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
                url: "{{ route('report.reservationReportView') }}",
                data: function(d) {
                    d.type = $('#type').val();
                    d.date = $('#date').val();
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
                { data: 'booking_date', name: 'booking_date', orderable: false, searchable: true },
                { data: 'booking_time', name: 'booking_time', orderable: false, searchable: true },
                { data: 'primary_guest', name: 'primary_guest', orderable: false, searchable: true },
                { data: 'guest_type', name: 'guest_type', orderable: false, searchable: true },
                { data: 'contact_number', name: 'contact_number', orderable: false, searchable: true },
                { data: 'email_address', name: 'email_address', orderable: false, searchable: true },
                { data: 'address', name: 'address', orderable: false, searchable: true },
                { data: 'nationality', name: 'nationality', orderable: false, searchable: true },
                { data: 'id_type', name: 'id_type', orderable: false, searchable: true },
                { data: 'id_number', name: 'id_number', orderable: false, searchable: true },
                { data: 'company_name', name: 'company_name', orderable: false, searchable: true },
                { data: 'check_in_date', name: 'check_in_date', orderable: false, searchable: true },
                { data: 'check_out_date', name: 'check_out_date', orderable: false, searchable: true },
                { data: 'no_of_nights', name: 'no_of_nights', orderable: true, searchable: true },
                { data: 'no_of_room', name: 'no_of_room', orderable: false, searchable: true },
                { data: 'room_type_requested', name: 'room_type_requested', orderable: false, searchable: true },
                { data: 'adult', name: 'adult', orderable: false, searchable: true },
                { data: 'children', name: 'children', orderable: false, searchable: true },
                { data: 'extra_bed_required', name: 'extra_bed_required', orderable: false, searchable: true },
                { data: 'smoking', name: 'smoking', orderable: false, searchable: true },
                { data: 'bed_type_preference', name: 'bed_type_preference', orderable: false, searchable: true },
                { data: 'rate_plan', name: 'rate_plan', orderable: false, searchable: true },
                { data: 'base_rate', name: 'base_rate', orderable: false, searchable: true },
                { data: 'discount_apply', name: 'discount_apply', orderable: false, searchable: true },
                { data: 'total_room_charge', name: 'total_room_charge', orderable: false, searchable: true },
                { data: 'tax_amount', name: 'tax_amount', orderable: false, searchable: true },
                { data: 'total_amount', name: 'total_amount', orderable: false, searchable: true },
                { data: 'payment_status', name: 'payment_status', orderable: false, searchable: true },
                { data: 'reservation_status', name: 'reservation_status', orderable: false, searchable: true },
                { data: 'check_in_status', name: 'check_in_status', orderable: false, searchable: true },
                { data: 'check_out_status', name: 'check_out_status', orderable: false, searchable: true },
                { data: 'last_modified', name: 'last_modified', orderable: false, searchable: true },
                { data: 'cancellation_date', name: 'cancellation_date', orderable: false, searchable: true },
                { data: 'cancellation_reason', name: 'cancellation_reason', orderable: false, searchable: true },
                { data: 'no_show_flag', name: 'no_show_flag', orderable: false, searchable: true }
            ],     
        });
       
        function searchReport() {
            table.ajax.reload();
        }

        function printReport(){
            let type = $('#type').val();
            let date = $('#date').val();
            let url = '../report/reservationReportPrint/type='+type+'&date='+date;
            window.open(url,'_blank');
        }
    </script>
@endsection
