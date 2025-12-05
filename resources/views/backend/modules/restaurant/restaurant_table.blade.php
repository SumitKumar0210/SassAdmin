@extends('backend.layouts.main')
@section('title','Restaurant Table')
@section('extra-css')
<style>
.image-container {
      display: inline-block;
      cursor: pointer;
    }
    .qr-big {
      display: none;
      position: fixed;
      z-index: 9999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.8);
      justify-content: center;
      align-items: center;
    }
    .qr-big img {
      max-width: 90%;
      max-height: 90%;
      border-radius: 8px;
      box-shadow: 0 0 20px rgba(255,255,255,0.3);
      transition: transform 0.3s ease;
    }
    .qr-big img:hover {
      transform: scale(1.1);
    }
</style>
@endsection
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
                                    <h3 class="d-block">Table</h3>
                                </div>
                                @if(in_array('Setting Add', (explode(',',auth()->user()->permission))))
                                <div class="col-12 col-sm-6">
                                    <div class="float-end">
                                        <button class="btn btn-primary ms-2" type="button" data-bs-toggle="modal" data-bs-target="#restaurantTableModal" onclick="resetmodel()"><span class="btn-icon"><i class="ri-add-line"></i></span> Add Table</button>
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
                                            <table class="display" id="restaurant_table">
                                                <thead>
                                                    <tr>
                                                        <th>SL No.</th>
                                                        <th>Table Number</th> 
                                                        <th>Capacity</th> 
                                                        <th>Area</th> 
                                                        <th>QR Code</th> 
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
<div class="modal fade" id="restaurantTableModal" tabindex="-1" role="dialog" aria-labelledby="restaurantTableModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper  text-start dark-sign-up">
                <div class="modal-header">
                    <h4 class="modal-title"><span class="action-title">Add</span> Table</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="qr_code_table" style="display:none;"></div>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" novalidate="">
                        <div class="col-md-12">
                            <input class="form-control" id="restaurant-table-id" type="hidden">
                            <label class="form-label" for="restaurant-table-number">Enter Table Number</label>
                            <input class="form-control" id="restaurant-table-number" type="text" placeholder="Enter Table Name">
                            <div class="restaurant-table-number"></div>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label" for="restaurant-table-capacity">Table Capacity</label>
                            <input class="form-control" id="restaurant-table-capacity" type="number" placeholder="Enter Table Capacity">
                            <div class="restaurant-table-capacity"></div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="restaurant-area">Select Area</label>
                            <select class="form-control" id="restaurant-area" required="">
                                <option value="">select</option>
                                @foreach($restaurant_area as $area)
                                    <option value="{{$area}}">{{$area}}</option>
                                @endforeach
                            </select>
                            <div class="restaurant-area"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" onclick="resetmodel()">Cancel</button>
                    <button class="btn btn-primary addAction" type="button" onclick="addTable()">Submit</button>
                    <button class="btn btn-primary updateAction d-none" type="button" onclick="updateRestaurantTable()">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="qr-big" id="imageBigQR" onclick="closeModal()">
  <img id="qrModal" src="">
</div>
<!-- Room category modal end-->
@endsection
@section('extra-js')
<script>
    const tableView = "{{ route('restaurant-table.getdetails') }}";
    const tableAdd = "{{ route('restaurant-table-add.store') }}";
    const tableGet = "{{ route('restaurant-table-get.getTable') }}";
    const tableSwitchStatus = "{{ route('restaurant-table.switchStatus') }}";
    const tableUpdate = "{{ route('restaurant-table.update') }}";
    const tableDelete = "{{ route('restaurant-table.delete') }}";

    function openModal(src) {
        document.getElementById("qrModal").src = src;
        document.getElementById("imageBigQR").style.display = "flex";
    }

    function closeModal() {
        document.getElementById("imageBigQR").style.display = "none";
    }
</script>
<script src="{{asset('backend/assets/js/custom/restaurant/table.js')}}"></script>
@endsection