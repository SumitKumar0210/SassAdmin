let i = 1;
let stockTransferItems = [];

function addReturnItems(){

    let item_check = validateField("#kitchen_return_item","select",".kitchen_return_item_class");
    let qty_check = validateField("#kitchen_return_itemQty","select",".kitchen_return_itemQty_class");

    if(item_check == true && qty_check == true){
        let itemId = $('#kitchen_return_item').val();
        let itemName = $('#kitchen_return_item option:selected').text();
        let qty = $('#kitchen_return_itemQty').val();
        if(qty <= 0){
            toastErrorAlert('Quantity should not be 0');
            return;
        }

        let unit = $('#kitchen_return_item option:selected').data('uom');
        let unit_id = $('#kitchen_return_item option:selected').data('uom_id');
        let max_qty = $('#kitchen_return_item option:selected').data('qty');       
        let reason = $('#kitchen_return_reason').val();
        let check = stockTransferItems.includes(parseInt(itemId));
        if(check){
            toastErrorAlert('Item already exist');
            $('.exits'+itemId).focus();
            return;
        }else{
            stockTransferItems.push(parseInt(itemId));
        }

        let itemDatas = '';
        itemDatas+= `<tr>
                        <td>${i}</td>
                        <td>${itemName}
                        <input type="hidden" name="kitchen_return_item_id[]" value="${itemId}"></td>
                        <td><input type="number" name="kitchen_return_itemQty[]" class="form-control form-control-sm exits${itemId}" style="width: 100px;" value="${qty}" min="1" max="${max_qty}" oninput="validateQty(this)"></td>
                        <td>${unit}
                        <input type="hidden" name="kitchen_return_unit[]" value="${unit_id}"></td>
                        <td><input type="text" name="kitchen_return_reason[]" class="form-control form-control-sm" value="${reason}"></td>
                        <td>
                            <ul class="action"> 
                            <li class="delete ms-1" id="deleteBtn" onclick="removeLeadRow(this,${itemId})"><i class="icon-trash"></i></li>
                            </ul>
                        </td>
                    </tr>`;
                    i++;       
        $('.appendkitchenReturnData').append(itemDatas);     
    }else{
       console.log('Please fill required fields');
    }

    if(stockTransferItems.length > 0){
        $('.showRequestView').removeClass('d-none');
    }else{
        $('.showRequestView').addClass('d-none');
    }
    
}
function removeLeadRow(x,id = ''){
    let result = stockTransferItems.filter(item => item !== id);
    $(x).closest('tr').remove();
    if(stockTransferItems.length > 0){
        $('.showRequestView').removeClass('d-none');
    }else{
        $('.showRequestView').addClass('d-none');
    }
}
function validateQty(input) {
    if(input.value <= 0){
        $('.addReturnItemsBtn').prop('disabled',true);
    }else{
        $('.addReturnItemsBtn').prop('disabled',false);
    }
    let maxQty = $('#kitchen_return_item option:selected').data('qty') || 0;
    let val = parseFloat(input.value);
    if (val > maxQty) {
        input.value = maxQty;
    } else if (val < 1) {
        input.value = 1;
    }
}

function kitchenReturnBulkSubmit(str_no){

    let itemId = $('input[name="kitchen_return_item_id[]"]').map(function(){return $(this).val()}).get();
    let qty = $('input[name="kitchen_return_itemQty[]"]').map(function(){return $(this).val()}).get();
    let unit = $('input[name="kitchen_return_unit[]"]').map(function(){return $(this).val()}).get();
    let reason = $('input[name="kitchen_return_reason[]"]').map(function(){return $(this).val()}).get();
    if(itemId.length === 0){
        
        toastErrorAlert('No item found !');
    }else{

        $('.returnRequestAddSubmit').addClass('d-none');
        $('.returnRequestAddSpinn').removeClass('d-none');
        $.ajax({
            url:returnRequestSubmit,
            type:"POST",
            data:{itemId:itemId,qty:qty,unit:unit,reason:reason,str_no:str_no},
            success:function(response){
                if(response.success){
                    toastSuccessAlert(response.success);
                    setTimeout(function(){
                        $('.returnRequestAddSpinn').addClass('d-none');
                        $('.returnRequestAddSubmit').removeClass('d-none');
                        window.location.href = transferRequest;
                    },1000);
                    
                }else{
                    toastErrorAlert('error found!');
                    $('.returnRequestAddSpinn').addClass('d-none');
                    $('.returnRequestAddSubmit').removeClass('d-none');
                }
            },
            error:function(xhr,status,error){
                console.log(xhr.responseText);
                alert("An error occoured "+error);
            }
        });

    }
}

