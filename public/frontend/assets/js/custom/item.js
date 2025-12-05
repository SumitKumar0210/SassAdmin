$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

let cartItem = [];
let data = [];
let dataReal = [];
let backend_path = '';
let frontend_path = '';
let itemListsFromDb = [];
getRestaurantMenu();

function getRestaurantMenu(){
    let id = window.location.pathname.split("/").pop();
    
    $.ajax({
        url: getMenuList,
        type: "GET",
        data: {id:id},
        success: function(response) {
            if(response.room_status == 'un-alloted'){
                $('.menu-error-view').removeClass('d-none');
                $('.menu-view').addClass('d-none');
            }else{
                $('.menu-view').removeClass('d-none');
                $('.menu-error-view').addClass('d-none');
            }
            backend_path = response.backend_path;
            frontend_path = response.frontend_path;
            let output = '';
            $.each(response.itemLists, function(key, list){
                if(list['cat_item'].length > 0){
                    output +=`<li class="menu-item has-submenu">
                    <a href="#cat_menu${list['id']}">${list['name']}<span class="toggle-icon ms-2"><i class="fa-solid fa-plus"></i></span><span class="float-end">${list['sub_categories'].length}<span></a>
                        <ul class="submenu">`;
                            $.each(list['sub_categories'], function(key, sub){
                                output +=`<li><a href="#subcat_menu${sub['id']}">${sub['name']} <span class="float-end">${sub['items'].length}</span></a></li>`;
                            });
                        output +=`</ul>
                    </li>`;
                }
            });
            $('.menu-menu-list').html(output);
            const allItems = filterCatItems(response.itemLists);
            dataReal.push(response.itemLists);
            data.push(allItems);
            drawMenu();
        }
    });
}

let typeSort = [];
let filterLabel = [];

function filterSort(id, type) {
    if (type === 0) { // label
        const index = filterLabel.indexOf(id);
        if (index === -1) {
            filterLabel.push(id);
        } else {
            filterLabel.splice(index, 1);
        }
    } else {
        const index = typeSort.indexOf(id);
        if (index === -1) {
            typeSort.push(id);
        } else {
            typeSort.splice(index, 1);
        }
    }

    $('.filter-item').removeClass('active');
    if(typeSort.length > 0){
        $.each(typeSort, function(key, val){
            if(val == 'Veg'){
                $('#labelIDType1').addClass('active');
            }else{
                $('#labelIDType2').addClass('active');
            }
        });
    }

    if(filterLabel.length > 0){
        $.each(filterLabel, function(key, val){
            $('#labelID'+val).addClass('active');
        });
    }
    if(type == 1){
        setLabel();
    }
}

function itemNameFilter(input){
    if(input.length > 2){
        input = input;
    }else{
        input = '';
    }
    const itemFilter = filterCatItems(dataReal[0], typeSort, filterLabel,input);
    data = [];
    data.push(itemFilter);
    drawMenu();
}

function setLabel(){
    const nonVegItems = filterCatItems(dataReal[0], typeSort, filterLabel);
    data = [];
    data.push(nonVegItems);
    drawMenu();
}

