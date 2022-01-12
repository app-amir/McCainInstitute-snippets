
  /*
 Original Plugin by Osvaldas Valutis, www.osvaldas.info
 http://osvaldas.info/drop-down-navigation-responsive-and-touch-friendly
 Available for use under the MIT License
 */
/**
 * jquery-doubleTapToGo plugin
 * Copyright 2017 DACHCOM.DIGITAL AG
 * @author Marco Rieser
 * @author Volker Andres
 * @author Stefan Hagspiel
 * @version 3.0.2
 * @see https://github.com/dachcom-digital/jquery-doubletaptogo
 */
!function(t,e,s,i){"use strict";function n(e,s){this.element=e,this.settings=t.extend({},a,s),this._defaults=a,this._name=o,this.init()}var o="doubleTapToGo",a={automatic:!0,selectorClass:"doubletap",selectorChain:"li:has(ul)"};t.extend(n.prototype,{preventClick:!1,currentTap:t(),init:function(){t(this.element).on("touchstart","."+this.settings.selectorClass,this._tap.bind(this)).on("click","."+this.settings.selectorClass,this._click.bind(this)).on("remove",this._destroy.bind(this)),this._addSelectors()},_addSelectors:function(){this.settings.automatic===!0&&t(this.element).find(this.settings.selectorChain).addClass(this.settings.selectorClass)},_click:function(e){this.preventClick?e.preventDefault():this.currentTap=t()},_tap:function(e){var s=t(e.target).closest("li");return s.hasClass(this.settings.selectorClass)?s.get(0)===this.currentTap.get(0)?void(this.preventClick=!1):(this.preventClick=!0,this.currentTap=s,void e.stopPropagation()):void(this.preventClick=!1)},_destroy:function(){t(this.element).off()},reset:function(){this.currentTap=t()}}),t.fn[o]=function(e){var s,a=arguments;return e===i||"object"==typeof e?this.each(function(){t.data(this,o)||t.data(this,o,new n(this,e))}):"string"==typeof e&&"_"!==e[0]&&"init"!==e?(this.each(function(){var i=t.data(this,o),r="destroy"===e?"_destroy":e;i instanceof n&&"function"==typeof i[r]&&(s=i[r].apply(i,Array.prototype.slice.call(a,1))),"destroy"===e&&t.data(this,o,null)}),s!==i?s:this):void 0}}(jQuery,window,document);
var subnav2;
(function($){
	var adminbar = 0;
	if ($('#wpadminbar').length) {
		adminbar = $('#wpadminbar').height();
	}

  // add equal height function for the elements
  $('.sub-title-box-section .sub-title-box .elementor-widget-container').matchHeight({
    byRow: true,
  });
  $('.equal-height-cta .elementor-widget-container .elementor-cta__content').matchHeight({
    byRow: true,
    
  });
  $('.mc-pricing-card .elementor-widget-container').matchHeight({
    byRow: true,
    
  });
  $('.state-direction-section .elementor-widget-call-to-action .elementor-cta__image').matchHeight({
    byRow: true,
    
  });
  

  $(document).ready(function(){
	
	let searchParams = new URLSearchParams(window.location.search);
	let type = searchParams.get('type');
	let topic = searchParams.get('topic');
	if( type !== undefined && type !== null ){
		$('select[name="type"].filter').val(type);
	}
	if( topic !== undefined && topic !== null ){
		$('select[name="topic"].filter').val(topic);
	}
	  
    // add class of ie_edge for edge
    if (document.documentMode || /Edge/.test(navigator.userAgent)) {
      $('body').addClass('ie_edge');
	}
	var isMobile = false; //initiate as false
    // device detection
    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) ||
        /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) {
        isMobile = true;
    }
    if (isMobile == true) {
        $('html').addClass('imMobile');
	}
	$('.video-play-btn a').on('click', function(x){
		x.preventDefault();
		$(this).parents().find('.video-play').find('.elementor-custom-embed-play').trigger('click');
		});
		setTimeout(function(){
			$('.main-header-wrapper:not(.elementor-sticky__spacer)').addClass('header-changed');
		}, 1000);
	/**
	 * Code For resource slider start
	 */

	$(".resource-slider").each(function(index, element){
		var $this = $(this);
		var $loop = true;
		if ($this.hasClass('mccain_slide_off')){
			$loop = false;
			$this.prev().addClass('arrow-disable');
			$this.prev().prev().addClass('arrow-disable');
		}
		$this.addClass("instance-" + index);
		$this.parent().find(".arrow-left").addClass("btn-prev-" + index);
		$this.parent().find(".arrow-right").addClass("btn-next-" + index);
		$this.parent().find(".swiper-pagination").addClass("paginate-" + index);
		var swiper = new Swiper(".instance-" + index, {
			slidesPerView: 1,
			resistance: false,
			spaceBetween: 0,
			loop: $loop,
			breakpoints: {
				// when window width is >= 480px
				600: {
					slidesPerView: 2,
				},
				// when window width is >= 640px
				961: {
				slidesPerView: 3,
				}
			},
			navigation: {
				nextEl: ".btn-next-" + index,
				prevEl: ".btn-prev-" + index,
			  },
			pagination: {
				el: ".paginate-" + index,
				clickable: true,
			},
		});
	});
	/** resource slider end here **/
	/**
	 * Code For header start
	 */
	$('.mobile-menu .menu .sub-menu li.current-menu-item,.mobile-menu .menu .sub-menu li.current-menu-ancestor,.mobile-menu .menu .sub-menu li.current-menu-parent,.mobile-menu .menu .sub-menu li.current_page_parent ').closest('ul').parent('li').addClass('sub-menu-toggled');
	$('.mobile-menu .menu .sub-menu li.current-menu-item,.mobile-menu .menu .sub-menu li.current-menu-ancestor,.mobile-menu .menu .sub-menu li.current-menu-parent,.mobile-menu .menu .sub-menu li.current_page_parent ').closest('ul').show();
	$('.mobile-menu .menu>li.menu-item-has-children').append('<div class="angle-down"><i class="fal fa-chevron-down"></i></div>');
	
	if ($('.mobile-menu').length > 0) {

		var myScroll = new IScroll('.mobile-menu .elementor-widget-container', {
			scrollbars: true,
			mouseWheel: true,
			interactiveScrollbars: true,
			shrinkScrollbars: 'scale',
			fadeScrollbars: true,
			click: true,
			disablePointer: true, // important to disable the pointer events that causes the issues
			disableTouch: false, // false if you want the slider to be usable with touch devices
			disableMouse: false, // false if you want the slider to be usable with a mouse (desktop)
		});
	}
	$('.menu-bar').on('click', function(e) {
		e.preventDefault();
		$('.main-header').addClass('hello-state');
		$(this).toggleClass('menu-close');
		$('html').toggleClass('mobile-menu-open');
		$('.mobile-menu').slideToggle(function(){
			if($('.mobile-menu').css('display') == 'none'){
				$('.main-header').removeClass('hello-state');
			}
		});
		setTimeout(function() {
			if ($('.mobile-menu').length > 0) {
				myScroll.refresh();
				myScroll.scrollTo(0, 0, 0);
			}

		}, 500)
	});
	$(document).on('click', '.angle-down', function(e) {
		var el = $(this).parent();

		$(this).parent().toggleClass('sub-menu-toggled').children('.sub-menu').slideToggle().closest('li').siblings().removeClass('sub-menu-toggled').children('.sub-menu').slideUp();
		setTimeout(function() {
			myScroll.refresh();
			// if (el.children('.sub-menu').css('display') == 'block') {
			// 	myScroll.scrollToElement(el[0]);
			// }
		}, 500);
		e.stopPropagation();
		e.stopImmediatePropagation();
		return false;
	});

	/**
	 * Code For header end
	 */

	/**
	 * Code for Team Bio
	 */
	$('.team-bio').on('click', function(){
		$(this).next().show();
		$('html').addClass('popup-open');
		console.log('wadfad')
	});
	$('.team-popup').on('click', function(){
		$(this).hide();
		$('html').removeClass('popup-open');
		console.log('wadfad')
	});
	$('.team-popup-container').on('click', function(e){
		e.stopPropagation();
	});
	 /** End code Team Bio **/


    //run the select code for all selects
    generate_select('select');
    document.activeElement.blur();
    $(document).on('gform_post_render', function () {
      generate_select('select');
    });

    
			$('.graphic-cta-type2 .elementor-cta__image, graphic-cta, .cta-narrow .elementor-cta__image').matchHeight({
				byRow: true,
				property: 'min-height',
			});
			$('.graphic-cta-type2 .elementor-cta__title').matchHeight({
				byRow: true,
				property: 'min-height',
			});
			$('.graphic-cta-type2 .elementor-cta__description').matchHeight({
				byRow: true,
				property: 'min-height',
			});
			$('.graphic-cta-type2 .elementor-cta__content').matchHeight({
				byRow: true,
				property: 'min-height',
			});
		// }

	  $('.site-main .subnav .elementor-text-editor ul li a').on('click', function(){
		  $(this).parent('li').addClass('active')
		  $(this).parent('li').siblings('li').removeClass('active');
	  })
	  
	  // Include active class in dropdown filteration after search.
	  $('.filter-dropdown>.filter [rel="'+type+'"]').addClass('active').siblings().removeClass('active');
	  $('.filter-dropdown>.filter-location [rel="'+topic+'"]').addClass('active').siblings().removeClass('active');
	 
  });

  //window resize and load function
  $(window).on('resize load', function () {
	
  });
	
	jQuery.fn.isInViewport = function () {
		var elementTop = jQuery(this).offset().top;
		var elementBottom = elementTop + jQuery(this).outerHeight();

		var viewportTop = jQuery(window).scrollTop();
		var viewportBottom = viewportTop + jQuery(window).height();

		return elementBottom + 54 > viewportTop && elementTop + 54 < viewportBottom;
	};
	
	$(document).ready(function () {
		

		//smoothscroll
		$('.site-main .subnav .elementor-text-editor ul li a[href^= "#"]').on('click', function (x) {
		 	x.stopImmediatePropagation();
			x.preventDefault();
			$(document).off("scroll");

			$('a').parent().each(function () {
				$(this).parent().removeClass('active');
			})
			$(this).addClass('active');

			var target = this.hash,
				menu = target;
			$target = $(target);
			$('html, body').stop().animate({
				'scrollTop': $target.offset().top - $('.site-main .subnav').outerHeight() - $('.main-header-wrapper').outerHeight() - adminbar + 10
			}, 500, 'swing', function () {
				$(document).on("scroll", onScroll);
			});
		});



		if ($('.inauguration-wrapper').length) {

			$(".inauguration-wrapper").each(function () {
				var el = $(this).children('.content-slider-wrapper');

				let image_slider = $(this).find('.image-inauguration');
				let content_slider = $(this).find('.content-inauguration');

				let bullets = $(this).find('.swiper-custom-bullets');

				let _nextEl = $(this).find('.swiper-custom-btn-right');
				let _prevEl = $(this).find('.swiper-custom-btn-left');

				let image_inauguration = new Swiper(image_slider, {
					slidesPerView: 'auto',
					resistance: true,
					resistanceRatio: 0,
					initialSlide: 0,
					observer: true,
					observeParents: true,
					watchOverflow: true,
					speed: 500,
					effect: 'fade',
					fadeEffect: {
						crossFade: true
					},
					on: {
						init: function () {
							let _length = el.find('.swiper-slide').length;
							el.addClass("total-slides-" + _length);
						},
					},
					pagination: {
						el: bullets,
						type: 'bullets',
						clickable: 'true',
					},

				});

				let content_inauguration = new Swiper(content_slider, {
					slidesPerView: 'auto',
					resistance: true,
					resistanceRatio: 0,
					initialSlide: 0,
					observer: true,
					observeParents: true,
					watchOverflow: true,
					speed: 500,
					simulateTouch: false,

					navigation: {
						nextEl: _nextEl,
						prevEl: _prevEl,
					},

				});

				image_inauguration.controller.control = content_inauguration;
				content_inauguration.controller.control = image_inauguration;

			});

		}
		/**
		 * Set the cursor position function
		 * @param {setCursorPosition} pos
		 */
		$.fn.setCursorPosition = function (pos) {
			this.each(function (index, elem) {
				if (elem.setSelectionRange) {
					elem.setSelectionRange(pos, pos);
				} else if (elem.createTextRange) {
					var range = elem.createTextRange();
					range.collapse(true);
					range.moveEnd('character', pos);
					range.moveStart('character', pos);
					range.select();
				}
			});
			return this;
		};
		//Set the cursor position for zip code
		$(document).on('focus', '.zip_field input', function () {
			var el = $(this);
			setTimeout(function () {
				if (el.val() == '_____')
					el.setCursorPosition(0);
			}, 75);
		});
		
		// Add class in mobile nav for postion handling
		if ($('.header-msg').is(':visible')){
			$('body').addClass('header-msg-visible')
		}else{
			$('body').addClass('header-msg-hidden')	
		}

		if ($('.subnav2').length > 0){
			$(` <span class="subnav2-arrow-left fal fa-chevron-left"></span>
				<div class= "swiper-container nav-slider">
					<div class="swiper-wrapper">
					</div>
				</div>
				<span class="subnav2-arrow-right fal fa-chevron-right"></span>
			`).insertAfter('.subnav2 .elementor-text-editor ul');
			$('.subnav2').find('ul').children('li').each(function(){
				var html = $(this).html();
				$('<div class="swiper-slide">' + html + '</div>').appendTo('.nav-slider .swiper-wrapper');
			});
			// var el = $(document).find('.nav2 .swiper-container.nav-slider')
			// setTimeout(function(){
				subnav2 = new Swiper(".subnav2 .swiper-container.nav-slider", {
					// slidesPerView: 1,
					slidesPerView:2,
					resistance: false,
					spaceBetween: 0,
					loop: false,
					resistance: true,
					resistanceRatio: 0,
					initialSlide: 0,
					observer: true,
					observeParents: true,
					watchOverflow: true,
					navigation: {
						nextEl: '.subnav2-arrow-right',
						prevEl: '.subnav2-arrow-left',
					},
					breakpoints: {
						375: {
							// slidesPerView: 2,
							slidesPerView: 'auto',
						},
						567: {
							slidesPerView: 'auto',
						},
						767: {
							slidesPerView: 3,
						},
						1024: {
							slidesPerView: 4,
						},
						// 1300: {
						// 	slidesPerView: 5,
						// }
					},
				});
			// }, 1000)
			
		}
		$('.anchor-with-swoop').on('click', function(x){
			x.preventDefault();
			x.stopPropagation();
			var $mgn = 0;
			if($(window).width() > 1024){
				$mgn = 200;
			} 
			else if( ($(window).width() <= 1024) && ( $(window).width() > 767 )){
				$mgn = 85;
			}
			var $target = $(this).find('a').attr('href');
			console.log($target);
			$('html, body').stop().animate({
				'scrollTop': $($target).offset().top - $('.main-header-wrapper').outerHeight() - adminbar + $mgn
			}, 500);
		})
	});
	/**
	 * Scroll event for subnav
	 * @param {onScroll} event 
	 */

	
	/**
	 * Scroll event for subnav
	 * @param {onScroll} event 
	 */
	function onScroll2(event) {
		var scrollPos = $(window).scrollTop();
		var activeindex =  0;
		$('.subnav2 .nav-slider .swiper-slide a[href^="#"]').each(function () {
			var currLink = $(this);
			var refElement = $(currLink.attr("href"));
			if (refElement.length>0){
				if (refElement.offset().top - $('.main-header-wrapper').outerHeight() - adminbar - 58 <= scrollPos && refElement.offset().top + refElement.height() > scrollPos - $('.main-header-wrapper').outerHeight() - adminbar - 58) {
					// $('.site-main .subnav .elementor-text-editor ul li').removeClass("active");
					currLink.parent().siblings().children().blur();
					// currLink.focus();
					currLink.parent().addClass("active-slide").siblings().removeClass('active-slide');
					activeindex = $('.active-slide').index();
					subnav2.slideTo(activeindex, 0, false);
				}
			}
			
		});

	}
	$(document).ready(function(){
		$(document).on("scroll", onScroll);
		$(document).on("scroll", onScroll2);
	})
	$(document).on('scroll load', function () {
		if ($('.subnav2.elementor-sticky--active').length> 0){
			var topPos = $('.nav2-wrapper').outerHeight() - $('.subnav2.elementor-sticky--active').outerHeight() - $('.main-header-wrapper').outerHeight() - adminbar;
			if (topPos > $(window).scrollTop()){
				$('.index-high').removeClass('index-low')
			}else{
				$('.index-high').addClass('index-low')
			}
			// console.log(topPos);
		}
	})
	document.addEventListener("scroll", function () {
		document.activeElement.blur();
	});
  
// $('.main-header-wrapper').outerHeight() - adminbar
}(jQuery))