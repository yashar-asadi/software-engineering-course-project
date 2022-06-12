/* Icon Picker */

(function($) {

	"use strict";

	$.fn.iconPicker = function() {
		
		var icons, $list, prefix, $target, $button, $popup;
		
		$list = $('');
		
		function font_set() {		
			
			prefix = 'irina-icons';	
			
			icons = [
				"cafe_wine-glass",
				"cafe_take-away-drink",
				"cafe_take-away-drink-2",
				"cafe_pizza-slice2",
				"health_diet-tape2",
				"health_kg-weight2",
				"health_scale2",
				"health_sunset",
				"health_tape-52",
				"hotel_hair-dryer",
				"spa_sunflower",
				"spa_swim-pool",
				"spa_sunbed",
				"spa_stones",
				"spa_spa-sign",
				"spa_shower2",
				"spa_small-candles",
				"spa_perfume2",
				"spa_razor2",
				"spa_mortar-pestle",
				"spa_nail-polish",
				"spa_night-cream",
				"spa_massage-oil-2",
				"spa_massage-oil",
				"spa_lipstick2",
				"spa_makeup-brush-set",
				"spa_makeup-set",
				"spa_hot-bath",
				"spa_hand-mirror-2",
				"spa_hand-cream2",
				"spa_flower-4",
				"spa_face-brush",
				"spa_eye-makeup",
				"spa_eye-cream",
				"spa_cream",
				"spa_comb",
				"spa_cleansing-oil",
				"spa_clean-brush",
				"spa_candle-fire",
				"spa_bamboo",
				"health_tape-apple2",
				"health_water-bottle-small",
				"ecommerce_shop-location2",
				"mail_mail",
				"calendar_wall-clock-2",
				"phone_phone-symbol",
				"phone_iphone",
				"three_dots",
				"arrow-left",
				"arrow-right",
				"external-link",
				"enlarge",
				"video-play",
				"building_home",
				"security_fingerprint",
				"quick-view",
				"download",
				"design_pencil-2",
				"arrows_rounded-arrow-left",
				"alignment_column-row-horizontal",
				"alignment_align-all-1",
				"alignment_align-all",
				"ui_more-options",
				"alignment_align-justify-all",
				"ui_remove_selection",
				"chat_chat-15",
				"ui_notice",
				"close-dark-larger",
				"404",
				"wishlist-empty",
				"empty-cart",
				"snapchat",
				"ecommerce_watchlist-eye",
				"display-list",
				"ui_add_selection",
				"ui_window",
				"seo_video-marketing",
				"ui_add",
				"ui_minus",
				"ui_delete",
				"ui_confirm",
				"ui_forbidden",
				"ui_plus-window",
				"ui_minus-window",
				"ui_logout",
				"ui_edit",
				"ui_edit-profile",
				"ui_star_full",
				"ui_star",
				"hamburger",
				"search",
				"wishlist",
				"ecommerce_wishlist",
				"account-24x24-dark-alt",
				"account",
				"add-dark",
				"remove-dark",
				"add-dark-large",
				"close-dark",
				"arrow-down-dark",
				"arrow-left-dark",
				"arrow-right-dark",
				"arrow-up-dark",
				"arrows_refresh",
				"ui_refresh-sync",
				"ui_question",
				"ui_options",
				"shopping-bag",
				"ecommerce_shopping-bag-2",
				"ecommerce_shopping-bag-3",
				"ecommerce_shopping-bag",
				"ecommerce_shopping-basket-2",
				"ecommerce_shopping-basket",
				"ecommerce_shopping-bags",
				"ecommerce_shopping-cart",
				"ecommerce_cart-checkout",
				"ecommerce_wallet",
				"ecommerce_money",
				"ecommerce_accepted-cards",
				"ecommerce_smartphone-shopping",
				"ecommerce_shop",
				"ecommerce_shop-location",
				"ecommerce_purchase-receipt",
				"ecommerce_product-tag-6",
				"ecommerce_discount-symbol",
				"ecommerce_discount-coupon",
				"ecommerce_shopping-coupons",
				"ecommerce_discount-coupon-scissors",
				"ecommerce_24h-support",
				"ecommerce_credit-card",
				"ecommerce_cash-register",
				"ecommerce_box-transport",
				"ecommerce_box-2",
				"ecommerce_present",
				"ecommerce_money-calculator",
				"display-grid",
				"ui_expand",
				"love_valentine-cake",
				"love_hearts",
				"sports_badminton",
				"sports_baseball-ball",
				"sports_basketball-2",
				"sports_basketball-arena",
				"sports_basketball-table",
				"sports_basketball",
				"sports_billiard-8-ball",
				"sports_fencing",
				"sports_football-ball",
				"sports_roller-skates",
				"sports_rugby-ball",
				"sports_rugby-helmet",
				"sports_sport-shirt",
				"sports_stopwatch",
				"sports_tennis-ball",
				"sports_tennis-baseball",
				"sports_tennis-rockets",
				"sports_ticket",
				"sports_volleyball",
				"sports_wight-lifting-3",
				"spa_flip-flops",
				"spa_hand-cream",
				"spa_hand-mirror",
				"spa_lipstick",
				"spa_perfume",
				"spa_razor-2",
				"spa_razor",
				"spa_rose",
				"spa_scissors",
				"spa_shower",
				"spa_spa-flower",
				"spa_spa-oil",
				"party_balloons",
				"party_christmas-candle",
				"party_christmas-cute-cap",
				"party_christmas-glove-2",
				"party_christmas-socks",
				"party_christmas-tree",
				"party_cookie-man",
				"party_door-bell",
				"party_door-star",
				"party_firework-4",
				"party_firework-stars",
				"party_present-2",
				"party_present-gift",
				"party_shopping-discount",
				"party_ski-boots",
				"party_snowflake",
				"party_snowman",
				"party_wax-candle",
				"music_audio-disc",
				"music_old-cassete",
				"medical_gauze",
				"industry_grain-2",
				"health_diet-stats",
				"health_diet-tape",
				"health_heart-rate",
				"health_kg-weight",
				"health_scale",
				"health_shower-towel",
				"health_slim-belly",
				"health_smartwatch-heart-rate",
				"health_stopwatch",
				"health_tape-5",
				"health_tape-apple",
				"handcrafts_eco-lamp-2",
				"handcrafts_leather",
				"handcrafts_sewing-machine",
				"handcrafts_small-bobbin",
				"handcrafts_e14-lamp",
				"halloween-easter_axe-blond",
				"halloween-easter_bat",
				"halloween-easter_candle",
				"halloween-easter_cracked-bone",
				"halloween-easter_cracked-skull",
				"halloween-easter_ghost",
				"gaming_controller-directions",
				"gaming_controller-symbols",
				"gaming_game-controller",
				"gaming_game-disc",
				"gaming_gaming-mouse",
				"gaming_handlet-console",
				"gaming_lifes",
				"gaming_medal",
				"gaming_pac-man-ghost",
				"gaming_pac-man",
				"gaming_puzzle-piece",
				"gaming_skull",
				"gambling_clover-cards-2",
				"gambling_clover-heart-pike-diamond",
				"gambling_diamond-2",
				"gambling_dollar-tips-2",
				"gambling_fruit-cherry",
				"gambling_king",
				"gambling_knight",
				"gambling_lucky-7",
				"gambling_slot-machine",
				"gambling_tic-tac-toe",
				"furniture_adjustable-lamp",
				"furniture_baby-bed",
				"furniture_basin",
				"furniture_bathtub",
				"furniture_bedside-2",
				"furniture_bedside-4",
				"furniture_bedside",
				"furniture_camping-table",
				"furniture_chair",
				"furniture_closed-door",
				"furniture_closet-3",
				"furniture_closet",
				"furniture_cough-3",
				"furniture_cough",
				"furniture_desk",
				"furniture_dining-table-lamp",
				"furniture_floor-lamp",
				"furniture_hanger",
				"furniture_home-stairs",
				"furniture_single-bed-side",
				"furniture_sink",
				"furniture_table-lamp",
				"furniture_wall-picture",
				"food_apple",
				"food_avocado",
				"food_banana",
				"food_bread-slice",
				"food_burritos-tacos",
				"food_cake",
				"food_candy",
				"food_carrot",
				"food_cheese-slice-2",
				"food_cherries",
				"food_chocolate",
				"food_cookies",
				"food_croissant",
				"food_donut",
				"food_eggplant",
				"food_fish-meat",
				"food_grain",
				"food_milk-ration",
				"food_pear",
				"food_sausage",
				"food_watermelon-slice",
				"electronics_air-condition",
				"electronics_air-purifier",
				"electronics_australia-socket",
				"electronics_blender",
				"electronics_espresso-machine",
				"electronics_hair-dryer",
				"electronics_mixer",
				"electronics_monitor",
				"electronics_music-player",
				"electronics_oven-2",
				"electronics_oven",
				"electronics_phone-fax",
				"electronics_power-socket",
				"electronics_projector",
				"electronics_toaster-bread",
				"electronics_tooth-brush",
				"electronics_tv-monitor",
				"electronics_washing-machine",
				"hardware_chipset",
				"hardware_computer-laptop-connection",
				"hardware_hard-drive",
				"hardware_ipad",
				"hardware_iphone",
				"hardware_laptop",
				"hardware_monitor",
				"hardware_scanner",
				"hardware_usb-stick",
				"hardware_webcamera",
				"hardware_wired-mouse",
				"construction_hammer-2",
				"construction_metre",
				"construction_nail-screw",
				"construction_paint-brush",
				"construction_paint-roller-2",
				"camping_axe",
				"camping_barbecue-grill-2",
				"camping_boots",
				"camping_camping-bag-2",
				"camping_camping-car",
				"cafe_fork-knife-sign",
				"cafe_fork-spoon-knife",
				"cafe_french-fries",
				"cafe_hot-bowl",
				"cafe_hot-coffee",
				"cafe_ice-cream",
				"cafe_pizza-slice",
				"cafe_restaurant-catalog",
				"cafe_serving-plate",
				"cafe_double-burger",
				"cafe_coffee-take-away",
				"cafe_coctail-drink",
				"cafe_candles",
				"cafe_burger",
				"cafe_bottle",
				"cafe_bottle-opener",
				"cafe_beer-classic-glass",
				"building_small-home-2",
				"building_country-home-2",
				"clothes_baby-hoodie",
				"clothes_baseball-hat",
				"clothes_belt",
				"clothes_boots",
				"clothes_bow",
				"clothes_bra-2",
				"clothes_bra-underwear-2",
				"clothes_bra-underwear",
				"clothes_bra",
				"clothes_cap-3",
				"clothes_cap-4",
				"clothes_dress-2",
				"clothes_dress-3",
				"clothes_dress-4",
				"clothes_dress",
				"clothes_gentlemen-cap",
				"clothes_gentlement-shoes",
				"clothes_glasses",
				"clothes_gloves",
				"clothes_hanger-towel",
				"clothes_hanger",
				"clothes_hat",
				"clothes_heels",
				"clothes_home-slippers",
				"clothes_hood",
				"clothes_jacket",
				"clothes_lady-bag-3",
				"clothes_lady-bag",
				"clothes_lady-shopping-bag",
				"clothes_lady-wallet",
				"clothes_lipstick",
				"clothes_long-sleeve-2",
				"clothes_long-sleeve",
				"clothes_pants-2",
				"clothes_pants-3",
				"clothes_pants",
				"clothes_ring",
				"clothes_shirt-long-sleeve-2",
				"clothes_shirt-long-sleeve-3",
				"clothes_shirt-long-sleeve-polo",
				"clothes_shirt-long-sleeve",
				"clothes_shirt-short-sleeve-2",
				"clothes_shirt-short-sleeve-3",
				"clothes_shirt-short-sleeve",
				"clothes_shirt",
				"clothes_shoes-2",
				"clothes_shoes",
				"clothes_short-pants-2",
				"clothes_short-pants-3",
				"clothes_short-pants-4",
				"clothes_short-pants",
				"clothes_skirt-3",
				"clothes_skirt-4",
				"clothes_skirt-5",
				"clothes_skirt",
				"clothes_sleeveless-jacket",
				"clothes_slippers",
				"clothes_sneakers",
				"clothes_socks-2",
				"clothes_socks",
				"clothes_sport-shoes",
				"clothes_sunglasses",
				"clothes_t-shirt-short-sleeve-2",
				"clothes_t-shirt-short-sleeve-3",
				"clothes_t-shirt-short-sleeve-polo",
				"clothes_t-shirt-short-sleeve",
				"clothes_t-shirt",
				"clothes_tie-2",
				"clothes_tie",
				"clothes_trendy-shoes",
				"clothes_underwear-2",
				"clothes_underwear-3",
				"clothes_underwear-4",
				"clothes_underwear-5",
				"clothes_underwear",
				"clothes_vest-2",
				"clothes_vest",
				"clothes_wallet",
				"clothes_wrist-watch-analog",
				"clothes_wrist-watch-digital",
				"rss",
				"twitter",
				"facebook-f",
				"instagram",
				"youtube2",
				"amazon",
				"apple",
				"slack",
				"tripadvisor",
				"wordpress",
				"youtube",
				"youtube-play",
				"yelp",
				"houzz",
				"google-plus",
				"google",
				"google2",
				"github-alt",
				"foursquare",
				"behance",
				"foursquare2",
				"sina-weibo",
				"skype",
				"soundcloud",
				"spotify",
				"swarm",
				"vine",
				"vk",
				"xing",
				"yelp2",
				"dribbble",
				"flickr",
				"github",
				"lastfm",
				"linkedin",
				"pinterest",
				"stumbleupon",
				"tumblr",
				"vimeo",
			];

		};
	
		font_set();

		function build_list($popup,$button,clear) {
		  	
		  	$list = $popup.find('.icon-picker-list');
		  
			if (clear==1) {
				$list.empty(); // clear list //
			}

			for (var i in icons) {
				$list.append('<li data-icon="' + icons[i] + '"><a href="#" title="' + icons[i] + '"><span class="' + prefix + '-' + icons[i] + '"></span></a></li>');
			};

			$('a', $list).click(function(e) {
				e.preventDefault();
				$(".icon_picker_input").change();
				var title = $(this).attr("title");
				$target.val(prefix + "-" + title);
				$button.removeClass().addClass("button icon-picker " + prefix + "-" + title);
				removePopup();
			});
		};
	
		function removePopup(){
			$(".icon-picker-container").remove();
		}

		$button = $('.icon-picker');

		$('body').on('click', '.icon-picker', function() {
			createPopup($(this));
		});

		function createPopup($button) {
			
			$target = $($button.data('target'));
			
			$popup = $('<div class="icon-picker-container"><div class="icon-picker-control" /><ul class="icon-picker-list" /><a href="#" class="icon-picker-close">Close</a></div>')
				.css({
					'top': $button.offset().top,
					'left': $button.offset().left
				});
			
			build_list($popup,$button,0);
			
			var $control = $popup.find('.icon-picker-control');
			
			$control.html(
				'<a data-direction="back" href="#"><span class="dashicons dashicons-arrow-left-alt2"></span></a> '+
				'<input type="text" class="" placeholder="Search" />'+
				'<a data-direction="forward" href="#"><span class="dashicons dashicons-arrow-right-alt2"></span></a>'
			);

			$('a', $control).click(function(e) {
				e.preventDefault();
				if ($(this).data('direction') === 'back') {
					//move last 25 elements to front
					$('li:gt(' + (icons.length - 26) + ')', $list).each(function() {
						$(this).prependTo($list);
					});
				} else {
					//move first 25 elements to the end
					$('li:lt(25)', $list).each(function() {
						$(this).appendTo($list);
					});
				}
			});

			$popup.appendTo('body').show();

			$('input', $control).on('keyup', function(e) {
				var search = $(this).val();
				if (search === '') {
					//show all again
					$('li:lt(25)', $list).show();
				} else {
					$('li', $list).each(function() {
						if ($(this).data('icon').toString().toLowerCase().indexOf(search.toLowerCase()) !== -1) {
							$(this).show();
						} else {
							$(this).hide();
						}
					});
				}
			});

			$('.icon-picker-close').click(function(e) {
				e.preventDefault();
				removePopup();
			});

			/*$(document).mouseup(function (e){
				if (!$popup.is(e.target) && $popup.has(e.target).length === 0) {
					removePopup();
				}
			});*/
		}
	}

	$(function() {
		$('.icon-picker').iconPicker();
	});

	$(document).ajaxComplete(function() {
		$('.icon-picker').iconPicker();
	});

}(jQuery));