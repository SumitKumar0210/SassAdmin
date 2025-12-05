@extends('backend.layouts.main')
@section('title', 'Stock Request In')
@section('extra-css')
@endsection
@section('main-container')
<div class="page-body">
    <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Stock Request In</h3>
                    </div>
                </div>
            </div>
        </div>

  {{-- Items Section --}}
  <div class="card">
    <div class="card-body">
        <div class="row">
          <div class="d-flex justify-content-between">
            <div class="col-md-4">
                <label class="form-label fw-medium" for="purchaseAdd-vendor">Department: <strong>{{$store_request[0]->departmentData->name ?? 'NA'}}</strong></label>
                {{-- <input type="text" class="form-control form-control-sm" value="{{$vendor[0]}}" readonly> --}}
            </div>
            <div>
              <label class="form-label fw-medium" for="purchaseAdd-vendor">STR No.: <strong>{{$store_request[0]->str_no ?? 'NA'}}</strong></label>
            </div>
          </div>
            
        </div>
        <div class="col-md-12 mt-4">
          <div class="table-responsive scroll-sm items-table border rounded">
            <table class="table bordered-table sm-table mb-0 border-0">
              <thead>
                <tr>
                  <th>Sr.No.</th>
                  <th>Item</th>
                  <th>Expiry</th>
                  <th>Available Qty</th>
                  <th>Ordered Qty</th>
                  <th>Transferring Qty</th>
                  <th>Unit</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $i =1;
                @endphp
              @foreach ($store_request as $store)
              @php
                  $unit_name = \App\Models\Measurement::where('id', $store->unit)->pluck('name')->first();
                  $stock_qty = \App\Models\Stock::where('item_id', $store->item_id)->value('qty')
              @endphp
                  <tr>
                    <input type="hidden" id="stock_request_id" name="stock_request_id[]" value="{{$store->id}}">
                    <td>{{$i++}}</td>
                    <td>{{$store->itemData->name}}</td>
                    <td>{{date('d-m-Y',strtotime($store->expiry_date))}}</td>
                    <td>{{$stock_qty}}</td>
                    <td>{{$store->expected_qty}}</td>
                    <td><input type="number" class="form-control form-control-sm" style="width: 100px;" name="stock_request_received_qty[]" value="{{$store->received_qty ?? 0}}" onchange="maxqty({{$stock_qty}},this)" {{$store->status == 0 ? 'readonly':''}}></td>
                    <td>{{$unit_name}}</td>
                  </tr>
                @endforeach
                </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-12 d-flex justify-content-end mt-3">
          <button type="button" class="btn btn-success btn-sm fw-medium m-2 requestReceivedSubmit {{$store->status == 0 ? 'd-none':''}}" onclick="acceptStockRequest()">
            Accept
          </button>
          <button class="btn btn-success btn-sm fw-medium m-2 requestReceivedSpinn d-none" type="button">
            Please Wait...
          </button>
        </div>
    </div>
  </div>
</div>
@endsection
@section('extra-js')
<script>
    const stockReceivedQuantityUpdate = "{{route('store.stockReceivedQuantityUpdate')}}"
</script>
    <script src="{{ asset('backend/assets/js/custom/store/stock-request-in.js') }}"></script>
     <script src="{{asset('backend/assets/js/custom/custom_backend.js')}}"></script>
@endsection