let pending_request_table = $('#pending-request-table').DataTable({
    processing:true,
    serverSide:true,
    ajax:{
        url:pendingRequestVeiw,
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
            name:'aciton',
            orderable:false,
            searchable:false
        }
    ]
});
function stockReturnPage(id){
    window.location.href= '/kitchen/return-request/' + id; 
}