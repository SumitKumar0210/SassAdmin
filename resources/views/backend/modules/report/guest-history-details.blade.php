@extends('backend.layouts.main')
@section('main-container')
@section('title')
Guest History
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Guest History</h3>
                    </div>
                </div>
            </div>
        </div>
        @php
            // dd($customers);
        @endphp
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="row product-page-main">
                            <div class="col-sm-12">
                                <ul class="nav nav-tabs border-tab nav-primary mb-3" id="top-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-controls="top-home" aria-selected="true">Guest Details</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="history-tab" data-bs-toggle="tab" href="#guest-history" role="tab" aria-controls="guest-history" aria-selected="false">Guest History</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="restaurant-tab" data-bs-toggle="tab" href="#guest-restaurant" role="tab" aria-controls="guest-restaurant" aria-selected="false">Guest Restaurant</a>
                                        <div class="material-border"></div>
                                    </li>
                                </ul>
                                
                                <div class="tab-content" id="top-tabContent">
                                    <!-- Guest Details Tab -->
                                    <div class="tab-pane fade active show" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                                        <div class="row">
                                            <!-- Full width card -->
                                            <div class="col-12">
                                                <input type="hidden" id="customerId" value="{{ $customers[0]->id ?? '' }}">
                                                <div class="row">
                                                    <div class="col-12"><h4>Guest Details </h4></div>
                                                
                                                    <div class="col-6 mb-2 mt-2">
                                                        <label class="detail-label">Guest Id:</label><span class="detail-value" id="g_guest_id">--</span>
                                                    </div>
                                                    <div class="col-6 mb-2 mt-2">
                                                        <label class="detail-label">Guest Name:</label><span class="detail-value" id="g_guest_name">--</span>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-12"><h4>Contact Information</h4></div>
                                                
                                                    <div class="col-6 mb-2 mt-2">
                                                        <label class="detail-label">Mobile:</label><span class="detail-value" id="g_mobile">--</span>
                                                    </div>
                                                    <div class="col-6 mb-2 mt-2">
                                                        <label class="detail-label">E-mail :</label><span class="detail-value" id="g_email">--</span>
                                                    </div>
                                                    <div class="col-6 mb-2 mt-2">
                                                        <label class="detail-label">Address:</label><span class="detail-value" id="g_address">--</span>
                                                    </div>
                                                    <div class="col-6 mb-2 mt-2">
                                                        <label class="detail-label">City :</label><span class="detail-value" id="g_city">--</span>
                                                    </div>
                                                    <div class="col-6 mb-2 mt-2">
                                                        <label class="detail-label">State :</label><span class="detail-value" id="g_state">--</span>
                                                    </div>
                                                    <div class="col-6 mb-2 mt-2">
                                                        <label class="detail-label">Country :</label><span class="detail-value" id="g_country">--</span>
                                                    </div>
                                                    <div class="col-6 mb-2 mt-2">
                                                        <label class="detail-label">Pincode :</label><span class="detail-value" id="g_pincode">--</span>
                                                    </div>
                                                    <div class="col-6 mb-2 mt-2">
                                                        <label class="detail-label">Allergic To :</label><span class="detail-value" id="g_allergic">--</span>
                                                    </div>
                                                    <div class="col-6 mb-2 mt-2">
                                                        <label class="detail-label">Company :</label><span class="detail-value" id="g_company">--</span>
                                                    </div>
                                                    <div class="col-6 mb-2 mt-2">
                                                        <label class="detail-label">Company Gst:</label><span class="detail-value" id="g_company_gst">--</span>
                                                    </div>
                                                    <div class="col-6 mb-2 mt-2">
                                                        <label class="detail-label">Note:</label><span class="detail-value" id="g_note">--</span>
                                                    </div>
                                                </div>
                                                <!-- Guest details styled like a card -->
                                                

                                                <!-- Button aligned left -->
                                                <div class="mt-3">
                                                    <button class="btn btn-warning" onclick="updateGuest({{ $customers[0]->id }})">Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Guest Detail</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form id="guestForm" class="needs-validation" novalidate>
                                                <div class="modal-body">
                                                    <input type="hidden" id="guestId">
                                                    <div class="mb-1">
                                                        <label for="recipient-name" class="col-form-label">First Name:</label>
                                                        <input type="text" class="form-control" id="guest_first_name" required>
                                                    </div>
                                                    <div class="mb-1">
                                                        <label for="recipient-name" class="col-form-label">Last Name:</label>
                                                        <input type="text" class="form-control" id="guest_last_name" required>
                                                    </div>
                                                    <div class="mb-1">
                                                        <label for="recipient-name" class="col-form-label">Mobile:</label>
                                                        <input type="text" class="form-control" id="guest_mobile" required>
                                                    </div>
                                                    <div class="mb-1">
                                                        <label for="recipient-name" class="col-form-label">Email:</label>
                                                        <input type="text" class="form-control" id="guest_email" required>
                                                    </div>
                                                    <div class="mb-1">
                                                        <label for="recipient-name" class="col-form-label">Address:</label>
                                                        <input type="text" class="form-control" id="guest_address" required>
                                                    </div>
                                                    <div class="mb-1">
                                                        <label for="recipient-name" class="col-form-label">CIty:</label>
                                                        <input type="text" class="form-control" id="guest_city" required>
                                                    </div>
                                                    <div class="mb-1">
                                                        <label for="recipient-name" class="col-form-label">ID Proof Type:</label>
                                                        <input type="text" class="form-control" id="guest_proof_Type" required>
                                                    </div>
                                                    <div class="mb-1">
                                                        <label for="recipient-name" class="col-form-label">ID Proof Number:</label>
                                                        <input type="text" class="form-control" id="guest_proof_number" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                        </div>
                                    <!-- Guest History Tab -->
                                    <div class="tab-pane fade" id="guest-history" role="tabpanel" aria-labelledby="history-tab">
                                        <table class="table table-bordered table-hover" id="guestHistoryTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Reservation Id</th>
                                                    <th>Bill No</th>
                                                    <th>Bill Date</th>
                                                    <th>Room Number</th>
                                                    <th>Room Type</th>
                                                    <th>Tariff Type</th>
                                                    <th>Reserved On</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    {{-- reservation modal --}}
                                    <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Reservation Id: <span class="resModelResId">-</span></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                              <div class="modal-body">
                                                <div class="row mb-1">
                                                    <div class="col">
                                                    <label class="fw-bold">First Name:</label>
                                                    <span class="resModelfirstName">-</span>
                                                    </div>
                                                    <div class="col">
                                                    <label class="fw-bold">Last Name:</label>
                                                    <span class="resModelLastName">-</span>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <div class="col">
                                                    <label class="fw-bold">Mobile:</label>
                                                    <span class="resModelMobile">-</span>
                                                    </div>
                                                    <div class="col">
                                                    <label class="fw-bold">Email:</label>
                                                    <span class="resModelEmail">-</span>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <div class="col">
                                                    <label class="fw-bold">Address:</label>
                                                    <span class="resModelAddress">-</span>
                                                    </div>
                                                    <div class="col">
                                                    <label class="fw-bold">City:</label>
                                                    <span class="resModelCity">-</span>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <div class="col">
                                                        <label class="fw-bold">Document Type:</label>
                                                        <span class="resModelDocumentType">-</span>
                                                    </div>
                                                    <div class="col">
                                                        <label class="fw-bold">ID Number:</label>
                                                        <span class="resModelIdNumber">-</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-1 resRoomDatas"></div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        {{-- reservation modal end--}}
                                        {{-- restaurant modal --}}
                                         <div class="modal fade" id="restaurantModal" tabindex="-1" aria-labelledby="restaurantModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">KOT : <span class="resModelResId">-</span></h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                              <div class="modal-body">
                                                <div class="row mb-1">
                                                    <div class="col">
                                                    <label class="fw-bold">Type:</label>
                                                    <span class="restModelType">-</span>
                                                    </div>
                                                    <div class="col">
                                                    <label class="fw-bold">Type Number:</label>
                                                    <span class="restModelTypeNumber">-</span>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <div class="col">
                                                    <label class="fw-bold">Order Time:</label>
                                                    <span class="restModelOrderTime">-</span>
                                                    </div>
                                                    <div class="col">
                                                    <label class="fw-bold">Item Qty:</label>
                                                    <span class="restModelQty">-</span>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <div class="col">
                                                    <label class="fw-bold">Complimenary:</label>
                                                    <span class="restModelComplimentary">-</span>
                                                    </div>
                                                    <div class="col">
                                                    <label class="fw-bold">Waiter:</label>
                                                    <span class="restModelWaiter">-</span>
                                                    </div>
                                                </div>

                                                <div class="row mb-1">
                                                    <div class="col">
                                                        <label class="fw-bold">Total Amount:</label>
                                                        <span class="restModelTotalAmount">-</span>
                                                    </div>
                                                    <div class="col">
                                                        <label class="fw-bold">Paid Amount:</label>
                                                        <span class="restModelPaidAmount">-</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col">
                                                        <label class="fw-bold">Assist By:</label>
                                                        <span class="restModelOrderBy">-</span>
                                                    </div>
                                                    <div class="col">
                                                        <label class="fw-bold">Order Status:</label>
                                                        <span class="restModelOrderStatus">-</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col">
                                                        <label class="fw-bold">Payment Type:</label>
                                                        <span class="restModelPaymentType">-</span>
                                                    </div>
                                                    <div class="col">
                                                        <label class="fw-bold">Notes:</label>
                                                        <span class="restModelNotes">-</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                         </div>
                                        {{-- restaurant modal end--}}
                                    <!-- Guest Restaurant Tab -->
                                    <div class="tab-pane fade" id="guest-restaurant" role="tabpanel" aria-labelledby="restaurant-tab">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover" id="guestRestaurantTable">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Reservation Id</th>
                                                        <th>Bill Number</th>
                                                        <th>Bill Date</th>
                                                        <th>Room Number</th>
                                                        <th>Kot Type</th>
                                                        <th>Assist By</th>
                                                        <th>Booked On</th>
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
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
   
