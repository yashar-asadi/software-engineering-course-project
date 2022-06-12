(function($){

	"use strict";

	var defaultConfig = {
		rootMargin: '0px',
		threshold: 0.1,
		load: function load(element) {}
	};
	jQuery.exists = function(selector) {return ($(selector).length > 0);}
	//===============================================================
	// Global Debounce
	//===============================================================

	// Returns a function, that, as long as it continues to be invoked, will not
	// be triggered. The function will be called after it stops being called for
	// N milliseconds. If `immediate` is passed, trigger the function on the
	// leading edge, instead of the trailing.

	window.nova_js_debounce = function(func, wait, immediate) {
		var timeout;
		return function() {
			var context = this, args = arguments;
			var later = function() {
				timeout = null;
				if (!immediate) func.apply(context, args);
			};
			var callNow = immediate && !timeout;
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
			if (callNow) func.apply(context, args);
		};
	};


	//===============================================================
	// Global Throttle
	//===============================================================

	// Returns a function, that, as long as it continues to be invoked, will only
	// trigger every N milliseconds. If <code>immediate</code> is passed, trigger the
	// function on the leading edge, instead of the trailing.

	window.nova_js_throttle = function(func, wait, immediate) {
		var timeout;
		return function() {
			var context = this, args = arguments;
			var later = function() {
				timeout = null;
				if (!immediate) func.apply(context, args);
			};
			var callNow = immediate && !timeout;
			if ( !timeout ) timeout = setTimeout( later, wait );
			if (callNow) func.apply(context, args);
		};
	};
	window.popup_createCookie = function(name, value, days) {
		var expires;
		if (days) {
				var date = new Date();
				date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
				expires = "; expires=" + date.toGMTString();
		} else {
				expires = "";
		}
		document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
	};
	window.popup_readCookie = function(name) {
			var nameEQ = escape(name) + "=";
			var ca = document.cookie.split(';');
			for (var i = 0; i < ca.length; i++) {
					var c = ca[i];
					while (c.charAt(0) === ' ') c = c.substring(1, c.length);
					if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
			}
			return null;
	};
	window.popup_eraseCookie = function(name) {
			popup_createCookie(name, "", -1);
	};

	//===============================================================
	// Scroll Detection
	//===============================================================

	window.scroll_position = $(window).scrollTop();
	window.scroll_direction = 'fixed';

	function scroll_detection() {
		var scroll = $(window).scrollTop();
	    if (scroll > window.scroll_position) {
	        window.scroll_direction = 'down';
	    } else {
	        window.scroll_direction = 'up';
	    }
	    window.scroll_position = scroll;
	}

	$(window).scroll(function() {
        scroll_detection();
    });


	//===============================================================
	// Lazy load
	//===============================================================
	function markAsLoaded(element) {
			element.setAttribute('data-element-loaded', true);
	}

	var isLoaded = function isLoaded(element) {
			return element.getAttribute('data-element-loaded') === 'true';
	};

	var onIntersection = function onIntersection(load) {
			return function (entries, observer) {
					entries.forEach(function (entry) {
							if (entry.intersectionRatio > 0) {
									observer.unobserve(entry.target);

									if (!isLoaded(entry.target)) {
											load(entry.target);
											markAsLoaded(entry.target);
									}
							}
					});
			};
	};
	window.nova_lazyload = function () {
      var selector = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
      var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

      var _defaultConfig$option = $.extend({}, defaultConfig, options),
          rootMargin = _defaultConfig$option.rootMargin,
          threshold = _defaultConfig$option.threshold,
          load = _defaultConfig$option.load;

      var observer = void 0;

      if (window.IntersectionObserver) {
          observer = new IntersectionObserver(onIntersection(load), {
              rootMargin: rootMargin,
              threshold: threshold
          });
      }

      return {
          triggerSingleLoad: function triggerSingleLoad(){
              if(!$.exists(selector)){
                  return;
              }
              var element = selector.get(0);
              if(isLoaded(element)){
                  return;
              }
              if (observer) {
                  observer.observe(element);
                  return;
              }
              load(element);
              markAsLoaded(element);

          },
          observe: function observe() {

              if ( !$.exists(selector) ) {
                  return;
              }
              for (var i = 0; i < selector.length; i++) {
                  if (isLoaded(selector[i])) {
                      continue;
                  }
                  if (observer) {
                      observer.observe(selector[i]);
                      continue;
                  }
                  load(selector[i]);
                  markAsLoaded(selector[i]);
              }
          },
          triggerLoad: function triggerLoad(element) {
              if (isLoaded(element)) {
                  return;
              }
              load(element);
              markAsLoaded(element);
          }
      };
  };
//===============================================================
// Add (+/-) Button Number Incrementers
//===============================================================

function nova_add_button_nummber_inc() {
	$(".quantity").append('<div class="qty-button inc">+</div><div class="qty-button dec">-</div>');
	$(".qty-button").on("click", function() {

		var $button = $(this);
		var oldValue = $button.parent().find("input").val();
		if ($button.text() == "+") {
			if(oldValue == 0 ) {
				var newVal = 1;
			}else {
				var newVal = parseFloat(oldValue) + 1;
			}
		} else {
		 // Don't allow decrementing below zero
			if (oldValue > 0) {
				var newVal = parseFloat(oldValue) - 1;
			} else {
				newVal = 0;
			}
		}

		$button.parent().find("input").val(newVal);
		if ( $( ".woocommerce-cart-form" ).length ) {
			$( '.woocommerce-cart-form :input[name="update_cart"]' ).prop( 'disabled', false );
		}
	});
}
nova_add_button_nummber_inc();

//===============================================================
// Select 2
//===============================================================
if ( typeof $.fn.select2 === 'function' ) {

	$('.nova-topbar .currency-switcher select').select2({
		minimumResultsForSearch: -1,
		dropdownAutoWidth: true,
		dropdownParent: $('.nova-topbar__left--switcher'),
		allowClear: false
	});


}
})(jQuery);


(function($){

	"use strict";

	if(nova_js_var.site_preloader == 1) {
		setTimeout(function() {
			$('body').removeClass('site-loading');
		}, 500);
		$(window).load(function() {
				$('body').removeClass('site-loading');
		});
		$(window).on('beforeunload', function(e) {
			$('body').addClass('site-loading');
		});
		$(window).on('pageshow', function(e) {
				if (e.originalEvent.persisted) {
						$('body').removeClass('site-loading');
				}
		});
	}

})(jQuery);


(function($){

	"use strict";

	var $style_tag = $('#nova_insert_custom_css');

	if (!$.exists($style_tag)) {
			$style_tag = $('<style></style>', {
					'id': 'nova_insert_custom_css'
			}).appendTo('head');
	}
	$('.custom-styles-css').each(function(){
		var custom_css = $(this).html();
		$style_tag.append(custom_css);
	});

})(jQuery);


(function($){

	"use strict";

	window.nova_responsive_media_css = function( el ){
			var $elm = $(el),
					n 		= $elm.attr('data-el_media_sizes'),
					target 	= $elm.attr('data-el_target'),
					tmp_xlg = '',
					tmp_lg  = '',
					tmp_md  = '',
					tmp_sm  = '',
					tmp_xs  = '',
					tmp_mb  = '';
			var init = function(){
					if (typeof n !== 'undefined' || n != null) {
							$.each($.parseJSON(n), function (i, v) {
									var css_prop = i;
									if (typeof v !== 'undefined' && v != null && v != '') {
											$.each(v.split(";"), function(i, vl) {
													if (typeof vl !== 'undefined' && vl != null && vl != '') {
															var splitval = vl.split(":"),
																	_elm_attr = css_prop + ":" + splitval[1] + ";";
															switch( splitval[0]) {
																	case 'xlg':
																			tmp_xlg     += _elm_attr;
																			break;
																	case 'lg':
																			tmp_lg      += _elm_attr;
																			break;
																	case 'md':
																			tmp_md      += _elm_attr;
																			break;
																	case 'sm':
																			tmp_sm      += _elm_attr;
																			break;
																	case 'xs':
																			tmp_xs      += _elm_attr;
																			break;
																	case 'mb':
																			tmp_mb      += _elm_attr;
																			break;
															}
													}
											});
									}
							});
					}

					if(tmp_xlg!='') {
							appendCSS(target+ '{' + tmp_xlg + '}', 'xlg');
					}
					if(tmp_lg!='') {
							appendCSS(target+ '{' + tmp_lg + '}', 'lg');
					}
					if(tmp_md!='') {
							appendCSS(target+ '{' + tmp_md + '}', 'md');
					}
					if(tmp_sm!='') {
							appendCSS(target+ '{' + tmp_sm + '}', 'sm');
					}
					if(tmp_xs!='') {
							appendCSS(target+ '{' + tmp_xs + '}', 'xs');
					}
					if(tmp_mb!='') {
							appendCSS(target+ '{' + tmp_mb + '}', 'mb');
					}
			};

			var appendCSS = function(css, screen){
					var screen_obj = {
							'lg' : 'all',
							'xlg' : 'screen and (min-width:1824px)',
							'md' : 'screen and (max-width:1199px)',
							'sm' : 'screen and (max-width:991px)',
							'xs' : 'screen and (max-width:767px)',
							'mb' : 'screen and (max-width:479px)'
					};

					$.each(screen_obj,function(item){
							if(!$.exists($('#nova_custom_css_' + item))){
									$(
											'<style></style>',
											{
													'id' : 'nova_custom_css_' + item,
													'media' : screen_obj[item]
											}
									).appendTo('head');
							}
					});

					var $style_tag = $('#nova_custom_css_' + screen);

					$style_tag.append(css);
			};

			return init();
	};

	$( ".js_responsive_css" ).each(function() {
		var el = $( this );
  	nova_responsive_media_css(this);
	});

})(jQuery);


