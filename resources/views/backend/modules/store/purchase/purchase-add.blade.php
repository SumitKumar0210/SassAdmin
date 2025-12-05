@extends('backend.layouts.main')
@section('title', 'Add Purchase')
@section('extra-css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('main-container')
<div class="page-body">
    <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Add Purchase Items</h3>
                    </div>
                </div>
            </div>
        </div>

  {{-- Items Section --}}
  <div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <label class="form-label fw-medium" for="purchaseAdd-vendor">Vendor</label>
                <select id="purchaseAdd-vendor" class="form-control form-control-sm select2-cls" onchange="validateField('#purchaseAdd-vendor','select','.purchaseAdd-vendor_class')">
                    <option value="">Select</option>
                    @foreach ($vendors as $vendor)
                        <option value="{{$vendor->id}}">{{$vendor->name}}</option>
                    @endforeach
                </select>
                <div class="purchaseAdd-vendor_class"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label class="form-label fw-medium" for="purchaseAdd-item">Item Name/Code</label>
                <select id="purchaseAdd-item" class="form-control form-control-sm select2-cls">
                    <option value="">Select</option>
                    @foreach ($materials as $raw_material)
                        <option value="{{$raw_material['id']}}" data-uom="{{$raw_material['uom']}}">{{$raw_material['name']}} ({{$raw_material['code']}})</option>
                    @endforeach
                </select>
                <div class="purchaseAdd-item_class"></div>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-medium" for="purchaseAdd-itemQty">Quantity</label>
                <input type="number" id="purchaseAdd-itemQty" class="form-control form-control-sm" placeholder="Qty" oninput="validateField('#purchaseAdd-itemQty','select','.purchaseAdd-itemQty_class')">
                <div class="purchaseAdd-itemQty_class"></div>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-success btn-sm fw-medium" style="margin-top: 27px;" onclick="addItems()">
                    <i class="ri-add-line"></i> Add Item
                </button>
            </div>
        </div>
        <div class="col-md-12 mt-4 itemAddShow d-none">
          <div class="table-responsive scroll-sm items-table border rounded">
            <table class="table bordered-table sm-table mb-0 border-0">
              <thead>
                <tr>
                  <th>Sr.No.</th>
                  <th>Item</th>
                  <th>Quantity</th>
                  <th>Unit</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody class="appendItemData">
                {{-- Dynamically appended rows --}}
                </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-12 d-flex justify-content-end mt-3 itemAddShow d-none">
          <button type="button" class="btn btn-success btn-sm fw-medium m-2 purchaseAddSubmit" onclick="purchaseItemsBulkSubmit()">
           Submit
          </button>
          <button class="btn btn-success btn-sm fw-medium m-2 purchaseAddSpinn d-none" type="button">
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
    const purchaseItemVeiw = "{{route('store.purchaseItemVeiw')}}";
    const purchaseAddSubmit = "{{route('store.purchaseAddSubmit')}}";
    const purchaseOrder = "{{route('store.purchaseOrder')}}";
</script>
    <script src="{{ asset('backend/assets/js/custom/store/purchase.js') }}"></script>
    <script src="{{asset('backend/assets/js/custom/custom_backend.js')}}"></script>
@endsection