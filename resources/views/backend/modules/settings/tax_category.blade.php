@extends('backend.layouts.main')
@section('title','Setting Tax Category')
@section('main-container')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Tax Category</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="hover row-border stripe" id="taxcategory_table">
                                    <thead>
                                        <tr>
                                            <th>S No</th>
                                            <th>Modules</th>
                                            <th>Status</th>
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
    
@endsection
@section('extra-js')
<script>
    const taxCategoryView = "{{ route('tax-category-detail.getDetails') }}";
    const taxCategorySwitchStatus = "{{ route('tax-category.switchStatus') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/tax_category.js')}}"></script>
@endsection
