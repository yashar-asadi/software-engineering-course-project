<?php

	// Kill theme modifications
	// remove_theme_mods();

	class Nova_OP {

		/**
		 * Cache each request to prevent duplicate queries
		 *
		 * @var array
		 */
		protected static $cached = [];

		/**
		 *  We don't need a constructor
		 */
		private function __construct() {}

		/**
		 * Default values for theme options
		 *
		 * @return array
		 */
		private static function theme_defaults() {
			return [
				// Global
				'site_width'                  => 1440,
				'site_preloader'             	=> 0,
				'bg_color' 										=> '#FFF',
				'newsletter_popup' 						=> 0,
				'popup_showonly_homepage' 		=> 1,
				'popup_show_mobile' 					=> 1,
				'popup_show_again' 						=> 0,
				'popup_show_after' 						=> 2000,
				'popup_show_again_text' 			=> esc_html__( 'Don’t show this popup again', 'irina' ),

				// Header
				'header_template' 						=> 'type-3',
				'header_menu_position' 						=> 'menu-center',
				'header_wide' 								=> 'off',
				'header_height'								=> 100,
				'header_transparent' 					=> 'off',
				'header_background_color' 		=> 'transparent',
				'header_background_color_2' 	=> '#F6F6F6',
				'header_font_color' 					=> '#242424',
				'header_accent_color'					=> '#564C42',
				'header_font_size' 						=> '16',
				'header_search_toggle'					=> 1,
				'header_search_style'						=> 'fullscreen',
				'header_search_by_category'				=> 0,
				'header_logo'                			=> get_template_directory_uri() . '/assets/images/logo.svg',
				'header_logo_light'               => get_template_directory_uri() . '/assets/images/logo_light.svg',
				'header_logo_width' 							=> 200,
				'header_alt_logo'                	=> get_template_directory_uri() . '/assets/images/alternative_logo.svg',
				'icons_on_topbar'             		=> 0,
				'header_burger_menu'             	=> 0,
				'header_user_account'             => 1,
				'header_user_action'             	=> 'modal',
				'header_wishlist' 								=> 0,
				'header_cart' 										=> 1,
				'header_cart_action' 							=> 'mini-cart',
				'topbar_toggle'             			=> 0,
				'topbar_template'									=> 'type-default',
				'topbar_wide'             				=> false,
				'topbar_bg_color'									=> '#F5F5F5',
				'topbar_font_color'		    				=> '#242424',
				'topbar_heading_color'		    		=> '#242424',
				'topbar_accent_color'		    			=> '#000',
				'topbar_border_color'		    			=> '#F5F5F5',
				'topbar_font_size'          			=> 12,
				'topbar_info_toggle'         			=> 0,
				'topbar_enable_switcher'          => 0,
				'main_menu_background_color'			=> '#FFF',
				'main_menu_font_color'						=> '#292929',
				'main_menu_accent_color'					=> '#564C42',
				'main_menu_border_color'					=> '#DEDEDE',
				'dropdowns_bg_color'         			=> '#fff',
				'dropdowns_font_color'       			=> '#616161',
				'dropdowns_accent_color'				=> '#564C42',
				'enable_header_sticky'				=> 0,
				'header_mobile_background_color'				=> '#fff',
				'header_mobile_text_color'				=> '#000',
				'handheld_bar_background_color'				=> '#000',
				'handheld_bar_text_color'				=> '#fff',
				'page_header_style' => 'large',
				'page_header_breadcrumb_toggle' => 1,
				'page_header_height' => 200,
				'pager_header_background_color' => '#ECEBE7',
				'pager_header_font_color' => '#616161',
				'pager_header_heading_color' => '#000',

				// Fonts
				'font_size' 							=> '16',
				'main_font' 							=> array('font-family' => 'Montserrat',  'variant' => '400', 'subsets' => array('latin')),
				'secondary_font' 						=> array('font-family' => 'Raleway', 'variant' => '600', 'subsets' => array('latin')),

				// Content Styling
				'primary_color'             	=> '#616161',
				'secondary_color'           	=> '#292929',
				'accent_color' 								=> '#564C42',
				'accent_color_2' 							=> '#000000',
				'border_color' 								=> '#ebebeb',
				'site_link_color'							=> '#292929',
				'site_link_hover_color'				=> '#564C42',
				'primary_button_color'				=> '#242424',
				'secondary_button_color'			=> '#564C42',

				//Blog Styling
				'blog_background_color'				=> '#F6F6F6',

				'qv_bg_color'									=> '#fff',
				'qv_font_color'								=> '#616161',
				'qv_heading_color'						=> '#000',

				//Shop by Category
				'enable_shopbycat'						=> 0,
				'shopbycat_subcategories'			=> 1,
				'shopbycat_counter'						=> 0,
				'shopbycat_thumbnail'					=> 0,


				// Shop
				'shop_layout_width'						=> 'boxed',
				'shop_sidebar' 								=> 0,
				'shop_filter_active' 					=> 1,
				'shop_sidebar_position'       => 'left',
				'shop_layout_style'						=> 'grid',
				'shop_pagination' 						=> 'infinite_scroll',
				'shop_filter_height'					=> 150,
				'shop_mobile_columns'					=> 2,
				'shop_second_image'						=> 0,
				'catalog_mode' 								=> 0,
				'catalog_mode_button'               	=> 0,
				'catalog_mode_price'                	=> 0,
				'shop_product_columns'								=> 4,
				'shop_product_per_page'								=> 12,
				'product_per_page_allow'							=> '12,15,30',
				'shop_product_addtocart_button'       => true,
				'shop_product_wishlist_button'      	=> true,
				'shop_product_quickview_button'    		=> true,
				'sale_page'                         	=> true,
				'sale_page_slug'                    	=> 'on-sale',
				'sale_page_title'                   	=> esc_html__( 'On Sale!', 'irina' ),
				'sale_page_badge_text'              	=> esc_html__( 'Sale!', 'irina' ),
				'new_products_page'                 	=> true,
				'new_products_page_slug'            	=> 'new-products',
				'new_products_page_title'           	=> esc_html__( 'New Products', 'irina' ),
				'new_products_badge_text'           	=> esc_html__( 'New!', 'irina' ),
				'new_products_number_type'            => 'last_added',
				'new_products_number'               	=> 8,
				'new_products_number_last' 						=> 8,

				// Blog
				'blog_layout'													=> 'layout-1',
				'blog_sidebar'                      	=> 1,
				'blog_sidebar_position'             	=> 'right',
				'blog_pagination' 										=> 'default',
				'blog_single_sidebar'               	=> 0,
				'blog_single_sidebar_position'      	=> 'right',
				'blog_single_featured'              	=> 1,
				'blog_single_social_share'						=> false,
				'blog_single_post_nav'								=> false,
				'blog_single_author_box'							=> false,
				'blog_highlighted_posts'							=> 0,
				'limit_excerpt_word'									=> 30,
				'blog_post_column_l'									=> 3,
				'blog_post_column_m'									=> 2,
				'blog_post_column_s'									=> 1,
				'blog_post_excerpt'										=> 1,

			    // Product Page
				'product_preset'											=> 'style_3',
				'product_tab_style'										=> 'style_1',
				'product_image_zoom'									=> 1,
				'product_image_lightbox'							=> 1,
				'upsell_products' 										=> 1,
				'related_products' 										=> 1,
				'related_products_column' 						=> 4,
				'single_product_sidebar'            	=> false,
				'single_product_tab_active'           => false,
				'single_product_social_share'					=> false,
				'single_product_sidebar_position'   	=> 'left',

				// Footer
				'footer_template'							=> 'type-mini',
				'footer_background_color' 		=> '#000',
				'footer_font_color' 					=> '#fff',
				'footer_headings_color'             	=> '#fff',
				'footer_text' 							=> esc_html__( '© 2021 Irina All rights reserved. Designed by Novaworks', 'irina' ),

				//Support list
				'site_chat_link' 						=> 'https://novaworks.ticksy.com/',
				'site_phone_link' 					=> '',
				'site_email_ad' 					=> 'demo@demo.com',

				// Socials
				'facebook_link' 						=> '#',
				'twitter_link' 							=> '#',
				'nav_button_title'						=> esc_html__( 'Browse Categories', 'irina' ),

				//Social Share
				'sharing_facebook'	=> 'on',
				'sharing_twitter'	=> 'on',
				'sharing_reddit'	=> 'off',
				'sharing_linkedin'	=> 'on',
				'sharing_tumblr'	=> 'on',
				'sharing_pinterest'	=> 'on',
				'sharing_line'	=> 'off',
				'sharing_vk'	=> 'off',
				'sharing_whatapps'	=> 'off',
				'sharing_telegram'	=> 'off',
				'sharing_email'	=> 'off',

				//404 page
				'page_404_font_color'                			=> '#000'
			];
		}

		/**
		 * Switch case for options that need post processing
		 *
		 * @param  [string] $key   [name of option]
		 * @param  [string] $value [value]
		 *
		 * @return [string]        [processed value]
		 */
		private static function processOption($key, $value) {
				$opacity_dark           = .75;
			    $opacity_medium         = .5;
			    $opacity_light          = .3;
			    $opacity_ultra_light    = .15;
				switch ($key) {


					case 'topbar_dark_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('topbar_font_color')) 	. "," . $opacity_dark . ")";
						break;
					case 'topbar_medium_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('topbar_font_color')) 	. "," . $opacity_medium . ")";
						break;
					case 'topbar_light_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('topbar_font_color')) 	. "," . $opacity_light . ")";
						break;
					case 'topbar_ultra_light_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('topbar_font_color')) 	. "," . $opacity_ultra_light . ")";
						break;

					case 'header_dark_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('header_font_color')) 	. "," . $opacity_dark . ")";
						break;
					case 'header_medium_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('header_font_color')) 	. "," . $opacity_medium . ")";
						break;
					case 'header_light_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('header_font_color')) 	. "," . $opacity_light . ")";
						break;
					case 'header_ultra_light_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('header_font_color')) 	. "," . $opacity_ultra_light . ")";
						break;

					case 'simple_header_ultra_light_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('simple_header_font_color')) 	. "," . $opacity_ultra_light . ")";
						break;


					case 'dropdowns_dark_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('dropdowns_font_color')) 	. "," . $opacity_dark . ")";
						break;
					case 'dropdowns_medium_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('dropdowns_font_color')) 	. "," . $opacity_medium . ")";
						break;
					case 'dropdowns_light_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('dropdowns_font_color')) 	. "," . $opacity_light . ")";
						break;
					case 'dropdowns_ultra_light_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('dropdowns_font_color')) 	. "," . $opacity_ultra_light . ")";
						break;


					case 'content_dark_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('primary_color')) 		. "," . $opacity_dark . ")";
						break;
					case 'content_medium_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('primary_color')) 		. "," . $opacity_medium . ")";
						break;
					case 'content_light_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('primary_color')) 		. "," . $opacity_light . ")";
						break;
					case 'content_ultra_light_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('primary_color')) 		. "," . $opacity_ultra_light . ")";
						break;


					case 'footer_dark_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('footer_font_color')) 	. "," . $opacity_dark . ")";
						break;
					case 'footer_medium_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('footer_font_color')) 	. "," . $opacity_medium . ")";
						break;
					case 'footer_light_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('footer_font_color')) 	. "," . $opacity_light . ")";
						break;
					case 'footer_ultra_light_gray':
						return "rgba(" . nova_hex2rgb(self::getOption('footer_font_color')) 	. "," . $opacity_ultra_light . ")";
						break;


					case 'header_logo':
						return self::getOption('header_logo');
						break;
					case 'header_alt_logo':
						return self::getOption('header_alt_logo');
						break;
					case 'catalog_mode_button':
						return self::getOption('catalog_mode') && self::getOption('catalog_mode_button');
						break;
					case 'catalog_mode_price':
						return self::getOption('catalog_mode') && self::getOption( 'catalog_mode_price');
						break;
					case 'footer_credit_card_icons':
						return self::getOption('footer_credit_card_icons');
						break;
					default:
						return $value;


				}

				return $value;
		}

		/**
		 * Return the theme option from cache; if it isn't cached fetch it and cache it
		 *
		 * @param  string $option_name
		 * @param  string $default
		 *
		 * @return string
		 */
		public static function getOption( $option_name, $default= '' ) {
			if (isset($_GET["preset"]))
			{
				$preset = $_GET["preset"];
			} else {
				$preset = "";
			}

			if ($preset != "")
			{
				if ( file_exists( get_template_directory() . '/_presets/'.$preset.'.dat' ) )
				{
				$presets_raw = nova_get_local_file_contents(get_template_directory() . '/_presets/'.$preset.'.dat');
				$presets = @unserialize( $presets_raw );
				}
			}
			if (isset($presets) && isset($presets['mods'][ $option_name]) ) {
				return $presets['mods'][ $option_name];
				die();
			}
			/* Return cached if possible */
			if ( array_key_exists($option_name, self::$cached) && empty($default) )
				return self::$cached[$option_name];
			/* If no default is given, fetch from theme defaults variable */
			if (empty($default)) {
				$default = array_key_exists($option_name, self::theme_defaults())? self::theme_defaults()[$option_name] : '';
			}

			$opt= get_theme_mod($option_name, $default);
			// echo '<br/>I did a database query<br/>';

			/* Cache the result */
			self::$cached[$option_name]= $opt;

			/* Process the variable */
			if ( $opt !== self::processOption($option_name, $opt) ) {
				self::$cached[$option_name]= self::processOption($option_name, $opt);
			}

			return self::$cached[$option_name];
		}
	}
?>
