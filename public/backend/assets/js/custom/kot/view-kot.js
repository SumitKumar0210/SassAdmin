getAllViewDetail();

let runningKotList = [];
let completeKotList = [];
let allRoomsList = [];
let allTablesList = [];
let allRoomsListFilter = [];
let allTablesListFilter = [];
let kotItemList = [];
let tableCustomer = [];

function getAllViewDetail(){
    
    $.ajax({
        url: getAllDetail,
        type: "GET",
        success: function(response) {
            allRoomsList.push(response.roomList);
            allTablesList.push(response.tableArea);
            runningKotList.push(response.kotDetail);
            completeKotList.push(response.kotDetailComplete);
            runningKot();
            completeKot();
            filterByCategoryId();
            filterByArea();
        }
    });
}

function runningKot(){
    let output ='';
    $.each(runningKotList[0], function(key,kot){
        let typeClass='';
        if(kot['type'] == 'Table'){
            typeClass='roundedcircle';
        }
        output +=`<div class="kot-item lg booked ${typeClass}" data-bs-toggle="offcanvas" href="#offcanvasRight" role="button" aria-controls="offcanvasRight" onClick="getKotDetail(${kot['id']},'${kot['kot_id']}')">
                    <div>
                        <p class="mb-0 text-center">${kot['diff']} mins</p>
                        <hr>
                        <p class="mb-0 text-center"><span>₹ </span> ${kot['grand_total']}</p>
                    </div>
                    <div class="badge border">${kot['number']}</div>
                    <button class="btn btn-white" type="button">
                        <i class="fa fa-eye"></i>
                    </button>
                </div>`;
    });
    $('.running_kot_room_orders').html(output);
}

function filterByCategoryId(a_id) {
    allRoomsListFilter = [];
    if (!a_id) {
        allRoomsListFilter = allRoomsList[0];
    }else{
        allRoomsListFilter = allRoomsList[0].filter(item => item.category_id == a_id);
    }
    allRooms(a_id);
}

function allRooms(d = 0){
    let output ='';
    let outputSelect ='';
    outputSelect +=`<option value="">All</option>`;
    $.each(allRoomsList[0], function(key, roomsCategory){
        outputSelect +=`<option value="${roomsCategory['category_id']}">${roomsCategory['name']}</option>`;
    });
    $.each(allRoomsListFilter, function(key, roomsCategory){
        $.each(roomsCategory['rooms'], function(key, room){
            output +=`<div class="kot-item mb-2 cursor-pointer" onClick="createKotOption(0,${room['room_number']},${room['id']})">
                    <h6>${room['room_number']}</h6>
                </div>`;
        });
    });
    $('.all_rooms_kot').html(output);
    $('#roomsCategory').html(outputSelect);
    if(d != ''){
        $('#roomsCategory').val(d);
    }else{
        $('#roomsCategory').val('');
    }
}

function filterByArea(a_id) {
    allTablesListFilter = [];
    if (!a_id) {
        allTablesListFilter = allTablesList[0];
    }else{
        allTablesListFilter = allTablesList[0].filter(item => item.area === a_id);
    }
    allTables(a_id);
}

function allTables(d = 0){
    let output ='';
    let outputSelect ='';
    outputSelect +=`<option value="">All</option>`;
    $.each(allTablesList[0], function(key, tableArea){
        outputSelect +=`<option value="${tableArea['area']}">${tableArea['area']}</option>`;
    });
    $.each(allTablesListFilter, function(key, tableArea){
        $.each(tableArea['table'], function(key, tab){
            output +=`<div class="kot-item mb-2 roundedcircle cursor-pointer" onClick="createKotOption(1,${tab['number']},${tab['id']})">
                    <h6>${tab['number']}</h6>
                </div>`;
        });
    });
    $('.all_tables_kot').html(output);
    $('#tableArea').html(outputSelect);
    if(d != ''){
        $('#tableArea').val(d);
    }else{
        $('#tableArea').val('');
    }
}

