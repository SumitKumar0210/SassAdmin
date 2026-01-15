@extends('backend.layouts.main')
@section('title','Restaurant Item Attribute')
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
                                        <h3 class="d-block">Item Attribute</h3>
                                    </div>
                                    @if(in_array('Setting Add', (explode(',',auth()->user()->permission))))
                                    <div class="col-12 col-sm-6">
                                        <div class="float-end">
                                            <button class="btn btn-primary ms-2" type="button" data-bs-toggle="modal" data-bs-target="#restaurantItemAttributeModal" onclick="resetmodel()"><span class="btn-icon"><i class="ri-add-line"></i></span> Add Attribute</button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="display" id="restaurant_item_attribute">
                                                    <thead>
                                                        <tr>
                                                            <th>SL No.</th>
                                                            <th>Name</th> 
                                                            <th>Parent</th> 
                                                            <th>Type</th> 
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

<!-- Room category modal start -->
<div class="modal fade" id="restaurantItemAttributeModal" tabindex="-1" role="dialog" aria-labelledby="restaurantItemAttributeModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper  text-start dark-sign-up">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="action-title">Add</span> Attribute</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" novalidate="">
                        <div class="col-md-12">
                            <input class="form-control" id="restaurant-item-attribute-id" type="hidden" placeholder="Enter Attribute Name">
                            <label class="form-label" for="restaurant-item-attribute-name"> Name</label>
                            <input class="form-control" id="restaurant-item-attribute-name" type="text" placeholder="Enter Attribute Name">
                            <div class="restaurant-item-attribute-name"></div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="restaurant-item-attribute-type">Type</label>
                            <select class="form-select form-select-sm" id="restaurant-item-attribute-type">
                                <option value="">Select</option>
                                <option value="0">Main Attribute</option>
                                @if(sizeof($attribute) > 0)
                                    <optgroup class="text-muted" label="Sub Attribute">
                                        @foreach ($attribute as $attr )
                                        <option value="{{$attr->id}}">{{$attr->name}}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            </select>
                            <div class="restaurant-item-attribute-type"></div>
                        </div>
                        <div class="col-md-12 mb-3 d-none">
                            <div class="form-group">
                                <div class="form-control">
                                    <div class="flex-grow-1 icon-state switch-outline">
                                        <label class="switch mb-0" >
                                        <input type="checkbox" checked=""><span class="switch-state bg-success"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" onclick="resetmodel()">Cancel</button>
                    <button class="btn btn-primary addAction" type="button" onclick="addItemAttribute()">Submit</button>
                    <button class="btn btn-primary updateAction d-none" type="button" onclick="updateRestaurantItemAttribute()">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Room category modal end-->
@endsection
@section('extra-js')
<script>
    const itemAttributeView = "{{ route('restaurant-item-attribute.getdetails') }}";
    const itemAttributeAdd = "{{ route('restaurant-item-attribute-add.store') }}";
    const itemAttributeGet = "{{ route('restaurant-item-attribute-get.getAttribute') }}";
    const itemAttributeSwitchStatus = "{{ route('restaurant-item-attribute.switchStatus') }}";
    const itemAttributeDelete = "{{ route('restaurant-item-attribute.delete') }}";
    const itemAttributeUpdate = "{{ route('restaurant-item-attribute.update') }}";
</script>
<script src="{{asset('backend/assets/js/custom/restaurant/item_attribute.js')}}"></script>
@endsection