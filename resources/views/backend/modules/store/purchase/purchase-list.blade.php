@extends('backend.layouts.main')
@section('main-container')
@section('title')
Purchase List
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Purchase List</h3>
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
          <!-- Room Type Name modal start -->
    <div class="modal fade" id="purchaseListEditModel" tabindex="-1" role="dialog" aria-labelledby="purchaseListEditModel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title roomName_title">Edit Purchase Quantity</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="">
                          <div class="modal-body">
                            <div class="row">
                                <input type="hidden" id="purchase_item_id">
                                <div class="col-12 mb-1">
                                    <label class="form-label" for="purchase_edit_id">Purchase Id</label>
                                    <input type="text" class="form-control form-control-sm" id="purchase_edit_id" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-1">
                                   <label class="form-label" for="purchase_edit_id">Item Name</label>
                                    <input type="text" class="form-control form-control-sm" id="purchase_edit_item" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                   <label class="form-label" for="purchase_edit_qty">Qty</label>
                                    <input type="number" class="form-control form-control-sm" id="purchase_edit_qty" oninput="validateField('#purchase_edit_qty','select','.purchase_edit_qty_class')">
                                      <div class="purchase_edit_qty_class"></div>
                                </div>
                            </div>
                        </div>
                            <div class="modal-footer">
                                <button class="btn btn-outline-secondary" type="button"
                                    data-bs-dismiss="modal" onclick="#">Cancel</button>
                                <button class="btn btn-primary purchaseItemUpdate" type="button"
                                    onclick="purchaseItemUpdate(document.getElementById('purchase_item_id').value)">Update</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Room Type Name modal end-->
        <div class="container-fluid">
            <div class="row">
                <!-- Zero Configuration  Starts-->
                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="hover row-border stripe" id="purchase-items-table">
                                    <thead>
                                        <tr>
                                            <th>PO.No.</th>
                                            <th>Item</th>
                                            <th>Qty</th>
                                            <th>Vendor</th>
                                            <th>Created By</th>
                                            <th>Date of Creation</th>
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
    const purchaseItemVeiw = "{{route('store.purchaseItemVeiw')}}";
    const getPurchaseItem = "{{route('store.getPurchaseItem')}}";
    const purchaseQtyUpdate = "{{route('store.purchaseQtyUpdate')}}";
</script>
{{-----------external js files added for page functions------------}}
  <script src="{{asset('backend/assets/js/custom/store/purchase.js')}}"></script>
   <script src="{{asset('backend/assets/js/custom/custom_backend.js')}}"></script>
@endsection