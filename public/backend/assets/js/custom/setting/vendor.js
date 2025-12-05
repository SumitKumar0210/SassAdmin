let vendor_table = $('#vendor_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: vendorView,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        error: function(xhr, error, thrown) {
            console.log(xhr.responseText);
            alert('Error: ' + thrown);
        }
    },
    columns: [{
            data: 'DT_RowIndex',
            name: 'DT_RowIndex'
        },
        {
            data: 'name',
            name: 'name'
        },
        {
            data: 'mobile',
            name: 'mobile'
        },
        {
            data: 'address',
            name: 'address'
        },
        {
            data: 'gst',
            name: 'gst'
        },
        {
            data: 'status',
            name: 'status',
            orderable: false,
            searchable: false
        },
        {
            data: 'action',
            name: 'action',
        },
    ]
});

$('.vendor_add').click(function() {

    $('.gst_change_detail').show();
    $('#vendorId').val('');
    $('#vendor_gst').val('');
    $('#vendor_name').val('');
    $('#vendor_address').val('');
    $('#gstAddrPncd').val('');
    $('#gstStateCode').val('');
    $('#gstLegalName').val('');
    $('#gstAddrBnm').val('');
    $('#gstAddrBno').val('');
    $('#gstAddrFlno').val('');
    $('#gstAddrSt').val('');
    $('#gstAddrLoc').val('');
    $('#gstTxpType').val('');
    $('#gstStatus').val('');
    $('#gstBlkStatus').val('');
    $('#gstDtReg').val('');
    $('#gstDtDReg').val('');
    $('#vendor_gst').val('');
    $('#vendor_mobile').val('');
    $('#vendor_email').val('');
    $('#vendor_billing_address').val('');
    $('#vendor_billing_pincode').val('');
    $('#vendor_billing_state').val('');
    $('#compnay_details_manually').prop('checked',false);
    $('.check_address_billing').prop('checked',true);
    $('.billing-detail').addClass('d-none');
    $('.vendorTitle').html('Add Vendor');
    $('.needs-validation').removeClass('was-validated');
    $('.vendorSubmit').removeClass('d-none');
    $('.vendorUpdate').addClass('d-none');
});

$('#vendor_form').on('submit', function(e) {
    e.preventDefault();
    let id = $('#vendorId').val();
    let name = $('#vendor_name').val();
    let mobile = $('#vendor_mobile').val();
    let address = $('#vendor_address').val();
    let gst = $('#vendor_gst').val();
    let LegalName = $('#gstLegalName').val();
    let AddrBnm = $('#gstAddrBnm').val();
    let AddrBno = $('#gstAddrBno').val();
    let AddrFlno = $('#gstAddrFlno').val();
    let AddrSt = $('#gstAddrSt').val();
    let AddrLoc = $('#gstAddrLoc').val();
    let TxpType = $('#gstTxpType').val();
    let Status = $('#gstStatus').val();
    let BlkStatus = $('#gstBlkStatus').val();
    let DtReg = $('#gstDtReg').val();
    let DtDReg = $('#gstDtDReg').val();
    let AddrPncd = $('#gstAddrPncd').val();
    let StateCode = $('#gstStateCode').val();
    let TradeName = $('#vendor_name').val();
    let state = $("#gstStateCode option:selected").text();
    let billing_address = $('#vendor_billing_address').val();
    let billing_pincode = $('#vendor_billing_pincode').val();
    let billing_state_code = $('#vendor_billing_state').val();
    let billing_state = $("#vendor_billing_state option:selected").text();
    
    if($('#vendor_details_manually').is(':checked')) {
        LegalName = $('#gstLegalName').val('');
        AddrBnm = $('#gstAddrBnm').val('');
        AddrBno = $('#gstAddrBno').val('');
        AddrFlno = $('#gstAddrFlno').val('');
        AddrSt = $('#gstAddrSt').val('');
        AddrLoc = $('#gstAddrLoc').val('');
        TxpType = $('#gstTxpType').val('');
        Status = $('#gstStatus').val('');
        BlkStatus = $('#gstBlkStatus').val('');
        DtReg = $('#gstDtReg').val('');
        DtDReg = $('#gstDtDReg').val('');
        gst = $('#vendor_gst').val('');
    } 

    if($('.check_address_billing').is(':checked')) {
        billing_address = address;
        billing_pincode = AddrPncd;
        billing_state_code = StateCode;
        billing_state = state;
    }

    if (LegalName == '' || address =='' || StateCode == '' || AddrPncd == '') {
        $('needs-validation').addClass('was-validated');
    } else {
        if ($('.vendorUpdate').is(':visible')) {
        vendorUpdate(id); // Trigger update function when update btn is active
        } else {
            $.ajax({
                url: vendorAdd,
                type: "POST",
                data: {
                    name:name,LegalName:LegalName,AddrBnm:AddrBnm,AddrBno:AddrBno,AddrFlno:AddrFlno,AddrSt:AddrSt,AddrLoc:AddrLoc,TxpType:TxpType,Status:Status,BlkStatus:BlkStatus,DtReg:DtReg,DtDReg:DtDReg,TradeName:TradeName,AddrPncd:AddrPncd,address:address,StateCode:StateCode,state:state,mobile:mobile,gst:gst,billing_address:billing_address,billing_pincode:billing_pincode,billing_state_code:billing_state_code,billing_state:billing_state
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#vendorModel').modal('hide');
                        $('#vendor_form').removeClass('was-validated');
                        $('#vendor_form')[0].reset();
                        $('#vendor_table').DataTable().ajax.reload();
                        toastSuccessAlert(response.success);
                    } else if(response.alreadyfound){
                        toastErrorAlert(response.alreadyfound);             
                    } else if(response.error_validation){
                        toastWarningAlert(response.error_validation);
                    } else{             
                        toastErrorAlert("something went wrong!");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("An error occurred: " + error);
                }
            });
        }
    }
});

