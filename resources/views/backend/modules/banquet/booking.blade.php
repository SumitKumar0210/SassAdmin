@extends('backend.layouts.main')
@section('title','Banquet Booking')
@section('main-container')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6 p-0">
                    <h3>Booking</h3>
                </div>
                @if(in_array('Banquet Booking Add', (explode(',',auth()->user()->permission))))
                <div class="col-12 col-sm-6 p-0 text-end">
                     <a href="{{route('create-booking.newBooking')}}" class="btn btn-primary btn-sm"><i class="ri-add-line"></i> Create New </a>
                </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="hover row-border stripe" id="booking_table">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Client Name</th> 
                                        <th>Phone No.</th>
                                        <th>Hall Name</th>
                                        <th>Event Type</th>
                                        <th>Event Date & Time</th>
                                        <th>End Time</th>
                                        <th>Guests</th>
                                        <th>Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Due Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
    <div class="modal fade" id="banquetBookingPaymentModel" tabindex="-1" role="dialog" aria-labelledby="banquetBookingPaymentModel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title roomCategory_title">Add Payment Record</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="banquet_booking_payment_form" class="needs-validation" novalidate>
                        <div class="modal-body">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="banquet_booking_amount1">Paid Amount</label>
                                <input class="form-control form-control-sm" id="banquet_paid_booking_amount" type="text" placeholder="Enter Amount" style="background-image: none;" readonly>
                            </div>
                            <div class="col-md-12 mb-3">
                                <input type="hidden" class="banquet_booking_id">
                                <label class="form-label" for="banquet_booking_amount">Amount</label>
                                <input class="form-control form-control-sm" id="banquet_booking_amount" type="number" placeholder="Enter Amount" style="background-image: none;" required step="0.01">
                                <div class="invalid-feedback">
                                    Enter Amount
                                </div>
                                <input class="form-control form-control-sm" id="banquet_booking_amount_limit" type="hidden" placeholder="Enter Amount" style="background-image: none;" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="banquet_booking_pmode">Payment Mode</label>
                                <select  class="form-control form-control-sm" name="" id="banquet_booking_pmode" style="background-image: none;" required>
                                    <option value="">Select</option>
                                    @foreach($payments as $pay)
                                    <option value="{{$pay['id']}}">{{$pay['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="col-md-12 txnVisibility d-none mb-3">
                                <label class="form-label" for="banquet_booking_txn">Transaction Number</label>
                                <input class="form-control form-control-sm" id="banquet_booking_txn" type="text" placeholder="Enter Transaction Number" style="background-image: none;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary roomcat_submit" type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="banquetBookingDraftModel" tabindex="-1" role="dialog" aria-labelledby="banquetBookingDraftModel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title roomCategory_title">Convert To Booking</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="banquet_booking_convert_form" class="needs-validation" novalidate>
                        <div class="modal-body">
                            <div class="col-md-12 mb-3">
                                <input type="hidden" class="banquet_booking_id">
                                <label class="form-label" for="document_upload">Signed Documnent</label>
                                <input class="form-control form-control-sm" id="document_upload" type="file" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                                <div class="invalid-feedback">
                                    Enter Amount
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit">Convert</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('extra-js') 
<script>
  const viewBooking = "{{ route('booking.view') }}";
  const cancelBanquetBooking = "{{ route('booking.cancel') }}";
  const addBooingPayment = "{{ route('booking.addPayment') }}";
  const convertDraftBooking = "{{ route('booking.draftToBooking') }}";
</script>
<script src="{{asset('backend/assets/js/custom/banquet/booking_view.js')}}"></script>
@endsection
