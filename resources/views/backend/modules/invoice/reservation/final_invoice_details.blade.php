@extends('backend.layouts.main')
@section('main-container')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Final Invoice List</h3>
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
                                <table class="display" id="reservation_invoice_final">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Status</th>
                                            <th>Reservation ID</th>
                                            <th>Room Number</th>
                                            <th>Room Type</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Amount</th>
                                            <th>Discount</th>
                                            <th>Paid Amount</th>
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
        let table = $('#reservation_invoice_final').DataTable({
                responsive: true, // Enable responsive feature
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('invoice.getfinalInvoiceData') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    error: function(xhr, error, thrown) {
                        console.error(xhr.responseText); // Use console.error for better error logs
                        alert(`Error: ${thrown}`); // Template literals for readability
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex',orderable:true, searchable:true },
                    { data: 'status',orderable:false, searchable:true },
                    { data: 'reservationid',orderable:false, searchable:true },
                    { data: 'room_num',orderable:false, searchable:true },
                    { data: 'room_type',orderable:false, searchable:true },
                    { data: 'checkin',orderable:false, searchable:true },
                    { data: 'checkout', orderable: false, searchable: true },
                    { data: 'name', orderable: false, searchable: true },
                    { data: 'mobile', orderable: false, searchable: true },
                    { data: 'email', orderable: false, searchable: true },
                    { data: 'address', orderable: false, searchable: true },
                    { data: 'amount', orderable: false, searchable: true },
                    { data: 'discount', orderable: false, searchable: true },
                    { data: 'paid_amount', orderable: false, searchable: true },
                    { data: 'action', orderable: false, searchable: true },
                ],
        });
        //for route path of cancel_final_invoice() in custome_backend.js
        const cancelFinalInvoice = "{{route('invoice.cancelFinalInvoice')}}"; 
       </script>
@endsection
