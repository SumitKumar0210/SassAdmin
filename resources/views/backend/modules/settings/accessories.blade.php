@extends('backend.layouts.main')
@section('title','Setting Accessories')
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
                                        <h3 class="d-block">Accessories</h3>
                                    </div>
                                    @if(in_array('Setting Add', (explode(',',auth()->user()->permission))))
                                    <div class="col-12 col-sm-6">
                                        <div class="float-end">
                                            <button class="btn btn-primary px-2 accessories_Add" type="button" data-bs-toggle="modal" data-bs-target="#accessoriesAdd"><span class="btn-icon"><i class="ri-add-line"></i></span> Add Accessories</button>
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
                                                <table class="hover row-border stripe" id="accessories_table">
                                                    <thead>
                                                        <tr>
                                                            <th>SL No.</th>
                                                            <th>Accessories</th>
                                                            <th>Rate</th>
                                                            <th>Status</th>
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
                </div>
            </div>
        </div>

    </div>

    <!-- Bed Type modal start -->
    <div class="modal fade" id="accessoriesAdd" tabindex="-1" role="dialog" aria-labelledby="accessoriesAdd"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title accessoriesTitle">Add accessories</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="accessories_form" class="g-3 needs-validation" novalidate="">
                        <div class="modal-body">
                            <div class="col-md-12">
                                <input type="hidden" id="accessories_id">
                                <label class="form-label" for="accessories">Name</label>
                                <input class="form-control form-control-sm" id="accessories" type="text" placeholder="Enter Accessories Name" style="background-image: none;" required>
                                <div class="invalid-feedback">
                                    Enter accessories Name
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label" for="rate">Rate</label>
                                <input class="form-control form-control-sm" id="rate" type="text" placeholder="Enter Rate Name" style="background-image: none;" required>
                                <div class="invalid-feedback">
                                    Enter Rate Name
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary accessories_submit" type="submit">Submit</button>
                            <button class="btn btn-primary accessories_update d-none" type="button" onclick="accessories_update(document.getElementById('accessories_id').value)">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bed Type modal end-->
@endsection
@section('extra-js')
<script>
    const accessoriesView = "{{ route('accessories.view') }}";
    const accessoriesAdd = "{{ route('accessories.store') }}";
    const accessoriesSwitchStatus = "{{ route('accessories.switch') }}";
    const getAccessoriesData = "{{ route('accessories.getData') }}";
    const accessoriesUpdate = "{{ route('accessories.update') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/accessories.js')}}"></script>
@endsection