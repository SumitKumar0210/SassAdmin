@extends('backend.layouts.main')
@section('title','Restaurant Item Category')
@section('main-container') 
<div class="page-body">
    <div class="container-fluid py-3">
        <div class="email-wrap bookmark-wrap">
            <div class="row">
                <div class="col-xl-2 box-col-6">
                    @include('backend.layouts.sidebar_master')
                </div>
                <div class="col-xl-10 col-md-12 box-col-12">
                    <div class="container-fluid">
                        <div class="page-title mt-2">
                            <div class="row gx-0">
                                <div class="col-12 col-sm-6">
                                    <h3 class="d-block">Item Category</h3>
                                </div>
                                @if(in_array('Setting Add', (explode(',',auth()->user()->permission))))
                                    <div class="col-12 col-sm-6">
                                        <div class="float-end">
                                            <button class="btn btn-primary ms-2" type="button" data-bs-toggle="modal" data-bs-target="#restaurantCategoryModal" onclick="resetmodel()"><span class="btn-icon"><i class="ri-add-line"></i></span> Add Category</button>
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
                                            <table class="display" id="restaurant_item_category">
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

<!-- Room category modal start -->
<div class="modal fade" id="restaurantCategoryModal" tabindex="-1" role="dialog" aria-labelledby="restaurantCategoryModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper  text-start dark-sign-up">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="action-title">Add</span> Category</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" novalidate="">
                        <div class="col-md-12">
                            <input class="form-control" id="restaurant-category-id" type="hidden">
                            <label class="form-label" for="restaurant-category-name">Name</label>
                            <input class="form-control" id="restaurant-category-name" type="text" placeholder="Enter Category Name">
                            <div class="restaurant-category-name"></div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="restaurant-category-type">Type</label>
                            <select class="form-select form-select-sm" id="restaurant-category-type">
                                <option value="">Select</option>
                                <option value="0">Main Category</option>
                                @if(sizeof($list) > 0)
                                    <optgroup class="text-muted" label="Sub Category">
                                        @foreach ($list as $cat )
                                        <option value="{{$cat['id']}}">{{$cat['name']}} @if($cat['type'] > "") - @endif {{$cat['type']}}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            </select>
                            <div class="restaurant-category-type"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" onclick="resetmodel()">Cancel</button>
                    <button class="btn btn-primary addAction" type="button" onclick="addItemCategory()">Submit</button>
                    <button class="btn btn-primary updateAction d-none" type="button" onclick="updateItemCategory()">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Room category modal end-->
@endsection
@section('extra-js')
<script>
    const itemCategoryView = "{{ route('restaurant-item-category.getdetails') }}";
    const itemCategoryAdd = "{{ route('restaurant-item-category-add.store') }}";
    const itemCategoryGet = "{{ route('restaurant-item-category-get.getCategory') }}";
    const itemCategorySwitchStatus = "{{ route('restaurant-item-category.switchStatus') }}";
    const itemCategoryDelete = "{{ route('restaurant-item-category.delete') }}";
    const itemCategoryUpdate = "{{ route('restaurant-item-category.update') }}";
</script>
<script src="{{asset('backend/assets/js/custom/restaurant/item_category.js')}}"></script>
@endsection