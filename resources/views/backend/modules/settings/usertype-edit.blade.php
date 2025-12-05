@extends('backend.layouts.main')
@section('title','Create Usertype')
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
                                        <h3 class="d-block">Edit Usertype</h3>
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
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label class="form-label fw-medium">Enter Usertype</label>
                                                    <input type="hidden" class="form-control form-control-sm" placeholder="Usertype" name="usertype_id" value="{{$usertypes[0]->id}}">
                                                    <input type="text" class="form-control form-control-sm" placeholder="Usertype" name="usertype_name" value="{{$usertypes[0]->name}}">
                                                </div>
                                            </div>
                                            <div class="row mt-4 mb-2">
                                                <div class="col-12">
                                                    <h4 class="form-label fw-medium">Permissions</h4>
                                                </div>
                                            </div>
                                            <div class="row mt-1 mb-1">
                                                @foreach ($moduleLists as $mod)
                                                    <div class="col-4 mb-3">
                                                        <div class="card-wrapper border rounded-3 checkbox-checked">
                                                            <h5><label class="form-label fw-medium">{{$mod['module']}}</label></h5>
                                                            @foreach ($mod['items'] as $item)
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input check-size" name="permissions[]" id="flexSwitchCheckDefault{{$item->id}}" type="checkbox" role="switch" value="{{$item->id}}" 
                                                                    @if(in_array($item->id, (explode(',',$usertypes[0]->permissions)))) checked 
                                                                    @endif
                                                                    ><label class="form-check-label" for="flexCheckDefault{{$item->id}}">{{$item->module_option}}</label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="col-md-12 d-flex justify-content-end mt-3 itemAddShow ">
                                                <button type="button" class="btn btn-success btn-sm fw-medium m-2 usertypeAddSubmit" onclick="updateUsertype()">
                                                Update
                                                </button>
                                                <button class="btn btn-success btn-sm fw-medium m-2 usertypeAddSpinn d-none" type="button">
                                                    Please Wait...
                                                </button>
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
    const usertypeUpdate = "{{ route('usertype.update') }}";
    const usertypeView = "{{ route('usertype.view') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/usertype.js')}}"></script>
@endsection