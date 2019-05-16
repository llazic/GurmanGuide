

/*-----------------------------------------------------------------------------------

    Template Name: Aahar Food Delivery Html5 Template
    Template URI: https://themeforest.net/user/hastech
    Description: Aahar Food Delivery Html5 Template
    Author: Hastech
    Author URI: https://themeforest.net/user/hastech
    Version: 1.0

-----------------------------------------------------------------------------------*/



(function($) {
    'use strict';


/*=========== Wow Active ===========*/

  new WOW().init();


/*=========== Counter Up===========*/

  $('.count').counterUp({
    delay: 10,
    time: 1000
  });


/*============= Youtub Popup ==============*/

  $('a.video-play-button').yu2fvl();



/*============= Youtub Popup 02 ==============*/

	$('a.video-play-button--2').yu2fvl();



/*=============  Testimonial Text Carousel  ==============*/

  $('.testimonial-text-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    draggable: false,
    fade: true,
    autoplay: true,
    asNavFor: '.testimonial-image-slider',
    responsive: [
        {
          breakpoint: 600,
          settings: {
            dots: false,
            slidesToShow: 1,
            slidesToScroll: 1,  
            centerPadding: '0px',
            }
        },
        {
          breakpoint: 320,
          settings: {
            autoplay: false,
            dots: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            centerMode: false,
            focusOnSelect: false,
            }
        }
        ]
    });



/*=============  Testimonial Image Slider As Nav  ==============*/

    $('.testimonial-image-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.testimonial-text-slider',
        autoplay: true,
        swipeToSlide: true,
        dots: true,
        arrows:false,
        dotsClass: 'dot__cus',
        infinite: true,
        prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-double-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-double-right"></i></button>',
        centerMode: true,
        focusOnSelect: true,
        centerPadding: '10px',
        responsive: [
            {
              breakpoint: 600,
              settings: {
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1,  
                centerPadding: '10px',
                }
            },
            {
              breakpoint: 320,
              settings: {
                autoplay: true,
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                centerMode: false,
                focusOnSelect: false,
                }
            }
        ]

    });



/*=============  Testimonial Activation 01  ==============*/

  $(".testimonial__activation--1").owlCarousel({
      loop:true,
      margin:0,
      nav:false,
      autoplay: false,
      autoplayTimeout: 3000,
      items:3,
      dots: false,
      lazyLoad: true,
      responsive:{
        0:{
          items:1
        },
        1920:{
          items:1
        }
      }
    });


/*=============  Testimonial Activation 02  ==============*/


    $('.testimonial__activation--2').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: false,
        swipeToSlide: true,
        dots: true,
        arrows:false,
        dotsClass: 'dot__cus',
        infinite: true,
        prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-double-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-double-right"></i></button>',
        centerMode: true,
        focusOnSelect: true,
        centerPadding: '0px',
        responsive: [
            {
              breakpoint: 600,
              settings: {
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1,  
                centerPadding: '10px',
                }
            },
            {
              breakpoint: 320,
              settings: {
                autoplay: true,
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                centerMode: false,
                focusOnSelect: false,
                }
            }
        ]

    });




  
/*=============  Testimonial Activation 03  ==============*/


  $(".testimonia__activation--3").owlCarousel({
      loop:true,
      margin:0,
      nav:false,
      autoplay: false,
      autoplayTimeout: 10000,
      items:1,
      dots: false,
      lazyLoad: true,
      responsive:{
        0:{
          items:1
        },
        1920:{
          items:1
        }
      }
    });


/*=============  Instagram Activation  ==============*/


  $(".instagram__activation").owlCarousel({
      loop:true,
      margin:0,
      nav:false,
      autoplay: false,
      autoplayTimeout: 10000,
      items:5,
      dots: false,
      lazyLoad: true,
      responsive:{
        0:{
          items:1
        },
        480:{
          items:2
        },
        575:{
          items:2
        },
        767:{
          items:2
        },
        768:{
          items:2
        },
        992:{
          items:3
        },
        1920:{
          items:5
        }
      }
    });


