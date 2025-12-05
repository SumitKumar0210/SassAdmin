@extends('backend.layouts.main')
@section('title', 'kitchen Return Request')
@section('extra-css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('main-container')
<div class="page-body">
    <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Kitchen Return Request</h3>
                    </div>
                </div>
            </div>
        </div>

  {{-- Items Section --}}
  <div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-2">
                <label class="form-label fw-medium" for="kitchen_return_item">Item Name/Code</label>
                <select id="kitchen_return_item" class="form-control form-control-sm select2-cls" onchange="validateField('#kitchen_return_item','select','.kitchen_return_item_class')">
                    <option value="">Select</option>
                    @foreach ($materials as $raw_material)
                        <option value="{{$raw_material['id']}}" data-uom="{{$raw_material['uom']}}" data-uom_id = "{{$raw_material['uom_id']}}" data-qty="{{$raw_material['max_qty']}}">{{$raw_material['name']}} ({{$raw_material['code']}})</option>
                    @endforeach
                </select>
                <div class="kitchen_return_item_class"></div>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-medium" for="kitchen_return_itemQty">Quantity</label>
                <input type="number" id="kitchen_return_itemQty" class="form-control form-control-sm" placeholder="Qty" oninput="validateField('#kitchen_return_itemQty','select','.kitchen_return_itemQty_class');validateQty(this)">
                <div class="kitchen_return_itemQty_class"></div>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-medium" for="kitchen_return_reason">Reason</label>
                <input type="text" id="kitchen_return_reason" class="form-control form-control-sm" placeholder="Reason" oninput="validateField('#kitchen_return_reason','select','.kitchen_return_reason_class')">
                <div class="kitchen_return_reason_class"></div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success btn-sm fw-medium addReturnItemsBtn" style="margin-top: 27px;" onclick="addReturnItems()">
                    <i class="ri-add-line"></i> Add Item
                </button>
            </div>
        </div>
        <div class="col-md-12 mt-4 showRequestView d-none">
          <div class="table-responsive scroll-sm items-table border rounded">
            <table class="table bordered-table sm-table mb-0 border-0">
              <thead>
                <tr>
                  <th>Sr.No.</th>
                  <th>Item</th>
                  <th>Quantity</th>
                  <th>Unit</th>
                  <th>Reason</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="appendkitchenReturnData">
                {{-- Dynamically appended rows --}}
                </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-12 d-flex justify-content-end mt-3 showRequestView d-none">
          <button type="button" class="btn btn-success btn-sm fw-medium m-2 returnRequestAddSubmit" onclick="kitchenReturnBulkSubmit(`{{$str_no}}`)"> Submit
          </button>
          <button class="btn btn-success btn-sm fw-medium m-2 returnRequestAddSpinn d-none" type="button">
            Please Wait...
          </button>
        </div>
    </div>
  </div>
</div>
@endsection

@section('extra-js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $('.select2-cls').select2();
    const returnRequestSubmit = "{{route('kitchen.returnRequestSubmit')}}";
    const transferRequest = "{{route('kitchen.pendingRequest')}}";
    // const returnRequestVeiw = "{{route('kitchen.returnRequestVeiw')}}";
</script>
    <script src="{{ asset('backend/assets/js/custom/kitchen/return-request.js') }}"></script>
    <script src="{{asset('backend/assets/js/custom/custom_backend.js')}}"></script>
    {{-- <script src="{{asset('backend/assets/js/custom/kitchen/return-request.js')}}"></script> --}}
@endsection