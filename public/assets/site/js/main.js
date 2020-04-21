/*--------------------------------------------------
	01. Navbar Sticky
---------------------------------------------------*/	
$(document).on("scroll", function(){
    if
  ($(document).scrollTop() > 100){
      $("#mainmenu").addClass("sticky bg-light");
      $("#mainmenu").removeClass("bg-transparent");
    }
    else
    {
        $("#mainmenu").removeClass("sticky bg-light");
        $("#mainmenu").addClass("bg-transparent");

    }
});

/*--------------------------------------------------
	01. Animate Preloader
---------------------------------------------------*/	
    $(".se-pre-con").fadeOut("slow");;

/*--------------------------------------------------
	01. OwlCarousel
---------------------------------------------------*/	
$('.owl-carousel').owlCarousel({
    loop:true,
    margin:20,
    nav:true,
    dots:false,
    rtl:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        }
    }
});
 
/*--------------------------------------------------
	01. Back To Top
---------------------------------------------------*/	 
if ($('#back-to-top').length) {
    var scrollTrigger = 100, // px
        backToTop = function () {
            var scrollTop = $(window).scrollTop();
            if (scrollTop > scrollTrigger) {
                $('#back-to-top').addClass('show');
            } else {
                $('#back-to-top').removeClass('show');
            }
        };

        
    backToTop();
    $(window).on('scroll', function () {
        backToTop();
    });
    $('#back-to-top').on('click', function (e) {
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0
        }, 800);
    });
}


/*--------------------------------------------------
	01. Full Screen Search
---------------------------------------------------*/	 

$(function () {
    $('a[href="#search"]').on('click', function(event) {
        event.preventDefault();
        $('#search').addClass('open');
        $('#search > form > input[type="search"]').focus();
    });
    
    $('#search, #search button.close').on('click keyup', function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });
    
    
    //Do not include! This prevents the form from submitting for DEMO purposes only!
 /*   $('form').submit(function(event) {
        event.preventDefault();
        return false;
    })*/
});






$(function () {

	'use strict';

  $('.product-one .section-product').on('click', function() {

    $(this).find('.angleup').toggleClass('fa-angle-down fa-angle-up');

    $(this).next('.toggle-Product').slideToggle();

  });

  // Dynamic Tabs

    $('.tabs-list li').on('click', function() {

        $(this).addClass('active').siblings().removeClass('active');

        $('.content-list > div').hide();

        $($(this).data('content')).fadeIn();

    });

    // Dynamic Tabs

      $('.tabclass-list li').on('click', function() {

          $(this).addClass('active').siblings().removeClass('active');

          $('.contents-list > div').hide();

          $($(this).data('content')).fadeIn();

      });
      
      $(window).scroll(function() {

		// Scroll To Top Button

		var scrollToTop = $('.scroll-to-top');

		if ($(window).scrollTop() >= 150) {

			if (scrollToTop.is(':hidden')) {

				scrollToTop.fadeIn(400);

			}

		} else {

			scrollToTop.fadeOut(400);

		}

	});

	// Click On Scroll To Top To Go Up

	$('.scroll-to-top').click(function(e) {

		e.preventDefault();

		$('body, html').animate({

			scrollTop: 0

		}, 800);

	});

});



AOS.init({
    // Global settings:
    disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
    startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
    initClassName: 'aos-init', // class applied after initialization
    animatedClassName: 'aos-animate', // class applied on animation
    useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
    disableMutationObserver: false, // disables automatic mutations' detections (advanced)
    debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
    throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)
    
  
    // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
    offset: 120, // offset (in px) from the original trigger point
    delay: 0, // values from 0 to 3000, with step 50ms
    duration: 500, // values from 0 to 3000, with step 50ms
    easing: 'ease', // default easing for AOS animations
    once: true, // whether animation should happen only once - while scrolling down
    mirror: false, // whether elements should animate out while scrolling past them
    anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation
  
  });
/*
  $("html").easeScroll({
    frameRate: 60,
    animationTime: 1000,
    stepSize: 120,
    pulseAlgorithm: 1,
    pulseScale: 8,
    pulseNormalize: 1,
    accelerationDelta: 20,
    accelerationMax: 1,
    keyboardSupport: true,
    arrowScroll: 50,
    touchpadSupport: true,
    fixedBackground: true
  });
*/
    