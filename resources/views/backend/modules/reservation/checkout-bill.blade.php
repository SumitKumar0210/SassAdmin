@extends('backend.layouts.main')
@section('title','Reservation Checkout Bill')
@section('main-container')
 <div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-12 p-0">
                    <h3>Check Out Bill</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    @foreach ($reservations as $reservation)
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-4">
                                <div class="mb-3">
                                    <label>Add Notes</label>
                                    <textarea class="form-control" id="notes" rows="2"></textarea>
                                    <span class="random_number d-none">{{$random_id}}</span>
                                </div>
                                <div class="checkout-bill-header">
                                    <table>
                                        <tr>
                                            <th colspan="2">To,</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="mb-0 w-100">
                                                    <input class="form-control" type="text" name="guest_name" placeholder="Guest Name" value="{{$reservation->first_name}} {{$reservation->last_name}}">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th colspan="2">
                                                @if($reservation->address != '') {{$reservation->address}}, @endif
                                                @if($reservation->city != '') {{$reservation->city}}, @endif
                                                @if($reservation->state != '') {{$reservation->state}} @endif
                                                @if($reservation->pincode != '') - {{$reservation->pincode}}@endif
                                                @if($reservation->country != ''), {{$reservation->country}} @endif
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="2" >
                                                @if($reservation->company_name != '') {{$reservation->company_name}}, @endif
                                                @if($reservation->company_gst != '') <br>{{$reservation->company_gst}} @endif
                                                @if($reservation->company_address != '') <br><small style="font-weight: 500">{{$reservation->company_address}}</small> @endif
                                            </th>
                                            <input class="form-control" type="hidden" name="company_gst" placeholder="N/A" value="{{$reservation->company_gst}}">
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="col-4 offset-4">
                                <div class="float-end checkout-bill-header">
                                    <table>
                                        <tr>
                                            <th>Invoice Date:</th>
                                            <td class="text-end">{{date('d/m/Y')}}</td>
                                        </tr>
                                        <tr>
                                            <th>Invoice Time:</th>
                                            <td class="text-end">{{date('h:i A')}}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="text-end">From,</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-end">{{$hotlr[0]->name}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"  class="text-end">{{$hotlr[0]->gst}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"  class="text-end">{{$hotlr[0]->mobile}}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="text-end">
                                                @if($hotlr[0]->address != '') {{$hotlr[0]->address}}, @endif
                                                @if($hotlr[0]->state != '') {{$hotlr[0]->state}} @endif
                                                @if($hotlr[0]->pincode != '') - {{$hotlr[0]->pincode}} @endif
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Check In Date:</th>
                                            <td class="text-end">{{$checkin_date}}</td>
                                        </tr>
                                        <tr>
                                            <th>Check In Time:</th>
                                            <td class="text-end">{{$checkin_time}}</td>
                                        </tr>
                                        <tr>
                                            <th>Check Out Date:</th>
                                            <td class="text-end">{{$checkout_date}}</td>
                                        </tr>
                                        <tr>
                                            <th>Check Out Time:</th>
                                            <td class="text-end">{{$checkout_time}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="room-tariff-details">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Room Type</th>
                                            <th>Room No</th>
                                            <th>Tariff Type</th>
                                            <th>Room Tariff</th>
                                            <th>Occupancy Type</th>
                                            <th>No Of Days</th>
                                            <th class="text-end">Amount</th>
                                        </tr>
                                        @php
                                            $grand_total =0;
                                            $no = 1;
                                        @endphp
                                        @foreach($reserved_room as $room)
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$room['room_type']}}</td>
                                            <td>{{$room['room_number']}}</td>
                                            <td>{{$room['tariff_type']}}</td>
                                            <td>{{$room['room_tariff']}}</td>
                                            <td>{{$room['adults'] + $room['extra_person']}}</td>
                                            <td><input type="hidden" value="{{$room['days']}}" name="no_of_days[]"/>{{intval($room['days'])}}</td>
                                            <td class="text-end">{{$room['total']}}</td>
                                        </tr>
                                        @php
                                            $grand_total += $room['total'];
                                        @endphp
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-3 col-sm-12">
                                <div class="mb-2">
                                    <label>Discount (%)</label>
                                    @php
                                        $discount = 0;
                                        if($reservation->discount > 0){
                                            $discount = $reservation->discount;
                                        }
                                    @endphp
                                    <input class="form-control discount_percentage" type="text" placeholder="0" value="{{$discount}}" onkeyup="calculate()">
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <label>GST Type</label>
                                        <select class="form-select tax_type" onchange="setTax(this.value)">
                                            @foreach($taxList as $key => $tax)
                                            <option value="{{$tax['value']}}">{{$tax['name']}}({{$tax['value']}}%)</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label>GST (%)</label>
                                        <input class="form-control tax_value" type="text" placeholder="0" value="{{$default_tax}}" readonly>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label>Round Off</label>
                                    <input class="form-control round_off" type="text" placeholder="0" onkeyup="calculate()">
                                </div>
                            </div>
                            <div class="col-5 offset-4">
                                <div class="float-end checkout-bill-header">
                                    <table>
                                        <tr>
                                            <th>Amount:</th>
                                            <td class="text-end">₹ <span class="total_amount">{{$grand_total}}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Discount:</th>
                                            <td class="text-end">₹ <span class="total_discount_amount">0</span></td>
                                        </tr>
                                        <tr>
                                            <th>Amount After Discount:</th>
                                            <td class="text-end">₹ <span class="total_discount">0</span></td>
                                        </tr>
                                        <tr class="tax-sgst">
                                            <th>SGST(<span class="total_sgst_percent">0</span>)%</th>
                                            <td class="text-end">₹ <span class="total_sgst">0</span></td>
                                        </tr>
                                        <tr class="tax-sgst">
                                            <th>CGST(<span class="total_sgst_percent">0</span>)%</th>
                                            <td class="text-end">₹ <span class="total_cgst">0</span></td>
                                        </tr>
                                        <tr class="tax-igst d-none">
                                            <th>IGST(<span class="total_igst_percent">0</span>)%</th>
                                            <td class="text-end">₹ <span class="total_igst">0</span></td>
                                        </tr>
                                        <tr>
                                            <th>Sub Total</th>
                                            <td class="text-end">₹ <span class="sub_total">0</span></td>
                                        </tr>
                                        <tr>
                                            <th>Advance Amount</th>
                                            <td class="text-end">₹ <span class="advance_amount">{{$total_advance_payment}}</span></td>
                                        </tr>
                                        <tr>
                                            <th><div class="form-check"><input class="form-check-input room_checked-element" type="checkbox" id="check_use_advance" checked="">Use Advance</div> </th>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <div class="border py-2 px-2 bg-light">
                                    <h5 class="text-end text-dark">Total Due: ₹ <span class="remaining_amount">0</span></h5>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-2">
                                    <label>Payment Mode</label>
                                    <select class="form-select" id="paymentMode">
                                        <option value="">Select</option>
                                        @foreach($payment_methods as $method)
                                        <option value="{{$method->id}}">{{$method->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-3" id="chequeField" style="display: none;">
                                <div class="mb-2">
                                    <label>Cheque Number</label>
                                    <input class="form-control cheque_number" name="cheque" type="text" placeholder="00000000000000">
                                </div>
                            </div>

                            <div class="col-3" id="upiField" style="display: none;">
                                <div class="mb-2">
                                    <label>Reference Number</label>
                                    <input class="form-control reference_code" type="text" name="reference_code" placeholder="000000000000000">
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="d-flex justify-content-end align-item-center">
                                   <button class="btn btn-secondary me-2" type="button" onClick="showPreview()">Preview</button>
                                   <button class="btn btn-primary ms-2" type="button" onClick="showPreview(1)">Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- Container-fluid Ends-->
</div>
@endsection
@section('extra-js') 
<script>
    const previewInvoice = "{{ route('checkout.previewInvoice',':id') }}";
    const invoiceGenerate = "{{ route('invoice.generateInvoice') }}";
</script>
<script>
    const paymentMode = document.getElementById('paymentMode');
    const upiField = document.getElementById('upiField');

    paymentMode.addEventListener('change', function () {
        chequeField.style.display = 'none';
        upiField.style.display = 'none';
        if (this.value > 1) {
            upiField.style.display = 'block';
        }
    });

    function setTax(x){
        $('.tax_value').val(x);
        calculate();
    }

    calculate();
    function calculate(){
        let discount_percentage = 0;
        let tax_value = parseFloat($('.tax_value').val());
        let total_amount = parseFloat($('.total_amount').html());
        let total_discount = parseFloat($('.total_discount').html());
        let round_off = 0;
        let tax_type = parseFloat($('.tax_type').val());
        let remaining_amount = parseFloat($('.remaining_amount').html());
        let advance_amount = 0;
        if ($('#check_use_advance').is(':checked')) {
            advance_amount = parseFloat($('.advance_amount').html());
        }
        
        if($('.discount_percentage').val() != ''){
            discount_percentage = parseFloat($('.discount_percentage').val());
        }

        if($('.round_off').val() != ''){
            if(parseFloat($('.round_off').val()) > 10){
                Swal.fire({
                    title: "Round Off Amount cannot be more than 10",
                    icon: "warning",
                    confirmButtonText: "OK"
                });
                $('.round_off').val(10);
                round_off = 10;
            }else{
                round_off = parseFloat($('.round_off').val());
            }
        }

        let tax_text = $('.tax_type option:selected').text();
        if(tax_value > 0){
            $('.total_sgst_percent').html(tax_value/2);
            $('.total_igst_percent').html(tax_value);
        }

        if (tax_text.startsWith("I")) {
            $('.tax-sgst').addClass('d-none');
            $('.tax-igst').removeClass('d-none');
        }else{
            $('.tax-sgst').removeClass('d-none');
            $('.tax-igst').addClass('d-none');
        }

        let discount_amount = (discount_percentage/100) * total_amount;
        $('.total_discount_amount').html(Math.round(discount_amount));
        let after_discount_amount = total_amount - discount_amount;
        $('.total_discount').html(Math.round(after_discount_amount));
        let gst_amount = (tax_value/100) * after_discount_amount;
        $('.total_sgst').html(Math.round(gst_amount/2));
        $('.total_cgst').html(Math.round(gst_amount/2));
        $('.total_igst').html(Math.round(gst_amount));
        let amount_after_tax = after_discount_amount + gst_amount;
        let paid = Math.round(amount_after_tax) - advance_amount;
        $('.sub_total').html(Math.round(amount_after_tax));
        paid -= round_off;
        $('.remaining_amount').html(paid);
    }

    function showPreview(i = 0){

        let random_number = $('.random_number').html();
        let number_of_days = $("input[name='no_of_days[]']").map(function () { return $(this).val();}).get();
        let total_days = number_of_days.reduce(function (sum, val) { return sum + parseInt(val);}, 0);
        let total_amount = $('.total_amount').html();
        let discount_percentage = $('.discount_percentage').val();
        let dicount_amount = $('.total_discount_amount').html();
        let tax_type = $('.tax_type').val();
        let tax_value = $('.tax_value').val();
        let total_cgst = $('.total_cgst').html();
        let total_sgst = $('.total_sgst').html();
        let total_igst = $('.total_igst').html();
        let round_off = $('.round_off').val();
        let remaining_amount = $('.remaining_amount').html();
        let advance_amount = $('.advance_amount').html();
        let payment_mode = $('#paymentMode').val();
        let cheque_number = $('.cheque_number').val();
        let reference_code = $('.reference_code').val();
        let notes = $('#notes').val();
        let guest_name =  $("input[name='guest_name']").val();
        let company_gst =  $("input[name='company_gst']").val();
        if(i > 0){
            if(payment_mode == '' && remaining_amount > 0){
                toastErrorAlert('Select Payment Mode');
            }else if(payment_mode != '1' && reference_code == '' && remaining_amount > 0){
                toastErrorAlert('Reference Number is required');
            }else{
                $.ajax({
                    url: invoiceGenerate,
                    method: "POST",
                    data: {
                        random_number: random_number,number_of_days: total_days,total_amount: total_amount,discount_percentage: discount_percentage,dicount_amount: dicount_amount,tax_type:tax_type,tax_value:tax_value,total_cgst:total_cgst,total_sgst:total_sgst,total_igst:total_igst,round_off:round_off,remaining_amount:remaining_amount,advance_amount:advance_amount,payment_mode:payment_mode,cheque_number:cheque_number,reference_code:reference_code,notes:notes,guest_name:guest_name,company_gst:company_gst
                    },
                    success: function(data){
                        console.log(data);
                        if(data.success){
                            //showPreview();
                            const url = `../../checkedout/${data.invoice_id}`;
                            window.location.href = url;
                        }else if(data.pending){
                            Swal.fire({ icon: "error", title: data.pending });
                             setTimeout(() => {
                                let res = 'reservation='+data.reservation_id+'&reservation_room_id='+data.room_id;
                                let url = '../../reservation/edit-reservation/'+res;
                                window.location.href = url;
                            },3000);
                        }
                    },
                    error: function() {
                        Swal.fire({ icon: "error", title: "An error occurred while generating invoice." });
                    }
                });
            }
        }else{
            let adv = 0;
            if ($('#check_use_advance').is(':checked')) {
                adv = advance_amount;
            } 
            let para = 'rand='+random_number+'&total='+total_amount+'&dicount_percentage='+discount_percentage+'&dicount_amount='+dicount_amount+'&tax_type='+tax_type+'&tax_value='+tax_value+'&total_cgst='+total_cgst+'&total_sgst='+total_sgst+'&total_igst='+total_igst+'&round_off='+round_off+'&advance_amount='+advance_amount+'&payment_mode='+payment_mode+'&cheque_number='+cheque_number+'&reference_code='+reference_code+'&number_of_days='+total_days+'&remaining_amount='+remaining_amount+'&adv_view='+adv+'&show='+0;
            let URL = previewInvoice.replace(':id', para);
            window.open(URL, "_blank");
        }
    }

    $('#check_use_advance').click(function() {
        calculate();
    });

</script>
@endsection