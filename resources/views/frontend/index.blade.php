
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$config[0]->name}} | MENU</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('backend/assets/css/vendors/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" integrity="sha512-XcIsjKMcuVe0Ucj/xgIXQnytNwBttJbNjltBV18IOnru2lDPe9KRRyvCXw6Y5H415vbBLRm8+q6fmLUU7DfO6Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/x-icon" href="{{ asset('backend/'.$config[0]->logo.'')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/sweetalert2.css')}}">
    <style>
        @media screen and (min-device-width: 300px) and (max-device-width: 768px) {
            .filter-item {
                padding: 0px 0.65rem !important;
                margin-right: 5px !important;
                columns: 100px 4;
            }

            .filter-item span {
                font-size: 12px !important;
            }
        }

        #loading-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            z-index: 5000;
            background: rgba(0, 0, 0, 0.788);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #loading-wrapper .spinner-border {
            width: 5rem;
            height: 5rem;
            color: #33bfbf;
        }

        #loder {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0, 0, 0, 0.95);
        }

        .offcanvaswidth {
            width: 50% !important;
        }

        @media only screen and (max-width: 800px) {
            .offcanvaswidth {
                width: 100% !important;
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    
        .border {
            border-color: #33bfbf33 !important;
        }
        .badge_color {
            background-color: #33bfbf !important;
        }

        .btn-menu:hover {
            background-color: #33bfbfbf !important;
        }

        .cart_button:hover {
            background-color: #33bfbf33 !important;
        }

        .filter-item:hover,
        .filtermenu:hover {
            border-color: #33bfbfbf !important;
        }

        .add-btn {
            color: #33bfbf;
            border: 1px solid #33bfbf33;
        }

        .qty-controls {
            color: #33bfbf;
            border: 1px solid #33bfbf66;
        }

        .filter_data:hover, .decrement:hover, .increment:hover {
            background-color: #33bfbfbf !important;
            color: #fff;
        }

        .filter_clear_data:hover {
            background-color: #33bfbf33 !important;
        }

        .add-btn:hover {
            background-color: #eaeded;
        }

        .add-item-btn {
            background: #33bfbf;
        }

        .btn-theme {
            background: #33bfbf;
        }

        .btn-theme-light {
            border: 1px solid #33bfbf;
        }

        .filter-item {
            border-color: #33bfbf33;
        }

        #label_close {
            color: white;
        }

        .toggle-icon,
        .badge_color {
            background-color: #33bfbf33;
        }

        .toggle-icon {
            color: #33bfbf;
        }

        .menu-description li a:hover {
            color: #33bfbf;
        }

        .main-footer {
            font-size: 13px !important;
        }

        .item-summary {
            background-color: #33bfbf;
        }

        #cartModel .filter-title h5 {
            color: #33bfbf;
        }
        .cart_class:hover {
            color: #000000 !important;
            cursor: pointer;
        }

        /* summary modal */
        .summary-qty-description {
            margin-bottom: 0;
            font-size: 13px;
            line-height: 1.4;
        }
        .summary-qty-title {
            font-size: 16px !important;
            margin-bottom: 2px !important;
        }
        .custom-checkbox {
            display: flex;
            align-items: center;
            cursor: pointer;
            user-select: none;
            font-size: 14px;
        }

        .custom-checkbox input[type="checkbox"] {
            display: none;
        }

        .checkbox-box {
            width: 14px;
            height: 14px;
            border: 1px solid grey;
            border-radius: 2px;
            display: inline-block;
            position: relative;
            transition: all 0.2s ease;
            margin-right: 8px;
        }

        .custom-checkbox input[type="checkbox"]:checked + .checkbox-box {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }

        .checkbox-box::after {
            content: "";
            position: absolute;
            top: 1px;
            left: 4px;
            width: 4px;
            height: 7px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .custom-checkbox input[type="checkbox"]:checked + .checkbox-box::after {
            opacity: 1;
        }

        .no-add-icon .add-btn:before{
            display: none;
        }
        .selected-item-description{
            font-size: 12px;
            margin-bottom: 0;
        }
        @media (min-width: 1400px) {
            .container, .container-sm, .container-md, .container-lg, .container-xl, .container-xxl {
                max-width: 800px;
            }
        }
        .filter-item.active {
            border-color: #33bfbf33;
            background: #3ab757;
        }
        .filter-item.active span {
            color: #fff;
        }

        .btn-theme-light {
            color: #000;
            padding: 6px 12px;
            border-radius: 0.5rem;
            border: 1px solid #856a4f;
        }

        .btn-close:hover {
            color: #fff;
        }

        .qty-controls.view-cart {
            line-height: 18px;
            margin-top: 0;
        }

        .loader-container {
            display: flex;
            flex-direction: column;
            gap: 30px;
            max-width: 1000px;
            margin: 20px auto;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 10px;
        }

        .loader-item {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 15px;
        }

        .loader-text {
            flex: 1;
        }

        .skeleton {
            background: #e0e0e0;
            border-radius: 6px;
            position: relative;
            overflow: hidden;
        }

        .skeleton::after {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            height: 100%;
            width: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            animation: shimmer 1.5s infinite;
        }

        @keyframes shimmer {
            100% {
                left: 100%;
            }
        }

        .skeleton.title {
            width: 150px;
            height: 20px;
            margin-bottom: 10px;
        }

        .skeleton.price {
            width: 80px;
            height: 15px;
            margin-bottom: 8px;
        }

        .skeleton.text {
            width: 200px;
            height: 12px;
        }

        .skeleton.image {
            width: 120px;
            height: 100px;
            border-radius: 10px;
        }

        .py-200{
            padding-top: 200px !important;
            padding-bottom: 200px !important;
        }

    </style>
    <div id="loading-wrapper">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</head>
<body>
    <div id="toasts" style="--default-text-color: #fff; z-index:1200"></div>
    <section>
        <div class="container px-0">
            <div class="row">
                <div class="col-12 text-center mt-3">
                    <img src="{{ asset('backend/'.$config[0]->logo.'')}}" class="mb-2 " style="height: 3.6rem;width: auto;" />
                    <h4 class="text-center mb-3" style="color:#972637">{{$config[0]->name}}</h4>
                </div>
                <div class="col-12 menu-view">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex flex-wrap flex-grow-1 bd-highlight">
                            <div class="filter-item mb-0 filtermenu" data-bs-toggle="modal" data-bs-target="#itemFilterModal">
                                <img src="{{ asset('frontend/assets/images/filter.png')}}" width="20px" />
                                <span>Filter</span><span class="ms-2"><i class="fa-solid fa-sort-down icon"></i></span>
                            </div>
                            <div class="filter-item veg-menu label_menu mb-2" id="labelIDType1" onclick="filterSort('Veg',1)">
                                <img src="{{ asset('frontend/assets/images/veg.png')}}" width="15px" />
                                <span id="label_text1">Veg</span>
                            </div>
                            <div class="filter-item nonveg-menu label_menu mb-2" id="labelIDType2" onclick="filterSort('Non-Veg',1)">
                                <img src="{{ asset('frontend/assets/images/nonveg.png')}}" width="15px" />
                                <span id="label_text2">Non Veg</span>
                            </div>
                            @foreach($labels as $label)
                            <div onclick="filterSort({{$label['id']}},0)" class="filter-item" id="label_hiddenID{{$label['id']}}" style="display: none;">
                                <img src="{{ asset('backend/uploads/Item/'.$label['image'])}}" width="15px" />
                                <span id="hidden_filter_label{{$label['id']}}">{{$label['name']}}</span>
                            </div>
                            @endforeach
                            <div id="mylabel" style="display:none;"></div>
                        </div>
                        {{-- Cart Icon --}}
                        <div class="bd-highlight cart-count-view d-none">
                            <div data-bs-toggle="modal" class="bd-highlight" onclick="showCart()">
                                <button class="btn position-relative me-3 m-1 cart_button" style="padding: 5px;">
                                    <i class="fa fa-shopping-bag" aria-hidden="true" style="color: #33bfbf;"></i><span class="text fs-18"></span>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill badge_color" id="added_items"> 0 </span>
                                </button>
                            </div>
                        </div>
                        <button id="toggleSearchBtn" class="btn btn-dark rounded-circle d-flex align-items-center justify-content-center" type="button" style="width: 30px; height: 30px; padding: 0;"><i id="searchIcon" class="ri-search-line" style="font-size: 1rem;"></i></button>
                        {{-- <div data-bs-toggle="modal" data-bs-target="#menuModal" class=" bd-highlight mb-2">
                            <button class="btn btn-menu fs-6" style="background-color:#33bfbf"><span class="me-2">
                            <i class="fa fa-cutlery" aria-hidden="true"></i></span>Menu</button>
                        </div> --}}
                    </div>
                    
                    <div id="searchBarDiv" class="input-group d-none align-items-center w-100 pb-3">
                        <input type="text" class="form-control" placeholder="Search..." aria-label="Search" onkeyup="itemNameFilter(this.value)">
                    </div>

                    <!----------Menu Model---------->
                    <div class="modal fade modal-right" id="menuModal" tabindex="-1" aria-labelledby="menuModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                <div class="modal-body">
                                    <div class="menu-description mb-3">
                                        <ul class="menu-menu-list"></ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--Filter Modal start -->
                    <div class="modal fade" id="itemFilterModal" tabindex="-1" aria-labelledby="itemFilterModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                <div class="modal-body">
                                    <div class="filter-title mb-3 pt-3">
                                        <h5>Filters and Sorting</h5>
                                    </div>
                                    <div class="filter-description">
                                        <h6 class="mb-3">Labels</h6>
                                        <div class="">
                                            <div class="d-flex flex-wrap filter-items-wrapper">
                                                @foreach($labels as $label)
                                                    <div onclick="filterSort({{$label['id']}},0)" class="filter-item" id="labelID{{$label['id']}}">
                                                        <img src="{{ asset('backend/uploads/Item/'.$label['image'])}}" width="15px" />
                                                        <span id="hidden_filter_label{{$label['id']}}">{{$label['name']}}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <div class="summary-counter d-flex align-items-center">
                                        <div class="btn-theme-light  text-center w-50 filter_clear_data" onclick="reset()" style="border-color:#33bfbf">
                                            <button class="btn m-0">Clear All</button>
                                        </div>
                                        <div class="add-item-btn btn-theme ms-3 w-50" style="background-color:#33bfbf" onclick="setLabel()">
                                            <button class="btn text-white m-0">Apply</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!--Filter Modal end -->
                    <div class="menu_item_list">
                        <div class="loader-container">
                            <?php for($i=0; $i <= 5; $i++){?>
                            <div class="loader-item">
                                <div class="loader-text">
                                    <div class="skeleton title"></div>
                                    <div class="skeleton price"></div>
                                    <div class="skeleton text"></div>
                                </div>
                                <div class="skeleton image"></div>
                            </div>
                            <?php }?>
                        </div>
                    </div>

                </div>

                <section class="px-4 d-flex justify-content-center align-items-center menu-error-view d-none" style="min-height: calc(100vh - 200px);">
                    <div class="alert alert-danger py-5 px-4 text-center w-100" role="alert" style="max-width: 500px;">
                        <h4 class="alert-heading">You are not Checked-in</h4>
                    </div>
                </section>
            </div>
        </div>
    </section>

    <div data-bs-toggle="modal" data-bs-target="#menuModal">
        <button class="btn btn-menu"><span class="d-block fs-6"><i class="ri-restaurant-line"></i></span> Menu</button>
    </div>

    <section>
        <div class="container-fluid gx-0">
            <div class="row">
                <div class="col-12 position-relative">
                    <div id="itemsummary" class="item-summary" style="display: none;">
                        <div class="d-flex justify-content-between">
                            <h6 class="mb-0 d-inline" style="margin-left: 20px;"><span class="summaryqty"></span> item added</h6>
                            <a data-bs-toggle="modal" onClick="showCart()" class=" bd-highlight cart_class" style="text-decoration: none; color:#fff">
                                <h6 class="mb-0 d-inline fs-6" style="margin-right: 20px;"><span id=""></span>VIEW CART<span> &nbsp;<i class="fa fa-shopping-bag"  aria-hidden="true"></i></span></h6>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--Summary Modal start -->
    <div class="modal fade" id="itemSummaryModal" tabindex="-1" aria-labelledby="itemSummaryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                <div class="modal-body">
                    <div class="summary-title text-start ms-2 mb-3">
                        <div class="d-flex">
                            <div>
                                <img src="" width="60" height="60" alt="cutlet" class="rounded me-2 selected-item-image"/>
                            </div>
                            <div>
                                <span class="selected-item-id d-none"></span>
                                <h5 class="mb-1"> <span class="me-1"><img src="assets/images/veg.png" width="15px" class="selected-item-type"/></span><span class="selected-item-name"></span></h5>
                                <p class="selected-item-description"></p>
                            </div>
                        </div>
                    </div>
                    <div class="selected-item-variation-detail mb-4"></div>
                    <div class="summary-counter d-flex align-items-center mb-0">
                        <div class="w-50">
                            <button class="btn btn-danger w-100" onclick="calc(0)">Remove Item</button>
                        </div>
                        <div class="add-item-btn ms-3 w-50">
                            <button class="btn btn-theme" onclick="calc()">Add Item</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Summary Modal end -->

    <!--View Cart Modal start -->
    <div class="modal fade" id="cartModel" tabindex="-1" aria-labelledby="cartModelLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                <div class="modal-body">
                    <div class="filter-title mb-3 pt-3">
                        <h5 class="mb-3 pb-2 border-bottom test-start">Your Cart Items</h5>
                        <div class="selected-items"></div>
                        <div class="mt-4 mb-2">
                            <label class="text-start d-block mb-1">Note</label>
                            <textarea class="form-control customer_order_note"></textarea>
                        </div>
                    </div>
                    <div class="summary-counter mb-0">
                        <div class="add-item-btn w-100 ">
                            <button class="btn btn-theme m-0 orderplace_btn" onClick="placeOrder()">Place Order</button>
                            <button class="btn btn-theme m-0 orderplace_wait" style="display: none;">Please Wait..</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--View Cart Modal end -->

    <!--Additional Item Modal start -->
    <div class="modal fade" id="additionalItemModal" tabindex="-1" aria-labelledby="additionalItemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
            <div class="modal-body">
            <div class="summary-title mb-3">
                <div class="d-flex align-items-center">
                <div>
                    <img src="assets/images/Veg-Cutlet.jpg" width="40" height="40" alt="cutlet" class="rounded me-2"/>
                </div>
                <div>
                    <h5 class="mb-1"> <span class="me-1"><img src="assets/images/veg.png" width="15px"/></span> Paneer Cutlet</h5>
                </div>
                </div>
            </div>
            <div class="summary-description mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Desserts & Bevarages</h6>
                        <p>Select upto 5</p>
                    </div>
                    <h6 class="text-danger fs-6">Clear All</h6>
                </div>
                <div class="d-flex justify-content-between align-items-center p-2 mb-3 rounded" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                    <div>
                        <h6 class="mb-1"> <span class="me-1"><img src="assets/images/veg.png" width="15px"/></span> Paneer Cutlet</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0 me-2 fs-6">+ ₹300</p>
                        <label class="custom-checkbox">
                            <input type="checkbox" />
                            <span class="checkbox-box"></span>
                        </label>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center p-2 mb-3 rounded" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                    <div>
                        <h6 class="mb-1"> <span class="me-1"><img src="assets/images/veg.png" width="15px"/></span> Paneer Cutlet</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0 me-2 fs-6">+ ₹300</p>
                        <label class="custom-checkbox">
                            <input type="checkbox" />
                            <span class="checkbox-box"></span>
                        </label>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center p-2 mb-3 rounded" style="box-shadow: rgba(99, 99, 99, 0.2) 0px 2px 8px 0px;">
                    <div>
                        <h6 class="mb-1"> <span class="me-1"><img src="assets/images/veg.png" width="15px"/></span> Paneer Cutlet</h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <p class="mb-0 me-2 fs-6">+ ₹300</p>
                        <label class="custom-checkbox">
                            <input type="checkbox" />
                            <span class="checkbox-box"></span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mb-0">
                    <h6 class="mb-0 me-2 fs-5">₹300</h6>
                    <div class="add-item-btn w-50">
                        <button class="btn btn-theme">Update Item</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    <!--Additional Item Modal end -->

    {{-- <footer class="main-footer mt-auto py-3 bg-white text-center fs-6 border-top">
        <div class="container px-0">
            <span class=""> Copyright © <span id="year"></span> <a href="javascript:void(0);" class="text-primary fw-semibold"></a><span class="fw-semibold" style="color:#33bfbf"> Techie Squad. </span>All rights reserved</span>
            <p class="mb-0 main-footer"><i class="fa fa-map-marker" aria-hidden="true"></i> Gola Road, Danapur, Patna</p>
        </div>
    </footer> --}}

    <script>
        const getMenuList = "{{ route('menu-item-list.getItemMenuList') }}";
        const itemVariationGet = "{{ route('menu-item-cart.getItemVariation') }}";
        const itemCartDetailGet = "{{ route('menu-item-cart-detail.getItemCartDetail') }}";
        const itemCartPlaceOrder = "{{ route('item-cart-place-order.placeOrder') }}";
    </script>
    <script src="{{asset('backend/assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{asset('frontend/assets/js/script.js')}}"></script>
    <script src="{{asset('frontend/assets/js/custom/item.js')}}"></script>
    <script src="{{asset('backend/assets/js/sweet-alert.js')}}"></script>
    <script>
        let VNmenuId = [];
        let labelMenuID = [];
        var primaryColor = "#33bfbf";
        //loadhomedata();

        function showItem(x) {
            if (VNmenuId.includes(x)) {
                let index = VNmenuId.indexOf(x);
                VNmenuId.splice(index, 1);
                $('#labelID' + x).css("background-color", "").css("border-color", "");
                $('#label_text' + x).css("color", "#1c1c1c");
                $('#labelID' + x + ' .close').remove();
            } else {
                VNmenuId.push(x);
                $('#labelID' + x).css("background-color", primaryColor).css("border-color", "white");
                $('#label_text' + x).css("color", "white");
                $('#labelID' + x).append("<span id='label_close' class='close'>&times;</span>");
            }
           // loadhomedata();
        }

        function showItemfilter(x) {
            filter(x)
           // loadhomedata();
        }

        function loadhomedata() {
            $.ajax({
                url: "https://hotel.techiesquad.in/filter",
                method: "POST",
                data: {
                    VNmenuId: VNmenuId,
                    labelMenuID: labelMenuID
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    $('.append_index_data').html(data.output);
                }
            });
        }

        function filter(x) {
            function addOrRemoveElement(element) {
                const index = labelMenuID.indexOf(element);
                if (index !== -1) {
                    labelMenuID.splice(index, 1);
                    $('#labelID' + x).css("background-color", "").css("border-color", "");
                    $('#hidden_filter_label' + x).css("color", "#1c1c1c");
                    $('#labelID' + x + ' .close').remove();
                    $('#hidden_label_name' + element).css("color", "#1c1c1c");
                    $('#label_hiddenID' + element + ' .close').remove();
                    $('#label_hiddenID' + element).hide();
                } else {
                    labelMenuID.push(element);
                    $('#labelID' + x).css("background-color", primaryColor).css("border-color", "white");
                    $('#hidden_filter_label' + x).css("color", "white");
                    $('#labelID' + x).append("<span id='label_close' class='close'>&times;</span>");
                    $('#label_hiddenID' + element).css("background-color", primaryColor).css("border-color", "white");
                    $('#hidden_label_name' + element).css("color", "white");
                    $('#label_hiddenID' + element).append("<span id='label_close' class='close'>&times;</span>");
                    $('#label_hiddenID' + element).show();
                }
            }
            addOrRemoveElement(x);
        }

        // function reset() {
        //     VNmenuId = [];
        //     labelMenuID = [];
        //     loadhomedata();
        //     $('#itemFilterModal').modal('hide');
        //     window.location.href = "https://hotel.techiesquad.in";
        // }

        function removetab(x, y, types) {
            filtermenu1 = y.slice(0, -4);
            $('#' + y).hide();
            $('#' + filtermenu1).css("background-color", "");
            if (types == 'toppicks') {

                if (filtermenutype.includes(x)) {
                    let index = filtermenutype.indexOf(x);
                    filtermenutype.splice(index, 1);
                } else {
                    filtermenutype.push(x);
                }
            } else {
                if (filtermenuID.includes(x)) {
                    let index = filtermenuID.indexOf(x);
                    filtermenuID.splice(index, 1);
                } else {
                    filtermenuID.push(x);
                }
            }
            loadhomedata();
        }

        function addItemToCart(item_id, price) {
            let qnty = 1;

            $.ajax({
                url: "https://hotel.techiesquad.in/cart",
                method: 'post',
                data: {
                    _token: '84dpz6MJqMuBStI5Vqv9fCn95OLvnuITXqXKintv',
                    id: item_id,
                    quantity: qnty,
                    offer_price: price
                },
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                        return;
                    }
                    $(`div.qty-controls[data-item-id='${item_id}']`).show();
                    updateCart(response.cart);
                }
            });
        }

        function adjustQuantity(item_id, price, adjustment) {
            let qnty = $(`div.qty-controls[data-item-id='${item_id}'] .qty`).text();
            qnty = parseInt(qnty, 10) + adjustment;
            if (qnty < 1) {
                qnty = 1;
            }
            $.ajax({
                url: "https://hotel.techiesquad.in/cart",
                method: 'post',
                data: {
                    _token: '84dpz6MJqMuBStI5Vqv9fCn95OLvnuITXqXKintv',
                    id: item_id,
                    quantity: adjustment,
                    offer_price: price
                },
                success: function(response) {
                    if (response.error) {
                        alert(response.error);
                        return;
                    }
                    $(`div.qty-controls[data-item-id='${item_id}'] .qty`).text(qnty);
                    updateCart(response.cart);
                }
            });
        }

        function updateCart(cart) {
            let cartItemsHtml = '';
            let totalQuantity = 0;
            cart.forEach(item => {
                cartItemsHtml += `<li>`
                if (item.f_category == 1) {
                    cartItemsHtml += `<img src="frontend/assets/images/veg.png" alt="veg" width="20"height="20"/>`
                } else {
                    cartItemsHtml +=
                        `<img src="frontend/assets/images/nonveg.png" alt="veg" width="20"height="20"/>`
                }
                cartItemsHtml += `<strong>${item.name} -</strong>
                    Qty: ${item.quantity}
                  <span><i class="fa fa-inr light-inr" aria-hidden="true"></i> ${item.price}</span>
                    <span>
                         <div class="qty-controls" style="margin-top: -7px;margin-bottom: -7px;">
                            <span class="decrement" onclick="adjustQuantity(${item.id},${item.price},-1)">-</span>
                            <span class="qty" style="margin-top: 6px;!important">${item.quantity}</span>
                            <span class="increment" onclick="adjustQuantity(${item.id},${item.price},1)">+</span>
                        </div>
                   </span>
                 </li>`;
                totalQuantity += item.quantity;
            });

            $('#cartModel .summary-title').html(cartItemsHtml);
            $('#added_items').html(totalQuantity);
            $('#summaryqty').text(totalQuantity);
            if (totalQuantity == 0) {
                $('.nocart_txt').text("Cart is empity!");
                $('#cartModel').modal('hide');
                $('#itemsummary').hide();
                $('.qty-controls').hide();
                $('.add-btn').show();
            }
        }

        function removeCartItems(cart_id) {
            $.ajax({
                url: "https://hotel.techiesquad.in/cartItemClear",
                method: "POST",
                data: {
                    id: cart_id
                },
                success: function(data) {
                    if (data.success) {
                        updateCart(data.cart);
                        toastMsg('success', data.success);
                    } else if (data.error_success) {
                        toastMsg('warning', data.error_success);
                    } else {
                        toastMsg('error', 'something went wrong');
                    }
                }
            });
        }

        function clearcart() {
            $.ajax({
                url: "https://hotel.techiesquad.in/cartClear",
                method: "POST",
                success: function(data) {
                    if (data.success) {
                        toastMsg('success', data.success);
                        $('.clrcart').hide();
                        $('.clrcart_wait').show();
                        setTimeout(function() {
                            window.location.href = "https://hotel.techiesquad.in";
                        }, 2000);
                    } else if (data.error_success) {
                        toastMsg('warning', data.error_success);
                    } else {
                        toastMsg('error', 'something went wrong');
                    }
                }
            });
        }

        function longDescription(x) {
            $('#strlimit' + x).toggle();
            $('#dots' + x).toggle();
            $('#more' + x).toggle();
            $('#myBtn' + x).toggle();
            $('#myBtn2' + x).toggle();
        }

        function modelClose() {
            $('#itemFilterModal').modal('hide');
        }
    </script>
    <script>
        setTimeout(function() {
            $(document).ready(function() {
                $("#loading-wrapper").fadeOut(500);
            });
        }, 100);
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
    <script>
        $(document).ready(function() {
            $(document).on('click', '.add-btn', function() {
                var quantityWrapper = $(this).siblings('.qty-controls');
                // var qty = quantityWrapper.find('.qty');
                // let itemSummary = $('#itemsummary');
                // qty.text('1');
                $(this).hide();
                quantityWrapper.show();
                // itemSummary.show();
            });

            $(document).on('click', '.increment', function() {
                let itemSummary = $('#itemsummary');
                let qtyElement = $(this).siblings('.qty');
                let currentQty = parseInt(qtyElement.text());
                let n = currentQty + 1;
                qtyElement.text(n);
                itemSummary.show();
            });

            $(document).on('click', '.decrement', function() {
                let qtyElement = $(this).siblings('.qty');
                let itemSummary = $('#itemsummary');
                let currentQty = parseInt(qtyElement.text());
                let n = currentQty - 1;
                qtyElement.text(n);
                itemSummary.show();
                if (n < 1) {
                    qtyElement.text('0');
                    let p = $(this).parent();
                    p.hide();
                    let b = p.siblings('.add-btn');
                    b.show();
                    itemSummary.hide();
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const decrementBtn = document.getElementById('decrementBtn');
            const incrementBtn = document.getElementById('incrementBtn');
            const counterValue = document.getElementById('counterValue');
            let count = 1;

            function incrementCounter() {
                count++;
                counterValue.value = count;
                $('.qty_count').html(count);
            }

            function decrementCounter() {
                if (count > 1) {
                    count--;
                    counterValue.value = count;
                    $('.qty_count').html(count);;
                }
            }
            incrementBtn.addEventListener('click', incrementCounter);
            decrementBtn.addEventListener('click', decrementCounter);
        });
        $(document).ready(function() {
            $(".expander").on("click", function() {
                let $this = $(this);
                $this.next().slideToggle();
                $this.children().slideToggle();
            })
        });

          function getimage(src, id, name, price,desc) {
            // let output1 = `<div class="filter-title mb-3 pt-3 d-flex justify-content-between">
            //     <div>
            //         <span class="img_detail_font" style="font-size: 15px; font-weight: initial; text-align: left;">${name}- ₹ ${price}<br>Description: ${desc}</span>
            //     </div>
            //     <div class="text-center quantity-selector" style="margin-top: -82px; margin-left: 70%;">
            //         <button class="add-btn">Add</button>
            //         <div class="qty-controls" style="display:none;" data-item-id="${id}">
            //             <span class="decrement" onclick="adjustQuantity(${id}, ${price}, -1)">-</span>
            //             <span class="qty">1</span>
            //             <span class="increment" onclick="adjustQuantity(${id}, ${price}, 1)">+</span>
            //         </div>
            //     </div>
            // </div>`;
            let output1 =`
                        <div class="d-flex justify-content-between align-items-center position-relative mt-3">
                        <div class="item-detail me-4">
                            <div class="mb-2 d-flex">
                                <img src="assets/images/veg.png" alt="veg" width="20" height="20"/>
                                <p class="mb-0"><span class="badge rounded bg-white text-dark border ms-2"><span class="me-2"><img src="assets/images/best-seller.png" width="10px"/> Best Seller</span></span></p>
                            </div>
                            <h4>${name}</h4>
                            <h5><span class="price text-decoration-line-through me-1 text-muted">₹280</span><span class="price">₹ ${price}</span></h5>
                        </div>
                        <div class="text-center no-add-icon">
                            <button class="add-btn">Add</button>
                            <div class="qty-controls" style="display:none;">
                            <span class="decrement" >-</span>
                            <span class="qty">1</span>
                            <span class="increment">+</span>
                            </div>
                        </div>
                        </div>
                        <p class="mb-3">${desc}</p>
                    `;
            $('.viewImage').html('<img src="' + src + '" style="width: 100%; border-radius: 15px 15px 0px 0px;">');
            $('.viewImage-details').html(output1);
        }

        function getmodelimage(id, image, name, price) {
            $('.viewmodelImage').html('<img src="uploads/items/' + image + '" height="60" width="70">');
            $('.item_id').empty();
            $('.item_id').append(id);
            $('.item_name').empty();
            $('.item_name').append(name);
            $('.order_price').empty();
            $('.order_price').append(price);
        }
    </script>

</body>

</html>
