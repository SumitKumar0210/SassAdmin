let halls = [];
let availableHalls = [];
let selectedHalls = [];
let itemList = [];
let selectedItemList = [];
let accessories = [];
let selectedAccessories = [];
let itemAdded = [];
let selected_hall_id = '';

collectAllData();
function collectAllData(){
    let id = $('#banquet_id').val();

    $.ajax({
        url: getBooking,
        type: "POST",
        data: { id: id},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // console.log(response);

            if(response.success){
                $('#banquet_eventDate').val(response.banquets[0].event_date);
                let curr_checkin = new Date($("#banquet_eventDate").val());
                flatpickr("#banquet_eventDate",{
                    dateFormat: "d-M-Y",
                    defaultDate: curr_checkin,
                    minDate: curr_checkin
                });
                
                $('#banquet_eventEndDate').val(response.banquets[0].event_end_date);
                let curr_checkin_out = new Date($("#banquet_eventEndDate").val());
                flatpickr("#banquet_eventEndDate",{
                    dateFormat: "d-M-Y",
                    defaultDate: curr_checkin_out,
                    minDate: curr_checkin_out
                });

                selected_hall_id = response.banquets[0].hall_id;
                response.halls.forEach(function(item){
                    halls.push(item);
                });
                response.accessories.forEach(function(item){
                    accessories.push(item);
                });

                let menu_cat = [];
                let access_item = [];
                response.banquet_menu.forEach(function(item){
                    if(!menu_cat.includes(item.menu_category_id)) {
                        menu_cat.push(item.menu_category_id);
                    }
                    let menu_data = {
                        'category_id': item.menu_category_id,
                        'category_name': item.menu_category_name,
                        'id': item.item_id,
                        'name': item.item_name
                    }
                    itemAdded.push(menu_data);
                });
                response.banquet_accessories.forEach(function(item){
                    if (!access_item.includes(item.accesories_id)) {
                        access_item.push(item.accesories_id);
                    }
                    let data ={
                        'id': item.accesories_id,
                        'name': item.accesories_name,
                        'qty': item.accesories_qty,
                        'rate': item.accesories_rate,
                        'total': item.accesories_amount,
                    }
                    selectedAccessories.push(data);
                });

                response.itemList.forEach(function(item){
                    if (menu_cat.includes(item.id)) {
                        let t = '';
                        response.banquet_menu.forEach(function(item_time){
                            if(item_time.menu_category_id == item.id && t == ''){
                                t = item_time.serve_time;
                            }
                        });
                        item.time = t;
                        selectedItemList.push(item);
                    }
                    itemList.push(item);
                });
                menu_cat = menu_cat.map(String);
                $('#menu_category').selectpicker('val', menu_cat);
                access_item = access_item.map(String);
                $('#consumable_item').selectpicker('val', access_item);

                // $('#menu_category').selectpicker('refresh');
                checkAvailable(curr_checkin);
                drawMenu();
                drawConsumable();
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("An error occurred: " + error);
        }
    });
}

function checkAvailable(value){
    let date = new Date(value);
    let yyyy = date.getFullYear();
    let mm = String(date.getMonth() + 1).padStart(2, '0'); // month is 0-based
    let dd = String(date.getDate()).padStart(2, '0');
    
    let dateValue = `${yyyy}-${mm}-${dd}`;
    availableHalls = [];
    halls.forEach(function(hall) {
        if(hall.id == selected_hall_id){
            availableHalls.push(hall);
        }else if(hall.booked_date != dateValue){
            availableHalls.push(hall);
        }
    });
    if(availableHalls.length){
        drawHallArea();
    }
}

function drawHallArea(){
    $('.hall_detail').empty();
    if(availableHalls.length <= 0){
        $('.hallView').addClass('d-none');
    }else{
        $('.hallView').removeClass('d-none');
        availableHalls.forEach(function(hall) {
            let sel = '';
            if(hall.id == selected_hall_id){
                sel = 'border-primary border-3';
            }
            $('.hall_detail').append(`<div class="col-md-4 mb-3 border-primary border-3" onClick="addHall(${hall.id},this)">
                <div class="item-hall-type border rounded-3 p-3 ${sel}">
                    <div class="d-flex justify-content-between mb-2">
                        <h4>${hall.name}</h4>
                        <span class="badge badge-success rounded-0 fw-normal">Available</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="d-flex align-items-center">
                        <p class="mb-0 fw-bold me-2 min-w92">Capacity:</p>
                        <p class="mb-0 min-w92">${hall.capacity}</p>
                        </div>
                        <div class="d-flex align-items-center">
                        <p class="mb-0 fw-bold me-2">Area:</p>
                        <p class="mb-0 min-w92 text-end">${hall.area}</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <div class="d-flex align-items-center">
                        <p class="mb-0 fw-bold me-2 min-w92">Set Up Time:</p>
                        <p class="mb-0 min-w92">${hall.setup_time}</p>
                        </div>
                        <div class="d-flex align-items-center">
                        <p class="mb-0 fw-bold me-2">Rate:</p>
                        <p class="mb-0 min-w92 text-end">${hall.rate}</p>
                        </div>
                    </div>
                </div>
            </div>`);
        });
    }
}

