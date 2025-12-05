let kotItemList = [];
let orderNote = '';
let tableCustomer = [];

function getKotDetail(id,kot_id){
    kotItemList = [];
    $.ajax({
        url: QrkotDetail,
        data:{id:id,kot_id:kot_id},
        type: "POST",
        success: function(response) {
            console.log(response);
            $('.qr_menu_generate_kot_id').html(id);
            $('.generated-kot-item-list').html('');
            $('.generated-table-room-number').html('');
            kotItemList.push(response.kotDetail);
            $('.generated-table-room-number').html(response.kots[0]['type_number']);
            $.each(kotItemList[0], function(key,kot){
                $('#generated-discount-type-select').val(kot.discount_type);
                $('#generated-discount-value').val(kot.discount_value);
                $('#generated_coupon_value').val(kot.coupon_amount);
                $('#generated-grand-gst-amount').val(kot.total_gst);
                $('#generated-subtotal-amount').val(kot.sub_total);
                $('#generated-total-adjustment').val(kot.adjustment);
                $('.generated-grand-total-amount').html(kot.grand_total);
                $("input[name='paymentTypeGenerated']").prop("checked", false);
                $("input[name='paymentTypeGenerated'][value='"+kot.payment_type+"']").prop("checked", true);
                $('#kot_waiter').val(kot.waiter_prev);
                $('.waiter_name_display').html($("#kot_waiter option:selected").text());
                $('.table-area-room-no').html(kot.type);
                if(kot.type == 'Room'){
                    $('.convert-to-room-kot').hide();
                }
                $('.convert-to-room-kot').attr("onclick", "getKotId(" + kot.id + ")");
            });
            drawKotArea();
        }
    });
}

function drawKotArea(){
    let output ='';
    let total =0;
    let gst_total =0;
    let grand =0;
    $('.generated-kot-item-list').empty();
    $.each(kotItemList[0], function(key,kot){
        output +=`<tr>
            <td colspan="4" class="py-1 kot-title">KOT - ${kot['id']}  <span class="ms-2">Time - ${kot['time']}</span></td>
        </tr>`;
        $.each(kot['items'], function(key,item){
            output +=`<tr>
                <td onClick="removeCart(${item['id']})"><span class="me-2 badge badge-danger rounded-circle cancel-item" ><i class="ri-close-line"></i></span><a href="#">${item['item_name']}</a></td>
                <td class="text-center"></td>
                <td class="text-center">
                    <div class="touchspin-wrapper"> 
                        <input class="input-touchspin spin-outline-primary" type="number" value="${item['qty']}" readonly>
                    </div>
                </td>
                <td class="text-end">${item['total']} <span class="d-block"><small><a href="#">${item['price']}</a></small></span></td>
            </tr>`;
            total = parseFloat(total) + parseFloat(item['total']);
            gst_total = parseFloat(gst_total) + parseFloat(item['gst_amount']);
        });
    });
    grand = parseFloat(total) + parseFloat(gst_total);
    $('.generated-kot-item-list').html(output);
    $('.generated_total').html(total);
    $('#generated-grand-gst-amount').html(gst_total);
    $('.generated-grand-total-amount').html(grand);
    $('#generated-subtotal-amount').val(grand);
}

function removeCart(x){
    $.each(kotItemList[0], function(key,kot){
        $.each(kot['items'], function(key,item){
            kot['items'] = kot['items'].filter((item) => item.id !== x);
        });
    });
    drawKotArea();
}

function calculateTotal(change = ''){
    
    let subtotal = 0;
    let adjustment = $('#generated-total-adjustment').val() || 0;
    if(parseFloat($('#generated-total-adjustment').val()) > 10){
        $('#generated-total-adjustment').val(10);
    }
    adjustment = $('#generated-total-adjustment').val() || 0;
    let grand_total = 0;
    let total = parseFloat($('.generated_total').html());
    
    if(change == ''){
        let discount_type = $('#generated-discount-type-select').val();
        let dis = $('#generated-discount-value').val();
        let discount = 0;
        let calGst = 0;
        if(dis != ''){
            if(discount_type == 'percent'){
                if(dis > 100){
                    $('#generated-discount-value').val(0);
                    discount = 0;
                    $('.alert_msg_danger').html('discount percentage cannot be greater than 100');
                    var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                    toast.show();
                }else{
                    $.each(kotItemList[0], function(key,kot){
                        $.each(kot['items'], function(key,item){
                            let total_item = item.price * item.qty;
                            let dis_amt = (parseFloat(dis)/100) * parseFloat(total_item);
                            let after_dis_amount = (total_item - dis_amt);
                            let gst_amount = (parseFloat(item.gst)/100) * after_dis_amount;
                            calGst += parseFloat(gst_amount);
                        });
                    });
                }
            }else{
                 $.each(kotItemList[0], function(key,kot){
                    $.each(kot['items'], function(key,item){
                        let total_item = item.price * item.qty;
                        let dis_amt = (parseFloat(dis)) / parseFloat(kot['items'].length);
                        let after_dis_amount = (total_item - dis_amt);
                        let gst_amount = (parseFloat(item.gst)/100) * after_dis_amount;
                        calGst += parseFloat(gst_amount);
                    });
                });
            }
        }
        if(dis > 0){
           calGst = calGst.toFixed(2)
           $('#generated-grand-gst-amount').val(calGst);
        }
    }
    
    let gst_amount = parseFloat($('#generated-grand-gst-amount').val());
    let amount_after_dis = parseFloat(total);
    subtotal = parseFloat(amount_after_dis) + parseFloat(gst_amount);
    if(adjustment > 10){
        $('#generated-total-adjustment').val(10);
        adjustment = 0;
    }
    $('#generated-subtotal-amount').val(subtotal.toFixed(2));
    grand_total = parseFloat(subtotal) - parseFloat(adjustment);
    if($("#generated_complimentary_offer").prop('checked') == true){
        grand_total = 0;
    }else{
        if(adjustment > subtotal){
            $('.alert_msg_danger').html('Adjustment Amount is always less than Total Amount');
            var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
            toast.show();
            grand_total = subtotal;
        }else{
            grand_total = subtotal - adjustment;
        }
    }

    $('.generated-grand-total-amount').html(grand_total.toFixed(2));
}

