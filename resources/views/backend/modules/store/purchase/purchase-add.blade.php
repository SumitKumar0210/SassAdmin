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
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label fw-medium" for="purchaseAdd-vendor">Vendor</label>
                {{-- <select id="purchaseAdd-vendor" class="form-control form-control-sm select2-cls" onchange="validateField('#purchaseAdd-vendor','select','.purchaseAdd-vendor_class')">
                    </select> --}}
                

                <div class="select-box select-box1">
                  <div class="options-container options-container1">
                    @foreach ($vendors as $vendor)
                    <div class="selection-option selection-option1">
                      <input class="radio" id="{{$vendor->id}}" value="{{$vendor->id}}" type="radio" name="puchase_vendor">
                      <label class="mb-0" for="{{$vendor->id}}">{{$vendor->name}}</label>
                    </div>
                    @endforeach
                  </div>
                  <div class="selected-box selected-box1">Select Vendor</div>
                  <div class="search-box search-box1">
                    <input type="text" placeholder="Start Typing...">
                  </div>
                </div>
                <div class="purchaseAdd-vendor_class"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label class="form-label fw-medium" for="purchaseAdd-item">Item Name/Code</label>
                {{-- <select id="purchaseAdd-item" class="form-control form-control-sm select2-cls">
                    <option value="">Select</option>
                    @foreach ($materials as $raw_material)
                        <option value="{{$raw_material['id']}}" data-uom="{{$raw_material['uom']}}">{{$raw_material['name']}} ({{$raw_material['code']}})</option>
                    @endforeach
                </select> --}}
                <div class="select-box select-box-abcd">
                  <div class="options-container options-container-abcd">
                    @foreach ($materials as $raw_material)
                    <div class="selection-option selection-option-abcd">
                      <input class="radio" id="v2{{$raw_material['id']}}" value="{{$raw_material['id']}}" data-uom="{{$raw_material['uom']}}" data-showname="{{$raw_material['name']}} ({{$raw_material['code']}})" type="radio" name="purchase_item">
                      <label class="mb-0" for="v2{{$raw_material['id']}}">{{$raw_material['name']}} ({{$raw_material['code']}})</label>
                    </div>
                    @endforeach
                  </div>
                  <div class="selected-box selected-box-abcd">Select Item</div>
                  <div class="search-box search-box-abcd">
                    <input type="text" placeholder="Start Typing...">
                  </div>
                </div>
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
<script>
    // Custom add search option
    const selected1 = document.querySelector(".selected-box-abcd");
    const optionsContainer1 = document.querySelector(".options-container-abcd");
    const searchBox1 = document.querySelector(".search-box-abcd input");

    const optionsList1 = document.querySelectorAll(".selection-option-abcd");

    selected1.addEventListener("click", () => {
      console.log("optionsContainer1", optionsContainer1);
      optionsContainer1.classList.toggle("active");

      searchBox1.value = "";
      filterList1("");

      if (optionsContainer1.classList.contains("active")) {
        searchBox1.focus();
      }
    });

    optionsList1.forEach((o) => {
      o.addEventListener("click", () => {
        selected1.innerHTML = o.querySelector("label").innerHTML;
        optionsContainer1.classList.remove("active");
      });
    });

    searchBox1.addEventListener("keyup", function (e) {
      filterList1(e.target.value);
    });

    const filterList1 = (searchTerm) => {
      searchTerm = searchTerm.toLowerCase();
      optionsList1.forEach((option) => {
        let label =
          option.firstElementChild.nextElementSibling.innerText.toLowerCase();
        if (label.indexOf(searchTerm) != -1) {
          option.style.display = "block";
        } else {
          option.style.display = "none";
        }
      });
    };

</script>
    <script src="{{ asset('backend/assets/js/custom/store/purchase.js') }}"></script>
    <script src="{{asset('backend/assets/js/custom/custom_backend.js')}}"></script>
@endsection