function addHall(id,that){
    selectedHalls = [];
    $('.item-hall-type').removeClass('border-primary border-3');
    $(that).children().addClass('border-primary border-3');
    availableHalls.forEach(function(hall) {
        if(hall.id == id){
            selectedHalls.push(hall);
        }
    });
}

function menuCategory(that){
    selectedItemList = [];
    $('.menu_items').empty();
    let menu_category = $(that).parent().find('#menu_category');
    let menu_category_id = menu_category.val();
    const numeric_array = menu_category_id.map(Number);
    itemList.forEach(function(item){
        if (numeric_array.includes(item.id)) {
            let index = selectedItemList.findIndex(it => it.id === item.id);
            if (index > -1) {
                selectedItemList.splice(index, 1);
            } else {
                item.time = '';
                selectedItemList.push(item);
            }
        }
    });
    drawMenu();
}

function drawMenu(){
    $('.menu_items').empty();
    let output = '';
    selectedItemList.forEach(function(item){
        output +=`<div class="col-md-6 col-12 mb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 id="categoryName${item.id}">${item.name}</h4>
                    <div class="w-25">
                        <input type="time" name="serve_time[]" class="form-control" placeholder="Enter Serving Time" value="${item.time}" onchange="setTime(this.value,${item.id})">
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <select id="menu${item.id}" class="form-control w-50 menu_item_list selectpicker" data-live-search="true" title="Add Menu Items">
                    <option value="">Select</option>`;
                    item.items.forEach(function(value){
                        output +=`<option value="${value.id}">${value.name}</option>`;
                    });
                    output +=`</select>
                    <div class="">
                        <a href="javascript:void(0)" class="btn btn-primary px-4" type="button" onClick="addItem(${item.id})"> Add </a>
                    </div>
                </div>`;
                if(itemAdded.length){
                    output +=`<div class="border p-3 rounded-3">
                    <table class="table table-sm table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Items Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>`;
                        itemAdded.forEach(function(value){
                            if(value.category_id == item.id){
                                output +=` <tr>
                                    <td>${value.name}</td>
                                    <td class="text-danger"><span onClick="removeItem(${value.id})"><i class="icon-trash"></i></span></td>
                                </tr>`;
                            }
                        });
                        output +=`</tbody>
                    </table>
                    </div>`;
                }
            output +=`</div>`;
    });
    $('.menu_items').html(output);
    $('.menu_item_list').selectpicker();
}

function addItem(id){
    let item_id = $('#menu'+id).val();
    let index = itemAdded.findIndex(it => it.id === item_id);
    if (index > -1) {
        toastErrorAlert("Item Already Exists");
    } else {
        itemAdded.push({
            'category_id': id,
            'category_name': $('#categoryName'+id).html(),
            'id': item_id,
            'name': $('#menu'+id+' option:selected').text()
        });
    }
    drawMenu();
}

function removeItem(item_id){
    itemAdded = itemAdded.filter(it => parseInt(it.id) !== item_id);
    drawMenu();
}

function consumableItem(that){
    selectedAccessories = [];
    let menu_category = $(that).parent().find('#consumable_item');
    let menu_category_id = menu_category.val();
    const numeric_array = menu_category_id.map(Number);
    accessories.forEach(function(item){
        if (numeric_array.includes(item.id)) {
            item.total = 0;
            item.qty = 0;
            selectedAccessories.push(item);
        }
    });
    drawConsumable();
}

function drawConsumable(){
    $('.accessories_list').empty();
    selectedAccessories.forEach(function(item){
        $('.accessories_list').append(`
            <div class="col-12 mb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="accesories-label">
                        <label class="form-label">${item.name}</label>
                    </div>
                    <div class="">
                        <input type="hidden" class="form-control" name="accessories_rate[]" placeholder="Quantity" value="${item.rate}">
                        <input type="number" class="form-control" name="accessories_qty[]" placeholder="Quantity" onkeyup="calculateAccesoriesAmount(this.value,${item.id})" value="${item.qty}">
                    </div>
                    <div class="">
                        <input type="number" class="form-control" name="accessories_amount[]" placeholder="Amount" value="${item.total}" readonly>
                    </div>
                </div>
        </div>`);
    })
}

