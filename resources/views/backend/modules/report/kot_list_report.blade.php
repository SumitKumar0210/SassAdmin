@extends('backend.layouts.main')
@section('main-container')
@section('title')
Kot List
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Kot List</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="card height-equal">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-10 col-sm-12">
                                    <form class="row g-3 needs-validation custom-input invoice-setting-form" novalidate="">
                                        <div class="col-5">
                                            <input class="form-control" id="date1" type="date" required="" value="{{date('Y-m-d')}}">
                                        </div>
                                        <div class="col-5">
                                            <input class="form-control" id="date2" type="date" required="" value="{{date('Y-m-d')}}">
                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-primary" type="button" onclick="searchReport()">Submit</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-lg-2 col-sm-12">
                                    <div class="row ">
                                        <div class="col-12">
                                            <h5>Card : ₹ <span class="card_price"> 0.00</span></h5>
                                        </div>
                                        <div class="col-12">
                                            <h5>Cash : ₹ <span class="cash_price"> 0.00</span></h5>
                                        </div>
                                        <div class="col-12">
                                            <h5>Credit : ₹ <span class="credit_price"> 0.00</span></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                <table class="display" id="reservation_room_table123">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>KOT No</th>
                                            <th>Table No</th>
                                            <th>Room No</th>
                                            <th>KOT Type</th>
                                            <th>Guest Name</th>
                                            <th>Assisted By</th>
                                            <th>Created By</th>
                                            <th>Status</th>
                                            <th>Cancelled By</th>
                                            <th>Reason</th>
                                            <th>KOT Value</th>
                                            <th>Date & Time</th>
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
            table = $('#reservation_room_table123').DataTable({
                responsive: true, // Enable responsive feature when small display then + button enable to view all data
                processing: true,
                serverSide: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Kot List Report'
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Kot List Report'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Kot List Report'
                    }
                ],
                ajax: {
                    url: "{{ route('kotListReport.kotListReportView') }}",
                    type: 'GET',
                    data: function(d) {
                        d.date_from = $('#date1').val();
                        d.date_to = $('#date2').val();
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataSrc: function (json) {
                        // json.total_amount comes from ->with()
                        $('.card_price').text(json.total_card ?? 0);
                        $('.cash_price').text(json.total_cash ?? 0);
                        $('.credit_price').text(json.total_amount ?? 0);

                        return json.data; // VERY IMPORTANT
                    },
                    error: function(xhr, error, thrown) {
                        console.error(xhr.responseText); // Use console.error for better error logs
                        alert(`Error: ${thrown}`); // Template literals for readability
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: true },
                    { data: 'kot_no', name: 'kot_no', orderable: true, searchable: true },
                    { data: 'table_no', name: 'table_no', orderable: false, searchable: true },
                    { data: 'room_number', name: 'room_number', orderable: false, searchable: true },
                    { data: 'kot_type', name: 'kot_type', orderable: false, searchable: true },
                    { data: 'guest_name', name: 'guest_name', orderable: false, searchable: true },
                    { data: 'assisted_by', name: 'assisted_by', orderable: false, searchable: true },
                    { data: 'created_by', name: 'created_by', orderable: false, searchable: true },
                    { data: 'status', name: 'status', orderable: false, searchable: true },
                    { data: 'cancelled_by', name: 'cancelled_by', orderable: false, searchable: true },
                    { data: 'reason', name: 'reason', orderable: false, searchable: true },
                    { data: 'kot_value', name: 'kot_value', orderable: false, searchable: true },
                    { data: 'date_time', name: 'date_time', orderable: false, searchable: true },
                ],     
            });
        });
       
        function searchReport(){
            table.ajax.reload();
        }
    </script>
@endsection
