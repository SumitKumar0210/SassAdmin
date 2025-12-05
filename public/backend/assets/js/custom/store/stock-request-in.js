function acceptStockRequest(){

    let request_id = $('input[name="stock_request_id[]"]').map(function(){return $(this).val()}).get();
    let received_qty = $('input[name="stock_request_received_qty[]"]').map(function(){return $(this).val()}).get();
    $('.requestReceivedSubmit').addClass('d-none');
    $('.requestReceivedSpinn').removeClass('d-none');

    $.ajax({
        url:stockReceivedQuantityUpdate,
        type:"POST",
        data:{request_id:request_id,received_qty:received_qty},
        success:function(response){
            if(response.success){
                setTimeout(function(){
                    // $('.requestReceivedSpinn').addClass('d-none');
                    // $('.requestReceivedSubmit').removeClass('d-none');
                    toastSuccessAlert(response.success);
                    window.location.reload();
                },500);
                
            }else{
                $('.requestReceivedSpinn').addClass('d-none');
                $('.requestReceivedSubmit').removeClass('d-none');
                toastErrorAlert('something went wrong!');
            }
            received_items = [];
        },
        error:function(xhr,error,thrown){
            console.log(xhr.responseText);
            alert("error found: "+thrown);
        }
    });
}

function maxqty(order_qty, inputElement) {
    let received_qty = parseFloat(inputElement.value);
    if (received_qty > order_qty) {
        inputElement.value = order_qty; // Reset to max allowed
    }
    if (isNaN(received_qty) || received_qty <= 0) {
        inputElement.value = 0; 
    }
}