(function($){

	"use strict";

		window.nova_custom_scrollbar = function(el) {
			var self = this,
      		$scrollBars = el ? el : $('.nova_box_ps, .nova-product-filter-content .wcapf-layered-nav');

      $scrollBars.each(function() {
        var that = $(this);
        that.perfectScrollbar({
          wheelPropagation: false,
          suppressScrollX: true
        });
      });

      $(window).resize(function() {
        resize($scrollBars);
      });

      var resize = function(container) {
        container.perfectScrollbar('update');
      };
		};
		nova_custom_scrollbar();
})(jQuery);


(function($) {

  "use strict";

  // =============================================================================
  // Foundation
  // =============================================================================

  $(document).foundation();
})(jQuery);


(function($) {

	"use strict";

	// =============================================================================
	// Header Search
	// =============================================================================

	// Search fullscreen
	if($('#masthead').find('#js_header_search_modal').length !== 0) {
		$("#js_header_search_modal").animatedModal({
			animatedIn: 'slideInDown',
			animatedOut: 'slideOutUp',
			beforeOpen: function() {
				window.setTimeout(function () {
								$(".header-search").addClass('animate');
				 }, 300);
				 window.setTimeout(function () {
								 $(".header-search").addClass('animate-line');
					}, 1000);
			},
		});
	}
	if($('.header-mobiles-wrapper').find('#js_mobile_search_modal').length !== 0) {
		$("#js_mobile_search_modal").animatedModal({
			animatedIn: 'slideInDown',
			animatedOut: 'slideOutUp',
			beforeOpen: function() {
				window.setTimeout(function () {
								$(".header-search").addClass('animate');
				 }, 300);
				 window.setTimeout(function () {
								 $(".header-search").addClass('animate-line');
					}, 1000);
			},
		});
	}
	// Init

	$(document).keyup(function(e) {
	    if( e.keyCode == 27 ) {
	    	$('.site-search.off-canvas .header_search_ajax_results_wrapper').removeClass('visible animated');
	    	return false;
    	}
	});

	if ( typeof $.fn.select2 === 'function' ) {

		$('.off-canvas-wrapper .header_search_select').select2({
			minimumResultsForSearch: -1,
			allowClear: false,
			dropdownParent: $('.off-canvas-wrapper .header_search_form'),
			containerCssClass: "select2_no_border",
			dropdownCssClass: "select2_no_border",
		});

		$('.header-type-1 .header_search_select').select2({
			minimumResultsForSearch: -1,
			allowClear: false,
			dropdownParent: $('.header-type-1 .header_search_form'),
			containerCssClass: "select2_no_border",
			dropdownCssClass: "select2_no_border",
		});

	}

	// Show it
	$('.header_search_select_wrapper').addClass('visible');
	// Open
	$('.header_search_input_wrapper input').on('click', function() {
		$(this).parents('form.header_search_form').addClass('active');
	    $('.header_search_ajax_results_wrapper').addClass('visible animated');
	});
	window.original_results = $('.header_search_ajax_results').html();

	// Start Close
	window.header_search_results_close = function(e) {

		var header_search_results_hiding = function(e) {
		    var container = $(".alwayshow-box .header_search_input_wrapper input, .alwayshow-box .header_search_ajax_results_wrapper");
		    if (!container.is(e.target) && container.has(e.target).length === 0)
		    {
		        $('.alwayshow-box  .header_search_ajax_results_wrapper').removeClass('animated');
		    }
		};

		var header_search_results_hide = nova_js_debounce(function(e) {
		    var container = $(".alwayshow-box .header_search_input_wrapper input, .alwayshow-box .header_search_ajax_results_wrapper");
		    if (!container.is(e.target) && container.has(e.target).length === 0)
		    {
		        $('.alwayshow-box  .header_search_ajax_results_wrapper').removeClass('visible');
		    }
		}, 300);

		var header_search_border = function(e) {
			var container = $('.header_search_form');
			if (!container.is(e.target) && container.has(e.target).length === 0)
			{
				container.removeClass('active');
			}
		}

		var header_search_results_reset = nova_js_debounce(function(e) {
		    var container = $(".header_search_input_wrapper input, .header_search_ajax_results_wrapper");
		    if (!container.is(e.target) && container.has(e.target).length === 0)
		    {
		        if(!$('.header_search_input').val()) {
		        	$('.header_search_ajax_results').html(window.original_results);
	        	}
		    }
		}, 400);

		header_search_results_hiding(e);
		header_search_results_hide(e);
		header_search_border(e);
		header_search_results_reset(e);

	}

	$(document).on('click', function(e) {
	    header_search_results_close(e);
	});

	$('.header_search_form').on('click', 'a.view-all', function(){
		$(this).parents('.header_search_form').submit();
	})
	// End Close

	// =============================================================================
	// WP Search
	// =============================================================================

	// Open
	$('.woocommerce-product-search input').on('click', function() {
		$(this).parents('form.woocommerce-product-search').addClass('active');
	});

	$('.search-form input').on('click', function() {
		$(this).parents('form.search-form').addClass('active');
	});

	// Close
	$(document).on('click', function(e) {
	    header_wp_search_border(e);
	    header_wc_search_border(e);
	});

	var header_wp_search_border = function(e) {
		var container = $('.search-form');
		if (!container.is(e.target) && container.has(e.target).length === 0)
		{
			container.removeClass('active');
		}
	}

	var header_wc_search_border = function(e) {
		var container = $('.woocommerce-product-search');
		if (!container.is(e.target) && container.has(e.target).length === 0)
		{
			container.removeClass('active');
		}
	}

})(jQuery);


(function($) {

	"use strict";

	var shopbycat_dropdown_hide = nova_js_debounce(function(e) {
			var container = $(".shopbycat-button");
			if (!container.is(e.target) && container.has(e.target).length === 0)
			{
					$('.shopbycat__dropdown').removeClass('is-open');
			}
	}, 200);
	$(document).on('click', function(e) {
			shopbycat_dropdown_hide(e);
	});

})(jQuery);


jQuery(function($) {

	"use strict";

	$(".nova-header__navigation, .nova-header__right-action")

	.on("mouseenter", "a[data-toggle]", function(e) {
		var panel_id = $(e.currentTarget).data("toggle");
		$(e.delegateTarget).find("#" + panel_id).addClass("animated");
	})

	.on("mouseleave", "a[data-toggle]", function(e) {
		$(e.delegateTarget).find(".dropdown-pane").removeClass("animated");
	});

	// =============================================================================
	// Shop Archive Orderby Select Options
	// =============================================================================

	if ( typeof $.fn.select2 === 'function' ) {

		$('.nova-topbar__right .dropdown select').select2({
			minimumResultsForSearch: -1,
			allowClear: false,
			dropdownAutoWidth: true,
			containerCssClass: "select2_no_border",
			dropdownCssClass: "select2_no_border",
		})
	}


});


jQuery(function($) {

	"use strict";

	var header = document.getElementById( 'masthead' );
	var topbar = document.getElementById( 'topbar' );
	var headermobiles = document.getElementById( 'header-mobile' );
	var handheldBar = document.getElementById( 'handheld_bar' );
	var offset = 0;
	var mqL = window.matchMedia('(min-width: 1280px)');

	if(nova_js_var.enable_header_sticky == 1 && header ) {
		topbar_space();
		if (!$("body").hasClass("has-transparent-header")) {
			prepareForWhiteHeader();
		}
		$(window).resize(function(){
			topbar_space();
			if (!$("body").hasClass("has-transparent-header")) {
			 	prepareForWhiteHeader();
			}
		 });
		offset = topbar ? topbar.clientHeight : 1;

		var stickyHeader = new Headroom( header, {
			offset  : offset,
			classes: {
				initial: "animated",
				pinned: "slideDown",
				unpinned: "slideUp"
			}
		} );
		var stickyMobileHeader = new Headroom( headermobiles, {
			offset  : 1,
			classes: {
				initial: "animated",
				pinned: "slideDown",
				unpinned: "slideUp"
			},
			onNotTop : function() {
    		handheldBar.classList.add("postion--fixed");
				handheldBar.classList.add("animated");
  		},
			onTop : function() {
				handheldBar.classList.remove("postion--fixed");
				handheldBar.classList.remove("slideUp");
			},
			onPin : function() {
				handheldBar.classList.add("slideUp");
			},
			onUnpin : function() {
				handheldBar.classList.remove("slideUp");
			}
		} );

		var headroomHeader = function () {
		  if (mqL.matches) {
				stickyMobileHeader.destroy();
				stickyHeader.init();
		  } else {
				stickyHeader.destroy();
				stickyMobileHeader.init();
		  }
		}

		mqL.addListener(headroomHeader);
		headroomHeader();
	}
	function topbar_space() {
		if ( topbar ) {
			header.style.top = topbar.clientHeight + 'px';
		}
	}
	function prepareForWhiteHeader() {
		if ( header ) {
			if ( topbar ) {
				topbar.style.marginBottom = header.clientHeight - 1 + 'px';
			} else {
				document.getElementById( 'site-content' ).style.paddingTop = header.clientHeight + 'px';
			}
		}
	}
});


(function($) {

	"use strict";

	$(document).on('click', '.header-handheld-header-bar .nova_com_action--dropdownmenu .component-target', function(e) {
	  e.preventDefault();
	  var $_parent = $(this).parent();
	  if ($_parent.hasClass('active')) {
	      $_parent.removeClass('active');
	      $('body').removeClass('open-overlay');
	  } else {
	      $_parent.addClass('active');
	      $_parent.siblings().removeClass('active');
	      $('body').addClass('open-overlay');
	  }
  });

})(jQuery);