function calculateAccesoriesAmount(qty,id){
    selectedAccessories.forEach(function(item){
        if(item.id == id){
            let t = qty * item.rate;
            item.qty = parseInt(qty);
            item.total = t;
        }
    });
    drawConsumable();
    calculateHall();
}

function calculateHall(){
    let banquet_hall_charge = $('#banquet_hall_charge').val() || 0;
    let banquet_hall_discount = $('#banquet_hall_discount').val() || 0;
    let amount = banquet_hall_charge - banquet_hall_discount;
    $('#banquet_hall_total').val(amount);
    $('#banquet_grand_total_hall_charge').val(amount);
    calculateAll();
}

function setTime(value,id){
    selectedItemList.forEach(function(item){
        if(item.id == id){
            item.time = value
        }
    });
    drawMenu();
}

function calculateAll(){
    let accessories_amount = $('input[name="accessories_amount[]"]').map(function(){return $(this).val()}).get();
    let total_accessories = 0;
    accessories_amount.forEach(function(tot){
        if(tot != ''){
            total_accessories += parseFloat(tot);
        }
    });

    $('#banquet_consumable_charge').val(total_accessories);
    let extra_room = $('#banquet_hall_extra_room').val() || 0;
    let per_room_charge = $('#banquet_hall_per_room_charge').val() || 0;
    let extra_room_charge = extra_room * per_room_charge;
    $('#banquet_total_extra_room_charge').val(extra_room_charge);
    let hall_charge = $('#banquet_grand_total_hall_charge').val() || 0;
    let food_charge = $('#banquet_total_food_charge').val() || 0;
    let subtotal = parseFloat(total_accessories) + parseFloat(hall_charge) + parseFloat(food_charge) + parseFloat(extra_room_charge);
    $('#banquet_sub_total_amount').val(subtotal);
    let banquet_discount = $('#banquet_discount').val() || 0;
    // let tot_discount = (banquet_discount/100) * subtotal;
    let tot_discount = banquet_discount;
    let amount = parseFloat(subtotal) - parseFloat(tot_discount);
    $('#banquet_after_discount').val(amount);
    $('#banquet_total_amount').val(amount);
    let adjustment = $('#banquet_adjustment').val() || 0;
    if(adjustment > 10){
        $('#banquet_adjustment').val(10);
        adjustment = 10;
    }
    let banquet_gst = $('#banquet_gst').val() || 0;
    let tot_gst = (banquet_gst/100) * subtotal;
    $('#banquet_after_gst').val(tot_gst);
    let grand_total = parseFloat(amount) + parseFloat(tot_gst) - parseFloat(adjustment);
    $('#banquet_grand_total').val(grand_total);
    let advance_paid = $('#banquet_advance_paid').val() || 0;
    if(advance_paid > grand_total){
        toastErrorAlert('Advance amount cannot be greater than Total Amount');
        $('#banquet_advance_paid').val(0);
        advance_paid = 0;
    }
    let due = parseFloat(grand_total) - parseFloat(advance_paid);
    $('#banquet_due_total').val(due);
}

function referenceNumberSet(id){
    if(id == '1'){
        $('.reference_number_view').addClass('d-none');
    }else{
        $('.reference_number_view').removeClass('d-none');
    }
}

