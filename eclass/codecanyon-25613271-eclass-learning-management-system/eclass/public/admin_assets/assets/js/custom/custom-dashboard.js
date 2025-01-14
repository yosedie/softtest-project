/*
----------------------------------------------
    : Custom - Dashboard CRM js :
----------------------------------------------
*/
"use strict";
$(function() {   
    
    /* -----  Apex Area1 Chart ----- */
    
    try{
         var options = {
        chart: {
            type:"area",
            height: 50,
            sparkline: {
                enabled: true
            }
        },
        stroke: {
            curve: "straight",
            width: 2
        },
        fill: {
            opacity: .05
        },
        series:[ {
            data:user
        }
        ],
        yaxis: {
            min: 0
        },
        colors:["#506fe4"],
        grid: {
            row: {
                colors: ['transparent', 'transparent'], opacity: .2
            },
            borderColor: 'transparent'
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        }
    }
    var chart = new ApexCharts(
        document.querySelector("#apex-area1-chart"),
        options
    );
    chart.render();
}catch(err){

}

    /* -----  Apex Area2 Chart ----- */
    
    try{
        var options = {
        chart: {
            type:"area",
            height: 50,
            sparkline: {
                enabled: true
            }
        },
        stroke: {
            curve: "straight",
            width: 2
        },
        fill: {
            opacity: .05
        },
        series:[ {
            data:course
        }
        ],
        yaxis: {
            min: 0
        },
        colors:["#43d187"],
        grid: {
            row: {
                colors: ['transparent', 'transparent'], opacity: .2
            },
            borderColor: 'transparent'
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        }
    }
    var chart = new ApexCharts(
        document.querySelector("#apex-area2-chart"),
        options
    );
    chart.render();
}catch(err){

}

    /* -----  Apex Area3 Chart ----- */
    try{
        var options = {
        chart: {
            type:"area",
            height: 50,
            sparkline: {
                enabled: true
            }
        },
        stroke: {
            curve: "straight",
            width: 2
        },
        fill: {
            opacity: .05
        },
        series:[ {
            data:category
        }
        ],
        yaxis: {
            min: 0
        },
        colors:["#96a3b6"],
        grid: {
            row: {
                colors: ['transparent', 'transparent'], opacity: .2
            },
            borderColor: 'transparent'
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        }
    }
    var chart = new ApexCharts(
        document.querySelector("#apex-area3-chart"),
        options
    );
    chart.render();
}catch(err){

}
  /* -----  Apex Area4 Chart ----- */
    
    try{
        var options = {
    chart: {
        type:"area",
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: "straight",
        width: 2
    },
    fill: {
        opacity: .05
    },
    series:[ {
        data:coupon
    }
    ],
    yaxis: {
        min: 0
    },
    colors:["#506fe4"],
    grid: {
        row: {
            colors: ['transparent', 'transparent'], opacity: .2
        },
        borderColor: 'transparent'
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}
var chart = new ApexCharts(
    document.querySelector("#apex-area4-chart"),
    options
);
chart.render();
}catch(err){

}

/* -----  Apex Area5 Chart ----- */
    
    try{
        var options = {
    chart: {
        type:"area",
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: "straight",
        width: 2
    },
    fill: {
        opacity: .05
    },
    series:[ {
        data:zoom
    }
    ],
    yaxis: {
        min: 0
    },
    colors:["#43d187"],
    grid: {
        row: {
            colors: ['transparent', 'transparent'], opacity: .2
        },
        borderColor: 'transparent'
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}
var chart = new ApexCharts(
    document.querySelector("#apex-area5-chart"),
    options
);
chart.render();
}catch(err){

}

/* -----  Apex Area6 Chart ----- */
    try{
        var options = {
    chart: {
        type:"area",
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: "straight",
        width: 2
    },
    fill: {
        opacity: .05
    },
    series:[ {
        data:bbl
    }
    ],
    yaxis: {
        min: 0
    },
    colors:["#96a3b6"],
    grid: {
        row: {
            colors: ['transparent', 'transparent'], opacity: .2
        },
        borderColor: 'transparent'
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}
var chart = new ApexCharts(
    document.querySelector("#apex-area6-chart"),
    options
);
chart.render();
}catch(err){

}
/* -----  Apex Area7 Chart ----- */
    
    try{
        var options = {
    chart: {
        type:"area",
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: "straight",
        width: 2
    },
    fill: {
        opacity: .05
    },
    series:[ {
        data:jitsi
    }
    ],
    yaxis: {
        min: 0
    },
    colors:["#506fe4"],
    grid: {
        row: {
            colors: ['transparent', 'transparent'], opacity: .2
        },
        borderColor: 'transparent'
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}
var chart = new ApexCharts(
    document.querySelector("#apex-area7-chart"),
    options
);
chart.render();
}catch(err){

}

/* -----  Apex Area8 Chart ----- */
    
    try{
        var options = {
    chart: {
        type:"area",
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: "straight",
        width: 2
    },
    fill: {
        opacity: .05
    },
    series:[ {
        data:googlemeet
    }
    ],
    yaxis: {
        min: 0
    },
    colors:["#43d187"],
    grid: {
        row: {
            colors: ['transparent', 'transparent'], opacity: .2
        },
        borderColor: 'transparent'
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}
var chart = new ApexCharts(
    document.querySelector("#apex-area8-chart"),
    options
);
chart.render();
}catch(err){

}

/* -----  Apex Area9 Chart ----- */
    try{
        var options = {
    chart: {
        type:"area",
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: "straight",
        width: 2
    },
    fill: {
        opacity: .05
    },
    series:[ {
        data:faq
    }
    ],
    yaxis: {
        min: 0
    },
    colors:["#96a3b6"],
    grid: {
        row: {
            colors: ['transparent', 'transparent'], opacity: .2
        },
        borderColor: 'transparent'
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}
var chart = new ApexCharts(
    document.querySelector("#apex-area9-chart"),
    options
);
chart.render();
}catch(err){
    
}
/* -----  Apex Area10 Chart ----- */

try{
var options = {
    chart: {
        type:"area",
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: "straight",
        width: 2
    },
    fill: {
        opacity: .05
    },
    series:[ {
        data:page
    }
    ],
    yaxis: {
        min: 0
    },
    colors:["#506fe4"],
    grid: {
        row: {
            colors: ['transparent', 'transparent'], opacity: .2
        },
        borderColor: 'transparent'
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}
var chart = new ApexCharts(
    document.querySelector("#apex-area10-chart"),
    options
);
chart.render();

}catch(err){
    
}

/* -----  Apex Area11 Chart ----- */

try{
var options = {
    chart: {
        type:"area",
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: "straight",
        width: 2
    },
    fill: {
        opacity: .05
    },
    series:[ {
        data:blog
    }
    ],
    yaxis: {
        min: 0
    },
    colors:["#43d187"],
    grid: {
        row: {
            colors: ['transparent', 'transparent'], opacity: .2
        },
        borderColor: 'transparent'
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}
var chart = new ApexCharts(
    document.querySelector("#apex-area11-chart"),
    options
);
chart.render();

}catch(err){
    
}

/* -----  Apex Area12 Chart ----- */

try{
var options = {
    chart: {
        type:"area",
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: "straight",
        width: 2
    },
    fill: {
        opacity: .05
    },
    series:[ {
        data:testimonial
    }
    ],
    yaxis: {
        min: 0
    },
    colors:["#96a3b6"],
    grid: {
        row: {
            colors: ['transparent', 'transparent'], opacity: .2
        },
        borderColor: 'transparent'
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}
var chart = new ApexCharts(
    document.querySelector("#apex-area12-chart"),
    options
);
chart.render();

}catch(err){
    
}
/* -----  Apex Area13 Chart ----- */

try{
var options = {
    chart: {
        type:"area",
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: "straight",
        width: 2
    },
    fill: {
        opacity: .05
    },
    series:[ {
        data:instructor
    }
    ],
    yaxis: {
        min: 0
    },
    colors:["#506fe4"],
    grid: {
        row: {
            colors: ['transparent', 'transparent'], opacity: .2
        },
        borderColor: 'transparent'
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}
var chart = new ApexCharts(
    document.querySelector("#apex-area13-chart"),
    options
);
chart.render();

}catch(err){
    
}

/* -----  Apex Area14 Chart ----- */
try{
var options = {
    chart: {
        type:"area",
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: "straight",
        width: 2
    },
    fill: {
        opacity: .05
    },
    series:[ {
        data:order
    }
    ],
    yaxis: {
        min: 0
    },
    colors:["#43d187"],
    grid: {
        row: {
            colors: ['transparent', 'transparent'], opacity: .2
        },
        borderColor: 'transparent'
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}
var chart = new ApexCharts(
    document.querySelector("#apex-area14-chart"),
    options
);
chart.render();

}catch(err){
    
}

/* -----  Apex Area15 Chart ----- */
try{
var options = {
    chart: {
        type:"area",
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: "straight",
        width: 2
    },
    fill: {
        opacity: .05
    },
    series:[ {
        data:refund
    }
    ],
    yaxis: {
        min: 0
    },
    colors:["#96a3b6"],
    grid: {
        row: {
            colors: ['transparent', 'transparent'], opacity: .2
        },
        borderColor: 'transparent'
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}
var chart = new ApexCharts(
    document.querySelector("#apex-area15-chart"),
    options
);
chart.render();

}catch(err){
    
}
 /* -----  Apex Area16 Chart ----- */
 try{
 var options = {
    chart: {
        type:"area",
        height: 50,
        sparkline: {
            enabled: true
        }
    },
    stroke: {
        curve: "straight",
        width: 2
    },
    fill: {
        opacity: .05
    },
    series:[ {
        data:follower
    }
    ],
    yaxis: {
        min: 0
    },
    colors:["#506fe4"],
    grid: {
        row: {
            colors: ['transparent', 'transparent'], opacity: .2
        },
        borderColor: 'transparent'
    },
    tooltip: {
        x: {
            format: 'dd/MM/yy HH:mm'
        },
    }
}
var chart = new ApexCharts(
    document.querySelector("#apex-area16-chart"),
    options
);
chart.render();

}catch(err){
    
}

    /* -- Apex Bar Chart -- */
    try{
    var options = {
      series: [{
      name: 'Servings',
      data: [44, 55, 41, 67, 22, 43, 21, 33, 45, 31, 87, 65]
    }],
      annotations: {
      points: [{
        x: 'Bananas',
        seriesIndex: 0,
        label: {
          borderColor: '#506fe4',
          offsetY: 0,
          style: {
            color: '#fff',
            background: '#506fe4',
          },
          text: 'Bananas are good',
        }
      }]
    },
    chart: {
      height: 285,
      type: 'bar',
      toolbar: {
        show: false
      }
    },
    plotOptions: {
      bar: {
        columnWidth: '50%',
        endingShape: 'rounded'  
      }
    },
    colors: ['#506fe4'],
    dataLabels: {
      enabled: false
    },
    stroke: {
      width: 2
    },    
    grid: {
      row: {
        colors: ['#fff', '#fff']
      }
    },
    xaxis: {
      labels: {
        rotate: -45
      },
      categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
      tickPlacement: 'on'
    },
    yaxis: {
      title: {
        text: 'Servings',
      },
    },
    fill: {
      type: 'gradient',
      gradient: {
        shade: 'light',
        type: "horizontal",
        shadeIntensity: 0.25,
        gradientToColors: undefined,
        inverseColors: true,
        opacityFrom: 0.85,
        opacityTo: 0.85,
        stops: [50, 0, 100]
      },
    }
    };

    var chart = new ApexCharts(document.querySelector("#apex-bar-chart"), options);
    chart.render();

    }catch(err){
    
}

    /* ----- Apex Operation Status1 Chart ----- */
    try{
    var options = {
        chart: {
            height: 260,
            type: 'radialBar',
            offsetY: -10
        },
        plotOptions: {
            radialBar: {
                startAngle: -135,
                endAngle: 135,
                dataLabels: {
                    name: {
                        fontSize: '18px',
                        fontFamily: 'Mukta Vaani',
                        color: '#8A98AC',
                        offsetY: 120
                    },
                    value: {
                        offsetY: 76,
                        fontSize: '24px',
                        fontFamily: 'Mukta Vaani',
                        color: '#141d46',
                        formatter: function (val) {
                            return val + "%";
                        }
                    }
                }
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                shadeIntensity: 0.15,
                inverseColors: false,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 50, 65, 91]
            },
        },
        stroke: {
            dashArray: 4
        },
        colors:["#506fe4"],
        series: [65],
        labels: ['Completed'],        
    }
    var chart = new ApexCharts(
        document.querySelector("#apex-operation-status1-chart"),
        options
    );        
    chart.render();

    }catch(err){
    
}

    /* ----- Apex Operation Status2 Chart ----- */
    try{
    var options = {
        chart: {
            height: 260,
            type: 'radialBar',
            offsetY: -10
        },
        plotOptions: {
            radialBar: {
                startAngle: -135,
                endAngle: 135,
                dataLabels: {
                    name: {
                        fontSize: '18px',
                        fontFamily: 'Mukta Vaani',
                        color: '#8A98AC',
                        offsetY: 120
                    },
                    value: {
                        offsetY: 76,
                        fontSize: '24px',
                        fontFamily: 'Mukta Vaani',
                        color: '#141d46',
                        formatter: function (val) {
                            return val + "%";
                        }
                    }
                }
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                shadeIntensity: 0.15,
                inverseColors: false,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 50, 65, 91]
            },
        },
        stroke: {
            dashArray: 4
        },
        colors:["#506fe4"],
        series: [85],
        labels: ['Completed'],        
    }
    var chart = new ApexCharts(
        document.querySelector("#apex-operation-status2-chart"),
        options
    );        
    chart.render();

    }catch(err){
    
}

    /* ----- Apex Operation Status3 Chart ----- */
    try{
    var options = {
        chart: {
            height: 260,
            type: 'radialBar',
            offsetY: -10
        },
        plotOptions: {
            radialBar: {
                startAngle: -135,
                endAngle: 135,
                dataLabels: {
                    name: {
                        fontSize: '18px',
                        fontFamily: 'Mukta Vaani',
                        color: '#8A98AC',
                        offsetY: 120
                    },
                    value: {
                        offsetY: 76,
                        fontSize: '24px',
                        fontFamily: 'Mukta Vaani',
                        color: '#141d46',
                        formatter: function (val) {
                            return val + "%";
                        }
                    }
                }
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                shadeIntensity: 0.15,
                inverseColors: false,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 50, 65, 91]
            },
        },
        stroke: {
            dashArray: 4
        },
        colors:["#506fe4"],
        series: [50],
        labels: ['Completed'],        
    }
    var chart = new ApexCharts(
        document.querySelector("#apex-operation-status3-chart"),
        options
    );        
    chart.render();

    }catch(err){
    
}

    /* ----- Apex Operation Status4 Chart ----- */
    try{
    var options = {
        chart: {
            height: 260,
            type: 'radialBar',
            offsetY: -10
        },
        plotOptions: {
            radialBar: {
                startAngle: -135,
                endAngle: 135,
                dataLabels: {
                    name: {
                        fontSize: '18px',
                        fontFamily: 'Mukta Vaani',
                        color: '#8A98AC',
                        offsetY: 120
                    },
                    value: {
                        offsetY: 76,
                        fontSize: '24px',
                        fontFamily: 'Mukta Vaani',
                        color: '#141d46',
                        formatter: function (val) {
                            return val + "%";
                        }
                    }
                }
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                shadeIntensity: 0.15,
                inverseColors: false,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [0, 50, 65, 91]
            },
        },
        stroke: {
            dashArray: 4
        },
        colors:["#506fe4"],
        series: [35],
        labels: ['Completed'],        
    }
    var chart = new ApexCharts(
        document.querySelector("#apex-operation-status4-chart"),
        options
    );        
    chart.render();

    }catch(err){
    
}

    /* -- User Slider -- */
    $('.user-slider').slick({
        arrows: true,
        dots: false,
        infinite: true,
        adaptiveHeight: true,
        rtl : rtl,
        slidesToShow: 1,
        slidesToScroll: 1,
        prevArrow: '<i class="feather icon-arrow-left"></i>',
        nextArrow: '<i class="feather icon-arrow-right"></i>'
    });
    

});