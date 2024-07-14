import './bootstrap';
import 'flowbite';
import ApexCharts from 'apexcharts';

function initChart(userId, chartId, apiUrl, seriesName, color) {
  const options = {
    colors: ["#1A56DB", "#FDBA8C"],
    series: [
    {
        name: seriesName,
        // color: "#32E0C4",
        color: color,
        data: []
        // data: [
        //     { x: "Mon", y: 231 },
        //     { x: "Tue", y: 122 },
        //     { x: "Wed", y: 63 },
        //     { x: "Thu", y: 65 },
        //     { x: "Fri", y: 122 },
        //     { x: "Sat", y: 323 },
        //     { x: "Sun", y: 111 },
        // ],
    },
    // {
    //     name: "Social media",
    //     color: "#8F9B9B",
    //     data: [
    //         { x: "Mon", y: 232 },
    //         { x: "Tue", y: 113 },
    //         { x: "Wed", y: 341 },
    //         { x: "Thu", y: 224 },
    //         { x: "Fri", y: 522 },
    //         { x: "Sat", y: 411 },
    //         { x: "Sun", y: 243 },
    //     ],
    // },
    ],
    chart: {
        type: "bar",
        height: "160px",
        fontFamily: "Inter, sans-serif",
        toolbar: {
            show: false,
        },
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: "70%",
            borderRadiusApplication: "end",
            borderRadius: 8,
        },
    },
    tooltip: {
        shared: true,
        intersect: false,
        style: {
            fontFamily: "Inter, sans-serif",
        },
    },
    states: {
        hover: {
            filter: {
                type: "darken",
                value: 1,
            },
        },
    },
    stroke: {
        show: true,
        width: 0,
        colors: ["transparent"],
    },
    grid: {
        show: false,
        strokeDashArray: 4,
        padding: {
            left: 2,
            right: 2,
            // top: -14
            top: -30,
            bottom: -12
        },
    },
    dataLabels: {
        enabled: false,
    },
    legend: {
        show: false,
    },
    xaxis: {
        floating: false,
        labels: {
            show: true,
            style: {
                fontFamily: "Inter, sans-serif",
                cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
            }
        },
        axisBorder: {
            show: false,
        },
        axisTicks: {
            show: false,
        },
    },
    yaxis: {
        show: false,
    },
    fill: {
        opacity: 1,
    },
  }

  const chart = new ApexCharts(document.getElementById(chartId), options);
    chart.render();

    fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
        chart.updateSeries([{
            data: data
        }]);
        chart.updateOptions({
            xaxis: {
                categories: data.map(entry => entry.x)
            }
        });
    });

}

function initLineChart(userId, chartId, apiUrl, seriesName, color) {
  const vsOptions = {
    chart: {
      height: "130px",
      maxWidth: "100%",
      type: "area",
      fontFamily: "Inter, sans-serif",
      dropShadow: {
        enabled: false,
      },
      toolbar: {
        show: false,
      },
    },
    tooltip: {
      enabled: true,
      x: {
        show: false,
      },
    },
    fill: {
      type: "gradient",
      gradient: {
        opacityFrom: 0.55,
        opacityTo: 0,
        shade: "#32E0C4",
        gradientToColors: ["#32E0C4"],
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      width: 6,
    },
    grid: {
      show: false,
      strokeDashArray: 4,
      padding: {
        left: 2,
        right: 2,
        top: 0
      },
    },
    series: [
      {
        name: seriesName,
        data: [],
        color: color,
      },
    ],
    xaxis: {
      categories: ['01 February', '02 February', '03 February', '04 February', '05 February', '06 February', '07 February'],
      labels: {
        show: false,
      },
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
    yaxis: {
      show: false,
    },
  }

  const chart = new ApexCharts(document.getElementById(chartId), vsOptions);
    chart.render();

    fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
        chart.updateSeries([{
            data: data
        }]);
        chart.updateOptions({
            xaxis: {
                categories: data.map(entry => entry.x)
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
  const userIdElement = document.getElementById('user-id');
  if (userIdElement) {
      const userId = userIdElement.value;
      initChart(userId, "column-chart", `/glucose-data/${userId}`, "Glucose", "#32E0C4");
      initChart(userId, "cholesterol-chart", `/cholesterol-data/${userId}`, "Cholesterol", "#32E0C4");
      initChart(userId, "uric-acid-chart", `/uric-acid-data/${userId}`, "Uric Acid", "#32E0C4");
      initLineChart(userId, "vs-chart", `/heart-rate-data/${userId}`, "Heart Rate", "#32E0C4");
  }
});



// if(document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
            
// }

// if(document.getElementById("cholesterol-chart") && typeof ApexCharts !== 'undefined') {
//   const chart = new ApexCharts(document.getElementById("cholesterol-chart"), options);
//   chart.render();
// }

// if(document.getElementById("uric-acid-chart") && typeof ApexCharts !== 'undefined') {
//   const chart = new ApexCharts(document.getElementById("uric-acid-chart"), options);
//   chart.render();
// }


  
  // if (document.getElementById("area-chart") && typeof ApexCharts !== 'undefined') {
  //   const chart = new ApexCharts(document.getElementById("area-chart"), vsOptions);
  //   chart.render();
  // }
  