@extends('backend.layouts.main')
@section('main-container')
@section('title')
QR Menu Order
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">QR Menu Orders</h3>
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
                            <div class="table-responsive scroll-sm items-table border rounded">
                                <table class="table bordered-table sm-table mb-0 border-0">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            {{-- <th>Id</th> --}}
                                            <th>Order Date</th>
                                            <th>Order Time</th>
                                            <th>Order Source</th>
                                            <th>Source Number</th>
                                            <th>Total Item</th>
                                            <th>Total Item Cost</th>
                                            <th>Subtotal</th>
                                            <th>Tax Amount</th>
                                            <th>Total Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kotList as $item)
                                            @php
                                            $no = 1;
                                            @endphp
                                            <tr>
                                                <td>{{$no++}}</td>
                                                {{-- <td>{{$item['menu_id']}}</td> --}}
                                                <td>{{$item['date']}}</td>
                                                <td>{{$item['date_time']}}</td>
                                                <td>{{$item['type']}}</td>
                                                <td>{{$item['type_number']}}</td>
                                                <td>{{$item['total_item_qty']}}</td>
                                                <td>{{$item['total']}}</td>
                                                <td>{{$item['sub_total']}}</td>
                                                <td>{{$item['total_gst']}}</td>
                                                <td>{{$item['grand_total']}}</td>
                                                <td><i class="icon-pencil-alt" data-bs-toggle="offcanvas" href="#offcanvasRight" role="button" aria-controls="offcanvasRight" onclick="getKotDetail({{$item['id']}},'{{$item['kot_id']}}')" ></i></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- user detail Modal  start-->
            <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="customerModalLabel">Customer Detail</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Name</label>
                                        <input class="form-control form-control-sm" type="text" placeholder="Name" id="generated_kot_customer_name"> 
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label class="form-label">Phone</label>
                                        <input class="form-control form-control-sm" type="text" placeholder="Phone" id="generated_kot_phone"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between flex-nowrap">
                            <button type="button" class="btn btn-outline-danger w-50" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary w-50" onclick="addGeneratedKotCustomer()">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- user detail Modal  end-->
            {{-- view kot start --}}
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" style="width:565px !important;">
                <div class="offcanvas-header border-bottom position-relative">
                    <h5 id="offcanvasRightLabel">View KOT</h5>
                    <span class="qr_menu_generate_kot_id d-none">0</span>
                    {{-- <span class=""></span> --}}
                    <button type="button" class="btn-close text-reset " data-bs-dismiss="offcanvas" aria-label="Close" ></button>
                </div>
                <div class="offcanvas-body p-0">
                    <div class="book-item-wrapper h-100 position-relative">
                        {{-- order type section start --}}
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="order-type active">
                                <h5>Dine In</h5>
                            </div>
                            <div class="order-type">
                                <h5>Delivery</h5>
                            </div>
                            <div class="order-type">
                                <h5>Pick Up</h5>
                            </div>
                        </div>
                        {{-- order type section end --}}
                        {{-- order section start --}}
                        <div class="d-flex justify-content-between align-items-center border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="order-section border-end" data-bs-toggle="modal" data-bs-target="#tableModal">
                                    <small class="kot-small-font">Table/Room</small>
                                    <div class="icon"><i class="ri-service-bell-line"></i></div>
                                    <p class="mb-0 text-danger generated-table-room-number"></p>
                                </div>
                                <div class="order-section border-end" data-bs-toggle="modal" data-bs-target="#customerModal">
                                    <small class="kot-small-font">Customer</small>
                                    <div class="icon"><i class="ri-user-3-line"></i></div>
                                </div>
                                <div class="order-section border-end" data-bs-toggle="modal" data-bs-target="#noteModal">
                                    <small class="kot-small-font">Note</small>
                                    <div class="icon"><i class="ri-edit-box-line"></i></div>
                                </div>
                                <div class="order-section border-end" data-bs-toggle="modal" data-bs-target="#waiterModal">
                                    <small class="kot-small-font">Steward</small>
                                    <div class="icon"><i class="ri-group-line"></i></div>
                                    <p class="mb-0 text-danger waiter_name_display"></p>
                                </div>
                                {{-- <div class="order-section border-end convert-to-room-kot">
                                    <small class="kot-small-font">To Room</small>
                                    <div class="icon"><i class="ri-exchange-line"></i></div>
                                </div> --}}
                            </div>
                            <div class="order-section location text-dark bg-warning border-start">
                                <p class="mb-0 text-truncate table-area-room-no">Ground Floor</p>
                            </div>
                        </div>
                        {{-- order section end --}}
                        {{-- order item section start --}}
                        <div class="order-items kot-view">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th><a href="#">Items</a></th>
                                        <th class="text-center"></th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-end">Price</th>
                                    </tr>
                                </thead>
                                <tbody class="kot-selected-item-wrapper generated-kot-item-list"></tbody>
                            </table>
                        </div>
                        {{-- order item section end --}}
                        <div class="book-item-footer position-absolute bottom-0 w-100">
                            <div class="order-item-offer bg-dark p-2" style="display:none;">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="mb-3">
                                            <label class="d-block mb-0" for="generated_complimentary_offer"></label>
                                            <input class="checkbox_animated" id="generated_complimentary_offer" type="checkbox" onclick="calculateTotal()">Complimentary
                                        </div>
                                        <div class="mb-3 d-none">
                                            <label class="d-block mb-0" for="generated_coupon_code"></label>
                                            <input class="checkbox_animated" id="generated_coupon_code" type="checkbox">Apply Coupon
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check form-check-inline me-3 radio radio-primary">
                                                <input class="form-check-input" id="radioinline3" type="radio" name="paymentTypeGenerated" value="Due">
                                                <label class="form-check-label mb-0" for="radioinline3">Due</label>
                                            </div>
                                        </div>
                                        {{-- show coupon field start--}}
                                        <div id="coupon-field" style="display:none;">
                                            <div class="d-flex align-items-center">
                                                <div class="form-group">
                                                    <input class="form-control form-control-sm bg-transparent py-1" type="text" placeholder="Coupon Code" id="generated_coupon_code"> 
                                                </div>
                                                <button class="btn btn-primary btn-sm ms-2 py-1">Apply</button>
                                            </div>
                                        </div>
                                        {{-- show coupon field end--}}
                                        <div class="form-group mt-2">
                                                <label class="form-label">Payment Mode</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <div class="form-check-size">
                                                <div class="form-check form-check-inline me-3 radio radio-primary">
                                                    <input class="form-check-input" id="radioinline1" type="radio" name="paymentTypeGenerated" value="Cash" checked>
                                                    <label class="form-check-label mb-0" for="radioinline1">Cash</label>
                                                </div>
                                                <div class="form-check form-check-inline me-3 radio radio-primary">
                                                    <input class="form-check-input" id="radioinline2" type="radio" name="paymentTypeGenerated" value="Card">
                                                    <label class="form-check-label mb-0" for="radioinline2">Card</label>
                                                </div>
                                                
                                                <div class="form-check form-check-inline me-3 radio radio-primary">
                                                    <input class="form-check-input" id="radioinline4" type="radio" name="paymentTypeGenerated" value="Other">
                                                    <label class="form-check-label mb-0" for="radioinline4">Other</label>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- show when payment mode is card start --}}
                                        <div id="card-detail" style="display:none;" class="mt-2">
                                            <div class="form-group" style="width:200px;">
                                                <input class="form-control form-control-sm bg-transparent py-1" type="text" placeholder="Enter Card Number" id="generated_card_number"> 
                                            </div>
                                        </div>
                                        {{-- show when payment mode is card end --}}
                                        {{-- show when payment mode is other start --}}
                                        <div id="other-payment" style="display:none;" class="mt-2">
                                            <div class="d-flex align-items-center">
                                                <select class="form-select forrm-select-sm bg-transparent py-1 me-3 text-white" id="generated_other_type" style="width:100px;">
                                                    <option value="">Select</option>
                                                    @foreach($payment_methods as $method)
                                                        @if($method['id'] > 2)
                                                            <option value="{{$method['id']}}">{{$method['name']}}</option>
                                                        @endif
                                                    @endforeach
                                                </select> 
                                                <div class="form-group">
                                                    <input class="form-control form-control-sm bg-transparent py-1" type="text" placeholder="Enter Reference Number" id="generated_other_ref_number"> 
                                                </div>
                                            </div>
                                        </div>
                                        {{-- show when payment mode is other end --}}
                                        <div class="mt-2">
                                            <div class="form-group">
                                                <label class="form-check-label mb-0">Narration</label>
                                                <textarea class="form-control form-control-sm bg-transparent py-1" id="generated_kot_narration" placeholder="Narration"></textarea> 
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <table class="table">
                                            <tr>
                                                <td class="text-end py-1 text-white border-0 f-6">Total - </td>
                                                <td class="text-end py-1 border-0 text-warning f-6 generated_total">0</td>
                                            </tr>
                                            <tr class="d-none">
                                                <td class="text-end py-1 text-white border-0">Discount Type - </td>
                                                <td class="text-end py-1 text-white border-0">
                                                    <select class="form-select form-select-sm bg-transparent py-1 text-white" id="generated-discount-type-select" onChange="calculateTotal()">
                                                        <option value="percent" selected>%</option>
                                                        {{-- <option value="amount">₹</option> --}}
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end py-1 text-white border-0">Discount - </td>
                                                <td class="text-end py-1 text-white border-0">
                                                    <div class="form-group" style="width:80px;">
                                                        <input class="form-control form-control-sm bg-transparent py-1" type="text" placeholder="0" id="generated-discount-value" onkeyup=" calculateTotal()" >
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr class=" d-none">
                                                <td class="text-end py-1 text-white border-0 d-none">Coupon Value - </td>
                                                <td class="text-end py-1 text-white border-0">
                                                    <div class="form-group" style="width:80px;">
                                                        <input class="form-control form-control-sm bg-transparent py-1" type="text" placeholder="0" id="generated_coupon_value">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end py-1 text-white border-0">GST - </td>
                                                <td class="text-end py-1 text-white border-0">
                                                    <div class="form-group" style="width:80px;">
                                                        <input class="form-control form-control-sm bg-transparent py-1" type="text" placeholder="0" readonly id="generated-grand-gst-amount" value="0">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end py-1 text-white border-0">Sub Total - </td>
                                                <td class="text-end py-1 text-white border-0">
                                                    <div class="form-group" style="width:80px;">
                                                        <input class="form-control form-control-sm bg-transparent py-1" type="text" placeholder="0" readonly id="generated-subtotal-amount">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end py-1 text-white border-0">Adjustment - </td>
                                                <td class="text-end py-1 text-white border-0">
                                                    <div class="form-group" style="width:80px;">
                                                        <input class="form-control form-control-sm bg-transparent py-1" type="text" placeholder="0" id="generated-total-adjustment" onkeyup=" calculateTotal(1)"> 
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end py-1 text-white border-0">Grand Total - </td>
                                                <td class="text-end py-1 text-white border-0 generated-grand-total-amount">0</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="offcanvas-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger btn-square py-2 w-33" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
                    <button class="btn btn-primary btn-footer-toggle btn-square py-2 w-33 d-flex align-items-center gap-2">
                        <input class="checkbox_animated m-0" id="record-payment" type="checkbox">
                        <span class="ms-1">Record Payment</span>
                    </button>
                    <button type="button" class="btn btn-success btn-square py-2 w-33" onClick="generateKotQr()">Generate KOT</button>
                </div>
            </div>
            {{-- view kot end --}}
        </div>
    </div>

    <!-- Waiter Modal Start-->
    <div class="modal fade" id="waiterModal" tabindex="-1" aria-labelledby="waiterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="waiterModalLabel">Waiter</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Waiter Name</label>
                            <select class="form-select form-select-sm" id="kot_waiter">
                                <option value="">Select</option>
                                @foreach($waiters as $waiter)
                                    <option value="{{$waiter['id']}}">{{$waiter['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between flex-nowrap">
                    <button type="button" class="btn btn-outline-danger w-50" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary w-50" onclick="setWaiter()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Waiter Modal End-->

    <!-- Note Modal Start-->
    <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noteModalLabel">Add Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label" for="order_note">Note</label>
                                <textarea class="form-control form-control-sm" id="order_note" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between flex-nowrap">
                    <button type="button" class="btn btn-outline-danger w-50" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary w-50" onclick="addOrderNote()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Note Modal End -->

    @include('backend.modules.models.KotConvertModal')
@endsection
@section('extra-js')
<script>
     document.addEventListener("DOMContentLoaded", function () {
        const checkbox = document.querySelector("#record-payment");
        const bookItemFooter = document.querySelector(".order-item-offer");
        const orderItems = document.querySelector(".order-items.kot-view");

        checkbox.addEventListener("change", function () {
            const isChecked = checkbox.checked;
            bookItemFooter.classList.toggle("collapsed", isChecked);

            if (isChecked) {
                orderItems.style.height = "calc(100vh - 420px)";
            } else {
                orderItems.style.height = "calc(100vh - 188px)";
            }
        });
    });
    const getKotQrDetailUpdate = "{{ route('qr-menu-orders-detail.getKotQrDetailUpdate') }}";
    const QrkotDetail = "{{ route('get-qr-kot-detail.getQrKotDetail') }}";
</script>
    <script src="{{asset('backend/assets/js/custom/kot/qr-kot-order.js')}}"></script>
@endsection