(function($) {

  "use strict";
  if ($("#js_medalion_burger_menu").hasClass("medalion_burger_menu")) {
    $("#js_medalion_burger_menu").animatedModal({
      animatedIn: 'slideInDown',
      animatedOut: 'slideOutUp',
      beforeOpen: function() {
        window.setTimeout(function() {
          $(".full-menu, .nova-fullscreen-menu__slidebar").addClass('animate');
        }, 300);
        window.setTimeout(function() {
          $(".full-menu, .nova-fullscreen-menu__slidebar").addClass('animate-line');
        }, 1000);
      },
      afterClose: function() {
        // $(".full-menu, .nova-fullscreen-menu__slidebar").removeClass('animate animate-line');
      }
    });
  }
  $('.full-menu > li').first().addClass('active-sub');

  $('.full-menu > li').on({
    mouseenter: function() {
      $(this).siblings().removeClass('active-sub');
      $(this).addClass('active-sub');
    }
  });

})(jQuery);


(function($) {

	"use strict";

	// =============================================================================
	// Filters Toggle
	// =============================================================================

	$(document).on('click', '.js-product-filters-toogle', function() {
		$('body').toggleClass('panel-open-menu');
		$('#side-filters').toggleClass('opened');
		setTimeout(function() {
			$('#side-filters').toggleClass('opened-opacity');
		}, 100);
		// $('#side-filters').toggle(100, function() {
		// 	$('#side-filters').toggleClass('opened');
		// });
	});

})(jQuery);


(function($) {

	"use strict";

	// =============================================================================
	// Shop Archive Orderby Select Options
	// =============================================================================

	if ( typeof $.fn.select2 === 'function' ) {

		$('.woocommerce-ordering .orderby').select2({
			minimumResultsForSearch: -1,
			placeholder: nova_js_var.select_placeholder,
			dropdownParent: $('.woocommerce-archive-header-inside'),
			allowClear: false,
			dropdownAutoWidth: true,
		})
	}

})(jQuery);


(function($) {

	"use strict";

	$(window).load(function() {
        setTimeout(function() {
			$(".product-item__thumbnail-placeholder.second_image_enabled").addClass("second_image_loaded");
        }, 300);
	});

	// =============================================================================
	// Shop Archive Buttons Click States
	// =============================================================================

	// Wishlist

	$(document).on('click', '.product-item__thumbnail .add_to_wishlist',  function(e) {
		var this_button = $(this);
		this_button.addClass('clicked');
		this_button.parents('.product-item').addClass('adding');
		setTimeout(function() {
        	this_button.addClass('loading');
        }, 400);
		$(document.body).on('added_to_wishlist', function() {
			this_button.removeClass('loading');
			this_button.parents('.product-item').removeClass('adding');
			this_button.removeClass('add_to_wishlist').addClass('added');
			this_button.attr("href", this_button.data("wishlist-url"));
		});
	});


	// Quick View

	$(document).on('click', '.nova_product_quick_view_btn',  function() {
		var this_button = $(this);
		$.LoadingOverlay("show", {
		    image       : '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: rgba(255, 255, 255,0); display: block; shape-rendering: auto;" width="51px" height="51px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><circle cx="50" cy="25" r="15" fill="#1d0e0b"><animate attributeName="cy" dur="1s" repeatCount="indefinite" calcMode="spline" keySplines="0.45 0 0.9 0.55;0 0.45 0.55 0.9" keyTimes="0;0.5;1" values="25;75;25"></animate></circle></svg>',
				imageAnimation: '',
				maxSize:	51
		});
		$(document.body).on('opened_product_quickview', function() {
					$.LoadingOverlay("hide");
		});
	});



	// Add to Cart

	$(document).on('click', '.product-item__description--actions .ajax_add_to_cart, .nova-product-mini .add_to_cart_button', function() {
		var this_button = $(this);
		var minicart_box = $('#MiniCartCanvas');
		var minicart_box_loading = $('#MiniCartCanvas .add_ajax_loading');
		this_button.addClass('clicked');
		this_button.parents('.product-item').addClass('adding');
		minicart_box.foundation('open');
		setTimeout(function() {
        	minicart_box_loading.addClass('visible');
        }, 300);
		$(document.body).on('wc_cart_button_updated', function() {
			minicart_box_loading.removeClass('visible');
			this_button.parents('.product-item').removeClass('adding');
			if (this_button.siblings('.added_to_cart').length ) {
				this_button.siblings('.added_to_cart').remove();
			}
		});
	});

})(jQuery);


(function($){

	"use strict";

	// =============================================================================
	// Switch Products Appearance
	// =============================================================================

	var shop_display_grid_btn 	= $('.shop-display-type .shop-display-grid');
	var shop_display_list_btn 	= $('.shop-display-type .shop-display-list');
	var products_container 	= $('.site-main-content > ul.products');

	function shop_display_grid() {
		shop_display_list_btn.removeClass('active');
		shop_display_grid_btn.addClass('active');
		products_container.removeClass('product-list-display')
		Cookies.set("shop_display", "grid");
	}

	function shop_display_list() {
		shop_display_grid_btn.removeClass('active');
		shop_display_list_btn.addClass('active');
		products_container.addClass('product-list-display');
		Cookies.set("shop_display", "list");
	}

	shop_display_grid_btn.on('click', function() {
		requestAnimationFrame(function() {
			shop_display_grid();
			product_card_animation('reset');
		});
	});

	shop_display_list_btn.on('click', function() {
		requestAnimationFrame(function() {
			shop_display_list();
			product_card_animation('reset');
		});
	});

	if (nova_js_var.is_customize_preview == 1) {
		if(nova_js_var.shop_display == 'list') {
			shop_display_list();
		} else {
			shop_display_grid();
		}
	} else {
		switch(Cookies.get('shop_display')) {
			case 'list':
				shop_display_list();
				break;
			case 'grid':
				shop_display_grid();
				break;
			default:
				if(nova_js_var.shop_display == 'list') {
					shop_display_list();
				} else {
					shop_display_grid();
				}
		}
	}

})(jQuery);


jQuery(function($) {

	"use strict";

	window.product_card_animation = function(action, delay) {

		if (typeof action === "undefined" || action === null) action = '';
		if (typeof delay === "undefined" || delay === null) delay = 150;

		$('ul.products:not(.novaworks-carousel)').addClass('js_animated');

		if (action == 'reset') $('ul.products.js_animated li.product').removeClass('visible nova_start_animation animated');

		$('ul.products.js_animated li.product:not(.visible)').each(function() {
	    	if ( $(this).visible("partial") ) {
                $(this).addClass('visible');
			}
		});

		$('ul.products.js_animated li.product.visible:not(.nova_start_animation)').each(function(i) {
	    	$(this).addClass('nova_start_animation');
	    	$(this).delay(i*delay).queue(function(next) {
                $(this).addClass('animated');
                next();
            });
		});

		$('ul.products.js_animated li.product.visible:first').prevAll().addClass('visible').addClass('nova_start_animation').addClass('animated');

	}

	$('ul.products.js_animated').imagesLoaded( function() {
		product_card_animation();
	});

	$(window).resize(function() {
		nova_js_throttle(product_card_animation(), 300);
	});

    $(window).scroll(function() {
    	nova_js_throttle(product_card_animation(), 300);
    });

	$(document).ajaxComplete(function() {
		$('ul.products.js_animated').imagesLoaded( function() {
			product_card_animation();
		});
	});

});


(function($) {

	"use strict";

  var $loginContainer = $('.nova-login-wrapper'),
      $links = $('.register-link,.login-link');

  $links.on('click', function(e) {
    e.preventDefault();
    var _this = $(this);

    if (_this.hasClass('register-link')) {
      $('.nova-form-container', $loginContainer).addClass('register-box-active');
    } else {
      $('.nova-form-container', $loginContainer).removeClass('register-box-active');
    }

  });

})(jQuery);


(function($) {

  "use strict";
  var $window = $( window ),
      $container = $( 'div.sidebar-status.sidebar_sticky' ),
      $sidebar = $container.find( '.nova-sidebar__container' ),
      summarySticky = false;

  if ( !$container.length ) {
		return;
	}
  function stickyElm($summarySticky,$summary) {
    var $window = $( window );
    var  options = {};
    var summarySticky = $summarySticky;
    if ( nova_js_var.enable_header_sticky == '1' ) {
			var offset = $('#masthead').height(),
				$topbar = $( '#topbar' );

			if ( $topbar.length ) {
				offset += $topbar.height();
			}

			options = {
				recalc_every: 1,
				offset_top: offset
			}
		}

    if ( $window.width() > 1024 ) {
      if ( ! summarySticky ) {
        $sidebar.stick_in_parent( options );
      }
      summarySticky = true;
    } else {
      $sidebar.trigger( 'sticky_kit:detach' );
      summarySticky = false;
    }

  }
  // Sticky Sidebar
  if ( $.fn.stick_in_parent ) {
    $sidebar.on( 'sticky_kit:bottom', function() {
      $( this ).parent().css( 'position', 'static' );
    } );

    stickyElm(summarySticky,$sidebar);
    $window.on( 'resize', stickyElm(summarySticky,$sidebar)  );
  }
})(jQuery);


