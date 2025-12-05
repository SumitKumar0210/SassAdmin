$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

let table = $('#restaurant_menu_item').DataTable({
    processing: false,
    serverSide: true,
    ajax: menuView,
    columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'image',
            name: 'image'
        },
        {
            data: 'code',
            name: 'code'
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'uom',
            name: 'uom'
        },
        {
            data: 'price',
            name: 'price'
        },
        {
            data: 'gst',
            name: 'gst'
        },
        {
            data: 'total',
            name: 'total'
        },
        {
            data: 'category',
            name: 'category'
        },
        {
            data: 'label',
            name: 'label'
        },
        {
            data: 'status',
            name: 'status',
            orderable: false,
            searchable: false
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        },
    ]
});

let itemRawMaterial = [];
let itemVariation = [];
let itemExtra = [];
let itemAddon = [];

function getSubCategory(x){
    $.ajax({
        url: itemCategoryGetAll,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {type:x},
        success: function(response) {
            let output = '';
            $('#restaurant-item-sub-category').empty();
            output +=`<option value="">Select</option>`;
            response.data.forEach(function(cat) {
                output +=`<option value="`+cat.id+`">`+cat.name+`</option>`;
            });
            $('#restaurant-item-sub-category').append(output);
        }
    });
}

function addRawMaterialItem(){
    
    let id = $('#restaurant-item-material-name').val();
    let qty = $('#restaurant-item-material-qty').val();
    const rndInt = Math.floor(Math.random() * 600) + 100;
    let chk = false;
    $.each(itemRawMaterial, function(index, item) {
        if(item.id == id){
            chk = true;
        }
    });

    if(chk){
        Swal.fire({
            title: "Invalid",
            text: "Item Already added",
            icon: "warning"
        }); 
    }else{
        if (id != '' && qty != 0 && qty > 0) {
            let name = $('#restaurant-item-material-name option:selected').text();
            let data = $('#restaurant-item-material-name option:selected').data();
            let uom = $('.active-mesurement-unit').html();
            itemRawMaterial.push({
                'rndno': rndInt,
                'name':name,
                'qty':qty,
                'id':id,
                'uom':uom,
                'min':data['min'],
                'max':data['max'],
            });
            resetField();
            drawTable(0);
        }else{
            Swal.fire({
                title: "Invalid",
                text: "Name and Qty is Required",
                icon: "warning"
            }); 
        }
    }
}

function getSubAttribute(x){
    $.ajax({
        url: itemAttributeGetAll,
        type: "POST",
        data: {type:x},
        success: function(response) {
           let output = '';
            $('#restaurant-item-variation-name').empty();
            response.data.forEach(function(attr) {
                output +=`<option value="`+attr.id+`">`+attr.name+`</option>`;
            });
            $('#restaurant-item-variation-name').append(output);
        }
    });
}

function addVariationItem(){

    let id = $('#restaurant-item-variation-attribute').val();
    let name = $('#restaurant-item-variation-name').val();
    let price = $('#restaurant-item-variation-price').val();
    const rndInt = Math.floor(Math.random() * 600) + 100;
    
    if (id != '' && name != '') {
       let attribute_name = $('#restaurant-item-variation-attribute option:selected').text();
       let sub_attribute_name = $('#restaurant-item-variation-name option:selected').text();
        if(price == '' || price < 0){
            price = 0;
        }
        itemVariation.push({
            'rndno': rndInt,
            'attribute_name':attribute_name,
            'price':price,
            'id':id,
            'sub_attribute_name':sub_attribute_name,
            'sub_attribute_id':name,
        });
        $('#offcanvasRight #restaurant-item-variation-attribute').val('').trigger('change');
//         $('#restaurant-item-variation-attribute option:selected').prop('selected', false);
// $('#restaurant-item-variation-attribute').trigger('change'); 
        resetField();
        drawTable(1);
        // $('#restaurant-item-variation-attribute').val('').change();
    }else{
        $('.restaurant-item-variation-attribute-class').html('Select Variation');
        $('.restaurant-item-variation-name-class').html('Select Name');
    }
}