function vendorSwitch(id) {
    $.ajax({
        url: vendorSwitchStatus,
        type: "POST",
        data: {
            id: id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                toastSuccessAlert(response.success);           
            $('#room_bedtype_table').DataTable().ajax.reload();
            } else {
                toastErrorAlert("something went wrong!");
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("An error occurred: " + error);
        }
    });
}

function vendorEdit(id) {
    $('.gst_change_detail').hide();
    $.ajax({
        url: vendorGetData,
        type: "POST",
        data: {
            id: id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                let getData = response.data[0];
                $('#vendorId').val(id);
                if(getData.gst != ""){
                    
                    $('#vendor_details_manually').prop('checked',false);
                    $('#vendor_gst').val(getData.gst);
                    $('.vendor_gst').show();
                    $('#vendor_name').prop('readonly',true);
                    $('#vendor_address').prop('readonly',true);
                    $('#gstAddrPncd').prop('readonly',true);
                    $('#gstStateCode').prop('disabled',true);
                }else{
                    $('#vendor_details_manually').prop('checked',true);
                    $('.vendor_gst').hide();
                    $('#vendor_name').prop('readonly',false);
                    $('#vendor_address').prop('readonly',false);
                    $('#gstAddrPncd').prop('readonly',false);
                    $('#gstStateCode').prop('disabled',false);
                }

                $('#vendor_name').val(getData.LegalName);
                $('#vendor_address').val(getData.address);
                $('#gstAddrPncd').val(getData.addrPncd);
                $('#gstStateCode').val(getData.StateCode);
                $('#vendor_mobile').val(getData.mobile);

                if(getData.billing_address == getData.address){
                    $('.check_address_billing').prop('checked',true);
                    $('.billing-detail').addClass('d-none');
                }else{
                    $('.check_address_billing').prop('checked',false);
                    $('.billing-detail').removeClass('d-none');
                }
                
                $('#vendor_billing_address').val(getData.billing_address);
                $('#vendor_billing_pincode').val(getData.billing_pincode);
                $('#vendor_billing_state').val(getData.billing_state_code);
                $('#vendorModel').modal('show');
                $('.vendorTitle').html('Edit vendor');
                $('.vendorSubmit').addClass('d-none');
                $('.vendorUpdate').removeClass('d-none');
            } else {
                alert("error");
            }
        }
    });
}

