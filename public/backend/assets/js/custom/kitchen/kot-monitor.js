function markDelivered(id){
    Swal.fire({
    text: "Mark this order as delivered?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Yes, do it!"
    }).then((result) => { 
        if (result.isConfirmed) {
          $.ajax({
                url: markKotDelivered,
                type: "POST",
                data: {
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({title: "Delivered!",
                          icon: "success"
                        });
                      loadKotMonitor('Pending');
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

let kot_item_data = [];

function loadKotMonitor(type = '',button = '') {
  if(type == ''){
    $('.kot-status').html('All KOT');
  }else if(type == 'Delivered'){
    $('.kot-status').html('Previous KOT');
  }else {
    $('.kot-status').html('Running KOT');
  }
  $(".loadKot").css({ "background-color": "","color": ""});

  if (button === '') {
    $(".loadKot.btn-outline-secondary").css({
      "background-color": "red",
      "color": "white"
    });
  } else {
    let $btn = $(button);
    const colorMap = {
      "btn-outline-primary": "blue",
      "btn-outline-success": "green"
    };
    $.each(colorMap, function(className, bgColor) {
      if ($btn.hasClass(className)) {
        $(".loadKot." + className).css({
          "background-color": bgColor,
          "color": "white"
        });
      }
    });
  }
  $.ajax({
    url: getKotDetails,
    method: "POST",
    success: function (response) {
      let kots = response.kots;
      let kot_items = response.kot_items;
      kot_item_data.push(kots);
      $('.kot-monitor-data').empty(); // Clear previous content
      if(type != ''){
        kots = kots.filter(item => item.order_status == type);
      }
      kots.forEach(kot_data => {  
        let d2Str = kot_data.order_time;
        let d2Parts = d2Str.split(" ");
        let content = `
          <div class="col-md-3 col-sm-12 mb-3 d-flex">
            <div class="kitchen-kot-item p-0 border rounded-3 w-100 h-100">
              <div class="kitchen-kot-item-header ${kot_data.order_status == 'Pending' ? 'running':''} p-3 border-bottom rounded position-relative">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                  <div>
                    <div class="d-flex align-items-center">
                      <p class="mb-0 item-title me-1">KOT ID:</p>
                      <p class="mb-0">${kot_data.kot_id}</p>
                    </div>
                    <div class="d-flex align-items-center ${kot_data.contact_person_name == null ? 'd-none':''}">
                      <p class="mb-0 item-title me-1">STW Name:</p>
                      <p class="mb-0">${kot_data.contact_person_name}</p>
                    </div>
                    <div class="d-flex align-items-center">
                      <p class="mb-0 item-title me-1">Type:</p>
                      <p class="mb-0">${kot_data.type}</p>
                    </div>
                    <div class="d-flex align-items-center">
                      <p class="mb-0 item-title me-1">Table/Room No.:</p>
                      <p class="mb-0">${kot_data.type_number}</p>
                    </div>
                    <div class="d-flex align-items-center">
                      <p class="mb-0 item-title me-1">Date & Time:</p>
                      <p class="mb-0">${d2Parts[0].split("-").reverse().join("-") + " " + d2Parts[1]}</p>
                    </div>
                  </div>
                  <div class="kot-check-icon position-absolute top-0 end-0 m-3 ${kot_data.order_status == 'Delivered' ? 'd-none':''}" onclick="markDelivered(${kot_data.id})">
                    <div class="bg-success text-white rounded-circle d-flex justify-content-center align-items-center">
                      <i class="ri-check-fill"></i>
                    </div>
                  </div>
                </div>
              </div>
              <div class="kitchen-kot-item-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                  <p class="mb-0"><strong>Description</strong></p>
                  <p class="mb-0"><strong>Qty</strong></p>
                </div>`;

        // Filter kot_items for current kot_id
        let itemsForKot = kot_items.filter(item => item.kot_id == kot_data.id);

        itemsForKot.forEach(item => {
          content += `
            <div class="d-flex align-items-center justify-content-between">
              <p class="mb-0">${item.item_name}</p>
              <p class="mb-0">${item.qty}</p>
            </div>`;
        });

        content += `
              </div>
            </div>
          </div>`;

        $('.kot-monitor-data').append(content);
      });
    }
  });
}

loadKotMonitor('Pending');