function addExtraItem(){

    let id = $('#restaurant-extra-item').val();
    let price = $('#restaurant-extra-price').val();
    const rndInt = Math.floor(Math.random() * 600) + 100;
    if (id != '' && price != 0 && price > 0) {
       let name = $('#restaurant-extra-item option:selected').text();
       itemExtra.push({
            'rndno': rndInt,
            'name':name,
            'price':price,
            'id':id,
        });
        resetField();
        drawTable(2);
    }else{
        Swal.fire({
            title: "Invalid",
            text: "All Fields are Required",
            icon: "warning"
        }); 
    }
}

function addAddonItem(){

    let id = $('#restaurant-item-addon-name').val();
    let variation = $('#restaurant-item-addon-variation').val();
    const rndInt = Math.floor(Math.random() * 600) + 100;
    if (id != '') {
       let name = $('#restaurant-item-addon-name option:selected').text();
       let variation_name = $('#restaurant-item-addon-variation option:selected').text();
       let data = $('#restaurant-item-addon-variation option:selected').data();

        itemAddon.push({
            'rndno': rndInt,
            'id':id,
            'name':name,
            'variation':variation,
            'variation_name':variation_name,
            'price':data['price']
        });
        resetField();
        drawTable(3);
    }else{
        Swal.fire({
            title: "Invalid",
            text: "All Fields are Required",
            icon: "warning"
        }); 
    }
}

function drawTable(x){
    let output = '';
    if(x == 0){
        $('.item_raw_material_list').empty();
        $('.item_raw_material_view').addClass('d-none');
        if(itemRawMaterial.length > 0){
            $('.item_raw_material_view').removeClass('d-none');
        }
        itemRawMaterial.forEach(function(material) {
            output +=`<tr class="row_`+material.rndno+`"><td>`+material.name+`</td><td>`+material.qty+` `+material.uom+`</td><td class="text-danger"><i class="icon-trash" onclick="deleteRow(`+material.rndno+`,`+x+`)"></i></td></tr>`;
        });
        $('.item_raw_material_list').append(output);
    }else if(x == 1){
        $('.item_variation_list').empty();
        $('.item_variation_view').addClass('d-none');
        if(itemVariation.length > 0){
            $('.item_variation_view').removeClass('d-none');
        }
        itemVariation.forEach(function(variation) {
            output +=`<tr class="row_`+variation.rndno+`"><td>`+variation.attribute_name+`</td><td>`+variation.sub_attribute_name+`</td><td>`+variation.price+`</td><td class="text-danger"><i class="icon-trash" onclick="deleteRow(`+variation.rndno+`,`+x+`)"></i></td></tr>`;
        });
        $('.item_variation_list').append(output);
    }else if(x == 2){
        $('.item_extra_list').empty();
        $('.item_extra_view').addClass('d-none');
        if(itemExtra.length > 0){
            $('.item_extra_view').removeClass('d-none');
        }
        itemExtra.forEach(function(extra) {
            output +=`<tr class="row_`+extra.rndno+`"><td>`+extra.name+`</td><td>`+extra.price+`</td><td class="text-danger"><i class="icon-trash" onclick="deleteRow(`+extra.rndno+`,`+x+`)"></i></td></tr>`;
        });
        $('.item_extra_list').append(output);
    }else if(x == 3){
        $('.item_addon_list').empty();
        $('.item_addon_view').addClass('d-none');
        if(itemAddon.length > 0){
            $('.item_addon_view').removeClass('d-none');
        }
        itemAddon.forEach(function(addon) {
            output +=`<tr class="row_`+addon.rndno+`"><td>`+addon.name+`</td><td>`+addon.price+`</td><td class="text-danger"><i class="icon-trash" onclick="deleteRow(`+addon.rndno+`,`+x+`)"></i></td></tr>`;
        });
        $('.item_addon_list').append(output);
    }else{}
}

function deleteRow(id,type){
    if(type == 0){
        itemRawMaterial = itemRawMaterial.filter(item => item.rndno !== id); 
    }else if(type == 1){
        itemVariation = itemVariation.filter(item => item.rndno !== id);
    }else if(type == 2){
        itemExtra = itemExtra.filter(item => item.rndno !== id);
    }else if(type == 3){
        itemAddon = itemAddon.filter(item => item.rndno !== id);
    }else{}
    drawTable(type)
}

