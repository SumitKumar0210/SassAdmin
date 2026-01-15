@extends('backend.layouts.main')
@section('title','Restaurant Item')
@section('main-container') 
 <div class="page-body">
    <div class="container-fluid py-3">
        <div class="email-wrap bookmark-wrap">
            <div class="row">
                <div class="col-xl-12 col-md-12 box-col-12">
                    <div> 
                        @include('backend.layouts.sidebar_master')
                    </div>
                    <div style=" padding-left:220px;">
                        <div class="container-fluid">
                            <div class="page-title mt-2">
                                <div class="row gx-0">
                                    <div class="col-12 col-sm-6">
                                        <h3 class="d-block">Menu</h3>
                                    </div>
                                    @if(in_array('Setting Add', (explode(',',auth()->user()->permission))))
                                    <div class="col-12 col-sm-6">
                                        <div class="float-end">
                                            <button class="btn btn-primary ms-2" type="button" data-bs-toggle="offcanvas" href="#offcanvasRight" role="button" aria-controls="offcanvasRight" onclick="resetMainForm()"><span class="btn-icon"><i class="ri-add-line"></i></span> Add Menu</button>
                                        </div>
                                    </div>
                                    @endif
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
                                                <table class="display" id="restaurant_menu_item">
                                                    <thead>
                                                        <tr>
                                                            <th>S No</th>
                                                            <th>Image</th> 
                                                            <th>Code</th> 
                                                            <th>Name</th> 
                                                            <th>UOM</th> 
                                                            <th>Price</th> 
                                                            <th>GST</th> 
                                                            <th>Total</th> 
                                                            <th>Category</th> 
                                                            <th>Label</th> 
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Edit Room Type start --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" style="width:30%">
    <div class="offcanvas-header border-bottom position-relative">
        <h5 id="offcanvasRightLabel"><span class="action-title">Add</span> Item</h5>
        <button type="button" class="btn-close text-reset " data-bs-dismiss="offcanvas" aria-label="Close" ></button>
    </div>
    <div class="offcanvas-body">
        <!--start Form  Step 1 -->
        <div class="general-section" >
            <h5 class="text-uppercase mb-3">General Information</h5> 
            <div class="form-input-wrapper">
                <div class="row"> 
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-code">Item Code<span class="text-danger">*</span></label>
                            <input class="form-control form-control-sm" id="restaurant-item-id" type="hidden" placeholder="Enter Item Code">
                            <input class="form-control form-control-sm" id="restaurant-item-code" type="text" placeholder="Enter Item Code">
                            <div class="restaurant-item-code"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-name">Name<span class="text-danger">*</span></label>
                            <input class="form-control form-control-sm" id="restaurant-item-name" type="text" placeholder="Enter Item Name">
                            <div class="restaurant-item-name"></div>
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-price">Price<span class="text-danger">*</span></label>
                            <input class="form-control form-control-sm" id="restaurant-item-price" type="number" placeholder="Enter Price" onkeyup="calPriceGst()">
                            <div class="restaurant-item-price"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-offer-price">Offer Price</label>
                            <input class="form-control form-control-sm" id="restaurant-item-offer-price" type="number" placeholder="Enter Offer Price" onkeyup="calPriceGst()">
                            <div class="restaurant-item-offer-price text-danger"></div>
                        </div>
                    </div>
                    <div class="col-6 d-none">
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-gst-amount">GST Amount</label>
                            <input class="form-control form-control-sm" id="restaurant-item-gst-amount" type="number" placeholder="Enter GST Amount" value="0">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class=" mb-3">
                            <label class="f-w-600 mb-1">Default Tax</label>
                            <div class="border rounded p-1 d-flex justify-content-between align-items-center">
                                <div class="flex-grow-1 icon-state switch-outline">
                                    <label class="switch mb-0">
                                    <input type="checkbox" id="restaurant-item-default-tax" checked="" onchange="customTax()"><span class="switch-state bg-success"></span>
                                    </label>
                                </div>
                                <p class="mb-0 restaurant-item-default-tax-display-area"><span class="restaurant-item-default-tax-display">{{round($default_tax)}}</span>%</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 d-none item-custom-tax"> 
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-custom-tax">Tax</label>
                            <select class="form-control" id="restaurant-item-custom-tax" required="" onchange="calPriceGst()">
                                <option value="">select</option>
                                @foreach ($taxList as $tax)
                                    <option value="{{$tax['value']}}">{{$tax['name']}} ({{$tax['value']}}%)</option>
                                @endforeach
                            </select>
                            <div class="restaurant-item-custom-tax"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-cost">Cost<span class="text-danger">*</span></label>
                            <input class="form-control form-control-sm" id="restaurant-item-cost" type="number" placeholder="Enter Price" readonly>
                        </div>
                    </div>
                    <div class="col-6"> 
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-uom">UOM</label>
                            <select class="form-control" id="restaurant-item-uom" required="">
                                <option value="">select</option>
                                @foreach ($measurements as $uom)
                                    <option value="{{$uom->id}}">{{$uom->short_name}}</option>
                                @endforeach
                            </select>
                            <div class="restaurant-item-uom"></div>
                        </div>
                    </div>
                    <div class="col-6"> 
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-category">Category</label>
                            <select class="form-control" id="restaurant-item-category" required="" onchange="getSubCategory(this.value)">
                                <option value="">select</option>
                                @foreach ($categories as $cat)
                                    @if($cat->type == "0")
                                        <option value="{{$cat->id}}">{{$cat->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="restaurant-item-category"></div>
                        </div>
                    </div>
                    <div class="col-6"> 
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-sub-category">Sub Category</label>
                            <select class="form-control" id="restaurant-item-sub-category" required="">
                                <option value="">select</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6"> 
                        <div class=" mb-3">
                            <label class="form-label" for="restaurant-item-label">Label <span class="text-danger">*</span></label>
                            <select class="form-control" id="restaurant-item-label" required="">
                                <option value="">select</option>
                                @foreach ($labels as $lab)
                                    <option value="{{$lab->id}}">{{$lab->name}}</option>
                                @endforeach
                            </select>
                            <div class="restaurant-item-label"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class=" mb-3">
                            <label class="form-label" for="restaurant-item-image">Upload Item Image</label>
                            <input class="form-control" id="restaurant-item-image" type="file"  accept="image/*"> 
                            <div class="restaurant-item-image"></div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class=" mb-3">
                            <label class="f-w-600">Only Internal</label>
                            <div class="flex-grow-1 icon-state switch-outline">
                                <label class="switch mb-0">
                                <input type="checkbox" id="only_internal"><span class="switch-state bg-success"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class=" mb-3">
                            <label class="f-w-600">Type</label>
                            <div class="m-checkbox-inline">
                                <label class="f-w-600" for="type-veg">
                                    <input class="radio_animated" id="type-veg" type="radio" name="restaurant-item-category-type" checked="" value="Veg">Veg
                                </label>
                                <label class="f-w-600" for="type-nonveg">
                                    <input class="radio_animated" id="type-nonveg" type="radio" name="restaurant-item-category-type" value="Non-Veg" >Non Veg
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class=" mb-3">
                            <label class="f-w-600">Status</label>
                            <div class="m-checkbox-inline">
                                <label class="f-w-600" for="status_active">
                                    <input class="radio_animated" id="status_active" type="radio" name="restaurant-item-category-status" value="1">Active
                                </label>
                                <label class="f-w-600" for="status_inactive">
                                    <input class="radio_animated" id="status_inactive" type="radio" name="restaurant-item-category-status" value="0">In-Active
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12"> 
                        <div class=" mb-3">
                            <label class="form-label" for="restaurant-item-description">Description</label>
                            <textarea class="form-control" id="restaurant-item-description" rows="4" placeholder="Enter Description" required=""></textarea>
                            <div class="restaurant-item-description"></div>
                        </div>
                    </div>
                </div>
            </div>   
        </div>
        <!--end Form  Step 1 -->
        <!--start Form  Step 2 -->
        <div class="rawmatrial-section">                                               
            <div class="d-none d-sm-block mb-3 mt-4 "> 
                <h5 class="text-uppercase">Raw Material</h5>
            </div>
            <div class="form-input-wrapper">
                <div class="row">
                    <div class="col-5"> 
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-material-name">Material</label>
                            <select class="selectpicker form-control" data-live-search="true" id="restaurant-item-material-name" onchange="getDetailMaterial(this.value)">
                                <option value="">select</option>
                                @foreach ($rawMaterials as $material)
                                    <option value="{{$material['id']}}" data-uom="{{$material['uom']}}" data-child="{{$material['uom_child']}}" data-min="{{$material['min']}}" data-max="{{$material['max']}}" >{{$material['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-5 unit-details"></div>
                    <div class="col-2">
                        <div class="mb-3 mt-4">
                            <div class="edit-add-extra-rooms">
                                <a href="javascript:void(0)" class="btn btn-primary px-2" type="button" onclick="addRawMaterialItem()"> 
                                    <span class="btn-icon"><i data-feather="plus"></i></span> Add
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 item_raw_material_view d-none">
                        <div class="card">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Qty</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="item_raw_material_list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end Form  Step 2 -->
        <!--start Form  Step 2 -->
        <div class="occupancy-section" >                                               
            <div class="d-none d-sm-block mb-3 mt-4 "> 
                <h5 class="text-uppercase">Variation</h5>
            </div>
            <div class="form-input-wrapper">
                <div class="row">
                    <div class="col-3"> 
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-variation-attribute">Attribute</label>
                            <select class="selectpicker form-control" data-live-search="true" id="restaurant-item-variation-attribute" onchange="getSubAttribute(this.value)">
                                <option value="">select</option>
                                @foreach ($attributes as $attr)
                                    @if($attr->type == "0")
                                        <option value="{{$attr->id}}">{{$attr->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div ><small class="restaurant-item-variation-attribute-class text-danger"></small></div>
                        </div>
                    </div>
                    <div class="col-4"> 
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-variation-name">Name</label>
                            <select class="form-control" id="restaurant-item-variation-name" required="">
                                <option value="">select</option>
                            </select>
                            <div><small class="restaurant-item-variation-name-class text-danger"></small></div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-variation-price">Additional Price</label>
                            <input class="form-control form-control-sm" id="restaurant-item-variation-price" type="number" placeholder="Enter Additional Price" value="0">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="mb-3 mt-4">
                            <div class="edit-add-extra-rooms">
                                <a href="javascript:void(0)" class="btn btn-primary px-2" type="button" onclick="addVariationItem()"> 
                                    <span class="btn-icon"><i data-feather="plus"></i></span> Add
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 item_variation_view d-none">
                        <div class="card">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Attribute</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="item_variation_list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end Form  Step 2 -->
        <!--start Form  Step 3 -->
        <div class="features-section d-none" >
            <div class="d-none d-sm-block mb-3 mt-4">
                <h5 class="text-uppercase">Extra</h5> 
            </div>
            <div class="form-input-wrapper">
                <div class="row">
                    <div class="col-5"> 
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-extra-item">Item</label>
                            <select class="selectpicker form-control" data-live-search="true" id="restaurant-extra-item">
                                <option value="">select</option>
                                @foreach ($items as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-extra-price">Price</label>
                            <input class="form-control form-control-sm" id="restaurant-extra-price" type="number" placeholder="Enter Price">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="mb-3 mt-4">
                            <div class="edit-add-extra-rooms">
                                <a href="javascript:void(0)" class="btn btn-primary px-2" type="button" onclick="addExtraItem()"> 
                                    <span class="btn-icon"><i data-feather="plus"></i></span> Add
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 item_extra_view d-none">
                        <div class="card">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="item_extra_list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end Form  Step 3 -->
        <!--start Form  Step 4 -->
        <div class="media-section">
            <div class="d-none d-sm-block mb-3 mt-4">
                <h5 class="text-uppercase">Addon</h5> 
            </div>
            <div class="form-input-wrapper">
                <div class="row">
                    <div class="col-5"> 
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-addon-name">Item</label>
                            <select class="selectpicker form-control" data-live-search="true" id="restaurant-item-addon-name" onchange="getItemVariant(this.value)">
                                <option value="">select</option>
                                @foreach ($items as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-5"> 
                        <div class="mb-3">
                            <label class="form-label" for="restaurant-item-addon-variation">Variant Name</label>
                            <select class="form-control" id="restaurant-item-addon-variation" required="">
                                <option value="">select</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="mb-3 mt-4">
                            <div class="edit-add-extra-rooms">
                                <a href="javascript:void(0)" class="btn btn-primary px-2" type="button" onclick="addAddonItem()"> 
                                    <span class="btn-icon"><i data-feather="plus"></i></span> Add
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 item_addon_view d-none">
                        <div class="card">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="item_addon_list"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end Form  Step 4 -->
    </div>
    <div class="offcanvas-footer d-flex">
        <button type="button" class="btn btn-danger w-50 btn-square py-2" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
        <button type="button" class="btn btn-primary w-50 btn-square py-2 roomtype_edit_btn" type="submit" onclick="addMenu()">Submit</button>
    </div>
</div>
@endsection
@section('extra-js')
<script>
    const menuView = "{{ route('restaurant-menu-detail.getDetails') }}";
    const menuAdd = "{{ route('restaurant-menu-add.store') }}";
    const menuGet = "{{ route('restaurant-menu-get.getMenu') }}";
    const menuSwitchStatus = "{{ route('restaurant-menu.switchStatus') }}";
    const menuUpdate = "{{ route('restaurant-menu.update') }}";
    const menuDelete = "{{ route('restaurant-menu.delete') }}";
    const itemCategoryGetAll  = "{{ route('restaurant-item-category-get.getCategoryAll') }}";
    const itemAttributeGetAll = "{{ route('restaurant-item-attribute-get.getAttributeAll') }}";
    const itemVariantGetAll = "{{ route('restaurant-item-attribute.itemVariantGetAll') }}";

</script>
<script src="{{asset('backend/assets/js/custom/restaurant/item.js')}}"></script>
@endsection