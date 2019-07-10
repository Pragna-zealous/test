$(document).ready(function(){
// Build the chart
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    exporting: {
      buttons: {
          contextButton: {
              enabled: false
          }
      }
  },
  credits: {
    enabled: false
},
    title: {
        text: ''
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: false
            },
            showInLegend: true,
            dataLabels: {
              enabled: true,
              style: {
                fontWeight: 'bold'
            },
              format: '{point.percentage:.1f} %',
              distance: -50,
              
          }
        }
    },

    colors: ['#03affb', '#e2e2e2', '#f0f0f0'],
    
    series: [{
      showInLegend: false,
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: 'Chrome',
            y: 84,
            sliced: false,
            selected: false
        }, {
            name: 'Internet Explorer',
            y: 11
        }, {
            name: 'Firefox',
            y: 5
        }]
    }]
});
});