(function($) {

	"use strict";
	singleProductStyle3();
	function singleProductStyle3()  {
		var $product = $( 'div.product_infos.product-single-layout-style_3' );
		if ( !$product.length ) {
			return;
		}
		var $window = $( window ),
		$summary = $product.find( '.summary' ),
		summarySticky = false;

		// Init zoom for product gallery images
		if ( '1' === nova_js_var.product_image_zoom ) {
			$product.find( '.woocommerce-product-gallery .woocommerce-product-gallery__image' ).each( function() {
				zoomSingleProductImage( this );
			} );
		}
		// Sticky summary
		if ( $.fn.stick_in_parent ) {
			$summary.on( 'sticky_kit:bottom', function() {
				$( this ).parent().css( 'position', 'static' );
			} );

			stickySummary(summarySticky,$summary);

			$window.on( 'resize', stickySummary(summarySticky,$summary)  );
		}
	}
  function zoomSingleProductImage ( zoomTarget ) {
		if ( typeof wc_single_product_params == 'undefined' || !$.fn.zoom ) {
			return;
		}

		var $target = $( zoomTarget ),
			width = $target.width(),
			zoomEnabled = false;

		$target.each( function( index, target ) {
			var $image = $( target ).find( 'img' );

			if ( $image.data( 'large_image_width' ) > width ) {
				zoomEnabled = true;
				return false;
			}
		} );

		// Only zoom if the img is larger than its container.
		if ( zoomEnabled ) {
			var zoom_options = $.extend( {
				touch: false
			}, wc_single_product_params.zoom_options );

			if ( 'ontouchstart' in document.documentElement ) {
				zoom_options.on = 'click';
			}

			$target.trigger( 'zoom.destroy' );
			$target.zoom( zoom_options );
		}
	}
	/**
	 * Sticky summary
	 */
	function stickySummary($summarySticky,$summary) {
		var $window = $( window );
		var  options = {};
		var summarySticky = $summarySticky;

		if ( nova_js_var.enable_header_sticky == '1' ) {
			var offset = $('#masthead').height(),
				$topbar = $( '#topbar' );

			if ( $topbar.length ) {
				offset += $topbar.height();
			}

			options = {
				recalc_every: 1,
				offset_top: offset
			}
		}

		if ( $window.width() > 991 ) {
			if ( ! summarySticky ) {
				$summary.stick_in_parent( options );
			}
			summarySticky = true;
		} else {
			$summary.trigger( 'sticky_kit:detach' );
			summarySticky = false;
		}
	}
})(jQuery);


(function($) {

	"use strict";

})(jQuery);


(function($) {

	"use strict";

	// =============================================================================
	// Gallery Trigger
	// =============================================================================
	if ( typeof wc_single_product_params === 'undefined' || wc_single_product_params.photoswipe_enabled !== '1' ) {
		return;
	}
	$( '.woocommerce-product-gallery' ).on( 'click', '.zoomImg', function() {
		if ( wc_single_product_params.flexslider_enabled ) {
			$( this ).closest( '.woocommerce-product-gallery' ).children( '.woocommerce-product-gallery__trigger' ).trigger( 'click' );
		} else {
			$( this ).prev( 'a' ).trigger( 'click' );
		}
	} );

})(jQuery);


(function($) {

	"use strict";

	// =============================================================================
	// Select2
	// =============================================================================

	if ( typeof $.fn.select2 === 'function' ) {
		$('.variations_form select').select2({
			minimumResultsForSearch: -1,
			placeholder: nova_js_var.select_placeholder,
			allowClear: true,
		});
	}

})(jQuery);


(function($) {
	
	"use strict";

	$(document).ready(function() {

		$(".single-product .product .cart .woocommerce-product-details__add-to-cart #wc-stripe-payment-request-button-separator").css("display", "none");
		$(".single-product .product .cart .woocommerce-product-details__add-to-cart #wc-stripe-payment-request-wrapper").css("display", "none");

		setTimeout(function(){
			if($(".single-product .product .cart .woocommerce-product-details__add-to-cart .StripeElement").children().length > 0) {
				$(".single-product .product .cart .woocommerce-product-details__add-to-cart").addClass("stripe-button");
				$(".single-product .product .cart .woocommerce-product-details__add-to-cart #wc-stripe-payment-request-button-separator").css("display", "block");
				$(".single-product .product .cart .woocommerce-product-details__add-to-cart #wc-stripe-payment-request-wrapper").css("display", "block");
			}
		},1000);

	});

})(jQuery);

(function($) {
	
	"use strict";

	var add_to_wishlist_button = $('.add_to_wishlist');

	add_to_wishlist_button.on('click',function(){
		$(this).parents('.yith-wcwl-add-button').addClass('loading');
	});

})(jQuery);

(function($) {

	"use strict";

	$('body')
		// Review link
		.on( 'click', 'a.woocommerce-review-link', function() {
			$(".nova-product-info-mn .panel_reviews a").trigger("click");
			setTimeout(function(){
				var tag = $("#reviews");
	    		$('html,body').animate({scrollTop: tag.offset().top},'slow');
    		}, 300);
			return true;
		} );

})(jQuery);


(function($) {
	
	"use strict";

	$(window).load(function() {

		$(window).scroll(function() {

			var scrollTop = $(window).scrollTop();
			var docHeight = $(document).height();
			var winHeight = $(window).height();
			var scrollPercent = (scrollTop) / (docHeight - winHeight);
			var scrollPercentRounded = Math.round(scrollPercent*100);

			$(".scroll-progress-bar").css( "width", scrollPercentRounded + "%" );

		});

	});

})(jQuery);

jQuery(function($) {

	"use strict";

	//===============================================================
	// Add (+/-) Button Number Incrementers
	//==============================================================
	$( document.body ).on( 'updated_cart_totals', function(){
		$(".quantity").append('<div class="qty-button inc">+</div><div class="qty-button dec">-</div>');
		$(".qty-button").on("click", function() {

			var $button = $(this);
			var oldValue = $button.parent().find("input").val();

			if ($button.text() == "+") {
				var newVal = parseFloat(oldValue) + 1;
			} else {
			 // Don't allow decrementing below zero
				if (oldValue > 0) {
					var newVal = parseFloat(oldValue) - 1;
				} else {
					newVal = 0;
				}
			}

			$button.parent().find("input").val(newVal);
			$( '.woocommerce-cart-form :input[name="update_cart"]' ).prop( 'disabled', false );
		});
	});
});


jQuery(function($) {

	"use strict";

	if ( ( $('.woocommerce-checkout').length ) && ( $('.woocommerce-form-login').length ) ) {

		 $('body.woocommerce-checkout .showlogin').on('click', function() {
		 	if($('.woocommerce-form-login').hasClass('show')) {
				$('.woocommerce-form-login').removeClass('show');
			 } else {
			 	setTimeout( function() {
					$('.woocommerce-form-login').addClass('show');
				}, 300);
			 }
		});

	}
});


(function($){

	"use strict";


})(jQuery);


(function($){

	"use strict";

	$('.product-categories-with-icon').on('click', '.cat-parent .dropdown_icon', function() {
		$(this).parent().toggleClass('active-item');
		$(this).siblings("ul.children").slideToggle('300', function() {
		});
	});

	// If there is more than 8 categories than add scroll class
	// If the user is inside the category, keep the widget category open
	
	$('.product-categories-with-icon .cat-item').each(function() {

		var max_subcategory_nr 		= 8
		var subcategory_nr 			= $(this).find("ul.children").find('li').length;

		if ( subcategory_nr > max_subcategory_nr ) {
			$(this).find("ul.children").addClass('add_scroll');
		} 

		if ( $(this).hasClass('current-cat') ) {
			$(this).addClass('active-item');
			$(this).find("ul.children").show();
		}

		if ( $(this).hasClass('current-cat-parent') ) {
			$(this).addClass('active-item');
			$(this).find("ul.children").show();
		}

		if ( $(this).hasClass('cat-parent') ) {
			if ( ! $(this).find('i').length ) {
				$(this).addClass('no-icon');
			}
		}
		
	});


})(jQuery);


jQuery(function($) {

    "use strict";

    $('body').imagesLoaded().always(function(instance) {
		setTimeout(function() {

			if ( $('.blog-hero-slider').length ) {

				var interleaveOffset = 0.5;
				var interleaveOffsetCaption = 1;

				// Caption
				var BloghalfSliderCaption = new Swiper('.blog-hero-slider__caption', {
				slidesPerView: 1,
				loop: true,
				effect: 'fade',
				direction: 'vertical',
				parallax: false,
				speed: 1500,
				simulateTouch: false
				});

				// Image
				var BloghalfSliderImage = new Swiper('.blog-hero-slider__image', {
				slidesPerView: 1,
				loop: true,
				pagination: {
				el: '.swiper-pagination-num',
				type: 'fraction',
				clickable: true
				},
				autoplay: {
				disableOnInteraction: false,
				},
				speed: 1500,
				direction: 'vertical',
				simulateTouch: false,
				roundLengths: true,
				keyboard: true,
				mousewheel: true,
				parallax: true,
				navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev'
				},
				on: {
				progress: function() {
				var swiper = this;
				for (var i = 0; i < swiper.slides.length; i++) {
				var slideProgress = swiper.slides[i].progress;
				var innerOffset = swiper.height * interleaveOffset;
				var innerTranslate = slideProgress * innerOffset;
				swiper.slides[i].querySelector('.cover-slider').style.transform =
				'translateY(' + innerTranslate + 'px)';
				}
				},
				touchStart: function() {
				var swiper = this;
				for (var i = 0; i < swiper.slides.length; i++) {
				swiper.slides[i].style.transition = '';
				}
				},
				setTransition: function(speed) {
				var swiper = this;
				for (var i = 0; i < swiper.slides.length; i++) {
				swiper.slides[i].style.transition = speed + 'ms';
				swiper.slides[i].querySelector('.cover-slider').style.transition =
				speed + 'ms';
				}
				}
				}
				});

				BloghalfSliderCaption.controller.control = BloghalfSliderImage;
				BloghalfSliderImage.controller.control = BloghalfSliderCaption;
			}

		}, 2500);
    });
});


jQuery(function($) {

	"use strict";
	$( ".js-video-popup-btn" ).each(function() {
		$(this).videoPopup({
			autoplay: 1,
			controlsColor: 'white',
			showVideoInformations: 0,
			showControls: false,
			width: 1000,
		});
	});
	$('.blog-layout-5 .blog-articles').imagesLoaded( function() {
		$('.blog-layout-5 .blog-articles').isotope({
			// options
			itemSelector: 'article',
			layoutMode: 'fitRows'
		});
	});

});
 


jQuery(function($) {

	"use strict";

});


