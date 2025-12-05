let stock_order_table = $('#stock-order-table').DataTable({
    processing:true,
    serverSide:true,
    ajax:{
        url:stockOrderVeiw,
        type:"POST",
        error:function(xhr,error,thrown){
            console.log(xhr.responseText);
            alert("An error occured "+thrown);
        }
         },
        columns:[{
            data:'str_no',
            name:'str_no'
        },
        {
            data:'order_item',
            name:'order_item'
        },
        {
            data:'department',
            name:'department'
        },
        {
            data:'created_by',
            name:'created_by'
        },
        {
            data:'created_at',
            name:'created_at'
        },
        {
            data:'status',
            name:'status'
        },
        {
            data:'action',
            name:'aciton'
        }
    ]
   
});
function stockAddPage() {
    window.location.href = '/store/stock-add-page';
}

function addStockItems(){
    let department_check = validateField("#stock_add_department","select",".stock_add_department_class");
    let item_check = validateField("#stock_add_item","select",".stock_add_item_class");
    let qty_check = validateField("#stock_add_itemQty","select",".stock_add_itemQty_class");
    if(department_check == true && item_check == true && qty_check == true){
        let itemId = $('#stock_add_item').val();
        let itemName = $('#stock_add_item option:selected').text();
        let qty = $('#stock_add_itemQty').val();
        let unit = $('#stock_add_item option:selected').data('uom');
        let check = stockItems.includes(parseInt(itemId));
        if(check){
            toastErrorAlert('Item already exist');
            return;
        }else{
            stockItems.push(parseInt(itemId));
        }
       let itemDatas = '';
       itemDatas+= `<tr>
                        <td>${i}</td>
                        <td>${itemName}
                        <input type="hidden" name="stock_itemId[]" value="${itemId}"></td>
                        <td><input type="number" name="stock_itemQty[]" class="form-control form-control-sm" style="width: 100px;"  value="${qty}"></td>
                        <td>${unit}
                        <input type="hidden" name="stock_unit[]" value="${unit}"></td>
                        <td>
                            <ul class="action"> 
                            <li class="delete ms-1" id="deleteBtn" onclick="removeLeadRow(this,${itemId})"><i class="icon-trash"></i></li>
                            </ul>
                        </td>
                    </tr>`;
                    i++;       
        $('.appendStockItemData').append(itemDatas);     
    }else{
       console.log('Please fill required fields');
    }
}
function removeLeadRow(x,id = ''){
    let result = stockItems.filter(item => item !== id);
    $(x).closest('tr').remove();
}
function stockItemsBulkSubmit(){
    let department = $('#stock_add_department').val();
    let itemId = $('input[name="stock_add_itemId[]"]').map(function(){return $(this).val()}).get();
    let qty = $('input[name="stock_add_itemQty[]"]').map(function(){return $(this).val()}).get();
    let unit = $('input[name="stock_add_unit[]"]').map(function(){return $(this).val()}).get();
    if(itemId.length === 0){
        toastErrorAlert('No item found !');
    }else{
        $('.stockAddSubmit').addClass('d-none');
        $('.stockAddSpinn').removeClass('d-none');
        $.ajax({
            url:stockAddSubmit,
            type:"POST",
            data:{department:department,itemId:itemId,qty:qty,unit:unit},
            success:function(response){
                if(response.success){
                    $('.stockAddSpinn').addClass('d-none');
                    $('.stockAddSubmit').removeClass('d-none');
                    toastSuccessAlert(response.success);
                }else{
                    toastErrorAlert('error found!');
                     $('.stockAddSpinn').addClass('d-none');
                    $('.stockAddSubmit').removeClass('d-none');
                }
            },
            error:function(xhr,status,error){
                console.log(xhr.responseText);
                alert("An error occoured "+error);
            }
        });
    }
}