@endsection

@section('extra-css')
<style>
    .guest-details-wrapper {
        padding: 10px 0;
    }
    
    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 8px 0;
        gap: 15px;
    }
    
    .detail-label {
        font-weight: 600;
        color: #333;
        margin: 0;
        min-width: 140px;
        flex-shrink: 0;
    }
    
    .detail-value {
        color: #666;
        text-align: right;
        word-break: break-word;
        flex: 1;
    }
    
    .detail-item hr {
        margin: 5px 0;
        opacity: 0.1;
    }
</style>
@endsection

@section('extra-js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    function loadGuestInfo(customerId) {
    $.ajax({
        url: "{{ route('guestHistory.getDetails') }}",
        type: "POST",
        data: { id: customerId },
        success: function (response) {

            if (response.success && response.data.length > 0) {
                let g = response.data[0];

                $('#g_guest_id').text(g.guest_id ?? '--');
                $('#g_guest_name').text((g.first_name ?? '') + ' ' + (g.last_name ?? ''));
                $('#g_mobile').text(g.mobile ?? '--');
                $('#g_email').text(g.email ?? '--');
                $('#g_address').text(g.address ?? '--');
                $('#g_city').text(g.city ?? '--');
                // $('#g_proof_type').text(g.proof_type ?? '--');
                // $('#g_id_proof').text(g.id_proof ?? '--');
                $('#g_state').text(g.state ?? '--');
                $('#g_country').text(g.country ?? '--');
                $('#g_pincode').text(g.pincode ?? '--');
                $('#g_allergic').text(g.allergic_to ?? '--');
                $('#g_company').text(g.company_name ?? '--');
                $('#g_company_gst').text(g.gst_number ?? '--');
                $('#g_note').text(g.note ?? '--');

                // Update button click
                $('#updateGuestBtn').attr('onclick', `updateGuest(${g.id})`);
            }
        },
        error: function (xhr) {
            console.log(xhr.responseText);
            toastErrorAlert('Failed to load guest details');
        }
    });
}

    $(document).ready(function() {
        let customerId = $('#customerId').val();
        loadGuestInfo(customerId);
        $('#guestHistoryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax:{
                url: "{{ route('guestHistory.historyDetails') }}",
                type: "POST",
                data: {id:customerId},
                error: function(xhr, error, thrown){
                    console.log(xhr.responseText);
                    alert('Error: '+ thrown);
            }
            },
            columns:[
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'reservation_id',
                    name: 'reservation_id'
                },
                {
                    data: 'bill_no',
                    name: 'bill_no'
                },
                {
                    data: 'bill_date',
                    name: 'bill_date'
                },
                {
                    data: 'room_num',
                    name: 'room_num'
                },
                {
                    data: 'room_type',
                    name: 'room_type'
                },
                {
                    data: 'tariff_type',
                    name: 'tariff_type'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]    
        });

        $('#guestRestaurantTable').DataTable({
            processing: true,
            serverSide: true,
             ajax:{
                url: "{{ route('guestHistory.restaurantDetails') }}",
                type: "POST",
                data: {id:customerId},
                error: function(xhr, error, thrown){
                    console.log(xhr.responseText);
                    alert('Error: '+ thrown);
            }
            },
            columns:[
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'kot_id',
                    name: 'kot_id'
                },
                {
                    data: 'bill_no',
                    name: 'bill_no'
                },
                {
                    data: 'bill_date',
                    name: 'bill_date'
                },
                {
                    data: 'room_num',
                    name: 'room_num'
                },
                {
                    data: 'kot_type',
                    name: 'kot_type'
                },
                {
                    data: 'assist_by',
                    name: 'assist_by'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ]
        }); 
    });

    function updateGuest(id){
        $.ajax({
            url: "{{ route('guestHistory.getDetails') }}",
            type: "POST",
            data: {id:id},
            success:function(response){
                let getData = response.data[0];
                console.log(getData);
                if(response.success){
                    $('#guestId').val(getData.id);
                    $('#guest_first_name').val(getData.first_name);
                    $('#guest_last_name').val(getData.last_name);
                    $('#guest_mobile').val(getData.mobile);
                    $('#guest_email').val(getData.email);
                    $('#guest_address').val(getData.address);
                    $('#guest_city').val(getData.city);
                    $('#guest_proof_Type').val(getData.proof_type);
                    $('#guest_proof_number').val(getData.id_proof);
                    $('#exampleModal').modal('show');
                }
            },
            error:function(xhr, error, thrown){
                console.log(xhr.responseText);
                alert('Error: '+ thrown);
            }
        });
    }
    $('#guestForm').on('submit', function(e){
        e.preventDefault();
        let customerId = $('#customerId').val();
        let id = $('#guestId').val();
        let first_name = $('#guest_first_name').val();
        let last_name = $('#guest_last_name').val();
        let mobile = $('#guest_mobile').val();
        let email = $('#guest_email').val();
        let address = $('#guest_address').val();
        let city = $('#guest_city').val();
        let proof_type = $('#guest_proof_Type').val();
        let id_proof = $('#guest_proof_number').val();
        $.ajax({
            url:"{{ route('guestHistory.updateDetails') }}",
            type: "POST",
            data: {id:id,first_name:first_name,last_name:last_name,mobile:mobile,email:email,address:address,city:city,proof_type:proof_type,id_proof:id_proof},
            success:function(response){
                // console.log(response);
                if(response.success){
                    $('#guestId').val('');
                    $('#guestForm')[0].reset();
                    $('.needs-validation').removeClass('was-validated');
                    $('#exampleModal').modal('hide');
                    loadGuestInfo(customerId);
                    toastSuccessAlert(response.success);
                }else{
                    toastErrorAlert('Something went wrong!');
                }

            }
        });
    })
    function getReservationDetails(id){
         $.ajax({
            url: "{{ route('guestHistory.getReservationDetails') }}",
            type: "POST",
            data: {id:id},
            success:function(response){
                let getData = response.resData[0];
                let getRoomData = response.resRoomData;
                $('.resModelResId').text(getData.reservation_id);
                $('.resModelfirstName').text(getData.first_name);
                $('.resModelLastName').text(getData.last_name);
                $('.resModelMobile').text(getData.mobile);
                $('.resModelEmail').text(getData.email);
                $('.resModelAddress').text(getData.address);
                $('.resModelCity').text(getData.city);
                $('.resModelDocumentType').text(getData.document_type);
                $('.resModelIdNumber').text(getData.id_number);
                $('.resRoomDatas').empty(); // clear old data
                let m = 1;

                getRoomData.forEach(element => {
                $('.resRoomDatas').append(`
                    <div class="card mb-2">
                    <div class="card-body">
                        <div class="row mb-1">
                        <div class="col">
                            <label class="fw-bold">Room Number:</label>
                            <span>${element.room_alloted}</span>
                        </div>
                        <div class="col">
                            <label class="fw-bold">Room Type:</label>
                            <span>${element.room_category}</span>
                        </div>
                        </div>
                        <div class="row mb-1">
                        <div class="col">
                            <label class="fw-bold">Tariff Type:</label>
                            <span>${element.tariff_type}</span>
                        </div>
                        <div class="col">
                            <label class="fw-bold">Tariff Amount:</label>
                            <span>${element.tariff_amount}</span>
                        </div>
                        </div>
                    </div>
                    </div>
                `);
                m++;
                });
                $('#reservationModal').modal('show');
            },
            error:function(xhr, error, thrown){
                console.log(xhr.responseText);
                alert('Error: '+ thrown);
            }
        });
    }

