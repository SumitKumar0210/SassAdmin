@extends('admin.layouts.app')

@section('title', 'Plan List')

@section('styles')

<link rel="stylesheet" type="text/css" href="{{asset('admin/assets/css/vendors/datatables.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('admin/assets/css/vendors/datatable-extension.css')}}">
<!-- Plugins css Ends-->
@endsection

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6 p-0">
                    <h3>Plans</h3>
                </div>
                <div class="col-12 col-sm-6 p-0 text-end">
                    <a href="{{route('admin.plans.create')}}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add New Plan
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
                        <h3>Plan Management</h3>
                    </div>
                    <div class="card-body">
                        <div class="dt-ext table-responsive theme-scrollbar">
                            <table class="display" id="export-button">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Billing Cycle</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($plans as $plan)
                                    <tr>
                                        <td>{{$loop->index +1}}</td>
                                        <td>{{$plan->name}}</td>
                                        <td>{{$plan->price}}</td>
                                        <td>{{$plan->billing_cycle}}</td>
                                        <td>
                                            <ul class="action">
                                                <li class="edit"> <a href="{{route('admin.plans.edit',['id' => $plan->id])}}" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="Edit"><i class="icon-pencil-alt"></i></a></li>
                                                <li class="delete">
                                                    <a href="javascript:void(0)"
                                                        class="open-delete-modal"
                                                        data-id="{{ $plan->id }}"
                                                        data-name="{{ $plan->name }}"
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
                    <img src="{{asset('admin/assets/images/gif/danger.gif')}}" alt="warning" width="80">

                    <h4 class="mt-3">Delete Plan?</h4>

                    <p class="text-muted mb-3">
                        Are you sure you want to delete
                        <strong id="tenantName"></strong>?
                        <br>
                        This action cannot be undone.
                    </p>

                    <form id="deletePlanForm">
                        @csrf

                        <input type="hidden" id="deletePlanId">

                        <div class="d-flex justify-content-center gap-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
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

    <!-- Container-fluid Ends-->
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

</script>
<script>
    $(document).ready(function() {

        let deletePlanId = null;

        /* ---------- OPEN DELETE MODAL ---------- */
        $('.open-delete-modal').on('click', function() {

            deletePlanId = $(this).data('id');
            let planName = $(this).data('name');

            $('#tenantName').text(planName);
            $('#deleteTenantModal').modal('show');
        });

        /* ---------- AJAX DELETE ---------- */
        $('#deletePlanForm').on('submit', function(e) {
            e.preventDefault();

            if (!deletePlanId) return;

            $.ajax({
                url: "{{ route('admin.plans.destroy', ':id') }}".replace(':id', deletePlanId),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {

                    if (response.success) {
                        $('#deleteTenantModal').modal('hide');

                        // Optional alert (replace with toast if you want)
                        AppAlert.success(response.message);

                        // Reload page
                        location.reload();
                    } else {
                        AppAlert.error(response.message || 'Something went wrong');
                    }
                },
                error: function() {
                    alert('Failed to delete plan. Please try again.');
                }
            });
        });

    });
</script>

@endsection