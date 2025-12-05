@extends('backend.layouts.main')
@section('main-container')
@section('title')
KOT Report
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">KOT Reports</h3>
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
                                <table class="display" id="reservation_room_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>KOT Number</th>
                                            <th>Order Date</th>
                                            <th>Order Time</th>
                                            <th>Order Type</th>
                                            <th>Order Source</th>
                                            <th>Table Number</th>
                                            <th>Room Number</th>
                                            <th>Server ID</th>
                                            <th>Guest Name</th>
                                            <th>Guest Contact</th>
                                            <th>Special Instructions</th>
                                            <th>Total Item</th>
                                            <th>Total Item Cost</th>
                                            <th>Subtotal</th>
                                            <th>Tax Amount</th>
                                            <th>Service Charge</th>
                                            <th>Discount Applied</th>
                                            <th>Total Amount</th>
                                            <th>Payment Method</th>
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
        @include('backend.modules.models.KotConvertModal')
        @include('backend.modules.models.KotCancelModel')
    </div>
@endsection
@section('extra-js')
    <script>
        const kotGetRoomDetail = "{{ route('available-room-kot.getRoomDetail') }}";
        const kotTableRoom = "{{ route('convert-room-detail.convertTableRoom') }}";
        const kotCollectPayment = "{{ route('collect-payment-kot.collectPayment') }}";
        let table;
        $(document).ready(function() {  
        
                table = $('#reservation_room_table').DataTable({
                responsive: true, // Enable responsive feature when small display then + button enable to view all data
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('report.kotReportView') }}",
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
                    { data: 'kot_id', name: 'kot_id', orderable: false, searchable: true },
                    { data: 'order_date', name: 'order_date', orderable: true, searchable: true },
                    { data: 'order_time', name: 'order_time', orderable: false, searchable: true },
                    { data: 'order_type', name: 'order_type', orderable: false, searchable: true },
                    { data: 'order_source', name: 'order_source', orderable: false, searchable: true },
                    { data: 'table_number', name: 'table_number', orderable: false, searchable: true },
                    { data: 'room_number', name: 'room_number', orderable: false, searchable: true },
                    { data: 'server_id', name: 'server_id', orderable: false, searchable: true },
                    { data: 'guest_name', name: 'guest_name', orderable: false, searchable: true },
                    { data: 'guest_contact', name: 'guest_contact', orderable: false, searchable: true },
                    { data: 'special', name: 'special', orderable: false, searchable: true },
                    { data: 'total_item', name: 'total_item', orderable: false, searchable: true },
                    { data: 'total_item_cost', name: 'total_item_cost', orderable: false, searchable: true },
                    { data: 'subtotal', name: 'subtotal', orderable: false, searchable: true },
                    { data: 'tax_amount', name: 'tax_amount', orderable: false, searchable: true },
                    { data: 'service_charge', name: 'service_charge', orderable: false, searchable: true },
                    { data: 'discount_applied', name: 'discount_applied', orderable: false, searchable: true },
                    { data: 'total_amount', name: 'total_amount', orderable: false, searchable: true },
                    { data: 'payment_method', name: 'payment_method', orderable: false, searchable: true },
                    { data: 'action', name: 'action'}
                ],         
            });
        });


        function searchReport() {
            table.ajax.reload();
        }
    </script>
    <script src="{{asset('backend/assets/js/custom/kot/kot.js')}}"></script>
@endsection
