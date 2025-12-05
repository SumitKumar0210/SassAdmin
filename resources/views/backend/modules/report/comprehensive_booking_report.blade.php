@extends('backend.layouts.main')
@section('main-container')
@section('title')
Comprehensive Booking Report
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Comprehensive Booking Report</h3>
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
                                    <input class="form-control" id="date1" type="date" required="">
                                </div>
                                <div class="col-5">
                                    <input class="form-control" id="date2" type="date" required="">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-primary" type="button" onclick="searchReport()">Submit</button>
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
                                <table class="display" id="comprehensive_booking_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Booking Date</th>
                                            <th>Client Name</th>
                                            <th>Contact Number</th>
                                            <th>Hall Name</th>
                                            <th>Event Type</th>
                                            <th>Event Date</th>
                                            <th>Start Time</th>
                                            <th>End Time</th>
                                            <th>Guest Count</th>
                                            <th>Duration (hrs)</th>
                                            <th>Base Amount</th>
                                            <th>F&B Amount</th>
                                            <th>Additional Services</th>
                                            <th>Total Amount</th>
                                            <th>Advance Paid</th>
                                            <th>Balance Due</th>
                                            <th>Payment Status</th>
                                            <th>Booking Status</th>
                                            <th>Sales Rep</th>
                                            <th>Special Requirements</th>
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

    $(document).ready(function() {  
        table = $('#comprehensive_booking_table').DataTable({
            responsive: true, // Enable responsive feature when small display then + button enable to view all data
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('comprehensiveBooking.comprehensiveBookingView') }}",
                data: function(d) {
                    d.date_from = $('#date1').val();
                    d.date_to = $('#date2').val();
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
                { data: 'booking_date', name: 'booking_date', orderable: false, searchable: true },
                { data: 'client_name', name: 'client_name', orderable: false, searchable: true },
                { data: 'contact_number', name: 'contact_number', orderable: false, searchable: true },
                { data: 'hall', name: 'hall', orderable: false, searchable: true },
                { data: 'event_type', name: 'event_type', orderable: false, searchable: true },
                { data: 'event_date', name: 'event_date', orderable: false, searchable: true },
                { data: 'start', name: 'start', orderable: false, searchable: true },
                { data: 'end', name: 'end', orderable: false, searchable: true },
                { data: 'guest_count', name: 'guest_count', orderable: false, searchable: true },
                { data: 'duration', name: 'duration', orderable: false, searchable: true },
                { data: 'base_amount', name: 'base_amount', orderable: false, searchable: true },
                { data: 'food_amount', name: 'food_amount', orderable: false, searchable: true },
                { data: 'additional', name: 'additional', orderable: false, searchable: true },
                { data: 'total', name: 'total', orderable: false, searchable: true },
                { data: 'advance', name: 'advance', orderable: false, searchable: true },
                { data: 'balance', name: 'balance', orderable: false, searchable: true },
                { data: 'payment_status', name: 'payment_status', orderable: false, searchable: true },
                { data: 'booking_status', name: 'booking_status', orderable: false, searchable: true },
                { data: 'sales', name: 'sales'},
                { data: 'note', name: 'note'}
            ],     
        });
    });

    function searchReport(){
        table.ajax.reload();
    }
</script>
@endsection
