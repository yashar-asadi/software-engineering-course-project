<?php

if ( is_admin() ) :

	// =============================================================================
	// Enqueue Admin Scripts
	// =============================================================================

	function nova_admin_scripts() {

	    global $pagenow, $post_type;

		wp_enqueue_script('nova-admin-icon-picker', get_template_directory_uri() .'/assets/js/admin/icon-picker.js', array('jquery'), nova_theme_version());
		wp_enqueue_script('nova-admin-go-to-page', get_template_directory_uri() . '/assets/js/admin/go-to-page.js', array('jquery'), nova_theme_version(), true);

	}

	add_action( 'admin_enqueue_scripts', 'nova_admin_scripts' );

endif;