function getResturantDetails(id){
    $.ajax({
        url: "{{ route('guestHistory.getRestaurantDetails') }}",
        type: "POST",
        data: {id:id},
        success:function(response){
            if(response.success){
                let getData = response.data[0];
                $('.resModelResId').text(getData.kot_id);
                $('.restModelType').text(getData.type);      
                $('.restModelTypeNumber').text(getData.type_number); 
                $('.restModelOrderTime').text(getData.order_time);     
                $('.restModelQty').text(getData.item_qty);            
                $('.restModelComplimentary').text(getData.complimentary); 
                $('.restModelWaiter').text(getData.waiter);           
                $('.restModelTotalAmount').text(getData.total_amount); 
                $('.restModelPaidAmount').text(getData.paid_amount);   
                $('.restModelOrderBy').text(getData.assist_by);         
                $('.restModelOrderStatus').text(getData.order_status);  
                $('.restModelPaymentType').text(getData.payment_type); 
                $('.restModelNotes').text(getData.notes);   
                $('#restaurantModal').modal('show'); 
            }
        },
        error:function(xhr){
            console.error("Error fetching restaurant details:", xhr);
        }
    });
}

function kotPrintBill(id){
    let url = '../../kot/kot-generated-bill-invoice/'+id;
    window.open(url,'_blank');
}

function printReservationBill(id){
    let url = '../../report/guest-reservation-print/'+id;
    window.open(url,'_blank');
}
</script>
@endsection