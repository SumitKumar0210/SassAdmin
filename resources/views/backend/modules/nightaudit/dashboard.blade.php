@extends('backend.layouts.main')
@section('title','Nightaudit Dashboard')
@section('main-container')
 <div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6 p-0">
                    <h3>Dashboard</h3>
                </div>
                <div class="col-12 col-sm-6 p-0 text-end">
                  <span class="time_duration d-none">{{$duration}}</span>
                    <button class="btn btn-primary ms-2" type="button" onclick="exportAllAudit()"><i class="ri-file-excel-line"></i> Export All Summary</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-sm-12">
                <div class="card">
                  <div class="card-header card-no-border pb-0">
                    <h4>Audit Progress Overview</h4>
                  </div>
                  <div class="card-body">
                    <div class="progress-showcase row">
                        <div class="col-lg-6 col-sm-12">
                            <h5 class="mb-2">Overall Progress</h5>
                            <div class="progress mb-3">
                                <div class="progress-bar-animated progress-bar-striped bg-success text-center" role="progressbar" style="width: {{$progress}}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">{{$progress}}%</div>
                            </div>
                            <h6 class="mb-2">{{$progress}}% Completed</h6>
                        </div>
                        <div class="col-lg-4 col-sm-12 offset-lg-2">
                            <h5 class="mb-2">Remaining Time</h5>
                            <h6 class="mb-2" id="timer">00:00:00</h6>
                            <i class="fa fa-stop-circle fs-2 stopTimer d-none" onclick="startAudit(2)"></i> 
                            <i class="fa fa-play-circle fs-2 d-none" id="startBtn" onclick="startAudit(1)"></i>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        {{-- second row start --}}
        <div class="row mb-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap mb-sm-4">
                    <div class="card small-widget w-100 mb-sm-0 me-sm-4">
                      <div class="card-body primary"> 
                        <h5 class="mb-2 f-dark">Occupancy</h5>
                        <div class="d-block">
                          <h4 class="mb-2">{{$room_occupied}}/{{$total_rooms}}</h4>
                          <h6 class="f-light f-14 f-w-600 d-block">{{round($booking_per)}}%</h6>
                        </div>
                        <div class="bg-gradient"> 
                          <svg class="stroke-icon svg-fill">
                            <use href="{{asset('backend/assets/svg/icon-sprite.svg#new-order')}}"></use>
                          </svg>
                        </div>
                      </div>
                    </div>
                    <div class="card small-widget w-100 mb-sm-0 me-sm-4">
                      <div class="card-body secondary"> 
                        <h5 class="mb-2 f-dark">Revenue</h5>
                        <div class="d-block">
                          <h4 class="mb-2">{{$revenue_room}}</h4>
                          <h6 class="f-light f-14 f-w-500">Room Revenue</h6>
                        </div>
                        <div class="bg-gradient"> 
                          <svg class="stroke-icon svg-fill">
                            <use href="{{asset('backend/assets/svg/icon-sprite.svg#new-order')}}"></use>
                          </svg>
                        </div>
                      </div>
                    </div>
                    <div class="card small-widget w-100 mb-sm-0 me-sm-4">
                      <div class="card-body warning"> 
                        <h5 class="mb-2 f-dark">Arrival</h5>
                        <div class="d-block">
                          <h4 class="mb-2">{{$arrival}}</h4>
                          <h6 class="f-light f-14 f-w-500">Tomorrow</h6>
                        </div>
                        <div class="bg-gradient"> 
                          <svg class="stroke-icon svg-fill">
                            <use href="{{asset('backend/assets/svg/icon-sprite.svg#new-order')}}"></use>
                          </svg>
                        </div>
                      </div>
                    </div>
                    <div class="card small-widget w-100 mb-sm-0 me-sm-4">
                      <div class="card-body success"> 
                        <h5 class="mb-2 f-dark">Departure</h5>
                        <div class="d-block">
                          <h4 class="mb-2">{{$departure}}</h4>
                          <h6 class="f-light f-14 f-w-500">Today</h6>
                        </div>
                        <div class="bg-gradient"> 
                          <svg class="stroke-icon svg-fill">
                            <use href="{{asset('backend/assets/svg/icon-sprite.svg#new-order')}}"></use>
                          </svg>
                        </div>
                      </div>
                    </div>
                    <div class="card small-widget w-100 mb-sm-0">
                      <div class="card-body secondary"> 
                        <h5 class="mb-2 f-dark">Revenue</h5>
                        <div class="d-block">
                          <h4 class="mb-2">{{$revenue_kot}}</h4>
                          <h6 class="f-light f-14 f-w-500">F&B Revenue</h6>
                        </div>
                        <div class="bg-gradient"> 
                          <svg class="stroke-icon svg-fill">
                            <use href="{{asset('backend/assets/svg/icon-sprite.svg#new-order')}}"></use>
                          </svg>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- second row end --}}
        <div class="row mb-3 audit-check-list d-none">
            <div class="col-sm-12">
                <div class="card">
                  <div class="card-header card-no-border pb-0">
                    <h4>Audit Check List</h4>
                  </div>
                  <div class="card-body">
                    <div class="progress-showcase row">
                        <div class="col-lg-8 col-sm-12">
                            <h5 class="mb-2">Financial Reconciliation</h5>
                            <ul class="flex-checks">
                                <li>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="parameter-1" type="checkbox" @if($guest_folio_review_status == 1) {{ 'checked'; }} @endif onclick="markAsDone(1)">
                                        <label class="form-check-label my-1" for="parameter-1">Guest Folio Review <a href="{{route('guest-folio.index')}}" target="_blank"><i class="ml-1 fa fa-external-link text-primary"></i></a></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="parameter-2" type="checkbox" @if($room_review_status == 1) {{ 'checked'; }} @endif onclick="markAsDone(2)">
                                        <label class="form-check-label my-1" for="parameter-2">Rooms/Inventory Review <a href="{{route('guest-folio.index')}}" target="_blank"><i class="ml-1 fa fa-external-link text-primary"></i></a></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="parameter-3" type="checkbox" @if($revenue_review_status == 1) {{ 'checked'; }} @endif onclick="markAsDone(3)">
                                        <label class="form-check-label my-1" for="parameter-3">Revenue Audit <a href="{{route('revenue-audit.index')}}" target="_blank"><i class="ml-1 fa fa-external-link text-primary"></i></a></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="parameter-4" type="checkbox" @if($closer_review_status == 1) {{ 'checked'; }} @endif onclick="markAsDone(4)">
                                        <label class="form-check-label my-1" for="parameter-4">Closure/House Keeping Review <a href="{{route('room-audit.index')}}" target="_blank"><i class="ml-1 fa fa-external-link text-primary"></i></a></label>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-check checkbox checkbox-primary mb-0">
                                        <input class="form-check-input" id="parameter-5" type="checkbox" @if($f_b_audit_status == 1) {{ 'checked'; }} @endif onclick="markAsDone(5)">
                                        <label class="form-check-label my-1" for="parameter-5">F&B Audit <a href="{{route('kot-audit.index')}}" target="_blank"><i class="ml-1 fa fa-external-link text-primary"></i></a></label>
                                    </div>
                                </li>
                            </ul>
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
@section('extra-js')
<script>
    function exportAllAudit(){
      window.open('/nightaudit/dashboard-print');
    }

    const updateProgressAudit = "{{ route('auditReport.updateProgress') }}";
    const updateAuditTime = "{{ route('auditReport.auditTime') }}";
</script>
<script src="{{asset('backend/assets/js/custom/audit/audit_report.js')}}"></script>
@endsection
