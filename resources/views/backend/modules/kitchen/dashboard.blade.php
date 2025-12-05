@extends('backend.layouts.main')
@section('title','Kitchen Dashboard')
@section('main-container')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Kitchen Dashboard</h3>
                    </div>
                    <div class="col-12 col-sm-6">
                        {{-- <div class="float-end">
                            <button class="btn btn-primary px-2 stock_add" type="button" onclick="stockAddPage()"><span class="btn-icon"><i class="ri-add-line"></i></span>
                                Add Stock</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
         <!-- Container-fluid starts-->
        <div class="container-fluid d-none">
          <div class="row">
              <div class="col-md-12 box-col-12">
                <div class="card o-hidden">
                    {{-- <div class="card-header">
                        <h3>Monthly  History</h3>
                    </div> --}}
                    <div class="bar-chart-widget">
                        <div class="bottom-content card-body">
                            <div class="row">
                                <div class="col-12">
                                <div id="chart-widget4"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
          </div>
        </div>
      <!-- Container-fluid Ends-->
      <div class="container-fluid">
          <div class="row"> 
            <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6"> 
              <div class="card widget-1">
                <div class="card-body"> 
                  <div class="widget-content">
                    <div class="widget-round secondary">
                      <div class="bg-round">
                        <svg class="svg-fill">
                          <use href="../assets/svg/icon-sprite.svg#cart"> </use>
                        </svg>
                        <svg class="half-circle svg-fill">
                          <use href="../assets/svg/icon-sprite.svg#halfcircle"></use>
                        </svg>
                      </div>
                    </div>
                    <div> 
                      <h4>00</h4><span class="f-light">Canceled KOT</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6"> 
              <div class="card widget-1">
                <div class="card-body"> 
                  <div class="widget-content">
                    <div class="widget-round primary">
                      <div class="bg-round">
                        <svg class="svg-fill">
                          <use href="../assets/svg/icon-sprite.svg#tag"> </use>
                        </svg>
                        <svg class="half-circle svg-fill">
                          <use href="../assets/svg/icon-sprite.svg#halfcircle"></use>
                        </svg>
                      </div>
                    </div>
                    <div> 
                      <h4>00</h4><span class="f-light">Complimentry KOTs</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
                <h3 class="d-block">Room KOT</h3>
              <!-- Zero Configuration  Starts-->
              <div class="col-lg-12 col-sm-12">
                  <div class="card">
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="hover row-border stripe" id="room-kot-table">
                                  <thead>
                                      <tr>  
                                          <th>Room No.</th>
                                          <th>Guest Name</th>
                                          <th>Status</th>
                                          <th>Amount</th>
                                          <th>Pending</th>
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
          <div class="row">
                <h3 class="d-block">Table KOT</h3>
              <!-- Zero Configuration  Starts-->
              <div class="col-lg-12 col-sm-12">
                  <div class="card">
                      <div class="card-body">
                          <div class="table-responsive">
                              <table class="hover row-border stripe" id="table-kot-table">
                                  <thead>
                                      <tr>  
                                          <th>Room No.</th>
                                          <th>Guest Name</th>
                                          <th>Status</th>
                                          <th>Amount</th>
                                          <th>Pending</th>
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
   
@endsection
@section('extra-js')
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    const getRoomKotData = "{{route('kitchen.getRoomKotData')}}";
    const getTableKotData = "{{route('kitchen.getTableKotData')}}";
</script>
{{-----------external js files added for page functions------------}}
  <script src="{{asset('backend/assets/js/custom/kitchen/dashboard.js')}}"></script>

@endsection