<?php

/******************************************************************************/
/* Archive Meta **************************************************************/
/******************************************************************************/

if ( ! function_exists( 'nova_posted_on' ) ) :

	function nova_posted_on() {

		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

		$time_string = sprintf( $time_string,
			get_the_date( DATE_W3C ),
			get_the_date()
		);

		return '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	}

endif;
if ( ! function_exists( 'nova_posted_on_style_2' ) ) :

	function nova_posted_on_style_2() {

		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

		$time_string = sprintf( $time_string,
			get_the_date( DATE_W3C ),
			get_the_date()
		);

		return '<div class="time-post">' . $time_string . '</div>';

	}

endif;
