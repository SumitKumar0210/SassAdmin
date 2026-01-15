@extends('backend.layouts.main')
@section('main-container')
@section('title')
Item wise sale
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Item wise sale</h3>
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
                                            <th>Item Name</th>
                                            <th>Category</th>
                                            <th>Quantity Sold</th>
                                            <th>Gross Amount</th>
                                            <th>Discount</th>
                                            <th>GST Amount</th>
                                            <th>Net Amount</th>
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
                        title: 'Item wise sale Report'
                    },
                    {
                        extend: 'csvHtml5',
                        title: 'Item wise sale Report'
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Item wise sale Report'
                    }
                ],
                ajax: {
                    url: "{{ route('itemWiseSale.itemWiseSaleView') }}",
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
                    { data: 'item_name', name: 'item_name', orderable: false, searchable: true },
                    { data: 'category', name: 'category', orderable: true, searchable: true },
                    { data: 'qty_sold', name: 'qty_sold', orderable: false, searchable: true },
                    { data: 'gross_amount', name: 'gross_amount', orderable: false, searchable: true },
                    { data: 'discount', name: 'discount', orderable: false, searchable: true },
                    { data: 'gst_amount', name: 'gst_amount', orderable: false, searchable: true },
                    { data: 'net_amount', name: 'net_amount', orderable: false, searchable: true },
                ],     
            });
        });

        function searchReport(){
            table.ajax.reload();
        }
       
    </script>
@endsection
