(function ($) {
	"use strict";

	// Hero Slider Carousel
	if ($.fn.owlCarousel) {
		$('.slider-carousel').owlCarousel({
			animateOut: 'fadeOut',
			animateIn: 'fadeIn',
			autoplay: true,
			loop: true,
			items: 1,
			margin: 0,
			stagePadding: 0,
			nav: false,
			dots: false
		});
	}

	// Navbar Scroll State
	$(window).scroll(function () {
		var st = $(this).scrollTop(),
			navbar = $('.ftco_navbar');

		if (st > 150) {
			if (!navbar.hasClass('scrolled')) navbar.addClass('scrolled');
		} else {
			if (navbar.hasClass('scrolled')) navbar.removeClass('scrolled sleep');
		}

		if (st > 350) {
			if (!navbar.hasClass('awake')) navbar.addClass('awake');
		} else {
			if (navbar.hasClass('awake')) {
				navbar.removeClass('awake').addClass('sleep');
			}
		}
	});

	// Counter Number Animation
	if ($.fn.waypoint && $.animateNumber) {
		$('#section-counter').waypoint(function (direction) {
			if (direction === 'down' && !$(this.element).hasClass('ftco-animated')) {
				var commaStep = $.animateNumber.numberStepFactories.separator(',');
				$('.number').each(function () {
					var $this = $(this),
						num = $this.data('number');
					$this.animateNumber({ number: num, numberStep: commaStep }, 3000);
				});
			}
		}, { offset: '95%' });
	}

	// Content Entrance Waypoint Animation
	if ($.fn.waypoint) {
		$('.ftco-animate').waypoint(function (direction) {
			if (direction === 'down' && !$(this.element).hasClass('ftco-animated')) {
				$(this.element).addClass('item-animate');
				setTimeout(function () {
					$('body .ftco-animate.item-animate').each(function (k) {
						var el = $(this);
						setTimeout(function () {
							var effect = el.data('animate-effect');
							el.addClass((effect || 'fadeInUp') + ' ftco-animated').removeClass('item-animate');
						}, k * 50, 'easeInOutExpo');
					});
				}, 100);
			}
		}, { offset: '95%' });
	}

	// Typewriter Effect
	var TxtType = function (el, toRotate, period) {
		this.toRotate = toRotate;
		this.el = el;
		this.loopNum = 0;
		this.period = parseInt(period, 10) || 2000;
		this.txt = '';
		this.isDeleting = false;
		this.tick();
	};

	TxtType.prototype.tick = function () {
		var i = this.loopNum % this.toRotate.length;
		var fullTxt = this.toRotate[i];

		this.txt = this.isDeleting
			? fullTxt.substring(0, this.txt.length - 1)
			: fullTxt.substring(0, this.txt.length + 1);

		this.el.innerHTML = '<span class="wrap">' + this.txt + '</span>';

		var that = this;
		var delta = 200 - Math.random() * 100;
		if (this.isDeleting) delta /= 2;

		if (!this.isDeleting && this.txt === fullTxt) {
			delta = this.period;
			this.isDeleting = true;
		} else if (this.isDeleting && this.txt === '') {
			this.isDeleting = false;
			this.loopNum++;
			delta = 500;
		}

		setTimeout(function () {
			that.tick();
		}, delta);
	};

	window.addEventListener('load', function () {
		var elements = document.getElementsByClassName('typewrite');
		for (var i = 0; i < elements.length; i++) {
			var toRotate = elements[i].getAttribute('data-type');
			var period = elements[i].getAttribute('data-period');
			if (toRotate) {
				new TxtType(elements[i], JSON.parse(toRotate), period);
			}
		}
		var css = document.createElement('style');
		css.innerHTML = '.typewrite > .wrap { border-right: 0.08em solid #fff }';
		document.body.appendChild(css);
	});
})(jQuery);