function getKotDetail(id,kot_id){
    kotItemList = [];
    $.ajax({
        url: kotDetail,
        data:{id:id,kot_id:kot_id},
        type: "POST",
        success: function(response) {
            // console.log(response);
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
                $('#generated_kot_narration').html(kot.narration);
                $("input[name='paymentTypeGenerated']").prop("checked", false);
                $("input[name='paymentTypeGenerated'][value='"+kot.payment_type+"']").prop("checked", true);
                $('.waiter_name_display').html(kot.waiter_name);
                $('.table-area-room-no').html(kot.type);
                if(kot.type == 'Room'){
                    $('.convert-to-room-kot').hide();
                }
                $('.convert-to-room-kot').attr("onclick", "getKotId(" + kot.id + ")");
                $('.print-kot-preview').attr("onclick", "printKot('" + kot_id + "')");
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
    $.each(kotItemList[0], function(key,kot){
        output +=`<tr>
            <td colspan="4" class="py-1 kot-title">KOT - ${kot['id']}  <span class="ms-2">Time - ${kot['time']}</span><span class="ms-2" onclick="getPrintKot(${kot['id']})"><i class="ri-printer-line"></i></span></td>
        </tr>`;
        $.each(kot['items'], function(key,item){
            output +=`<tr>
                <td><a href="#">${item['item_name']}</a></td>
                <td class="text-center"></td>
                <td class="text-center">
                    <div class="touchspin-wrapper"> 
                        <button type="button" class="decrement-touchspin btn-touchspin spin-border-primary" onClick="addToCart(${item['id']},'${item['gst']}',2,${kot['id']})"><i class="ri-subtract-fill"></i></button>
                        <input class="input-touchspin spin-outline-primary" type="number" value="${item['qty']}">
                        <button type="button" class="increment-touchspin btn-touchspin spin-border-primary" onClick="addToCart(${item['id']},'${item['gst']}',1,${kot['id']})"><i class="ri-add-fill"></i></button>
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
    calculateTotal();
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
    $('#generated-subtotal-amount').val(subtotal.toFixed(2));
    if(adjustment > 10){
        $('#generated-total-adjustment').val(10);
        adjustment = 0;
    }
    grand_total = parseFloat(subtotal) - parseFloat(adjustment);
    if($("#generated_complimentary_offer").prop('checked') == true){
        grand_total = 0;
    }

    if(adjustment > subtotal){
        $('.alert_msg_danger').html('Adjustment Amount is always less than Total Amount');
        var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
        toast.show();
        grand_total = subtotal;
    }else{
        grand_total = subtotal - adjustment;
    }

    $('.generated-grand-total-amount').html(grand_total.toFixed(2));
}

function addToCart(id,gst,type = 0,parent_kot){
    let newqty = 1;
    $.each(kotItemList[0], function(key, kotItem){
        if(kotItem['id'] == parent_kot){
            $.each(kotItem['items'], function(index, item) {
                let price = parseFloat(item.price);
                if (item.id === parseInt(id)) {
                    
                    if(type == 2){
                        item.qty = parseInt(item.qty) - parseInt(newqty);
                    }else{
                        item.qty = parseInt(item.qty) + parseInt(newqty);
                    }
                    item.total = parseFloat(item.qty) * parseFloat(price);
                    let gst_amount = (gst/100) * (newqty * price);
                    item.gst_amount = parseFloat(item.gst_amount) + parseFloat(gst_amount);
                    item.grand_amount = (parseFloat(newqty) * parseFloat(price)) + parseFloat(gst_amount) + parseFloat(item.grand_amount);
                    return false; 
                }
            });
        }
    });
    drawKotArea();
}

function addGeneratedKotCustomer(){
    tableCustomer.push({
        name: $('#generated_kot_customer_name').val(),
        phone : $('#generated_kot_phone').val(),
    });
    $('#customerModal').modal('hide');
}

function updateKot(){
    let total = parseFloat($('.generated_total').html());
    let subtotal = $('#generated-subtotal-amount').val();;
    let gst_amount = parseFloat($('#generated-grand-gst-amount').val());
    let discount_type = $('#generated-discount-type-select').val();
    let discount_value = $('#generated-discount-value').val();
    let adjustment = $('#generated-total-adjustment').val();
    let grand_total =  $('.generated-grand-total-amount').html();;
    let is_complementry =0;
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
    
    if($("#record-payment").prop('checked') == true){
        total_paid = parseFloat(grand_total);
    }

    if(paymentType == 'Due' || paymentType == 'Complete with Due'){
        total_paid = 0;
    }
    $.ajax({
        url: updatekotDetail,
        type: "POST",
        data : {cartItem:kotItemList[0],total_cost:total,discount_type:discount_type,discount_value:discount_value,adjustment:adjustment,grand_total:grand_total,person:tableCustomer,paymentType:paymentType,payment_card:payment_card,other_type:other_type,other_ref:other_ref,coupon_code:coupon_code,coupon_value:coupon_value,complimentary:is_complementry,apply_coupon:apply_coupon,gst_amount:gst_amount,total_paid:total_paid,subtotal:subtotal,narration:narration},
        success: function(response) {
            if (response.success) {
                $('#offcanvasRight').offcanvas('hide');
                if(paymentType == 'Due'){
                    $('.alert_msg').html('Kot Updated Successfully');
                }else{
                    $('.alert_msg').html('Kot Completed Successfully');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
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

function completeKot(){
    let output ='';
    $.each(completeKotList[0], function(key,kot){
        let typeClass='';
        if(kot['type'] == 'Table'){
            typeClass='roundedcircle';
        }
        output +=`<div class="kot-item lg completed ${typeClass}">
                    <div>
                        <p class="mb-0 text-center">${kot['diff']} mins</p>
                        <hr>
                        <p class="mb-0 text-center"><span>₹ </span> ${kot['grand_total']}</p>
                    </div>
                    <div class="badge border">${kot['number']}</div>
                    <button class="btn btn-white" type="button" onClick="printKot('${kot['kot_id']}')">
                        <i class="fa fa-print"></i>
                    </button>
                </div>`;
    });
    $('.completed-kots').html(output);
}

function createKotOption(type,num,id){
    let url = 'generate-kot/tokenPara='+type+'&numPara='+num+'&valuePara='+id;
    window.open(url,'_blank');
}

function getPrintKot(id){
    let url = 'view-kot-print/tokenPara='+id;
    window.open(url,'_blank');
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