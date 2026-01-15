let itemList = [];
let filterItemList = [];
let cartItem = [];
let basicKot = [];
let person = [];
let orderNote = '';
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

getRestaurantMenu();

function getRestaurantMenu(){

    $.ajax({
        url: getMenuList,
        type: "GET",
        success: function(response) {
            // console.log(response);
            $('.all-kot-itemlist').html('');
            $('#menu-items').html('');
            $('.menu-item').html();
            let menu_list = '';
            let menu_category = '';
            menu_category += `<li class="side-menu active">Favourite</li>`;
            $.each(response.itemLists, function(key, list){
                $.each(list['cat_item'], function(key, item){
                    itemList.push(item);
                });
                $.each(list['sub_categories'], function(key, sub_cat){
                    $.each(sub_cat['items'], function(key, item){
                        itemList.push(item);
                    });
                });
                menu_list += `<option value="${list['id']}">${list['name']}</option>`;
                
                    menu_category += `<li class="side-menu" onClick="setCategory(${list['id']},this)">${list['name']}`;
                    if(list['sub_categories'].length > 0){
                        menu_category += `<span class="float-end fs-6 fw-normal" onClick="setHideShow(${list['id']},this)" style="margin-top:-2px;"><i class="icofont icofont-thin-down" style="font-weight:600;"></i></span>`;
                    }
                    menu_category += `</li>`;
                    if(list['sub_categories'].length > 0){
                        menu_category += `<li class="subCategoryView${list['id']} d-none p-0" >
                        <ul>`;
                        if(list['sub_categories'].length > 0){
                            $.each(list['sub_categories'], function(key, sub_cat){
                                menu_category += `<li class="sub-side-menu" onClick="setSubCategory(${sub_cat['id']},this)">${sub_cat['name']}</li>`;
                            });
                        }
                        menu_category += `</ul></li>`;
                    }
            });
            filterItemList = itemList;
            $('#menu-items').html(menu_list);
            $('.menu-item').html(menu_category);
            createItemList();
        }
    });
}

function createItemList(){
    let output = '';
    filterItemList.sort((a, b) => a.name.localeCompare(b.name));
    $.each(filterItemList, function(key, list){
        let type = '';
        if(list['type'] == 'Non-Veg'){
            type = 'non-';
        }
        output +=`<div class="kot-food-item ${type}veg-item" onClick="addToCart(${list['id']},'${list['name']}','${list['offer_price']}','${list['gst']}')">
            <div>
                <h5 class="mb-0 text-center">${list['name']}</h5>
            </div>
        </div>`;
    });
    $('.all-kot-itemlist').html(output);
}

function addToCart(id,name,price,gst,type = 0){
    let newqty = 1;
    let found = false;
    if(cartItem.length > 0) {
        $.each(cartItem, function(index, item) {
            let price = item.price;
            if (item.id === parseInt(id)) {
                
                if(type == 2){
                    item.qty -= parseInt(newqty);
                }else{
                    item.qty += parseInt(newqty);
                }
                item.total_price = (parseFloat(item.qty) * parseFloat(price));
                let gst_amount = (parseFloat(gst)/100) * (parseFloat(newqty) * parseFloat(price));
                item.gst_amount += parseFloat(gst_amount);
                item.mrp += (parseFloat(newqty) * parseFloat(price)) + parseFloat(gst_amount);
                found = true;
                return false; 
            }
        });
    }

    if(!found) {
        var rnd = Math.floor(1000 + Math.random() * 9000);
        if(newqty > 0){
            let gst_amount = (gst/100) * (newqty * parseFloat(price));
            let mrp = (newqty * parseFloat(price)) + gst_amount;
            cartItem.push({
                id: id,
                qty: newqty,
                rnd:rnd,
                name:name,
                price: parseFloat(price),
                total_price:parseFloat(newqty) * parseFloat(price),
                gst: gst,
                gst_amount: Math.round(gst_amount),
                mrp: mrp,
            });
        }
    }

    let sound = document.getElementById('clickSound');
    sound.currentTime = 0; // restart sound
    sound.play();
    setTimeout(() => {
        sound.pause();       // stop sound after 1 sec
        sound.currentTime = 0; // reset again (optional)
    }, 1000);
    $('#searchItemDropdown').empty();
    $('#searchItemDropdown').addClass('d-none');
    drawCart();
}

