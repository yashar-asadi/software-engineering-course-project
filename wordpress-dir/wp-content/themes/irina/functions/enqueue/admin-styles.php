<?php

// =============================================================================
// Enqueue Admin Styles
// =============================================================================

if ( is_admin() ) :

	function nova_admin_styles() {

		wp_enqueue_style('nova-admin-styles', get_template_directory_uri() .'/assets/css/admin-styles.css', false, nova_theme_version(), 'all');
	}

	add_action( 'admin_enqueue_scripts', 'nova_admin_styles' );

endif;
