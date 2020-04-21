$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:3
        }
    }
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