function drawCart(){
    let total_amount = 0;
    let grand_gst_amount = 0;
    let grand_total_amount = 0;
    $('.cart-items').html('');
    let output = '';
    $.each(cartItem, function(key,item){
        if(item['qty'] > 0){
            output +=` <tr class="${item['rnd']}">
                        <td onClick="removeCart(${item['rnd']})"><span class="me-2 badge badge-danger rounded-circle cancel-item" ><i class="ri-close-line"></i></span><a href="#">${item['name']}</a></td>
                        <td class="text-center">
                            <div class="touchspin-wrapper"> 
                                <button type="button" class="decrement-touchspin btn-touchspin spin-border-primary" onClick="addToCart(${item['id']},'${item['name']}','${item['price']}','${item['gst']}',2)"><i class="ri-subtract-fill"></i></button>
                                <input class="input-touchspin spin-outline-primary" type="number" value="${item['qty']}">
                                <button type="button" class="increment-touchspin btn-touchspin spin-border-primary" onClick="addToCart(${item['id']},'${item['name']}','${item['price']}','${item['gst']}',1)"><i class="ri-add-fill"></i></button>
                            </div>
                        </td>
                        <td class="text-end">${item['total_price']} <span class="d-block"><small><a href="#">${item['price']}</a></small></span></td>
                    </tr>`;
            total_amount += item['total_price'];
            if(item['gst_amount'] != null || item['gst_amount'] != NaN){
                grand_gst_amount += item['gst_amount'];
            }
            grand_total_amount += item['mrp'];
        }
    });
    $('.cart-items').html(output);
    $('.grand-total-cost').html((total_amount).toFixed(2));
    let sub = total_amount + grand_gst_amount;
    $('#subtotal').val((sub).toFixed(2));
    $('.grand-gst-amount').val((grand_gst_amount).toFixed(2));
    $('.grand-total-amount').html((grand_total_amount).toFixed(2));
    if(cartItem.length > 0){
        $('.amount-detail-view').removeClass('d-none');
    }else{
        $('.amount-detail-view').addClass('d-none');
    }
}

function removeCart(rndno){
    cartItem = cartItem.filter((item) => item.rnd !== rndno);
    drawCart();
}

function addItemFromInput(x){
    $.each(itemList, function(key, list){
        if(list['code'] == x){
            addToCart(list['id'],list['name'],list['offer_price'],list['gst']);
        }
    });
}

let itemType = '';
let subcategory = [];
let subcategoryParent = [];

function setCategory(x,that){
    $('.side-menu').removeClass('active');
    $(that).addClass('active');
    subcategoryParent = [];
    subcategoryParent.push(x);
    const vegItems = filterMenu(itemList, itemType , subcategoryParent);
    filterItemList = vegItems;
    createItemList();
}

function setSubCategory(x,that){
    $('.sub-side-menu').removeClass('active');
    $(that).addClass('active');
    subcategory = [];
    subcategory.push(x);
    const vegItems = filterMenu(itemList, itemType , subcategoryParent, subcategory);
    filterItemList = vegItems;
    createItemList();
}

const foodType = document.getElementById('filterButton');
const states = ['allitem', 'veg', 'nonveg'];
const labels = {
    all: 'All',
    veg: 'Veg',
    nonveg: 'Non-Veg'
};
let currentIndexType = 0;

