(function ($) {
	"use strict";

	var windowOn = $(window)
	///////////////////////////////////////////////////
	// 01. PreLoader Js
	windowOn.on('load',function () {
		$('#loading').fadeOut(500);
	});

	///////////////////////////////////////////////////
	// 02. SubMenu Dropdown Toggle
	if ($('.tp-main-menu nav > ul > li.has-dropdown > a').length) {
		$('.tp-main-menu nav > ul > li.has-dropdown > a').append('<i class="fal fa-angle-down"></i>');
	}

    ///////////////////////////////////////////////////
	// 03. scroll-to-target 
	windowOn.on('scroll', function () {
		var scroll = windowOn.scrollTop();
		if (scroll < 500) {
			$('.scroll-to-target').removeClass('open');

		} else {
			$('.scroll-to-target').addClass('open');
		}
	});
	
	///////////////////////////////////////////////////
	// 04. Scroll Up Js
	if ($('.scroll-to-target').length) {
		$(".scroll-to-target").on('click', function () {
		var target = $(this).attr('data-target');
		// animate
		$('html, body').animate({
			scrollTop: $(target).offset().top
		}, 1000);
	
		});
	}

	// 04. Scroll Up Js
	if ($('.scroll-to-target-2').length) {
		$(".scroll-to-target-2").on('click', function () {
		var target = $(this).attr('data-target');
		// animate
		$('html, body').animate({
			scrollTop: $(target).offset().top
		}, 1000);
	
		});
	}
	function smoothSctollTop() {
		$('.smooth a').on('click', function (event) {
			var target = $(this.getAttribute('href'));
			if (target.length) {
				event.preventDefault();
				$('html, body').stop().animate({
					scrollTop: target.offset().top - 150
				}, 1000);
			}
		});
	}
	smoothSctollTop();
	
    ///////////////////////////////////////////////////
	// 05. wow animation
	var wow = new WOW(
		{
		  mobile: true,
		}
	  );
	  wow.init();
	var windowOn = $(window);

	///////////////////////////////////////////////////
	// 06. PreLoader Js
	windowOn.on('load',function() {
		$("#loading").fadeOut(500);

	});

	///////////////////////////////////////////////////
	// 07. Sticky Header Js
	windowOn.on('scroll', function () {
		var scroll = windowOn.scrollTop();
		if (scroll < 400) {
			$("#header-sticky").removeClass("header-sticky");
		} else {
			$("#header-sticky").addClass("header-sticky");
		}
	});

	////////////////////////////////////////////////////
	// 08. Mobile Menu Js
	$('#mobile-menu').meanmenu({
		meanMenuContainer: '.mobile-menu',
		meanScreenWidth: "991",
		meanExpand: ['<i class="fal fa-plus"></i>'],
	});
	////////////////////////////////////////////////////
	// 08. Mobile Menu Js
	$('#mobile-menu-2').meanmenu({
		meanMenuContainer: '.mobile-menu',
		meanScreenWidth: "6000",
		meanExpand: ['<i class="fal fa-plus"></i>'],
	});


	
$(window).on('load', function () {

	$('#preloader').delay(350).fadeOut('slow');

	$('body').delay(350).css({ 'overflow': 'visible' });

})

	////////////////////////////////////////////////////
	// 09. Sidebar Js
	$(".tp-menu-bar").on("click", function () {
		$(".tpoffcanvas").addClass("opened");
		$(".body-overlay").addClass("apply");
	});
	$(".close-btn").on("click", function () {
		$(".tpoffcanvas").removeClass("opened");
		$(".body-overlay").removeClass("apply");
	});
	$(".body-overlay").on("click", function () {
		$(".tpoffcanvas").removeClass("opened");
		$(".body-overlay").removeClass("apply");
	});

	///////////////////////////////////////////////////
	// 10. Magnific Js
	$(".popup-video").magnificPopup({
		type: "iframe",
	});

	////////////////////////////////////////////////////
	// 11. Data CSS Js
	$("[data-background").each(function () {
		$(this).css("background-image", "url( " + $(this).attr("data-background") + "  )");
	});

	$("[data-width]").each(function () {
		$(this).css("width", $(this).attr("data-width"));
	});

	$("[data-bg-color]").each(function () {
		$(this).css("background-color", $(this).attr("data-bg-color"));
	});

	////////////////////////////////////////////////////
	// 12. Counter Js
	$('.counter').counterUp({
		delay: 10,
		time: 1000
	});

	// 09. Home-1-Slider js
	$('.tp-slider-active').slick({
		fade:true,
		autoplay:true,
		slidesToShow: 1,
		arrows: true,
		prevArrow: '<button type="button" class="slick-prev"><i class="fal fa-long-arrow-left"></i></button>',
		nextArrow: '<button type="button" class="slick-next"><i class="fal fa-long-arrow-right"></i></button>',
		responsive: [
			{
				breakpoint: 992,
				settings: {
					arrows: false,
				}
			},
			{
				breakpoint: 768,
				settings: {
					arrows: false,
				}
			},
			{
				breakpoint: 480,
				settings: {
					arrows: false,
				}
			}
		]
	});


	// testimonial
$('.test-slider-active').slick({
	slidesToShow: 1,
	slidesToScroll: 1,
	arrows: false,
	fade: false,
	asNavFor: '.test-img-active'
  });
  
	$('.test-img-active').slick({
	prevArrow: '<button type="button" class="slick-prev"><i class="fal fa-long-arrow-left"></i></button>',
	nextArrow: '<button type="button" class="slick-next"><i class="fal fa-long-arrow-right"></i></button>',	
	slidesToShow: 3,
	slidesToScroll: 1,
	asNavFor: '.test-slider-active',
	dots: false,
	arrows: true,
	focusOnSelect: true,
	centerPadding: '0',
	responsive: [
		{
			breakpoint: 1200,
			settings: {
				slidesToShow: 2,
			}
		},
		{
			breakpoint: 992,
			settings: {
				slidesToShow: 2,
			}
		},
		{
			breakpoint: 768,
			settings: {
				slidesToShow: 2,
			}
		},
		{
			breakpoint: 480,
			settings: {
				arrows: false,
				slidesToShow: 1,
			}
		}
	]
  });

	// 09. Home-1-Slider js
	$('.tp-barnd__active').slick({
		fade:false,
		autoplay:false,
		slidesToShow: 5,
		arrows: false,
		Infinity:true,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 5,
					arrows: false,
				}
			},
			{
				breakpoint: 992,
				settings: {
					arrows: false,
					slidesToShow: 4,
				}
			},
			{
				breakpoint: 768,
				settings: {
					arrows: false,
					slidesToShow: 3,
				}
			},
			{
				breakpoint: 480,
				settings: {
					arrows: false,
					slidesToShow: 1,
				}
			}
		]
	});

	// 09. Home-1-Slider js
	$('.tp-testimonial__active').slick({
		fade:false,
		autoplay:false,
		slidesToShow: 3,
		arrows: false,
		responsive: [
			{
				breakpoint: 1600,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 1400,
				settings: {
					slidesToShow: 2,
				}
			},
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 1,
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 1,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
				}
			}
		]
	});
	// 09. Home-1-Slider js
	$('.tp-service__slider-active').slick({
		fade:false,
		autoplay:false,
		slidesToShow: 3,
		prevArrow: '<button type="button" class="slick-prev"><i class="fal fa-long-arrow-left"></i></button>',
		nextArrow: '<button type="button" class="slick-next"><i class="fal fa-long-arrow-right"></i></button>',
		arrows: true,
		responsive: [
			{
				breakpoint: 1400,
				settings: {
					slidesToShow: 3,
					arrows: false,
				}
			},
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 3,
					arrows: false,
				}
			},
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
					arrows: false,
				}
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					arrows: false,
				}
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					arrows: false,
				}
			}
		]
	});

	////////////////////////////////////////////////////
	// 14. magnificPopup Js
	$('.popup-image').magnificPopup({
		type: 'image',
		gallery: {
			enabled: true
		}
	});


	// 20. Show Login Toggle Js
	$('#showlogin').on('click', function () {
		$('#checkout-login').slideToggle(900);
	});

	/*-------------------------

		showcoupon toggle function

	--------------------------*/

	$('#showcoupon').on('click', function () {

		$('#checkout_coupon').slideToggle(900);

	});


