@extends('backend.layouts.main')
@section('title','Nightaudit Revenue Audit')
@section('main-container')
 <div class="page-body">
    <div class="container-fluid">
        <div class="page-title mt-2">
            <div class="row gx-0">
                <div class="col-12 col-sm-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <h3 class="d-block">Revenue Audit</h3>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-warning ms-2 px-3 d-inline-block text-center" type="button" onClick="exportRevenueAudit()">
                                <div class="d-flex flex-row align-items-center">
                                    <i class="ri-file-excel-line me-2"></i>
                                    <span>Export</span>
                                </div>
                            </button>
                        </div>
                    </div>
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
                            <table class="table hover row-border stripe table-sm" id="basic-1">
                                <thead>
                                    <tr>
                                        <th>Mode</th>
                                        <th>Amount</th> 
                                        <th>Department</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($paymentList as $list)
                                    <tr>
                                        <td>{{$list['name']}}</td>
                                        <td>{{$list['amount']}}</td>
                                        <td>{{$list['department']}}</td>
                                        <td> 
                                            <div class="form-check checkbox checkbox-primary mb-0">
                                                <input class="form-check-input" id="checkbox-primary-23{{$list['id']}}" type="checkbox">
                                                <label class="form-check-label my-1" for="checkbox-primary-23{{$list['id']}}"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
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
    function exportRevenueAudit(){
      window.open('/nightaudit/revenue-audit-print');
    }
  </script>
@endsection
