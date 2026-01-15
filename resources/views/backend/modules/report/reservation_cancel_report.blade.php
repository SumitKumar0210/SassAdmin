@extends('backend.layouts.main')
@section('main-container')
@section('title')
Reservation Room Details
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Reservation Rooms</h3>
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
                                    <button class="btn btn-primary" type="button" onclick="searchReport()">Search</button>
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
                                            <th>Reservation Number</th>
                                            <th>Booking Date</th>
                                            <th>Primary Guest Name</th>
                                            <th>Contact Number</th>
                                            <th>Check-in Date</th>
                                            <th>Check-out Date</th>
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

    <div class="modal fade" id="reservationUpdateCheckinModel" tabindex="-1" role="dialog" aria-labelledby="banquetBookingPaymentModel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title roomCategory_title">Update Reservation</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="reservation_update_checkin_form" class="needs-validation" novalidate>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" class="reservation_room_id" name="reservation_room_id" required>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="reservation_checkin_date">Checkin Date</label>
                                    <input class="form-control form-control-sm" id="reservation_checkin_date" name="reservation_checkin_date" type="date" placeholder="Enter Amount" style="background-image: none;" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="reservation_checkout_date">Checkout Date</label>
                                    <input class="form-control form-control-sm" id="reservation_checkout_date" name="reservation_checkout_date" type="date" placeholder="Enter Amount" style="background-image: none;" required>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary " type="submit">Submit</button>
                            <button class="btn btn-primary payment_processing d-none" type="button">Please Wait..</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-js')
<script>
    const reservationUpdateTimeCheckin = "{{ route('report.reservationUpdateTime') }}";
</script>
    <script>
        let table;
        
        table = $('#reservation_room_table').DataTable({
            responsive: true, // Enable responsive feature when small display then + button enable to view all data
            processing: false,
            serverSide: true,
            ajax: {
                url: "{{ route('report.reservationCancelReportView') }}",
                data: function(d) {
                    d.dateFrom = $('#date1').val();
                    d.dateTo = $('#date2').val();
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
                { data: 'reservation', name: 'reservation', orderable: false, searchable: true },
                { data: 'booking_date', name: 'booking_date', orderable: false, searchable: true },
                { data: 'primary_guest', name: 'primary_guest', orderable: false, searchable: true },
                { data: 'contact_number', name: 'contact_number', orderable: false, searchable: true },
                { data: 'check_in_date', name: 'check_in_date', orderable: false, searchable: true },
                { data: 'check_out_date', name: 'check_out_date', orderable: false, searchable: true },
                { data: 'action', name: 'action'},
            ],     
        });
       
        function searchReport() {
            table.ajax.reload();
        }

        function updateReservationStatus(id,res){
            $('.reservation_room_id').val(id);
            $('#reservationUpdateCheckinModel').modal('show');
        }

        $('#reservation_update_checkin_form').on("submit", function(event){
            event.preventDefault();
            
            let form = document.getElementById("reservation_update_checkin_form");
            let formData = new FormData(form);
            
            $.ajax({
                url:reservationUpdateTimeCheckin,
                type:"POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if(response.success){
                        toastSuccessAlert(response.success);
                        setTimeout(function() {
                            window.location.reload();
                        }, 2500);
                    }
                }
            });

        });
    </script>
@endsection