/*-------------------------

	Create an account toggle function

--------------------------*/

$('#cbox').on('click', function () {

	$('#cbox_info').slideToggle(900);

});



/*-------------------------

	Create an account toggle function

--------------------------*/

$('#ship-box').on('click', function () {

	$('#ship-box-info').slideToggle(1000);

});


	////////////////////////////////////////////////////
	// 15. MagnificPopup video view Js
	$(".popup-video").magnificPopup({
	   type: "iframe",
    });

	////////////////////////////////////////////////////
	//26.isotope
	$('.grid').imagesLoaded(function () {
		// init Isotope
		var $grid = $('.grid').isotope({
			itemSelector: '.grid-item',
			percentPosition: true,
			layoutMode: 'fitRows',
			masonry: {
				// use outer width of grid-sizer for columnWidth
				columnWidth: 1,
			},
			
		});
		

		// filter items on button click
		$('.masonary-menu').on('click', 'button', function () {
			var filterValue = $(this).attr('data-filter');
			$grid.isotope({ 
				filter: filterValue,
				animationOptions: {
					duration: 10000,
					easing: "linear",
					queue: true
				}
			});
			
		});

		//for menu active class
		$('.masonary-menu button').on('click', function (event) {
			$(this).siblings('.active').removeClass('active');
			$(this).addClass('active');
			event.preventDefault();
		});

	});	

		// 05. Search Js
		$(".tp-search-box").on("click", function () {
			$(".search-wrapper").toggleClass("search-open");
		});
		$("body > *:not(header)").on("click", function () {
			$(".search-wrapper").removeClass("search-open");
		});

	////////////////////////////////////////////////////
	// 16. Cart Quantity Js
	$('.cart-minus').on('click', function () {
		var $input = $(this).parent().find('input');
		var count = parseInt($input.val()) - 1;
		count = count < 1 ? 1 : count;
		$input.val(count);
		$input.change();
		return false;
	});

	$('.cart-plus').on('click', function () {
		var $input = $(this).parent().find('input');
		$input.val(parseInt($input.val()) + 1);
		$input.change();
		return false;
	});


	/* Price filter active */

	if ($("#slider-range").length) {

		$("#slider-range").slider({

			range: true,

			min: 0,

			max: 500,

			values: [75, 300],

			slide: function (event, ui) {

				$("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);

			}

		});

		$("#amount").val("$" + $("#slider-range").slider("values", 0) +

			" - $" + $("#slider-range").slider("values", 1));

		$('#filter-btn').on('click', function () {

			$('.filter-widget').slideToggle(1000);

		});

	}


	
	// 08. Nice Select Js
	$('select').niceSelect();


})(jQuery);