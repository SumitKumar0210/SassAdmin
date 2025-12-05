let deficiency_table = $('#expired-report-table').DataTable({
    processing:true,
    serverSide:true,
    ajax:{
        url:wasteDisposeReportView,
        type:"POST",
        error:function(xhr,error,thrown){
            console.log(xhr.responseText);
            alert("An error occured "+thrown);
        }
         },
        columns:[{
            data:'item',
            name:'item'
        },
        {
            data:'unit',
            name:'unit'
        },
        {
            data:'qty',
            name:'qty'
        },
        {
            data:'expired',
            name:'expired'
        },
        {
            data:'action',
            name:'action'
        }
    ]
});

function disposeItem(id){

    Swal.fire({
        title: "Are you sure to Dispose this Item?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Dispose it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url:wasteDisposeItem,
                type:"POST",
                data:{id:id},
                success:function(response){
                    if (response.success) {
                        $('#expired-report-table').DataTable().ajax.reload();
                        toastSuccessAlert(response.success);
                        
                    }else{
                        toastErrorAlert(response.error_success);
                    }
                }
            });
        }
    });
}