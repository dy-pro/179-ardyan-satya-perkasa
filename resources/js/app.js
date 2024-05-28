import ApexCharts from 'apexcharts';
import 'flowbite';
import './bootstrap';



const options = {
    colors: ["#1A56DB", "#FDBA8C"],
    series: [
    {
        name: "Glucose",
        color: "#32E0C4",
        data: [
            { x: "Mon", y: 231 },
            { x: "Tue", y: 122 },
            { x: "Wed", y: 63 },
            { x: "Thu", y: 1000 },
            { x: "Fri", y: 122 },
            { x: "Sat", y: 323 },
            { x: "Sun", y: 111 },
        ],
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

if(document.getElementById("column-chart") && typeof ApexCharts !== 'undefined') {
    const chart = new ApexCharts(document.getElementById("column-chart"), options);
    chart.render();
}

if(document.getElementById("cholesterol-chart") && typeof ApexCharts !== 'undefined') {
    const chart = new ApexCharts(document.getElementById("cholesterol-chart"), options);
    chart.render();
}

if(document.getElementById("uric-acid-chart") && typeof ApexCharts !== 'undefined') {
    const chart = new ApexCharts(document.getElementById("uric-acid-chart"), options);
    chart.render();
}
