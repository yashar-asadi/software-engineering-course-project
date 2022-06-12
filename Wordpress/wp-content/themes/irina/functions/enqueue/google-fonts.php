<?php

// =============================================================================
// Enqueue Google Fonts
// =============================================================================

if ( ! function_exists('nova_default_google_fonts') ) :
function nova_default_google_fonts() {
	$fonts_url = 'https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap';
	wp_enqueue_style( 'nova-google-fonts', $fonts_url, array(), null );
}
endif;
if ( ! function_exists('nova_google_fonts') ) :
function nova_google_fonts() {

	$mfont = Nova_OP::getOption('main_font');
	$sfont = Nova_OP::getOption('secondary_font');

	$main_font 					= $mfont['font-family'];
	$main_font_variants 		= array($mfont['variant'],'200','300','400','500','600','700');
	$main_font_subsets 			= $mfont['subsets'];
	if($main_font == 'Muli') {
		$main_font = 'Mulish';
	}
	$secondary_font 			= $sfont['font-family'];
	$secondary_font_variants 	= array($sfont['variant'], '400itatic','500','500itatic','600','700','700itatic');

	$static_font 			= 'Playfair+Display';
	$static_font_variants 	= array('400','400itatic','500','500itatic','700','700itatic');

	$main_family = FALSE;
	$secondary_family = FALSE;
	$font_family = FALSE;
	$static_family = FALSE;

	$subsets = '';

	$haystack 	= array($main_font, $secondary_font, $static_font);
	$target 	= array_keys(Kirki_Fonts::get_google_fonts());

	if ( count(array_intersect($haystack, $target)) > 0 ) :

		if (!empty($main_font) )
		{
			$main_family = $main_font.':';
			foreach ($main_font_variants as $variant)
			{
				$main_family .= $variant.',';
			}

			$main_family = rtrim($main_family, ',');
		}

		if (!empty($secondary_font) && count(array_intersect(array($secondary_font), $target)) > 0 )
		{
			$secondary_family = $secondary_font.':';
			foreach ($secondary_font_variants as $svariant)
			{
				$secondary_family .= $svariant.',';
			}
			$secondary_family = rtrim($secondary_family, ',');
		}
		if (!empty($static_font) )
		{
			$static_family = $static_font.':';
			foreach ($static_font_variants as $stvariant)
			{
				$static_family .= $stvariant.',';
			}
			$static_family = rtrim($static_family, ',');
		}

		if ( !empty($main_family) && !empty($secondary_family) && !empty($static_family)  )
		{
			$font_family = str_replace( '%2B', '+', urlencode( $main_family.'|'.$secondary_family.'|'.$static_family ) );
		}
		elseif ( !empty($main_family) )
		{
			$font_family = str_replace( '%2B', '+', urlencode( $main_family ) );
		}
		elseif ( !empty($secondary_family) )
		{
			$font_family = str_replace( '%2B', '+', urlencode( $secondary_family ) );
		}

		if (!empty($main_font_subsets ))
		{
			$subsets .= urlencode( implode( ',', $main_font_subsets ) );
		}


		if ( !empty($font_family) ):
			$query_args = array(
				'family' => $font_family,
				'subset' => $subsets
			);

			$fonts_url = add_query_arg($query_args, '//fonts.googleapis.com/css');
			wp_enqueue_style( 'nova-google-fonts', $fonts_url, array(), null );

		endif;

	endif;
}
if ( NOVA_KIRKI_IS_ACTIVE ) {
	add_action('wp_head', 'nova_google_fonts', 0);
}
endif;
if ( ! NOVA_KIRKI_IS_ACTIVE ) {
	add_action('wp_head', 'nova_default_google_fonts', 0);
}
