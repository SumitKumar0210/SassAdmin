@extends('backend.layouts.main')
@section('main-container')
@section('title')
Hall Utilization Report
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Hall Utilization Reports</h3>
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
                                <table class="display" id="hall_utilization_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Hall Name</th>
                                            <th>Capacity</th>
                                            <th>Area (sq ft)</th>
                                            <th>Rate/Guest</th>
                                            <th>Total Bookings</th>
                                            <th>Booking Days</th>
                                            <th>Available Days</th>
                                            <th>Occupancy Rate (%)</th>
                                            <th>Revenue Generated</th>
                                            <th>Avg Booking Value</th>
                                            <th>Performance Rating</th>
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
    
            table = $('#hall_utilization_table').DataTable({
            responsive: true, // Enable responsive feature when small display then + button enable to view all data
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('hallUtilization.hallReportView') }}",
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
                { data: 'hall', name: 'hall', orderable: false, searchable: true },
                { data: 'capacity', name: 'capacity', orderable: true, searchable: true },
                { data: 'area', name: 'area', orderable: false, searchable: true },
                { data: 'rate', name: 'rate', orderable: false, searchable: true },
                { data: 'booking', name: 'booking', orderable: false, searchable: true },
                { data: 'booking_days', name: 'booking_days', orderable: false, searchable: true },
                { data: 'available_days', name: 'available_days', orderable: false, searchable: true },
                { data: 'occupancy_rate', name: 'occupancy_rate', orderable: false, searchable: true },
                { data: 'revenue_generated', name: 'revenue_generated', orderable: false, searchable: true },
                { data: 'avg_booking', name: 'avg_booking', orderable: false, searchable: true },
                { data: 'performance_rate', name: 'performance_rate', orderable: false, searchable: true },
            ],     
        });
    });

    function searchReport() {
        table.ajax.reload();
    }
</script>
@endsection
