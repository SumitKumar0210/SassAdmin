@extends('backend.layouts.main')
@section('main-container')
@section('title')
Event Type Analysis
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Event Type Analysis</h3>
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
                                <table class="display" id="event_type_analysis_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Event Type</th>
                                            <th>Total Bookings</th>
                                            <th>Percentage Share</th>
                                            <th>Total Revenue</th>
                                            <th>Avg Guest Count</th>
                                            <th>Avg Duration</th>
                                            <th>Avg Revenue/Booking</th>
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
        table = $('#event_type_analysis_table').DataTable({
            responsive: true, // Enable responsive feature when small display then + button enable to view all data
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('eventType.eventTypeView') }}",
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
                { data: 'event_type', name: 'event_type', orderable: false, searchable: true },
                { data: 'total_booking', name: 'total_booking', orderable: true, searchable: true },
                { data: 'percentage_share', name: 'percentage_share', orderable: false, searchable: true },
                { data: 'total_revenue', name: 'total_revenue', orderable: false, searchable: true },
                { data: 'avg_guest', name: 'avg_guest', orderable: false, searchable: true },
                { data: 'avg_duration', name: 'avg_duration', orderable: false, searchable: true },
                { data: 'avg_booking', name: 'avg_booking', orderable: false, searchable: true },
            ],     
        });
    });

    function searchReport(){
        table.ajax.reload();
    }
</script>
@endsection
