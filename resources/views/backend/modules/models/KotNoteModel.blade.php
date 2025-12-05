<!-- Note Modal  start-->
<div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="noteModalLabel">Add Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label class="form-label" for="order_note">Note</label>
                    <textarea class="form-control form-control-sm" id="order_note" rows="2"></textarea>
                </div>
            </div>
        </div>
        </div>
        <div class="modal-footer justify-content-between flex-nowrap">
        <button type="button" class="btn btn-outline-danger w-50" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary w-50" onclick="addOrderNote()">Submit</button>
        </div>
    </div>
    </div>
</div>
<!-- Note Modal  end-->