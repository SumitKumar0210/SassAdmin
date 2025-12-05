@extends('backend.layouts.main')
@section('main-container')
@section('title')
Outstanding Payments Report
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Outstanding Payments Report</h3>
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
                                <table class="display" id="outstanding_payments_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Client Name</th>
                                            <th>Booking ID</th>
                                            <th>Invoice Number</th>
                                            <th>Invoice Date</th>
                                            <th>Due Date</th>
                                            <th>Original Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Outstanding Amount</th>
                                            <th>Days Overdue</th>
                                            <th>Collection Status</th>
                                            <th>Last Follow-up</th>
                                            <th>Next Follow-up</th>
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

        $(document).ready(function() {
            table = $('#outstanding_payments_table').DataTable({
            responsive: true, // Enable responsive feature when small display then + button enable to view all data
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('outstandingPayments.outstandingPaymentsView') }}",
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
                { data: 'booking_id', name: 'booking_id', orderable: true, searchable: true },
                { data: 'invoice_number', name: 'invoice_number', orderable: false, searchable: true },
                { data: 'invoice_date', name: 'invoice_date', orderable: false, searchable: true },
                { data: 'due_date', name: 'due_date', orderable: false, searchable: true },
                { data: 'original_amount', name: 'original_amount', orderable: false, searchable: true },
                { data: 'paid_amount', name: 'paid_amount', orderable: false, searchable: true },
                { data: 'outstanding_amount', name: 'outstanding_amount', orderable: false, searchable: true },
                { data: 'day_overdue', name: 'day_overdue', orderable: false, searchable: true },
                { data: 'collection', name: 'collection', orderable: false, searchable: true },
                { data: 'last_follow', name: 'last_follow', orderable: false, searchable: true },
                { data: 'next_follow', name: 'next_follow', orderable: false, searchable: true },
                { data: 'action', name: 'action'},
            ],     
        });
    });

    function searchReport(){
        table.ajax.reload();
    }
       
    </script>
@endsection
