@extends('backend.layouts.main')
@section('title',' Dashboard')
@section('main-container')
 <div class="page-body">
    <div class="container-fluid">        
      <div class="page-title">
        <div class="row">
          <div class="col-12 col-sm-12 p-0"> 
            <h3>Dashboard </h3>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid starts-->
      <div class="container-fluid default-dashboard">
        <div class="row">
          <div class="col-md-12 mb-4">
            <div class="row g-sm-3 height-equal-2 widget-charts ">
              <div class="col-sm-3"> 
                <div class="card small-widget mb-sm-0">
                  <div class="card-body primary"> <span class="f-light">New Booking</span>
                    <div class="d-flex align-items-end gap-1">
                      <h4>{{$new_booking}}</h4><span class="font-primary f-14 f-w-600"><i class="icon-arrow-up"></i><span>{{$new_booking_yes}}%</span></span>
                    </div>
                    <div class="bg-gradient"> 
                      <i class="ri-calendar-line f-20 fw-normal"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3"> 
                <div class="card small-widget mb-sm-0"> 
                  <div class="card-body warning"><span class="f-light">Check-in</span>
                    <div class="d-flex align-items-end gap-1">
                      <h4>{{$check_ins}}</h4><span class="font-warning f-14 f-w-600"><i class="icon-arrow-up"></i><span>{{round($check_ins_per,2)}}%</span></span>
                    </div>
                    <div class="bg-gradient"> 
                        <i class="ri-login-box-line f-20 fw-normal"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3"> 
                <div class="card small-widget mb-sm-0"> 
                  <div class="card-body secondary"><span class="f-light">Check-out</span>
                    <div class="d-flex align-items-end gap-1">
                      <h4>{{$check_outs}}</h4><span class="font-secondary f-14 f-w-600"><i class="icon-arrow-down"></i><span>{{round($check_outs_per,2)}}%</span></span>
                    </div>
                    <div class="bg-gradient"> 
                      <i class="ri-logout-box-r-line f-20 fw-normal"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-3"> 
                <div class="card small-widget mb-sm-0"> 
                  <div class="card-body success"><span class="f-light">Total Revenue</span>
                    <div class="d-flex align-items-end gap-1">
                      <h4>₹ {{$revenue}}</h4><span class="font-success f-14 f-w-600"><i class="icon-arrow-up"></i><span>0%</span></span>
                    </div>
                    <div class="bg-gradient"> 
                      <i class="ri-money-rupee-circle-line f-20 fw-normal"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-12 mt-4">
                <div class="card mb-1">
                  <div class="card-body reservation-list">
                    <div class="legend d-none d-sm-flex mt-2 mb-2 filter-parameter ">
                      <button class="btn btn-primary ms-2 " type="button" onclick="categoryFilter('')"> All </button>
                    </div>
                    <hr>
                    <div class="category-filter-list"></div>
                    <div class="reservation-itemlist-wrapper py-3 room_detail_views_dashboard mt-3 mb-5"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-9 ">
          <!--  Reservation chart start-->
            <div class="col-md-12">
              <div class="small-chart-widget chart-widgets-small">
                <div class="card">
                  <div class="card-header card-no-border">
                    <h3>Reservation</h3>
                  </div>
                  <div class="card-body pt-0">
                    <div class="chart-container">
                      <div class="row">
                        <div class="col-12">
                          <div id="reservation-chart"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Reservation chart end -->
          </div>
          <!-- side area start -->
          <div class="col-md-3">
              <div class="row">
                
                
                <div class="col-md-12">
                  <div class="card p-3">
                    <h3 class="mb-2 fw-normal">Room Availability</h3>
                    <div class="bar-container">
                      <div class="occupied"></div>
                      <div class="reserved"></div>
                      <div class="available"></div>
                      <div class="not-ready"></div>
                    </div>
                    <div class="status-grid">
                      <div class="status">
                        <div class="status-bar occupied-bar"></div>
                        <div>
                          <div class="status-text">Occupied</div>
                          <div class="status-value">{{$occupied}}</div>
                        </div>
                      </div>
                      <div class="status">
                        <div class="status-bar reserved-bar"></div>
                        <div>
                          <div class="status-text">Reserved</div>
                          <div class="status-value">{{$new_booking}}</div>
                        </div>
                      </div>
                      <div class="status">
                        <div class="status-bar available-bar"></div>
                        <div>
                          <div class="status-text">Available</div>
                          <div class="status-value">{{$available}}</div>
                        </div>
                      </div>
                      <div class="status">
                        <div class="status-bar not-ready-bar"></div>
                        <div>
                          <div class="status-text">Not Ready</div>
                          <div class="status-value">{{$not_ready}}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
    
                <div class="col-md-12 d-none">
                  <div class="card">
                    <div class="card-header card-no-border">
                      <div class="header-top">
                        <h3 class="m-0">Recent Activities</h3>
                      </div>
                      {{-- <div class="card-header-right">
                        <ul class="list-unstyled card-option">
                          <li>
                            <div><i class="icon-settings"></i></div>
                          </li>
                          <li><i class="view-html fa fa-code"></i></li>
                          <li><i class="icofont icofont-maximize full-card"></i></li>
                          <li><i class="icofont icofont-minus minimize-card"></i></li>
                          <li><i class="icofont icofont-refresh reload-card"></i></li>
                          <li><i class="icofont icofont-error close-card"></i></li>
                        </ul>
                      </div> --}}
                    </div>
                    <div class="card-body pt-0">
                      <!-- <div class="order-box"> 
                        <div class="d-flex">
                          <div class="flex-shrink-0"><img src="../assets/images/dashboard-2/total-icon/headphones.png" alt=""></div>
                          <div class="flex-grow-1"> <a href="chat.html"> 
                              <h3>Old Reis Telephone</h3>
                              <p>Sold by Vingate Techies</p>
                              <p>#BK739200</p></a></div><span>$30</span>
                        </div>
                      </div> -->
                      <ul class="track-order">
                        <li> 
                          <div class="d-flex">
                            <div class="flex-shrink-0 bg-dark">
                              <!-- <img src="/assets/images/dashboard-2/total-icon/1.png" alt=""> -->
                                <i class="ri-user-community-line f-16 fw-normal"></i>
                            </div>
                            <div class="flex-grow-1"> 
                              <div class="d-flex justify-content-between"> <a href="chat.html"> 
                                  <h5>Confrence Room</h5>
                                  <p class="text-truncate">Lorem Ipsum is simply dummy  </p></a><span class="font-primary f-w-600">10:00 AM</span></div>
                            </div>
                          </div>
                        </li>
                        <li> 
                          <div class="d-flex">
                            <div class="flex-shrink-0 bg-dark">
                              <!-- <img src="../assets/images/dashboard-2/total-icon/2.png" alt=""> -->
                                <i class="ri-logout-box-r-line f-16 fw-normal"></i>
                            </div>
                            <div class="flex-grow-1"> 
                              <div class="d-flex justify-content-between"> <a href="chat.html"> 
                                  <h5>Guest Check-Out</h5>
                                  <p class="text-truncate">Lorem Ipsum is simply dummy  </p></a><span class="font-primary f-w-600">11:30 AM</span></div>
                            </div>
                          </div>
                        </li>
                        <li> 
                          <div class="d-flex">
                            <div class="flex-shrink-0 ">
                              <!-- <img src="../assets/images/dashboard-2/total-icon/3.png" alt=""> -->
                                <i class="ri-check-line f-16 fw-normal"></i>
                            </div>
                            <div class="flex-grow-1"> 
                              <div class="d-flex justify-content-between"> <a href="chat.html"> 
                                  <h5>Room Cleaning Completed</h5>
                                  <p class="text-truncate">Lorem Ipsum is simply dummy  </p></a><span class="font-primary f-w-600">12:30 PM</span></div>
                            </div>
                          </div>
                        </li>
                        <li> 
                          <div class="d-flex">
                            <div class="flex-shrink-0">
                              <!-- <img src="../assets/images/dashboard-2/total-icon/4.png" alt=""> -->
                                !
                            </div>
                            <div class="flex-grow-1"> 
                              <div class="d-flex justify-content-between"> <a href="chat.html"> 
                                  <h5>Maintenance Request Logged</h5>
                                  <p class="text-truncate">Lorem Ipsum is simply dummy  </p></a><span class="font-primary f-w-600">01:30 PM</span></div>
                            </div>
                          </div>
                        </li>
                          <li> 
                          <div class="d-flex">
                            <div class="flex-shrink-0">
                              <!-- <img src="../assets/images/dashboard-2/total-icon/4.png" alt=""> -->
                                <i class="ri-login-box-line f-16 fw-normal"></i>
                            </div>
                            <div class="flex-grow-1"> 
                              <div class="d-flex justify-content-between"> <a href="chat.html"> 
                                  <h5>Guest Check-in</h5>
                                  <p class="text-truncate">Lorem Ipsum is simply dummy  </p></a><span class="font-primary f-w-600">02:30 PM</span></div>
                            </div>
                          </div>
                        </li>
                      </ul>
                      <div class="code-box-copy">
                        <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#track-order" title="" data-bs-original-title="Copy" aria-label="Copy"><i class="icofont icofont-copy-alt"></i></button>
                      </div>
                    </div>
                  </div>
                </div>
                  <div class=" col-md-12  pre-order d-none">
                    <div class="card">
                      <div class="card-header card-no-border pb-0"> 
                        <div class="header-top">
                          <h3>Task</h3>
                        </div>
                        {{-- <div class="card-header-right">
                          <ul class="list-unstyled card-option">
                            <li>
                              <div><i class="icon-settings"></i></div>
                            </li>
                            <li><i class="view-html fa fa-code"></i></li>
                            <li><i class="icofont icofont-maximize full-card"></i></li>
                            <li><i class="icofont icofont-minus minimize-card"></i></li>
                            <li><i class="icofont icofont-refresh reload-card"></i></li>
                            <li><i class="icofont icofont-error close-card"></i></li>
                          </ul>
                        </div> --}}
                      </div>
                      <div class="card-body py-0">
                        <ul class="message-box custom-scrollbar">
                          <li>
                            <div class="d-flex">
                              <div class="flex-shrink-0 bg-dark-color task-box"><i class="fa fa-check-circle"></i></div>
                              <div class="flex-grow-1 mx-2"> 
                                <a href="#"><h5 class="text-truncate">Lorem Ipsum is simply dummy text of the</h5></a>
                                  <p class="fw-semibold">Admin </p>
                                </div>
                                <span>June 23, 2025 </span>
                              </div>
                          </li>
                          <li>
                            <div class="d-flex">
                              <div class="flex-shrink-0 bg-primary task-box"><i class="fa fa-exclamation-circle"></i></div>
                              <div class="flex-grow-1 mx-2">
                                <a href="#"><h5 class="text-truncate">Lorem Ipsum is simply dummy text of the</h5></a>
                                  <p class="fw-semibold">Admin </p>
                                </div>
                                <span>June 23, 2025 </span>
                            </div>
                          </li>
                          <li>
                            <div class="d-flex">
                              <div class="flex-shrink-0 bg-secondary task-box"><i class="fa fa-times-circle"></i></div>
                              <div class="flex-grow-1 mx-2"> 
                                <a href="#"><h5 class="text-truncate">Lorem Ipsum is simply dummy text of the</h5></a>
                                  <p class="fw-semibold">Admin </p>
                                </div>
                                <span>June 23, 2025 </span>
                            </div>
                          </li>
                          <li>
                            <div class="d-flex">
                              <div class="flex-shrink-0 bg-dark-color task-box"><i class="fa fa-check-circle"></i></div>
                              <div class="flex-grow-1 mx-2">
                                <a href="#"><h5 class="text-truncate">Lorem Ipsum is simply dummy text of the</h5></a>
                                  <p class="fw-semibold">Admin </p>
                                </div>
                                <span>June 23, 2025 </span>
                            </div>
                          </li>
                          <li>
                            <div class="d-flex">
                              <div class="flex-shrink-0 bg-dark-color task-box"><i class="fa fa-check-circle"></i></div>
                              <div class="flex-grow-1 mx-2">
                                <a href="#"><h5 class="text-truncate">Lorem Ipsum is simply dummy text of the</h5></a>
                                  <p class="fw-semibold">Admin </p>
                                </div>
                                <span>June 23, 2025 </span>
                            </div>
                          </li>
                        </ul>
                        <div class="code-box-copy">
                          <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#message-box" title="" data-bs-original-title="Copy" aria-label="Copy"><i class="icofont icofont-copy-alt"></i></button>
                        </div>
                      </div>
                    </div>
                </div>
                {{-- <div class="col-md-12 "> 
                    <div class="card">
                      <div class="card-header card-no-border"> 
                        <div class="header-top">
                          <h3>Schedule a lesson</h3>
                        </div>
                        <div class="card-header-right">
                          <ul class="list-unstyled card-option">
                            <li>
                              <div><i class="icon-settings"></i></div>
                            </li>
                            <li><i class="view-html fa fa-code"></i></li>
                            <li><i class="icofont icofont-maximize full-card"></i></li>
                            <li><i class="icofont icofont-minus minimize-card"></i></li>
                            <li><i class="icofont icofont-refresh reload-card"></i></li>
                            <li><i class="icofont icofont-error close-card"></i></li>
                          </ul>
                        </div>
                      </div>
                      <div class="card-body pt-0 pb-0">
                        <div class="schedule-lesson"> 
                          <div class="default-datepicker"> 
                            <div class="datepicker-here" data-language="en"></div>
                          </div>
                        </div>
                        <div class="code-box-copy">
                          <button class="code-box-copy__btn btn-clipboard" data-clipboard-target="#schedule" title="" data-bs-original-title="Copy" aria-label="Copy"><i class="icofont icofont-copy-alt"></i></button>
                        </div>
                      </div>
                    </div>
                </div> --}}
              </div>
          </div>
          <!-- side area end -->
          {{-- <div class="col-md-12 dashboard-booking-list"> 
            <div class="card"> 
              <div class="card-header card-no-border py-2"> 
                <div class="header-top">
                  <h3 class="mt-2">Booking List</h3>
                  <div class="card-header-right-icon mt-2">
                    <div class="dropdown">
                      <button class="btn dropdown-toggle" id="dropdownMenuButton2" type="button" data-bs-toggle="dropdown" aria-expanded="false">All Status</button>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton2"><a class="dropdown-item" href="#">Checkin</a><a class="dropdown-item" href="#">Checkout</a><a class="dropdown-item" href="#">Waiting </a></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body pt-0 userinformation"> 
                <div class="table-responsive theme-scrollbar">
                  <table class="table display" id="information" style="width:100%">
                      <thead>
                        <tr>
                          <th>Booking ID</th>
                          <th>Guest Name</th>
                          <th>Room Type</th>
                          <th>Room Number</th>
                          <th>Duration</th>
                          <th>Checkin & Checkout</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($reservedRoom as $item)
                            <tr>
                              <td>{{$item['reservation_id']}}</td>
                              <td>{{$item['guest_name']}}</td>
                              <td>{{$item['room_type']}}</td>
                              <td>{{$item['room']}}</td>
                              <td>{{$item['duration']}} {{$item['days']}}</td>
                              <td>{{$item['checkin']}} @if($item['status'] != 'Checkin') - {{$item['checkout']}} @endif</td>
                              <td class="font-@if($item['status'] == 'Checkin')success @else danger @endif f-w-500">{{$item['status']}}</td>
                          </tr>
                        @endforeach
                        
                      </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div> --}}
      </div>
      </div>
    <!-- Container-fluid end-->
  </div>

  <div class="modal fade" id="reservationView" tabindex="-1" role="dialog" aria-labelledby="banquetBookingPaymentModel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"  style="width: 750px;">
            <div class="modal-toggle-wrapper  text-start dark-sign-up">
                <div class="modal-header">
                    <h4 class="modal-title roomCategory_title">Reservation</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body detail-reservation-dashboard"></div>
            </div>
        </div>
    </div>
  </div>
@endsection
@section('extra-js')
<script>
	const reservationViewLayout = "{{ route('reservation-layout.reservationViewLayout') }}";
</script>
<script>
   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  const getDashboardChart = "{{route('backend.dashboardChart')}}";
</script>
  <script src="{{asset('backend/assets/js/chart/apex-chart/stock-prices.js')}}"></script>
  <script src="{{asset('backend/assets/js/chart/apex-chart/moment.min.js')}}"></script>
  <script src="{{asset('backend/assets/js/custom/dashboard.js')}}"></script>
@endsection