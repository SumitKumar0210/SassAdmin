(function ($) {
  "use strict";

  // column chart
  var optionscolumnchart = {
    series: [
      {
        name: "Profit",
        data: [100, 50, 25, 50, 30, 50, 70],
      },
      // {
      //   name: "Revenue",
      //   data: [70, 20, 55, 45, 35, 110, 85],
      // },
      // {
      //   name: "Cash Flow",
      //   data: [85, 55, 100, 35, 90, 60, 80],
      // },
    ],
    chart: {
      type: "bar",
      height: 380,
      toolbar: {
        show: false,
      },
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "30%",
        endingShape: "rounded",
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      show: true,
      width: 1,
      colors: ["transparent"],
      curve: "smooth",
      lineCap: "butt",
    },
    xaxis: {
      categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
      floating: false,
      axisTicks: {
        show: false,
      },
      axisBorder: {
        color: "#C4C4C4",
      },
    },
    yaxis: {
      title: {
        text: "Items Qty",
        style: {
          fontSize: "14px",
          fontFamily: "Roboto, sans-serif",
          fontWeight: 500,
        },
      },
    },
    colors: [BohoAdminConfig.primary, BohoAdminConfig.secondary, "#4AAD8A"],
    fill: {
      type: "gradient",
      gradient: {
        shade: "light",
        type: "vertical",
        shadeIntensity: 0.1,
        inverseColors: false,
        opacityFrom: 1,
        opacityTo: 0.9,
        stops: [0, 100],
      },
    },
    tooltip: {
      custom: function ({ series, seriesIndex, dataPointIndex, w }) {
        var data = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
        return '<ul class="p-2">' +
          '<li><b>Price</b>: ' + w.globals.labels[dataPointIndex] + '</li>' +
          '</ul>';
      }
    },
    responsive: [
      {
        breakpoint: 576,
        options: {
          chart: {
            height: 200,
          }
        }
      }
    ]
  };
  var chartcolumnchart = new ApexCharts(
    document.querySelector("#chart-widget4"),
    optionscolumnchart
  );
  chartcolumnchart.render();

})(jQuery);