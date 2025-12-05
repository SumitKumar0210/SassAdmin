
$('#hotlr_setting_form').on('submit', function(e) {
    e.preventDefault();
    
    let name = $('#setting_hotlr_name').val();
    let gst = $('#setting_hotlr_gst').val();
    
    if (name == '' || gst == '') {
        $('needs-validation').addClass('was-validated');
    } else {
        let logo = $('#hotlr-upload-logo').prop('files')[0];
        let item_add = $('#hotlr-upload-item-add').prop('files')[0];
        let notification = $('#hotlr-upload-notification-sound').prop('files')[0];

        var formData = new FormData(this);
        formData.append('name', $('#setting_hotlr_name').val());
        formData.append('email', $('#setting_hotlr_email').val());
        formData.append('contact', $('#setting_hotlr_contact').val());
        formData.append('address', $('#setting_hotlr_address').val());
        formData.append('state', $('#setting_hotlr_state').val());
        formData.append('city', $('#setting_hotlr_city').val());
        formData.append('zipcode', $('#setting_hotlr_zipcode').val());
        formData.append('country', $('#setting_hotlr_country').val());
        formData.append('gst', $('#setting_hotlr_gst').val());
        formData.append('website', $('#setting_hotlr_website').val());
        formData.append('logo', logo);
        formData.append('item_add', item_add);
        formData.append('notification', notification);

        $.ajax({
            url: settingAdd, // PHP script to handle the upload
            type: 'POST',
            data: formData,
            contentType: false, // Important: Don't set content type
            processData: false, // Important: Don't process the data
            success: function(response) {
                toastSuccessAlert(response.success);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    }
});

$('#hotlr_einvoice_form').on('submit', function(e) {
    e.preventDefault();
    
    let einvoice_email = $('#hotlr_einvoice_email').val();
    let einvoice_username = $('#hotlr_einvoice_username').val();
    let einvoice_password = $('#hotlr_einvoice_password').val();
    let einvoice_ipaddress = $('#hotlr_einvoice_ipaddress').val();
    let einvoice_clientid = $('#hotlr_einvoice_clientid').val();
    let einvoice_clientsecret = $('#hotlr_einvoice_clientsecret').val();
    let einvoice_gst = $('#hotlr_einvoice_gst').val();

    if (einvoice_email == '' || einvoice_username == '' || einvoice_password == '' || einvoice_ipaddress == '' || einvoice_clientid == '' || einvoice_clientsecret == '' || einvoice_gst == '') {
        $('needs-validation').addClass('was-validated');
    } else {
        if ($('.tariffUpdate').is(':visible')) {
        tariffUpdate(id); // Trigger update function when update btn is active
        } else {
            $.ajax({
                url: settingAddEinvoice,
                type: "POST",
                data: {einvoice_email:einvoice_email,einvoice_username:einvoice_username,einvoice_password:einvoice_password,einvoice_ipaddress:einvoice_ipaddress,einvoice_clientid:einvoice_clientid,einvoice_clientsecret:einvoice_clientsecret,einvoice_gst:einvoice_gst},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastSuccessAlert(response.success);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("An error occurred: " + error);
                }
            });
        }
    }
});

$('#hotlr_add_item_sound_form').on('submit', function(e) {
    e.preventDefault();
    
    let item_add = $('#hotlr-upload-item-add').prop('files')[0];
    if(item_add != undefined){
       
        var formData = new FormData(this);
        formData.append('item_add', item_add);
        formData.append('type', 'item_add');
        
        $.ajax({
            url: settingAddSound, // PHP script to handle the upload
            type: 'POST',
            data: formData,
            contentType: false, // Important: Don't set content type
            processData: false, // Important: Don't process the data
            success: function(response) {
                toastSuccessAlert(response.success);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    }else{
        toastErrorAlert('Upload Item Add Sound');
    }
});

$('#hotlr_notification_sound_form').on('submit', function(e) {
    e.preventDefault();
    
    let notification = $('#hotlr-upload-notification-sound').prop('files')[0];
    if(notification != undefined){

        var formData = new FormData(this);
        formData.append('notification', notification);
        formData.append('type', 'notification');

        $.ajax({
            url: settingAddSound, // PHP script to handle the upload
            type: 'POST',
            data: formData,
            contentType: false, // Important: Don't set content type
            processData: false, // Important: Don't process the data
            success: function(response) {
                toastSuccessAlert(response.success);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    }else{
        toastErrorAlert('Upload Notification Sound');
    }
});

// time setting
function checkTimeZone(x){
    if(x == ""){
        $('.time-setting').addClass('d-none');
    }else{
        $('.time-setting').removeClass('d-none');
    }
}

$('body').on('change', '#general_setting_time_slot', function(){
    
    if ($('#general_setting_time_slot').prop('checked')) {
        $('.time-setting-slot').removeClass('d-none');
    } else {
        $('.time-setting-slot').addClass('d-none');
    }
});

$('body').on('change', '#general_setting_early_checkin', function(){
    
    if ($('#general_setting_early_checkin').prop('checked')) {
        $('.general_setting_early_checkin_para').removeClass('d-none');
    } else {
        $('.general_setting_early_checkin_para').addClass('d-none');
    }
});

$('#hotlr_add_time_form').on('submit', function(e) {
    e.preventDefault();
    
    let timezone = $('#general_setting_timezone').val();
    let timeslot = 0;
    if ($('#general_setting_time_slot').prop('checked')) {
        timeslot = 1;
    } 
    let checkout_time = $('#general_setting_checkout_time').val();
    let checkout_buffer_time = $('#general_setting_checkout_buffer').val();
    let checkin_time = $('#general_setting_checkin_time').val();
    let checkin_early_time = $('#general_setting_early_checkin_buffer').val();
    
    if(timezone != ''){

        $.ajax({
            url: settingTimeConfiguration,
            type: "POST",
            data: {timezone:timezone,timeslot:timeslot,checkout_time:checkout_time,checkout_buffer_time:checkout_buffer_time,checkin_time:checkin_time,checkin_early_time:checkin_early_time},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                toastSuccessAlert(response.success);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("An error occurred: " + error);
            }
        });
    }

});