function chkTime(){
    let start = $('#audit_start_general_setting').val();
    let end = $('#audit_end_general_setting').val();

    if ((start != '') && (end != '')) {
        let startDate = new Date("1970-01-01T" + start + ":00");
        let endDate = new Date("1970-01-01T" + end + ":00");
        if (endDate <= startDate) {
            endDate.setDate(endDate.getDate() + 1);
        }
        let diffMs = endDate - startDate;
        let diffHoursDecimal = diffMs / (1000 * 60 * 60); // Convert ms to hours
        let diffHours = Math.floor(diffMs / (1000 * 60 * 60));
        let diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));
        $('#audit_duration_general_setting_view').val(`${diffHours} Hrs ${diffMinutes} Mins`);
        $('#audit_duration_general_setting').val(parseFloat(diffHoursDecimal.toFixed(2)));
    }
}

function updateAuditTime(){
    let start = $('#audit_start_general_setting').val();
    let end = $('#audit_end_general_setting').val();
    let duration = $('#audit_duration_general_setting').val();

    $.ajax({
        url: updateAuditSetting,
        type: "POST",
        data: {
            id:1,start:start,end:end,duration:duration
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            $('.alert_msg').html(response.success);
            var toast = new bootstrap.Toast(document.getElementById('liveToast'));
            toast.show();
        }
    });
}