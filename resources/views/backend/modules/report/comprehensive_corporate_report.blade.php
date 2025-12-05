@extends('backend.layouts.main')
@section('main-container')
@section('title')
Comprehensive Corporate Report
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Comprehensive Corporate Report</h3>
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
                                <table class="display" id="comprehensive_corporate_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Client Name</th>
                                            <th>Contact Number</th>
                                            <th>Reservation Date</th>
                                            <th>Room No</th>
                                            <th>Tariff Type</th>
                                            <th>Tariff Amount</th>
                                            <th>Check-in Date</th>
                                            <th>Check-out Date</th>
                                            <th>Pax</th>
                                            <th>Duration (days)</th>
                                            <th>Total Amount</th>
                                            <th>F&B Amount</th>
                                            <th>Total Amount</th>
                                            <th>Advance Paid</th>
                                            <th>Balance Due</th>
                                            <th>Payment Status</th>
                                            <th> Status</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
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
        table = $('#comprehensive_corporate_table').DataTable({
            responsive: true, // Enable responsive feature when small display then + button enable to view all data
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('comprehensiveCorporate.comprehensiveCorporateView') }}",
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
                { data: 'client_name', name: 'client_name', orderable: false, searchable: true },
                { data: 'contact_number', name: 'contact_number', orderable: false, searchable: true },
                { data: 'reservation_date', name: 'reservation_date', orderable: false, searchable: true },
                { data: 'room_no', name: 'room_no', orderable: false, searchable: true },
                { data: 'tariff_type', name: 'tariff_type', orderable: false, searchable: true },
                { data: 'tariff_amount', name: 'tariff_amount', orderable: false, searchable: true },
                { data: 'checkin_date', name: 'checkin_date', orderable: false, searchable: true },
                { data: 'checkout_date', name: 'checkout_date', orderable: false, searchable: true },
                { data: 'pax', name: 'pax', orderable: false, searchable: true },
                { data: 'duration', name: 'duration', orderable: false, searchable: true },
                { data: 'total_amount', name: 'total_amount', orderable: false, searchable: true },
                { data: 'food_amount', name: 'food_amount', orderable: false, searchable: true },
                { data: 'total', name: 'total', orderable: false, searchable: true },
                { data: 'advance', name: 'advance', orderable: false, searchable: true },
                { data: 'balance', name: 'balance', orderable: false, searchable: true },
                { data: 'payment_status', name: 'payment_status', orderable: false, searchable: true },
                { data: 'status', name: 'status', orderable: false, searchable: true },
            ],     
        });
    });

    function searchReport(){
        table.ajax.reload();
    }
</script>
@endsection
