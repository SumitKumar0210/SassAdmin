@extends('backend.layouts.main')
@section('title','Setting Department')
@section('main-container')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Department</h3>
                        {{-- <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/dashboard">                                       
                        <svg class="stroke-icon">
                            <use href="backend/assets/svg/icon-sprite.svg#breadcrumb-home"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item active"> Bed Type</li>
                    </ol> --}}
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="float-end">
                            <button class="btn btn-primary px-2 department_add" type="button" data-bs-toggle="modal"
                                data-bs-target="#departmentModel"><span class="btn-icon"><i class="ri-add-line"></i></span>
                                Add Department</button>
                        </div>
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
                            <div class="table-responsive">
                                <table class="hover row-border stripe" id="department_table">
                                    <thead>
                                        <tr>
                                            <th>Sr.No.</th>
                                            <th>Name</th>
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

    <!-- Bed Type modal start -->
    <div class="modal fade" id="departmentModel" tabindex="-1" role="dialog" aria-labelledby="departmentModel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title departmentTitle">Add department</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="department_form" class="g-3 needs-validation" novalidate="">
                        <div class="modal-body">
                            <div class="col-md-12">
                                <input type="hidden" id="departmentId">
                                <label class="form-label" for="department_name">Name</label>
                                <input class="form-control form-control-sm" id="department_name" type="text" placeholder="Enter Name" style="background-image: none;"
                                    required>
                                <div class="invalid-feedback">
                                    Enter Name
                                </div>
                            </div>
                        </div>
                            <div class="modal-footer">
                                <button class="btn btn-outline-secondary" type="button"
                                    data-bs-dismiss="modal">Cancel</button>
                                <button class="btn btn-primary departmentSubmit" type="submit">Submit</button>
                                <button class="btn btn-primary departmentUpdate d-none" type="button"
                                    onclick="departmentUpdate(document.getElementById('departmentId').value)">Update</button>
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
    const departmentView = "{{ route('department.view') }}";
    const departmentAdd = "{{ route('department.add') }}";
    const departmentSwitchStatus = "{{ route('department.switchStatus') }}";
    const departmentGetData = "{{ route('department.getDetails') }}";
    const departmentDataUpdate = "{{ route('department.update') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/department.js')}}"></script>
@endsection
