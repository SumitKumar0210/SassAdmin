@extends('backend.layouts.main')
@section('title','Nightaudit Guest Folio')
@section('main-container')
 <div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6 p-0">
                    <h3>Guest Folio Review</h3>
                </div>
                <div class="col-12 col-sm-6 p-0 text-end">
                    <button class="btn btn-primary ms-2" type="button" onclick="exportFolioAudit()"><i class="ri-file-excel-line"></i> Export Summary</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="row product-page-main">
                        <div class="col-sm-12">
                            <ul class="nav nav-tabs border-tab nav-primary mb-3" id="top-tab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-controls="top-home" aria-selected="false">All Folio</a>
                                    <div class="material-border"></div>
                                </li>
                                <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="false">Pending Folio</a>
                                    <div class="material-border"></div>
                                </li>
                                <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab" href="#top-contact" role="tab" aria-controls="top-contact" aria-selected="true">No Show</a>
                                    <div class="material-border"></div>
                                </li>
                            </ul>
                            <div class="tab-content" id="top-tabContent">
                                <div class="tab-pane fade active show" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                                    <div class="table-responsive">
                                        <table class="table hover row-border stripe" id="guest_folio_all">
                                            <thead>
                                                <tr>
                                                    <th>Room No.</th>
                                                    <th>Guest Name</th>
                                                    <th>Status</th>
                                                    <th>Paid</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($roomList as $room)
                                                <tr>
                                                    <td>{{$room['room']}}</td>
                                                    <td>{{$room['name']}}</td>
                                                    <td>{{$room['status']}}</td>
                                                    <td>{{$room['balance']}}</td>
                                                    <td> 
                                                        {{-- <a href="#" class="me-2 fs-6 text-primaru"><i class="ri-eye-line"></i></a> --}}
                                                        @if($room['status'] == 'Alloted')
                                                            <a href="javascript:;" class="me-2 fs-6 text-success" onclick="receiveReservationPayment({{$room['balance']}},'{{$room['reservation_id']}}',{{$room['id']}})"><i class="ri-bank-card-line"></i></a>
                                                        @endif
                                                        @if($room['status'] == 'Reserved')
                                                            <a href="javascript:;" class="fs-6 text-danger" onclick="cancelReservationData({{$room['id']}})"><i class="ri-calendar-close-line"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                                    <div class="table-responsive">
                                        <table class="table hover row-border stripe" id="guest_folio_pending">
                                            <thead>
                                                <tr>
                                                    <th>Room No.</th>
                                                    <th>Guest Name</th>
                                                    <th>Status</th>
                                                    <th>Balance</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               @foreach($roomList as $room)
                                                @if($room['status'] == 'Alloted')
                                                    <tr>
                                                        <td>{{$room['room']}}</td>
                                                        <td>{{$room['name']}}</td>
                                                        <td>{{$room['status']}}</td>
                                                        <td>{{$room['balance']}}</td>
                                                        <td> 
                                                            <a href="javascript:;" class="me-2 fs-6 text-success" onclick="receiveReservationPayment({{$room['balance']}},'{{$room['reservation_id']}}',{{$room['id']}})"><i class="ri-bank-card-line"></i></a>
                                                        </td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="top-contact" role="tabpanel" aria-labelledby="contact-top-tab">
                                    <div class="table-responsive">
                                        <table class="table hover row-border stripe table-sm" id="guest_folio_noshow">
                                            <thead>
                                                <tr>
                                                    <th>Room No.</th>
                                                    <th>Guest Name</th>
                                                    <th>Status</th>
                                                    <th>Balance</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($roomList as $room)
                                                    @if($room['status'] == 'Reserved')
                                                        <tr>
                                                            <td>{{$room['room']}}</td>
                                                            <td>{{$room['name']}}</td>
                                                            <td>{{$room['status']}}</td>
                                                            <td>{{$room['balance']}}</td>
                                                            <td> 
                                                                <a href="javascript:;" class="fs-6 text-danger" onclick="cancelReservationData({{$room['id']}})"><i class="ri-calendar-close-line"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <div class="modal fade" id="auditCollectPayment" tabindex="-1" role="dialog" aria-labelledby="auditCollectPayment" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title roomCategory_title">Record Payment </h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="audit_collect_reservation_payment" class="needs-validation" novalidate>
                        <div class="modal-body">
                            <div class="col-md-12 mb-3">
                                <input type="hidden" class="audit_reservation_id">
                                <label class="form-label" for="audit_reservation_paid_amount">Paid Amount</label>
                                <input class="form-control form-control-sm" id="audit_reservation" type="hidden" placeholder="Enter Amount" style="background-image: none;" readonly>
                                <input class="form-control form-control-sm" id="audit_reservation_paid_amount" type="number" placeholder="Enter Amount" style="background-image: none;" readonly>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="audit_reservation_amount">Amount</label>
                                <input class="form-control form-control-sm" id="audit_reservation_amount" type="number" placeholder="Enter Amount" style="background-image: none;" required step="0.01">
                                <div class="invalid-feedback">
                                    Enter Amount
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="audit_reservation_pmode">Payment Mode</label>
                                <select  class="form-control form-control-sm" name="" id="audit_reservation_pmode" style="background-image: none;" required>
                                    <option value="">Select</option>
                                    @foreach($payments as $pay)
                                    <option value="{{$pay['id']}}">{{$pay['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                             <div class="col-md-12 txnVisibility d-none mb-3">
                                <label class="form-label" for="audit_reservation_txn">Transaction Number</label>
                                <input class="form-control form-control-sm" id="audit_reservation_txn" type="text" placeholder="Enter Transaction Number" style="background-image: none;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit">Submit</button>
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
    $('#guest_folio_all').DataTable();
    $('#guest_folio_pending').DataTable();
    $('#guest_folio_noshow').DataTable();

    function exportFolioAudit(){
      window.open('/nightaudit/guest-folio-print');
    }

    const cancelReservation = "{{ route('reservation.cancelReservation') }}";
    const recordReservationPayment = "{{ route('auditReport.recordReservationPayment') }}";
    const getPaymentDetail = "{{ route('reservation.getPaymentDetail') }}";
</script>
<script src="{{asset('backend/assets/js/custom/reservation.js')}}"></script>
@endsection