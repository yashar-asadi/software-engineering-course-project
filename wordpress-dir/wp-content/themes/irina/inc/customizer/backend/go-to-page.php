<?php

if ( ! function_exists( 'get_section_url' ) ) :

	function get_section_url() {

		switch($_POST['page']) {
			case 'shop': 
				echo get_permalink( wc_get_page_id( 'shop' ) ); 
				break;
			case 'blog': 
				echo get_permalink( get_option( 'page_for_posts' ) ); 
				break;
			case 'blog_single': 
				$args = array('orderby' => 'rand', 'post_status' => 'publish', 'posts_per_page' => 1); 
				$post = get_posts($args); 
				echo get_permalink( $post[0]->ID );
				break;
			case 'product': 
				$args = array('orderby' => 'rand', 'limit' => 1); 
				$product = wc_get_products($args); 
				echo get_permalink( $product[0]->get_id() ); 
				break;
			default:
				echo get_home_url();
				break;
		}
		exit();
	}
	
	add_action( 'wp_ajax_get_url', 'get_section_url' );

endif;
