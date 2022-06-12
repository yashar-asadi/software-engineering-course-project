<?php

//remove_theme_mods(); // DEBUG

function nova_theme_customiser_styles() {

	ob_start();
	$custom_code = str_replace(array("\r\n", "\r"), "\n", ob_get_clean());
	$lines = explode("\n", $custom_code);
	$new_lines = array();
	foreach ($lines as $i => $line) { if(!empty($line)) $new_lines[] = trim($line); }
	echo implode($new_lines);
}

add_action( 'wp_head', 'nova_theme_customiser_styles', 99 );
