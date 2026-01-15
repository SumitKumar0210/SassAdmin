@extends('backend.layouts.main')
@section('title','Restaurant Raw Material')
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
                                        <h3 class="d-block">Raw Material</h3>
                                    </div>
                                    @if(in_array('Setting Add', (explode(',',auth()->user()->permission))))
                                    <div class="col-12 col-sm-6">
                                        <div class="float-end">
                                            <button class="btn btn-primary ms-2" type="button" data-bs-toggle="modal" data-bs-target="#restaurantRawMaterialModal" onclick="resetmodel()"><span class="btn-icon"><i class="ri-add-line"></i></span> Add Raw Material</button>
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
                                                <table class="display" id="restaurant_raw_material">
                                                    <thead>
                                                        <tr>
                                                            <th>S No</th>
                                                            <th>Code</th> 
                                                            <th>Name</th> 
                                                            <th>UOM</th> 
                                                            <th>Minimum Capping</th> 
                                                            <th>Maximum Capping</th> 
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
<div class="modal fade" id="restaurantRawMaterialModal" tabindex="-1" role="dialog" aria-labelledby="restaurantRawMaterialModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper  text-start dark-sign-up">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="action-title">Add</span> Raw Material</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" novalidate="">
                        <div class="col-md-12">
                            <input class="form-control" id="restaurant-raw-material-id" type="hidden">
                            <label class="form-label" for="restaurant-raw-material-itemcode">Item Code</label>
                            <input class="form-control" id="restaurant-raw-material-itemcode" type="text" placeholder="Enter Item Code">
                            <div class="restaurant-raw-material-itemcode"></div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="restaurant-raw-material-name">Name</label>
                            <input class="form-control" id="restaurant-raw-material-name" type="text" placeholder="Enter Name">
                            <div class="restaurant-raw-material-name"></div>
                        </div>
                        <div class="col-md-6 d-none">
                            <label class="form-label" for="restaurant-raw-material-qty">Qty</label>
                            <input class="form-control" id="restaurant-raw-material-qty" type="number" placeholder="Enter Qty" value="1">
                            <div class="restaurant-raw-material-qty"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="restaurant-raw-material-uom">Select Measurement</label>
                            <select class="form-control" id="restaurant-raw-material-uom" required="">
                                <option value="">select</option>
                                @foreach($measurements as $measure)
                                    <option value="{{$measure->id}}">{{$measure->short_name}}</option>
                                @endforeach
                            </select>
                            <div class="restaurant-raw-material-uom"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="restaurant-raw-material-min-capping">Minimum Capping</label>
                            <input class="form-control" id="restaurant-raw-material-min-capping" type="number" maxlength="3" onkeyup="chkCappping()" placeholder="Enter Minimum Capping">
                            <div class="restaurant-raw-material-min-capping text-danger"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="restaurant-raw-material-max-capping">Maximum Capping</label>
                            <input class="form-control" id="restaurant-raw-material-max-capping" type="number" maxlength="5" oninput="chkCappping()" placeholder="Enter Maximum Capping">
                            <div class="restaurant-raw-material-max-capping text-danger"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" onclick="resetmodel()">Cancel</button>
                    <button class="btn btn-primary addAction" type="button" onclick="addRawMaterial()">Submit</button>
                    <button class="btn btn-primary updateAction d-none" type="button" onclick="updateRawMaterial()">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Room category modal end-->

@endsection
@section('extra-js')
<script>
    const rawMaterialView = "{{ route('restaurant-raw-material.getdetails') }}";
    const rawMaterialAdd = "{{ route('restaurant-raw-material-add.store') }}";
    const rawMaterialGet = "{{ route('restaurant-raw-material-get.getRawMaterial') }}";
    const rawMaterialSwitchStatus = "{{ route('restaurant-raw-material.switchStatus') }}";
    const rawMaterialUpdate = "{{ route('restaurant-raw-material.update') }}";
    const rawMaterialDelete = "{{ route('restaurant-raw-material.delete') }}";
</script>
<script src="{{asset('backend/assets/js/custom/restaurant/raw_material.js')}}"></script>
@endsection