/*=============  Blog Activation  ==============*/


  $(".blog__activation").owlCarousel({
      loop:true,
      margin:0,
      nav:true,
      autoplay: false,
      autoplayTimeout: 10000,
      items:1,
      navText: [ '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ],
      dots: false,
      lazyLoad: true,
      responsive:{
        0:{
          items:1
        },
        1920:{
          items:1
        }
      }
    });


/*=============  About Video Activation  ==============*/


  $(".about__video__activation").owlCarousel({
      loop:true,
      margin:0,
      nav:true,
      autoplay: false,
      autoplayTimeout: 10000,
      items:1,
      navText: [ '<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>' ],
      dots: false,
      lazyLoad: true,
      responsive:{
        0:{
          items:1
        },
        1920:{
          items:1
        }
      }
    });

/*=============  Portfolio Activation  ==============*/

  $('.portfolio__area').imagesLoaded( function() {

    // filter items on button click
    $('.portfolio__menu').on( 'click', 'button', function() {
      var filterValue = $(this).attr('data-filter');
      $grid.isotope({ filter: filterValue });
    });
    
    // change is-checked class on buttons
    $('.portfolio__menu button').on('click', function () {
        $('.portfolio__menu button').removeClass('is-checked');
        $(this).addClass('is-checked');
        var selector = $(this).attr('data-filter');
        $containerpage.isotope({ filter: selector });
        return false;
  });

    // init Isotope
    var $grid = $('.portfolio__wrap').isotope({
      itemSelector: '.pro__item',
      percentPosition: true,
      transitionDuration: '0.7s',
      layoutMode: 'fitRows',
      masonry: {
        // use outer width of grid-sizer for columnWidth
        columnWidth: 1,
      }
    })

  });



/*=============  Blog Mesonry Activation  ==============*/

  $('.blog__masonry__container').imagesLoaded( function() {

    // filter items on button click
    $('.blog__masonry__menu').on( 'click', 'button', function() {
      var filterValue = $(this).attr('data-filter');
      $grid.isotope({ filter: filterValue });
    });
    
    // change is-checked class on buttons
    $('.blog__masonry__menu button').on('click', function () {
        $('.blog__masonry__menu button').removeClass('is-checked');
        $(this).addClass('is-checked');
        var selector = $(this).attr('data-filter');
        $containerpage.isotope({ filter: selector });
        return false;
  });

    // init Isotope
    var $grid = $('.blog__masonery__wrap').isotope({
      itemSelector: '.bl__item',
      percentPosition: true,
      transitionDuration: '0.7s',
      masonry: {
        // use outer width of grid-sizer for columnWidth
        columnWidth: 1,
      }
    })


  });


/*=============  Plus Minus Button ==============*/


    $(".cart-plus-minus").append('<div class="dec qtybutton">-</i></div><div class="inc qtybutton">+</div>');

    $(".qtybutton").on("click", function () {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.text() == "+") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }
        $button.parent().find("input").val(newVal);
    });







/*============= Login Register Form ==============*/

    function loginRegisterForm(){
        var trigger = $('.accountbox-trigger'),
            container = $('.accountbox-wrapper');
            $('<div class="body-overlay"></div>').prependTo(container);

        trigger.on('click', function(e){
            e.preventDefault();
            container.addClass('is-visible');
        });

        $('.body-overlay').on('click', function(){
            container.removeClass('is-visible');
        });

        $('span.accountbox-close-button').on('click', function(){
            container.removeClass('is-visible');
        });

  };
  loginRegisterForm();




/*============= Cartbox Toggler ==============*/

    function cartboxToggler(){
        var trigger = $('.minicart-trigger'),
            container = $('.cartbox-wrap');
        $('<div class="body-overlay"></div>').prependTo(container);

        trigger.on('click', function(e){
            e.preventDefault();
            container.toggleClass('is-visible');
        })
        $('.cartbox-close').on('click', function(){
            container.removeClass('is-visible');
        })
        container.find('.body-overlay').on('click', function(){
            container.removeClass('is-visible');
        })
    };
    cartboxToggler();




/*=========== ScrollUp ===========*/

  $.scrollUp({
      scrollText: '<i class="fa fa-angle-up"></i>',
      easingType: 'linear',
      scrollSpeed: 900,
      animation: 'slideInRight'
  });


/*=========== Mobile Menu ===========*/

  $('nav.main__menu__nav').meanmenu({
    meanMenuClose: 'X',
    meanMenuCloseSize: '18px',
    meanScreenWidth: '991',
    meanExpandableChildren: true,
    meanMenuContainer: '.mobile-menu',
    onePage: true
  });



/*=========== ScrollReveal Js Init ===========*/

  window.sr = ScrollReveal({ duration: 700 , reset: false});
  sr.reveal('.foo');
  sr.reveal('.bar');



/*=========== Sticky Header ===========*/
function stickyHeader(){
    $(window).on('scroll', function(){
        var sticky_menu = $('.sticky__header');
        var pos = sticky_menu.position();
        if (sticky_menu.length) {
            var windowpos = sticky_menu.top;
            $(window).on('scroll', function() {
               var windowpos = $(window).scrollTop();
               if (windowpos > pos.top + 250) {
                   sticky_menu.addClass('is-sticky');
               } else {
                   sticky_menu.removeClass('is-sticky');
               }
            });
        }
    });
}
stickyHeader();





/*============= Checkout Login/Register Toggle ==============*/
    function checkoutLoginToggle(){
        var checkoutMethodList = $('.checkout-method-list li');
        checkoutMethodList.on('click', function(){
            var form = $(this).data('form');
            if( !$(this).hasClass('active') ) {
                $('.checkout-method-list li').removeClass('active');
                $(this).addClass('active');
                $('.checkout-method form').slideUp(500);
                $('.' + form).delay(500).slideDown();
            }
        });
    }
    checkoutLoginToggle();
    




/*============= Checkout Shipping Form Toggle ==============*/
    function checkoutShippingToggle(){
        var shipingFormToggle = $('.shipping-form-toggle');
        var shipingForm = $('.shipping-form');
        shipingFormToggle.on('click', function(){
            if( $(this).hasClass('active') ) {
                $(this).removeClass('active');
                shipingForm.slideUp();
            } else {
                $(this).addClass('active');
                shipingForm.slideDown();
            }
        });
    }
    checkoutShippingToggle();
    




/*============= Payment Method Toggle ==============*/
    function paymentMethodToggle(){
        var paymentMethodList = $('.payment-method-list li');
        var paymentFormToggle = $('.payment-form-toggle');
        var paymentForm = $('.payment-form');
        paymentMethodList.on('click', function(){
            paymentMethodList.removeClass('active');
            $(this).addClass('active');
            if( $(this).hasClass('payment-form-toggle') ) {
                paymentForm.slideDown()
            } else {
                paymentForm.slideUp()
            }
        });
    }
    paymentMethodToggle();








})(jQuery);