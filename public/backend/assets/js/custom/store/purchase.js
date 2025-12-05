

function purchaseAddPage() {
    window.location.href = '/store/purchase-add-page';
}

let i = 1;
let items = [];

function addItems(){
    let vendor_check = validateField("#purchaseAdd-vendor","select",".purchaseAdd-vendor_class");
    let item_check = validateField("#purchaseAdd-item","select",".purchaseAdd-item_class");
    let qty_check = validateField("#purchaseAdd-itemQty","select",".purchaseAdd-itemQty_class");
    if(vendor_check == true && item_check == true && qty_check == true){
        let itemId = $('#purchaseAdd-item').val();
        let itemName = $('#purchaseAdd-item option:selected').text();
        let qty = $('#purchaseAdd-itemQty').val();
        if(qty > 0){

            let unit = $('#purchaseAdd-item option:selected').data('uom');
            let check = items.includes(parseInt(itemId));
            if(check){
                toastErrorAlert('Item already exist');
                $('.exits'+itemId).focus();
                return;
            }else{
                items.push(parseInt(itemId));
            }
           let itemDatas = '';
           itemDatas+= `<tr>
                            <td>${i}</td>
                            <td>${itemName}
                            <input type="hidden" name="purchase-itemId[]" value="${itemId}"></td>
                            <td><input type="number" name="purchase-itemQty[]" class="form-control form-control-sm exits${itemId}" style="width: 100px;" value="${qty}"></td>
                            <td>${unit}
                            <input type="hidden" name="purchase-unit[]" value="${unit}"></td>
                            <td>
                                <ul class="action"> 
                                <li class="delete ms-1" id="deleteBtn" onclick="removeLeadRow(this,${itemId})"><i class="icon-trash"></i></li>
                                </ul>
                            </td>
                        </tr>`;
                        i++;       
            $('.appendItemData').append(itemDatas);     
            $('#purchaseAdd-item').val('').change();
            $('#purchaseAdd-itemQty').val('').change();
        }else{

            toastErrorAlert('Qty cannot be 0 ');
            return;

        }
    }else{
       console.log('Please fill required fields');
    }

    if(items.length > 0){
        $('.itemAddShow').removeClass('d-none');
    }else{
        $('.itemAddShow').addClass('d-none');
    }
}

function removeLeadRow(x,id = ''){
    let result = items.filter(item => item !== id);
    $(x).closest('tr').remove();
    if(items.length > 0){
        $('.itemAddShow').removeClass('d-none');
    }else{
        $('.itemAddShow').addClass('d-none');
    }
}

function purchaseItemsBulkSubmit(){
    let chk_zero = true;
    let vendor = $('#purchaseAdd-vendor').val();
    let itemId = $('input[name="purchase-itemId[]"]').map(function(){return $(this).val()}).get();
    let qty = $('input[name="purchase-itemQty[]"]').map(function(){
        if($(this).val() > 0){
            return $(this).val()
        }else{
            chk_zero = false;
        }
    }).get();
    let unit = $('input[name="purchase-unit[]"]').map(function(){return $(this).val()}).get();
    if(itemId.length === 0){
        toastErrorAlert('No item found !');
    }else{
        if(chk_zero){

            $('.purchaseAddSubmit').addClass('d-none');
            $('.purchaseAddSpinn').removeClass('d-none');
            $.ajax({
                url:purchaseAddSubmit,
                type:"POST",
                data:{vendor:vendor,itemId:itemId,qty:qty,unit:unit},
                success:function(response){
                    if(response.success){
                        // $('.purchaseAddSpinn').addClass('d-none');
                        // $('.purchaseAddSubmit').removeClass('d-none');
                        toastSuccessAlert(response.success);
                        setTimeout(function(){
                            window.location.href= purchaseOrder;
                        },1000);
                    }else{
                        toastErrorAlert('error found!');
                        $('.purchaseAddSpinn').addClass('d-none');
                        $('.purchaseAddSubmit').removeClass('d-none');
                    }
                },
                error:function(xhr,status,error){
                    console.log(xhr.responseText);
                    alert("An error occoured "+error);
                }
            });

        }else{

            toastErrorAlert('Item Qty cannot be 0');
        }
        
    }
}

let purchase_items_table = $('#purchase-items-table').DataTable({
    processing:true,
    serverSide:true,
    ajax:{
        url:purchaseItemVeiw,
        type:"POST",
        error:function(xhr,error,thrown){
            console.log(xhr.responseText);
            alert("An error occured "+thrown);
        }
         },
        columns:[{
            data:'purchase_id',
            name:'purchase_id'
        },
        {
            data:'item',
            name:'item'
        },
        {
            data:'qty',
            name:'qty'
        },
        {
            data:'vendor',
            name:'vendor'
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
            data:'action',
            name:'aciton',
            orderable:false,
            searchable:false
        }
    ]
   
});

function editPurchase(id){
    $.ajax({
        url:getPurchaseItem,
        type:"POST",
        data:{id:id},
        success:function(response){
            let getData = response.data[0];
            $('#purchase_item_id').val(getData['id']);
            $('#purchase_edit_id').val(getData['purchase_id']);
            $('#purchase_edit_item').val(getData['item']);
            $('#purchase_edit_qty').val(getData['qty']);
        },
        error:function(xhr,error,thrown){
            console.log(xhr.responseText);
            alert('error found: '+thrown);
        }
    });
}

function purchaseItemUpdate(id){
    let qty_check = validateField("#purchase_edit_qty","select",".purchase_edit_qty_class");
    if(qty_check == true){
        let qty =  $('#purchase_edit_qty').val();
        if(qty < 1){
            qty = 1;
        }
        $.ajax({
            url:purchaseQtyUpdate,
            type:"POST",
            data:{id:id,qty:qty},
            success:function(response){
                if(response.success){
                    $('#purchaseListEditModel').modal('hide');
                    $('#purchase-items-table').DataTable().ajax.reload();
                    toastSuccessAlert(response.success);
                }else{
                    toastErrorAlert(response.error_success);
                }
            },
            error:function(xhr,error,thrown){
                console.log(xhr.responseText);
                alert('error found: '+thrown);
            }
        });
    }else{
        console.log('Please fill required fields');
    }
}

function printPurchase(x){
    let url = '../store/purchase-print/'+x;
    window.open(url,'_blank');
}