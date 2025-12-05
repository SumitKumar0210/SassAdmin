    let company_table = $('#company_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: companyView,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            error: function(xhr, error, thrown) {
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
                data: 'gst',
                name: 'gst'
            },
            {
                data: 'state',
                name: 'state'
            },
            {
                data: 'mobile',
                name: 'mobile'
            },
            {
                data: 'email',
                name: 'email'
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
                orderable: false,
                searchable: false
            },
        ]
    });

    $('.add_company_modal').click(function() {
        $('.gst_change_detail').show();
        $('#company_id').val('')
        $('#company_name').val('');
        $('#company_address').val('');
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
        $('#company_gst').val('');
        $('#company_mobile').val('');
        $('#company_email').val('');
        $('#company_billing_address').val('');
        $('#company_billing_pincode').val('');
        $('#company_billing_state').val('');
        $('#compnay_details_manually').prop('checked',false);
        $('.check_address_billing').prop('checked',true);
        $('.billing-detail').addClass('d-none');
        $('.companyTitle').html('Add Company');
        $('.needs-validation').removeClass('was-validated');
        $('.companySubmit').removeClass('d-none');
        $('.companyUpdate').addClass('d-none');
    });

    $('#company_form').on('submit', function(e) {
        e.preventDefault();
        let id = $('#company_id').val();
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
        let TradeName = $('#company_name').val();
        let AddrPncd = $('#gstAddrPncd').val();
        let address = $('#company_address').val();
        let StateCode = $('#gstStateCode').val();
        let gst = $('#company_gst').val();
        let mobile = $('#company_mobile').val();
        let email = $('#company_email').val();
        let state = $("#gstStateCode option:selected").text();
        let billing_address = $('#company_billing_address').val();
        let billing_pincode = $('#company_billing_pincode').val();
        let billing_state_code = $('#company_billing_state').val();
        let billing_state = $("#company_billing_state option:selected").text();
        
        if($('#compnay_details_manually').is(':checked')) {
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
            gst = $('#company_gst').val('');
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
            if ($('.companyUpdate').is(':visible')) {
                companyUpdate(id); // Trigger update function when update btn is active
            } else {
                $.ajax({
                    url: companyAdd,
                    type: "POST",
                    data: {
                        LegalName:LegalName,AddrBnm:AddrBnm,AddrBno:AddrBno,AddrFlno:AddrFlno,AddrSt:AddrSt,AddrLoc:AddrLoc,TxpType:TxpType,Status:Status,BlkStatus:BlkStatus,DtReg:DtReg,DtDReg:DtDReg,TradeName:TradeName,AddrPncd:AddrPncd,address:address,StateCode:StateCode,state:state,mobile:mobile,email:email,gst:gst,billing_address:billing_address,billing_pincode:billing_pincode,billing_state_code:billing_state_code,billing_state:billing_state
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#company_form').removeClass('was-validated');
                            $('#company_form')[0].reset();
                            $('#companyModel').modal('hide');
                            $('.alert_msg').html(response.success);
                            var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                            toast.show();
                            $('#company_table').DataTable().ajax.reload();
                        } else if(response.alreadyfound){
                            $('.alert_msg_danger').html(response.alreadyfound);
                            var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                            toast.show();              
                        } else if(response.error_validation){
                            $('.alert_msg_danger').html(response.error_validation);
                            var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                            toast.show(); 
                        } else{             
                            console.log("Error");
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

    function companySwitch(id) {
        $.ajax({
            url: companySwitchStatus,
            type: "POST",
            data: {
                id: id
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    $('.alert_msg').html('Status Changed Successfully');
                    var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                    toast.show();             
                $('#room_bedtype_table').DataTable().ajax.reload();
                } else {
                    alert("Error");
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    }

    function companyEdit(id) {
        $('.gst_change_detail').hide();
        $.ajax({
            url: companyGetData,
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
                    $('#company_id').val(id);
                    if(getData.Gstin != ""){
                        $('#compnay_details_manually').prop('checked',false);
                        $('#company_gst').val(getData.Gstin);
                        $('.company_gst').show();
                        $('#company_name').prop('readonly',true);
                        $('#company_address').prop('readonly',true);
                        $('#gstAddrPncd').prop('readonly',true);
                        $('#gstStateCode').prop('disabled',true);
                    }else{
                        $('#compnay_details_manually').prop('checked',true);
                        $('.company_gst').hide();
                        $('#company_name').prop('readonly',false);
                        $('#company_address').prop('readonly',false);
                        $('#gstAddrPncd').prop('readonly',false);
                        $('#gstStateCode').prop('disabled',false);
                    }

                    $('#company_name').val(getData.LegalName);
                    $('#company_address').val(getData.address);
                    $('#gstAddrPncd').val(getData.addrPncd);
                    $('#gstStateCode').val(getData.StateCode);
                    $('#company_mobile').val(getData.mobile);
                    $('#company_email').val(getData.email);

                    if(getData.billing_address == getData.address){
                        $('.check_address_billing').prop('checked',true);
                        $('.billing-detail').addClass('d-none');
                    }else{
                        $('.check_address_billing').prop('checked',false);
                        $('.billing-detail').removeClass('d-none');
                    }
                    
                    $('#company_billing_address').val(getData.billing_address);
                    $('#company_billing_pincode').val(getData.billing_pincode);
                    $('#company_billing_state').val(getData.billing_state_code);
                    $('#companyModel').modal('show');
                    $('.companyTitle').html('Edit Company');
                    $('.companySubmit').addClass('d-none');
                    $('.companyUpdate').removeClass('d-none');
                } else {
                    console.log("error");
                }
            }
        });
    }

    function companyUpdate(id) {

        let name = $('#company_name').val();
        let address = $('#company_address').val();
        let pincode = $('#gstAddrPncd').val();
        let state_code = $('#gstStateCode').val();
        let state = $("#gstStateCode option:selected").text();
        let mobile = $('#company_mobile').val();
        let email = $('#company_email').val();
        let billing_address = $('#company_billing_address').val();
        let billing_pincode = $('#company_billing_pincode').val();
        let billing_state_code = $('#company_billing_state').val();
        let billing_state = $("#company_billing_state option:selected").text();

        if (name == '' || address =='' || state_code == '' || pincode == '') {
            $('needs-validation').addClass('was-validated');
        } else {
            $.ajax({
                url: companyDataUpdate,
                type: "POST",
                data: {id:id,name:name,address:address,pincode:pincode,state_code:state_code,state:state,mobile:mobile,email:email,billing_address:billing_address,billing_pincode:billing_pincode,billing_state_code:billing_state_code,billing_state:billing_state
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        $('#company_form').removeClass('was-validated');
                        $('#company_form')[0].reset();
                        $('#companyModel').modal('hide');
                        $('.alert_msg').html(response.success);
                        var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                        toast.show();
                        $('#company_table').DataTable().ajax.reload();
                    } else if(response.alreadyfound){
                        $('.alert_msg_danger').html(response.alreadyfound);
                        var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                        toast.show();              
                    } else if(response.error_validation){
                        $('.alert_msg_danger').html(response.error_validation);
                        var toast = new bootstrap.Toast(document.getElementById('liveToast2'));
                        toast.show(); 
                    } else{             
                        console.log("Error");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("An error occurred: " + error);
                }
            });
        }
    }

    function checkGstRequest(number){
        
        const regex = /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z][1-9A-Z]Z[0-9A-Z]$/ // only alphanumeric, exactly 15 chars
        if(regex.test(number)){
           
            $.ajax({
                url: companyVerifyGst,
                type: "POST",
                data: {
                    number:number,type:'Company'
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

                            $('#departmentModel').modal('hide');
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
                            $('#company_name').val(data.TradeName);
                            $('#gstAddrPncd').val(data.AddrPncd);
                            let addr = data.AddrFlno +', '+ data.AddrBno +', '+ data.AddrBnm +', '+ data.AddrSt +', '+ data.AddrLoc;
                            $('#company_address').val(addr);
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

    $('#compnay_details_manually').on('click',function(){
        if($('#compnay_details_manually').is(':checked')) {
            $('.company_gst').hide();
            $('#company_name').prop('readonly',false);
            $('#company_address').prop('readonly',false);
            $('#gstAddrPncd').prop('readonly',false);
            $('#gstStateCode').prop('disabled',false);
        } else {
            $('.company_gst').show();
            $('#company_name').prop('readonly',true);
            $('#company_address').prop('readonly',true);
            $('#gstAddrPncd').prop('readonly',true);
            $('#gstStateCode').prop('disabled',true);
        }
    });

    function checkEmailValid(id,value){
        let isEmailValid = true;
        if(value.length > 0){
            isEmailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
        }
        if(isEmailValid === false){
            $('#'+ id).addClass("is_field_invalid");
            $('.'+id+'_class').text("invalid email id").addClass("is_invalid");
        }else{
            $('#'+ id).removeClass("is_field_invalid");
            $('.'+id+'_class').text("");
        }
    }

    $('.check_address_billing').on('click',function(){
        if($('.check_address_billing').is(':checked')) {
            $('.billing-detail').addClass('d-none');
        } else {
            $('.billing-detail').removeClass('d-none');
        }
    });