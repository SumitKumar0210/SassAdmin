@extends('admin.layouts.app')

@section('title', 'Feature List')

@section('styles')
<link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/vendors/datatables.css') }}">
@endsection

@section('content')
<div class="page-body">
    <div class="container-fluid">

        {{-- Page Title --}}
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Features</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <button class="btn btn-primary" id="openCreateModal">
                        <i class="fa fa-plus"></i> Add Feature
                    </button>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="card">
            <div class="card-body">
                <div class="dt-ext table-responsive theme-scrollbar">
                    <table class="display" id="export-button">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Feature Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($features as $feature)
                            <tr>
                                <td>{{$loop->index +1}}</td>
                                <td>{{$feature->name}}</td>
                                <td class="feature-status">
                                    {!! $feature->status
                                    ? '<span class="badge bg-success">Active</span>'
                                    : '<span class="badge bg-danger">Inactive</span>' !!}
                                </td>
                                <td>
                                    <ul class="action">
                                        <li class="">
                                            <a href="#"
                                                class="editFeature"
                                                data-id="{{ $feature->id }}"
                                                data-name="{{ $feature->name }}"
                                                data-status="{{ $feature->status }}"
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="bottom"
                                                data-bs-original-title="Edit"><i class="icon-pencil-alt"></i></a>
                                        </li>
                                        <li class="delete">
                                            <a href="javascript:void(0)"
                                                class="deleteFeature"
                                                data-id="{{ $feature->id }}"
                                                data-name="{{ $feature->name }}"
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

{{-- CREATE / EDIT MODAL --}}
<div class="modal fade" id="featureModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form id="featureForm">
                @csrf
                <input type="hidden" id="feature_id">

                <div class="modal-header">
                    <h5 class="modal-title">Feature</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Feature Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" id="feature_name" required>
                        <div class="invalid-feedback">Please select status</div>
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select class="form-select" name="status" id="feature_status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- Delete Feature Modal -->
<div class="modal fade" id="deleteFeatureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-body text-center p-4">
                <img src="{{ asset('admin/assets/images/gif/danger.gif') }}" alt="warning" width="80">

                <h4 class="mt-3">Delete Feature?</h4>

                <p class="text-muted mb-3">
                    Are you sure you want to delete
                    <strong id="deleteFeatureName"></strong>?
                    <br>
                    This action cannot be undone.
                </p>

                <form id="deleteFeatureForm">
                    @csrf
                    <input type="hidden" id="deleteFeatureId">

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
    $(document).ready(function() {

                /* ---------- OPEN CREATE MODAL ---------- */
                $('#openCreateModal').on('click', function() {
                    $('#featureForm')[0].reset();
                    $('#feature_id').val('');
                    $('#featureModal').modal('show');
                });

                /* ---------- OPEN EDIT MODAL ---------- */
                $('.editFeature').on('click', function() {
                    $('#feature_id').val($(this).data('id'));
                    $('#feature_name').val($(this).data('name'));
                    $('#feature_status').val($(this).data('status'));
                    $('#featureModal').modal('show');
                });

                /* ---------- SAVE (CREATE / UPDATE) ---------- */
                $('#featureForm').on('submit', function(e) {
                    e.preventDefault();

                    let id = $('#feature_id').val();
                    let url = id ?
                        "{{ route('admin.features.update', ':id') }}".replace(':id', id) :
                        "{{ route('admin.features.store') }}";

                    $.ajax({
                        url: url,
                        type: "POST",
                        data: $(this).serialize(),
                        success: function(res) {
                            AppAlert.success(res.message);
                            location.reload();
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                let errors = Object.values(xhr.responseJSON.errors)
                                    .flat().join('\n');
                                AppAlert.error(errors);
                            } else {
                                AppAlert.error('Something went wrong');
                            }
                        }
                    });
                });

                /* ---------- OPEN DELETE MODAL ---------- */
                $('.deleteFeature').on('click', function() {

                    let id = $(this).data('id');
                    let name = $(this).data('name');

                    $('#deleteFeatureId').val(id);
                    $('#deleteFeatureName').text(name);

                    $('#deleteFeatureModal').modal('show');
                });

                /* ---------- CONFIRM DELETE ---------- */
                $('#deleteFeatureForm').on('submit', function(e) {
                    e.preventDefault();

                    let id = $('#deleteFeatureId').val();

                    $.ajax({
                        url: "{{ route('admin.features.destroy', ':id') }}".replace(':id', id),
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            $('#deleteFeatureModal').modal('hide');
                            AppAlert.success(res.message);
                            location.reload();
                        },
                        error: function() {
                            AppAlert.error('Delete failed');
                        }
                    });
                });
            });
</script>
@endsection