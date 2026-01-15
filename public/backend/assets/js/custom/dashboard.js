// ------------------------------ Chart Start ------------------------------ //


getDashboardChartData();

let totalRooms = 0;
let availableRooms = 0;
let soldOutRooms = 0;
let monthData = [];
let lastBooking = [];
let lastCancel = [];
let lastDates = [];

function getDashboardChartData(){

  $.ajax({
      url: getDashboardChart,
      method: "GET",
      success: function (response) {
        
        totalRooms = response.roomnum;
        availableRooms = response.available;
        soldOutRooms = response.occupied;
        monthData = response.monthlyRevenue;
        lastBooking = response.lastBooking;
        lastCancel = response.lastCancel;
        lastDates = response.lastDay;

        monthlyReservation();
        lastReservation();
        roomDetail();
      }
  });

}
// Define the product area chart options

function monthlyReservation(){
  
  var optionsProductChart = {
    chart: {
      height: 180,
      type: "area",
      toolbar: {
        show: false,
      },
    },
    stroke: {
      curve: "smooth",
      width: 0,
    },
    series: [
      {
        name: "Revenue",
        data: monthData,
      },
    ],
    fill: {
      colors: [BohoAdminConfig.primary, BohoAdminConfig.secondary],
      type: "gradient",
      gradient: {
        shade: "light",
        type: "vertical",
        shadeIntensity: 0.4,
        inverseColors: false,
        opacityFrom: 0.9,
        opacityTo: 0.8,
        stops: [0, 100],
      },
    },
    dataLabels: {
      enabled: false,
    },
    grid: {
      borderColor: "rgba(196,196,196, 0.3)",
      padding: {
        top: 0,
        right: -120,
        bottom: 10,
      },
    },
    colors: [BohoAdminConfig.primary, BohoAdminConfig.secondary],
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    markers: {
      size: 0,
    },
    xaxis: {
      axisTicks: {
        show: false,
      },
      axisBorder: {
        color: "rgba(196,196,196, 0.3)",
      },
    },
    yaxis: {
      labels: {
        formatter: (val) => val,
         style: {
          fontSize: '14px',
          fontWeight: 'bold',
          colors: ['#222']
      }
      },
     
    },
    tooltip: {
      custom: function ({ series, seriesIndex, dataPointIndex, w }) {
        var data = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
        return `
          <ul class="p-2">
            <li class="text-center"><b>Total Revenue <br></b>${data}</li>
          </ul>`;
      },
    },
  };

  // Render the product area chart
  var chartProduct = new ApexCharts(
    document.querySelector("#revenue"),
    optionsProductChart
  );
  chartProduct.render();
}


// ------------------------------ Chart End ------------------------------ //


// ------------------------------ Reservation Chart Start ------------------------------ //

function lastReservation(){
  
  var options = {
    series: [
      {
        name: "Booked",
        group: "booked",
        data: lastBooking,
      },
      {
        name: "Cancel",
        group: "cancel",
        data: lastCancel,
      },
    ],
    chart: {
      type: "bar",
      height: 250,
      stacked: true,
      toolbar: {
        show: false,
      },
    },
    stroke: {
      width: 1,
      colors: ["#fff"],
    },
    dataLabels: {
      enabled: false,
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "25%",
      },
    },
    xaxis: {
      categories: lastDates,
    },
    fill: {
      opacity: 1,
    },
    colors: ["#b7eed6", "#8ee4bf", "#ccf3e2", "#a3e9cb"],
    yaxis: {
      labels: {
        formatter: (val) => val,
         style: {
          fontSize: '14px',
          fontWeight: 'bold',
          colors: ['#222']
      }
      },
     
    },
    legend: {
    position: "top",
    horizontalAlign: "right",
  },
  };
  
  var chart = new ApexCharts(document.querySelector("#reservation-chart"), options);
  chart.render();

}
// ------------------------------ Reservation Chart End ------------------------------ //

