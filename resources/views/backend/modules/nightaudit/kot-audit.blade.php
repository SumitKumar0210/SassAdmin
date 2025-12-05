@extends('backend.layouts.main')
@section('title','Nightaudit Kot Audit')
@section('main-container')
 <div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6 p-0">
                    <h3>KOT Audit</h3>
                </div>
                <div class="col-12 col-sm-6 p-0 text-end">
                    <button class="btn btn-primary ms-2" type="button" onclick="exportKotAudit()"><i class="ri-file-excel-line" ></i> Export Summary</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row mb-3">
           <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6"> 
                <div class="card widget-1">
                  <div class="card-body"> 
                    <div class="widget-content">
                      <div class="widget-round secondary">
                        <div class="bg-round">
                          <svg class="svg-fill">
                            <use href="{{asset('backend/assets/svg/icon-sprite.svg#cart')}}"> </use>
                          </svg>
                          <svg class="half-circle svg-fill">
                            <use href="{{asset('backend/assets/svg/icon-sprite.svg#halfcircle')}}"></use>
                          </svg>
                        </div>
                      </div>
                      <div> 
                        <h4>{{$total_revenue}}</h4><span class="f-light">Total Revenue</span>
                      </div>
                    </div>
                    {{-- <div class="font-secondary f-w-600"><i class="icon-arrow-up icon-rotate me-1"></i><span>+50%</span></div> --}}
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
                            <use href="{{asset('backend/assets/svg/icon-sprite.svg#tag')}}"> </use>
                          </svg>
                          <svg class="half-circle svg-fill">
                            <use href="{{asset('backend/assets/svg/icon-sprite.svg#halfcircle')}}"></use>
                          </svg>
                        </div>
                      </div>
                      <div> 
                        <h4>{{$total_kot}}</h4><span class="f-light">Total KOT's</span>
                      </div>
                    </div>
                    {{-- <div class="font-primary f-w-600"><i class="icon-arrow-up icon-rotate me-1"></i><span>+70%</span></div> --}}
                  </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6"> 
                <div class="card widget-1">
                  <div class="card-body"> 
                    <div class="widget-content">
                      <div class="widget-round warning">
                        <div class="bg-round">
                          <svg class="svg-fill">
                            <use href="{{asset('backend/assets/svg/icon-sprite.svg#return-box')}}"> </use>
                          </svg>
                          <svg class="half-circle svg-fill">
                            <use href="{{asset('backend/assets/svg/icon-sprite.svg#halfcircle')}}"></use>
                          </svg>
                        </div>
                      </div>
                      <div> 
                        <h4>{{$total_item_order}}</h4><span class="f-light">Total Item Orders</span>
                      </div>
                    </div>
                    {{-- <div class="font-warning f-w-600"><i class="icon-arrow-down icon-rotate me-1"></i><span>-20%</span></div> --}}
                  </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-3 col-lg-6 box-col-6"> 
                <div class="card widget-1">
                  <div class="card-body"> 
                    <div class="widget-content">
                      <div class="widget-round success">
                        <div class="bg-round">
                          <svg class="svg-fill">
                            <use href="{{asset('backend/assets/svg/icon-sprite.svg#rate')}}"> </use>
                          </svg>
                          <svg class="half-circle svg-fill">
                            <use href="{{asset('backend/assets/svg/icon-sprite.svg#halfcircle')}}"></use>
                          </svg>
                        </div>
                      </div>
                      <div> 
                        <h4>{{$total_cancel_order}}</h4><span class="f-light">Cancelled KOT</span>
                      </div>
                    </div>
                    {{-- <div class="font-success f-w-600"><i class="icon-arrow-up icon-rotate me-1"></i><span>+70%</span></div> --}}
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
                        <h5 class="mb-2 f-dark">Cash Payment</h5>
                        <div class="d-block">
                          <h4 class="mb-2">{{$kots_cash}}</h4>
                          <h6 class="f-light f-14 f-w-600 d-block">{{$avg_cash}}%</h6>
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
                        <h5 class="mb-2 f-dark">Card Payment</h5>
                        <div class="d-block">
                          <h4 class="mb-2">{{$kots_card}}</h4>
                          <h6 class="f-light f-14 f-w-500">{{$avg_card}}%</h6>
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
                        <h5 class="mb-2 f-dark">UPI</h5>
                        <div class="d-block">
                          <h4 class="mb-2">{{$kots_upi}}</h4>
                          <h6 class="f-light f-14 f-w-500">{{$avg_upi}}%</h6>
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
                        <h5 class="mb-2 f-dark">Cancelled KOT</h5>
                        <div class="d-block">
                          <h4 class="mb-2">{{$total_cancel_order}}</h4>
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
                        <h5 class="mb-2 f-dark">Complimentory KOT</h5>
                        <div class="d-block">
                          <h4 class="mb-2">{{$is_complimentary}}</h4>
                          <h6 class="f-light f-14 f-w-500">Today</h6>
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
        <div class="row mb-3">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table hover row-border stripe table-sm" id="basic-1">
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
                                    @foreach ($roomKot as $item)
                                      <tr>
                                        <td>{{$item['room']}}</td>
                                        <td>{{$item['name']}}</td>
                                        <td class="font-@if($item['status'] == 'Paid') {{ 'success'}} @else{{ 'danger'}} @endif f-w-500">{{$item['status']}}</td>
                                        <td>{{$item['grand_total']}}</td>
                                        <td>{{$item['due']}}</td>
                                        <td> 
                                          <a href="#"><i class="icofont icofont-eye-alt fs-5"></i></a>
                                        </td>
                                      </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
    function exportKotAudit(){
      window.open('/nightaudit/kot-audit-print');
    }
  </script>
@endsection
