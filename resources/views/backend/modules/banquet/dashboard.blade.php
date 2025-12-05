@extends('backend.layouts.main')
@section('title','Banquet Dashboard')
@section('main-container')
  <div class="page-body">
    <div class="container-fluid">        
      <div class="page-title">
        <div class="row">
          <div class="col-12 col-sm-6 p-0">
              <h3>Dashboard</h3>
          </div>
        </div>
      </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
      <div class="row mb-3">
        <div class="col-md-2">
          {{-- <div class="input-group"><span class="input-group-text" id="search"><i class="ri-search-2-line"></i></span>
            <input class="form-control" type="text" placeholder="Search" aria-label="Search" aria-describedby="search">
          </div> --}}
        </div>
        <div class="col-md-4 offset-md-6">
          <div class="d-flex justify-content-end align-items-center">
            <button class="btn btn-outline-primary btn-sm me-3 hallStatusFilter" type="button" onclick="drawHallDetail('',this)">All</button>
            <button class="btn btn-outline-secondary btn-sm me-3 hallStatusFilter" type="button" onclick="drawHallDetail('Occupied',this)">Occupied</button>
            <button class="btn btn-outline-success btn-sm me-3 hallStatusFilter" type="button" onclick="drawHallDetail('Available',this)">Available</button>
            <button class="btn btn-outline-danger btn-sm hallStatusFilter" type="button" onclick="drawHallDetail('Maintainance',this)">Maintainance</button>
          </div>
        </div>
      </div>
      {{-- hall status start --}}
      <div class="row mb-3">
        <div class="col-12">
          <div class="card py-2">
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-sm-12 mb-3">
                  <div class="d-flex justify-content-between align-items-center ">
                      <h3>Hall Booking Status : {{ date('d-m-Y')}}</h3>
                  </div>
                </div>
                <div class="col-12 col-sm-12 mb-3">
                  <div class="row hall_booking_detail"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        {{-- hall status end --}}
      {{-- calendar start --}}
      <div class="calendar-basic mb-5">
          <div class="card">
            <div class="card-body">
              <div class="row" id="wrap">
                <div class="col-xxl-3 box-col-4e">
                  <div class="md-sidebar mb-3"><a class="btn btn-primary md-sidebar-toggle" href="javascript:void(0)">calendar filter</a>
                    <div class="md-sidebar-aside job-left-aside custom-scrollbar">
                      <div id="external-events">
                        <h3>Events</h3>
                        <div id="external-events-list">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xxl-9 box-col-8">
                  <div class="calendar-default" id="calendar-container">
                    <div id="calendar"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      {{-- calendar end --}}
        
        <div class="row mb-3">
        {{-- top event start --}}
        <div class="col-md-6 col-sm-12">
          <div class="card">
            <div class="card-body p-3">
              <h3 class="mb-3">Top Event</h3>
              <table class="table table-dark-header table-hover">
                <thead>
                  <tr>
                    <th>Event Type</th>
                    <th>Counts</th>
                    <th>Revenue</th>
                  </tr>
                </thead>
                <tbody class="event_collection"></tbody>
              </table>
            </div>
          </div>
        </div>
        {{-- top event end --}}
        {{-- pre booking start --}}
        <div class="col-md-6 col-sm-12">
          <div class="card">
            <div class="card-body p-3">
              <h3 class="mb-3">Pre Booking Quater</h3>
              <table class="table table-dark-header table-hover">
                <thead>
                <tr>
                  <th>Quaters</th>
                  <th>Bookings</th>
                  <th>Amount</th>
                  <th>%</th>
                </tr>
                </thead>
                <tbody class="quarterly_data"></tbody>
              </table>
            </div>
          </div>
        </div>
        {{-- pre booking end --}}
        </div>
    </div>
  </div>
  <!-- Container-fluid end-->


@endsection
@section('extra-js') 
<script>
  const bookingDashboard = "{{ route('dashboard.getDashboardData') }}";
  const calendarDatesInfo = "{{ route('dashboard.calender-date-info') }}";
  const updateStatusHall = "{{ route('hall.update-status') }}";
</script>
<script src="{{asset('backend/assets/js/custom/banquet/booking_dashboard.js')}}"></script>
<script src="{{asset('backend/assets/js/calendar/fullcalendar.min.js')}}"></script>
<script src="{{asset('backend/assets/js/calendar/fullcalendar-custom.js')}}"></script>
@endsection