@extends('backend.layouts.main')
@section('title','Setting Waiter')
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
                                        <h3 class="d-block">Waiter</h3>
                                    </div>
                                    @if(in_array('Setting Add', (explode(',',auth()->user()->permission))))
                                    <div class="col-12 col-sm-6">
                                        <div class="float-end">
                                            <button class="btn btn-primary px-2 waiter_add" type="button" data-bs-toggle="modal"
                                                data-bs-target="#waiterModel"><span class="btn-icon"><i class="ri-add-line"></i></span>
                                                Add Waiter</button>
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
                                                <table class="hover row-border stripe" id="waiter_table">
                                                    <thead>
                                                        <tr>
                                                            <th>Sr.No.</th>
                                                            <th>Name</th>
                                                            <th>Mobile</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                        </tr>

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
    <div class="modal fade" id="waiterModel" tabindex="-1" role="dialog" aria-labelledby="waiterModel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title waiterTitle">Add Waiter</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="waiter_form" class="g-3 needs-validation" novalidate="">
                        <div class="modal-body">
                            <div class="col-md-12 mb-2">
                                <input type="hidden" id="waiterId">
                                <label class="form-label" for="waiter_name">Name</label>
                                <input class="form-control form-control-sm" id="waiter_name" type="text" placeholder="Enter Name" style="background-image: none;"
                                    required>
                                <div class="invalid-feedback">
                                    Enter Name
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="form-label" for="waiter_mobile">Mobile</label>
                                <input class="form-control form-control-sm" id="waiter_mobile" type="tel" placeholder="Enter Mobile No." style="background-image: none;" minlength="10" maxlength="10" required>
                                <div class="invalid-feedback">
                                    Enter Mobile
                                </div>
                            </div>
                        </div>
                            <div class="modal-footer">
                                <button class="btn btn-outline-secondary" type="button"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary waiterSubmit" type="submit">Submit</button>
                                <button class="btn btn-primary waiterUpdate d-none" type="button"
                                    onclick="waiterUpdate(document.getElementById('waiterId').value)">Update</button>
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
    const waiterView = "{{ route('waiter.view') }}";
    const waiterAdd = "{{ route('waiter.add') }}";
    const waiterSwitchStatus = "{{ route('waiter.switchStatus') }}";
    const waiterGetData = "{{ route('waiter.getDetails') }}";
    const waiterDataUpdate = "{{ route('waiter.update') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/waiter.js')}}"></script>
@endsection
