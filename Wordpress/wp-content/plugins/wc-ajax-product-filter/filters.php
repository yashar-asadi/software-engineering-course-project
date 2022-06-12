<?php
/*
List of available filters in WC Ajax Product Filter plugin.
You can use these filterns in your theme in funtions.php file
and set different default settings.
*/

// Set default settings
function wcapf_default_settings($settings) {
	$settings['shop_loop_container'] = '.another-container';
	$settings['custom_scripts'] = 'alert("hello");';
	$settings['scroll_to_top'] = null;
	return $settings;
}
add_filter('wcapf_settings', 'wcapf_default_settings');