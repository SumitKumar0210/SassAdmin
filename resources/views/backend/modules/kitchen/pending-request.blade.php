@extends('backend.layouts.main')
@section('title','Kitchen Pending Request')
@section('main-container')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Pending Request List</h3>
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
        <div class="container-fluid">
            <div class="row">
                <!-- Zero Configuration  Starts-->
                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="hover row-border stripe" id="pending-request-table">
                                    <thead>
                                        <tr>  
                                            <th>STR No.</th>
                                            <th>Requested Item</th>
                                            <th>Request From</th>
                                            <th>Created By</th>
                                            <th>Date of creation</th>
                                            <th>Status</th>
                                            <th>Return</th>
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
    const pendingRequestVeiw = "{{route('kitchen.pendingRequestVeiw')}}";
</script>
{{-----------external js files added for page functions------------}}
  <script src="{{asset('backend/assets/js/custom/kitchen/pending-request.js')}}"></script>
@endsection