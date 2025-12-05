@extends('backend.layouts.main')
@section('main-container')
@section('title')
Store Transfer Report
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Transfer Report List</h3>
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
                                <table class="hover row-border stripe" id="transfer-report-table">
                                    <thead>
                                        <tr>  
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Item Name</th>
                                            <th>Qty</th>
                                            <th>Unit</th>
                                            <th>Date Of Request</th>
                                            <th>Date of Transfer</th>
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
    const transferReportVeiw = "{{route('store.transferReportVeiw')}}";
</script>
{{-----------external js files added for page functions------------}}
  <script src="{{asset('backend/assets/js/custom/store/transfer-report.js')}}"></script>
@endsection