function filterCatItems(data, typeFilter = [], labelIds = [], itemName = '') {
    const result = [];

    data.forEach(category => {
        const subCategoryMap = {};

        if (Array.isArray(category.cat_item)) {
            category.cat_item.forEach(item => {
                const matchesType = typeFilter.length > 0 ? typeFilter.includes(item.type) : true;
                const matchesLabel = labelIds.length
                    ? item.label.some(label => labelIds.includes(label.id))
                    : true;
                const matchesName = itemName
                    ? item.name.toLowerCase().includes(itemName.toLowerCase())
                    : true;

                if (matchesType && matchesLabel && matchesName) {
                    const subCatName = item.sub_category?.trim() || 'Uncategorized';
                    const subCatId = item.sub_category ? item.sub_category_id : 0;

                    if (!subCategoryMap[subCatName]) {
                        subCategoryMap[subCatName] = [];
                    }
                    subCategoryMap[subCatName].push({
                        ...item,
                        parent_category_id: category.id,
                        sub_category_id: subCatId
                    });
                }
            });
        }

        // Handle sub_categories.items
        if (Array.isArray(category.sub_categories)) {
            category.sub_categories.forEach(sub => {
                if (Array.isArray(sub.items)) {
                    sub.items.forEach(item => {
                        const matchesType = typeFilter.length > 0 ? typeFilter.includes(item.type) : true;
                        const matchesLabel = labelIds.length
                            ? item.label.some(label => labelIds.includes(label.id))
                            : true;
                        const matchesName = itemName
                            ? item.name.toLowerCase().includes(itemName.toLowerCase())
                            : true;

                        if (matchesType && matchesLabel && matchesName) {
                            const subCatName = item.sub_category?.trim() || sub.name || 'Uncategorized';
                            const subCatId = item.sub_category_id || sub.id || 0;

                            if (!subCategoryMap[subCatName]) {
                                subCategoryMap[subCatName] = [];
                            }
                            subCategoryMap[subCatName].push({
                                ...item,
                                parent_category_id: category.id,
                                sub_category_id: subCatId
                            });
                        }
                    });
                }
            });
        }

        const subCategories = Object.entries(subCategoryMap)
            .sort(([subCatA], [subCatB]) => {
                if (subCatA === 'Uncategorized') return 1;
                if (subCatB === 'Uncategorized') return -1;
                return subCatA.localeCompare(subCatB);
            })
            .map(([subCategory, items]) => ({
                sub_category: subCategory,
                sub_category_id: items[0].sub_category_id,
                items
            }));

        if (subCategories.length > 0) {
            result.push({
                category: category.name,
                parent_category_id: category.id,
                sub_categories: subCategories
            });
        }
    });

    return result;
}


function reset() {
    filterLabel = [];
    $('#itemFilterModal').modal('hide');
    setLabel();
}

function drawMenu(){
    let output ='';
    $.each(data, function(key, category_list){
        let visi = '';
        if(key == 0){
            visi = 'show'
        }
        $.each(category_list, function(key, list){
            if(list['sub_categories'].length > 0){
                output +=`<div class="col-12 content-wrapper px-4">
                <div class="accordion" id="accordionExample${list['parent_category_id']}">
                    <h2 class="accordion-header" id="headingOne">
                        <div class="d-flex justify-content-between py-3 text-nowrap" id="cat_menu${list['parent_category_id']}">
                            <h5><a href="#mcat${list['parent_category_id']}" style="color: #33bfbff2;text-decoration: none;">${list['category']}</a></h5>
                            <button class="accordion-button collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#mcat${list['parent_category_id']}" aria-expanded="false" aria-controls="mcat${list['parent_category_id']}"></button>
                        </div>
                        <div id="mcat${list['parent_category_id']}" class="item-wrapper content accordion-collapse collapse ${visi}" aria-labelledby="headingOne" data-bs-parent="#accordionExample${list['parent_category_id']}">`;
                            $.each(list['sub_categories'], function(key, sub){
                                
                                if(sub['items'].length > 0){
                                    if(sub['sub_category'] != 'Uncategorized'){
                                    output +=`<div class="d-flex justify-content-between py-3 border-bottom text-nowrap" id="subcat_menu${sub['sub_category_id']}">
                                        
                                        <h6><a href="#subcat-${sub['sub_category_id']}${list['parent_category_id']}" style="color: #33bfbfcc;text-decoration: none;">${sub['sub_category']}</a></h6>
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#subcat-${sub['sub_category_id']}${list['parent_category_id']}" aria-expanded="true" aria-controls="subcat-${sub['sub_category_id']}${list['parent_category_id']}" style="margin-top: -3px;"></button>
                                        </div>
                                        <div id="subcat-${sub['sub_category_id']}${list['parent_category_id']}" class="item-wrapper content accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#subcat-${sub['sub_category_id']}${list['parent_category_id']}">`;
                                    }
                                    $.each(sub['items'], function(key, itemValue){
                                        type = 'veg';
                                        if(itemValue['type'] != 'Veg'){
                                            type = 'nonveg';
                                        }
                                        output +=`<div class="item d-flex justify-content-between border-bottom mt-2 mb-2 pb-4">
                                            <div class="item-detail me-4">
                                                <div class="mb-2 d-flex flex-wrap">
                                                    <img src="${frontend_path}/${type}.png" alt="${itemValue['type']}" width="20" height="20">`;
                                                    $.each(itemValue['label'], function(key, labels){
                                                        output +=`<p class="mb-1"><span class="badge rounded bg-white text-dark border ms-2"><span class="me-2"><span id="labelfilter3"><span><img src="${backend_path}/${labels['image']}" width="10px"> ${labels['name']}</span></span></span></span>
                                                        </p>`;
                                                    });
                                                output +=`</div>
                                                <h4>${itemValue['name']}</h4>
                                                <h5>`;
                                                    if(itemValue['price'] != itemValue['offer_price']){
                                                        output +=`<span class="price text-decoration-line-through me-1 text-muted">₹${itemValue['price']}</span>`;
                                                    }
                                                        output +=`<span class="price">₹${itemValue['offer_price']}</span>
                                                </h5>
                                                <p class="mb-3"><span id="strlimit${itemValue['id']}">${itemValue['description'].substring(0,70)}</span><span id="dots${itemValue['id']}">...</span><span id="more${itemValue['id']}" style="display:none;">${itemValue['description']}</span><span class="ms-1 fw-bold" onclick="longDescription(${itemValue['id']})" id="myBtn${itemValue['id']}">read more</span><span class="ms-1 fw-bold" onclick="longDescription(${itemValue['id']})" id="myBtn2${itemValue['id']}" style="display:none;">read less</span></p>
                                            </div>
                                            <div class="item-image"><img src="${backend_path}/${itemValue['image']}" height="144" width="156" alt="item" class="rounded" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="getimage(this.src,${itemValue['id']},'${itemValue['name']}',${itemValue['price']},'${itemValue['description']}')" style="border-radius: 12px !important;">
                                                <div class="text-center quantity-selector" >
                                                    <button class="add-btn" onclick="getVariation(${itemValue['id']},${itemValue['variation']})">Add</button>
                                                    <div class="qty-controls" style="display:none;" onclick="getVariation(${itemValue['id']},${itemValue['variation']})"> 
                                                        <span>Edit</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content front_image_modal">
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" style="height: 33px;width: 30px;" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                                                <div class="modal-body viewImage p-0 alt=" item=""  width="100%"></div>
                                                </div>
                                                <div class="modal-content">
                                                    <div class="modal-body viewImage-details" style="background-color:#fff; border-radius:0px 0px 15px 15px;"></div>
                                                </div>
                                            </div>
                                        </div>`;
                                    });
                                    if(sub['sub_category'] != 'Uncategorized'){
                                        output += `</div>`;
                                    }
                                }   
                            });
                        output +=`</div>
                    </h2>
                </div>
            </div>`;
            }
        });
    });
    $('.menu_item_list').html(output);
}

