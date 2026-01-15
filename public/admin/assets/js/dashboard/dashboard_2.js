(function ($) {
  "use strict";
  const Option = {
    series: [65],
    chart: {
      type: 'radialBar',
      height: 280,
      offsetY: -10,
      sparkline: {
        enabled: true,
      },
    },
    plotOptions: {
      radialBar: {
        startAngle: -120,
        endAngle: 180,
        offsetY: 0,
        hollow: {
          size: '55%',
        },
        track: {
          background: BohoAdminConfig.lightcolor,
          strokeWidth: '90%',
          startAngle: 0,
          endAngle: 360,
        },
        dataLabels: {
          enabled: true,
          textAnchor: 'middle',
          name: {
            show: false,
          },
          value: {
            fontSize: '30px',
            fontFamily: "'Secular One', sans-serif",
            fontWeight: 600,
          },
        },
      },
    },
    colors: [BohoAdminConfig.darkcolor],
    grid: {
      padding: {
        top: 0,
        bottom: 0,
        left: 0,
        right: 0,
      },
    },
    stroke: {
      lineCap: 'round',
    },
    responsive: [
      {
        breakpoint: 1700,
        options: {
          chart: {
            height: 280,
          },
          plotOptions: {
            radialBar: {
              hollow: {
                size: '48%',
              },
              dataLabels: {
                value: {
                  fontSize: '14px',
                },
              },
            },
          },
        },
      },
      {
        breakpoint: 1580,
        options: {
          chart: {
            height: 250,
          },
          plotOptions: {
            radialBar: {
              hollow: {
                size: '48%',
              },
              dataLabels: {
                value: {
                  fontSize: '14px',
                },
              },
            },
          },
        },
      },
      {
        breakpoint: 1400,
        options: {
          chart: {
            height: 230,
          },
          plotOptions: {
            radialBar: {
              hollow: {
                size: '60%',
              },
              dataLabels: {
                value: {
                  fontSize: '18px',
                },
              },
            },
          },
        },
      },
      {
        breakpoint: 876,
        options: {
          chart: {
            height: 230,
          },
          plotOptions: {
            radialBar: {
              hollow: {
                size: '60%',
              },
              dataLabels: {
                value: {
                  fontSize: '18px',
                },
              },
            },
          },
        },
      },
      {
        breakpoint: 376,
        options: {
          chart: {
            height: 260,
          },
          plotOptions: {
            radialBar: {
              hollow: {
                size: '60%',
              },
              dataLabels: {
                value: {
                  fontSize: '18px',
                },
              },
            },
          },
        },
      },
    ],
  };
  var chart = new ApexCharts(document.querySelector('#earning'), Option);
  chart.render();
  //  Sales Summary chart start
  var optionssalessummary = {
    series: [
      {
        name: "Activity",
        data: [4, 5, 5.7, 3, 5, 5.4, 5.8, 4, 4.5, 3, 5],
      },
    ],
    chart: {
      height: 320,
      type: "bar",
      toolbar: {
        show: false,
      },
    },
    plotOptions: {
      bar: {
        distributed: true,
        borderRadius: 3,
        columnWidth: "30%",
      },
    },
    dataLabels: {
      enabled: false,
    },
    xaxis: {
      categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov"],
      labels: {
        style: {
          fontSize: "12px",
          fontFamily: "Rubik, sans-serif",
          colors: "var(--chart-text-color)",
        },
      },
      axisBorder: {
        show: false,
      },
      axisTicks: {
        borderType: 'solid',
      },
      tooltip: {
        enabled: false,
      },
    },
    legend: {
      show: false,
    },
    yaxis: {
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      labels: {
        formatter: function (val) {
          return val + "0" + "k";
        },
        style: {
          fontSize: "14px",
          fontFamily: "Secular One",
          colors: "$black",
        },
      },
    },
    tooltip: {
      custom: function ({ series, seriesIndex, dataPointIndex, w }) {
        var data = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
        return '<ul class="p-2">' +
          '<li><b>Oreder</b>: ' + w.globals.labels[dataPointIndex] + '</li>' +
          '</ul>';
      }
    },
    grid: {
      borderColor: "var(--chart-dashed-border)",
    },
    colors: [BohoAdminConfig.lightcolor, BohoAdminConfig.lightcolor, BohoAdminConfig.lightcolor, BohoAdminConfig.lightcolor, BohoAdminConfig.lightcolor, BohoAdminConfig.lightcolor, BohoAdminConfig.darkcolor, BohoAdminConfig.lightcolor, BohoAdminConfig.lightcolor, BohoAdminConfig.lightcolor, BohoAdminConfig.lightcolor],
  };
  var chartasalessummary = new ApexCharts(
    document.querySelector("#salessummary"),
    optionssalessummary
  );
  chartasalessummary.render();
  //  Traffic chart start
  var options = {
    series: [
      {
        type: "area",
        data: [50, 70, 65, 80, 40, 50, 48, 60, 48, 50, 70, 80, 75, 50, 60, 50, 50, 10, 30, 20, 70, 65, 95, 45, 70, 50, 80, 75, 90, 60, 65, 50, 70, 65, 50, 55, 50],
      },
    ],
    chart: {
      height: 235,
      type: "area",
      toolbar: {
        show: false,
      },
    },
    stroke: {
      curve: "smooth",
      width: [3, 1],
      dashArray: [0, 5],
    },
    annotations: {
      points: [{
        x: 347,
        y: 65,
        marker: {
          size: 8,
          fillColor: BohoAdminConfig.darkcolor,
          strokeColor: '#ffffff',
          strokeWidth: 5,
          radius: 2,
        },
      }]
    },
    fill: {
      type: "gradient",
      gradient: {
        shadeIntensity: 1,
        opacityFrom: 0.5,
        opacityTo: 0.9,
        stops: [0, 100],
      },
    },
    responsive: [
      {
        breakpoint: 1470,
        options: {
          chart: {
            height: 200,
          },
        },
      },
      {
        breakpoint: 992,
        options: {
          chart: {
            height: 200,
          },
        },
      },
    ],
    yaxis: {
      show: false,
    },
    grid: {
      show: false,
    },
    xaxis: {
      show: false,
      labels: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      crosshairs: {
        show: true,
        width: 1,
        position: "back",
        stroke: {
          color: BohoAdminConfig.darkcolor,
          width: 1,
          dashArray: 5,
        },
      },
    },
    tooltip: {
      marker: {
        show: false,
      },
      fixed: {
        enabled: false,
        position: "bottomRight",
        offsetX: 0,
        offsetY: 0,
      },
    },
    dataLabels: {
      enabled: false,
    },
    legend: {
      show: false,
    },
    tooltip: {
      custom: function ({ series, seriesIndex, dataPointIndex, w }) {
        var data = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
        return '<ul class="p-2">' +
          '<li><b>Price</b>: ' + w.globals.labels[dataPointIndex] + '</li>' +
          '</ul>';
      }
    },
    colors: [BohoAdminConfig.darkcolor],
  };
  var chart = new ApexCharts(document.querySelector("#traffic"), options);
  chart.render();
  // delete js
  $(".userinformation table").on("click", ".remove", function (event) {
    var ndx = $(this).parent().index() + 1;
    $("tr", event.delegateTarget).remove(":nth-child(" + ndx + ")");
  });
})(jQuery);