function addMenu(){
    let id = $('#restaurant-item-id').val();
    let code = validateField("#restaurant-item-code","input",".restaurant-item-code");
    let name = validateField("#restaurant-item-name","input",".restaurant-item-name");
    let type = validateField("#restaurant-item-uom","select",".restaurant-item-uom");
    let price = validateField("#restaurant-item-price","amount",".restaurant-item-price");
    let category = validateField("#restaurant-item-category","select",".restaurant-item-category");
    let desc = validateField("#restaurant-item-description","input",".restaurant-item-description");
    let label = validateField("#restaurant-item-label","select",".restaurant-item-label");
    if(itemVariation.length == 0){
         Swal.fire({
            title: "Required",
            text: 'Variation is required',
            icon: "warning"
        });
        return;
    }
    if (name == true && type == true && code == true && price == true && category == true && desc == true && label) {

        let code = $('#restaurant-item-code').val();
        let name = $('#restaurant-item-name').val();
        let uom = $('#restaurant-item-uom').val();
        let price = $('#restaurant-item-price').val();
        let offer_price = $('#restaurant-item-offer-price').val();
        let category = $('#restaurant-item-category').val();
        let sub_category = $('#restaurant-item-sub-category').val();
        let tax_amount = $('#restaurant-item-gst-amount').val();
        let total = $('#restaurant-item-cost').val();
        let gstper = 0;
        if($("#restaurant-item-default-tax").prop('checked') == true){
            gstper = $('.restaurant-item-default-tax-display').html();
        }else{
            gstper = $('#restaurant-item-custom-tax').val();
        }
        let label = $('#restaurant-item-label').val();
        let image = $('#restaurant-item-image').prop('files')[0];
        let internal = 0;
        if($("#only_internal").prop('checked') == true){
            internal = 1;
        }
        let type = $('input[name="restaurant-item-category-type"]:checked').val();
        let status = $('input[name="restaurant-item-category-status"]:checked').val();
        let desc = $('#restaurant-item-description').val();

        let formData = new FormData();
        formData.append('id', id);
        formData.append('code', code);
        formData.append('name', name);
        formData.append('price', price);
        formData.append('offer_price', offer_price);
        formData.append('gst', gstper);
        formData.append('gst_amount', tax_amount);
        formData.append('total', total);
        formData.append('uom', uom);
        formData.append('category', category);
        formData.append('sub_category', sub_category);
        formData.append('label', label);
        formData.append('image', image);
        formData.append('internal', internal);
        formData.append('type', type);
        formData.append('status', status);
        formData.append('desc', desc);
        formData.append('raw_material', JSON.stringify(itemRawMaterial));
        formData.append('variation', JSON.stringify(itemVariation));
        formData.append('extra', JSON.stringify(itemExtra));
        formData.append('addon', JSON.stringify(itemAddon));

        if(id == ''){
            $.ajax({
                url: menuAdd,
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        resetMainForm();
                        $('#offcanvasRight').offcanvas('hide');
                        $('.alert_msg').html('Item Added Successfully');
                            var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                            toast.show();
                            $('#restaurant_menu_item').DataTable().ajax.reload();
                    } else if(response.alreadyfound_error){
                        Swal.fire({
                            title: "Already Found",
                            text: response.alreadyfound_error,
                            icon: "warning"
                        });                    
                    } else {
                        alert("Error");
                    }
                }
            });
        }else{
            $.ajax({
                url: menuUpdate,
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        resetMainForm();
                        $('#offcanvasRight').offcanvas('hide');
                        $('.alert_msg').html('Item Updated Successfully');
                            var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                            toast.show();
                        $('#restaurant_menu_item').DataTable().ajax.reload();
                    } else if(response.alreadyfound_error){
                        Swal.fire({
                            title: "Already Found",
                            text: response.alreadyfound_error,
                            icon: "warning"
                        });                    
                    } else {
                        alert("Error");
                    }
                }
            });
        }
    }
}

function resetField(){
    $('#restaurant-item-material-name').val('');
    $('#restaurant-item-material-qty').val('');
    $('#restaurant-item-variation-attribute').val('');
    $('#restaurant-item-variation-name').val('');
    $('#restaurant-item-variation-price').val('');
    $('#restaurant-extra-item').val('');
    $('#restaurant-extra-price').val('');
    $('#restaurant-item-addon-name').val('');
    $('#restaurant-item-addon-variation').val('');
    $('.unit-details').empty();
}