function getVariation(id){

    $('#itemSummaryModal').modal('show');
    $.ajax({
        url: itemVariationGet,
        type: "POST",
        data: {id: id},
        success: function(response) {
            let path = response.path+'/'+response.image;
            $('.selected-item-image').attr("src",path);
            $('.selected-item-type').attr("src",response.frontend_path);
            $('.selected-item-name').html(response.name);
            $('.selected-item-description').html(response.description);
            $('.selected-item-id').html(response.id);
            let output = '';
            $.each(response.variationsType, function(key,type){
                output +=`<h6 class="mb-2">`+type['name']+`</h6>`;
                if(type['allow_multiple'] == 0){
                    output +=`<small>Required . Select any 1 option</small>`;
                }else{
                    output +=`<small>Required . Select any option</small>`;
                }
                $.each(response.itemVariation, function(key,vari){
                    if(vari['attribute_id'] == type['id']){
                        let chk = '';
                        if(key == 0){
                            chk ='checked';
                        }
                        let count_qty = 0;
                        $.each(cartItem, function(key,cart){
                            if(cart.id == id && cart.attribute == vari['attribute_id']){
                                count_qty = cart.qty;
                            }
                        });
                        if(count_qty == 0 && key == 0){
                            count_qty = 1;
                        }

                        if(vari['type'] == "variation"){

                            if(type['allow_multiple'] == 0){
                                output +=` <div class="d-flex justify-content-between align-items-center mt-2">
                                    <p class="mb-0 "><span class="me-1"><input type="radio" name="${type['id']}" class="attribute_select d-none" value="${vari['sub_attribute_id']}" ${chk}></span> ${vari['sub_attribute_name']}</p>
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 me-2">+ ₹${vari['price']} </p>
                                        <div class="btn-theme-light d-flex align-items-center justify-content-between">
                                            <span class="decrementBtn" onClick="itemQty(0,this)">-</span>
                                            <input type="text" data-id="${id}" data-attribute="${vari['sub_attribute_id']}" class="counterValue" value="${count_qty}" readonly>
                                            <span class="incrementBtn" onClick="itemQty(1,this)">+</span>
                                        </div>
                                    </div>
                                </div>`;
                            }else{
                                output +=`<div class="d-flex justify-content-between align-items-center mt-2">
                                    <label class="custom-checkbox ">
                                        <input type="checkbox" class="attribute_select d-none" value="${vari['sub_attribute_id']}" ${chk}/>
                                        <span class="checkbox-box d-none"></span>
                                        ${vari['sub_attribute_name']}
                                    </label>
                                    <div class="d-flex align-items-center">
                                        <p class="mb-0 me-2">+ ₹${vari['price']} </p>
                                        <div class="btn-theme-light d-flex align-items-center justify-content-between">
                                            <span class="decrementBtn" onClick="itemQty(0,this)">-</span>
                                            <input type="text" data-id="${id}" data-attribute="${vari['sub_attribute_id']}" class="counterValue" value="${count_qty}" readonly>
                                            <span class="incrementBtn" onClick="itemQty(1,this)">+</span>
                                        </div>
                                    </div>
                                </div>`;
                            }
                        }
                    }
                });
                output +=`<hr>`;

                if(response.addonItem > 0){
                    
                    output +=`<h6 class="mb-2">Addon's</h6>`;
                    $.each(response.itemVariation, function(key,vari){
                        
                        if(vari['type'] == "Addon"){
                            let chk = '';
                            if(key == 0){
                                chk ='checked';
                            }
                            let count_qty = 0;
                            $.each(cartItem, function(key,cart){
                                if(cart.id == vari['item_id'] && cart.attribute == vari['attribute_id']){
                                    count_qty = cart.qty;
                                }
                            });
    
                            if(vari['type'] == "Addon"){
    
                                if(type['allow_multiple'] == 0){
                                    output +=` <div class="d-flex justify-content-between align-items-center mt-2">
                                        <p class="mb-0 "><span class="me-1"><input type="radio" name="${type['id']}" class="attribute_select d-none" value="${vari['sub_attribute_id']}" ${chk}></span> ${vari['sub_attribute_name']}</p>
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0 me-2">+ ₹${vari['price']} </p>
                                            <div class="btn-theme-light d-flex align-items-center justify-content-between">
                                                <span class="decrementBtn" onClick="itemQty(0,this)">-</span>
                                                <input type="text" data-id="${vari['item_id']}" data-attribute="${vari['sub_attribute_id']}" class="counterValue" value="${count_qty}" readonly>
                                                <span class="incrementBtn" onClick="itemQty(1,this)">+</span>
                                            </div>
                                        </div>
                                    </div>`;
                                }else{
                                    output +=`<div class="d-flex justify-content-between align-items-center mt-2">
                                        <label class="custom-checkbox ">
                                            <input type="checkbox" class="attribute_select d-none" value="${vari['sub_attribute_id']}" ${chk}/>
                                            <span class="checkbox-box d-none"></span>
                                            ${vari['item_name']} - ${vari['sub_attribute_name']}
                                        </label>
                                        <div class="d-flex align-items-center">
                                            <p class="mb-0 me-2">+ ₹${vari['price']} </p>
                                            <div class="btn-theme-light d-flex align-items-center justify-content-between">
                                                <span class="decrementBtn" onClick="itemQty(0,this)">-</span>
                                                <input type="text" data-id="${vari['item_id']}" data-attribute="${vari['sub_attribute_id']}" class="counterValue" value="${count_qty}" readonly>
                                                <span class="incrementBtn" onClick="itemQty(1,this)">+</span>
                                            </div>
                                        </div>
                                    </div>`;
                                }
                            }
                        }
                    });
                }
                $('.selected-item-variation-detail').html(output);
            });
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("An error occurred: " + error);
        }
    });
}

