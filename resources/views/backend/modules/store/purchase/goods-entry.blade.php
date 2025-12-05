@extends('backend.layouts.main')
@section('title', 'Purchase Goods Entry')
@section('extra-css')
@endsection
@section('main-container')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title mt-2">
      <div class="row gx-0">
        <div class="col-12 col-sm-6">
          <h3 class="d-block">Goods Entry</h3>
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
                <label class="form-label fw-medium" for="purchaseAdd-vendor">Vendor: <strong>{{$purchase[0]->vendorData->name}}</strong></label>
                {{-- <input type="text" class="form-control form-control-sm" value="{{$vendor[0]}}" readonly> --}}
            </div>
            <div>
              <label class="form-label fw-medium" for="purchaseAdd-vendor">PO No.: <strong>{{$purchase[0]->purchase_id}}</strong></label>
            </div>
          </div>
            
        </div>
        <div class="col-md-12 mt-4">
          <div class="table-responsive scroll-sm items-table border rounded">
            <table class="table bordered-table sm-table mb-0 border-0">
              <thead>
                <tr>
                  <th>SNo</th>
                  <th>Item</th>
                  <th>Ordered Qty</th>
                  <th>Received Qty</th>
                  <th>Expiry Date</th>
                  <th>Unit</th>
                  {{-- <th>Action</th> --}}
                </tr>
              </thead>
              <tbody>
                @php
                  $i =1;
                @endphp
                @foreach ($purchaseItems as $items)
                  <tr>
                    <input type="hidden" id="purchase_data_id" name="purchase_date_id[]" value="{{$items->id}}">
                    <td>{{$i}}</td>
                    <td>{{$items->itemData->name}}</td>
                    <td>{{$items->expected_qty}}</td>
                    @php
                      $qty = $items->expected_qty - $items->received_qty;
                    @endphp
                      <td><input type="number" class="form-control form-control-sm" style="width: 100px;" name="purchase_received_qty[]" value="0" oninput="maxqty({{$qty}},this);addReceivedData({{$items->id}},this.value,{{$items->received_qty}})"{{$qty == 0 ? 'disabled':''}}></td>
                    <td><input type="date" class="form-control form-control-sm" name="purchase_expiry_date[]" value="" min="{{date('Y-m-d')}}" style="width: 160px;"/></td>
                    <td>{{$items->unit}}</td>
                  </tr>
                  @php
                    $i++;
                  @endphp
                @endforeach
                </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-12 d-flex justify-content-end mt-3">
          <button type="button" class="btn btn-success btn-sm fw-medium m-2 purchaseReceivedSubmit" onclick="receivedQtyUpdate(`{{$purchase[0]->purchase_id}}`)">
            Mark In
          </button>
          <button class="btn btn-success btn-sm fw-medium m-2 purchaseReceivedSpinn d-none" type="button">
            Please Wait...
          </button>
        </div>
        @if(count($item_inwards) > 0)
          <h4> Logs</h4>
          <div class="col-md-12 mt-4">
            <div class="table-responsive scroll-sm items-table border rounded">
              <table class="table bordered-table sm-table mb-0 border-0">
                <thead>
                  <tr>
                    <th>SNo</th>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $i =1;
                  @endphp
                  @foreach ($item_inwards as $item_list)
                    <tr>
                      <td>{{$i++}}</td>
                      <td>{{$item_list['item']}}</td>
                      <td>{{$item_list['qty']}}</td>
                      <td>{{$item_list['date']}}</td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        @endif
    </div>
  </div>
</div>
@endsection

@section('extra-js')

<script>
    const purchaseAddSubmit = "{{route('store.purchaseAddSubmit')}}";
    const receivedQuantityUpdate = "{{route('store.receivedQuantityUpdate')}}";
    const purchaseOrder = "{{route('store.purchaseOrder')}}";
    const purchaseOrderVeiw = "{{route('store.purchaseOrderVeiw')}}";
</script>
    <script src="{{ asset('backend/assets/js/custom/store/purchase-order.js') }}"></script>
    <script src="{{asset('backend/assets/js/custom/custom_backend.js')}}"></script>
@endsection