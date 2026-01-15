@extends('backend.layouts.main')
@section('title','Setting Closure Reason')
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
                                            <h3 class="d-block">Closure Reason</h3>
                                        </div>
                                        @if(in_array('Setting Add', (explode(',',auth()->user()->permission))))
                                        <div class="col-12 col-sm-6">
                                            <div class="float-end">
                                                <button class="btn btn-primary px-2 closerReasonAdd" type="button" data-bs-toggle="modal" data-bs-target="#closerReason"><span class="btn-icon"><i class="ri-add-line"></i></span> Add Reason For Closer</button>
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
                                                    <table class="hover row-border stripe" id="room_bedtype_table1">
                                                        <thead>
                                                            <tr>
                                                                <th>SL No.</th>
                                                                <th>Closer Reason</th>
                                                                <th>Color</th>
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

    </div>

    <!-- Bed Type modal start -->
    <div class="modal fade" id="closerReason" tabindex="-1" role="dialog" aria-labelledby="closerReason"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title closerReasonTitle">Add Closer Reason</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="closerReason_form" class="g-3 needs-validation" novalidate="">
                        <div class="modal-body">
                            <div class="col-md-12">
                                <input type="hidden" id="closer_reason_id">
                                <label class="form-label" for="closer_reason">Reason For Closer Name</label>
                                <input class="form-control form-control-sm" id="closer_reason" type="text" placeholder="Enter Reason For Closer Name" style="background-image: none;" required>
                                <div class="invalid-feedback">
                                    Enter Reason For Closer Name
                                </div>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="form-label" for="closer_reason_color">Pick a color</label>
                                <input class="form-control form-control-sm" id="closer_reason_color" type="color" placeholder="Enter Pick a color" style="background-image: none;" required value="#ff0000">
                                <div class="invalid-feedback">
                                    Pick a color
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary closerReasonSubmit" type="submit">Submit</button>
                            <button class="btn btn-primary closerReasonUpdate d-none" type="button" onclick="closerReasonUpdate(document.getElementById('closer_reason_id').value)">Update</button>
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
    const closerReasonView = "{{ route('reason-closer.view') }}";
    const closerReasonAdd = "{{ route('reason-closer.store') }}";
    const closerReasonSwitch = "{{ route('reason-closer.switch') }}";
    const closerReasonGetData = "{{ route('reason-closer.getData') }}";
    const closerReasonDataUpdate = "{{ route('reason-closer.update') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/reason_closer.js')}}"></script>
@endsection