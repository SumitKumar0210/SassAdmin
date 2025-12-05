<!-- Note Modal  start-->
<div class="modal fade" id="earlyCheckinConfirmation" tabindex="-1" aria-labelledby="earlyCheckinConfirmationLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="earlyCheckinConfirmationLabel">Early Check-in Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <div class="d-flex align-items-center gap-3 checkout-format">
                        <span>No</span>
                        <div class="form-check form-switch green-switch">
                            <input class="form-check-input" type="checkbox" checked>
                        </div>
                        <span>Yes</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label text-danger">Note: If not selected one extra day will be add to the bill</label>
                </div>
            </div>
        </div>
        </div>
        <div class="modal-footer justify-content-between flex-nowrap">
        <button type="button" class="btn btn-primary w-50" onclick="ReservationWithCheckin()">OK</button>
        </div>
    </div>
    </div>
</div>
<!-- Note Modal  end-->

<!-- Note Modal  start-->
<div class="modal fade" id="earlyCheckinAlert" tabindex="-1" aria-labelledby="earlyCheckinAlertLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="earlyCheckinAlertLabel">Early Check-in</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-labeltext-danger">Note: You are doing a checkin earlier then usual checkin time.Extra chargeswill be applicable.</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between flex-nowrap">
                <button type="button" class="btn btn-primary w-100 await-time">---</button>
            </div>
        </div>
    </div>
</div>
<!-- Note Modal  end-->