function calc( x = 1){
    
    let total_qty = 0;
    $('#itemSummaryModal').modal('hide');
    let area = $("input.counterValue");
    let same_qty = 0;
    $.each(area, function(key, input_area){

        let selectedValue = parseInt(input_area.value, 10);
        let selectedId = parseInt((input_area.getAttribute('data-id')));
        let selectedAttribute = parseInt((input_area.getAttribute('data-attribute')));

        if(x > 0){

            let found = false;
            if (cartItem.length > 0) {
                $.each(cartItem, function(index, item) {
                    if (item.id === selectedId && item.attribute_id === selectedAttribute) {
                        item.qty = selectedValue;
                        same_qty = selectedValue;
                        found = true;
                        return false; 
                    }
                });
            }
    
            if (!found) {
                cartItem.push({
                    id: selectedId,
                    qty: selectedValue,
                    attribute_id: selectedAttribute
                });
                
                same_qty = selectedValue;
            }
        }else{

            cartItem = cartItem.filter(function(item) {
                return item.id !== selectedId
            });
        }

    });

    $.each(cartItem, function(index, item) {
        total_qty += parseInt(item.qty);
    });

    $('#added_items').html(total_qty);

    $('.summaryqty').html(total_qty);
    if(total_qty > 0 ){
        // $('.cart-count-view').removeClass('d-none');
        $('#itemsummary').show();
    }else{
        // $('.cart-count-view').addClass('d-none');
        $('#itemsummary').hide();
    }
}

