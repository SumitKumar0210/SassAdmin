@extends('backend.layouts.main')
@section('title','Kot Bill')
@section('main-container')
 <div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-12 p-0">
                    <h3>Kot Bill</h3>
                    <span class="random_number d-none">{{$ids}}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-6 offset-6">
                                <div class="float-end checkout-bill-header">
                                    <table>
                                        <tr>
                                            <th>Invoice Date:</th>
                                            <td class="text-end">{{date('d/m/Y')}}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="text-end">To,</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="mb-0 w-100">
                                                    <input class="form-control" type="text" name="guest_name" placeholder="Guest Name" value="{{$basic[0]['customer']}}">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="mb-0 w-100">
                                                    <input class="form-control" type="text" name="gst_number" placeholder="GST Number" value="{{$basic[0]['customer_gst']}}">
                                                </div>
                                            </td>
                                        </tr>
                                        @if($basic[0]['type'] == 'Room')
                                        <tr>
                                            <th>Room Number:</th>
                                            <td class="text-end">{{$basic[0]['type_number']}}</td>
                                        </tr>
                                        @else
                                        <tr>
                                            <th>Table Number:</th>
                                            <td class="text-end">{{$basic[0]['type_number']}}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>Assisted By:</th>
                                            <td class="text-end">{{$basic[0]['bill_by']}}</td>
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
                                            <th>Item Code</th>
                                            <th>Item Name</th>
                                            <th>Qty</th>
                                            <th>Rate</th>
                                            <th class="text-end">Amount</th>
                                        </tr>
                                        @php
                                            $no = 1;
                                            $total_amount = 0;
                                            $gst_total = 0;
                                            $gst = 0;
                                        @endphp
                                        @foreach($kotList as $list)
                                            <tr>
                                                <td>{{$no++}}</td>
                                                <td>{{$list['item_code']}}</td>
                                                <td>{{$list['item_name']}}</td>
                                                <td>{{$list['qty']}}</td>
                                                <td>{{$list['price']}}</td>
                                                <td class="text-end">{{$list['total']}}</td>
                                            </tr>
                                        @php
                                            $total_amount += $list['total'];
                                            $gst_total += $list['gst_amount'];
                                            $gst = $list['gst'];
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
                                    <input class="form-control discount_percentage" type="text" placeholder="0" value="0" onkeyup="calculate()">
                                </div>
                                <input class="form-control tax_value" type="hidden" placeholder="0" value="{{$gst}}" readonly>
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
                                            <td class="text-end">₹ <span class="total_amount">{{$total_amount}}</span></td>
                                        </tr>
                                        <tr class="d-none">
                                            <th>Discount:</th>
                                            <td class="text-end">₹ <span class="total_discount_amount">0</span></td>
                                        </tr>
                                        <tr>
                                            <th>Amount After Discount:</th>
                                            <td class="text-end">₹ <span class="total_discount">{{$total_amount}}</span></td>
                                        </tr>
                                        <tr class="tax-sgst">
                                            <th>SGST(<span class="total_sgst_percent">{{$gst/2}}</span>)%</th>
                                            <td class="text-end">₹ <span class="total_sgst">{{$gst_total/2}}</span></td>
                                        </tr>
                                        <tr class="tax-sgst">
                                            <th>CGST(<span class="total_sgst_percent">{{$gst/2}}</span>)%</th>
                                            <td class="text-end">₹ <span class="total_cgst">{{$gst_total/2}}</span></td>
                                        </tr>
                                        <tr class="tax-igst d-none">
                                            <th>IGST(<span class="total_igst_percent">{{$gst}}</span>)%</th>
                                            <td class="text-end">₹ <span class="total_igst">{{$gst_total}}</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <div class="border py-2 px-2 bg-light">
                                    <h5 class="text-end text-dark">Total Due: ₹ <span class="remaining_amount">{{$total_amount + $gst_total}}</span></h5>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-2">
                                    <label>Payment Mode</label>
                                    <select class="form-select" id="paymentMode" onchange="showRef(this.value)">
                                        <option value="">Select</option>
                                        @foreach($payment_methods as $method)
                                            <option value="{{$method->id}}">{{$method->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-3 reference_view d-none">
                                <div class="mb-2">
                                    <label>Reference Number</label>
                                    <input class="form-control reference_code" type="text" name="reference_code" placeholder="00000000XXXX">
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
   
    <!-- Container-fluid Ends-->
</div>
@endsection
@section('extra-js') 
<script>
    const previewKotInvoice = "{{ route('invoice-kot-preview.previewKotInvoice',':id') }}";
    const invoiceKotGenerate = "{{ route('invoice-kot.generateInvoiceKot') }}";
</script>
<script>
    function calculate(){
        let discount_percentage = 0;
        let tax_value = parseFloat($('.tax_value').val());
        let total_amount = parseFloat($('.total_amount').html());
        let total_discount = parseFloat($('.total_discount').html());
        let round_off = 0;
        
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

        let discount_amount = (discount_percentage/100) * total_amount;
        $('.total_discount_amount').html(Math.round(discount_amount));
        let after_discount_amount = total_amount - discount_amount;
        $('.total_discount').html(Math.round(after_discount_amount));
        let gst_amount = parseFloat($('.total_igst').html());
        let amount_after_tax = after_discount_amount + gst_amount;
        amount_after_tax -= round_off;
        $('.remaining_amount').html(amount_after_tax);
    }

    function showRef(id){
        if(id > 1){
            $('.reference_view').removeClass('d-none');
        }else{
            $('.reference_view').addClass('d-none');
        }
    }

    function showPreview(i = 0){

        let random_number = $('.random_number').html();
        let total_amount = $('.total_amount').html();
        let discount_percentage = $('.discount_percentage').val();
        let dicount_amount = $('.total_discount_amount').html();
        let tax_value = $('.tax_value').val();
        let total_cgst = $('.total_cgst').html();
        let total_sgst = $('.total_sgst').html();
        let total_igst = $('.total_igst').html();
        let round_off = $('.round_off').val();
        let remaining_amount = $('.remaining_amount').html();
        let payment_mode = $('#paymentMode').val();
        let reference_code = $('.reference_code').val();
        let guest_name =  $("input[name='guest_name']").val();
        let company_gst =  $("input[name='gst_number']").val();
        if(i > 0){
            if(payment_mode == '' && remaining_amount > 0){
                toastErrorAlert('Select Payment Mode');
            }else if(payment_mode != '1' && reference_code == '' && remaining_amount > 0){
                toastErrorAlert('Reference Number is required');
            }else{
                $.ajax({
                    url: invoiceKotGenerate,
                    method: "POST",
                    data: {
                        random_number: random_number,total_amount: total_amount,discount_percentage: discount_percentage,dicount_amount: dicount_amount,tax_value:tax_value,total_cgst:total_cgst,total_sgst:total_sgst,total_igst:total_igst,round_off:round_off,remaining_amount:remaining_amount,payment_mode:payment_mode,reference_code:reference_code,guest_name:guest_name,company_gst:company_gst
                    },
                    success: function(data){
                        // console.log(data);
                        if(data.success){
                            showPreview();
                            window.location.href='../kot-generate-bill';
                        }
                    },
                    error: function() {
                        Swal.fire({ icon: "error", title: "An error occurred while generating invoice." });
                    }
                });
            }
        }else{
            let para = 'rand='+random_number+'&total='+total_amount+'&dicount_percentage='+discount_percentage+'&dicount_amount='+dicount_amount+'&tax_value='+tax_value+'&total_cgst='+total_cgst+'&total_sgst='+total_sgst+'&total_igst='+total_igst+'&round_off='+round_off+'&payment_mode='+payment_mode+'&reference_code='+reference_code+'&remaining_amount='+remaining_amount+'&guest_name='+guest_name+'&company_gst='+company_gst+'&show='+0;
            let URL = previewKotInvoice.replace(':id', para);
            window.open(URL, "_blank");
        }
    }
</script>
@endsection