jQuery(function($) {

  "use strict";
  
	var defaultConfig = {
		rootMargin: '0px',
		threshold: 0.1,
		load: function load(element) {

			var base_src = element.getAttribute('data-src') || element.getAttribute('data-lazy') || element.getAttribute('data-lazy-src') || element.getAttribute('data-lazy-original'),
				base_srcset = element.getAttribute('data-src') || element.getAttribute('data-lazy-srcset'),
				base_sizes = element.getAttribute('data-sizes') || element.getAttribute('data-lazy-sizes');

			if (base_src) {
				element.src = base_src;
			}
			if (base_srcset) {
				element.srcset = base_srcset;
			}
			if (base_sizes) {
				element.sizes = base_sizes;
			}
			if (element.getAttribute('data-background-image')) {
				element.style.backgroundImage = 'url(' + element.getAttribute('data-background-image') + ')';
			}
			if (element.getAttribute('data-auto-padding') == 'true') {
				getimgMeta(
					element.getAttribute('data-background-image'),
					function(width, height) {

						element.style.paddingBottom = (height / width) * 100 + '%';
					}
				);
			}
		}
	};

	function getimgMeta(url, callback) {
		var img = new Image();
		img.src = url;
		img.onload = function() {
			callback(this.width, this.height);
		}
	}

	function markAsLoaded(element) {
		element.setAttribute('data-element-loaded', true);
	}

	var isLoaded = function isLoaded(element) {
		return element.getAttribute('data-element-loaded') === 'true';
	};
	var onIntersection = function onIntersection(load) {
		return function(entries, observer) {
			entries.forEach(function(entry) {
				if (entry.intersectionRatio > 0) {
					observer.unobserve(entry.target);

					if (!isLoaded(entry.target)) {
						load(entry.target);
						markAsLoaded(entry.target);
					}
				}
			});
		};
	};
  window.CustomLazyLoad = function() {
    var selector = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : false;
    var options = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : {};

    var _defaultConfig$option = $.extend({}, defaultConfig, options),
      rootMargin = _defaultConfig$option.rootMargin,
      threshold = _defaultConfig$option.threshold,
      load = _defaultConfig$option.load;

    var observer = void 0;

    if (window.IntersectionObserver) {
      observer = new IntersectionObserver(onIntersection(load), {
        rootMargin: rootMargin,
        threshold: threshold
      });
    }

    return {
      triggerSingleLoad: function triggerSingleLoad() {
        if (!$.exists(selector)) {
          return;
        }
        var element = selector.get(0);
        if (isLoaded(element)) {
          return;
        }
        if (observer) {
          observer.observe(element);
          return;
        }
        load(element);
        markAsLoaded(element);

      },
      observe: function observe() {
        if (!$.exists(selector)) {
          return;
        }
        for (var i = 0; i < selector.length; i++) {
          if (isLoaded(selector[i])) {
            continue;
          }
          if (observer) {
            observer.observe(selector[i]);
            continue;
          }
          load(selector[i]);
          markAsLoaded(selector[i]);
        }
      },
      triggerLoad: function triggerLoad(element) {
        if (isLoaded(element)) {
          return;
        }
        load(element);
        markAsLoaded(element);
      }
    };
  };
	CustomLazyLoad($('.nova-lazyload-image')).observe();
})


jQuery(function($) {

	"use strict";
	
window.ajax_load_shortcode = function( el ){
	var $this = $(el),
			query = $this.data('query-settings'),
			product_type = $this.data('product-type'),
			nonce = $this.data('public-nonce'),
			requestData = {
					action : 'nova_get_shortcode_loader_by_ajax',
					data 	: query,
					type	:	product_type,
					_vcnonce : nonce
		};
		var init = function(){
				nova_lazyload($this, {
					rootMargin: '200px',
					load : setup_ajax
				}).observe();
		};

		var setup_ajax = function() {
			if($this.hasClass('is-loading') || $this.hasClass('has-loaded')){
					return;
			}
			$this.addClass('is-loading');
			var _ajax_option = {
					url : nova_ajax_url,
					method: "POST",
					dataType: "html",
					data : requestData
			};
			$.ajax(_ajax_option).done(function(response_data){
				var $data = $(response_data);
				$(document).trigger('NOVA:AjaxLoadShortCode:before_render',[$this,$data]);
				$this.removeClass('is-loading');
				$this.addClass('has-loaded');
				$data.appendTo($this);
				$this.find('.product-item__thumbnail-placeholder.second_image_enabled').addClass('second_image_loaded');
				$(document).trigger('NOVA:AjaxLoadShortCode:after_render',[$this,$data]);
			});
		};

		return init();
}
$( ".elm-ajax-loader" ).each(function() {
	ajax_load_shortcode(this);
});

});


jQuery(function($) {

	"use strict";

	var listing_class 		= ".blog-articles";
	var item_class 			= ".blog-articles article";
	var pagination_class 	= ".posts-navigation";
	var next_page_class 	= ".posts-navigation .nav-previous a";
	var ajax_button_class 	= ".posts_ajax_button";
	var ajax_loader_class 	= ".posts_ajax_loader";

	var ajax_load_items = {

	    init: function() {

	        if (nova_js_var.blog_pagination_type == 'load_more_button' || nova_js_var.blog_pagination_type == 'infinite_scroll') {

		        $(document).ready(function() {

		            if ($(pagination_class).length) {

		                $(pagination_class).before('<div class="pagination-container"><div class="'+ajax_button_class.replace('.', '')+'" data-processing="0"><span class="button">'+nova_js_var.load_more_btn+'<span></div></div>');

		            }

		        });

		        $('body').on('click', ajax_button_class, function() {

		            if ($(next_page_class).length) {

		                $(ajax_button_class).attr('data-processing', 1).addClass('loading');

		                var href = $(next_page_class).attr('href');

		                if( ! ajax_load_items.msieversion() ) {
							history.pushState(null, null, href);
						}

		                ajax_load_items.onstart();

		                $.get(href, function(response) {

		                    $(pagination_class).html($(response).find(pagination_class).html());

		                    $(response).find(item_class).each(function() {

		                        $('.blog-articles > article:last').after($(this));

		                    });

		                    $(ajax_button_class).attr('data-processing', 0).removeClass('loading');

		                    ajax_load_items.onfinish();

		                    if ($(next_page_class).length == 0) {
		                        $(ajax_button_class).addClass('disabled').show();
		                    } else {
		                    	$(ajax_button_class).show();
		                    }

		                });

		            } else {

		                $(ajax_button_class).addClass('disabled').show();

		            }

		        });

	        }

	        if (nova_js_var.blog_pagination_type == 'infinite_scroll') {

		        var buffer_pixels = Math.abs(0);

		        $(window).scroll(function() {

		            if ($(listing_class).length) {

		                var a = $(listing_class).offset().top + $(listing_class).outerHeight();
		                var b = a - $(window).scrollTop();

		                if ((b - buffer_pixels) < $(window).height()) {
		                    if ($(ajax_button_class).attr('data-processing') == 0) {
		                        $(ajax_button_class).trigger('click');
		                    }
		                }

		            }

		        });
	        }
	    },

	    onstart: function() {
	    },

	    onfinish: function() {
	    },

	    msieversion: function() {
	        var ua = window.navigator.userAgent;
	        var msie = ua.indexOf("MSIE ");

	        if (msie > 0)
	            return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)));

	        return false;
	    },

	};

	ajax_load_items.init();
	//ajax_load_items.onfinish();

});


jQuery(function($) {

	"use strict";

	var listing_class 		= ".products";
	var item_class 			= ".products > .product";
	var pagination_class 	= "body.woocommerce-shop .woocommerce-pagination";
	var next_page_class 	= ".woocommerce-pagination a.next";
	var ajax_button_class 	= ".products_ajax_button";
	var ajax_loader_class 	= ".products_ajax_loader";
	var loadmore_text = nova_js_var.load_more_btn;

	var ajax_load_items = {

	    init: function() {

	        if (nova_js_var.shop_pagination_type == 'load_more_button' || nova_js_var.shop_pagination_type == 'infinite_scroll') {

		        $(document).ready(function() {

		            if ($(pagination_class).length) {

		                $(pagination_class).before('<div class="'+ajax_button_class.replace('.', '')+'" data-processing="0"><span>'+loadmore_text+'</span></div>');

		            }

		        });

		        $('body').on('click', ajax_button_class, function() {

		            if ($(next_page_class).length) {

		                $(ajax_button_class).attr('data-processing', 1).addClass('loading');

		                var href = $(next_page_class).attr('href');

		                ajax_load_items.onstart();

		                $.get(href, function(response) {

		                    $(pagination_class).html($(response).find(".woocommerce-pagination").html());

		                    $(response).find(item_class).each(function(i) {

		                    	$(this).find('.product-item__thumbnail-placeholder.second_image_enabled').addClass('second_image_loaded');

		                        $(listing_class).append($(this));

		                    });

		                    $(ajax_button_class).attr('data-processing', 0).removeClass('loading');

		                    ajax_load_items.onfinish();

		                    if ($(next_page_class).length == 0) {
		                        $(ajax_button_class).addClass('disabled').show();
		                    } else {
		                    	$(ajax_button_class).show();
		                    }
		                });

		            } else {

		                $(ajax_button_class).addClass('disabled').show();

		            }

		        });

	        }

	        if (nova_js_var.shop_pagination_type == 'infinite_scroll') {

		        var buffer_pixels = Math.abs(100);

		        $(window).scroll(function() {

		            if ($(listing_class).length) {

		                var a = $(listing_class).offset().top + $(listing_class).outerHeight();
		                var b = a - $(window).scrollTop();

		                if ((b - buffer_pixels) < $(window).height()) {
		                    if ($(ajax_button_class).attr('data-processing') == 0) {
		                        $(ajax_button_class).trigger('click');
		                    }
		                }

		            }

		        });

	        }

	    },

	    onstart: function() {
	    },

	    onfinish: function() {

	    },

	    msieversion: function() {
	        var ua = window.navigator.userAgent;
	        var msie = ua.indexOf("MSIE ");

	        if (msie > 0)
	            return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)));

	        return false;
	    },

	};
	ajax_load_items.init();
	//ajax_load_items.onfinish();

});


