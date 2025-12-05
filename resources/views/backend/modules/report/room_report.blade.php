@extends('backend.layouts.main')
@section('main-container')
@section('title')
Room Details
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Room Details</h3>
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
                                            <th>SL No.</th>
                                            <th>Room Number</th>
                                            <th>Room Category</th>
                                            <th>Room Status</th>
                                            <th>Occupancy Status</th>
                                            <th>Bed Configuration</th>
                                            <th>Room Capacity</th>
                                            <th>Smoking Status</th>
                                            <th>Room Size (sq ft)</th>
                                            <th>Balcony/View</th>
                                            <th>Special Amenities</th>
                                            <th>Last Maintenance Date</th>
                                            <th>Maintenance Type</th>
                                            <th>Revenue Generated (Daily)</th>
                                            <th>Revenue Generated (Monthly)</th>
                                            <th>Average Daily Rate (ADR)</th>
                                            <th>Occupancy Rate</th>
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
            ajax: {
                url: "{{ route('report.roomReportView') }}",
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
                { data: 'occupancy_status', name: 'occupancy_status', orderable: false, searchable: true },
                { data: 'bed_configuration', name: 'bed_configuration', orderable: false, searchable: true },
                { data: 'room_capacity', name: 'room_capacity', orderable: false, searchable: true },
                { data: 'smoking_status', name: 'smoking_status', orderable: false, searchable: true },
                { data: 'room_size', name: 'room_size', orderable: false, searchable: true },
                { data: 'view', name: 'view', orderable: false, searchable: true },
                { data: 'amenities', name: 'amenities', orderable: false, searchable: true },
                { data: 'last_maintenance', name: 'last_maintenance', orderable: false, searchable: true },
                { data: 'maintenance_type', name: 'maintenance_type', orderable: false, searchable: true },
                { data: 'revenue_generated', name: 'revenue_generated', orderable: false, searchable: true },
                { data: 'revenue_generate_monthly', name: 'revenue_generate_monthly', orderable: false, searchable: true },
                { data: 'avg_daily_rate', name: 'avg_daily_rate', orderable: false, searchable: true },
                { data: 'occupancy_rate', name: 'occupancy_rate', orderable: false, searchable: true },
            ],     
        });
       
    </script>
@endsection
