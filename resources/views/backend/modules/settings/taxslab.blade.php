@extends('backend.layouts.main')
@section('title','Setting Tax Slab')
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
                                            <h3 class="d-block">Tax Slab</h3>
                                        </div>
                                        @if(in_array('Setting Add', (explode(',',auth()->user()->permission))))
                                            <div class="col-12 col-sm-6">
                                                <div class="float-end">
                                                    <button class="btn btn-primary px-2 taxslab_Add" type="button" data-bs-toggle="modal" onclick="resetmodel()"
                                                        data-bs-target="#taxslabModel"><span class="btn-icon"><i class="ri-add-line"></i></span>
                                                        Add Tax Slab</button>
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
                                                    <table class="hover row-border stripe" id="taxslab_table">
                                                        <thead>
                                                            <tr>
                                                                <th>SL No.</th>
                                                                <th>Category</th>
                                                                <th>Name</th>
                                                                <th>Rate (%)</th>
                                                                <th>Mark As Default</th>
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
    <div class="modal fade" id="taxslabModel" tabindex="-1" role="dialog" aria-labelledby="taxslabModel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title"><span class="action-title">Add</span> Tax Slab</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="taxslab_form" class="g-3 needs-validation" novalidate="">
                        <div class="modal-body row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="tax_slab_catgory">Category</label>
                                <select class="form-select form-select-sm" id="tax_slab_catgory">
                                    <option value="">Select</option>
                                    @if(sizeof($tax_categories) > 0)
                                        @foreach ($tax_categories as $cat )
                                            <option value="{{$cat->id}}">{{$cat->module}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="tax_slab_catgory"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <input type="hidden" id="taxslab_id">
                                <label class="form-label" for="tax_slab_name">Name</label>
                                <input class="form-control" id="tax_slab_id" type="text" placeholder="Enter Tax Slab Name" >
                                <input class="form-control" id="tax_slab_name" type="text" placeholder="Enter Tax Slab Name"
                                    required>
                                <div class="invalid-feedback">
                                    Enter Tax Slab Name
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tax_slab_rate">Rate</label>
                                <div class="input-group">
                                    <input class="form-control" id="tax_slab_rate" type="number" placeholder="Enter Rate"><span class="input-group-text">%</span>
                                </div>
                                <div class="invalid-feedback">
                                    Enter Tax Slab Rate
                                </div> 
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class=" mb-3">
                                    <label class="f-w-600 mb-1">Set Relation</label>
                                    <div class="border rounded p-1 d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1 icon-state switch-outline">
                                            <label class="switch mb-0">
                                            <input type="checkbox" id="tax_slab_set_relation" onchange="setCheckRelation()"><span class="switch-state bg-success"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 set_relation d-none">
                                <label class="form-label" for="tax_slab_releted_to">Releted To</label>
                                <select class="form-select form-select-sm" id="tax_slab_releted_to">
                                    <option value="">Select</option>
                                    @if(sizeof($taxes) > 0)
                                        @foreach ($taxes as $t)
                                            <option value="{{$t->id}}">{{$t->name}} {{$t->rate}} %</option>
                                        @endforeach
                                    @endif
                                </select>
                                <div class="tax_slab_releted_to"></div>
                            </div>
                            {{-- <div class="col-md-6 mb-3">
                                <div class=" mb-3">
                                    <label class="f-w-600 mb-1">Mark As Default Tax</label>
                                    <div class="border rounded p-1 d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1 icon-state switch-outline">
                                            <label class="switch mb-0">
                                            <input type="checkbox" id="tax_slab_mark_as_default"><span class="switch-state bg-success"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal" onclick="resetmodel()">Cancel</button>
                            <button class="btn btn-primary addAction" type="button" onClick="addTaxSlab()">Submit</button>
                            <button class="btn btn-primary updateAction d-none" type="button" onclick="updateTaxSlab()">Update</button>
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
    const taxSlabView = "{{ route('taxslab.getData') }}";
    const taxSlabAdd = "{{ route('taxslab.store') }}";
    const taxSlabGet = "{{ route('taxslab.getDetails') }}";
    const taxSlabSwitchStatus = "{{ route('taxslab-details.switchStatus') }}";
    const taxSlabSwitchDefaultTax = "{{ route('taxslab-default.switchDefaultTax') }}";
    const taxSlabDelete = "{{ route('taxslab.delete') }}";
    const taxSlabUpdate = "{{ route('taxslab.update') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/tax_slab.js')}}"></script>
@endsection
