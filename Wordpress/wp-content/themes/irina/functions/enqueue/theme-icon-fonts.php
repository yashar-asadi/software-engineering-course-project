<?php

// =============================================================================
// Enqueue Theme Fonts
// =============================================================================

if ( ! function_exists('nova_icons_font') ) :
function nova_icons_font() {
	wp_enqueue_style('novaworks-icons', get_template_directory_uri() . '/assets/icon-fonts/core/css/icons.css', false, nova_theme_version(), 'all');
}
add_action( 'wp_enqueue_scripts', 'nova_icons_font' );
endif;
