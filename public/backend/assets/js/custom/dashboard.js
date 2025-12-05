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