function addGeneratedKotCustomer(){
    tableCustomer.push({
        name: $('#generated_kot_customer_name').val(),
        phone : $('#generated_kot_phone').val(),
    });
    $('#customerModal').modal('hide');
}

function generateKotQr(){

    let id = $('.qr_menu_generate_kot_id').html();
    let total = parseFloat($('.generated_total').html());
    let subtotal = $('#generated-subtotal-amount').val();;
    let gst_amount = parseFloat($('#generated-grand-gst-amount').val());
    let discount_type = $('#generated-discount-type-select').val();
    let discount_value = $('#generated-discount-value').val();
    let adjustment = $('#generated-total-adjustment').val();
    let grand_total =  $('.generated-grand-total-amount').html();;
    let is_complementry = 0;
    if($("#generated_complimentary_offer").prop('checked') == true){
        is_complementry = 1;
    }
    let paymentType = $('[name="paymentTypeGenerated"]:checked').val();
    let payment_card = $('#generated_card_number').val();
    let other_type = $('#generated_other_type').val();
    let other_ref = $('#generated_other_ref_number').val();
    let narration = $('#generated_kot_narration').val();
    let coupon_code ='';
    let apply_coupon = 0;
    if($("#kot_apply_coupon").prop('checked') == true){
        coupon_code = $('#generated_coupon_code').val();
        apply_coupon = 1;
    }
    
    let coupon_value = $('#generated_coupon_value').val();
    if($('#generated_coupon_value').val() == ''){
        coupon_value = 0;
    }
    if(grand_total == ''){
        grand_total = subtotal;
    }
    let total_paid = 0;
    let waiter = $('#kot_waiter').val();
    let waiter_display = $('.waiter_name_display').html();
    if(waiter == '' || waiter_display == ''){
        Swal.fire({
            title: "Please Select Steward",
            icon: "warning"
        }); 
        return;
    }

    $.ajax({
        url: getKotQrDetailUpdate,
        type: "POST",
        data : {id:id,cartItem:kotItemList[0],total_cost:total,discount_type:discount_type,discount_value:discount_value,adjustment:adjustment,grand_total:grand_total,paymentType:paymentType,payment_card:payment_card,other_type:other_type,other_ref:other_ref,coupon_code:coupon_code,coupon_value:coupon_value,complimentary:is_complementry,apply_coupon:apply_coupon,gst_amount:gst_amount,total_paid:total_paid,subtotal:subtotal,waiter_id:waiter,waiter_name:waiter_display,orderNote:orderNote,tableCustomer:tableCustomer,narration:narration},
        success: function(response) {
            if (response.success) {
                $('#offcanvasRight').offcanvas('hide');
                $('.alert_msg').html('Kot Generated Successfully');
                let url = '../../kot/view-kot-print/tokenPara='+id;
                window.open(url,'_blank');
                setTimeout(function() {
                    location.reload();
                }, 2000);
                var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                toast.show(); 
            } else if(response.alreadyfound_error){
                Swal.fire({
                    title: "Something Went Wrong",
                    text: response.alreadyfound_error,
                    icon: "warning"
                });                    
            } else {
                alert("Error");
            }
        }
    });
}

function setWaiter(){
    let waiter = $('#kot_waiter').val();
    if(waiter == ''){
        // toastErrorAlert('Please Select Waiter');
        Swal.fire({
            title: "Please Select Steward",
            icon: "warning"
        }); 
        return;
    }else{
        $('.waiter_name_display').html($("#kot_waiter option:selected").text());
        $('#waiterModal').modal('hide');
    }
}

function addOrderNote(){
    orderNote = $('#order_note').val();
    $('#noteModal').modal('hide');
}

$(document).on('change', 'input[name="paymentTypeGenerated"]', function () {
    let value = $(this).val();

    if (value === 'Card') {
        $('#card-detail').show();
        $('#other-payment').hide();
    } else if (value === 'Other') {
        $('#other-payment').show();
        $('#card-detail').hide();
    } else {
        $('#card-detail, #other-payment').hide();
    }
});