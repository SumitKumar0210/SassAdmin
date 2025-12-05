let received_items = [];
let purchase_order_table = $('#purchase-order-table').DataTable({
    processing:true,
    serverSide:true,
    ajax:{
        url:purchaseOrderVeiw,
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
            data:'order_item',
            name:'order_item'
        },
        {
            data:'received_item',
            name:'received_item'
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
            data:'status',
            name:'status'
        },
        {
            data:'action',
            name:'aciton',
            orderable:false,
            searchable:false
        }
    ]
   
});

function purchaseAddPage() {
    window.location.href = '/store/purchase-add-page';
}

function goodsEntry(id){
    window.location.href = '/store/purchase-goods-entry/'+id;
}


function addReceivedData(id,r_qty,last_qty){
    setTimeout(function(){
        let check = false;
        received_items.forEach(element => {
            if(element['id'] == parseInt(id)){
                if(element['last_qty'] == parseInt(r_qty)){
                received_items = received_items.filter(item => item.id !== parseInt(id));
                }else{
                element['qty'] = parseInt(r_qty);
            }
            check = true;
            }

        });
        if(check == false){
            received_items.push({
                'id':parseInt(id),
                'qty':parseInt(r_qty),
                'last_qty':parseInt(last_qty),
            })
        }
    },200);
}

function maxqty(order_qty, inputElement) {
    let received_qty = parseFloat(inputElement.value);
    if (received_qty >= order_qty) {
        inputElement.value = order_qty; // Reset to max allowed
    }
    if (isNaN(received_qty) || received_qty <= 0) {
        inputElement.value = 0; 
    }
}

function receivedQtyUpdate(purchase_id){

    if(received_items.length === 0){
        toastErrorAlert('kindly modify the quantity');
        return
    }
    
    let expiry_dates = $('input[name="purchase_expiry_date[]"]').map(function(){return $(this).val()}).get();
    let count_date = $('input[name="purchase_expiry_date[]"]').filter(function() { return $(this).val().trim() !== "";}).length;
    let count_item = $('input[name="purchase_received_qty[]"]').filter(function() { return $(this).val() != 0;}).length;

    if(count_date == count_item){
        
        $('.purchaseReceivedSubmit').addClass('d-none');
        $('.purchaseReceivedSpinn').removeClass('d-none');

        $.ajax({
            url:receivedQuantityUpdate,
            type:"POST",
            data:{purchase_id:purchase_id,received_items:received_items,expiry_dates:expiry_dates},
            success:function(response){
                if(response.success){
                    $('#purchase-order-table').DataTable().ajax.reload();
                        // $('.purchaseReceivedSpinn').addClass('d-none');
                        // $('.purchaseReceivedSubmit').removeClass('d-none');
                        toastSuccessAlert(response.success);
                        setTimeout(function(){
                                window.location.href= purchaseOrder;
                        },1000);             
                }else{
                    $('.purchaseReceivedSpinn').addClass('d-none');
                    $('.purchaseReceivedSubmit').removeClass('d-none');
                    toastErrorAlert('something went wrong!');
                }
                received_items = [];
            },
            error:function(xhr,error,thrown){
                console.log(xhr.responseText);
                alert("error found: "+thrown);
            }
        });
    }else{
        toastErrorAlert('Select Expiry date');
        return
    }
}

function printPurchase(x){
    let url = '../store/purchase-print/'+x;
    window.open(url,'_blank');
}