function vendorUpdate(id) {
    let name = $('#vendor_name').val();
    let mobile = $('#vendor_mobile').val();
    let address = $('#vendor_address').val();
    let pincode = $('#gstAddrPncd').val();
    let state_code = $('#gstStateCode').val();
    let state = $("#gstStateCode option:selected").text();
    let billing_address = $('#vendor_billing_address').val();
    let billing_pincode = $('#vendor_billing_pincode').val();
    let billing_state_code = $('#vendor_billing_state').val();
    let billing_state = $("#vendor_billing_state option:selected").text();

    if (name == '' || address =='' || state_code == '' || pincode == '') {
        $('needs-validation').addClass('was-validated');
    } else {
        $.ajax({
            url: vendorDataUpdate,
            type: "POST",
            data: {id:id,name:name,address:address,pincode:pincode,state_code:state_code,state:state,mobile:mobile,billing_address:billing_address,billing_pincode:billing_pincode,billing_state_code:billing_state_code,billing_state:billing_state
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('#vendor_form').removeClass('was-validated');
                    $('#vendor_form')[0].reset();
                    $('#vendorModel').modal('hide');
                    toastSuccessAlert(response.success);
                    $('#vendor_table').DataTable().ajax.reload();
                } else if(response.alreadyfound){
                    toastErrorAlert(response.alreadyfound);            
                } else if(response.error_validation){
                    toastWarningAlert(response.error_validation);
                } else{             
                    toastErrorAlert("something went wrong!");
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    }
}

$('#vendor_details_manually').on('click',function(){
    if($('#vendor_details_manually').is(':checked')) {
        $('.vendor_gst').hide();
        $('#vendor_name').prop('readonly',false);
        $('#vendor_address').prop('readonly',false);
        $('#gstAddrPncd').prop('readonly',false);
        $('#gstStateCode').prop('disabled',false);
    } else {
        $('.vendor_gst').show();
        $('#vendor_name').prop('readonly',true);
        $('#vendor_address').prop('readonly',true);
        $('#gstAddrPncd').prop('readonly',true);
        $('#gstStateCode').prop('disabled',true);
    }
});

function checkGstRequest(number){
        
    const regex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][1-9A-Z]Z[0-9A-Z]$/ // only alphanumeric, exactly 15 chars
    if(regex.test(number)){
        
        $.ajax({
            url: companyVerifyGst,
            type: "POST",
            data: {
                number:number,type:'Vendor'
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status == 200) {
                    let data = response.data.data;
                    if(data == undefined){
                        
                        let a = JSON.parse(response.data.status_desc);
                        Swal.fire('Error-'+a[0].ErrorCode, a[0].ErrorMessage, 'error');
                    }else{

                        $('#gstLegalName').val(data.LegalName);
                        $('#gstAddrBnm').val(data.AddrBnm);
                        $('#gstAddrBno').val(data.AddrBno);
                        $('#gstAddrFlno').val(data.AddrFlno);
                        $('#gstAddrSt').val(data.AddrSt);
                        $('#gstAddrLoc').val(data.AddrLoc);
                        $('#gstTxpType').val(data.TxpType);
                        $('#gstStatus').val(data.Status);
                        $('#gstBlkStatus').val(data.BlkStatus);
                        $('#gstDtReg').val(data.DtReg);
                        $('#gstDtDReg').val(data.DtDReg);
                        $('#vendor_name').val(data.TradeName);
                        $('#gstAddrPncd').val(data.AddrPncd);
                        let addr = data.AddrFlno +', '+ data.AddrBno +', '+ data.AddrBnm +', '+ data.AddrSt +', '+ data.AddrLoc;
                        $('#vendor_address').val(addr);
                        $('#gstStateCode').val(data.StateCode);
                    }
                } else if(response.alreadyfound){
                    $('.alert_msg_danger').html('Gst already exists in record!');
                    var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                    toast.show();
                }else{             
                    alert("Error");
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    }else{
        $('.alert_msg_danger').html('Invalid GST Number');
        var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
        toast.show();
    }
}

$('.check_address_billing').on('click',function(){
    if($('.check_address_billing').is(':checked')) {
        $('.billing-detail').addClass('d-none');
    } else {
        $('.billing-detail').removeClass('d-none');
    }
});