jQuery(function($) {

  "use strict";

  function product_quick_view_ajax(id) {

    $.ajax({

      url: nova_ajax_url,

      data: {
        "action": "nova_product_quick_view",
        'product_id': id
      },

      success: function(results) {
        $(".nova_wc_quickview__content").empty().html(results);
        $("body").removeClass("progress");
        $("body").addClass("quickview-loaded");
        if (typeof $.fn.select2 === 'function') {
          $('#nova_wc_quickview .variations_form select').select2({
            minimumResultsForSearch: -1,
            placeholder: nova_js_var.select_placeholder,
            allowClear: true,
          });
        }
        if ($('.qv-carousel').length > 0) {
          $('.qv-carousel').slick();
        }
        //Active custom scrollBars
        nova_custom_scrollbar( $('#nova_wc_quickview .nova_wc_quickview__content .site-content .product .box-summary-wrapper') );

				$('#nova_wc_quickview .woocommerce-product-details__short-description').showMore({
						minheight: 100,
						buttontxtmore: nova_js_var.read_more_btn,
						buttontxtless: nova_js_var.read_less_btn,
						animationspeed: 250
				});
        setTimeout(function() {
          $('#nova_wc_quickview .variations_form').each(function() {
            $(this).wc_variation_form();
          });
        }, 1100);

        setTimeout(function() {
          $('#nova_wc_quickview .woocommerce-product-gallery').wc_product_gallery();
        }, 1000);

        setTimeout(function() {
          $(document.body).trigger('opened_product_quickview');
          $('#nova_wc_quickview').addClass('open');
        }, 500);

        setTimeout(function() {
          $('#nova_wc_quickview .nova_wc_quickview__content').addClass('maybe_scroll');
        }, 1200);
      },

    });
  }

  function close_quickview_modal() {
    $("body").removeClass("quickview-loaded");
    $('#nova_wc_quickview').removeClass('open');
    $('#nova_wc_quickview .nova_wc_quickview__content').removeClass('maybe_scroll');
    $('#nova_wc_quickview .nova_wc_quickview__content').empty();
    $(document.body).trigger('closed_product_quickview');
  }

  $('.site-content').on('click', '.nova_product_quick_view_btn', function(e) {
    e.preventDefault();
    close_quickview_modal();
    var product_id = $(this).data('product-id');
    product_quick_view_ajax(product_id);
  });

  $('#nova_wc_quickview').on('click', function(e) {
    var containers = [
      ".nova_wc_quickview__content"
    ];

    var container = $(containers.join(", "));

    if (!container.is(e.target) && container.has(e.target).length === 0) {
      close_quickview_modal();
    }
  });

  $('#nova_wc_quickview').on('click', 'button.close-button', function(e) {
    close_quickview_modal();
  });
});


jQuery(function($) {

	"use strict";

	//=============================================================================
	//  yith wishlist counter
	//=============================================================================

	function getCookie(name) {
	    var dc = document.cookie;
	    var prefix = name + "=";
	    var begin = dc.indexOf("; " + prefix);
	    if (begin == -1) {
	        begin = dc.indexOf(prefix);
	        if (begin != 0) return null;
	    }
	    else
	    {
	        begin += 2;
	        var end = document.cookie.indexOf(";", begin);
	        if (end == -1) {
	        end = dc.length;
	        }
	    }
	    // because unescape has been deprecated, replaced with decodeURI
	    //return unescape(dc.substring(begin + prefix.length, end));
	    return decodeURIComponent(decodeURIComponent((dc.substring(begin + prefix.length, end))));
	}

	function nova_update_wishlist_count(count) {
		if ( ( typeof count === "number" && isFinite(count) && Math.floor(count) === count ) && count >=0 ) {
			$('.js-count-wishlist-item').html(count);
		}
	}

	if ($('.js-count-wishlist-item').length ) {


		var wishlistCounter = 0;

		/*
		**	Check for Yith cookie
		*/
		var wlCookie = getCookie("yith_wcwl_products");

		if ( wlCookie != null ) {
            wlCookie = wlCookie.slice(0, wlCookie.indexOf(']') + 1);
			var products = JSON.parse(wlCookie);
			wishlistCounter =  Object.keys(products).length;
		} else 	{
			wishlistCounter = Number($('.js-count-wishlist-item').html());
		}

		/*
		**	Increment counter on add
		*/
		$('body').on( 'added_to_wishlist' , function(){
			wishlistCounter++;
			nova_update_wishlist_count(wishlistCounter);
		});

		/*
		**	Decrement counter on remove
		*/
		$('body').on( 'removed_from_wishlist' , function(){
			wishlistCounter--;
			nova_update_wishlist_count(wishlistCounter);
		});

		nova_update_wishlist_count(wishlistCounter);

	}

	//=============================================================================
	//  END yith wishlist counter
	//=============================================================================

});


jQuery(function($) {

	"use strict";


});


jQuery(function($) {

    "use strict";

    function getSuggestions() {


        var keyword=  $('.header_search_form input.header_search_input').val();
        var category= $('.header_search_form select.header_search_select').val();



        if (keyword.length >= 3 && keyword != keydown) {
            $.xhrPool.abortAll();
            $('.header_search_ajax_results').addClass('loading');
            $('.header_search_ajax_loading').addClass('visible');
            $('.header_search_button_wrapper').addClass('btn-loading');

            if ( search_cache[keyword+category] !== undefined) {
                $('.header_search_ajax_results').html('<div class="ajax_results_wrapper">' + search_cache[keyword+category] + '</div>');
                $('.header_search_ajax_results').removeClass('loading');
                $('.header_search_ajax_loading').removeClass('visible');
                $('.header_search_button_wrapper').removeClass('btn-loading');
            } else {
                $.ajax({
                    type: 'GET',
                    url: nova_ajax_url,
                    cache: true,
                    data: {
                        "action" : "nova_ajax_url",
                        "search_keyword"    : keyword,
                        "search_category"   : category
                    },
                    dataType: "json",
                    contentType: "application/json",
                    success: function( results ) {
                        search_cache[keyword+category]= results.suggestions;
                        $('.header_search_ajax_results').html('<div class="ajax_results_wrapper">' + results.suggestions + '</div>');
                        $('.header_search_ajax_results').removeClass('loading');
                        $('.header_search_ajax_loading').removeClass('visible');
                        $('.header_search_button_wrapper').removeClass('btn-loading');
                    },

                    always: function( results ) {
                       $('.header_search_ajax_results').removeClass('loading');
                       $('.header_search_ajax_loading').removeClass('visible');
                       $('.header_search_button_wrapper').removeClass('btn-loading');
                    }
                });
            }
        }
    };

    $.xhrPool = [];
    $.xhrPool.abortAll = function() {
        $(this).each(function(i, jqXHR) {   //  cycle through list of recorded connection
            jqXHR.abort();  //  aborts connection
            $.xhrPool.splice(i, 1); //  removes from list by index
        });
    }
    $.ajaxSetup({
        beforeSend: function(jqXHR) { $.xhrPool.push(jqXHR); }, //  annd connection to list
        complete: function(jqXHR) {
            var i = $.xhrPool.indexOf(jqXHR);   //  get index for current connection completed
            if (i > -1) $.xhrPool.splice(i, 1); //  removes from list by index
        }
    });

    var search_cache=  new Array;

    var keydown  = $('.header_search_form input.header_search_input').val();

    $('input.header_search_input').on('keydown', function(e) {
        keydown = $(this).val();
    })

    $('input.header_search_input').on('keyup focus', function(e) {
        getSuggestions();
    });

    $('select.header_search_select').change(function() {
        var keyword=  $('.header_search_form input.header_search_input').val();

        if ( keyword.length >= 3 ) {
            getSuggestions();
            $('input.header_search_input').click();
        }
    });

    $('form.header_search_form').on('click', 'span.view-all a', function(){
        $(this).parents('form.header_search_form').submit();
    })
})


jQuery(function($) {
	
	"use strict";

	$('.reveal').on('click', '.next', function(){
		var next = $(this).parent('.reveal').next('.reveal').attr('id');
		if (next) {
			next = '#' + next;
			$(next).foundation('open');
		}
	});

	$('.reveal').on('click', '.prev', function(){
		var prev = $(this).parent('.reveal').prev('.reveal').attr('id');
		if (prev) {
			prev = '#' + prev;
			$(prev).foundation('open');
		}
	});

	if ($('.reveal.gb-gallery').length) {
		$('.reveal.gb-gallery:first').find('.gb-gallery-btn.prev').hide();
		$('.reveal.gb-gallery:last').find('.gb-gallery-btn.next').hide();
	}
})

