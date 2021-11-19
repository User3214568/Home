$(document).ready(function(){
    $("#upload-input").on('change',function(){
        $("#submit").click();
    });
    $("#upload").click(function(){
        $("#upload-input").click();
    });

   renderChart();

});

function renderChart(){
    var formations = Object.keys(for_eff);
    var [labels,series] = [[],[]];
    formations.forEach(f=>{
        labels.push(f);
        series.push(for_eff[f]);
    });
    console.log(labels,series);
    var options = {
        series: series,
        chart: {
        type: 'donut',
      },
      responsive: [{
        breakpoint: 480,
        options: {
          chart: {
            width: 200
          },
          legend: {
            position: 'bottom'
          }
        }
      }],
      labels : labels
      };

      var chart = new ApexCharts(document.querySelector("#chart"), options);
      chart.render();

}