function updateBooking(){
    $('.submitBtn').addClass('d-none');
    $('.processBtn').removeClass('d-none');
    selectedItemList.forEach(function(category){
        itemAdded.forEach(function(item){
            if(category.id == item.category_id){
                item.time = category.time;
            }
        });
    });
    let id = $('#banquet_id').val();
    let client = $('#banquet_client').val();
    let company = $('#banquet_company').val();
    let address = $('#banquet_address').val();
    let company_gst = $('#banquet_company_gst').val();
    let company_address = $('#banquet_company_address').val();
    let eventDate = $('#banquet_eventDate').val();
    let startTime = $('#banquet_startTime').val();
    let eventEndDate = $('#banquet_eventEndDate').val();
    let endTime = $('#banquet_endTime').val();
    let eventType = $('#banquet_eventType').val();
    let eventTypeName = $('#banquet_eventType option:selected').text();
    let guestCount = $('#banquet_guestCount').val();
    let phone = $('#banquet_phone').val();
    let hall_charge = $('#banquet_hall_charge').val();
    let hall_discount = $('#banquet_hall_discount').val();
    let hall_total = $('#banquet_hall_total').val();
    let complimentary_room = $('#banquet_complimentary_room').val();
    let hall_extra_room = $('#banquet_hall_extra_room').val();
    let hall_per_room_capacity = $('#banquet_hall_per_room_capacity').val();
    let hall_per_room_charge = $('#banquet_hall_per_room_charge').val();
    let banquet_plate_price = $('input[name="banquet_plate_price"]:checked').val();
    let grand_total_hall_charge = $('#banquet_grand_total_hall_charge').val();
    let total_food_charge = $('#banquet_total_food_charge').val();
    let consumable_charge = $('#banquet_consumable_charge').val();
    let total_extra_room_charge = $('#banquet_total_extra_room_charge').val();
    let sub_total_amount = $('#banquet_sub_total_amount').val();
    let discount = $('#banquet_discount').val();
    let after_discount = $('#banquet_after_discount').val();
    let total_amount = $('#banquet_total_amount').val();
    let gst = $('#banquet_gst').val();
    let after_gst = $('#banquet_after_gst').val();
    let grand_total = $('#banquet_grand_total').val();
    let advance_paid = $('#banquet_advance_paid').val();
    let due_total = $('#banquet_due_total').val();
    let payment_mode = $('#banquet_payment_mode').val();
    let reference = $('#banquet_reference').val();
    let note = $('#banquet_note').val();
    let adjustment = $('#banquet_adjustment').val() || 0;
    if(client == '' || eventDate == '' || startTime == '' || endTime == '' || eventType == '' || guestCount == '' || phone == '' || hall_charge == '' ||  gst == '' || grand_total == '' || sub_total_amount == ''){
        toastErrorAlert("All Fields are Required");
        $('.submitBtn').removeClass('d-none');
        $('.processBtn').addClass('d-none');
    }else{
        $.ajax({
            url: updateBookingData,
            type: "POST",
            data: { id:id,client:client,company:company,company_gst:company_gst,company_address:company_address,eventDate:eventDate,startTime:startTime,eventEndDate:eventEndDate,endTime:endTime,eventType:eventType,guestCount:guestCount,phone:phone,hall_charge:hall_charge ,hall_discount:hall_discount,hall_total:hall_total,complimentary_room:complimentary_room,hall_extra_room:hall_extra_room,hall_per_room_capacity:hall_per_room_capacity,hall_per_room_charge:hall_per_room_charge,grand_total_hall_charge:grand_total_hall_charge,total_food_charge:total_food_charge,consumable_charge:consumable_charge, total_extra_room_charge:total_extra_room_charge,sub_total_amount:sub_total_amount,discount:discount,after_discount:after_discount,total_amount:total_amount,gst:gst,after_gst:after_gst,grand_total:grand_total,advance_paid:advance_paid,due_total:due_total,banquet_plate_price:banquet_plate_price,selectedHalls:selectedHalls,itemAdded:itemAdded,selectedAccessories:selectedAccessories,payment_mode:payment_mode,reference:reference,note:note,address:address,eventTypeName:eventTypeName,adjustment:adjustment},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success){
                    toastSuccessAlert(response.success);
                    setTimeout(function(){
                        window.location.reload();
                    },2500);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    }
}

function checkGstRequest(number){
    
    const regex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][1-9A-Z]Z[0-9A-Z]$/ // only alphanumeric, exactly 15 chars
    if(regex.test(number)){
        
        $.ajax({
            url: companyVerifyGst,
            type: "POST",
            data: {
                number:number,type:'Banquet'
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status == 200) {
                    let data = response.data.data;
                    if(data == undefined){
                        
                        let a = JSON.parse(response.data.status_desc);
                        Swal.fire('Error-'+a[0].ErrorCode, a[0].ErrorMessage, 'error');
                    }else{

                        $('#banquet_company').val(data.LegalName);
                        let addr = data.AddrFlno +', '+ data.AddrBno +', '+ data.AddrBnm +', '+ data.AddrSt +', '+ data.AddrLoc;
                        $('#banquet_company_address').val(addr);
                    }
                } else if(response.alreadyfound){
                    $('.alert_msg_danger').html('Gst already exists in record!');
                    var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                    toast.show();
                }else{             
                    alert("Error");
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    }else{
        $('.alert_msg_danger').html('Invalid GST Number');
        var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
        toast.show();
    }
}