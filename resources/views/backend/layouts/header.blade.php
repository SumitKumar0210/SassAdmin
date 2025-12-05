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
    
    @php
    $permission_allow = explode(',',auth()->user()->permission);
    // dd($permission_allow);
    @endphp
    <!-- tap on top starts-->
    <div class="tap-top"><i class="ri-arrow-up-double-line"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-sidebar compact-small material-icon" id="pageWrapper">
      <div class="d-flex">
        <div class="vertical-layout-sidebar d-none d-md-block">
          <div class="logo-container overflow-hidden">
            <img src="{{ asset('backend/'.$hotlr[0]->logo.'')}}"  alt="logo" style="width: auto; height:50px;"/>
          </div>
          @php
          $path = $_SERVER["REQUEST_URI"];
          @endphp
          <div class="sidebar-menu border-end">
            <ul>
              <div class="first-item">
              <li @if($path == '/dashboard') class="active active-page-link" @endif >
                <a href="/dashboard" class=""> 
                  <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 400 400">
                    <path d="M392,151.72v178.15c-4.13,22.22-16.14,41.54-35.99,52.79-8.34,4.73-16.92,7.31-26.26,9.34H70.25c-22.26-4.12-41.63-16.11-52.89-35.92-4.74-8.33-7.32-16.89-9.36-26.21v-178.15c3.55-19.44,12.63-35.64,28.25-47.78,39.36-30.6,86.92-55.73,127.25-85.59,23.63-13.3,49.94-13.15,73.48.27,43.18,24.62,84.35,59.75,127.21,85.63,13.74,10.43,25.96,30.17,27.81,47.47ZM192.72,34.17c-7.97.9-15.85,4.65-22.58,8.75-30.84,18.77-63.19,42.13-93.2,62.72-20.07,13.77-41.52,24.82-43.69,52.4v161.47c2.65,24.67,22.68,44.7,47.42,47.25l237.99.04c24.6-2.16,44.61-21.64,47.98-45.98l.11-162.07c-1.46-14.68-8.35-27.3-19.64-36.58-39.48-24.79-77.45-55.32-117.25-79.25-12.06-7.25-22.79-10.37-37.15-8.75Z"/>
                    <path d="M156.32,168.38c27.49,1.64,59.02-2.86,86.05-.19,12.58,1.25,21,11.43,22.12,23.58,2.37,25.7-1.77,54.8.04,80.86-.67,11.73-8.99,21.59-20.65,23.56-28.01-1.93-59.43,2.55-87.04.03-11.53-1.05-20.51-11.62-21.33-22.87,1.75-26.28-2.39-55.66,0-81.57,1.11-12.07,8.75-21.16,20.81-23.4ZM160.62,185.6c-4.1,1.16-5.76,3.92-6.22,8.01,1.5,23.71-2,49.85-.02,73.27.43,5.12,2.01,8.39,7.47,8.9,24.4,2.25,52.23-1.77,77-.02,4.97-.7,6.39-4.33,6.78-8.88,2.04-23.86-1.31-50.94-.34-75.09-.7-3.13-2.34-4.97-5.36-6.03l-79.3-.17Z"/>
                  </svg>
                  <span class="menu-text"> Dashboard</span>
                </a>
              </li>
              @if(in_array('Reservation View', $permission_allow))
              <li @if($path == '/reservation-new') class="active active-page-link" @endif> 
                <a href="{{route('reservation.reservationLayout')}}" class="">
                  
                  <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 400 400">
                    <path d="M368.06,57.86c-20.99-18.5-45.02-19.47-71.87-18.36V12.88c0-.48-3.56-4.32-4.49-4.88h-6.74c-1.86,1.17-5.24,5-5.24,7.12v24.38H121.03V15.12c0-2.13-3.38-5.95-5.24-7.12h-6.74c-1.04.9-4.49,3.65-4.49,4.88v26.62c-17.92-.07-35.32-1.21-52.16,5.86-23.86,10.03-40.84,33.25-43.64,59.02l-.05,222.02c3.07,33.84,28.97,60.14,62.16,65.59h258.99c9.32-2.04,17.89-4.63,26.21-9.36,19.81-11.26,31.8-30.63,35.92-52.89V102.5c-2.99-17.08-10.86-33.1-23.94-44.64ZM366.77,324.67c0,20.36-27.43,45.7-47.97,45.28l-238.88-.12c-19.79-.68-45.95-25.41-45.95-45.16v-167.08h332.8v167.08ZM366.77,133.51H33.97v-29.57c0-19.56,25.02-43.95,44.53-45.16,81.32-1.26,163.04-1.47,244.34.11,19.31,1.42,43.93,25.74,43.93,45.05v29.57Z"/>
                    <path d="M89.6,264.69c8.72,6.24,17.61,15.63,27.01,25.58,18.83,19.9,38.3,40.49,60.68,40.58.05,0,.11,0,.16,0,11.69,0,22.72-5.56,33.67-16.93l101.04-99.01.21-.23c2.68-3.39,3-8.19.81-12.22-2.06-3.8-5.87-5.93-9.94-5.54-3.49.33-8.04,4.32-12.78,8.73-.45.42-.86.8-1.21,1.12-15.38,13.99-30.36,29.2-44.85,43.91-18.85,19.13-38.34,38.91-58.93,56.26-7.79,3.59-15.77,2.63-23.09-2.78l-59.31-56.61-.22-.21-.27-.15c-6.08-3.47-11.68-1.4-14.52,2.2-2.83,3.57-3.67,9.79,1.16,14.99l.38.33Z"/>
                  </svg>
                  <span class="menu-text">Reservation</span>
                </a> 
              </li>
              @endif
              @if(in_array('Kot View', $permission_allow))
              <li class="more-menu @if($path == '/kot/generate-kot/0' || $path == '/kot/view-kot' || $path == '/kot/qr-menu-orders') active @endif">
                <a href="#" class="moreMenuBtn">
                  <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 400 400">
                    <path d="M21.75,9.89c1.84,1.16,5.19,4.94,5.19,7.04v24.09h328.71c4.88,0,13.94-8.53,16.07-12.84,3.25-6.58.3-14.04,7.28-18.29h11.12v14.82c-3.05,13.4-11.98,25.29-25.01,30.21-1.48.56-6.86,2.4-7.98,2.4h-30.02v48.18c25.5,2.26,49.14,20.56,58.38,44.28,2.09,5.35,3.08,11,4.62,16.5v161.58c-5.31,32.2-30.12,57.24-62.72,61.42l-205.94.08c-32.98-3.91-59.08-29.71-63.29-62.71v-159.16c3.94-32.18,30.47-58.96,62.9-61.98v-48.18H26.94v325c0,.67-1.88,4.12-2.56,4.85-4.11,4.48-13.2,2.33-13.76-4.1l-.02-366.19c-.26-3.43,2.14-5.12,4.48-7.01h6.67ZM306.47,58.51h-164.76v45.06h164.76v-45.06ZM126.76,127.56c-23.22,3.23-42.15,22.64-44.89,45.94v147.14c3.02,23.98,22.14,43.1,46.12,46.12l191.53.04c24.26-2.63,43.75-21.98,46.79-46.16l.04-146.47c-2.6-24.42-22.45-44.23-46.82-46.82l-192.76.22Z"/>
                    <path d="M232.32,199.55c35.46,3.83,66.13,28.77,75.71,63.25,2.86,10.29,3.84,21,3.51,31.7,5.15.36,10.03-1.6,13.74,2.94,4,4.9,1.3,11.76-4.8,13.03-64.38.43-129.02.78-193.35-.18-5.79-1.49-8.04-8.19-4.23-12.85s8.59-2.58,13.74-2.94c-.29-10.29.53-20.6,3.17-30.55,9.32-35.09,40.05-60.54,76.05-64.4.21-6.02-1.39-13.9,6.16-15.73,10.05-2.44,11.04,8.52,10.31,15.73ZM291.68,292.53c.63-18.42-4.07-36.95-16.18-51.07-27.08-31.6-75.73-31.66-102.8.04-12.11,14.18-16.92,32.51-16.21,51.03h135.19Z"/>
                  </svg>
                  <span class="menu-text">KOT</span>
                </a>
                <div class="morePanel sidebar-popover" style="display:none;">
                  <div class="popover-header bg-white text-dark">
                    <div class="d-flex justify-content-between border-bottom">
                      <h4>KOT</h4>
                      <div class="popover-close text-muted fw-normal"><i class="ri-close-line"></i></div>
                    </div>
                  </div>
                  <div class="popover-item">
                    <ul class="w-100">
                      @if(in_array('Kot Generate', $permission_allow))
                      <li class="py-1 px-1">
                        <a href="{{route('generate-kot.index',0)}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Generate KOT
                          </div>
                        </a>
                      </li>
                      @endif
                      <li class="py-1 px-1">
                        <a href="{{route('view-kot.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            View KOT
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="/index/0">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            QR MENU
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('qr-menu-orders.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            QR MENU Orders
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('restaurant-breakfast-chart.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Breakfast Chart
                          </div>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </li>
              @endif
              @if(in_array('Kitchen Full Permission', $permission_allow))
              <li class="more-menu @if($path == '/kitchen/dashboard' || $path == '/kitchen/kot-monitor' || $path == '/kitchen/in-stock' || $path == '/kitchen/consumtion-report' || $path == '/kitchen/transfer-request' || $path == '/kitchen/pending-request' || $path == '/kitchen/return-request-list') active @endif">
                <a href="#" class="moreMenuBtn">
                  
                  <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 400 400">
                    <path d="M386.53,19.22c-2.86-4.32-7.62-6.46-12.13-5.42-4.37,1-7.51,4.74-8.19,9.76l-.02.18c-1.1,17.77-.48,36.53.12,54.68.64,19.4,1.31,39.46-.16,58.13-1.65,21.01-19.46,40.32-40.33,44.34V21.67c0-4.19-6.6-7.85-9.97-7.95-2.66-.09-6.54,1.57-8.8,3.76-1.69,1.64-2.05,3.18-2.05,4.19v159.21c-20.88-4.08-38.69-23.39-40.33-44.33-1.47-18.71-.8-38.83-.15-58.29.59-17.88,1.21-36.36.19-53.79-.2-6.57-5.04-10.23-9.45-10.84-4.23-.59-9.34,1.45-11.21,7.33l-.12.37-.07,116.86v.25c3.23,32.29,29.32,59.17,61.14,63.43v175.81c.08,3.84,2.8,6.08,4.8,7.72.37.3.74.6,1.08.91l.71.63h7.65l.71-.63c.35-.31.71-.61,1.08-.91,1.99-1.64,4.72-3.88,4.81-7.78v-175.74c24.78-3.18,47.27-20.73,56.45-44.29,1.41-3.61,2.32-7.33,3.2-10.93.43-1.75.87-3.56,1.36-5.31l.09-.33V19.84l-.41-.63Z"/>
                    <path d="M267.28,352.53c-3.59.53-8.61,2.48-13.93,4.54-3.92,1.52-7.97,3.1-11.03,3.89-56.61,14.69-115.5-.94-157.53-41.82-42.01-40.86-59.26-99.25-46.16-156.21,15.22-66.13,70.44-117.09,137.41-126.81,5.94-.86,11.9-.88,17.65-.9,5.04-.02,10.24-.03,15.26-.63,6.67-.8,9.66-6.01,9.61-10.51-.05-4.65-3.28-9.65-10.36-10.33-36.89-3.58-76.18,7.39-110.64,30.87-33.3,22.7-58.91,54.58-72.12,89.77-10.59,28.22-14.06,57.79-10.31,87.87,3.53,28.33,13.64,56.12,29.22,80.36,31.91,49.63,82.95,80.36,140.03,84.31,4.56.31,10.28.47,15.99.47s11.43-.16,15.99-.47h0c13.3-.92,29.84-5.3,34.59-6.62.9-.25,22.11-6.17,26.03-10.33,3.1-3.29,3.79-7.95,1.75-11.86-2.14-4.11-6.64-6.31-11.45-5.6Z"/>
                    <path d="M273.27,282.42c-5.74-1.73-12.66,3.06-18.23,6.92-1.56,1.08-3.03,2.1-4.09,2.68-28.17,15.4-61.42,17.08-91.21,4.59-29.4-12.32-51.2-36.77-59.81-67.07-8.77-30.86-3.35-63.38,14.86-89.21,18.48-26.22,47.76-42.49,80.31-44.64,1.52-.1,3.35,0,5.3.11,6.83.39,16.18.91,17.95-8.57.76-4.06-.65-6.66-1.97-8.12-5.06-5.62-17.6-4.63-24.35-4.09l-1.35.1c-45.77,3.35-84.66,30.53-104.03,72.71-19.49,42.44-14.67,90.03,12.89,127.3,18.75,25.35,48,43.17,80.25,48.87,7.61,1.35,15.17,2.01,22.64,2.01,25.15,0,49.05-7.56,68.96-22.09l.94-.68c4.37-3.14,9.81-7.05,6.63-15.06-1.21-3.05-3.12-4.99-5.69-5.76Z"/>
                  </svg>
                  <span class="menu-text"> Kitchen</span>
                </a>
                <div class="morePanel sidebar-popover" style="display:none;">
                  <div class="popover-header bg-white text-dark">
                    <div class="d-flex justify-content-between border-bottom">
                      <h4>Kitchen</h4>
                      <div class="popover-close text-muted fw-normal"><i class="ri-close-line"></i></div>
                    </div>
                  </div>
                  <div class="popover-item">
                    <ul class="w-100">
                      <li class="py-1 px-1">
                        <a href="{{route('kitchen.dashboard')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Dashboard
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('kitchen.kot-monitor')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Kot Monitor
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('kitchen.inStock')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            In Stock
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('kitchen.consumtionReport')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Consumtion Report
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('kitchen.transferRequest')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Transfer Request
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('kitchen.pendingRequest')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Pending Request
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('kitchen.returnRequestList')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Return Request List
                          </div>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </li>
              @endif
              @if(in_array('Store Full Permission', $permission_allow))
              <li class="more-menu @if($path == '/store/purchase-order' || $path == '/store/purchase-list' || $path == '/store/stock-request' || $path == '/store/stock-current' || $path == '/store/transfer-report' || $path == '/store/deficiency-report') active @endif">
                <a href="#" class="moreMenuBtn"> 
                  
                  <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 400 400">
                    <path d="M362.38,4l33.62,152.06c-.31,3.66.43,7.9,0,11.46-1.31,10.92-8.77,24-16.5,31.67l.36,159.65c-2.33,19.01-17.63,34.83-36.93,36.42H57.08c-18.98-2.13-33.86-17.59-36.18-36.42l.36-159.65c-10.78-10.68-17.3-25.85-16.49-41.21L38.39,4h323.99ZM122.71,25.3h-63.16l-28.96,130.38c-.02,33.97,31.42,43.77,60.46,38.68,14.59-2.56,31.66-18.13,31.66-33.68v-11.98h15.97v11.98c0,15.6,17.05,31.12,31.66,33.68,11.71,2.05,49.11,2.08,60.72-.11,14.31-2.69,31.04-18.35,31.04-33.57v-11.98h15.97v11.98c0,15.61,17.06,31.13,31.66,33.68,29.39,5.14,60.85-4.94,60.35-39.3l-28.85-129.76h-63.16v76.95h-15.97V25.3h-123.41v76.95h-15.97V25.3ZM45.76,214.71v139.74c0,8.02,11.74,19.15,19.97,19.23l267.89.04c8.75.77,21.38-10.86,21.38-19.27v-139.74c-25.47,8.78-59.11,8.71-78.42-12.68-1.43-1.03-5.62-8.71-6.87-8.37-.48.13-4.68,6.74-5.81,8-9.74,10.88-23.9,17.2-38.45,18.17-15.61,1.04-50.69,1.58-64.84-2.73-7.39-2.25-13.9-6.58-19.77-11.45l-10.51-11.99c-16.89,28.96-55.84,31.23-84.58,21.06Z"/>
                  </svg>
                  <span class="menu-text"> Store</span>
                </a>
                <div class="morePanel sidebar-popover" style="display:none;">
                  <div class="popover-header bg-white text-dark">
                    <div class="d-flex justify-content-between border-bottom">
                      <h4>Store</h4>
                      <div class="popover-close text-muted fw-normal"><i class="ri-close-line"></i></div>
                    </div>
                  </div>
                  <div class="popover-item">
                    <ul class="w-100">
                      <li class="py-1 px-1">
                        <a href="{{route('store.purchaseOrder')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Purchase Order
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('store.purchaseList')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Purchase List
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('store.stockRequest')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Item Requests
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('store.stockCurrent')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Current Stock
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('store.transferReport')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Transfer Report
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('store.deficiencyReport')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Deficiency Report
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('store.wasteDisposeReport')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Expired Item Report
                          </div>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </li>
              @endif
              @if(in_array('Banquet View', $permission_allow))
              <li class="more-menu @if($path == '/banquet/dashboard' || $path == '/banquet/booking' || $path == '/banquet/hall') active @endif">
                <a href="#" class="moreMenuBtn">
                  
                  <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 400 400">
                    <path d="M376.25,311.75h-32.25v-111.75h32.25v-16.5h-32.25c1.3-74.6-61.16-140.74-135.75-143.25V8s-16.5,0-16.5,0v32.25c-74.59,2.53-137.05,68.62-135.75,143.25H23.75v16.5h32.25v111.75H23.75v16.5h352.5v-16.5ZM128.11,83.14c32.22-23.9,74.77-30.09,112.67-16.64,47.18,16.74,81.02,63.32,80.34,113.82H78.88c-.46-38.32,18.8-74.6,49.24-97.18ZM133.93,308.96h-59.85v-106.16h59.85v106.16ZM245.6,308.96h-91.2v-106.16h91.2v106.16ZM325.93,308.96h-59.85v-106.16h59.85v106.16Z"/>
                    <rect x="6.5" y="374" width="387" height="19.5"/>
                  </svg>
                  <span class="menu-text"> Banquet</span>
                </a>
                <div class="morePanel sidebar-popover" style="display:none;">
                  <div class="popover-header bg-white text-dark">
                    <div class="d-flex justify-content-between border-bottom">
                      <h4>Banquet</h4>
                      <div class="popover-close text-muted fw-normal"><i class="ri-close-line"></i></div>
                    </div>
                  </div>
                  <div class="popover-item">
                    <ul class="w-100">
                      <li class="py-1 px-1">
                        <a href="{{route('dashboard.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Dashboard
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('booking.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Booking
                          </div>
                        </a>
                      </li>
                      @if(in_array('Banquet Hall View', $permission_allow))
                      <li class="py-1 px-1">
                        <a href="{{route('hall.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Hall
                          </div>
                        </a>
                      </li>
                      @endif
                    </ul>
                  </div>
                </div>
              </li>
              @endif
              @if(in_array('Report Full Permission', $permission_allow))
              <li class="more-menu @if($path == '/report/reservationReportView' || $path == '/report/kotReport' || $path == '/report/hall-utilization-report' || $path == '/report/hall-revenue-comparison' || $path == '/report/comprehensive-booking-report' || $path == '/report/comprehensive-corporate-report' || $path == '/report/event-type-analysis' || $path == '/report/monthly-revenue-breakdown' || $path == '/report/outstanding-payments-report') active @endif">
                <a href="#" class="moreMenuBtn">
                  <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 400 400">
                    <path d="M360.5,392H39.5l-.03-343.98c1.39-20.22,14.25-35.29,34.24-39.19l167.96-.13,3.37,1.12,115.3,115.47.15,266.7ZM229.93,33.97H81.37c-2.65,0-10.17,4.94-12.13,7.1-2.54,2.81-6.04,10.21-6.04,13.88v311.82h273.6v-226.84h-106.88V33.97ZM329.9,118.18l-79.8-79.64v79.64h79.8Z"/>
                    <g>
                      <rect x="183.5" y="183.91" width="16.5" height="144.47"/>
                      <path d="M202,330.37h-20.5v-148.47h20.5v148.47ZM185.5,326.37h12.5v-140.47h-12.5v140.47Z"/>
                    </g>
                    <g>
                      <rect x="248" y="231.81" width="16.5" height="96.56"/>
                      <path d="M266.5,330.37h-20.5v-100.56h20.5v100.56ZM250,326.37h12.5v-92.56h-12.5v92.56Z"/>
                    </g>
                    <g>
                      <rect x="119.75" y="264" width="16.5" height="64.37"/>
                      <path d="M138.25,330.37h-20.5v-68.38h20.5v68.38ZM121.75,326.37h12.5v-60.38h-12.5v60.38Z"/>
                    </g>
                  </svg>
                  <span class="menu-text">Report</span>
                </a>
                <div class="morePanel sidebar-popover" style="display:none;">
                  <div class="popover-header bg-white text-dark">
                    <div class="d-flex justify-content-between border-bottom">
                      <h4>Report</h4>
                      <div class="popover-close text-muted fw-normal"><i class="ri-close-line"></i></div>
                    </div>
                  </div>
                  <div class="popover-item">
                    <ul class="w-100">
                      <li class="py-1 px-1">
                        <a href="{{route('roomReport.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Rooms
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('guestHistory.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Guest History
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('reservationReport.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Reservation
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('kotReport.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            KOT
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('hallUtilization.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Hall Utilization
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('hallRevenue.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Hall Revenue
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('comprehensiveBooking.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            <span class="text-start">Comprehensive Hall Booking</span>
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('comprehensiveCorporate.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            <span class="text-start">Comprehensive Corporate</span>
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('eventType.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            <span class="text-start">Event Type Analysis</span>
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('monthlyRevenue.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            <span class="text-start">Monthly Revenue Breakdown</span>
                          </div>
                        </a>
                      </li>
                      <li class="py-1 px-1">
                        <a href="{{route('outstandingPayments.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Outstanding Payments
                          </div>
                        </a>
                      </li>
                      
                    </ul>
                  </div>
                </div>
              </li>
              @endif
              @if(in_array('Night Audit Full Permission', $permission_allow))
              <li class="@if($path == '/nightaudit/dashboard') active @endif"> 
                <a href="{{route('auditReport.index')}}" class="">
                  
                  <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 400 400">
                    <path d="M241.99,385.94c-1.92-.12-3.73-.24-5.5-.49-10.36-1.47-21.44-4.65-33.87-9.74-.69-.28-2.8-1.43-4.5-2.35-4.36-2.37-4.77-2.56-5.5-2.56H29.93V45.99c0-2.3,2.42-6.18,6.01-9.66,4.05-3.92,8.67-6.51,11.51-6.4l240.95-.03c9.93.54,18.18,8.31,19.68,18.52l.05,86.34,20.24,10.72V45.99c0-15.64-19.96-35.63-36.27-36.26l-245.41-.03h-.2C27.16,11.68,11.69,27.15,9.7,46.49l.02,344.52h256.54l-15.28-3.94c-2.92-.75-6-.95-8.98-1.14Z"/>
                    <path d="M333.83,322.18c-.39-1.49,3.81-5.69,4.94-7.36,49.75-73.32-4.4-167.39-92.38-161.65-47.81,3.12-90.1,45.4-93.22,93.22-5.74,87.96,88.33,142.12,161.64,92.38,1.67-1.13,5.86-5.34,7.36-4.94l55.05,55.19h.74l11.05-11.05v-.74l-55.19-55.05ZM181.76,291.34c-24.32-50.16,8.88-112.49,64.64-117.42,66.76-5.9,113.29,63.12,80.07,122.07-32.05,56.86-116.23,54.06-144.7-4.65Z"/>
                    <rect x="151.21" y="87.83" width="114.54" height="20.21"/>
                    <rect x="72.36" y="87.83" width="51.9" height="20.21"/>
                    <rect x="72.36" y="166.68" width="51.9" height="20.21"/>
                    <rect x="72.36" y="245.53" width="51.9" height="20.21"/>
                    <path d="M310.39,230.57c-6.66-7-8.02-8.1-9.69-7.8l-.61.11-54.47,53.32-1.21-.25-28.82-28.01-.6-.11c-.96-.17-1.73-.31-7.79,5.75-6.1,6.1-5.96,6.86-5.79,7.83l.11.64.47.45c3.4,3.27,6.77,6.8,10.03,10.22,4.23,4.43,8.59,9.01,13.16,13.16,6.28,5.71,12.32,11.2,20.27,11.2,3.32,0,6.98-.96,11.12-3.26l.23-.13,59.37-57.77-1.85-1.41c-.58-.44-2.35-2.3-3.92-3.95Z"/>
                  </svg>
                  <span class="menu-text"> Night Audit</span>
                </a> 
              </li>
              @endif
              
              </div>
              <div class="last-item ">
                @if(in_array('Setting View', $permission_allow))
                <li class="@if($path == '/roomnum' || $path == '/setting/tariff' || $path == '/roomtype' || $path == '/restaurant/restaurant-table' || $path == '/restaurant/restaurant-menu' || $path == '/restaurant/restaurant-raw-material' || $path == '/restaurant/restaurant-item-attribute' || $path == '/restaurant/restaurant-item-category' || $path == '/tax/tax-slab' || $path == '/setting/payment-method' || $path == '/setting/company' || $path == '/setting/waiter' || $path == '/setting/event' || $path == '/setting/feature' || $path == '/setting/accessories' || $path == '/setting/reason-closer') active @endif"> <a href="{{route('room.roomNumber')}}" class="">
                  <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 400 400">
                    <g>
                      <path d="M373.8,307.9l-.86-.38-42.59-.16c-2.66-18.62-16.12-31.74-35.26-33.89-18.39-2.07-33.31,1.14-43.16,9.28-7.12,5.88-11.51,14.15-13.1,24.6H28.14s-.45.08-.45.08c-6.8,1.4-11.24,6.91-10.8,13.38.45,6.7,5.77,11.73,12.93,12.22h.15s208.71-.03,208.71-.03c3.79,17.2,12.86,27.57,27.65,31.67,6.37,1.76,12.75,2.63,18.88,2.63,11.25,0,21.66-2.92,29.63-8.57,8.55-6.05,13.85-14.95,15.5-25.89,5.26-.2,10.91.05,16.4.3,7.66.34,15.58.69,22.85-.12,6.8-.76,11.79-5.12,12.71-11.1.89-5.83-2.45-11.33-8.52-14.01ZM297.15,338.03c-3.67,1.61-10.17,2.34-16.17,1.8-6.41-.58-11.38-2.47-13.29-5.07-4.42-6.01-4-25.7.66-30.54,1.66-1.73,5.78-3.42,9.38-3.86,10.65-1.28,17.47-.33,21.46,3.01,3.2,2.67,4.95,7.2,5.35,13.85.47,7.81-.43,17.76-7.39,20.82Z"/>
                      <path d="M27.69,93.33l.45.09h210.62c2.67,18.6,16.12,31.72,35.26,33.87,3.62.41,7.1.61,10.44.61,13.69,0,24.94-3.4,32.9-10.02,7.08-5.89,11.42-14.1,12.94-24.47h40.72s.38-.06.38-.06c6.47-1.13,10.98-6.34,10.96-12.67-.02-6.39-4.62-11.62-11.19-12.72l-.36-.06-40.55-.2c-3.71-22.52-21.57-35.21-48.58-34.13-23.88.95-39.05,13.04-43.13,34.19l-208.42-.05h-.31c-7.16.5-12.48,5.53-12.93,12.23-.44,6.47,4,11.98,10.8,13.38ZM300.97,65.47c4.84,5.64,4.69,25.96-.22,31.07-2.47,2.57-8.98,4.29-16.2,4.29h0c-7.22,0-13.73-1.73-16.2-4.29-4.57-4.75-5.11-23.97-.85-30.24,2.84-4.18,9.68-5.3,14.92-5.51,8.79-.34,15.74,1.4,18.55,4.68Z"/>
                    </g>
                    <path d="M382.28,196.53c-1.67-5.7-6.63-8.84-12.22-9.44-.29-.05-.6-.08-.93-.08-.22-.01-.43-.01-.63,0-23.79,0-47.59,0-71.38,0-38.09,0-76.18,0-114.27,0-7.38,0-14.77,0-22.15,0-1.79-9.61-5.92-18.47-13.87-24.73-8.83-6.95-20.19-9.46-31.24-9.59-11.69-.14-23.69,2.19-33.02,9.62-7.94,6.32-12.14,15.25-13.93,24.91-13.29.35-26.75-2-39.93-.08-9.22,1.34-15.61,10.94-10.67,19.67,3.42,6.05,8.83,6.59,14.9,6.64,7.55.06,15.09.12,22.64.18,4.36.03,8.72.07,13.08.1,1.82,9.79,6.13,18.69,14.32,24.99,8.59,6.61,19.54,9.11,30.21,9.36,11.34.26,23.25-1.73,32.49-8.7,8.4-6.33,13.16-15.64,15.3-25.7,35.88-.09,71.77.08,107.65.12,18.63.02,37.26.01,55.89-.09,9.31-.05,18.62-.12,27.93-.22,4.65-.05,9.3-.11,13.96-.18,3.74-.05,7.24.28,10.47-1.86,4.85-3.21,7.03-9.35,5.39-14.92ZM134.17,203.61c-.39,5.41-1.57,11.24-6.68,14.07-5.26,2.92-12.91,2.9-18.72,2.11-12.14-1.66-14.21-11.87-13.57-22.63.3-5.11,1.34-10.8,6-13.72,5.1-3.2,12.96-3.2,18.76-2.57,12.62,1.38,14.76,11.64,14.21,22.74Z"/>
                  </svg>
                  <span class="menu-text">Settings</span></a>
                </li>
                @endif
                <li class="more-menu @if($path == '/banquet/dashboard' || $path == '/banquet/booking' || $path == '/banquet/hall') active @endif">
                <a href="#" class="moreMenuBtn">
                  <img src="{{asset('backend/assets/images/profile.png')}}" alt="">
                  <span class="menu-text"> {{ Auth::user()->name }}</span>
                </a>
                <div class="morePanel sidebar-popover" style="display:none;">
                  {{-- <div class="popover-header bg-white text-dark">
                    <div class="d-flex justify-content-between border-bottom">
                      <h4>Banquet</h4>
                      <div class="popover-close text-muted fw-normal"><i class="ri-close-line"></i></div>
                    </div>
                  </div> --}}
                  <div class="popover-item">
                    <ul class="w-100">
                      @if(in_array('General Setting', $permission_allow))
                      <li class="py-1 px-1">
                        <a href="{{route('setting.index')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            General Setting
                          </div>
                        </a>
                      </li>
                      @endif
                      <li class="py-1 px-1">
                        <a href="{{route('logout')}}">
                          <div class="d-flex align-items-center">
                            <span class="me-2 icon"><i class="ri-file-chart-line"></i></span> 
                            Logout
                          </div>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </li>
              </div>
            </ul>
          </div>
        </div>
        <div class="vertical-layout-body">
          
          <!-- Page Body Start-->
          <div class="page-body-wrapper horizontal-menu">
            <!-- Page Sidebar Start-->
            <div class="sidebar-wrapper" data-layout="stroke-svg">
              <div>
                {{-- <div class="logo-wrapper"><a href="index.html"><img class="img-fluid for-light" src="../assets/images/logo/logo.png" alt=""><img class="img-fluid for-dark" src="../assets/images/logo/logo_dark.png" alt=""></a>
                  <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                  <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
                </div> --}}
                <nav class="sidebar-main">
                  <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
                  <div id="sidebar-menu">
                    <ul class="sidebar-links vertical-menu-mobile" id="simple-bar">
                      <li class="active-menu">
                        <a href="/dashboard" class="current-page"> 
                          
                          <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400">
                            <path d="M43.73,105.63v241.85c0,5.35,6.04,9.04,11.05,8.81h288.9c8.19-.6,11.12-2.65,11.84-11.08l.02-214.7c2.29-8.31,13.63-9.1,17.72-1.76,1.35,74.02.19,148.4.58,222.55-2.18,12.47-11.46,21.66-24.04,23.33l-303.05-.38c-11.43-2.85-20.01-11.9-21.39-23.7V50.2c1.43-12.53,11.52-22.64,24.07-24.07l302.42.23c33.31,8.07,18.92,47.94,21.93,72.73.23,1.89-4.48,6.54-5.69,6.54H43.73ZM71.06,56.93c-11.84,1.72-11.74,16.59.65,18.05,7.5.89,21.55,1.11,20.59-9.89-.85-9.68-14.01-9.22-21.24-8.17ZM119.97,56.93c-11.84,1.72-11.74,16.59.65,18.05,7.5.89,21.55,1.11,20.59-9.89-.85-9.68-14.01-9.22-21.24-8.17ZM168.87,56.93c-11.84,1.72-11.74,16.59.65,18.05,7.5.89,21.55,1.11,20.59-9.89-.85-9.68-14.01-9.22-21.24-8.17Z"/>
                            <path d="M80.41,319.59h13.75v-24.07c0-.22,1.89-3.43,2.27-3.84,3.73-3.98,11.33-3.76,14.55.78.68.95,2.28,4.5,2.28,5.36v21.78h12.99v-47.76c0-.96,2.53-4.85,3.55-5.62,4.4-3.31,11.04-2.09,13.91,2.68.3.5,1.64,3.5,1.64,3.71v46.99h12.99v-66.1c0-3.73,6.01-7.34,9.55-7.32,3.77.02,9.55,3.23,9.55,7.32v66.1h12.99v-40.88c0-1.88,3.63-6.67,5.54-7.45,3.08-1.24,7.28-.85,10,1.07,1.03.73,3.56,4.01,3.56,4.85v42.41h13.75v-67.63c0-3.29,6.39-5.96,9.57-5.79s8.77,3.27,8.77,6.55v66.86c3.34.34,7.57-.64,10.74.34,7.69,2.37,7.23,16.42-1.23,17.96l-183.16-.14c-2.77-1.5-5.81-3.53-5.93-7.06l.06-77.92c1.45-5.9,8.03-8.17,13.51-5.96,1.13.45,4.78,4.23,4.78,5.15v67.63Z"/>
                            <path d="M196.34,136.36l132.83-.2c3.89-.14,7.64,3.45,8,7.28-1.61,22.64,2.08,48.06.02,70.35-.39,4.21-2.96,7.4-7.28,8l-134.09-.43c-2.57-1.62-5.3-3.44-5.4-6.83,1.59-22.65-2.06-48.03-.02-70.35.36-3.96,2.28-6.28,5.93-7.83ZM318.82,154.53h-110.04v48.9h110.04v-48.9Z"/>
                            <path d="M109.28,124.18c39.94-4.5,70.82,29.58,61.24,68.89-11.8,48.44-79.72,55.96-102.47,11.65-17.08-33.28,3.48-76.28,41.22-80.53ZM107.92,143.84c-24.19,6.35-34.68,34.08-21.26,55.26,9.28,14.65,31.82,21.22,47.03,12.15.62-.37,1.28.23.97-1.3-8.78-9.28-18.63-17.67-26.74-27.52v-38.59ZM126.26,143.84v30.95l21.79,21.77c1.53.31.93-.35,1.3-.97,11.4-19.11-1.37-47.14-23.09-51.75Z"/>
                            <path d="M281.92,252.5h49.35c8.43,2.49,7.88,16.79-.65,18.13-14.01,2.22-33.46-1.53-48.06,0-8.83-2.8-9.07-14.81-.64-18.14Z"/>
                            <path d="M281.92,286.13h49.35c8.43,2.49,7.88,16.79-.65,18.13-14.01,2.22-33.46-1.53-48.06,0-8.83-2.8-9.07-14.81-.64-18.14Z"/>
                            <path d="M281.92,319.75h49.35c8.43,2.49,7.88,16.79-.65,18.13-14.01,2.22-33.46-1.53-48.06,0-8.83-2.8-9.07-14.81-.64-18.14Z"/>
                          </svg>
                          <span class="menu-text">Home</span>
                        </a>
                      </li>
                      <li class=""> 
                        <a href="client.php" class="">
                          
                          <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400">
                            <path d="M392,326.13c-2.5,10.3-9.08,16.4-19.81,17.24-17.58,1.38-36.92-1.1-54.69,0-7.34-.52-8.99-9.12-2.07-11.83l57.41-.23c2.68.19,7.18-3.89,7.18-6.29v-192.75H20.73v42.29c0,.17-1.73,2.39-2.05,2.64-3.97,2.99-8.89.42-9.88-4.18.62-36.48-1.48-73.34,1.09-109.61,1.5-5.87,9.64-13.48,15.71-13.48h39.3v-22.08c0-.37.91-4.92,1.11-5.63,1.91-6.68,8.78-12.67,15.73-13.46s31.04-.92,37.1.33c4.68.97,9.95,5.4,12.07,9.64.35.7,2.11,5.09,2.11,5.38v25.82h134.74v-25.82c0-.29,1.76-4.68,2.11-5.38,2.12-4.24,7.39-8.67,12.07-9.64,6.05-1.25,30.46-1.09,37.1-.33,8.9,1.01,16.84,10.24,16.84,19.09v22.08h39.3c.44,0,5.31,1.72,6.12,2.11,5.23,2.53,9.95,9.44,10.72,15.1v258.99ZM84.92,20.17c-4.86.7-7.31,2.71-7.99,7.73-2.12,15.65,1.47,35.5-.09,51.61-.17,3.74,2.68,7.94,6.43,8.54,5.96.95,24.29.67,30.68.08,3.95-.36,6.61-2.24,7.09-6.38-1.25-17.36,1.6-36.85.02-53.95-.45-4.9-3.19-7.15-7.98-7.74-6.15-.75-22.09-.77-28.16.11ZM287.03,20.17c-3.71.58-6.36,2.46-7.27,6.21,1.15,17.57-1.67,37.33-.08,54.64.32,3.44,2,6.45,5.69,7.03,5.98.94,24.28.67,30.68.08,5.3-.49,7.3-3.58,7.81-8.65,1.23-12.22,1.13-37.84.04-50.17-.57-6.53-2.95-8.68-9.4-9.32s-21.59-.73-27.49.19ZM64.89,61.89H26.34c-1.01,0-5.61,4.61-5.61,5.61v52.77h359.3v-52.77c0-1.01-4.61-5.61-5.61-5.61h-38.55v18.34c0,1.12-1.2,5.92-1.67,7.32-2.15,6.45-9.22,11.8-15.92,12.53s-31.42.79-37.22-.96c-4.78-1.44-13.31-9.34-13.31-14.39v-22.83h-134.74v22.83c0,5.05-8.52,12.94-13.31,14.39-5.8,1.75-30.46,1.69-37.22.96s-13.77-6.08-15.92-12.53c-.46-1.39-1.67-6.2-1.67-7.32v-18.34Z"/>
                            <path d="M150.22,392c-6.43-3.62-5.48-21.83-3.14-27.47,1.1-2.64,5.12-6.96,8.01-6.96h17.59v-14.22H26.34c-8.14,0-17.46-10.29-17.5-18.43l-.11-125.68c.55-7.73,9.95-8.92,11.95-1.44l.04,125.71c-.41,2.9,3.69,7.86,6.36,7.86h145.59v-15.72H47.3c-.76,0-4.92-1.79-5.87-2.37-4.68-2.89-6.72-7.68-7.22-12.99-1.45-15.49-1.45-47.35,0-62.85.8-8.52,5.9-14.47,14.55-15.39l91.25-.07c1.12-.38,3.97-9.88,5.07-12.14,21.92-45.14,88.11-45.55,110.34-.51,1.07,2.18,4.17,12.27,5.31,12.66l91.25.07c8.67.92,13.76,6.88,14.55,15.39,1.42,15.25,1.51,47.67,0,62.86-.51,5.15-2.71,10.19-7.23,12.99-.94.58-5.11,2.37-5.87,2.37h-125.38v15.72h64.75c1.76,0,3.99,4.4,3.9,6.25-.11,2.33-3.21,5.73-5.4,5.73h-63.25v14.22h17.59c2.88,0,6.91,4.33,8.01,6.96,2.34,5.64,3.29,23.85-3.14,27.47h-100.3ZM193.47,187.86c-17.01,1.92-32.7,14.94-39.12,30.5-2.46,5.96-2.15,12.95-9.35,15.35l-94.76.31c-2.38-.19-4.1.86-4.11,3.38,1.4,19.82-1.75,41.91,0,61.45.15,1.66.18,3.26,1.52,4.46l305.81-.36c.98-1.23,1.01-2.61,1.14-4.1,1.66-19.63-1.34-41.56,0-61.45,0-2.52-1.73-3.57-4.11-3.38l-94.19-.13c-7.72-2.17-7.37-9.37-9.92-15.54-8.78-21.28-30.1-33.07-52.93-30.5ZM216.09,315.65h-31.44v41.92h31.44v-41.92ZM243.04,369.54h-85.33v11.23h85.33v-11.23Z"/>
                            <path d="M82.11,273.74c-.65.83,14.82,12.03,5.65,17.24-6.19,3.52-11.24-6.23-15.01-9.76-.89,3.27.65,6.98-2.63,9.33-5.22,3.74-9.19-.68-9.72-5.97-.75-7.48-.73-23.21-.02-30.72.57-6.06,2.66-7.43,8.61-7.85,6.29-.45,14.64.81,18.7,6.05,5.19,6.71,3.17,19.26-5.57,21.68Z"/>
                            <path d="M222.08,273.74c2.55,4.4,13.09,11.7,5.97,16.81-6.36,4.57-11.83-5.04-14.96-9.33l-1.24,6.61c-1.84,5.94-10.7,5.15-11.5-1.73-.82-7.1-.84-26.64,0-33.72.97-8.21,12.87-6.99,18.88-5.37,13.24,3.56,15.23,20.75,2.84,26.74Z"/>
                            <path d="M314.69,246.94c2.41-.54,9.16-.42,11.81-.15,24.13,2.41,23.05,41.74,1.51,44.16-4.23.48-16.05,1.24-17.44-3.53l-.11-35.73c.31-2.22,2.02-4.26,4.23-4.75ZM322.39,279.72c13.63,1.36,13.79-23.3,0-20.96v20.96Z"/>
                            <path d="M196.44,198.31c27.11-4.26,33.1,33.8,9.35,40.03-27.85,7.31-35.74-35.88-9.35-40.03ZM197.91,210.27c-8.9,2.05-7.56,18.15,3.39,16.92,11.65-1.31,8.95-19.76-3.39-16.92Z"/>
                            <path d="M142.74,258.77c-.26,1.26.34,1.52,1.22,2.14,4.76,3.29,11.75,2.82,15.86,8.84,7.97,11.68-3.3,23.03-15.96,21.94-6.15-.53-20.59-8.05-13.51-14.99,6.42-6.3,13.24,8.72,19.83,1.07.46-2.76-10.99-5.61-13.21-6.88-12.24-7.01-5.74-24.37,8.51-24.56,5.62-.08,19.67,4.97,14.81,12.41-5.21,7.99-10.99-3.03-17.55.03Z"/>
                            <path d="M180.16,258.76v4.5c3.84.15,11.12-1.35,12.57,3.52,2.54,8.54-6.48,9.02-12.57,8.45v4.5c2.77.2,5.84-.33,8.56.04,7.28,1.01,7.3,10.55.63,11.75-5.27.95-19.51,1.8-21-4.85-1.08-4.81-.72-27.11-.19-32.81.38-4.08,1.14-6.58,5.63-7.1s18.12-1.21,20.04,3.2c3.52,8.11-8.01,9.7-13.66,8.79Z"/>
                            <path d="M290.2,258.76v4.5c4.2.09,11.36-1.33,12.58,4.28,1.72,7.88-6.98,8.18-12.58,7.69v4.5c4.38.31,10.27-1.5,13.04,3.05,2.1,3.46-.04,7.91-3.84,8.76-4.19.94-19.95,1.64-21.01-4.12l.17-36.93c.8-1.57,1.94-3.33,3.8-3.68,2.54-.48,17.67-.29,19.37.8,1.17.76,2.15,2.98,2.29,4.31.79,7.33-8.86,7.14-13.82,6.84Z"/>
                            <path d="M108.3,258.76v4.5c18.14-3.2,17.7,14.81,0,11.97v4.5c3.12.3,6.95-.52,9.95.16,5.53,1.24,5.75,9.86.57,11.48-3.7,1.16-19.76,1.67-21.59-3.19l.18-38.44c.64-1.79,2-2.61,3.83-2.9,2.7-.43,16.95-.39,18.72.65,1.36.81,2.57,3.34,2.63,4.94.24,6.85-9.47,6.73-14.29,6.34Z"/>
                            <path d="M255.01,268.49c1.31-4.13,4.91-20.4,8.77-21.55,4.93-1.46,9.03,1.63,8.31,6.75-.59,4.19-9.38,30.3-11.44,34.27-1.89,3.65-6.11,4.91-9.66,2.89-2.8-1.59-7.35-16.5-8.71-20.49-1.25-3.69-5.83-15.19-5.95-18.05-.14-3.39,3.49-6.34,6.83-5.9,7.17.95,7.49,17.72,11.85,22.06Z"/>
                          </svg>
                          <span class="menu-text">Reservation</span>
                        </a> 
                      </li>
                      <li class="">
                        <a href="#" class="">
                          
                          <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400">
                            <path d="M8.73,144.45c2.29-3.93,8.92-4.45,10.82,0l7.82,50.72c23.38,2.5,54.55-10.01,60.93,21.47,4.47,22.07,5.46,46.04,9.67,68.29-1.03,6.2-8.53,7.84-11.32,1.97l-7.82-55.94c-15.65.22-31.44-.43-47.03.33-2.69,18.32-3.46,37.35-6.12,55.77-1.7,3.07-4.47,4.34-7.81,2.99-4.15-1.68-3.33-6.47-3.17-10.24.76-17.96,4.85-36.96,5.68-55.06l-11.65-72.83v-7.46ZM76.59,219.02c1.29-3.74-5.53-11.93-8.58-11.93H29.61l1.49,11.93h45.49Z"/>
                            <path d="M126.55,135.5h47.72c-.29-6.29-9.92-22.84,1.07-23.91l51.11.43c6.65,3-1.15,18.05-1.48,23.48h47.72c-1.46-6.18-4.78-22.85,4.08-23.88,6.84-.79,23.7-.72,30.64-.03,4.32.43,6.96,3.93,5.15,8.23-1.3,3.07-5.3,2.8-5.53,3.03-.46.44.45,10.62-.78,12.64h16.03c3.03,0,7.49,5.3,8.22,8.18,1.06,4.16.83,17.58-1.12,21.29-5.11,9.69-26.58,8.07-21.28-2.63,2.21-4.47,6.59-2.66,10.82-2.98v-12.68H80.32v12.68h211.4c1.63,0,3.7,5.02,3.36,7.05-.3,1.81-4.05,4.88-5.6,4.88h-71.96v83.52c6.05-.31,12.33-.39,16,5.25.38.59,1.9,3.76,1.9,4.07v14.54c10.32-2.78,18.06,7.69,6.29,11.88-26.52-1.83-56.68,2.6-82.76.09-4.84-.47-8.42-2.91-6.71-8.28,1.53-4.79,7.67-3.64,11.6-3.69v-14.54c0-.31,1.52-3.48,1.9-4.07,3.67-5.64,9.95-5.57,16-5.25-2.8-16.19,14.57-16.18,11.93,0h11.93v-83.52h-11.93v54.81c0,1.44-3.88,4.73-5.65,4.84-2.11.14-6.29-3.16-6.29-4.84v-54.81h-101.79c-3.96,0-9.12-3.52-10.62-7.28-1.4-3.53-1.52-17.18-.44-20.93.78-2.71,5.35-7.59,8.07-7.59h16.03c-1.23-2.02-.32-12.2-.78-12.64-.24-.23-4.24.04-5.53-3.03-1.81-4.3.84-7.81,5.15-8.23,6.94-.69,23.8-.76,30.64.03,8.87,1.03,5.55,17.69,4.08,23.88ZM116.11,122.82h-11.93c-3.06,17.04,14.6,16.42,11.93,0ZM216.03,122.82h-32.81c1.38,3.97,1.05,10.23,5.54,11.98,3.26,1.27,19.85,1.26,22.74-.48,3.35-2.02,3.32-8.07,4.53-11.5ZM295.08,122.82h-11.93c-2.67,16.42,14.99,17.04,11.93,0ZM223.49,266.74h-47.72v11.93h47.72v-11.93Z"/>
                            <path d="M369.65,207.08h-38.4c-3.04,0-9.87,8.19-8.58,11.93h27.96c3.86,0,6.63,8.9.8,11.24-5.01,2.02-29.93-.43-31.01.68l-7.82,55.94c-2.69,6.08-11.12,4-11.3-2.47,4.16-21.95,5.26-45.32,9.55-67.14,6.35-32.31,36.9-19.59,61.03-22.11l7.2-48.36c1.02-8.41,13.02-6.86,11.5,1.77-1.64,24.48-10.7,52.24-11.54,76.32-.59,17.01,4.9,38.13,5.55,55.62.13,3.46.83,7.4-2.74,9.25-5.36,2.78-8.35-1.38-9.14-6.32-2.44-15.23-4.72-38.16-5.33-53.58-.32-7.91,1.29-15.02,2.27-22.77Z"/>
                          </svg>
                          <span class="menu-text">KOT</span>
                        </a>
                      </li>
                      <li class="">
                        <a href="#" class="">
                          
                          <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400">
                            <path d="M52.25,234.06h102.75c.06-7.46-11.11-26.56,1.84-27.73,11.72-1.06,35.62-1.08,47.32,0,13.34,1.23,1.43,19.77,1.84,27.73h23.25v-20.96c0-.17-1.94.15-3.41-.71-4.62-2.71-3.3-10.52,2.32-11.23,21.72,1.41,46.09-2.02,67.49-.08,3.47.31,6.22,1.69,6.39,5.67.28,6.65-6.05,5.86-6.05,6.35v20.96h28.5c-.97-9.99-4.95-21.96-5.28-31.79-.12-3.58-.1-5.33,3.05-7.5l52.15-.43c5.17,1.11,5.1,4.81,4.73,9.3-.58,7.14-2.74,19.98-4.47,26.97-.33,1.32-.76,2.28-1.43,3.44,8.31-.24,12.79-.89,13.53,8.58l-.03,134.77c-.19,3.06-1.62,5.57-4.46,6.78H17.7c-2.25-.73-3.46-3.8-3.72-6.01-.07-38.43-.19-76.95.8-115.26.18-7.13-1.03-17.37.02-23.94.32-2.01,3.12-4.91,4.83-4.91h19.88v-20.96c-18.62,3.43-18.26-15.23,0-11.97-2.35-27.03,31.54-42.12,49.13-20.97,4.71,5.66,11.66,26.16,1.44,27.67-8.33,1.23-6.47-5.86-7.15-10.74-1.72-12.21-13.62-18.85-24.44-11.83-2.06,1.33-6.23,6.49-6.23,8.75v40.05ZM366.5,206.36h-34.5c2.63,5.9,1.43,23.87,7.22,26.85,2.33,1.2,14.96,1.31,17.75.69,8.64-1.95,6.65-20.96,9.53-27.54ZM284,213.1h-42.75v20.96h42.75v-20.96ZM197,218.34h-33l3.7,15.4,25.12.37,4.18-15.76ZM104,246.04H26.75v15.72h77.25v-15.72ZM194,246.78l-77.25-.75v15.72h77.25v-14.97ZM374,246.04h-167.25s-.75,126.5-.75,126.5h168v-126.5ZM104,273.73H26v98.81h78v-98.81ZM194,273.73h-77.25v98.81h77.25v-98.81Z"/>
                            <path d="M239.75,115.04v14.6l35.9,38.27c1.82,3.15.89,6.98-2.34,8.7-48.31,1.09-96.94.64-145.35.23-3.61-1.5-4.79-5.57-2.86-8.93l35.15-37.52v-15.35H18.12c-2.05,0-3.92-4.45-4.14-6.34-1.95-16.34.24-39.68.05-56.94-.1-9.52-1.71-19.56-.81-29.19.32-3.46,1.07-6,4.49-7.5l364-.17c2.35.46,3.9,3.29,4.24,5.5,1,6.49-.18,16.19.02,23.19.55,19.11,2.9,45.79.78,64.34-.21,1.84-2.41,7.11-4.12,7.11h-142.88ZM374,26.71H26v14.97h348v-14.97ZM135.5,54.41H26v48.65h109.5v-48.65ZM194,54.41h-45.75v48.65h45.75v-48.65ZM251.75,54.41h-45.75v48.65h45.75v-48.65ZM374,54.41h-108.75v48.65h108.75v-48.65ZM227.75,115.04h-55.5v11.98h55.5v-11.98ZM256.25,165.19l-23.2-25.13-3.38-1.12-60.64.2-24.53,26.05h111.75Z"/>
                            <path d="M228.3,280.65l122.11-.21c3.65-.15,6.85,2.76,7.11,6.38-1.42,19.76,1.83,41.97.01,61.43-.4,4.3-1.51,7.11-6.37,7.12l-124.89-.43c-1.37-1.22-3.1-2.41-3.06-4.43,1.81-20.37-2.27-44.52.02-64.43.38-3.26,1.84-4.84,5.07-5.42ZM345.5,293.19h-110.25v50.15h110.25v-50.15Z"/>
                            <path d="M298.03,255.92l54.54-.11c6.3.99,6.3,10.89,0,11.88h-53.91c-6.56-1.03-6.89-10.02-.63-11.77Z"/>
                            <path d="M227.53,255.92c2.34-.52,14.59-.5,16.76.18,5.36,1.68,5.01,10.63-1.21,11.6-2.63.41-13.81.41-16.12-.29-5.42-1.65-5.15-10.2.57-11.48Z"/>
                            <path d="M262.79,255.93c2.39-.53,14.52-.51,16.75.17,5.62,1.71,5.17,10.59-1.21,11.6-2.56.4-13.89.4-16.12-.29-5.21-1.63-4.94-10.25.57-11.48Z"/>
                            <path d="M88.04,306.08c10.64-2.36,9.08,13.49,8.49,20.45-.95,11.18-11.69,11.49-12.79,2.24-.44-3.7-.5-18.53,1.5-21,.64-.79,1.81-1.47,2.81-1.69Z"/>
                            <path d="M128.54,306.08c3.85-.87,7.77.61,8.42,4.75.51,3.24.5,16.12-.13,19.25-1.45,7.18-10.84,6.02-11.81.9-.56-2.97-.47-17.74.03-20.89.33-2.07,1.38-3.53,3.49-4.01Z"/>
                            <path d="M173.96,87.88c-2.36-2.35-2.21-13.7-1.21-16.88,1.79-5.74,10.5-4.9,11.49.27.34,1.81.32,13.24-.14,14.8-1.09,3.74-7.45,4.5-10.13,1.82Z"/>
                            <path d="M220.04,67.29c10.99-2.49,10.2,16.62,6.25,20.47-10.66,10.41-14.98-18.49-6.25-20.47Z"/>
                            <path d="M251.54,303.09c10.7-2.41,9.07,15.09,8.49,21.95-.98,11.55-11.55,10.38-12.73,2.93-.57-3.62-.5-15.63.03-19.35.37-2.61,1.45-4.9,4.22-5.52Z"/>
                          </svg>
                          <span class="menu-text"> Kitchen</span>
                        </a>
                      </li>
                      <li class="">
                        <a href="#" class=""> 
                          
                          <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400">
                            <path d="M8,351.58c2.16-4.82,6.49-8.54,12-8.24,1.19-16.18-6.71-40.55,18.75-37.42v-17.59c0-2.87,5.36-6.49,6.04-7.63,1.56-2.61.54-17.96.68-22.34,1.28-41.6,2.99-83.35,4.56-124.94.8-21.23-4.59-45.65,17.21-57.68,2.81-1.55,17.66-8.25,20-8.38,4.5-.25,7.53,4.89,5.34,8.98-1.96,3.67-17.81,7.93-22.69,11.78-10.83,8.56-7.37,28.2-7.86,40.81-1.63,41.83-3.42,83.85-4.56,125.69-.22,8.14.59,16.31-.72,24.36h56.25v-99.56c0-.2-2-.51-3.33-2.29-3.34-4.48-3.35-16.47-2.6-21.97.62-4.58,4.02-8.07,8.16-9.82l168.22-.17c3.57.6,6.85,3.39,8.35,6.64,2.33,5.03,2.03,20.65-1.46,25.33-1.33,1.78-3.33,2.09-3.33,2.29v99.56h56.25c-1.38-16.29-.99-32.7-1.47-49.06-.99-33.62-2.49-67.38-3.81-100.99-.58-14.66,3.97-35.89-11.98-43.43-41.31-17.15-81.83-36.43-123.44-52.7-3.16-.42-6.29.02-9.28,1.06l-77.99,33.74c-3.46,1-7.34-1.74-7.52-5.38-.23-4.52,3.74-5.6,6.99-7.19,24.11-11.79,50.49-20.77,74.78-32.41,10.14-3.21,15.7-1.87,25.24,1.72,39.54,14.89,78.48,35.97,118.01,51.39,21.57,10.99,16.44,37.4,17.21,57.68,1.58,41.59,3.28,83.34,4.56,124.94.13,4.38-.89,19.74.68,22.34.68,1.14,6.04,4.76,6.04,7.63v17.59c25.46-3.12,17.56,21.24,18.75,37.42,5.51-.3,9.84,3.42,12,8.24v20.21c-2.72,4.4-5.91,8.21-11.59,8.26H58.59c-4.94.18-8.02-4.45-5.95-9,.31-.68,3.26-3,3.74-3h324.38v-12.73H19.25v12.73h13.88c4.11,0,6.92,10.73-.79,11.93-3.29.51-12.73.36-15.94-.47-4.15-1.08-6.13-4.45-8.39-7.72v-20.21ZM281,156.96H119v12.73h162v-12.73ZM182,181.66h-57v132.49c24.99-16.64,44.08-42.01,52.12-71.11,5.51-19.93,4.87-40.85,4.88-61.38ZM206.75,181.66h-13.5c.15,22.37,1.2,43.38-4.88,65.12-9.51,34.06-32.89,63.51-63.37,81.22v15.35h150v-15.35c-36.11-20.82-62.22-58.78-67.39-100.41-1.88-15.16-.37-30.66-.86-45.93ZM275,181.66h-57c-.02,20.56-.64,41.41,4.88,61.38,8.04,29.1,27.13,54.47,52.12,71.11v-132.49ZM113,290.95h-62.25v14.97c5.61-.25,11.65-.39,15.63,4.23.97,1.12,3.12,5.39,3.12,6.62v26.57h43.5v-52.4ZM349.25,290.95h-62.25v52.4h43.5v-26.57c0-1.23,2.15-5.5,3.12-6.62,3.98-4.62,10.02-4.48,15.63-4.23v-14.97ZM57.5,317.89h-25.5v25.45h25.5v-25.45ZM368,317.89h-25.5v25.45h25.5v-25.45Z"/>
                            <path d="M180.32,70.32c8-1.18,29.76-1.03,38.04-.19,5.3.54,10.64,3.47,12.03,8.95,1.09,4.26.9,24.55.36,29.59-.67,6.26-5.45,10.3-11.6,10.88-9.07.85-30.12.99-39.03-.03-5.74-.65-10.26-5.1-10.88-10.85s-.8-22.99.05-28.4,5.84-9.19,11.03-9.95ZM218.75,82.11h-37.5v25.45h37.5v-25.45Z"/>
                          </svg>
                          <span class="menu-text"> Banquet</span>
                        </a>
                      </li>
                      <li class="">
                        <a href="#" class=""> 
                          
                          <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400">
                            <path d="M48.42,297.12c-.08.42-.85,1.67-1.26,1.93-1.87,1.16-21.94,1.14-23.86,0-.85-.51-1.64-1.68-1.81-2.69l.02-160.43c-4.89-.72-8.28-4.15-8.96-9.12-1.35-9.94-1.01-36.09-.1-46.46.81-9.2,5.84-10.11,13.91-10.81L164.78,13.22l5.09-.56,140.52,57.24c6.29.28,12.1.68,12.79,8.19,1.48,16.15-1.14,34.59-.08,50.99-.91,5.73-8.09,6.32-8.24,6.88l.06,34.4c1.9,3.21,4.39,6.16,4.48,10.15,5.86-1.09,12.43-3.93,17.92-.34,2.14,1.4,3.87,5.25,5.64,5.59,15.12,2.91,41.17-8.3,43.7,16.21l.12,167.93c-.54,8.96-5.02,16.77-14.59,17.63h-143.02c-6.94-1.46-12.66-7.44-13.11-14.63v-172.56c3.09-21.88,29.12-12.72,44.44-14.56,4.39-9.96,13.69-7.25,22.25-5.6.79-2.45,1.69-4.64,2.81-6.95.52-1.06,2.39-2.67,2.39-2.86v-34.88H48.42v161.62ZM46.92,70.25h242.53l-120.95-49.49-121.58,49.49ZM315.65,78.5H20.73v48.75h294.92v-48.75ZM40.19,135.5h-10.48v156h10.48v-156ZM306.67,135.5h-10.48v30c3.33-1.43,7.12-.86,10.48,0v-30ZM334.36,201.5v-13.12c0-5.35-20.12,4.3-22.28-1.67-.88-2.44-.3-5.93-1.76-8.73-4-7.65-16.93-6.37-19.02,1.76-.63,2.43.37,7.52-2.02,8.53-5.92,2.51-14.75-3.24-20.79-1v14.25h65.87ZM260.26,194h-31.06c-1.39,0-5.41,4.37-4.88,6.36v172.53c.69,5.84,5.86,6.77,10.84,7.14,43.01,3.19,89.89-2.48,133.3,0,5.39-.2,10.17-3.59,10.1-9.38v-168.06c.86-2.57-3.56-8.6-5.64-8.6h-30.32v3.75h28.07c.91,0,3.93,2.61,3.41,4.09l-.2,170.88c-.89,1.87-2.49,3.05-4.66,2.83l-138.2-.38c-2.25-.73-3.06-3-2.98-5.26v-166.57c-.52-1.83,1.71-5.59,3.4-5.59h28.82v-3.75ZM260.26,206c-1.44-.93-20.5.7-23.95,0v161.25h129.5v-161.25h-23.95c-.25,0,.36,2.54-3.33,3.04-10-1.62-73.18,2.28-77.22-.73-.88-.65-.93-2.24-1.04-2.31Z"/>
                            <path d="M59.43,164.15l132.41.53c1.63,1.8,1.66,4.15,1.83,6.41,2.99,39.39-2.33,82.53,0,122.31-.05,2.01-.52,4.09-1.83,5.66l-133.33-.05-1.14-4.11.41-129.41,1.65-1.35ZM79.86,171.5h-14.22v56.25h55.39v-56.25h-14.22v17.62c0,.18-1.47,2.43-1.82,2.68-3.68,2.71-8.01-2.83-11.34-3.04-3.55-.23-7.51,5.24-11.53,3.36-.38-.18-2.26-2.08-2.26-2.24v-18.38ZM98.57,171.5h-10.48v10.5c4.06-2.75,6.43-2.74,10.48,0v-10.5ZM143.49,171.5h-14.22v56.25h56.14v-56.25h-14.97v18.38c0,6.5-11.87-1.24-13.79-1.12-3.28.21-8.48,6.31-11.7,2.65-.27-.3-1.46-2.84-1.46-3.04v-16.88ZM162.2,171.5h-10.48v10.5c4.06-2.75,6.43-2.74,10.48,0v-10.5ZM79.86,236h-14.22v55.5h55.39v-55.5h-14.22v17.62c0,1.42-2.79,3.14-4.25,3.18-2.41.06-6.8-3.95-8.97-4.14-2.92-.25-8.31,6.15-12.17,3.16-.44-.34-1.56-1.87-1.56-2.21v-17.62ZM98.57,236h-10.48v9.75c3.91-1.61,6.21-2.24,10.1.01l.38-9.76ZM143.49,236h-14.22v55.5h56.14v-55.5h-14.97v18.38c0,.67-2.85,2.49-3.99,2.44-2.81-.14-7.73-4.32-9.74-4.14s-6.91,4.35-8.99,4.17c-1.73-.15-4.23-3.22-4.23-4.71v-16.12ZM162.2,236h-10.48l.38,9.76c3.48-1.78,6.66-2.38,10.09,0v-9.75Z"/>
                            <path d="M251.8,235.4c2.08-.61,19.52-.55,22.34-.19,2.52.32,3.8,1.63,4.12,4.12.39,3.02.38,19.14-.37,21.46-.69,2.15-2.45,2.73-4.52,2.97-3.31.39-17.97.46-20.63-.35-1.97-.6-2.73-1.79-3-3.75-.33-2.49-.21-21.65.41-22.92.3-.63.98-1.15,1.65-1.35ZM269.99,242.75h-11.98v12.75h11.98v-12.75Z"/>
                            <path d="M251.8,272.9c2.08-.61,19.52-.55,22.34-.19,2.52.32,3.8,1.63,4.12,4.12.53,4.17.39,14.48,0,18.82-.13,1.42-.1,2.97-1.17,4.08-2.03,2.11-18.11,1.88-21.73,1.55-3.02-.27-5.16-.76-5.62-4.12-.33-2.49-.21-21.65.41-22.92.3-.63.98-1.15,1.65-1.35ZM269.99,280.25h-11.98v12.75h11.98v-12.75Z"/>
                            <path d="M277.3,337.07c-.83.83-2.75.86-3.91.96-3.04.26-21.26.32-22.56-.71-.91-.72-.95-1.61-1.08-2.66-.52-3.94-.53-17.16,0-21.07.49-3.59,3.19-3.83,6.37-4.12,3.56-.33,18.95-.57,20.98,1.54,1.07,1.11,1.04,2.66,1.17,4.08.28,3.06.36,20.66-.96,21.98ZM269.99,317.75h-11.98v12.75h11.98v-12.75Z"/>
                            <path d="M286.99,245.16l61.23-.17c5.56.04,6.44,7.53.77,8.3h-61.45c-4.81-.48-5.47-6.98-.55-8.13Z"/>
                            <path d="M286.99,282.66l61.23-.17c6.08.38,6.26,7.95,0,8.28-18.89-1.67-41.47,2.18-59.91,0-5.61-.66-6.62-6.13-1.32-8.1Z"/>
                            <path d="M286.99,320.16l61.23-.17c6.17.47,6.3,7.54,0,8.28-18.46,2.17-41.01-1.66-59.91,0-5.38-.27-6.67-6.35-1.32-8.1Z"/>
                            <path d="M125.3,91.41h85.01c4.97.76,4.19,15.97,3.37,19.56-.53,2.33-2.36,3.47-4.69,3.55l-83.08-.03c-1.01-.17-2.18-.96-2.69-1.81-1.18-1.98-1.16-17.65,0-19.59.35-.58,1.42-1.48,2.08-1.67ZM205.61,99.5h-74.85v6.75h74.85v-6.75Z"/>
                          </svg>
                          <span class="menu-text"> Store</span>
                        </a>
                      </li>
                      <li class=""> 
                        <a href="#" class="">
                          
                          <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400">
                            <path d="M161.45,8c13.21,1.68,26.66,14.16,29.94,26.95h44.16v26.95h55.39v71.86l32.17,5.61c-64.87,51.87-26.67,156.54,56.16,154.21-20.44,29.64-51.31,50.93-88.33,52.02v45.66H19.98V61.89h53.15v-25.82c0-.08,1.04-1.12,1.12-1.12h43.79c3.5-14.44,15.35-23.21,29.19-26.95,4.5.41,9.85-.56,14.22,0ZM169.68,58.15v-16.09c0-1.39-3.26-6.3-4.54-7.44-7.43-6.63-19.71-4.85-24.21,4.14-.37.73-1.94,5.15-1.94,5.54v13.85h-42.67v30.69h116.02v-30.69h-42.67ZM73.12,85.1h-30.69v283.7h225.31v-24.7c-65.97-11.32-105.48-84.47-78.49-146.23,14-32.04,43.64-56.41,78.49-61.86v-50.9h-32.19v26.95H73.12v-26.95ZM281.96,156.97c-64.13,3.33-99.94,77.47-63.49,130.47,24.49,35.6,80.89,47.66,115.69,20.19.6-.47,1.38.02.94-1.7-57.91-20.95-84.46-95.78-53.14-148.96Z"/>
                            <path d="M127.49,132.31l15.29,14.51.62,2.13-42.96,43.18-26.52-27.21,15.39-15.39c1.73-.31,7.99,8.31,10.01,9.35.58.3.92.5,1.48,0l26.68-26.56Z"/>
                            <path d="M127.49,206.42c1.12-.2,14.59,13.63,15.94,15.94l-43.63,43.09-25.22-24.99c-.62-.61-.85-1.27-.62-2.13.58-2.22,13.23-12.59,15.37-15.44,1.42-.25,9.23,9.05,11.13,10.41l27.05-26.88Z"/>
                            <path d="M127.49,279.77c1.12-.2,14.59,13.63,15.94,15.94l-43.63,43.09-25.87-26.42,16.04-16.18,10.48,10.45,27.05-26.88Z"/>
                          </svg>
                          <span class="menu-text"> Night Audit</span>
                        </a> 
                      </li>
                      <div class="last-item">
                          <li class=""> 
                            <a href="#" class="">
                            
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400">
                              <path d="M305.17,392h-42.67c-3.2-1.79-6.23-3.32-7.52-7.07-1.19-3.47-1.33-14.9-2.93-16.53-.26-.26-5.34-2.4-5.64-2.38-.82.07-10.22,8.38-13.32,9.65-5.48,2.24-8.35,1.22-12.88-2.37-5.79-4.57-20.87-19.67-25.44-25.46-3.44-4.36-4.43-7.33-2.23-12.73,1.5-3.68,9.51-11.27,9.37-13.78-.04-.72-1.77-4.94-2.27-5.3-1.86-1.37-11.87-1.52-15.38-2.59-6.33-1.93-8.11-6.96-8.6-13.11-.67-8.45-.74-23.82.04-32.2.62-6.66,2.78-11.16,9.55-12.9,2.73-.71,13.69-1.19,14.77-2.45,2.98-3.47,1.73-8.29-1.89-10.85l-48.17-.28c-2.1,3.1-3.02,7.08-5.12,10.6-18.08,30.35-66.51,23.8-75.56-10.6l-52.6-.17c-4.12-.49-6.78-4.06-8.68-7.42v-7.49c1.83-3.54,4.65-6.51,8.66-7.44l52.62-.15c9.19-34.5,58.03-40.99,75.83-10.13,1.26,2.19,3.32,8.71,3.98,9.5.6.73,1.34.8,2.22.78l45.55-.19,24.85-24.55c10.44-7.79,16.64,4.73,23.62,7.86,1.58.71,6.89-1.27,7.32-1.99.68-1.11,1.11-11.49,1.83-14.27,1.52-5.91,5.46-8.75,11.48-9.48,8.1-.98,26.07-.82,34.38-.11,5.51.47,10.85,2.67,12.57,8.39,1.04,3.45,1.02,13.64,2.36,15.6.79,1.16,5.65,2.5,7.08,1.86,6.99-3.12,12.09-14.75,22.76-8.49,2.73,1.6,26.25,25.13,28.57,28.31,2.81,3.84,3.28,8.14,1.26,12.53-1.15,2.49-9.58,11.38-9.68,12.56-.02.31,2.2,5.4,2.4,5.63,2.59,3.02,20.4-1.16,23.24,9.7l.19,43.65c-3.29,10.52-14.84,6.73-21.92,9.52-1.66.65-4.01,5.14-3.91,6.37.06.79,8.45,9.95,9.65,12.58,2.34,5.12,1.36,8.87-1.98,13.25-4.18,5.48-19.93,21.06-25.45,25.45-4.39,3.49-8.89,4.79-14.13,2.12-3.54-1.81-8.69-7.93-11.71-9.26-1.04-.45-6.03,1.92-6.74,3.75-2.86,7.34,1.08,18.56-9.73,22.08ZM291.69,199.63l-15.67.03c-1.13,5.38-.46,13.97-4.89,17.93-4.75,4.25-17.73,5.73-23.38,10.3-2.63.57-5.28.12-7.7-.94-3.43-1.5-7.02-6.12-9.73-7.54-.72-.38-.77-.37-1.49,0-.65.34-10.25,9.78-10.31,10.51,3.68,6.66,10.73,10.37,8.45,19.12-.44,1.68-8.38,20.21-9.23,21.46-4.47,6.59-12.4,4.08-18.91,6.67l.05,15.25c4.73.77,10.13.31,14.51,2.33,6.35,2.94,5.94,8.56,8.33,14.13,2.87,6.69,7.85,11.82,4.49,19.48-.91,2.07-7.9,9.61-7.53,10.47,2.37,1.5,8.76,9.9,10.67,10.4,1.68.44,8.29-6.26,11.15-7.33,7.49-2.79,11.28,1.51,17.54,4.02,5.92,2.37,13.79,3.14,16.08,10.12.65,1.98,1.41,13.38,2.29,13.53l15.28-.05c.93-5.74.19-13.13,4.47-17.62,2.99-3.14,9.73-4.48,14.01-6.2,8.74-3.51,10.9-8.08,20.7-1.5,2.06,1.38,5.6,5.86,7.97,4.76,2.49-1.15,7.63-8.64,10.48-10.51-3.23-3.91-8.65-8.9-9.01-14.19-.41-5.89,2.68-8.44,4.66-13.38,1.87-4.65,3.13-11.72,6.99-14.72,4.24-3.3,11.61-3.15,16.84-3.74l-.09-15.64c-5.54-1.55-13.06-.35-17.5-4.58-3.17-3.01-3.59-8.1-5.26-11.96-2.51-5.81-7.03-11.34-5.25-18,.82-3.09,8.88-11.41,8.29-12.71l-10.61-10.41c-1.15-.2-8.16,6.59-10.23,7.58-7.91,3.77-11.11-.88-17.75-3.5-4.45-1.76-11.4-2.82-14.62-6.34-3.82-4.18-3.2-11.91-4.09-17.24ZM108.88,211.81c-24.29.64-23.17,37.28.54,37.28s24.6-37.94-.54-37.28Z"/>
                              <path d="M8,136c2.37-4.42,5.78-6.84,10.85-7.49l134.66.05c11.5-39.46,68.47-39.79,79.91-.15l52.49.28c12.52,3.04,12.52,19.8,0,22.85l-52.49.28c-11.36,39.67-68.46,39.28-79.91-.15l-134.64.04c-5.41-.54-8.27-2.96-10.86-7.47v-8.23ZM189.7,121.96c-22.37,3.83-18.06,40.77,7.88,36.32,22.18-3.8,17.93-40.75-7.88-36.32Z"/>
                              <path d="M8,46.18c1.89-3.36,4.56-6.93,8.68-7.42l52.6-.17C78.33,4.25,126.73-2.4,144.83,27.98c2.1,3.52,3.02,7.5,5.12,10.6l136.15.09c12.22,2.2,12.25,20.27,0,22.49l-136.15.09c-2.1,3.1-3.02,7.08-5.12,10.6-18.09,30.37-66.54,23.69-75.56-10.6l-52.6-.17c-4.12-.49-6.78-4.06-8.68-7.42v-7.49ZM107.38,31.39c-27.97,3.33-16.73,47.54,10.41,35.13,17.87-8.17,10.2-37.58-10.41-35.13Z"/>
                              <path d="M278.05,243.25c55.52-6.39,64.42,74.78,12.43,82.04-57.82,8.08-64.61-76.04-12.43-82.04ZM279.52,266.42c-19.37,3.3-18.52,33.84,1.38,36.43,28,3.64,28.73-41.57-1.38-36.43Z"/>
                            </svg>
                            <span class="menu-text">Settings</span>
                            </a>
                          </li>
                        <li>
                          <a href="#"> 
                            
                            <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 400">
                              <path d="M268.49,392H82.11c-24.79-4.72-43.79-23.26-47.81-48.37l-.13-284.39c2.79-26.66,24.52-48.2,51.28-50.53,61.21.41,122.55-.66,183.67.54,12.88,5.1,11.82,23.12-1.81,26.38-61.01.76-122.25-1.21-183.14,1-11.06,2.67-19.45,11-22.06,22.1-1.5,94.4-1.78,189.52.14,283.89,3.89,14.27,14.91,21.38,29.22,22.42l176.47.18c13.61,4.3,13.51,21.53.55,26.77Z"/>
                              <path d="M320.14,213.85h-160.56c-.7,0-5.9-3.61-6.69-4.54-4.76-5.56-3.95-15.26,1.87-19.75.51-.39,4.55-2.66,4.83-2.66h160.56l-65.88-66.24c-8.61-14.33,8.02-28.31,20.9-17.91l86.91,86.75c6.05,6.12,6.26,15.05.37,21.36l-86.46,86.46c-12.84,11.57-30.75-2.12-21.71-17.22l65.87-66.25Z"/>
                            </svg>
                            <span class="menu-text text-danger">Logout</span>
                          </a>
                        </li>
                      </div>
                    </ul>
                  </div>
                  <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
                </nav>
              </div>
            </div>
          