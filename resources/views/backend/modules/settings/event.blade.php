@extends('backend.layouts.main')
@section('title','Setting Event')
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
                                        <h3 class="d-block">Events</h3>
                                    </div>
                                    @if(in_array('Setting Add', (explode(',',auth()->user()->permission))))
                                    <div class="col-12 col-sm-6">
                                        <div class="float-end">
                                            <button class="btn btn-primary px-2 event_Add" type="button" data-bs-toggle="modal" data-bs-target="#eventAdd"><span class="btn-icon"><i class="ri-add-line"></i></span> Add Events</button>
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
                                                <table class="hover row-border stripe" id="event_table">
                                                    <thead>
                                                        <tr>
                                                            <th>SL No.</th>
                                                            <th>Event</th>
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
    <div class="modal fade" id="eventAdd" tabindex="-1" role="dialog" aria-labelledby="eventAdd"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title eventTitle">Add Event</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="event_form" class="g-3 needs-validation" novalidate="">
                        <div class="modal-body">
                            <div class="col-md-12">
                                <input type="hidden" id="event_id">
                                <label class="form-label" for="event">Event Name</label>
                                <input class="form-control form-control-sm" id="event" type="text" placeholder="Enter Event Name" style="background-image: none;" required>
                                <div class="invalid-feedback">
                                    Enter Event Name
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary event_submit" type="submit">Submit</button>
                            <button class="btn btn-primary event_update d-none" type="button" onclick="event_update(document.getElementById('event_id').value)">Update</button>
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
    const eventView = "{{ route('event.view') }}";
    const eventAdd = "{{ route('event.store') }}";
    const getEventData = "{{ route('event.getData') }}";
    const eventUpdate = "{{ route('event.update') }}";
    const eventSwitchStatus = "{{ route('event.switch') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/event.js')}}"></script>
@endsection