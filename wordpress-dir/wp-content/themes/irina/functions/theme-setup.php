<?php

// =============================================================================
// Theme Setup
// =============================================================================

if ( ! function_exists( 'nova_theme_setup' ) ) :

	function nova_theme_setup() {

		load_theme_textdomain( 'irina', get_template_directory() . '/languages' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'woocommerce', array(

			'product_grid'          => array(
		        'default_rows'    => 3,
		        'min_rows'        => 1,
		        'max_rows'        => 10,

		        'default_columns' => 4,
		        'min_columns'     => 1,
		        'max_columns'     => 6,
		    ),
		) );
		add_editor_style('editor-style.css');
		// gutenberg
		add_theme_support( 'align-wide' );
		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		if ( wp_is_mobile() ) {
			remove_theme_support( 'wc-product-gallery-zoom' );
		}
		if(NOVA_RWMB_IS_ACTIVE) {
			// Enable support for Post Formats
			add_theme_support( 'post-formats', array( 'video', 'audio', 'quote', 'link' ) );
		}
		add_theme_support('html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		));
		//Image size
		add_image_size( 'nova-custom-p2-size', 700, 735, true );
		//Elementor addon
		update_option('novaworks_elementor_modules', array(
			'advanced-carousel' => true,
			'advanced-map' => true,
			'animated-box' => false,
			'animated-text' => false,
			'audio' => false,
			'banner' => true,
			'button' => false,
			'brands' => false,
			'circle-progress' => false,
			'countdown-timer' => true,
			'dropbar'  => false,
			'headline' => false,
			'horizontal-timeline' => false,
			'image-comparison' => false,
			'images-layout' => false,
			'instagram-gallery' => true,
			'portfolio' => false,
			'posts' => true,
			'price-list' => false,
			'pricing-table' => false,
			'progress-bar' => false,
			'scroll-navigation' => false,
			'services' => false,
			'subscribe-form' => true,
			'table' => false,
			'tabs' => true,
			'team-member' => true,
			'testimonials' => true,
			'timeline' => false,
			'video-modal' => true,
			'breadcrumbs' => true,
			'post-navigation' => false,
			'slides' => false,
			'business-hours' => true,
			'heading' => true
		));
		update_option( 'elementor_cpt_support', array( 'page', 'post','product') );
		update_option( 'elementor_disable_color_schemes', 'yes' );
		update_option( 'elementor_disable_typography_schemes', 'yes' );
		update_option( 'elementor_stretched_section_container', '#outer-wrap > #wrap' );
		update_option( 'elementor_page_title_selector', '#section_page_header' );
		update_option( 'elementor_editor_break_lines', 1 );
		update_option( 'elementor_edit_buttons', 'on' );
		update_option( 'elementor_global_image_lightbox', '' );
	}

	add_action( 'after_setup_theme', 'nova_theme_setup', 100 );

	if ( ! isset( $content_width ) ) {
		$content_width = 1920; // pixels
	}

endif;

// =============================================================================
// WC Notification Classes
// =============================================================================

add_filter('woocommerce_add_success', 'custom_wc_notices_class', 10, 1);
add_filter('woocommerce_add_error', 'custom_wc_notices_class', 10, 1);
function custom_wc_notices_class( $message) {
	$class = 'no-button';
	if ( (strpos($message, '</a>') !== false) || (strpos($message, '<button') !== false) ) {
	    $class = 'with-button';
	}

	return '<p class="'.$class.'">'.$message.'</p>';
}


// ==============================================================================
// Register custom query variables
// ==============================================================================

if ( ! function_exists( 'nova_query_var_filters' ) ) :
	function nova_query_var_filters( $vars ) {

		if ( (Nova_OP::getOption('sale_page') === true) && ! empty( Nova_OP::getOption('sale_page_slug') ) ) :
			$vars[] = Nova_OP::getOption('sale_page_slug');
		endif;

		if ( (Nova_OP::getOption('new_products_page') === true) && ! empty( Nova_OP::getOption('new_products_page_slug') ) ) :
			$vars[] = Nova_OP::getOption('new_products_page_slug');
		endif;

		return $vars;
	}
	add_filter( 'query_vars', 'nova_query_var_filters' );
endif;

// ==============================================================================
// Add a pingback url auto-discovery header for single posts, pages, or attachments.
// ==============================================================================
if ( ! function_exists( 'nova_pingback_header' ) ) {
	function nova_pingback_header() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}
	add_action( 'wp_head', 'nova_pingback_header' );
}
