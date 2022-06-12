<?php

// =============================================================================
// Enqueue Styles (Front-end)
// =============================================================================

if ( ! function_exists('nova_styles') ) :
function nova_styles() {
	$theme_version = defined('WP_DEBUG') && WP_DEBUG ? time() : nova_theme_version();
	if ( NOVA_WOOCOMMERCE_IS_ACTIVE ) {
			wp_enqueue_style('select2');
	}
	wp_enqueue_style('fontawesome-pro', get_template_directory_uri() . '/assets/vendor/fontawesome-pro/css/all.css', NULL, '5.1.0', 'all');
	wp_enqueue_style('normalize', get_template_directory_uri() . '/assets/vendor/animatedModal.js/css/normalize.min.css', NULL, '3.0.2', 'all');
	wp_enqueue_style('animate', get_template_directory_uri() . '/assets/vendor/animatedModal.js/css/animate.min.css', NULL, $theme_version, 'all');
	wp_enqueue_style('nova-irina-styles', get_template_directory_uri() . '/assets/css/app.css', NULL, $theme_version, 'all');

	wp_register_style('fancybox', get_template_directory_uri() . '/assets/vendor/fancybox/jquery.fancybox.min.css', NULL, '3.5.7', 'all');
	if ( ! empty( Nova_OP::getOption('page_404_bg') ) ) :
		$bg_img_404 = Nova_OP::getOption('page_404_bg');
		$custom_404_css = "
						.page-404 {
								background-image: url($bg_img_404);
								background-repeat: no-repeat;
								background-size: cover;
						}";
		wp_add_inline_style( 'nova-irina-styles', $custom_404_css );
	endif;
}
add_action( 'wp_enqueue_scripts', 'nova_styles' );
endif;