jQuery(function($) {

	"use strict";

	window.nova_slider = function(carousel){

		var $slider = $(carousel),
				options =  $slider.data('settings') || {};

		var init = function(){
				setup_slider();
		};

		var setup_slider = function(){

			var slider_autoplay, slider_autoplay_delay, slide_autoplay_on_hover, slider_loop, slide_duration, captionOptions = {}, imageOptions = {};
			slider_autoplay = options.autoplay;
			slider_autoplay_delay = options.autoplayDelay;
			slide_autoplay_on_hover = options.autoplayHover;
			slider_loop = options.loop;
			slide_duration = options.speed;
			//settings for caption slider
			captionOptions['slidesPerView'] = 1;
			captionOptions['loop'] = slider_loop;
			captionOptions['effect'] = 'fade';
			captionOptions['parallax'] = true;
			captionOptions['speed'] = slide_duration;
			captionOptions['simulateTouch'] = false;
			//settings for image slider
			imageOptions['slidesPerView'] = 1;
			imageOptions['loop'] = slider_loop;
			imageOptions['pagination'] = {
				el: '.swiper-pagination',
				type: 'fraction',
				clickable: true
			};
			imageOptions['autoplay'] = slider_autoplay ? { delay: slider_autoplay_delay, disableOnInteraction: false } : false;
			imageOptions['speed'] = slide_duration;
			imageOptions['simulateTouch'] = false;
			imageOptions['roundLengths'] = true;
			imageOptions['keyboard'] = true;
			imageOptions['mousewheel'] = false;
			imageOptions['parallax'] = true;
			imageOptions['navigation'] = {
				nextEl: '.nova-slider-button-next',
				prevEl: '.nova-slider-button-prev'
			};

			$slider.imagesLoaded().always( function( instance ) {

				// Half slider
				var interleaveOffset = 0.5;
				var novaSliderCaption = new Swiper($('.slider__caption',$slider), captionOptions);

				imageOptions = $.extend({}, imageOptions, {
					on: {
						progress: function() {
							var swiper = this;
							for (var i = 0; i < swiper.slides.length; i++) {
								var slideProgress = swiper.slides[i].progress;
								var innerOffset = swiper.width * interleaveOffset;
								var innerTranslate = slideProgress * innerOffset;
								swiper.slides[i].querySelector('.cover-slider').style.transform =
								'translateX(' + innerTranslate + 'px)';
							}
						},
						touchStart: function() {
							var swiper = this;
							for (var i = 0; i < swiper.slides.length; i++) {
								swiper.slides[i].style.transition = '';
							}
						},
						setTransition: function(speed) {
							var swiper = this;
							for (var i = 0; i < swiper.slides.length; i++) {
								swiper.slides[i].style.transition = speed + 'ms';
								swiper.slides[i].querySelector('.cover-slider').style.transition =
								speed + 'ms';
							}
						},
						slideChangeTransitionStart: function() {
							$('.slider-nav__path-progress',$slider).css({'transition': slide_duration+'ms','stroke-dashoffset': '0'});
						},
						slideChangeTransitionEnd: function() {
							$('.slider-nav__path-progress',$slider).css({'transition': '0ms','stroke-dashoffset': '141'});
						}
					}
				});

				var novaSliderImage = new Swiper($('.slider__image',$slider), imageOptions);

				novaSliderCaption.controller.control = novaSliderImage;
				novaSliderImage.controller.control = novaSliderCaption;

				if(slide_autoplay_on_hover != 'none'){

					if(slide_autoplay_on_hover == 'pause' || 'stop' ) {
						$slider.on("mouseover", function( e ) {
							novaSliderCaption.autoplay.stop();
							novaSliderImage.autoplay.stop();
						});
					}
					if(slide_autoplay_on_hover == 'pause'){
						$slider.on("mouseleave", function( e ) {
							novaSliderCaption.autoplay.start();
							novaSliderImage.autoplay.start();
						});
					}
				}

			});

		};

		return init();
	};

	if($('.shortcode_nova_slider').length > 0) {
		var shortcode_nova_slider = $('.shortcode_nova_slider');
		shortcode_nova_slider.each(function(){
				nova_slider($(this));
		});
	}

});


jQuery(function($) {

	"use strict";

	function NovaVericalSlider() {
		if( $('.shortcode_nova_vertical_slider').length > 0 ){
			var titles = [];
			var subtitle = [];
			var presets = [];
			$('.shortcode_nova_vertical_slider .swiper-slide').each(function(i) {
					titles.push($(this).data('title'));
					subtitle.push($(this).data('subtitle'));
					presets.push($(this).data('preset'));
			});
		var interleaveOffset = 0.4;
		var swiperOptions = {
			direction: "vertical",
			loop: false,
			grabCursor: true,
			resistance : true,
			resistanceRatio:0.5,
			slidesPerView: 1,
			watchSlidesProgress: true,
			allowTouchMove:true,
			speed:900,
			autoplay: false,
			effect: "slide",
			mousewheel: true,
			pagination: {
				el: '.showcase-captions',
				clickable: true,
				renderBullet: function (index, className) {
					return '<div class="outer ' + className + ' ' + presets[index] + '">' + '<div class="inner">' + '<div class="nova-vs-subtitle">' + subtitle[index] + '</div>' +  '<div class="scale-wrapper">' + '<div class="nova-vs-title">' + '<div>' + titles[index] + '</div>' + '</div>' + '</div>' + '</div>' + '</div>';

				},
			},
			navigation: {
				nextEl: '.swiper-button-next',
				prevEl: '.swiper-button-prev',
			},
			on: {
				progress: function() {
						var swiper = this;
						for (var i = 0; i < swiper.slides.length; i++) {
							var slide = swiper.slides[i];
							var slideProgress = slide.progress;
							console.log(slideProgress);
							var innerOffset = swiper.height * interleaveOffset;
							var innerTranslate = slideProgress * innerOffset;
							slide.querySelector(".slide-img-holder").style.transform = "translate3d(0, " + innerTranslate + "px,0)";
						}

					},
					touchStart: function() {
						var swiper = this;
						for (var i = 0; i < swiper.slides.length; i++) {
							swiper.slides[i].style.transition = "";
						}
					},
					setTransition: function(speed) {
						var swiper = this;
						for (var i = 0; i < swiper.slides.length; i++) {
							swiper.slides[i].style.transition = speed + "ms";
							swiper.slides[i].querySelector(".slide-img-holder").style.transition = speed + "ms";
						}
				 	},
					init: function () {
						$('.swiper-slide-active').find('video').each(function() {
							$(this).get(0).play();
						});
					},
					slideChangeTransitionStart: function () {

						var prevslidetitle = new TimelineLite();
						prevslidetitle.staggerTo($('.swiper-pagination-bullet-active').prev().find('.nova-vs-title span').sort(() => Math.round(Math.random())-0.5), 0.5, {scaleY:2, y:-200, opacity:0, ease:Power2.easeInOut},  0.02)

						var prevslidecaption = new TimelineLite();
						prevslidecaption.staggerTo($('.swiper-pagination-bullet-active').prev().find('.nova-vs-subtitle'), 0.3, {y:-40, opacity:0, delay:0, ease:Power2.easeIn},  -0.02)

						var activeslidetitle = new TimelineLite();
						activeslidetitle.staggerTo($('.swiper-pagination-bullet-active').find('.nova-vs-title span').sort(() => Math.round(Math.random())-0.5), 0.5, {scaleY:1, y:0, opacity:1, scale:1, delay:0.3, ease:Power2.easeOut}, 0.02)

						var activeslidecaption = new TimelineLite();
						activeslidecaption.staggerTo($('.swiper-pagination-bullet-active').find('.nova-vs-subtitle'), 0.5, {y:0, opacity:1, scale:1, delay:0.5, ease:Power2.easeOut}, -0.02)

						var nextslidetitle = new TimelineLite();
						nextslidetitle.staggerTo($('.swiper-pagination-bullet-active').next().find('.nova-vs-title span').sort(() => Math.round(Math.random())-0.5), 0.5, {scaleY:2, y:200, opacity:0, ease:Power2.easeInOut},  0.02)

						var nextslidecaption = new TimelineLite();
						nextslidecaption.staggerTo($('.swiper-pagination-bullet-active').next().find('.nova-vs-subtitle'), 0.3, {y:40, opacity:0, delay:0, ease:Power2.easeIn},  -0.02)

						$('.swiper-slide-active').find('video').each(function() {
							$(this).get(0).play();
						});

					},
					slideChangeTransitionEnd: function () {

						$('.swiper-slide-prev').find('video').each(function() {
							$(this).get(0).pause();
						});

						$('.swiper-slide-next').find('video').each(function() {
							$(this).get(0).pause();
						});

					}
			},

		};
		$('.slide-img-thumbnail').each(function() {
			var image = $(this).data('src');
			$(this).css({'background-image': 'url(' + image + ')'});
		});
		var swiper = new Swiper(".shortcode_nova_vertical_slider", swiperOptions);

		//Slide Captions
		$('.showcase-captions-wrap .nova-vs-title').each(function(){
			var words = $(this).text().slice(" ");
			var total = words.length;
			$(this).empty();
			for (var index = 0; index < total; index ++){
				$(this).append($("<span /> ").text(words[index]));
			}
		});
		$("#showcase-slider .swiper-slide").find(".nova-vs-title").each(function(i) {
			$(this).wrap( "<div class='outer'><div class='inner'></div></div>" );
		});
		//Sart show slider
		TweenMax.set($("#showcase-holder"), {opacity:0, scale:1.05});
		TweenMax.to($("#showcase-holder"), 0.4, {force3D:true, opacity:1, scale:1, delay:0.8, ease:Power2.easeOut});
		// Add new footer
		$("footer").addClass("showcase-footer")
	}
}
NovaVericalSlider();
});


(function($) {

	"use strict";

	// =============================================================================
	// Select2
	// =============================================================================

	if ( typeof $.fn.select2 === 'function' ) {
		$('.wpcf7 select').select2({
			minimumResultsForSearch: -1,
			placeholder: nova_js_var.select_placeholder,
			allowClear: true,
			containerCssClass: "select2_no_border",
			dropdownCssClass: "select2_no_border"
		});
	}

})(jQuery);


