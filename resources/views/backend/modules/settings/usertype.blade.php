@extends('backend.layouts.main')
@section('title','Setting Usertype')
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
                                        <h3 class="d-block">Usertype</h3>
                                    </div>
                                    @if(in_array('Setting Add', (explode(',',auth()->user()->permission))))
                                    <div class="col-12 col-sm-6">
                                        <div class="float-end">
                                            <a class="btn btn-primary px-2" href="{{route('usertype.create')}}"><span class="btn-icon"><i class="ri-add-line"></i></span> Add Usertype</a>
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
                                                <table class="hover row-border stripe" id="usertype_table">
                                                    <thead>
                                                        <tr>
                                                            <th>SL No.</th>
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

@endsection
@section('extra-js')
<script>
    const usertypeView = "{{ route('usertype.view') }}";
    const usertypeSwitchStatus = "{{ route('usertype.switch') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/usertype.js')}}"></script>
@endsection