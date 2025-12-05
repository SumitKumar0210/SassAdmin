
function markAsDone(type){
    let current_value = 0;
    let comment = 'Pending';
    if ($('#parameter-'+type).prop('checked')) {
        current_value = 1;
        comment = 'Done';
    }

    Swal.fire({
        title: "Are you sure to Mark As "+comment+"?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: updateProgressAudit,
                type: "POST",
                data: {
                    type: type,
                    current_value: current_value,
                },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            text: "Audit detail updated",
                            showConfirmButton: false,
                            timer: 4000,
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 2500);
                    }
                },
            });
        }
    });
}

let remaining = $('.time_duration').html();
startAudit(0);
function startAudit(x){
    if(x != 0){
        stopTimer();
    }
    $.ajax({
        url: updateAuditTime,
        type: "POST",
        data: {
            x: x,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            // console.log(response);
            if(x == 0){
                if(response.duration_set == '00:00'){
                    localStorage.removeItem("remainingTime");
                    const value = localStorage.getItem('remainingTime');
                    if (value !== null) {
                        localStorage.removeItem("remainingTime");
                    }
                    $('#timer').html('00:00:00');
                }
                $('#startBtn').removeClass('d-none');
                $('.stopTimer').addClass('d-none');
                $('#timer').removeClass('d-none');
            }else if(x == 1){
                $('#startBtn').addClass('d-none');
                $('.stopTimer').removeClass('d-none');
            }else{
                $('#startBtn').removeClass('d-none');
                $('.stopTimer').addClass('d-none');
            }
        },
    });
}

// let remaining = duration;
let interval = null;

// Restore from localStorage if exists (per client)
let saved = localStorage.getItem("remainingTime");
if (saved) {
    remaining = parseInt(saved);
}

// Update timer display
function updateDisplay(seconds) {
    
    let hours   = Math.floor(seconds / 3600);
    let minutes = Math.floor((seconds % 3600) / 60);
    let secs    = Math.floor(seconds % 60);

    hours   = hours.toString().padStart(2, '0');
    minutes = minutes.toString().padStart(2, '0');
    secs    = secs.toString().padStart(2, '0');

    document.getElementById("timer").textContent = `${hours}:${minutes}:${secs}`;
}

// Start/resume timer
function startTimer() {
    if (interval) return; // already running

    interval = setInterval(function () {
        if (remaining <= 0) {
            clearInterval(interval);
            interval = null;
            alert("⏰ 4 hours completed!");
            startAudit(1);
            $('.audit-check-list').addClass('d-none');
            return;
        }
        remaining--;
        $('.audit-check-list').removeClass('d-none');
        updateDisplay(remaining);
        localStorage.setItem("remainingTime", remaining); // save progress
    }, 1000);
}

// Pause timer
function stopTimer() {
    clearInterval(interval);
    interval = null;
    localStorage.setItem("remainingTime", remaining);
    $('.audit-check-list').addClass('d-none');
}

// Initial render
updateDisplay(remaining);

document.getElementById("startBtn").addEventListener("click", startTimer);