foodType.addEventListener('click', () => {
    currentIndexType = (currentIndexType + 1) % states.length;
    const state = states[currentIndexType];

    // Update class and text
    foodType.className = state;
    foodType.textContent = labels[state];
    itemType = '';
    if(state == 'veg'){
        itemType = 'Veg';
    }else if(state == 'nonveg'){
        itemType = 'Non-Veg';
    }
    const vegItems = filterMenu(itemList, itemType , subcategory);
    filterItemList = vegItems;
    createItemList();
});

function filterMenu(items, typeFilter = "", categoryIdFilter = [], subCategoryIdFilter = []) {
    return items
        .filter(item => {
            const typeMatches = typeFilter
                ? item.type.toLowerCase() === typeFilter.toLowerCase()
                : true;

            const categoryMatches = categoryIdFilter.length > 0
                ? categoryIdFilter.includes(Number(item.category_id))
                : true;

            const subCategoryMatches = subCategoryIdFilter.length > 0
                ? subCategoryIdFilter.includes(Number(item.sub_category_id))
                : true;

            return typeMatches && categoryMatches && subCategoryMatches;
        })
        .sort((a, b) => a.name.localeCompare(b.name)); // Sort alphabetically
}

function getKotOrderArea(){
    let tableRoomNumber = '';
    let tableRoomNumberId = '';
    
    let kotType = $('input[name="radio5"]:checked').val();
    if(kotType == 'Table'){
        tableRoomNumberId = $('#kot_table_number').val();
        tableRoomNumber = $('#kot_table_number').find(":selected").text();
    } else{
        tableRoomNumberId = $('#kot_room_number').val();
        tableRoomNumber = $('#kot_room_number').find(":selected").text();
        $('.customer_name_display').html($('#kot_room_number option:selected').data('name'));
    }
    if($('#kot_room_number').val() == '' && $('#kot_table_number').val() == ''){
        toastErrorAlert('Select Valid Type');
        return;
    }
    if(tableRoomNumberId != ''){
        basicKot = [];
        basicKot.push({
            type: kotType,
            id: tableRoomNumberId,
            number: tableRoomNumber
        });
        $('.table-area-room-no').html(kotType);
        $('.room_table_number_display').html(tableRoomNumber);
        $('#tableModal').modal('hide');
        $('#waiterModal').modal('show');
    }else{
        toastErrorAlert('Select Valid Type');
        return;
    }
}

function addKotCustomer(){
    let name = validateField("#generate_kot_customer_name","input",".generate_kot_customer_name");
    let type = validateField("#generate_kot_phone","mobile",".generate_kot_phone");

    if (name == true && type == true) {
        person.push({
            name: $('#generate_kot_customer_name').val(),
            phone : $('#generate_kot_phone').val(),
        });
        $('.customer_name_display').html(name);
        $('#customerModal').modal('hide');
    }
}

function addOrderNote(){
    orderNote = $('#order_note').val();
    $('#noteModal').modal('hide');
}

function getLastNote(){
    $('#order_note').val(orderNote);
}

