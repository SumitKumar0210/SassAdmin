let running_kot = $('#kot-running-table').DataTable({
    processing: true,
    serverSide: true,
    ajax:{
        url: runningKotData,
        type: "POST",
        headers:{
        'X-CSRF-TOKEN' : $('meta[input="csrf_token"]').attr('content')
        },
        error:function(xhr,error,thrown){
            console.log(xhr.responseText);
            alert('Error:'+ thrown);
        }
    },
    
    columns:[
        {
            data:'kot_id',
            name:'kot_id'
        },
        {
            data:'type',
            name:'type'
        },
        {
            data:'room_num',
            name:'room_num'
        },
        {
            data:'order_time',
            name:'order_time'
        },
        {
            data:'complimentary',
            name:'complimentary'
        },
        {
            data:'waiter',
            name:'waiter'
        },
        {
            data:'amount',
            name:'amount'
        },
        {
            data:'paid',
            name:'paid'
        },
        {
            data:'status',
            name:'status'
        },
        {
            data:'action',
            name:'action'
        }
    ]
});