function showCart(){
    cartItem = cartItem.filter(function(item) {
        return item.qty !== 0
    });
    $('#cartModel').modal('show');
    itemListsFromDb = [];
    $.ajax({
        url: itemCartDetailGet,
        type: "POST",
        data: { item: cartItem },
        success: function(response) {
            response.itemLists.forEach(function(element) {
                itemListsFromDb.push(element);
            });
            drawOrderPlaced();
        }
    });
}

function drawOrderPlaced(){
    let output ='';
    $('.selected-items').empty();
    itemListsFromDb.forEach(function(element){
        output +=`<div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1"> <span class="me-1"><img src="https://hydx.techiesquad.in/backend/uploads/Item/${element.image}" width="15px"/></span>${element.name}</h5>
                    <p class="fs-6 text-start">${element.attribute_name} </p>
                </div>
                <div class="d-flex align-items-center">
                    <div class="qty-controls view-cart me-3">
                        <span class="decrement" onClick="qtyUpdated(${element.id},0)">-</span>
                        <span class="qty">${element.qty}</span>
                        <span class="increment" onClick="qtyUpdated(${element.id},1)">+</span>
                    </div>
                    <h6 class="mb-0 f6">₹ ${element.total_price} </h6>
                </div>
            </div>`;
    });
    $('.selected-items').append(output);
}

function qtyUpdated(id,x){
    itemListsFromDb.forEach(function(element){
        if(element.id == id){
            if(x == 0){
                element.qty = parseInt(element.qty) - 1;
            }else{
                element.qty = parseInt(element.qty) + 1;
            }
            element.total_price = parseFloat(element.price) * parseFloat(element.qty);
        }
    });
    drawOrderPlaced();
}

function placeOrder(){
    $('.orderplace_btn').hide();
    $('.orderplace_wait').show();

    let id = window.location.pathname.split("/").pop();
    let total_cost = 0;
    let total_gst = 0;
    let grand_total = 0;
    
    itemListsFromDb.forEach(function(element){
        let gst_amount = parseFloat(element.gst/100) * parseFloat(element.total_price);
        element.gst_amount = gst_amount;
        let grand =  parseFloat(element.total_price) + parseFloat(gst_amount);
        element.mrp = grand;
        total_cost += parseFloat(element.total_price);
        total_gst += gst_amount;
        grand_total += grand;
    });

    let customer_order_note = $('.customer_order_note').val();

    $.ajax({
        url: itemCartPlaceOrder,
        type: "POST",
        data: { item: itemListsFromDb, id:id, total_cost:total_cost, total_gst:total_gst, grand_total:grand_total, note:customer_order_note },
        success: function(response) {
            if(response.success){
                $('#cartModel').modal('hide');
                Swal.fire({
                    title: "Thank You for order, we will soon update you the status",
                    icon: "success"
                });
                setTimeout(() => {
                    location.reload();
                }, 2500);
                
            }else{
                $('.orderplace_btn').show();
                $('.orderplace_wait').hide();
                Swal.fire("Error!", "Something Went Wrong Please Try Again.. " + error, "error");
            }
        }
    });
}

function itemQty(type,that){
    
    let input = $(that).siblings(".counterValue");
    let currentVal = parseInt(input.val()) || 0;
    if(type == 0){
        if(currentVal > 0){
            input.val(currentVal - 1);
            newqty = currentVal - 1;
        }
    }else{
        input.val(currentVal + 1);
        newqty = currentVal + 1;
    }

}






