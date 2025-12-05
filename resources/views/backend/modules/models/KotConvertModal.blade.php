<div class="modal fade" id="kotModal" tabindex="-1" aria-labelledby="kotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="kotModalLabel">Convert To Room</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="convert_kot_id" />
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Room Number</label>
                        <select class="form-select form-select-sm" id="convert_room_number">
                            <option value="">Select</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-end flex-nowrap">
                <button type="button" class="btn btn-outline-danger w-50" data-bs-dismiss="modal" onclick="convertToRoom()">Submit</button>
            </div>
        </div>
    </div>
</div>