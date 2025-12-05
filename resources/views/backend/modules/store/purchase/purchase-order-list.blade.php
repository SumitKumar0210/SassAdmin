@extends('backend.layouts.main')
@section('main-container')
@section('title')
PO List
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Purchase Order List</h3>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="float-end">
                            <button class="btn btn-primary px-2 purchase_add" type="button" onclick="purchaseAddPage()"><span class="btn-icon"><i class="ri-add-line"></i></span>
                                Add Purchase</button>
                        </div>
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
                                <table class="hover row-border stripe" id="purchase-order-table">
                                    <thead>
                                        <tr>  
                                            <th>PO.No.</th>
                                            <th>Order Item</th>
                                            <th>Received Item</th>
                                            <th>Vendor Name</th>
                                            <th>Created By</th>
                                            <th>Date of Creation</th>
                                            <th>Status</th>
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
    const purchaseOrderVeiw = "{{route('store.purchaseOrderVeiw')}}";

</script>
{{-----------external js files added for page functions------------}}
  <script src="{{asset('backend/assets/js/custom/store/purchase-order.js')}}"></script>
@endsection