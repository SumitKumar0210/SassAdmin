@extends('backend.layouts.main')
@section('main-container')
@section('title')
Reservation Details
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Reservation History</h3>
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
                                <table class="display" id="reservation_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Reservation ID</th>
                                            <th>Booked On</th>
                                            <th>Name</th>
                                            <th>Mobile</th>
                                            <th>Email ID</th>
                                            <th>Address</th>
                                            <th>Arrival Time</th>
                                            <th>City</th>
                                            <th>State</th>
                                            <th>Pin</th>
                                            <th>Document Type</th>
                                            <th>ID Number</th>
                                            <th>Company Name</th>
                                            <th>Company GST</th>
                                            <th>Company Add.</th>
                                            <th>Comments</th>
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

    <!-- Bed Type modal start -->
    <div class="modal fade" id="bedTypeModel" tabindex="-1" role="dialog" aria-labelledby="bedTypeModel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title bedTypeTitle">Add Room View</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="bedType_form" class="g-3 needs-validation" novalidate="">
                        <div class="modal-body">
                            <div class="col-md-12">
                                <input type="hidden" id="bed_type_id">
                                <label class="form-label" for="bed_type">Bed Type Name</label>
                                <input class="form-control" id="bed_type" type="text" placeholder="Enter Bed Type Name"
                                    required>
                                <div class="invalid-feedback">
                                    Enter Bed Type Name
                                </div>
                            </div>
                        </div>
                            <div class="modal-footer">
                                <button class="btn btn-outline-secondary" type="button"
                                    data-bs-dismiss="modal" onclick="resetmodel()">Cancel</button>
                                <button class="btn btn-primary bedType_submit" type="submit">Submit</button>
                                <button class="btn btn-warning bedType_update d-none" type="button"
                                    onclick="bedType_update(document.getElementById('bed_type_id').value)">Update</button>
                            </div>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bed Type modal end-->
@endsection
@section('extra-js')
    <script>
        let table = $('#reservation_table').DataTable({
                responsive: true, // Enable responsive feature when small display then + button enable to view all data
                processing: false,
                serverSide: true,
                ajax: {
                    url: "{{ route('reservation.getAllData') }}",
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
                    { data: 'reservationid', name: 'reservationid',orderable:false, searchable:true },
                    { data: 'created_at', name: 'created_at',orderable:false, searchable:true },
                    { data: 'name', name: 'name',orderable:true, searchable:true },
                    { data: 'mobile', name: 'mobile', orderable: false, searchable: true },
                    { data: 'email', name: 'email', orderable: false, searchable: true },
                    { data: 'address', name: 'address', orderable: false, searchable: true },
                    { data: 'arrival_time', name: 'arrival_time', orderable: false, searchable: true },
                    { data: 'city', name: 'city', orderable: false, searchable: true },
                    { data: 'state', name: 'state', orderable: false, searchable: true },
                    { data: 'pin', name: 'pin', orderable: false, searchable: true },
                    { data: 'document_type', name: 'document_type', orderable: false, searchable: true },
                    { data: 'id_number', name: 'id_number', orderable: false, searchable: true },
                    { data: 'company_name', name: 'company_name', orderable: false, searchable: true },
                    { data: 'company_gst', name: 'company_gst', orderable: false, searchable: true },
                    { data: 'company_address', name: 'company_address', orderable: false, searchable: true },
                    { data: 'comments', name: 'comments', orderable: false, searchable: false },
                ],
        });
    </script>
@endsection
