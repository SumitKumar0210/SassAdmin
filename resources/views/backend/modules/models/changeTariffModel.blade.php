<div class="modal fade" id="changeTariffModel" tabindex="-1" role="dialog" aria-labelledby="banquetBookingPaymentModel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper  text-start dark-sign-up">
                <div class="modal-header">
                    <h4 class="modal-title roomCategory_title">Update Tariff</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="change_tariff_form" class="needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 mb-3 d-none">
                                <input type="text" class="change_tariff_reservation_room_id" name="change_tariff_reservation_room_id">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="prev_change_tariff_list">Previous Tariffs</label>
                                <select  class="form-control form-control-sm" id="prev_change_tariff_list" style="background-image: none;" required disabled>
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="prev_change_tariff_amount">Previous Amount</label>
                                <input class="form-control form-control-sm" id="prev_change_tariff_amount" type="number" placeholder="Enter Amount" style="background-image: none;" required step="0.01" min="1" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="change_tariff_list">Tariffs</label>
                                <select  class="form-control form-control-sm" name="change_tariff_list" id="change_tariff_list" style="background-image: none;" required onchange="changeTariffAmount(this.value)">
                                    <option value="">Select</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="change_tariff_amount">Amount</label>
                                <input class="form-control form-control-sm" id="change_tariff_amount" name="change_tariff_amount" type="number" placeholder="Enter Amount" style="background-image: none;" required step="0.01" min="1" value="" required>
                                <div class="invalid-feedback">
                                    Enter Amount
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary payment_collecting_submit " type="submit">Update</button>
                        <button class="btn btn-primary payment_processing d-none" type="button">Please Wait..</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>