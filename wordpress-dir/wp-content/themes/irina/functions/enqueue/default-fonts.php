<?php

// =============================================================================
// Enqueue Embed Fonts
// =============================================================================

if ( ! function_exists('nova_default_fonts') ) :
function nova_default_fonts() {
		wp_enqueue_style( 'nova-default-fonts', get_template_directory_uri() . '/inc/fonts/default.css', false, nova_theme_version(), 'all');
}
add_action( 'wp_enqueue_scripts', 'nova_default_fonts', 100 );
endif;
