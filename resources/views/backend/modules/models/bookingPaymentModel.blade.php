<div class="position-absolute bg-primary d-block p-2 rounded-start" id="dtab-showbtn" onClick="getPaymentDetailRemaining()"><i class="icon-angle-left"></i>
</div>
<div class="reservation-summary px-3 py-2 bg-light ">
    <h4 class="text-uppercase my-2">Booking Summary</h4>
    <div class="my-2">
        <label class="d-flex justify-content-between d-none"><div><span>Reservation Info</span></div><div><span class="reservation_last_payment">0</span><i class="icon-info-alt text-primary ms-1"></i></div> </label>
        <label class="d-flex justify-content-between"><div><span>Room Total</span></div><div><span class="me-1">₹ </span><span class="room_total_amount"> 0</span><span class="no_of_nights d-none">1</span><span class="no_of_stay ms-1">(1 Night)</span></div></label>
        <label class="d-flex justify-content-between"><div><span>Extra Person Total</span></div><div><span class="extra_total_person">0</span></div> </label>
        <label class="d-flex justify-content-between"><div><span>Extra Total</span></div><div><span class="me-1">₹ </span><span class="extra_total_amount">0</span></div></label>
        <label class="d-flex justify-content-between "><div><span>Discount Total <span class="discount_percentage_reservation"></span></span></div><div class="text-danger"><span class="me-1">₹ </span><span class="discount_total_room">0</span></div></label>
        <div class="my-2">
            <label class="d-flex justify-content-between"><div><span>Total</span></div><div><span class="me-1">₹ </span><span class="total_final_res_amount"> 0</span></div></label>
            <label class="d-flex justify-content-between border-bottom pb-2"><div><span>Total Received</span></div><div><span class="me-1">₹ </span><span class="total_received">0</span></div></label>
        </div>
        <div class="my-2">
            <h4 class="d-flex justify-content-between text-danger"><div><span>Total Outstanding</span></div><div><span class="me-1">₹ </span><span class="total_outstanding">0</span></div></h4><br>
            <button class="btn btn-success w-100 btn-sm p-recordBtnShow text-light btn-dark" onClick="getPaymentDetailRemaining()">Record Payment</button>
        </div>
    </div>
</div>
