var total_vsed = 0;
var total_pai = 0;
$(document).ready(function () {
    var keys = Object.keys(stats);
    var [etudiant, module, prof, formations] = [[], [], [], []];
    keys.forEach(formation => {
        etudiant.push(stats[formation].etudiants);
        module.push(stats[formation].modules);
        prof.push(stats[formation].profs);
        formations.push(formation);
    })
    Apex.colors = [ '#3eb59b' ,'#F44336', '#366ff4'];

    var options = {
        series: [{
            name: 'Etudiants',
            data: etudiant
        }, {
            name: 'Modules',
            data: module
        }, {
            name: 'Professeurs',
            data: prof
        }],
        chart: {
        type: 'bar',
        height: 350,
        stacked: true,
        toolbar: {
          show: true
        },
        zoom: {
          enabled: true
        }
      },
      responsive: [{
        breakpoint: 480,
        options: {
          legend: {
            position: 'bottom',
            offsetX: -10,
            offsetY: 0
          }
        }
      }],
      plotOptions: {
        bar: {
          horizontal: false,
          borderRadius: 10
        },
      },
      xaxis: {
        categories: formations,
      },
      legend: {
        position: 'top',
        offsetY: 10
      },
      fill: {
        opacity: 1
      }
      };

      var chart = new ApexCharts(document.querySelector("#chart1"), options);
      chart.render();

    // chart 2

    var [data,data1] = [[],[]];
    var formations = Object.keys(fin_stats);

    formations.forEach(formation=>{
        total_vsed += fin_stats[formation].total_vers;
        total_pai += fin_stats[formation].paiements;
        data.push({
            x: formation,
            y: fin_stats[formation].vers,
            goals: [
              {
                name: 'Expected',
                value: fin_stats[formation].total_vers,
                strokeWidth: 5,
                strokeColor: '#775DD0'
              }
            ]
        });
        data1.push({
            x: formation,
            y: fin_stats[formation].paiements,
            goals: [
              {
                name: 'Expected',
                value: fin_stats[formation].total_paiements,
                strokeWidth: 5,
                strokeColor: '#775DD0'
              }
            ]
        });
    });


    var options = {
        series: [
        {
          name: 'Actual',
          data: data
        }
      ],
        chart: {
        height: 350,
        type: 'bar'
      },
      plotOptions: {
        bar: {
          horizontal: true,
        }
      },
      colors: ['#00E396'],
      dataLabels: {
        formatter: function(val, opt) {
          const goals =
            opt.w.config.series[opt.seriesIndex].data[opt.dataPointIndex]
              .goals

          if (goals && goals.length) {
            return `${val} / ${goals[0].value}`
          }
          return val
        }
      },
      legend: {
        show: true,
        showForSingleSeries: true,
        customLegendItems: ['Actual', 'Expected'],
        markers: {
          fillColors: ['#00E396', '#775DD0']
        }
      }
      };

      var chart = new ApexCharts(document.querySelector("#chart2"), options);
      chart.render();

    // chart 3

    var options = {
        series: [
        {
          name: 'Actual',
          data: data1
        }
      ],
        chart: {
        height: 350,
        type: 'bar'
      },
      plotOptions: {
        bar: {
          horizontal: true,
        }
      },
      colors: ['#00E396'],
      dataLabels: {
        formatter: function(val, opt) {
          const goals =
            opt.w.config.series[opt.seriesIndex].data[opt.dataPointIndex]
              .goals

          if (goals && goals.length) {
            return `${val} / ${goals[0].value}`
          }
          return val
        }
      },
      legend: {
        show: true,
        showForSingleSeries: true,
        customLegendItems: ['Actual', 'Expected'],
        markers: {
          fillColors: ['#00E396', '#775DD0']
        }
      }
      };

      var chart = new ApexCharts(document.querySelector("#chart3"), options);
      chart.render();

        //chart 3-4
      console.log(fin_stats)
        renderChartRadial("#chart4",total_vsed <= 0 ? 100 :  (total_versments*100/total_vsed).toFixed(2));
        renderChartRadial('#chart5',total_paiements <= 0 ? 100 :  (total_pai*100/total_paiements).toFixed(2));
})

function renderChartRadial(divId,value,label=""){
    var options = {
        series: [value],
        chart: {
        height: 150,
        type: 'radialBar',
        offsetY: -10
      },
      plotOptions: {
        radialBar: {
          startAngle: -135,
          endAngle: 135,
          dataLabels: {
            name: {
              fontSize: '16px',
              color: undefined,
              offsetY: 120
            },
            value: {
              offsetY: 76,
              fontSize: '22px',
              color: undefined,
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
      labels: [label],
      };

      var chart = new ApexCharts(document.querySelector(divId), options);
      chart.render();
}
