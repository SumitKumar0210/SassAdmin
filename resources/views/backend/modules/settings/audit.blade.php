@extends('backend.layouts.main')
@section('title','Setting Audit')
@section('main-container')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Audit</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="card height-equal">
                        <div class="card-header card-no-border pb-0">
                            <h3>Audit Time Setting</h3>
                        </div>
                        <div class="card-body">
                            <form class="row g-3 needs-validation custom-input invoice-setting-form" novalidate="">
                                <div class="col-4">
                                    <label class="form-label" for="audit_start_general_setting">Start Time</label>
                                    <input class="form-control" id="audit_start_general_setting" type="time" required="" onchange="chkTime()" value="{{$hotlr[0]->audit_start}}">
                                    <div class="invalid-feedback">Please enter start time </div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label" for="audit_end_general_setting">End Time</label>
                                    <input class="form-control" id="audit_end_general_setting" type="time"required="" onchange="chkTime()" value="{{$hotlr[0]->audit_end}}">
                                    <div class="invalid-feedback">Please enter end time </div>
                                </div>
                                <div class="col-4 d-none">
                                    <label class="form-label" for="audit_duration_general_setting">Duration</label>
                                    <input class="form-control" id="audit_duration_general_setting_view" type="text" readonly>
                                    <input class="form-control" id="audit_duration_general_setting" type="hidden" value="{{$hotlr[0]->duration}}" >
                                </div>
                                <div class="col-4">
                                    <button class="btn btn-primary mt-4" type="button" onclick="updateAuditTime()">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-js')
<script>
    const updateAuditSetting = "{{ route('audit-setting-update') }}";
</script>
<script src="{{asset('backend/assets/js/custom/setting/audit.js')}}"></script>
@endsection
