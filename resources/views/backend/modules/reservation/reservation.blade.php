@extends('backend.layouts.main')
@section('main-container')
@section('title')
Reservation
@endsection
<link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/dynamic-toggle-style.css')}}">
    <div class="page-body pb-1">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-sm-6 p-0">
                        <h3>Reservation</h3>
                    </div>
                    <div class="col-12 col-sm-6 p-0">
                        <div class="d-flex justify-content-end align-items-center">
                            <div class="d-flex mx-2">
                                <span class=" border rounded full-screen-icon" id="fullscreen"><i class="ri-fullscreen-fill"></i></span>
                                <span class=" border rounded full-screen-icon" id="normalscreen"><i class="ri-fullscreen-exit-fill"></i></span>
                            </div>
                            {{-- -------------view change function working from reservation-row-view.js------------------------- --}}
                            <div id="calender-view" class="btn-view border rounded active"><a href="{{route('reservation.reservation')}}"><i class="fa fa-calendar text-white"></i></a></div>
                            <div id="row-view" class="btn-view border rounded mx-2"><a href="{{route('reservation.reservationLayout')}}"><i class="ri-layout-grid-2-fill text-dark"></i></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            {{--------------------------------date calender-------------------------------------}}
            <div class="col-sm-12">
                <div class="reservation-head mb-2">
                    <div class="d-flex align-items-center">
                        <div>
                            <select class="form-select" aria-label=".form-select-sm example" id="selectDays"
                                onchange="reservationViewCount(this.value)">
                                <option value="7" {{ $getResViewCount == 7 ? 'selected' : '' }}>7 days</option>
                                <option value="14" {{ $getResViewCount == 14 ? 'selected' : '' }}>14 days</option>
                                <option value="28" {{ $getResViewCount == 28 ? 'selected' : '' }}>28 days</option>
                            </select>
                        </div>
                        <div class="ms-2">
                            {{-- <input class="form-control" id="search" type="text" placeholder="search ..."> --}}
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-light" type="button" onclick="loadreservationdata(0,2,this)">View Today</button>
                        <div class="ms-2">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button class="btn btn-light" type="button" onclick="loadreservationdata(14,1,this)" data-toggle="tooltip" data-placement="top" title="Shift Previous 14 Days"><span>&#8920;</span></button>
                                <button class="btn btn-light" type="button" onclick="loadreservationdata(7,1,this)" data-toggle="tooltip" data-placement="top" title="Shift Previous 7 Days"><span>&#8810;</span></button>
                                <button class="btn btn-light" type="button" onclick="loadreservationdata(1,1,this)" data-toggle="tooltip" data-placement="top" title="Shift Previous 1 Day"><span>&#60;</span></button>
                                <button class="btn btn-light" type="button">
                                    <div class="input-group date_change_class flatpicker-calender" style="width:120px;">
                                        <span class="me-2"><i class="icofont icofont-ui-calendar"></i></span>
                                        <input class="form-control p-0 border-0" id="datetime-local" type="date" value="2023-05-03" onchange="dateChange()">
                                    </div>
                                </button>
                                <button class="btn btn-light" type="button" onclick="loadreservationdata(1,'',this)" data-toggle="tooltip" data-placement="top" title="Shift Next 1 Day"><span>&#62;</span></button>
                                <button class="btn btn-light" type="button" onclick="loadreservationdata(7,'',this)" data-toggle="tooltip" data-placement="top" title="Shift Next 7 Days"><span>&#8811;</span></button>
                                <button class="btn btn-light" type="button" onclick="loadreservationdata(14,'',this)" data-toggle="tooltip" data-placement="top" title="Shift Next 14 Days"><span>&#8921;</span></button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#roomCloser" onClick="clearCloser()"><span class="btn-icon"><i class="ri-indeterminate-circle-line"></i></span> Room Closure</button>
                        <button class="btn btn-primary ms-2" type="button" data-bs-toggle="modal" data-bs-target="#reservation" onclick="clearReservation()"><span class="btn-icon"><i class="icon-plus me-1" style="font-size: 10px;"></i></span> Reservation</button>
                    </div>
                </div>
            </div>
            <div id="calendar-div" class="row content mb-5" style="display:block;">    
                <div class="append_reservation_data"></div> <!------------Reservation Data Calander View Appended Here Using Ajax-------------------->
            </div>
            {{----------------------------- row view start ------------------------------------------}}
            
        </div>
        {{---------------------------------------------- row view end ---------------------------------------------------}}
    </div>
        <!-- Container-fluid Ends-->
        {{-- ----------------extra div for data append and use somewhere in code--------------- --}}
        <div class="reload_reservation_duration" style="display:none;"></div>
        <div class="extra_data" style="display:none;"></div>
        <div class="get_reservationid" style="display:none;"></div>
        <div class="currdates_data" style="display:none;"></div>
        <div class="currDisplay_data" style="display:none;"></div>
        <div class="guest_room_id" style="display:none;"></div>
        <div class="guest_length_data" style="display:none;"></div>
        <div class="amount_during_checkout" style="display:none;"></div>
        <div class="checkin_dt" style="display:none;"></div>
        <div class="checkout_dt" style="display:none;"></div>
        <div class="outstanding_amount" style="display:none;"></div>
        <!-- Room closure modal start -->
        @include('backend.modules.models.addReservationModel')
        {{-- @include('backend.modules.models.addRoomCloserModel') --}}

        </div>
        @include('backend.modules.models.addCustomerStatusModel')
        @include('backend.modules.models.editReservationModel')
        @include('backend.modules.models.addChangeReservationModel')
        {{-- @include('backend.modules.models.reservationSummary') --}}
    @endsection
    @section('extra-js')
    {{-- <script src="{{asset('backend/assets/js/custom/reservation-row-view.js')}}"></script> --}}
    <script>
        //used for route url in ajax call on custom.js page
        const getRservationandRoomDetails = "{{ route('reservation.getRservationandRoomDetails') }}";
        const getResDetails = "{{ route('backend.getReservation_Details') }}";
        const getResDetails2 = "{{ route('backend.getReservationDetails') }}";
        const reservationRoomDetailData = "{{ route('reservation.getRservationRoomDatas') }}";
        const reservationDetailData = "{{ route('reservation.getRservationDatas') }}";
        const reservationRoomDetailsUrl = "{{ route('backend.getRservationRoomDetails') }}";
        const reservatiionRommNumberUpdate = "{{ route('reservation.reservationRoomNumUpdate') }}";
        const reservatiionAdd = "{{ route('reservation.add_reservation') }}";
        const reservationCountView = "{{ route('reservation.reservationCountView') }}";
        const reservationPaymentSubmit = "{{ route('reservation.reservationPayment') }}";
        const submitroomguestData = "{{ route('reservation.submitroomguestData') }}";
        const roomguestnoteData = "{{ route('reservation.roomguestnoteData') }}";
        const getActivityLogData = "{{ route('reservation.getActivityLogDetails') }}";
        const checkinProcess = "{{ route('reservation.roomcheckIn') }}";
        const checkoutProcess = "{{ route('reservation.roomcheckOut') }}";
        const getRoomTypeDataUrl = "{{ route('room.getRoomTypeData') }}";
        const getOccupancyUrl = "{{ route('room.getOccupancyData') }}";
        const reservatiionEditAdd = "{{ route('reservation.edit_add_reservation') }}";
        const getRoomTypeDataEditUrl = "{{ route('room.getRoomTypeEditData') }}";
        const getOccupancyEditUrl = "{{ route('room.getOccupancyEditData') }}";
        const editReservationUpdate = "{{ route('reservation.editReservationUpdate') }}";
        const getRoomcategory = "{{ route('room.getRoomCategory') }}";
        const updateroomguestData = "{{ route('reservation.updateroomguestData') }}";
        const res_confirm_status = "{{ route('reservation.res_confirm_status') }}";
        const roomBalanceFetch = "{{ route('room.roomBalanceFetch') }}";
        const roomTypeDetails = "{{ route('roomtype.checkRoomType') }}";
        const guestCheckout = "{{route('reservation.guestCheckout')}}";
        const roomstatusupdate = "{{route('room.roomstatusupdate')}}";
        const manageroomclose = "{{route('room.manageroomclose')}}";
        const getDetailsWithPhone = "{{route('reservation.getDetailsWithPhone')}}";
        const addDataUsingPhone = "{{route('reservation.addDataUsingPhone')}}";
        const updateDiscountEdit = "{{route('reservation.updateDiscountEdit')}}";
        const paymentInvoiceStatus = "{{route('invoice.invoice_status')}}";
        const reservationData = "{{ route('backend.reservationdata') }}";
        const roomClosureData = "{{ route('room.getRoomclosuredata') }}";
        const addRoomClosure = "{{ route('backend.add_roomClosure') }}";
        const cancelReservation = "{{ route('reservation.cancelReservation') }}";
        const getPaymentDetail = "{{ route('reservation.getPaymentDetail') }}";
        const checkoutData = "{{ route('checkout.checkoutReservationPreview',':id')}}";
        const recordKotReservationPayment = "{{ route('record-reservation-payment.recordPayment')}}";
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            loadreservationdata();
        });
    </script>
    <script src="{{asset('backend/assets/js/custom/custom_backend.js')}}"></script>
    <script src="{{asset('backend/assets/js/custom/closer_room.js')}}"></script>
    <script src="{{asset('backend/assets/js/custom/reservation.js')}}"></script>
    <script src="{{asset('backend/assets/js/custom/reservation_comman.js')}}"></script>
    <script src="{{asset('backend/assets/js/custom/reservation_layout.js')}}"></script>
    <script src="{{asset('backend/assets/js/dynamic-toggle-script.js')}}"></script>
    <script>
      document.querySelectorAll('.customer-details.onhover-show-div').forEach(div => {
        const parent = div.parentElement;

        parent.addEventListener('mouseenter', () => {
          // reset
          div.style.left = '0';
          div.style.right = 'auto';

          const rect = div.getBoundingClientRect();

          // if overflow on the right -> align right
          if (rect.right > window.innerWidth) {
            div.style.left = 'auto';
            div.style.right = '-180px';
          }

          // if overflow on the left -> align left
          if (rect.left < 0) {
            div.style.left = '0';
            div.style.right = 'auto';
          }
        });
      });
      
    </script>
@endsection