function restaurantItemSwitch(id){
    $.ajax({
        url: menuSwitchStatus,
        type: "POST",
        data: {id: id},
        success: function(response) {
            if (response.success) {
                $('.alert_msg').html('Status Changed Successfully');
                var toastElement = document.getElementById('liveToast');
                var toast = new bootstrap.Toast(toastElement);
                toast.show();                   
                $('#restaurant_menu_item').DataTable().ajax.reload();
            } else {
                alert("Error");
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("An error occurred: " + error);
        }
    });
}

function editRestaurantItem(id){
    resetMainForm();
    $.ajax({
        url: menuGet,
        type: "POST",
        data: {id: id},
        success: function(response) {
            if (response.success) {
                $('#restaurant-item-id').val(response.getItem['id']);
                $('#restaurant-item-code').val(response.getItem['code']);
                $('#restaurant-item-name').val(response.getItem['name']);
                $('#restaurant-item-price').val(response.getItem['price']);
                $('#restaurant-item-offer-price').val(response.getItem['offer_price']);
                $('#restaurant-item-gst-amount').val(response.getItem['gst_amount']);
                $('#restaurant-item-cost').val(response.getItem['total']);
                $('#restaurant-item-uom').val(response.getItem['uom']);
                $('#restaurant-item-category').val(response.getItem['category']);
                
                $('#restaurant-item-label').val(response.getItem['label']);
                if(response.getItem['only_internal']){
                    $("#only_internal").prop('checked',true);
                }else{
                    $("#only_internal").prop('checked',false);
                }
                if(response.getItem['type'] == 'Veg'){
                    $("#type-veg").prop('checked',true);
                }else{
                    $("#type-nonveg").prop('checked',false);
                }
                if(response.getItem['status']){
                    $("#status_active").prop('checked',true);
                }else{
                    $("#status_active").prop('checked',false);
                }

                $('.restaurant-item-default-tax-display').html(response.getItem['gst']);
                $('#restaurant-item-description').val(response.getItem['description']);
                
                let output = '';
                $('#restaurant-item-sub-category').empty();
                output +=`<option value="">Select</option>`;
                response.sub_categories.forEach(function(cat) {
                    output +=`<option value="`+cat.id+`">`+cat.name+`</option>`;
                });
                $('#restaurant-item-sub-category').append(output);
                $('#restaurant-item-sub-category').val(response.getItem['sub_category']);
                $.each(response.getRawMaterial, function(key,material){
                    const rndInt = Math.floor(Math.random() * 600) + 1000;
                    itemRawMaterial.push({
                        'rndno': rndInt,
                        'name':material.name,
                        'qty':material.qty,
                        'id':material.id,
                        'uom':material.uom,
                        'min':material.min,
                        'max':material.max,
                    });
                });
                drawTable(0);
                
                $.each(response.getVariation, function(key,variation){
                    const rndInt = Math.floor(Math.random() * 600) + 1000;
                    itemVariation.push({
                        'rndno': rndInt,
                        'attribute_name':variation.attribute_name,
                        'price':variation.price,
                        'id':variation.id,
                        'sub_attribute_name':variation.sub_attribute_name,
                        'sub_attribute_id':variation.sub_attribute_id,
                    });
                });
                drawTable(1);
                
                $.each(response.getAddon, function(key,addon){
                    const rndInt = Math.floor(Math.random() * 600) + 1000;
                    itemAddon.push({
                        'rndno': rndInt,
                        'id':addon.id,
                        'name':addon.addon_item_name,
                        'variation':addon.variation,
                        'variation_name':addon.variation_name,
                        'price':addon.price
                    });
                });
                drawTable(3);

                $('#offcanvasRight').offcanvas('show');
                $('.action-title').html('Edit');
            } else {
                alert("error");
            }
        }
    });
}

function deleteRestaurantItem(id){
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: menuDelete,
                type: "POST",
                data: { id: id},
                success: function(response) {
                    if (response.success) {
                        Swal.fire("Deleted!", response.success, "success");
                        $('#restaurant_menu_item').DataTable().ajax.reload();
                    } else {
                        Swal.fire("Error!", "Error", "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire("Error!", "An error occurred: " + error, "error");
                }
            });
        }
    });
}