jQuery(function($) {

	"use strict";

		window.nova_slick_slider = function(carousel){

			var $slider = $(carousel),
					options =  $slider.data('slider_config') || {};

			var init = function(){
					setup_slick();
			};

			var setup_slick = function(){
					var laptopSlides, tabletPortraitSlides, tabletSlides, mobileSlides, mobilePortraitSlides, defaultOptions, slickOptions;
					laptopSlides = parseInt(options.slidesToShow.laptop) || 1;
					tabletSlides = parseInt(options.slidesToShow.tablet) || 1;
					tabletPortraitSlides = parseInt(options.slidesToShow.tabletportrait) || 1;
					mobileSlides = parseInt(options.slidesToShow.mobile) || 1;
					mobilePortraitSlides = parseInt(options.slidesToShow.mobileportrait) || 1;
					options.slidesToShow = parseInt(options.slidesToShow.desktop) || 1;

					defaultOptions = {

							responsive: [
									{
											breakpoint: 1336,
											settings: {
													slidesToShow: laptopSlides,
													slidesToScroll: options.slidesToScroll
											}
									},
									{
											breakpoint: 1025,
											settings: {
													slidesToShow: tabletSlides,
													slidesToScroll: tabletSlides
											}
									},
									{
											breakpoint: 769,
											settings: {
													slidesToShow: tabletPortraitSlides,
													slidesToScroll: tabletPortraitSlides
											}
									},
									{
											breakpoint: 481,
											settings: {
													slidesToShow: mobileSlides,
													slidesToScroll: mobileSlides
											}
									},
									{
											breakpoint: 361,
											settings: {
													slidesToShow: mobilePortraitSlides,
													slidesToScroll: mobilePortraitSlides
											}
									}
							]
					};
					$slider.on('init', function(e, slick){
							if(slick.slideCount <= slick.options.slidesToShow){
									slick.$slider.addClass('hidden-dots');
							}
							else{
									slick.$slider.removeClass('hidden-dots');
							}
							if(slick.options.centerMode){
									slick.$slider.addClass('nova-slick-centerMode');
							}
					});
					slickOptions = $.extend( {}, defaultOptions, options );
					$slider.not('.slick-initialized').slick( slickOptions );
			};

			return init();

	};
	if($('.slick-carousel').length > 0) {
		var slick_carousel = $('.slick-carousel');
		slick_carousel.each(function(){
				nova_slick_slider($(this));
		});
	}
})


jQuery(function($) {

	"use strict";
	
	function newsletterPopupInit (newsletter) {
		$('#popup_newsletter .subcriper_label input').on('click', function(){
		if($(this).parent().find('input:checked').length){
				popup_createCookie('newsletterSubscribe', 'true', 1);
		} else {
				popup_readCookie('newsletterSubscribe');
		}
		});
		$('#popup_newsletter .input-box button.button').on('click', function(){
				var button = $(this);
				setTimeout(function(){
						if(!button.parent().find('input#popup-newsletter').hasClass('validation-failed')){
								popup_createCookie('newsletterSubscribe', 'true', 1);
						}
				}, 500);
		});
		if (popup_readCookie('newsletterSubscribe') == null) {
				setTimeout(function(){
						newsletter.foundation('open');
				}, nova_js_var.popup_show_after);
		}
	}
	if($('#popup_newsletter').length > 0){
			var newsletter = $('#popup_newsletter');
			if(newsletter.hasClass("disable--mobile")) {
				$("html").addClass("mobile-reveal-open");
				newsletter.parent('div').addClass("disable--mobile");
			}
			newsletterPopupInit(newsletter);
	}
})


jQuery(function($) {

	"use strict";
	
	$(document).on('click', '#sidebar_primary .js-sidebar-toogle', function() {
		$(this).closest('#sidebar_primary').toggleClass('opened');
	});
})


jQuery(function($) {
    
    "use strict";

    function bs_fix_vc_full_width_row() {

        var $elements = $('[data-vc-full-width="true"]');
        $.each($elements, function () {
            var $el = jQuery(this);
            $el.css('right', $el.css('left')).css('left', '');
        });

    }

    // Fixes rows in RTL
    if( $('body').hasClass("rtl") ) {
        $(document).on('vc-full-width-row', function () {
            bs_fix_vc_full_width_row();
        });
    }

    // Run one time because it was not firing in Mac/Firefox and Windows/Edge some times
    if ($('body').hasClass("rtl")) {
        bs_fix_vc_full_width_row();
    }
});

jQuery(function($) {

	"use strict";

  $('.cover-slider').each(function() {
    $(this).css('background-image', 'url('+$(this).data('bg')+')');
  });

});


jQuery(function($) {
  
"use strict";

});


jQuery(function($) {

	"use strict";

  /**
	 * Instagram Feed
	 */
	$( '.nova-instagram-feeds' ).each( function() {
		var $shortcode = $( this );

		var $this = $shortcode,
			_configs = $this.data( 'feed_config' ),
			_instagram_token = $this.data( 'instagram_token' ),
			$target, feed_configs, feed;

		if( '' == _instagram_token ) {
			$this.addClass( 'loaded loaded-error' );
		}

		$target = $( '.instagram-feeds', $this );

		feed_configs = $.extend( {
			target: $target.get(0).id,
			accessToken: _instagram_token
		}, _configs );

		feed = new Instafeed( feed_configs );
		feed.run();
	} );

});


(function($){

	"use strict";

})(jQuery);


(function($){

	"use strict";

})(jQuery);


jQuery(function($) {
	
	"use strict";

	// WPML

	$(document).on('click', '.wpml-ls-item-legacy-dropdown-click.wpml-ls-current-language', function(){

		$(this).toggleClass('active');
	});

	$(document).click(function(e){
		if(!$('.wpml-ls-item-legacy-dropdown-click.wpml-ls-current-language .wpml-ls-item-toggle').is(e.target) ) {
			$('.wpml-ls-item-legacy-dropdown-click.wpml-ls-current-language').removeClass('active');
		}
	});

	$('.wpml-ls-item-legacy-dropdown.wpml-ls-current-language').hover( 
		function(){
			$(this).addClass('active');
		}, 
		function(){
			$(this).removeClass('active');
		}
	);

	// WCML

	$(document).on('click', '.wcml-dropdown-click .wcml-cs-active-currency .wcml-cs-item-toggle', function(){

		$(this).parent('.wcml-cs-active-currency').toggleClass('active');
	});
	
	$(document).click(function(){
		$('.wcml-dropdown-click .wcml-cs-active-currency').removeClass('active');
	});

	$('.wcml-dropdown .wcml-cs-active-currency').hover( 
		function(){
			$(this).addClass('active');
		}, 
		function(){
			$(this).removeClass('active');
		}
	);
});

// =============================================================================
// Globals
// =============================================================================

//@codekit-prepend "globals/_globals.js"

// =============================================================================
// Preloader
// =============================================================================

//@codekit-prepend "globals/_preloader.js"

// =============================================================================
// Insert custom css
// =============================================================================

//@codekit-prepend "globals/_custom_css.js"

// =============================================================================
// Resonsive Media CSS
// =============================================================================

//@codekit-prepend "globals/_resonsive_media_css.js"

// =============================================================================
// Custom Scrollbar
// =============================================================================

//@codekit-prepend "globals/_custom_scrollbar.js"



// =============================================================================
// Inits
// =============================================================================

//@codekit-prepend "inits/_inits.js"


// =============================================================================
// Header
// =============================================================================

//@codekit-prepend "components/header/_search.js"
//@codekit-prepend "components/header/_shopbycat.js"
//@codekit-prepend "components/header/_dropdown.js"
//@codekit-prepend "components/header/_sticky.js"
//@codekit-prepend "components/header/_mobile.js"
//@codekit-prepend "components/header/_fullcreen-menu.js"

// =============================================================================
// Shop
// =============================================================================

//@codekit-prepend "components/shop/_filters.js"
//@codekit-prepend "components/shop/_orderby.js"
//@codekit-prepend "components/shop/_product_card.js"
//@codekit-prepend "components/shop/_product_appearance.js"
//@codekit-prepend "components/shop/_product_card_animation.js"
//@codekit-prepend "components/shop/_login-form.js"
//@codekit-prepend "components/shop/_sidebar-sticky.js"


// =============================================================================
// Product
// =============================================================================

//@codekit-prepend "components/product/_init.js"
//@codekit-prepend "components/product/_readmore.js"
//@codekit-prepend "components/product/_gallery.js"
//@codekit-prepend "components/product/_variable_product.js"
//@codekit-prepend "components/product/_stripe_button.js"
//@codekit-prepend "components/product/_wishlist.js"
//@codekit-prepend "components/product/_review_link.js"
//@codekit-prepend "components/product/_progress_bar.js"


// =============================================================================
// Cart
// =============================================================================

//@codekit-prepend "components/cart/_cart.js"


// =============================================================================
// Checkout
// =============================================================================

//@codekit-prepend "components/checkout/_checkout.js"


// =============================================================================
// Footer
// =============================================================================

//@codekit-prepend "components/footer/_footer.js"


// =============================================================================
// Widgets
// =============================================================================

//@codekit-prepend "widgets/_product-categories-with-icon.js"

// =============================================================================
// Blog
// =============================================================================

//@codekit-prepend "components/blog/hero.js"
//@codekit-prepend "components/blog/blog.js"
//@codekit-prepend "components/blog/single.js"

// =============================================================================
// Modules
// =============================================================================

//@codekit-prepend "modules/_lazyload.js"
//@codekit-prepend "modules/_ajax_load_shortcode.js"
//@codekit-prepend "modules/_ajax_load_posts.js"
//@codekit-prepend "modules/_ajax_load_products.js"
//@codekit-prepend "modules/_ajax_load_product_quick_view.js"
//@codekit-prepend "modules/_ajax_wishlist.js"
//@codekit-prepend "modules/_animations.js"
//@codekit-prepend "modules/_ajax_search.js"
//@codekit-prepend "modules/_wp_gallery.js"
//@codekit-prepend "modules/_art_carousel_horizontal.js"
//@codekit-prepend "modules/_vertical_slider.js"
//@codekit-prepend "modules/_contact_form_7.js"
//@codekit-prepend "modules/_slick_carousel.js"
//@codekit-prepend "modules/_nl_popup.js"
//@codekit-prepend "modules/_nova_sidebar.js"

// =============================================================================
// VC
// =============================================================================

//@codekit-prepend "components/vc/rtl.js"
//@codekit-prepend "components/vc/slider.js"
//@codekit-prepend "components/vc/products_slider.js"
//@codekit-prepend "components/vc/instagram.js"

// =============================================================================
// ELEMENTOR
// =============================================================================
//@codekit-prepend "components/elementor/nova-heading.js"
//@codekit-prepend "components/elementor/video-modal.js"

// =============================================================================
// WPML
// =============================================================================

//@codekit-prepend "components/wpml/wpml.js"
