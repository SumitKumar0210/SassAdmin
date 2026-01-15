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
                                    <select class="form-control" id="type">
                                        <option value="All">All</option>
                                        <option value="checkin">Checked-in</option>
                                        <option value="checkout">Check-out</option>
                                    </select>
                                </div>
                                <div class="col-5">
                                    <input class="form-control" id="date" type="date" required="" value="{{date('Y-m-d')}}">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-primary" type="button" onclick="searchReport()">Search</button>
                                    <button class="btn btn-warning" type="button" onclick="printReport()">Print</button>
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

    <div class="modal fade" id="reservationUpdateTimeModel" tabindex="-1" role="dialog" aria-labelledby="banquetBookingPaymentModel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title roomCategory_title">Update Timming</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="reservation_update_time_form" class="needs-validation" novalidate>
                        <div class="modal-body">
                            <div class="row">
                                <input type="hidden" class="reservation_room_id" name="reservation_room_id">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="reservation_checkin_date">Checkin Date</label>
                                    <input class="form-control form-control-sm" id="reservation_checkin_date" name="reservation_checkin_date" type="date" placeholder="Enter Amount" style="background-image: none;" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="reservation_checkin_time">Checkin Time</label>
                                    <input class="form-control form-control-sm" id="reservation_checkin_time" name="reservation_checkin_time" type="time" placeholder="Enter Amount" style="background-image: none;" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="reservation_checkout_date">Checkout Date</label>
                                    <input class="form-control form-control-sm" id="reservation_checkout_date" name="reservation_checkout_date" type="date" placeholder="Enter Amount" style="background-image: none;" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label" for="reservation_checkout_time">Checkout Time</label>
                                    <input class="form-control form-control-sm" id="reservation_checkout_time" name="reservation_checkout_time" type="time" placeholder="Enter Amount" style="background-image: none;" required>
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
    const reservationCancel = "{{ route('report.reservationCancelCheckout') }}";
    const reservationUpdateCheckinCheckout = "{{ route('report.reservationUpdateCheckinCheckoutTime') }}";
    const getReservationRoomDetail = "{{ route('report.reservationGetDetail') }}";
</script>
    <script>
        let table;
        
        table = $('#reservation_room_table').DataTable({
            responsive: true, // Enable responsive feature when small display then + button enable to view all data
            processing: false,
            serverSide: true,
            ajax: {
                url: "{{ route('report.reservationReportView') }}",
                data: function(d) {
                    d.type = $('#type').val();
                    d.date = $('#date').val();
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

        function printReport(){
            let type = $('#type').val();
            let date = $('#date').val();
            let url = '../report/reservationReportPrint/type='+type+'&date='+date;
            window.open(url,'_blank');
        }

        function cancelCheckout(id){
             Swal.fire({
                    text: "Are you sure to cancel Checkout?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, Do it!"
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url:reservationCancel,
                            type:"POST",
                            data:{id:id},
                            success:function(response){

                                Swal.fire({
                                    text: "Reservation Checkout Cancel status updated successfully",
                                    icon: "success"
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                },2500);
                            }
                        });

                    }
                });
        }

        function edit_reservation(id, reservationid) {
            let res = 'reservation='+reservationid+'&reservation_room_id='+id;
            let url = '../../reservation/edit-reservation/'+res;
            window.location.href = url;
        }

        function getReservationData(id,reservation_id){
            $('#reservationUpdateTimeModel').modal('show');
            $('.reservation_room_id').val(id);
            
            $.ajax({
                url:getReservationRoomDetail,
                type:"POST",
                data:{id:id},
                success:function(response){
                    // console.log(response);
                    $('#reservation_checkin_date').val(response.checkin_date);
                    $('#reservation_checkin_time').val(response.checkin_time);
                    $('#reservation_checkout_date').val(response.checkout_date);
                    $('#reservation_checkout_time').val(response.checkout_time);
                }
            });
        }

        $('#reservation_update_time_form').on("submit", function(event){
            event.preventDefault();
            let form = document.getElementById("reservation_update_time_form");
            let formData = new FormData(form);
            $.ajax({
                url:reservationUpdateCheckinCheckout,
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
        })
    </script>
@endsection
