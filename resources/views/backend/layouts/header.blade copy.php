<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('backend/'.$hotlr[0]->logo.'')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('backend/'.$hotlr[0]->logo.'')}}" type="image/x-icon">
    <title>
      @yield('title')
    </title>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200;300;400;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Secular+One&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/font-awesome.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/icofont.css')}}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/themify.css')}}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/flag-icon.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/feather-icon.css')}}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/slick-theme.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/scrollbar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/datatable/select.dataTables.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/date-picker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/prism.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/jsgrid.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/flatpickr/flatpickr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/owlcarousel.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/slick.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/slick-theme.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/dropzone.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" integrity="sha512-XcIsjKMcuVe0Ucj/xgIXQnytNwBttJbNjltBV18IOnru2lDPe9KRRyvCXw6Y5H415vbBLRm8+q6fmLUU7DfO6Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/sweetalert2.css')}}">
     <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/calendar.css')}}">
    <!-- Plugins css Ends-->
      <!-- Plugins css Ends-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/scrollable.css')}}">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vendors/bootstrap.css')}}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/custom.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/vertical.css')}}">
     <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/dashboard.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/custom-dark.css')}}">
        {{-- custom_backend css for backend work --}}
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/custom_backend.css')}}">
    <link id="color" rel="stylesheet" href="{{asset('backend/assets/css/color-1.css')}}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/plugins/bs-select.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/plugins/bootstrap-select.min.css')}}">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/plugins/daterangepicker.css')}}">
    {{-- ----datatable css added for data loaders--- --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
     {{-- For Datatable Data responsivnes --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">
    @yield('extra-css')
  </head>
  <body id="fullscreen-table">
    <!-- loader starts  -->
    <!-- Loading starts -->
    <div id="loading-wrapper">
      <div class="spinner-border" role="status">
          <span class="sr-only">Loading...</span>
      </div>
  </div>
  <!-- Loading ends -->
    @include('backend.modules.alert.toast')
    <!-- tap on top starts-->
    <div class="tap-top"><i class="ri-arrow-up-double-line"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-sidebar compact-small material-icon" id="pageWrapper">
      <!-- Page Header Start-->
      <div class="page-header">
        <div class="header-wrapper row m-0">
          <div class="header-logo-wrapper col-auto p-0">
            <div class="logo-wrapper">
              <a href="/dashboard">
                {{-- <img class="img-fluid" src="https://hydx.techiesquad.in/backend/assets/images/logo/svg/admin-logo.png" alt="logo" style="width: 15px;"> --}}
                <img class="img-fluid" src="{{ asset('backend/'.$hotlr[0]->logo.'')}}" alt="logo" style="width: 15px;">
              </a>
            </div>
            <div class="toggle-sidebar"><i class="ri-menu-2-line"></i>
              <div class="status_toggle middle sidebar-toggle">
                <div class="header-left">
                  <form class="search-form mb-0">
                    <div class="input-group"><span class="input-group-text pe-0">
                        <svg class="search-bg svg-color"></svg></span>
                      <input class="form-control" type="search" placeholder="Search anything..." >
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          {{-- <form class="form-inline search-full" action="#" method="get">
            <div class="form-group w-100">
              <div class="Typeahead Typeahead--twitterUsers">
                <div class="u-posRelative">
                  <input class="demo-input Typeahead-input form-control-plaintext w-100" type="text" placeholder="Search ..." name="q" title="">
                  <svg class="search-bg svg-color">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#search')}}"></use>
                  </svg>
                </div>
                <div class="Typeahead-menu"></div>
              </div>
            </div>
          </form> --}}
          <div class="nav-right col-auto pull-right right-header p-0 ms-auto">
            <ul class="nav-menus">
              {{-- <li class="clear-cache-btn">
                <i class="ri-refresh-line clearCacheBtn text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Clear Cache"></i>
              </li> --}}
              <li>
                <div class="mode">
                  <svg>
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#moon')}}"></use>
                  </svg>
                </div>
              </li>
              <li class="profile-nav onhover-dropdown pe-0 py-0">
                <div class="d-flex profile-media"><img src="{{asset('backend/assets/images/profile.png')}}" alt="">
                  <div class="flex-grow-1"><span>{{ Auth::user()->name }}</span>
                    <p class="mb-0 font-roboto">{{ Auth::user()->designation }} <i class="middle fa fa-angle-down"></i></p>
                  </div>
                </div>
                <ul class="profile-dropdown onhover-show-div">
                  {{-- <li><a href="{{route('profile.index')}}"><i class="ri-user-line mx-2"></i><span>Profile</span></a></li> --}}
                  <li><a href="{{route('setting.index')}}"><i class="ri-settings-2-line mx-2"></i><span>Setting</span></a></li>
                  <li><a href="{{route('logout')}}"><i class="ri-logout-circle-r-line mx-2"></i><span>Log Out</span></a></li>
                </ul>
              </li>
            </ul>
          </div>
          <script class="result-template" type="text/x-handlebars-template">
            <div class="ProfileCard u-cf">                        
              <div class="ProfileCard-avatar">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
              </div>
              <div class="ProfileCard-details">
                <div class="ProfileCard-realName">{{ Auth::user()->name }}</div>
              </div>
            </div>
          </script>
          <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
        </div>
      </div>
      <div class="page-sub-header" data-layout="stroke-svg"> 
        <div class="body-header">
          <ul class="sidebar-body-menu">
            <li>
              <div> 
                <h3>Masters</h3><span>Room, Settings</span>
              </div>
              @php
              // Fetch the specific user's permissions
              $per = explode(",", Auth::user()->permission); // Split the permissions into an array
              @endphp
              <ul class="sidebar-body-mainmenu custom-scrollbar"> 
                {{-- @if(in_array('manage_rooms',$per)) --}}
                <li> <a href="#"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-home')}}"></use>
                    </svg>Rooms </a><span class="sub-body-arrow"><i class="fa fa-angle-right"></i></span>
                    <ul class="sidebar-body-submenu custom-scrollbar"> 
                    <li><a href="{{route('room.roomNumber')}}">Room Number</a></li>
                    <li><a href="{{route('tariff.index')}}">Room Tariff</a></li>
                    <li><a href="{{route('roomtype.index')}}">Room Specification</a></li>
                    <li class="d-none"><a href="{{route('room.roomCategory')}}">Room Category</a></li>
                    <li class="d-none"><a href="{{route('room.roomTypeName')}}">Room Type Name</a></li>
                    <li class="d-none"><a href="/room-view">Room View</a></li>
                    <li class="d-none"><a href="/bedtype">Bed Type</a></li>
                    <li class="d-none"><a href="/room-facilities">Room Amenities & Facilities</a></li>
                    {{-- <li><a href="/availability">Availability</a></li> --}}
                    {{-- <li><a href="{{route('reservation.reservation2')}}">Rsvn_New</a></li> --}}
                  </ul>
                </li>
                {{-- @endif
                @if(in_array('manage_users',$per))
                  <li> <a href="{{route('permission.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-home')}}"></use>
                    </svg>Manage Users</a>
                  </li>
                @endif --}}
                <li> <a href="#"> 
                  <svg class="stroke-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                  </svg>
                  <svg class="fill-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-home')}}"></use>
                  </svg>Restaurant </a><span class="sub-body-arrow"><i class="fa fa-angle-right"></i></span>
                  <ul class="sidebar-body-submenu custom-scrollbar"> 
                    <li><a href="{{route('restaurant-table.index')}}">Table</a></li>
                    <li><a href="{{route('restaurant-item.index')}}">Menu</a></li>
                    <li><a href="{{route('restaurant-raw-material.index')}}">Raw Item</a></li>
                    <li><a href="{{route('restaurant-item-attribute.index')}}">Item Attribute</a></li>
                    <li><a href="{{route('restaurant-item-category.index')}}">Item Category</a></li>
                    <li class="d-none"><a href="{{route('restaurant-item-label.index')}}">Item Label</a></li>
                    </ul>
                </li>
                <li> 
                  <a href="#"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-form')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-form')}}"></use>
                    </svg>General Settings
                  </a><span class="sub-body-arrow"><i class="fa fa-angle-right"></i></span>
                  <ul class="sidebar-body-submenu custom-scrollbar"> 
                    <li><a href="{{route('taxslab.index')}}">Tax Slabs</a></li>
                    <li><a href="{{route('tax-category.index')}}">Tax Category</a></li>
                    <li><a href="{{route('general-setting.index')}}">Invoice</a></li>
                    <li><a href="{{route('payment-method.index')}}">Payment Method</a></li>
                    <li><a href="{{route('company.index')}}">Company</a></li>
                    <li><a href="{{route('waiter.index')}}">Waiter</a></li>
                    <li><a href="{{route('vendor.index')}}">Vendor</a></li>
                    <li class="d-none"><a href="{{route('department.index')}}">Department</a></li>
                    <li><a href="{{route('reason-closer.index')}}">Reason For Closer</a></li>
                    <li><a href="{{route('audit-setting.index')}}">Audit</a></li>
                    <li><a href="{{route('event.index')}}">Banquet Event</a></li>
                    <li><a href="{{route('feature.index')}}">Banquet Feature</a></li>
                    <li><a href="{{route('accessories.index')}}">Banquet Accesories</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li>
              <div> 
                <h3>Reservation</h3><span>Reserve Room</span>
              </div>
              <ul class="sidebar-body-mainmenu custom-scrollbar"> 
                <li> <a href="{{route('reservation.reservationLayout')}}"> 
                  <svg class="stroke-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                  </svg>
                  <svg class="fill-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                  </svg>Reservation</a>
                </li>
                {{-- <li> <a href="{{route('reservation.occupancyChart')}}"> 
                  <svg class="stroke-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                  </svg>
                  <svg class="fill-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                  </svg>Occupancy Chart</a>
                </li> 
                <li> <a href="{{route('reservation.reservationHistory')}}"> 
                  <svg class="stroke-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                  </svg>
                  <svg class="fill-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                  </svg>Reservation Details</a>
                </li>
                <li> <a href="{{route('reservation.reservationRoomHistory')}}"> 
                  <svg class="stroke-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                  </svg>
                  <svg class="fill-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                  </svg>Resvn Room Details</a>
                </li>--}}
              </ul>
            </li>
            <li>
              <div> 
                <h3>KOT</h3><span>Restaurant Order</span>
              </div>
              <ul class="sidebar-body-mainmenu custom-scrollbar"> 
                <li> 
                  <a href="{{route('generate-kot.index',0)}}"> 
                  <svg class="stroke-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                  </svg>
                  <svg class="fill-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                  </svg>Generate KOT</a>
                </li>
                <li> 
                  <a href="{{route('view-kot.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>View KOT</a>
                </li>
                <li> 
                  <a href="/index/0"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>QR MENU</a>
                </li>
                <li> 
                  <a href="{{route('qr-menu-orders.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>QR MENU Orders</a>
                </li>
                <li> 
                  <a href="{{route('restaurant-breakfast-chart.index')}}" target="_blank"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Breakfast Chart</a>
                </li>
              </ul>
            </li>
            {{-- <li>
              <div> 
                <h3>Finance</h3><span>Invoice Details</span>
              </div>
              <ul class="sidebar-body-mainmenu custom-scrollbar"> 
                <li> <a href=""> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Invoice</a>
                  </li>
              </ul>
            </li> --}}
            <li>
              <div> 
                <h3>Report</h3><span>Report View</span>
              </div>
              <ul class="sidebar-body-mainmenu custom-scrollbar"> 
                <li> 
                  <a href="{{route('roomReport.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Rooms Report</a>
                </li>
                <li> 
                  <a href="{{route('guestHistory.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Guest History</a>
                </li>
                <li> 
                  <a href="{{route('reservationReport.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Reservation report</a>
                </li>
                <li> 
                  <a href="{{route('kotReport.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>KOT Report</a>
                </li>
                <li> 
                  <a href="{{route('hallUtilization.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Hall Utilization</a>
                </li>
                <li> 
                  <a href="{{route('hallRevenue.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Hall Revenue</a>
                </li>
                <li> 
                  <a href="{{route('comprehensiveBooking.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Comprehensive Hall Booking</a>
                </li>
                <li> 
                  <a href="{{route('comprehensiveCorporate.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Comprehensive Corporate</a>
                </li>
                <li> 
                  <a href="{{route('eventType.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Event Type Analysis</a>
                </li>
                <li> 
                  <a href="{{route('monthlyRevenue.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Monthly Revenue Breakdown</a>
                </li>
                <li> 
                  <a href="{{route('outstandingPayments.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Outstanding Payments</a>
                </li>
              </ul>
            </li>
            <li class="d-none1">
              <div> 
                <a href="{{route('auditReport.index')}}"><h3>Night Audit</h3><span>Dashboard</span></a>
              </div>
            </li>
            <li class="d-none1">
              <div> 
                <h3>Store</h3><span>Purchase,Stock</span>
              </div>
              <ul class="sidebar-body-mainmenu custom-scrollbar">               
                <li> <a href="{{route('store.purchaseOrder')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Purchase Order</a>
                </li>
                <li> <a href="{{route('store.purchaseList')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Purchase List</a>
                </li>
                {{-- <li> <a href="{{route('store.stockOrder')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Stock Order</a>
                </li> --}}
                <li> <a href="{{route('store.stockRequest')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Item Requests</a>
                </li>
                <li> <a href="{{route('store.stockCurrent')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Current Stock</a>
                </li>
                <li> <a href="{{route('store.transferReport')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Transfer Report</a>
                </li>
                <li> <a href="{{route('store.deficiencyReport')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Deficiency Report</a>
                </li>
              </ul>
            </li>
            <li class="d-none1">
              <div> 
                <h3>Kitchen</h3><span>Stock</span>
              </div>
              <ul class="sidebar-body-mainmenu custom-scrollbar">               
                <li> <a href="{{route('kitchen.dashboard')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Dashboard</a>
                </li>
                <li> <a href="{{route('kitchen.kot-monitor')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Kot Monitor</a>
                </li>
                <li> <a href="{{route('kitchen.inStock')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>In Stock</a>
                </li>
                <li> <a href="{{route('kitchen.consumtionReport')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Consumtion Report</a>
                </li>
                <li> <a href="{{route('kitchen.transferRequest')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Transfer Request</a>
                </li>
                <li> <a href="{{route('kitchen.pendingRequest')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Pending Request</a>
                </li>
                <li> <a href="{{route('kitchen.returnRequestList')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Return Request List</a>
                </li>
              </ul>
            </li>
            <li class="d-none1">
              <div> 
                <h3>Banquet</h3><span>Dashboard</span>
              </div>
              <ul class="sidebar-body-mainmenu custom-scrollbar"> 
                <li> <a href="{{route('dashboard.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Dashboard </a>
                </li>
                <li> <a href="{{route('booking.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Booking</a>
                </li>
                <li> <a href="{{route('hall.index')}}"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Hall</a>
                </li>
                {{-- <li> <a href="/banquet/client"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Client</a>
                </li>
                <li> <a href="/banquet/reports"> 
                    <svg class="stroke-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-file')}}"></use>
                    </svg>
                    <svg class="fill-icon">
                      <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-file')}}"></use>
                    </svg>Reports</a>
                </li> --}}
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <!-- Page Header Ends -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <div class="sidebar-wrapper" data-layout="stroke-svg">
          <div>
            <div class="logo-wrapper"><a href=""><img class="img-fluid for-light" src="{{asset('backend/assets/images/logo/logo.png')}}" alt=""><img class="img-fluid for-dark" src="{{asset('backend/assets/images/logo/logo_dark.png')}}" alt=""></a>
              <div class="back-btn"><i class="fa fa-angle-left"></i></div>
              <div class="toggle-sidebar"><span class="status_toggle middle sidebar-toggle"><i class="ri-menu-2-line"></i></div>
            </div>
            <nav class="sidebar-main">
              <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
              <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                  <li class="back-btn"><a href=""><img class="img-fluid" src="{{asset('backend/assets/images/logo/logo-icon.png')}}" alt=""></a>
                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                  </li>
                  <li class="pin-title sidebar-main-title">
                    <div> 
                      <h6>Pinned</h6>
                    </div>
                  </li>
                  <li class="sidebar-main-title">
                    <div>
                      <h6>General</h6>
                    </div>
                  </li>
                  <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
                    <label class="badge badge-light-primary">5</label><a class="sidebar-link sidebar-title" href="#">
                      <svg class="stroke-icon">
                        <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-home')}}"></use>
                      </svg>
                      <svg class="fill-icon">
                        <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-home')}}"></use>
                      </svg><span>Dashboard </span></a>
                    <ul class="sidebar-submenu">
                      <li><a href="/dashboard">Home</a></li>
                    </ul>
                  </li>
                  <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                      <svg class="stroke-icon">
                        <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-widget')}}"></use>
                      </svg>
                      <svg class="fill-icon">
                        <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-widget')}}"></use>
                      </svg><span>Restaurant</span></a>
                    <ul class="sidebar-submenu">
                      <li><a href="{{route('restaurant-table.index')}}">Table</a></li>
                      <li><a href="{{route('restaurant-item.index')}}">Menu</a></li>
                      <li><a href="{{route('restaurant-raw-material.index')}}">Raw Item</a></li>
                      <li><a href="{{route('restaurant-item-attribute.index')}}">Item Attribute</a></li>
                      <li><a href="{{route('restaurant-item-category.index')}}">Item Category</a></li>
                      <li class="d-none"><a href="{{route('restaurant-item-label.index')}}">Item Label</a></li>
                  </ul>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                  <svg class="stroke-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-layout')}}"></use>
                  </svg>
                  <svg class="fill-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-layout')}}"></use>
                  </svg><span>General Settings</span></a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{route('taxslab.index')}}">Tax Slabs</a></li>
                    <li><a href="{{route('tax-category.index')}}">Tax Category</a></li>
                    <li><a href="{{route('general-setting.index')}}">Invoice</a></li>
                    <li><a href="{{route('payment-method.index')}}">Payment Method</a></li>
                    <li><a href="{{route('company.index')}}">Company</a></li>
                    <li><a href="{{route('waiter.index')}}">Waiter</a></li>
                    <li><a href="{{route('vendor.index')}}">Vendor</a></li>
                    <li><a href="{{route('department.index')}}">Department</a></li>
                    <li><a href="{{route('reason-closer.index')}}">Reason For Closer</a></li>
                    <li><a href="{{route('audit-setting.index')}}">Audit</a></li>
                    <li><a href="{{route('event.index')}}">Event</a></li>
                    <li><a href="{{route('feature.index')}}">Feature</a></li>
                    <li><a href="{{route('accessories.index')}}">Accesories</a></li>
                  </ul>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                  <svg class="stroke-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-layout')}}"></use>
                  </svg>
                  <svg class="fill-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-layout')}}"></use>
                  </svg><span>Reservation</span></a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{route('reservation.reservationLayout')}}">Reservation</a></li>
                  </ul>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                  <svg class="stroke-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-layout')}}"></use>
                  </svg>
                  <svg class="fill-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-layout')}}"></use>
                  </svg><span>KOT</span></a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{route('generate-kot.index',0)}}">Generate KOT</a></li>
                    <li><a href="{{route('view-kot.index')}}">View KOT</a></li>
                    <li><a href="/index/0">QR MENU</a></li>
                    <li><a href="{{route('qr-menu-orders.index')}}">QR MENU Orders</a></li>
                    <li><a href="{{route('restaurant-breakfast-chart.index')}}">Breakfast Chart</a></li>
                  </ul>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                  <svg class="stroke-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-layout')}}"></use>
                  </svg>
                  <svg class="fill-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-layout')}}"></use>
                  </svg><span>Report</span></a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{route('roomReport.index')}}">Rooms Report</a></li>
                    <li><a href="{{route('guestHistory.index')}}">Guest History</a></li>
                    <li><a href="{{route('reservationReport.index')}}">Reservation Report</a></li>
                    <li><a href="{{route('kotReport.index')}}">KOT Report</a></li>
                    <li><a href="{{route('hallUtilization.index')}}">Hall Utilization</a></li>
                    <li><a href="{{route('hallRevenue.index')}}">Hall Revenue</a></li>
                    <li><a href="{{route('comprehensiveBooking.index')}}">Comprehensive Hall Booking</a></li>
                    <li><a href="{{route('eventType.index')}}">Event Type Analysis</a></li>
                    <li><a href="{{route('monthlyRevenue.index')}}">Monthly Revenue Breakdown</a></li>
                    <li><a href="{{route('outstandingPayments.index')}}">Outstanding Payments</a></li>
                  </ul>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="{{route('auditReport.index')}}">
                  <svg class="stroke-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-layout')}}"></use>
                  </svg>
                  <svg class="fill-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-layout')}}"></use>
                  </svg><span>Night Audit</span></a>
                  {{-- <ul class="sidebar-submenu">
                    <li><a href="{{route('roomReport.index')}}">Rooms Report</a></li>
                    <li><a href="{{route('guestHistory.index')}}">Guest History</a></li>
                    <li><a href="{{route('reservationReport.index')}}">Reservation Report</a></li>
                    <li><a href="{{route('kotReport.index')}}">KOT Report</a></li>
                    <li><a href="{{route('hallUtilization.index')}}">Hall Utilization</a></li>
                  </ul> --}}
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                  <svg class="stroke-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-layout')}}"></use>
                  </svg>
                  <svg class="fill-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-layout')}}"></use>
                  </svg><span>Store</span></a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{route('store.purchaseOrder')}}">Purchase Order</a></li>
                    <li><a href="{{route('store.purchaseList')}}">Purchase List</a></li>
                    <li><a href="{{route('store.stockRequest')}}">Item Requests</a></li>
                    <li><a href="{{route('store.stockCurrent')}}">Current Stock</a></li>
                    <li><a href="{{route('store.transferReport')}}">Transfer Report</a></li>
                    <li><a href="{{route('store.deficiencyReport')}}">Deficiency Report</a></li>
                  </ul>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                  <svg class="stroke-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-layout')}}"></use>
                  </svg>
                  <svg class="fill-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-layout')}}"></use>
                  </svg><span>Kitchen</span></a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{route('kitchen.dashboard')}}">Dashboard</a></li>
                    <li><a href="{{route('kitchen.kot-monitor')}}">Kot Monitor</a></li>
                    <li><a href="{{route('kitchen.inStock')}}">In Stock</a></li>
                    <li><a href="{{route('kitchen.consumtionReport')}}">Consumtion Report</a></li>
                    <li><a href="{{route('kitchen.transferRequest')}}">Transfer Request</a></li>
                    <li><a href="{{route('kitchen.pendingRequest')}}">Pending Request</a></li>
                    <li><a href="{{route('kitchen.returnRequestList')}}">Return Request List</a></li>
                  </ul>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                  <svg class="stroke-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#stroke-layout')}}"></use>
                  </svg>
                  <svg class="fill-icon">
                    <use href="{{asset('backend/assets/svg/icon-sprite.svg#fill-layout')}}"></use>
                  </svg><span>Banquet</span></a>
                  <ul class="sidebar-submenu">
                    <li><a href="{{route('dashboard.index')}}">Dashboard</a></li>
                    <li><a href="{{route('booking.index')}}">Booking</a></li>
                    <li><a href="{{route('hall.index')}}">Hall</a></li>
                  </ul>
                </li>
                </ul>
              </div>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </nav>
          </div>
        </div>
        <!-- Page Sidebar Ends-->