<div class="modal fade" id="kotModalCancel" tabindex="-1" aria-labelledby="kotModalCancelLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="kotModalCancelLabel">Cancel KOT</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Reason</label>
                        <textarea class="form-control form-control-sm" id="kot_cancel_reason" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between flex-nowrap">
                <button type="button" class="btn btn-outline-danger w-50" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary w-50" onclick="cancelKotDetail()">Submit</button>
            </div>
        </div>
    </div>
</div>

{{-- Kot Payment Coolect --}}
<div class="modal fade" id="kotModalPayment" tabindex="-1" role="dialog" aria-labelledby="kotModalPayment" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper  text-start dark-sign-up">
                <div class="modal-header">
                    <h4 class="modal-title roomCategory_title">Record Payment </h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="kot_due_payment_collect" class="needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="col-md-12 mb-3">
                            <input type="hidden" class="kot_collect_id">
                            <label class="form-label" for="kot_collect_paid_amount">Paid Amount</label>
                            <input class="form-control form-control-sm" id="kot_collect_paid_amount" type="number" placeholder="Enter Amount" style="background-image: none;" readonly>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="kot_collect_amount">Amount</label>
                            <input class="form-control form-control-sm" id="kot_collect_amount" type="number" placeholder="Enter Amount" style="background-image: none;" required step="0.01">
                            <div class="invalid-feedback">
                                Enter Amount
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="kot_collect_pmode">Payment Mode</label>
                            <select  class="form-control form-control-sm" name="" id="kot_collect_pmode" style="background-image: none;" required>
                                <option value="">Select</option>
                                @foreach($payments as $pay)
                                <option value="{{$pay['id']}}">{{$pay['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                            <div class="col-md-12 txnVisibility d-none mb-3">
                            <label class="form-label" for="kot_collect_txn">Transaction Number</label>
                            <input class="form-control form-control-sm" id="kot_collect_txn" type="text" placeholder="Enter Transaction Number" style="background-image: none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>