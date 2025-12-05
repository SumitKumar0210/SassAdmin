function updateInvoiceSettingDetail(){
    let prefix = $('#invoice_prefix_general_setting').val();
    let suffix_length = $('#invoice_suffix_general_setting').val();

    if(prefix != '' && suffix_length > 0){
        $('.invoice-setting-form').removeClass('was-validated');
        $.ajax({
            url: updateInvoiceGeneralSetting,
            type: "POST",
            data: {prefix:prefix,suffix_length:suffix_length},
            success: function(response) {
                if (response.success) {
                    $('.alert_msg').html('Invoice Setting Updated Successfully');
                    var toastElement = document.getElementById('liveToast');
                    var toast = new bootstrap.Toast(toastElement);
                    toast.show();
                } else {
                    alert("error");
                }
            }
        });
    }else{
        $('.invoice-setting-form').addClass('was-validated');
    }
}

function resetInvoiceNumber(){
    Swal.fire({
        title: "Are you sure?",
        text: "You want to reset Invoice Number",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, reset it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: resetInvoice,
                type: "POST",
                data: {
                    id: 1
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire("Updated", response.success, "success");
                    } else {
                        Swal.fire("Error!", "Error", "error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    Swal.fire("Error!", "An error occurred: " + error, "error");
                }
            });
        }
    });
}