@extends('backend.layouts.main')
@section('title', 'kitchen Transfer Request')
@section('extra-css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('main-container')
<div class="page-body">
    <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Kitchen Transfer Request</h3>
                    </div>
                </div>
            </div>
        </div>

  {{-- Items Section --}}
  <div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <label class="form-label fw-medium" for="kitchen_transfer_item">Item Name/Code</label>
                <select id="kitchen_transfer_item" class="form-control form-control-sm select2-cls">
                    <option value="">Select</option>
                    @foreach ($materials as $raw_material)
                        <option value="{{$raw_material['id']}}" data-uom="{{$raw_material['uom']}}" data-uom_id="{{$raw_material['uom_id']}}" data-expiry="{{$raw_material['expiry']}}">{{$raw_material['name']}} ({{$raw_material['code']}}) - {{$raw_material['expiry']}}</option>
                    @endforeach
                </select>
                <div class="kitchen_transfer_item_class"></div>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-medium" for="kitchen_transfer_itemQty">Quantity</label>
                <input type="number" id="kitchen_transfer_itemQty" class="form-control form-control-sm" placeholder="Qty" oninput="validateField('#kitchen_transfer_itemQty','select','.kitchen_transfer_itemQty_class')">
                <div class="kitchen_transfer_itemQty_class"></div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success btn-sm fw-medium" style="margin-top: 27px;" onclick="addTransferItems()">
                    <i class="ri-add-line"></i> Add Item
                </button>
            </div>
        </div>
        <div class="col-md-12 mt-4 showItemAdd d-none">
          <div class="table-responsive scroll-sm items-table border rounded">
            <table class="table bordered-table sm-table mb-0 border-0">
              <thead>
                <tr>
                  <th>Sr.No.</th>
                  <th>Item</th>
                  <th>Expiry Date</th>
                  <th>Quantity</th>
                  <th>Unit</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="appendkitchenTransferData">
                {{-- Dynamically appended rows --}}
                </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-12 d-flex justify-content-end mt-3 showItemAdd d-none">
          <button type="button" class="btn btn-success btn-sm fw-medium m-2 transferRequestAddSubmit" onclick="kitchenTransferBulkSubmit()">
            Submit Request
          </button>
          <button class="btn btn-success btn-sm fw-medium m-2 transferRequestAddSpinn d-none" type="button">
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
    const transferRequestSubmit = "{{route('kitchen.transferRequestSubmit')}}";
    const transferRequest = "{{route('kitchen.pendingRequest')}}";
</script>
    <script src="{{ asset('backend/assets/js/custom/kitchen/transfer-request.js') }}"></script>
     <script src="{{asset('backend/assets/js/custom/custom_backend.js')}}"></script>
@endsection