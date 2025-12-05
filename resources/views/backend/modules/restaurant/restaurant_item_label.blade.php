@extends('backend.layouts.main')
@section('title','Restaurant Item Label')
@section('main-container') 
 <div class="page-body">
    <div class="container-fluid">
        <div class="page-title mt-2">
            <div class="row gx-0">
                <div class="col-12 col-sm-6">
                    <h3 class="d-block">Item Label</h3>
                    {{-- <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">                                       
                        <svg class="stroke-icon">
                            <use href="backend/assets/svg/icon-sprite.svg#breadcrumb-home"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item active"> Room View</li>
                    </ol> --}}
                </div>
                <div class="col-12 col-sm-6">
                    <div class="float-end">
                        <button class="btn btn-primary px-2" type="button" data-bs-toggle="modal" data-bs-target="#restaurantItemLabelModal" onclick="resetmodel()"><span class="btn-icon"><i class="ri-add-line"></i></span> Add Label</button>
                    </div>
                </div>
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
                            <table class="display" id="item_label_table">
                                <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Image</th>
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

<!-- Room View modal start -->
<div class="modal fade" id="restaurantItemLabelModal" tabindex="-1" role="dialog" aria-labelledby="restaurantItemLabelModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper  text-start dark-sign-up">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="action-title">Add</span> Label</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 mb-3 needs-validation" novalidate="">
                        <div class="col-md-12">
                            <input class="form-control" id="restaurant-label-id" type="hidden" placeholder="Enter Label Name">
                            <label class="form-label" for="restaurant-label-name">Label Name</label>
                            <input class="form-control" id="restaurant-label-name" type="text" placeholder="Enter Label Name">
                            <div class="restaurant-label-name"></div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="restaurant-label-image">Upload Label Image</label>
                            <input class="form-control" id="restaurant-label-image" type="file"  accept="image/*"> 
                            <div class="restaurant-label-image"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" onclick="resetmodel()">Cancel</button>
                    <button class="btn btn-primary addAction" type="button" onclick="addItemLabel()">Submit</button>
                    <button class="btn btn-primary updateAction d-none" type="button" onclick="updateRestaurantItemLabel()">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Room View modal end-->

@endsection
@section('extra-js')
<script>
    const itemLabelView = "{{ route('restaurant-item-label.getdetails') }}";
    const itemLabelAdd = "{{ route('restaurant-item-label-add.store') }}";
    const itemLabelGet = "{{ route('restaurant-item-label-get.getLabel') }}";
    const itemLabelSwitchStatus = "{{ route('restaurant-item-label.switchStatus') }}";
    const itemLabelUpdate = "{{ route('restaurant-item-label.update') }}";
    const itemLabelDelete = "{{ route('restaurant-item-label.delete') }}";
</script>
<script src="{{asset('backend/assets/js/custom/restaurant/item_label.js')}}"></script>
@endsection