function roomDetail(){

  document.getElementById('availableCount').innerText = availableRooms;
  document.getElementById('soldoutCount').innerText = soldOutRooms;
  
  // Animate progress bars
  document.getElementById('availableBar').style.width = (availableRooms / totalRooms * 100) + '%';
  document.getElementById('soldoutBar').style.width = (soldOutRooms / totalRooms * 100) + '%'; 
}
  // Set counts

  // Room detail in dashboard
  getReservationForDashboard();

  let roomDetailDashboard = [];
  let statusNameColor = [];
  let reservedRoomDetailDashboard = [];
  let categorySet = 'All';
  let typeSet = '';

  function getReservationForDashboard(){

      $.ajax({
          url: reservationViewLayout,
          method: "POST",
          data: { days: 1},
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
              // console.log(data);
              roomDetailDashboard = data.roomDetails;
              statusNameColor = data.statusNameColor;
              $('.filter-parameter').html('');
              let colorArea = `<button class="btn btn-primary ms-2 d-flex justify-content-between" type="button" onclick="roomDetailDesign('')" style="width:200px;"> All </button>`;
              statusNameColor.forEach(reason => {
                  colorArea += `<button class="btn ms-2 text-white d-flex justify-content-between" type="button" onclick="roomDetailDesign('${reason.id}')" style="background-color:${reason.color}; width:200px;"><span> ${reason.name} </span><span class="text-end">${reason.count}</span></button>`;
              });
              $('.filter-parameter').html(colorArea);
              roomDetailDesign();
          }
      });
  }

  function roomDetailDesign(type = ''){
    typeSet = type;
    $('.room_detail_views').html();
    let room_detail = '';
    let room_category_detail = '';
    let class_filter_all = 'btn-outline-primary';
    if(categorySet == 'All'){
      class_filter_all = 'btn-primary';
    }
    
    room_category_detail += `<button class="btn ${class_filter_all} ms-2 filter-category-btn" type="button" onClick="categoryFilter('')"> All </button>`;  
    roomDetailDashboard.forEach(category => {

      $('.filter-category-btn').removeClass('btn-primary');
      let class_filter = 'btn-outline-primary';
      if(category.id == type){
          class_filter = 'btn-primary';
      }

      room_category_detail += `<button class="btn ${class_filter} ms-2 filter-category-btn" type="button" onClick="categoryFilter(${category.id})"> ${category.name} </button>`;

      // let filteredCategory;
      // if (type === '') {
      //     filteredCategory = category;
      // } else if (category.id == type) {
      //     filteredCategory = category;
      // } else {
      //     return; // skip non-selected category
      // }
      // Filter category
        if (categorySet && categorySet !== 'All' && category.id != categorySet) {
            return; 
        }

        // Filter rooms by status
        const filteredRooms = type === '' 
            ? category.rooms 
            : category.rooms.filter(r => r.current_status == type);

      
        if (filteredRooms.length === 0) {
            return; // skip the row
        }


      filteredRooms.forEach(room => {

          let bg = '';
          let clickEvent = '';

          if (room.current_status != '-1') {
              const match = statusNameColor.find(x => x.id == room.current_status);
              if (match) {
                  bg = `color:#fff; background-color:${match.color}`;
                  category.room_reservation_detail.forEach(reser => {
                    console.log(reser);
                    if(reser.room_id == room.id){
                      clickEvent = `onClick="getReservationDetailDashboard('${reser.id}')"`;
                      reservedRoomDetailDashboard.push(reser);
                    }
                  });
              }
          }

          // if(room.current_status != '-1') {
          //   const match = statusNameColor.find(x => x.id == room.current_status);
          //   if (match) {
          //     bg = `color:#fff; background-color:${match.color}`;
          //     hoverClass = 'onhover-dropdown';
          //   }
          // }

          room_detail += `
              <div class="reservation-reserved-item room-reserved"
                  style="${bg}" ${clickEvent}>
                  <h5 class="mb-0 text-center">${room.room_number}</h5>
              </div>`;
      });
    });

    $('.room_detail_views_dashboard').html(room_detail);
    $('.category-filter-list').html(room_category_detail);
  }

  function getReservationDetailDashboard(id){
    console.log(reservedRoomDetailDashboard);
    let room_detail = '';
    $('.detail-reservation-dashboard').empty();
    let count = 0;
    reservedRoomDetailDashboard.forEach(reservation => {
      if(reservation.id == id){
        count++;
        if(count == 1){
        room_detail +=`
            <div class="row mb-3 ">
                <div class="row">
                <div class="title col-md-3 mb-2 fw-bold">Guest Info</div>
                </div>
                <div class="col-md-12">
                    <div class="row custom-border-2-hotlr">
                        <div class="col-md-6">
                            <p class="mb-1">Guest Name: ${reservation.first_name} ${reservation.last_name}</p>
                            <p class="mb-1">Phone No.: ${reservation.mobile}</p>
                        </div>

                        <div class="company-hotlr col-md-6" style="padding-left: 60px;">
                            <p class="mb-1">Company: ${reservation.company_name.substring(0, 20)}</p>
                            <p class="mb-1">GST: ${reservation.company_gst}</p>
                        </div>
                    </div>
                </div>
            </div>`;
        }else{
          room_detail +=`<hr>`;
        }
          room_detail +=`
            <div class="row">
                <div class="col-md-6">
                    <div class="title mb-2 fw-bold">Reservation Details <button class="btn btn-outline-danger py-1 ms-2 filter-category-btn" type="button" onclick="edit_reservation(${reservation.reservation_room_id}, '${reservation.reservation_id}')"> Checkout </button></div>

                    <p class="mb-1">Reservation ID: ${reservation.reservation_id} </p>
                    <p class="mb-1">Room No: ${reservation.room_alloted}</p>
                    <p class="mb-1">Room Type: ${reservation.category}</p>
                    <p class="mb-1">Room Tariff: ${reservation.tariff_cost}</p>
                </div>

                <!-- Divider for large screen -->
                <div class="col-md-1 d-none d-md-flex justify-content-center">
                    <div style="border-right:1px solid #000; height:100%;"></div>
                </div>
                <div class="col-md-5">
                    <div class="title mb-2">Check-In Details</div>

                    <p class="mb-1">Check-in Date: ${reservation.reservation_checkin_date} </p>
                    <p class="mb-1">Room Time: ${reservation.reservation_checkin_time} </p>
                    <p class="mb-1">Tariff Plan: ${reservation.tariff}</p>
                </div>
            </div>`;
      }
    });
    $('#reservationView').modal('show');
    $('.detail-reservation-dashboard').html(room_detail);
  }

  function categoryFilter(name){
    categorySet = name;
    roomDetailDesign(typeSet);
}

function edit_reservation(id, reservationid) {
    let res = 'reservation='+reservationid+'&reservation_room_id='+id;
    let url = '../../reservation/edit-reservation/'+res;
    window.location.href = url;
}