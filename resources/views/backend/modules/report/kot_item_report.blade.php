@extends('backend.layouts.main')
@section('main-container')
@section('title')
KOT Item List
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">KOT Item List</h3>
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
                                            <th>Item Name</th>
                                            <th>Category</th>
                                            <th>Quantity</th>
                                            <th>Rate</th>
                                            <th>Amount</th>
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
                    title: 'KOT Item Report'
                },
                {
                    extend: 'csvHtml5',
                    title: 'KOT Item Report'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'KOT Item Report'
                }
            ],
            ajax: {
                url: "{{ route('kotItemReport.kotItemReportView') }}",
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
                { data: 'kot_no', name: 'kot_no', orderable: false, searchable: true },
                { data: 'item_name', name: 'item_name', orderable: true, searchable: true },
                { data: 'category', name: 'category', orderable: false, searchable: true },
                { data: 'quantity', name: 'quantity', orderable: false, searchable: true },
                { data: 'rate', name: 'rate', orderable: false, searchable: true },
                { data: 'amount', name: 'amount', orderable: false, searchable: true },
                { data: 'status', name: 'status', orderable: false, searchable: true },
            ],     
        });
    });
    
    function searchReport(){
        table.ajax.reload();
    }
</script>
@endsection
