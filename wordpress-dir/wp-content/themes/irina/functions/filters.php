<?php
// -----------------------------------------------------------------------------
// Add Schemes color
// -----------------------------------------------------------------------------

if ( ! function_exists( 'nova_schemes_color_css' ) ) :
	function nova_schemes_color_css(){
	require_once( get_template_directory() . '/assets/css/var.css.php' );
	}
	add_action( 'wp_head', 'nova_schemes_color_css',98);
endif;

// -----------------------------------------------------------------------------
// Disable Font Variants
// -----------------------------------------------------------------------------
if ( ! function_exists( 'nova_disable_font_variants' ) ) :
	function nova_disable_font_variants() {
		if ( class_exists( 'Kirki_Fonts_Google' ) ) {
				Kirki_Fonts_Google::$force_load_all_variants = true;
		}
	}
	add_action( 'wp', 'nova_disable_font_variants');
endif;

if ( ! function_exists( 'nova_kses_allowed_html' ) ) :
function nova_kses_allowed_html($tags, $context) {
  switch($context) {
    case 'simple':
      $tags = array(
        'div' => array(
					'id' => array(),
					'class' => array()
				),
        'ul' => array(
					'id' => array(),
					'class' => array()
				),
        'li' => array(
					'id' => array(),
					'class' => array()
				),
        'span' => array(
					'class' => array()
				),
				'a' => array(
		        'href' => array(),
		        'target' => array(),
		        'data-toggle' => array(),
		        'title' => array()
		    ),
				'img' => array(
		        'src' => array(),
		        'class' => array()
		    ),
				'i' => array(
					'class' => array()
				)
      );
      return $tags;
    default:
      return $tags;
  }
}
add_filter( 'wp_kses_allowed_html', 'nova_kses_allowed_html', 10, 2);
endif;

// -----------------------------------------------------------------------------
// Disable Wishlist Responsive
// -----------------------------------------------------------------------------
add_filter( 'yith_wcwl_is_wishlist_responsive', '__return_false' );
