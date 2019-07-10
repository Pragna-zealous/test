$(document).ready(function(){

  //home slider
  $('.home-slides').slick({
    infinite: true,
    dots: true,
    arrows: false
  });

  $('.testimonial-slides').slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    responsive: [
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: true,
          }
        },
    ]
  });

  $(".signin-popup").on('click', function() {
    $("#form-popup-bg").fadeIn();
    $("#form-popup-main").fadeIn();
  });
  $("#form-popup-head i").on('click', function() {
    $("#form-popup-bg").fadeOut();
    $("#form-popup-main").fadeOut();
  });

  $(".password-change-btn .defult-btn").on('click', function() {
    $(".password-change-btn").hide();
    $(".password-change").show();
  });


  function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('.bg-img').attr('style', 'background-image:url('+e.target.result +')' );
          }

          reader.readAsDataURL(input.files[0]);
      }
  }

  $(".fid-img").change(function(){
    readURL(this);
  });

  $(".people-icon").on('click', function() {
    $(this).toggleClass('active');
  });

  $(".share-btn span").on('click', function() {
    $(this).toggleClass('active');
    $(".share-icon").fadeToggle('');
    
  });


// Build the chart
Highcharts.chart('container', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Browser market shares in January, 2018'
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
            showInLegend: true
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: [{
            name: 'Chrome',
            y: 61.41,
            sliced: true,
            selected: true
        }, {
            name: 'Internet Explorer',
            y: 11.84
        }, {
            name: 'Firefox',
            y: 10.85
        }, {
            name: 'Edge',
            y: 4.67
        }, {
            name: 'Safari',
            y: 4.18
        }, {
            name: 'Other',
            y: 7.05
        }]
    }]
});
  

});