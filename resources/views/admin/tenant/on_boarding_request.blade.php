@extends('admin.layouts.app')

@section('title', 'On Boarding Request List')

@section('styles')

<link rel="stylesheet" type="text/css" href="{{asset('admin/assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('admin/assets/css/vendors/datatable-extension.css')}}">
@endsection

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6 p-0">
                    <h3>On Boarding Request List</h3>
                </div>
                <div class="col-12 col-sm-6 p-0 text-end">
                    <a href="{{route('add.tenant')}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add New Tenant
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header pb-0 card-no-border">
                        <h3>Manage Requests</h3>
                    </div>
                    <div class="card-body">
                        <div class="dt-ext table-responsive theme-scrollbar">
                            <table class="display" id="export-button">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Hotel Name</th>
                                        <th>Woner Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Subdomain</th>
                                        <th>Plan</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($lists as $list)
                                    <tr>
                                        <td>{{$loop->index +1}}</td>
                                        <td>{{$list->hotel_name}}</td>
                                        <td>{{$list->woner_name}}</td>
                                        <td>{{$list->email}}</td>
                                        <td>{{$list->phone}}</td>
                                        <td>{{$list->preferred_subdomain }}</td>
                                        <td>{{$list->plan?->name ?? '-'}}</td>
                                        <td>{{ date('Y-m-d', strtotime($list->created_at)) }}</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="{{route('tenant.editOnBoardingRequest', ['id' => $list->id])}}" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Edit"><i class="icon-pencil-alt"></i></a></li>
                                                <li class="delete">
                                                    <a href="javascript:void(0)"
                                                        class="open-delete-modal"
                                                        data-id="{{ $list->id }}"
                                                        data-name="{{ $list->hotel_name }}"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="bottom"
                                                        title="Delete">
                                                        <i class="icon-trash"></i>
                                                    </a>
                                                </li>
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
    <!-- Delete Tenant Modal -->
    <div class="modal fade" id="deleteTenantModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body text-center p-4">
                    <img src="../assets/images/gif/danger.gif" alt="warning" width="80">

                    <h4 class="mt-3">Delete Tenant?</h4>

                    <p class="text-muted mb-3">
                        Are you sure you want to delete
                        <strong id="tenantName"></strong>?
                        <br>
                        This action cannot be undone.
                    </p>

                    <form id="deleteTenantForm" method="POST">
                        @csrf
                        @method('DELETE')

                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button type="submit" class="btn btn-danger">
                                Yes, Delete
                            </button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="{{asset('admin/assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/jszip.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/buttons.colVis.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/pdfmake.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/vfs_fonts.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/dataTables.autoFill.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/dataTables.select.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/buttons.print.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/dataTables.colReorder.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/dataTables.scroller.min.js')}}"></script>
<script src="{{asset('admin/assets/js/datatable/datatable-extension/custom.js')}}"></script>
<script src="{{asset('admin/assets/js/tooltip-init.js')}}"></script>
<script>
$(document).ready(function () {

    $('.open-delete-modal').on('click', function () {

        let tenantId   = $(this).data('id');
        let tenantName = $(this).data('name');

        // Set tenant name
        $('#tenantName').text(tenantName);

        // Set form action
        $('#deleteTenantForm').attr(
            'action',
            "{{ url('admin/tenants') }}/" + tenantId
        );

        // Show modal
        $('#deleteTenantModal').modal('show');
    });

});
</script>

@endsection