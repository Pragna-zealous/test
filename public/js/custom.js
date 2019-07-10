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
          breakpoint: 769,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            dots: false,
          }
        },

        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            dots: false,
          }
        },
    ]
  });

  $('.partner-logo-box').slick({
    slidesToShow: 6,
    slidesToScroll: 1,
    autoplay: true,    
    dots: false,
    arrows: false,
    autoplaySpeed: 2000,
    responsive: [
        
        {
            breakpoint: 769,
            settings: {
              slidesToShow: 4,
              slidesToScroll: 1,
              dots: false,
            }
          },
          {
            breakpoint: 479,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              dots: false,
            }
          },
    ]
  });

  $('.we-can-setting .section-row').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,    
    dots: false,
    arrows: false,
    autoplaySpeed: 2000,
    responsive: [
        
        {
            breakpoint: 769,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 1,
              dots: false,
            }
          },
          {
            breakpoint: 479,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              dots: false,
            }
          },
    ]
  });

  $(".signin-popup").on('click', function() {
    $("#form-popup-bg").fadeIn();
    $("#form-popup-main").fadeIn();
  });
  
  $(".mail-msg").on('click', function() {
    $(".form-popup-bg").fadeIn();
    $("#emailPopup").fadeIn();
  });

  $(".form-popup-head i").on('click', function() {
    $(".form-popup-bg").fadeOut();
    $("#LoginPopup").fadeOut();
    $("#emailPopup").fadeOut();
  });

  $(".password-change-btn .defult-btn").on('click', function() {
    $(".password-change-btn").hide();
    $(".password-change").show();
  });

  $(".menu-icon").on('click', function() {
    $(".nav-menu").slideToggle();
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

  //$(".people-icon").on('click', function() {
   // $(this).toggleClass('active');
  //});

  $(".share-btn span").on('click', function() {
    $(this).toggleClass('active');
    $(".share-icon").fadeToggle('');
    
  });
});