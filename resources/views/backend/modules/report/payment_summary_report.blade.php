@extends('backend.layouts.main')
@section('main-container')
@section('title')
Payment Summary
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Payment Summary</h3>
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
                                            <th>Date</th>
                                            <th>Payment Mode</th>
                                            <th>Bill Count</th>
                                            <th>Total Amount</th>
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
                    title: 'Payment Summary Report'
                },
                {
                    extend: 'csvHtml5',
                    title: 'Payment Summary Report'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Payment Summary Report'
                }
            ],
            ajax: {
                url: "{{ route('paymentSummary.paymentSummaryView') }}",
                type: 'GET',
                data: function(d) {
                    d.date_from = $('#date1').val();
                    d.date_to = $('#date2').val();
                },
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
                { data: 'date', name: 'date', orderable: false, searchable: true },
                { data: 'payment_mode', name: 'payment_mode', orderable: true, searchable: true },
                { data: 'bill_count', name: 'bill_count', orderable: false, searchable: true },
                { data: 'total_amount', name: 'total_amount', orderable: false, searchable: true },
            ],     
        });
    });
    
    function searchReport(){
        table.ajax.reload();
    }
</script>
@endsection