function resetMainForm(){
    itemRawMaterial = [];
    itemVariation = [];
    itemExtra = [];
    itemAddon = [];
    $('.item_addon_view').addClass('d-none');
    $('.item_extra_view').addClass('d-none');
    $('.item_variation_view').addClass('d-none');
    $('.item_raw_material_view').addClass('d-none');
    $('#restaurant-item-code').val('');
    $('#restaurant-item-name').val('');
    $('#restaurant-item-uom').val('');
    $('#restaurant-item-price').val('');
    $('#restaurant-item-offer-price').val('');
    $('#restaurant-item-category').val('');
    $('#restaurant-item-sub-category').val('');
    $('#restaurant-item-label').val('');
    $('#restaurant-item-description').val('');
    $('input[name="restaurant-item-category-type"]:checked').val('Veg');
    $('input[name="restaurant-item-category-status"]:checked').val('1');
    $('.action-title').html('Add');
    $('.unit-details').empty();
}

function customTax(){
    if($("#restaurant-item-default-tax").prop('checked') == true){
       $('.item-custom-tax').addClass('d-none');
       $('.restaurant-item-default-tax-display-area').removeClass('d-none');
    }else{
        $('.item-custom-tax').removeClass('d-none');
        $('.restaurant-item-default-tax-display-area').addClass('d-none');
    }
    calPriceGst();
}
// calculate gst

function calPriceGst(){
    let price = $('#restaurant-item-price').val();
    let offer_price = $('#restaurant-item-offer-price').val();
    let actualPrice =0;
    if(offer_price > price){
        $('.restaurant-item-offer-price').html('Enter Valid Offer Price');
    }else{
        $('.restaurant-item-offer-price').html('');
        if(offer_price != '' && offer_price > 0){
            actualPrice = offer_price;
        }else{
            actualPrice = price;
        }
    }
    let gst = 0;
    if($("#restaurant-item-default-tax").prop('checked') == true){
        gst = $('.restaurant-item-default-tax-display').html();
    }else{
        gst = $('#restaurant-item-custom-tax').val();
    }
    
    let calGst =0;
    let total =0;
    calGst = actualPrice*(gst/100);
    $('#restaurant-item-gst-amount').val(calGst);
    total = parseFloat(calGst) + parseFloat(actualPrice);
    $('#restaurant-item-cost').val(total);
}

function getDetailMaterial(x){
    let output = '';
    if(x != ''){
        let data = $('#restaurant-item-material-name option:selected').data();
        output +=`<div class="mb-3 d-flex justify-content-between">
            <div>
                <label class="form-label" for="restaurant-item-material-qty">Qty</label>
                <div class="input-group me-1">
                    <input class="form-control" id="restaurant-item-material-qty" type="number"><span class="input-group-text active-mesurement-unit px-2">${data['uom']}</span>
                </div>
            </div>`;
            if(data['child'] != ''){
                output +=`<div class="tg-list-item pt-4 mt-2 ms-2">
                    <div class="d-flex">
                        <label class="form-label ">${data['uom']}</label>
                        <div class="px-1 flex-grow-1 text-end">
                            <label class="switch square-checked mb-0" onChange="checkUnit('${data['child']}','${data['uom']}')">
                                <input type="checkbox" id="raw_material_unit_setting"><span class="switch-state bg-success rounded-2"></span>
                            </label>
                        </div>
                        <label class="form-label">${data['child']}</label>
                    </div>
                </div> `;
            }
        output +=`</div>`;
    }
    $('.unit-details').empty();
    $('.unit-details').html(output);
}

function checkUnit(child,parent){
    if($("#raw_material_unit_setting").prop('checked') == true){
        $('.active-mesurement-unit').html(child);
    }else{
        $('.active-mesurement-unit').html(parent);
    }
}

function getItemVariant(id){
 
   $.ajax({
        url: itemVariantGetAll,
        type: "POST",
        data: {id:id},
        success: function(response) {
            let output = '';
            $('#restaurant-item-addon-variation').empty();
            output +=`<option value="">Select</option>`;
            response.data.forEach(function(attr) {
                output +=`<option value="`+attr.id+`" data-price="`+attr.price+`">`+attr.name+`</option>`;
            });
            $('#restaurant-item-addon-variation').append(output);
        }
    });

}