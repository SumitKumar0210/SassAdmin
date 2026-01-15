@extends('backend.layouts.main')
@section('main-container')
@section('title')
Stay Report
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Stay Report</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row d-none">
                <div class="col-lg-10 col-sm-10">
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
                <!-- Zero Configuration Starts-->
                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display" id="reservation_room_table123">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Guest Name</th>
                                            <th>Room No</th>
                                            <th>Room Type</th>
                                            <th>Check-in Date</th>
                                            <th>Check-out Date</th>
                                            <th>Status</th>
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
        $(function () {
            let table = $('#reservation_room_table123').DataTable({
                responsive: true, // Enable responsive feature when small display then + button enable to view all data
                processing: true,
                serverSide: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Stay Report'
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Stay Report'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Stay Report'
                    }
                ],
                ajax: {
                    url: "{{ route('stayReport.stayReportView') }}",
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
                    { data: 'guest_name', name: 'guest_name', orderable: false, searchable: true },
                    { data: 'room_no', name: 'room_no', orderable: true, searchable: true },
                    { data: 'room_type', name: 'room_type', orderable: false, searchable: true },
                    { data: 'checkin_date', name: 'checkin_date', orderable: false, searchable: true },
                    { data: 'checkout_date', name: 'checkout_date', orderable: false, searchable: true },
                    { data: 'status', name: 'status', orderable: false, searchable: true },
                ],     
            });

        });
       
    </script>
@endsection
