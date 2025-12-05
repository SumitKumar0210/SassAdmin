@extends('backend.layouts.main')
@section('main-container')
@section('title')
Store Deficiency Report
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Deficiency Report List</h3>
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
                                <table class="hover row-border stripe" id="deficiency-report-table">
                                    <thead>
                                        <tr>  
                                            <th>Item Name</th>
                                            <th>Unit</th>
                                            <th>Qty</th>
                                            <th>Minimum Limit</th>
                                            <th>Maximum Limit</th>
                                            {{-- <th>Opening Balance</th>
                                            <th>Closing Balance</th> --}}
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
    const deficiencyReportVeiw = "{{route('store.deficiencyReportVeiw')}}";
</script>
{{-----------external js files added for page functions------------}}
  <script src="{{asset('backend/assets/js/custom/store/deficiency-report.js')}}"></script>
@endsection