function calcuateTotal(change = ''){
    
    let total = parseFloat($('.grand-total-cost').html());
    if(change == ''){
        let discount_type = $('#discount-type-select').val();
        let dis = $('#discount-value').val();
        let discount = 0;
        let calGst = 0;
        if(dis != ''){
            if(discount_type == 'percent'){
                if(dis > 100){
                    $('#discount-value').val(0);
                    discount = 0;
                    $('.alert_msg_danger').html('discount percentage cannot be greater than 100');
                    var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                    toast.show();
                }else{
                    
                    $.each(cartItem, function(key,item){
                        let total_item = item.price * item.qty;
                        let dis_amt = (parseFloat(dis)/100) * parseFloat(total_item);
                        let after_dis_amount = (total_item - dis_amt);
                        let gst_amount = (parseFloat(item.gst)/100) * after_dis_amount;
                        calGst += parseFloat(gst_amount);
                    });
                }
            }else{
                $.each(cartItem, function(key,item){
                    let total_item = item.price * item.qty;
                    let dis_amt = (parseFloat(dis)) / parseFloat(cartItem.length);
                    let after_dis_amount = (total_item - dis_amt);
                    let gst_amount = (parseFloat(item.gst)/100) * after_dis_amount;
                    calGst += parseFloat(gst_amount);
                });
            }
        }
        if(dis > 0){
           calGst = calGst.toFixed(2)
           $('.grand-gst-amount').val(calGst);
        }
    }
    
    let gst_amount = parseFloat($('.grand-gst-amount').val());
    let subtotal = 0;
    let grand_total = 0;
    let amount_after_dis = total;
    subtotal = amount_after_dis + gst_amount;
    $('#subtotal').val(subtotal.toFixed(2));
    if($("#kot_complimentary_offer").prop('checked') == true){
        grand_total = 0;
    }
    let adjustment = 0;
    if($('#total-adjustment').val() != ""){
        if(parseFloat($('#total-adjustment').val()) > 10){
            $('#total-adjustment').val(10);
        }
        adjustment = parseFloat($('#total-adjustment').val());
    }
    if(adjustment > subtotal){
        $('.alert_msg_danger').html('Adjustment Amount is always less than Total Amount');
        var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
        toast.show();
        grand_total = subtotal;
    }else{
        grand_total = subtotal - adjustment;
    }
    $('.grand-total-amount').html(grand_total.toFixed(2));
}

function generateKot(x = 0){
    // x represent genarate and print
    let kot_time = $('.current_time_min').html();
    let total_cost = $('.grand-total-cost').html() ||0;
    let discount_type = $('#discount-type-select').val();
    let discount_value = $('#discount-value').val();
    let adjustment = $('#total-adjustment').val() ||0 ;
    let grand_total = $('.grand-total-amount').html() ||0;
    let paymentType = $('[name="paymentType"]:checked').val();
    let waiter = $('#kot_waiter').val();
    let waiter_display = $('.waiter_name_display').html();
    let room_table = $('.room_table_number_display').html();
    if(room_table == ''){
        toastErrorAlert('Select Table/Room Number');
        return;
    }
    if(waiter == '' || waiter_display == ''){
        toastErrorAlert('Please Select Steward');
        return;
    }
    let complimentary = 0;
    if($("#kot_complimentary_offer").prop('checked') == true){
        complimentary = 1;
    }
    let payment_card = $('#kot_payment_card').val();
    let other_type = $('#kot_payment_other_type').val();
    let other_ref = $('#kot_payment_other_ref').val();
    let coupon_code ='';
    let apply_coupon = 0;
    if($("#kot_apply_coupon").prop('checked') == true){
        coupon_code = $('#kot_coupon_code').val();
        apply_coupon = 1;
    }
    let coupon_value = $('#coupon_value').val();
    if($('#coupon_value').val() == ''){
        coupon_value = 0;
    }
    let gst_amount = $('.grand-gst-amount').val();
    let total_paid = 0;
    if($("#record-payment").prop('checked') == true && (paymentType != 'Due' || paymentType != 'Complete with Due')){
        total_paid = parseFloat(grand_total);
    }else{
        paymentType = paymentType;
    }
    let subtotal = $('#subtotal').val() || 0;
    let narration = $('#kot_narration').val();
    $('.kotgenerate').addClass('d-none');
    $('.kotprocessing').removeClass('d-none');
    
    if($('#urgent_order').prop('checked')){
        x = 2;
    }

    $.ajax({
        url: addKot,
        type: "POST",
        data : {cartItem:cartItem,kot_time:kot_time,total_cost:total_cost,discount_type:discount_type,discount_value:discount_value,adjustment:adjustment,grand_total:grand_total,person:person,orderNote:orderNote,basicKot:basicKot,paymentType:paymentType,waiter:waiter,payment_card:payment_card,other_type:other_type,other_ref:other_ref,coupon_code:coupon_code,coupon_value:coupon_value,complimentary:complimentary,apply_coupon:apply_coupon,gst_amount:gst_amount,total_paid:total_paid,subtotal:subtotal,narration:narration,urgent_type:x},
        success: function(response) {
            if (response.success) {
                if(total_paid > 0){
                    if($("#record-payment").prop('checked') == true){
                        $('.alert_msg').html('Kot Completed Successfully');
                    }else{
                        $('.alert_msg').html('Kot Updated Successfully');
                    }
                }else{
                    if($("#record-payment").prop('checked') == true){
                        $('.alert_msg').html('Kot Completed Successfully');
                    }else{
                        $('.alert_msg').html('Kot Created Successfully');
                    }
                }
                var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                toast.show();
                if(x >= 1){
                    // let url = '../../kot/print-kot-invoice/'+response.rnd;
                    let url = '../../kot/view-kot-print/tokenPara='+response.rnd;
                    window.open(url,'_blank');
                }
                setTimeout(function() {
                    location.reload();
                }, 2000);
            } else if(response.error_validation){
                if(response.error_validation == 'The basic kot field is required.'){
                    $('.alert_msg_danger').html('Table/Room Number is Required');                 
                }else{
                    $('.alert_msg_danger').html(response.error_validation);                 
                }
                var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                toast.show();
                $('.kotgenerate').removeClass('d-none');
                $('.kotprocessing').addClass('d-none');
            } else {
                alert("Error");
            }
        }
    });
}

