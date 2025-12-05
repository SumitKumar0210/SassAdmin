let i = 1;
let stockTransferItems = [];

function addTransferItems(){
    let item_check = validateField("#kitchen_transfer_item","select",".kitchen_transfer_item_class");
    let qty_check = validateField("#kitchen_transfer_itemQty","amount",".kitchen_transfer_itemQty_class");
    if(item_check == true && qty_check == true){
        let itemId = $('#kitchen_transfer_item').val();
        let itemName = $('#kitchen_transfer_item option:selected').text();
        let qty = $('#kitchen_transfer_itemQty').val();
        let unit = $('#kitchen_transfer_item option:selected').data('uom');
        let unit_id = $('#kitchen_transfer_item option:selected').data('uom_id');
        let expiry = $('#kitchen_transfer_item option:selected').data('expiry');
        let check = stockTransferItems.includes(parseInt(itemId));
        if(check){
            toastErrorAlert('Item already exist');
            $('.exits'+itemId).focus();
            $('.exits'+itemId).addClass('border-danger');
            return;
        }else{
            stockTransferItems.push(parseInt(itemId));
            $('.exits'+itemId).removeClass('border-danger');
        }

        let itemDatas = '';
        itemDatas +=`<tr>
                        <td>${i}</td>
                        <td>${itemName}<input type="hidden" name="kitchen_transfer_item_id[]" value="${itemId}"></td>
                        <td><input type="text" name="kitchen_transfer_item_expiry[]" class="form-control form-control-sm" value="${expiry}" readonly style="width:150px;"/></td>
                        <td><input type="number" name="kitchen_transfer_itemQty[]" class="form-control form-control-sm exits${itemId}" style="width: 100px;" value="${qty}"></td>
                        <td>${unit}
                        <input type="hidden" name="kitchen_transfer_unit[]" value="${unit_id}"></td>
                        <td>
                            <ul class="action"> 
                            <li class="delete ms-1" id="deleteBtn" onclick="removeLeadRow(this,${itemId})"><i class="icon-trash"></i></li>
                            </ul>
                        </td>
                    </tr>`;
                    i++;       
        $('.appendkitchenTransferData').append(itemDatas);     
        $('#kitchen_transfer_item').val('').change();
        $('#kitchen_transfer_itemQty').val('').change();
    }else{
       console.log('Please fill required fields');
    }

    if(stockTransferItems.length > 0){
        $('.showItemAdd').removeClass('d-none');
    }else{
        $('.showItemAdd').addClass('d-none');
    }
}

function removeLeadRow(x,id = ''){
    let result = stockTransferItems.filter(item => item !== id);
    $(x).closest('tr').remove();
     if(stockTransferItems.length > 0){
        $('.showItemAdd').removeClass('d-none');
    }else{
        $('.showItemAdd').addClass('d-none');
    }
}

function kitchenTransferBulkSubmit(){
    let itemId = $('input[name="kitchen_transfer_item_id[]"]').map(function(){return $(this).val()}).get();
    let qty = $('input[name="kitchen_transfer_itemQty[]"]').map(function(){return $(this).val()}).get();
    let unit = $('input[name="kitchen_transfer_unit[]"]').map(function(){return $(this).val()}).get();
    let expiry = $('input[name="kitchen_transfer_item_expiry[]"]').map(function(){return $(this).val()}).get();

    if(itemId.length === 0){
        toastErrorAlert('No item found !');
    }else{
        $('.transferRequestAddSubmit').addClass('d-none');
        $('.transferRequestAddSpinn').removeClass('d-none');
        $.ajax({
            url:transferRequestSubmit,
            type:"POST",
            data:{itemId:itemId,qty:qty,unit:unit,expiry:expiry},
            success:function(response){
                if(response.success){
                    toastSuccessAlert(response.success);
                    setTimeout(function(){
                        $('.transferRequestAddSpinn').addClass('d-none');
                        $('.transferRequestAddSubmit').removeClass('d-none');
                        window.location.href = transferRequest;
                    },1000);
                    
                }else{
                    toastErrorAlert('error found!');
                    $('.transferRequestAddSpinn').addClass('d-none');
                    $('.transferRequestAddSubmit').removeClass('d-none');
                }
            },
            error:function(xhr,status,error){
                console.log(xhr.responseText);
                alert("An error occoured "+error);
            }
        });
    }
}