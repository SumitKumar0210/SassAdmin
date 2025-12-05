(function ($) {
    "use strict";
    var options = {
        series: [{
            name: 'Average : 26,546 ',
            data: [20, 120, 40, 30, 65, 120, 44],
        }],
        chart: {
            height: 300,
            type: 'radar',
            toolbar: {
                show: false,
            },
        },
        legend: {
            show: true,
        },
        plotOptions: {
            radar: {
                size: 110,
                offsetY: -20,
                polygons: {
                    strokeColors: '#e9e9e9',
                    fill: {
                        colors: [BohoAdminConfig.lightcolor, '#fff']
                    }
                },
                dataLabels: {
                    name: {
                        show: true,
                    }
                },
            }
        },
        title: {
            text: "Average : 26,546",
            align: "center",
            offsetY: 272,
            style: {
                fontSize: '16px',
                fontWeight: '400',
                fontFamily: 'Secular One',
                color: '#1F2F3E'
            },
        },
        labels: ['Average : 26,546 '],
        colors: [BohoAdminConfig.darkcolor],
        markers: {
            size: 5,
            colors: ['#fff'],
            strokeColor: BohoAdminConfig.darkcolor,
            strokeWidth: 3,
        },
        tooltip: {
            custom: function ({ series, seriesIndex, dataPointIndex, w }) {
                var data = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
                return '<ul class="p-2">' +
                    '<li><b>visitors</b>: ' + w.globals.labels[dataPointIndex] + '</li>' +
                    '</ul>';
            }
        },
        xaxis: {
            categories: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
        },
        yaxis: {
            show: false,
        },
        responsive: [
            {
                breakpoint: 1446,
                options: {
                    plotOptions: {
                        radar: {
                            size: 90,
                        }
                    },
                }
            },
            {
                breakpoint: 1334,
                options: {
                    plotOptions: {
                        radar: {
                            size: 70,
                        }
                    },
                }
            },
            {
                breakpoint: 1200,
                options: {
                    plotOptions: {
                        radar: {
                            size: 110,
                        }
                    },
                }
            },
            {
                breakpoint: 405,
                options: {
                    plotOptions: {
                        radar: {
                            size: 90,
                        }
                    },
                }
            },
            {
                breakpoint: 360,
                options: {
                    plotOptions: {
                        radar: {
                            size: 68,
                        }
                    },
                }
            },
        ],
    };
    var chart = new ApexCharts(document.querySelector("#weekly-visitors"), options);
    chart.render();
    // Bubble cahrt
    function generateData(baseval, count, yrange) {
        var i = 0;
        var series = [];
        while (i < count) {
            var y =
                Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;
            var z = Math.floor(Math.random() * (75 - 15 + 1)) + 15;
            series.push([baseval, y, z]);
            baseval += 86400000;
            i++;
        }
        return series;
    }
    var options = {
        chart: {
            height: 400,
            type: "bubble",
            toolbar: {
                show: false,
            },
        },
        dataLabels: {
            enabled: false,
        },
        series: [
            {
                name: "Product1",
                data: generateData(new Date("01 Jan 2023 GMT").getTime(), 20, {
                    min: 10,
                    max: 55,
                }),
            },
            {
                name: "Product2",
                data: generateData(new Date("01 Jan 2023 GMT").getTime(), 20, {
                    min: 10,
                    max: 55,
                }),
            },
            {
                name: "Product3",
                data: generateData(new Date("01 Jan 2023 GMT").getTime(), 20, {
                    min: 10,
                    max: 55,
                }),
            },
            {
                name: "Product4",
                data: generateData(new Date("01 Jan 2023 GMT").getTime(), 20, {
                    min: 10,
                    max: 55,
                }),
            },
        ],
        fill: {
            type: "gradient",
        },
        legend: {
            show: false,
        },
        xaxis: {
            tickAmount: 12,
            type: "datetime",
            labels: {
                rotate: 0,
            },
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return value + "K";
                },
                style: {
                    colors: [BohoAdminConfig.darkcolor],
                    fontFamily: "Secular One",
                },
            },
        },
        theme: {
            palette: "palette2",
        },
        colors: ["#1F2F3E", "#C1E9C1", "#1F2F3E", "#C1E9C1"],
        tooltip: {
            custom: function ({ series, seriesIndex, dataPointIndex, w }) {
                var data = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
                return '<ul class="p-2">' +
                    '<li><b>Order</b>: ' + w.globals.labels[dataPointIndex] + '</li>' +
                    '</ul>';
            }
        }
    };
    var chart = new ApexCharts(document.querySelector(" #salessummary"), options);
    chart.render();
    $(".sellingproduct table").on("click", ".remove", function (event) {
        var ndx = $(this).parent().index() + 1;
        $("tr", event.delegateTarget).remove(":nth-child(" + ndx + ")");
    });
})(jQuery);