function checkCoupon(){

}

function filterItemName(name){
    let output ='';
    if(name.length > 2){
        const filtered = itemList.filter(function(item) {
            return item.name.toLowerCase().startsWith(name);
        });
        $.each(filtered, function(key, items){
            output +=`<li class="list-group-item" onClick="addToCart(${items.id},'${items.name}',${items.offer_price},${items.gst})">${items.name}</li>`;
        });
    }
    $('#searchItemDropdown').empty();
    if(output != ''){
        $('#searchItemDropdown').removeClass('d-none');
    }else{
        $('#searchItemDropdown').addClass('d-none');
    }
    $('#searchItemDropdown').append(output);
}

tableRoomSelected();
function tableRoomSelected(){
    const path = window.location.pathname;
    const paramsPart = path.split("/kot/generate-kot/")[1];
    if(paramsPart != 0){
        const params = new URLSearchParams(paramsPart);
        let kotType = 'Table';
        if(params.get("tokenPara") == '0'){
            kotType = 'Room';
        }
        basicKot.push({
            type: kotType,
            id: params.get("valuePara"),
            number: params.get("numPara")
        });
        $('.room_table_number_display').html(params.get("numPara"));
    }
}

function setWaiter(){
    let waiter = $('#kot_waiter').val();
    if(waiter == ''){
        toastErrorAlert('Please Select Steward');
        return;
    }else{
        $('.waiter_name_display').html($("#kot_waiter option:selected").text());
        $('#waiterModal').modal('hide');
    }
}

function filterItem(){
    let search = $('#search_itemname_code').val();
    filterItemList = itemList.filter(item =>
        item.name.toLowerCase().includes(search.toLowerCase())
    );
    createItemList();
}

$(document).on('change', 'input[name="paymentType"]', function () {
    let value = $(this).val();

    if (value === 'Card') {
        $('#card-detail').show();
        $('#other-payment').hide();
    } else if (value === 'Other') {
        $('#other-payment').show();
        $('#card-detail').hide();
    } else {
        $('#card-detail, #otherInput').hide();
    }
});

function setHideShow(x,that){
    const $icon = $(that).find('i.icofont');
    $icon.toggleClass('icofont-thin-down icofont-thin-up');
    if($('.subCategoryView'+x).hasClass('d-none')){
        $('.subCategoryView'+x).removeClass('d-none');
    }else{
        $('.subCategoryView'+x).addClass('d-none');
    }
}