@extends('backend.layouts.main') 
@section('main-container')
@section('title')
Reservation
@endsection
@section('extra-css')
<style>
	.onhover-show-div {
	  top: 35px;
	}
</style>
@endsection
<link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/dynamic-toggle-style.css')}}">
<div class="page-body">
	<div class="container-fluid">
		<div class="page-title">
			<div class="row">
				<div class="col-6 p-0">
					<h3>Reservation <span style="font-size: 13px;"> Today ({{date('d-m-Y')}}) </span></h3> 
				</div>
				
				<div class="col-6 p-0">
					<div class="d-flex justify-content-end align-items-center">
						{{-- <div class="d-flex mx-2">
							<span class=" border rounded full-screen-icon" id="fullscreen"><i class="ri-fullscreen-fill"></i></span>
							<span class=" border rounded full-screen-icon" id="normalscreen"><i class="ri-fullscreen-exit-fill"></i></span>
						</div> --}}
						{{-- -------------view change function working from reservation-row-view.js------------------------- --}}
						<div id="calender-view" class="btn-view border rounded" title="calender"><a href="{{route('reservation.reservation')}}"><i class="fa fa-calendar text-dark"></i></a></div>
						<div id="row-view1" class="btn-view border rounded mx-2 active " title="grid"><a href="{{route('reservation.reservationLayout')}}"><i class="ri-layout-grid-2-fill text-white"></i></a></div>
					
						@if(in_array('Reservation Add', (explode(',',auth()->user()->permission))))
						
							<button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#roomCloser" onClick="clearCloser()"><span class="btn-icon"><i class="ri-indeterminate-circle-line"></i></span> Room Closure</button>
							{{-- <button class="btn btn-primary ms-2" type="button" data-bs-toggle="modal" data-bs-target="#reservation" onclick="clearReservation()"><span class="btn-icon"><i class="icon-plus me-1" style="font-size: 10px;"></i></span> Reservation</button> --}}
							<a class="btn btn-primary ms-2" href="{{route('create-reservation.index')}}"><span class="btn-icon"><i class="icon-plus me-1" style="font-size: 10px;"></i></span> Reservation</a>
						@endif
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 p-0 category-filter-list mt-2"></div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body reservation-list">
						<div class="legend d-none d-sm-flex  mt-1 mb-1 filter-parameter">
							<div class="d-flex align-items-center rooms-status-btn flex-column mx-5" onclick="roomDetailDesign('')">
								<h5>All</h5>
								<div class="all-room w-40  bg-success border-radius-4"></div>
							</div>
						</div>
						<div class="table-responsive signal-table">
							<table class="table">
								<thead>
									<tr>
										<th scope="col" class="text-nowrap">Room Type</th>
										<th scope="col">Rooms </th>
										<th scope="col">Unallocated</th>
									</tr>
								</thead>
								<tbody class="room_detail_views"></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@include('backend.modules.models.addReservationModel')
@include('backend.modules.models.addRoomCloserModel')

@include('backend.modules.models.editReservationModel')
@include('backend.modules.models.earlyCheckinModel')
@include('backend.modules.models.collectPaymentModel')

@endsection
@section('extra-js') 
<script>
	const reservationViewLayout = "{{ route('reservation-layout.reservationViewLayout') }}";
	const getRservationandRoomDetails = "{{ route('reservation.getRservationandRoomDetails') }}";
	const checkinProcess = "{{ route('reservation.roomcheckIn') }}";
    const checkoutProcess = "{{ route('reservation.roomcheckOut') }}";
	const checkoutData = "{{ route('checkout.checkoutReservationPreview',':id')}}";
	const getDetailsWithPhone = "{{route('reservation.getDetailsWithPhone')}}";
	const addDataUsingPhone = "{{route('reservation.addDataUsingPhone')}}";
	const roomClosureData = "{{ route('room.getRoomclosuredata') }}";
    const addRoomClosure = "{{ route('backend.add_roomClosure') }}";
	const manageroomclose = "{{route('room.manageroomclose')}}";
	const reservatiionAdd = "{{ route('reservation.add_reservation') }}";
	const cancelReservation = "{{ route('reservation.cancelReservation') }}";
    const getPaymentDetail = "{{ route('reservation.getPaymentDetail') }}";
	const editReservationUpdate = "{{ route('reservation.editReservationUpdate') }}";
	const roomguestnoteData = "{{ route('reservation.roomguestnoteData') }}";
	const updateroomguestData = "{{ route('reservation.updateroomguestData') }}";
	const submitroomguestData = "{{ route('reservation.submitroomguestData') }}";
	const reservationPaymentSubmit = "{{ route('reservation.reservationPayment') }}";
	const reservatiionEditAdd = "{{ route('reservation.edit_add_reservation') }}";
	const companyVerifyGst = "{{ route('company.verifyGst') }}";
	const recordKotReservationPayment = "{{ route('record-reservation-payment.recordPayment')}}";
</script>
<script>
	$(document).ready(function() {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	});

	
</script>
<script src="{{asset('backend/assets/js/custom/reservation.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/reservation_comman.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/closer_room.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/custom_backend.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/reservation_layout.js')}}"></script>
<script src="{{asset('backend/assets/js/custom/reservation_side_layout.js')}}"></script>
<script src="{{asset('backend/assets/js/dynamic-toggle-script.js')}}"></script>
@endsection