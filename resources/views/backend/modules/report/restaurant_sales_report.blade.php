@extends('backend.layouts.main')
@section('main-container')
@section('title')
Restaurant Sales Report
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Restaurant Sales Report</h3>
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
                                            <th>Guest Name</th>
                                            <th>Room No</th>
                                            <th>Table No</th>
                                            <th>Bill No</th>
                                            <th>Discount (%)</th>
                                            <th>CGST (%)</th>
                                            <th>SGST (%)</th>
                                            <th>Round Off</th>
                                            <th>Paid Amount</th>
                                            <th>Company Name</th>
                                            <th>GST Number</th>
                                            <th>Bill Date</th>
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
                        title: 'Restaurant Sales Report'
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Restaurant Sales Report'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Restaurant Sales Report'
                    }
                ],
                ajax: {
                    url: "{{ route('restaurantSaleReport.restaurantSaleReportView') }}",
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
                    { data: 'guest_name', name: 'guest_name', orderable: true, searchable: true },
                    { data: 'room_number', name: 'room_number', orderable: false, searchable: true },
                    { data: 'table_no', name: 'table_no', orderable: false, searchable: true },
                    { data: 'bill_no', name: 'bill_no', orderable: false, searchable: true },
                    { data: 'discount', name: 'discount', orderable: false, searchable: true },
                    { data: 'cgst', name: 'cgst', orderable: false, searchable: true },
                    { data: 'sgst', name: 'sgst', orderable: false, searchable: true },
                    { data: 'roundoff', name: 'roundoff', orderable: false, searchable: true },
                    { data: 'paid_amount', name: 'paid_amount', orderable: false, searchable: true },
                    { data: 'company', name: 'company', orderable: false, searchable: true },
                    { data: 'gst_number', name: 'gst_number', orderable: false, searchable: true },
                    { data: 'bill_date', name: 'bill_date', orderable: false, searchable: true },
                ],     
            });
        });

        function searchReport(){
            table.ajax.reload();
        }
       
    </script>
@endsection
