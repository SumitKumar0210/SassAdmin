@extends('backend.layouts.main')
@section('title','Generate KOT')
@section('main-container')
<style>

.menu-flex {
    display: flex;
    flex-wrap: wrap;
    gap: 10px 30px;
  }

  .skeleton-line {
    width: 130px; /* same width as your menu item */
    height: 60px;
    border-radius: 4px;
    background: #e0e0e0;
    position: relative;
    overflow: hidden;
  }

  /* Shimmer animation */
  .skeleton-line::after {
    content: "";
    position: absolute;
    top: 0;
    left: -100px;
    width: 80px;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.5), transparent);
    animation: shimmer 1.2s infinite;
  }

  @keyframes shimmer {
    100% {
      transform: translateX(300%);
    }
  }

  /* ===== Skeleton Loader ===== */
    .skeleton-container {
      width: 220px;
      height: 100vh;
      padding: 2px 0;
      display: flex;
      flex-direction: column;
      gap: 1px;
    }

    .skeleton-item {
      width: 97%;
      height: 40px;
      margin: 0 auto;
      background: linear-gradient(
        90deg,
        #e0e0e0 25%,
        #e3e3e3 50%,
        #e0e0e0 75%
      );
      background-size: 200% 100%;
      animation: shimmer1 1.5s infinite;
    }

    @keyframes shimmer1 {
      0% {
        background-position: -200% 0;
      }
      100% {
        background-position: 200% 0;
      }
    }

   
