<div class="modal fade" id="kotPaymentModel" tabindex="-1" role="dialog" aria-labelledby="banquetBookingPaymentModel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper  text-start dark-sign-up">
                <div class="modal-header">
                    <h4 class="modal-title roomCategory_title">Add Payment Record</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="record_kot_payment_form" class="needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="col-md-12 mb-3 d-none">
                            <input type="text" class="record_kot_id">
                            <label class="form-label" for="record_kot_amount_total">Paid Amount</label>
                            <input class="form-control form-control-sm" id="record_kot_amount_total" type="text" placeholder="Enter Amount" style="background-image: none;" readonly>
                        </div>
                        <div class="col-md-12 mb-3">
                            
                            <label class="form-label" for="record_kot_amount">Amount</label>
                            <input class="form-control form-control-sm" id="record_kot_amount" type="number" placeholder="Enter Amount" style="background-image: none;" required step="0.01" min="1" readonly>
                            <div class="invalid-feedback">
                                Enter Amount
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="record_kot_pmode">Payment Mode</label>
                            <select  class="form-control form-control-sm" name="" id="record_kot_pmode" style="background-image: none;" required>
                                <option value="">Select</option>
                                @foreach($payments as $pay)
                                    <option value="{{$pay['id']}}">{{$pay['name']}}</option>
                                @endforeach
                            </select>
                        </div>
                            <div class="col-md-12 txnVisibility d-none mb-3">
                            <label class="form-label" for="record_kot_txn">Transaction Number</label>
                            <input class="form-control form-control-sm" id="record_kot_txn" type="text" placeholder="Enter Transaction Number" style="background-image: none;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary payment_collecting_submit " type="submit">Submit</button>
                        <button class="btn btn-primary payment_processing d-none" type="button">Please Wait..</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>