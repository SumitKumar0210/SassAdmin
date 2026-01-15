@extends('backend.layouts.main')
@section('title','Setting Payment Method')
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
                                            <h3 class="d-block">Payment Method</h3>
                                        </div>
                                        @if(in_array('Setting Add', (explode(',',auth()->user()->permission))))
                                        <div class="col-12 col-sm-6">
                                            <div class="float-end">
                                                <button class="btn btn-primary px-2" type="button" data-bs-toggle="modal"
                                                    data-bs-target="#paymentMethodModel" onclick="resetmodel()"><span class="btn-icon"><i class="ri-add-line"></i></span>
                                                    Add Payment Method</button>
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
                                                    <table class="hover row-border stripe" id="paymentMethod_table">
                                                        <thead>
                                                            <tr>
                                                                <th>S No</th>
                                                                <th>Name</th>
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

    <!-- Bed Type modal start -->
    <div class="modal fade" id="paymentMethodModel" tabindex="-1" role="dialog" aria-labelledby="paymentMethodModel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title"><span class="action-title">Add</span> Payment Method</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form class="g-3 needs-validation" novalidate="">
                        <div class="modal-body">
                            <div class="col-md-12">
                                <input type="hidden" id="paymentMethod_id">
                                <label class="form-label" for="paymentMethod_name">Name</label>
                                <input class="form-control" id="paymentMethod_name" type="text" placeholder="Enter Payment Name" required>
                                <div class="paymentMethod_name"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" onclick="resetmodel()">Cancel</button>
                            <button class="btn btn-primary addAction" type="button" onClick="addPaymentMethod()">Submit</button>
                            <button class="btn btn-primary updateAction d-none" type="button" onClick="updatePaymentMethod()">Update</button>
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
    const paymentMethodView = "{{ route('payment-method-detail.getDetails') }}";
    const paymentMethodAdd = "{{ route('payment-method-add.store') }}";
    const paymentMethodGet = "{{ route('payment-method-get.getPaymentMethod') }}";
    const paymentMethodSwitchStatus = "{{ route('payment-method.switchStatus') }}";
    const paymentMethodDelete = "{{ route('payment-method.delete') }}";
    const paymentMethodUpdate = "{{ route('payment-method.update') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/payment_method.js')}}"></script>
@endsection
