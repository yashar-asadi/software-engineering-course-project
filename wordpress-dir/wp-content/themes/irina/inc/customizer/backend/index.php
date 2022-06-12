<?php

// ==================================================================
// Remove Customize Pages
// ==================================================================

add_action('admin_menu', 'remove_customize_pages');
function remove_customize_pages(){
    global $submenu;
    unset($submenu['themes.php'][15]); // remove Header link
    unset($submenu['themes.php'][20]); // remove Background link
}


// ==================================================================
// Custom Controls
// ==================================================================

add_action( 'customize_register', function( $wp_customize ) {

    class Kirki_Control_Separator extends Kirki_Control_Base {
        public $type = 'separator';
        public function render_content() { ?>
            <hr />
            <?php
        }
    }

    add_filter( 'kirki_control_types', function( $controls ) {
        $controls['separator'] = 'Kirki_Control_Separator';
        return $controls;
    } );

} );

// ==================================================================
// Control Config
// ==================================================================

Kirki::add_config( 'irina', array(
    'capability'    => 'edit_theme_options',
    'option_type'   => 'theme_mod',
) );

// ==================================================================
// Custom Fonts
// ==================================================================

function nova_custom_fonts_to_kirki( $fonts ) {

        $fonts["system-font"] = array(
        "label" => "Cerebri Sans",
        "stack" => "Cerebri Sans",
        );
        return $fonts;
}
add_filter( 'kirki/fonts/standard_fonts', 'nova_custom_fonts_to_kirki' );