</style>
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid gx-0">
            <div class="row mb-3">
                <div class="col-xl-8 col-lg-8 col-md-7 col-sm-12 px-0">
                    <div class="kot-item-header-top">
                        <div class=" d-flex justify-content-between align-items-center px-2 py-1">
                            <div>
                                <p class="mb-0">Table Started By</p>
                                <p class="mb-0">{{$bill_by}}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                   <button id="filterButton" class="allitem">All</button>
                                </div>
                                <div class="kot-date-time">
                                    <p class="mb-0">Date & Time</p>
                                    <p class="mb-0">{{date('d-m-Y')}} <span class="current_time">00:00:00</span></p>
                                    <span class="last_kot d-none">{{$lastKot}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div class="kot-item-menu">
                            {{-- <select class="form-select forrm-select-sm" id="menu-items"></select> --}}
                            <ul class="menu-item">
                                <div class="skeleton-container" id="skeleton">
                                    @for($i=0; $i<= 20;$i++)
                                    <div class="skeleton-item"></div>
                                    @endfor
                                </div>
                            </ul>
                        </div>
                        <div class="kot-item-menu food-items">
                            <div class="kot-item-header d-none d-lg-block">
                                <div class="d-flex justify-content-between align-items-center p-2">
                                    <div class="w-50 me-2">
                                    <div class="input-group me-2">
                                        <span class="input-group-text text-muted"><i class="ri-search-line"></i></span>
                                        <input id="itemSearchInput" class="form-control form-control-sm" type="text" placeholder="Search item" onkeyup="filterItemName(this.value)">
                                    </div>
                                    <div class="d-block position-relative" style="z-index :99;">
                                        <ul id="searchItemDropdown" class="search-item list-group position-absolute w-100 rounded-0 d-none"></ul>
                                    </div>
                                    </div>
                                    <div class="w-50 ms-2">
                                    <div class="input-group">
                                        <span class="input-group-text text-muted"><i class="ri-search-line"></i></span>
                                        <input class="form-control form-control-sm" type="text" placeholder="Search by item code" onchange="addItemFromInput(this.value)">
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kot-item-header d-block d-lg-none">
                                <div class="d-flex justify-content-between align-items-center p-2">
                                    <div class="w-50 ms-2">
                                        <div class="input-group">
                                            <span class="input-group-text text-muted"><i class="ri-search-line"></i></span>
                                            <input class="form-control form-control-sm" type="text" placeholder="Search by item" id="search_itemname_code">
                                        </div>
                                    </div>
                                    <div class="w-50 ms-2">
                                        <div class="input-group">
                                            <button class="btn btn-primary btn-sm mb-1 kotgenerate" onclick="filterItem()"><i class="ri-search-line"></i> Fetch Item</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="kot-itemlist-wrapper p-3 border-bottom all-kot-itemlist">
                                <div class="menu-flex">
                                    @for($i=0; $i < 60; $i++)
                                        <div class="skeleton-line"></div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-5 col-sm-12 p-0">
                    <audio id="clickSound" src="{{ asset('backend/uploads/tone/'.$hotlr[0]->item_add.'')}}" preload="auto"></audio>
                    <div class="book-item-wrapper border-start position-relative">
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
                                    <p class="mb-0 text-danger room_table_number_display"></p>
                                </div>
                                <div class="order-section border-end" data-bs-toggle="modal" data-bs-target="#customerModal">
                                    <small class="kot-small-font">Customer</small>
                                    <div class="icon"><i class="ri-user-3-line"></i></div>
                                </div>
                                <div class="order-section border-end" data-bs-toggle="modal" data-bs-target="#noteModal" onClick="getLastNote()">
                                    <small class="kot-small-font">Note</small>
                                   <div class="icon"><i class="ri-edit-box-line"></i></div>
                                </div>
                                <div class="order-section border-end" data-bs-toggle="modal" data-bs-target="#waiterModal">
                                    <small class="kot-small-font">Steward</small>
                                    <div class="icon"><i class="ri-group-line"></i></div>
                                    <p class="mb-0 text-danger waiter_name_display"></p>
                                </div>
                            </div>
                            <div class="order-section location text-dark bg-warning border-start">
                                <p class="mb-0 text-truncate table-area-room-no">Area</p>
                            </div>
                        </div>
                        {{-- order section end --}}
                        {{-- order item section start --}}
                        <div class="order-items">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th><a href="#">Items</a></th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-end">Price</th>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="py-1 kot-title">KOT - <span class="kot_serial_number"> 00 </span> <span class="ms-2">Time - <span class="current_time_min">00:00:00</span></span></td>
                                    </tr>
                                </thead>
                                <tbody class="kot-selected-item-wrapper cart-items"></tbody>
                            </table>
                        </div>
                        {{-- order item section end --}}
                        <div class="book-item-footer position-absolute bottom-0 w-100">
                            <div class="order-item-offer bg-dark p-2" style="display:none;">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <div class="mb-3">
                                            <label class="d-block mb-0" for="offer"></label>
                                            <input class="checkbox_animated" id="kot_complimentary_offer" type="checkbox">Complimentary
                                        </div>
                                        <div class="mb-3 d-none">
                                            <label class="d-block mb-0" for="coupon"></label>
                                            <input class="checkbox_animated" id="kot_apply_coupon" type="checkbox">Apply Coupon
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check form-check-inline me-3 radio radio-primary">
                                                <input class="form-check-input" id="radioinline3" type="radio" name="paymentType" value="Due" checked>
                                                <label class="form-check-label mb-0" for="radioinline3">Due</label>
                                            </div>
                                        </div>
                                        {{-- show coupon field start--}}
                                        <div id="coupon-field" style="display:none;">
                                            <div class="d-flex align-items-center">
                                                <div class="form-group">
                                                    <input class="form-control form-control-sm bg-transparent py-1" type="text" id="kot_coupon_code" placeholder="Coupon Code"> 
                                                </div>
                                                <button class="btn btn-primary btn-sm ms-2 py-1" onclick="checkCoupon()">Apply</button>
                                            </div>
                                        </div>
                                        {{-- show coupon field end--}}
                                        <div class="form-group mt-2">
                                             <label class="form-label">Payment Type</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <div class="form-check-size">
                                                <div class="form-check form-check-inline me-3 radio radio-primary">
                                                    <input class="form-check-input" id="radioinline1" type="radio" name="paymentType" value="Cash">
                                                    <label class="form-check-label mb-0" for="radioinline1">Cash</label>
                                                </div>
                                                <div class="form-check form-check-inline me-3 radio radio-primary">
                                                    <input class="form-check-input" id="radioinline2" type="radio" name="paymentType" value="Card">
                                                    <label class="form-check-label mb-0" for="radioinline2">Card</label>
                                                </div>
                                                
                                                <div class="form-check form-check-inline me-3 radio radio-primary">
                                                    <input class="form-check-input" id="radioinline4" type="radio" name="paymentType" value="Other">
                                                    <label class="form-check-label mb-0" for="radioinline4">Other</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        {{-- show when payment mode is card start --}}
                                        <div id="card-detail" style="display:none;" class="mt-2">
                                            <div class="form-group" style="width:200px;">
                                                <input class="form-control form-control-sm bg-transparent py-1" type="text" id="kot_payment_card" placeholder="Enter Card Number"> 
                                            </div>
                                        </div>
                                        {{-- show when payment mode is card end --}}
                                        {{-- show when payment mode is other start --}}
                                        <div id="other-payment" style="display:none;" class="mt-2">
                                            <div class="d-flex align-items-center">
                                                <select class="form-select forrm-select-sm bg-transparent py-1 me-3 text-white" id="kot_payment_other_type" style="width:100px;">
                                                    <option value="">Select</option>
                                                    @foreach($payment_methods as $method)
                                                        @if($method->id > 2)
                                                            <option value="{{$method->id}}">{{$method->name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select> 
                                                <div class="form-group">
                                                    <input class="form-control form-control-sm bg-transparent py-1" type="text" id="kot_payment_other_ref" placeholder="Enter Reference Number"> 
                                                </div>
                                            </div>
                                        </div>
                                        {{-- show when payment mode is other end --}}
                                        <div class="mt-2">
                                            <div class="form-group">
                                                <label class="form-check-label mb-0">Narration</label>
                                                <textarea class="form-control form-control-sm bg-transparent py-1" id="kot_narration" placeholder="Narration"></textarea> 
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <table class="table">
                                            <tr>
                                                <td class="text-end py-1 text-white border-0 f-6">Total - </td>
                                                <td class="text-end py-1 border-0 text-warning f-6 grand-total-cost">0</td>
                                            </tr>
                                            <tr class="d-none">
                                                <td class="text-end py-1 text-white border-0">Discount Type - </td>
                                                <td class="text-end py-1 text-white border-0">
                                                    <select class="form-select form-select-sm bg-transparent py-1 text-white" id="discount-type-select" onchange="calcuateTotal()">
                                                    <option value="percent">%</option>
                                                    {{-- <option value="amount">₹</option> --}}
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end py-1 text-white border-0">Discount - </td>
                                                <td class="text-end py-1 text-white border-0">
                                                    <div class="form-group" style="width:80px;">
                                                        <input class="form-control form-control-sm bg-transparent py-1" type="text" maxlength="4" placeholder="0" id="discount-value" onkeyup="calcuateTotal()">
                                                    </div>
                                                </td>
                                            </tr>
                                             <tr class="d-none">
                                                <td class="text-end py-1 text-white border-0">Coupon Value - </td>
                                                <td class="text-end py-1 text-white border-0">
                                                    <div class="form-group" style="width:80px;">
                                                        <input class="form-control form-control-sm bg-transparent py-1" type="text" placeholder="0" id="coupon_value">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end py-1 text-white border-0">GST - </td>
                                                <td class="text-end py-1 text-white border-0">
                                                    <div class="form-group" style="width:80px;">
                                                        <input class="form-control form-control-sm bg-transparent py-1 grand-gst-amount" type="text" placeholder="0" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end py-1 text-white border-0">Subtotal - </td>
                                                <td class="text-end py-1 text-white border-0">
                                                     <div class="form-group" style="width:80px;">
                                                        <input class="form-control form-control-sm bg-transparent py-1" id="subtotal" type="text" placeholder="0" readonly>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end py-1 text-white border-0">Adjustment - </td>
                                                <td class="text-end py-1 text-white border-0">
                                                    <div class="form-group" style="width:80px;">
                                                        <input class="form-control form-control-sm bg-transparent py-1" id="total-adjustment" maxlength="4" type="text" placeholder="0" onkeyup="calcuateTotal(1)"> 
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="text-end py-1 text-white border-0">Grand Total - </td>
                                                <td class="text-end py-1 text-white border-0 grand-total-amount">
                                                    0
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="order-item-offer px-2 py-2 border-top d-none amount-detail-view bg-light w-100">
                                <div class="d-flex flex-wrap align-items-center justify-content-between">
                                    <button class="btn btn-primary btn-sm mb-xl-0 mb-lg-2 px-3 btn-footer-toggle d-flex align-items-center gap-2">
                                        <input class="checkbox_animated m-0" id="record-payment" type="checkbox">
                                        <span class="ms-1" style="padding-top:2px;">Pay</span>
                                    </button>
                                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                                        <!--<button class="btn btn-secondary btn-sm mb-1 me-1 kotgenerate" onclick="generateKot(0)"><span>₹ </span>Pay</button>-->
                                        <button class="btn btn-secondary btn-sm mb-1 kotgenerate" onclick="generateKot(1)"><i class="ri-printer-line"></i> Create</button>
                                        <button class="btn btn-secondary btn-sm mb-1 kotprocessing d-none">Placing Order </button>
                                        <button class="btn btn-outline-dark btn-sm ms-1 mb-0"><span>₹ </span><span class="grand-total-amount"></span></button> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid end-->
    </div>
    <!-- TABLE number Modal  start-->
    <div class="modal fade" id="tableModal" tabindex="-1" aria-labelledby="tableModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="tableModalLabel">Table/Room Number</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-check-size">
                                <div class="form-check form-check-inline radio radio-primary">
                                    <input class="form-check-input" id="radioTable" type="radio" name="radio5" value="Table" checked onclick="toggleDropdown()">
                                    <label class="form-check-label mb-0" for="radioTable">Table</label>
                                </div>
                                <div class="form-check form-check-inline radio radio-primary">
                                    <input class="form-check-input" id="radioRoom" type="radio" name="radio5" value="Room" onclick="toggleDropdown()">
                                    <label class="form-check-label mb-0" for="radioRoom">Room</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3" id="tableDropdown" style="display: none;">
                            <label class="form-label">Table No.</label>
                            <select class="form-select form-select-sm" id="kot_table_number">
                                <option value="">Select</option>
                                @foreach($tableArea as $area)
                                <optgroup class="text-muted" label="{{$area['area']}}">
                                    @foreach($area['table'] as $table)
                                    <option value="{{$table['id']}}">{{$table['number']}}</option>
                                    @endforeach
                                </optgroup>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 mb-3" id="roomDropdown">
                            <label class="form-label">Room No.</label>
                            <select class="form-select form-select-sm" id="kot_room_number">
                                <option value="">Select</option>
                                @foreach($roomList as $area)
                                    <optgroup class="text-muted" label="{{$area['name']}}">
                                        @foreach($area['rooms'] as $room)
                                            <option value="{{$room['id']}}">{{$room['room_number']}}</option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between flex-nowrap">
                    <button type="button" class="btn btn-outline-danger w-50" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary w-50" onclick="getKotOrderArea()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <!-- TABLE number Modal  end-->
      <!-- Waiter Modal  start-->
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
    <!-- Waiter Modal  end-->
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
                        <input class="form-control form-control-sm" type="text" placeholder="Name" id="generate_kot_customer_name"> 
                        <div class="generate_kot_customer_name"></div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-group mb-3">
                        <label class="form-label">Phone</label>
                        <input class="form-control form-control-sm" type="number" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" placeholder="Phone" maxlength="10" id="generate_kot_phone"> 
                        <div class="generate_kot_phone"></div>
                    </div>
                </div>
            </div>
            </div>
            <div class="modal-footer justify-content-between flex-nowrap">
            <button type="button" class="btn btn-outline-danger w-50" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary w-50" onclick="addKotCustomer()">Submit</button>
            </div>
        </div>
        </div>
    </div>
    <!-- user detail Modal  end-->
    <!-- Note Modal  start-->
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
    <!-- Note Modal  end-->

@endsection
@section('extra-js')
 <script>
    function toggleDropdown() {
        const isRoom = document.getElementById('radioRoom').checked;
        document.getElementById('roomDropdown').style.display = isRoom ? 'block' : 'none';
        document.getElementById('tableDropdown').style.display = isRoom ? 'none' : 'block';
    }

    // Trigger on page load to set correct state
    window.onload = toggleDropdown;
    $('body').on('click', '.submenu-toggle', function(e) {
        e.stopPropagation(); // Prevents event bubbling
        const $icon = $(this).find('i.icofont');
        const $submenuContainer = $(this).closest('.has-submenu');
        const $submenu = $submenuContainer.find('.submenu');
        $submenu.toggle(); // Optional animation

        // Toggle arrow direction
        $icon.toggleClass('icofont-thin-down icofont-thin-up');
        // Toggle padding-bottom on .has-submenu
        if ($submenu.is(':visible')) {
            $submenuContainer.css('padding-bottom', '0'); // Change padding when expanded
        } else {
            $submenuContainer.css('padding-bottom', '10px'); // Reset when collapsed
        }
    });
</script>
<script>
    const itemSearchInput = document.getElementById('itemSearchInput');
    const searchItemDropdown = document.getElementById('searchItemDropdown');
    itemSearchInput.addEventListener('input', function () {
        if (this.value.trim() !== '') {
        searchItemDropdown.style.display = 'block';
        } else {
        searchItemDropdown.style.display = 'none';
        }
    });

    document.getElementById('kot_apply_coupon').addEventListener('change', function () {
        const couponField = document.getElementById('coupon-field');
        couponField.style.display = this.checked ? 'block' : 'none';
    });

    document.querySelectorAll('input[name="paymentType"]').forEach((radio) => {
        radio.addEventListener('change', function () {
            const value = this.value;
            document.getElementById('card-detail').style.display = value === 'card' ? 'block' : 'none';
            document.getElementById('other-payment').style.display = value === 'other' ? 'block' : 'none';
        });
    });

    function time() {
        let d = new Date();
        let s = d.getSeconds();
        let m = d.getMinutes();
        let h = d.getHours();
        $('.current_time').html(("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2));
        $('.current_time_min').html(("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2));
        $('.kot_serial_number').html( $('.last_kot').html());
    }

    setInterval(time, 1000);

</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const checkbox = document.querySelector("#record-payment");
        const bookItemFooter = document.querySelector(".order-item-offer");
        const orderItems = document.querySelector(".order-items");

        checkbox.addEventListener("change", function () {
        const isChecked = checkbox.checked;
        bookItemFooter.classList.toggle("collapsed", isChecked);

        if (isChecked) {
            orderItems.style.height = "calc(100vh - 580px)";
        } else {
            orderItems.style.height = "calc(100vh - 319px)";
        }
        });
    });
</script>
<script>
    const getMenuList = "{{ route('menu-item-list.getItemMenuList') }}";
    const addKot = "{{ route('create-kot.store') }}";
</script>
<script src="{{asset('backend/assets/js/custom/kot/generate-kot.js')}}"></script>
@endsection
