@extends('backend.layouts.main')
@section('title','Kitchen Kot Monitor')
@section('main-container')
 <div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-md-4 p-0">
                    <h3>KOT Monitor</h3>
                </div>
                <div class="col-md-4 offset-md-4">
                  <div class="d-flex justify-content-end align-items-center">
                    <button class="btn btn-outline-secondary btn-sm me-3 loadKot" type="button" onclick="loadKotMonitor('Pending',this)">Running KOT</button>
                    <button class="btn btn-outline-primary btn-sm me-3 loadKot" type="button" onclick="loadKotMonitor('',this)">All</button>
                    <button class="btn btn-outline-success btn-sm loadKot" type="button" onclick="loadKotMonitor('Delivered',this)">Previous KOT</button>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                      <div class="row d-flex flex-wrap align-items-stretch">
                        <div class="col-12">
                          <h3 class="fw-normal mb-3 kot-status">Running KOT</h3>
                        </div>
                        <div class="kot-monitor-data row">
                          {{-- data appended here using js --}}
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
   $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
  const getKotDetails = "{{route('kitchen.kot-monitor-data')}}";
  const markKotDelivered = "{{route('kitchen.markKotDelivered')}}";
</script>
{{-----------external js files added for page functions------------}}
  <script src="{{asset('backend/assets/js/custom/kitchen/kot-monitor.js')}}"></script>
@endsection