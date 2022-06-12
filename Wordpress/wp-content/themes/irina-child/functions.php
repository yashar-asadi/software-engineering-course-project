<?php //Start building your awesome child theme functions

add_action( 'wp_enqueue_scripts', 'irina_enqueue_styles', 100 );
function irina_enqueue_styles() {
    wp_enqueue_style( 'irina-child-styles',  get_stylesheet_directory_uri() . '/style.css', array( 'nova-irina-styles' ), wp_get_theme()->get('Version') );
}
