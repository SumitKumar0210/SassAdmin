@extends('backend.layouts.main')
@section('title','Setting Room Tarrif')
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
                                        <h3 class="d-block">Room Tariff</h3>
                                    </div>
                                    @if(in_array('Setting Add', (explode(',',auth()->user()->permission))))
                                    <div class="col-12 col-sm-6">
                                        <div class="float-end">
                                            <button class="btn btn-primary px-2 tariff_add" type="button" data-bs-toggle="modal"
                                                data-bs-target="#tariffModel"><span class="btn-icon"><i class="ri-add-line"></i></span>
                                                Add Tariff</button>
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
                                                <table class="hover row-border stripe" id="tariff_table">
                                                    <thead>
                                                        <tr>
                                                            <th>S No</th>
                                                            <th>Category</th>
                                                            <th>Tariff</th>
                                                            <th>Room Tariff</th>
                                                            <th>Extra Person Tariff</th>
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
    <div class="modal fade" id="tariffModel" tabindex="-1" role="dialog" aria-labelledby="tariffModel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title tariffTitle">Add Tariff</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="tariff_form" class="g-3 needs-validation" novalidate="">
                        <div class="modal-body">
                            <input type="hidden" id="tariffId">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="roomnum_type">Category</label>
                                <select class="form-select form-select-sm" id="roomnum_type">
                                    <option value="">Select</option>
                                    @foreach ($room_types as $item)
                                        <option value="{{$item->id}}">{{$item->room_category}}</option>
                                    @endforeach
                                </select>
                                <div class="roomnum_type_class"></div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label mt-1" for="tariffType">Tariff </label>
                                <input class="form-control form-control-sm" id="tariffType" type="text" placeholder="Enter Tariff" style="background-image: none;"
                                    required>
                                <div class="invalid-feedback">
                                    Enter Tariff
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label mt-1" for="roomTariff">Tariff Amount</label>
                                <input class="form-control form-control-sm" id="roomTariff" type="number" placeholder="Enter Room Tariff Amount" style="background-image: none;"
                                    required>
                                <div class="invalid-feedback">
                                    Enter Tariff Amount
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label mt-1" for="extraPersonTariff">Extra Person Tariff Amount</label>
                                <input class="form-control form-control-sm" id="extraPersonTariff" type="number" placeholder="Enter Extar Person Tariff Amount" style="background-image: none;"
                                    required>
                                <div class="invalid-feedback">
                                    Enter Extra Person Tariff
                                </div>
                            </div>
                        </div>
                            <div class="modal-footer">
                                <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary tariffSubmit" type="submit">Submit</button>
                                <button class="btn btn-primary tariffUpdate d-none" type="button" onclick="tariffUpdate(document.getElementById('tariffId').value)">Update</button>
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
    const tariffView = "{{ route('tariff.view') }}";
    const tariffAdd = "{{ route('tariff.add') }}";
    const tariffSwitchStatus = "{{ route('tariff.switchStatus') }}";
    const tariffGetData = "{{ route('tariff.getDetails') }}";
    const tariffDataUpdate = "{{ route('tariff.update') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/tariff.js')}}"></script>
@endsection
