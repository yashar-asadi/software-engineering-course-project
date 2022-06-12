<?php

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
	exit;
}

class Nova_Ajax_Search {


	function __construct() {

		add_action( 'pre_get_posts', array( $this, 'nova_search_in_category' ), 10 );
		// Search results ajax action
		add_action( 'wp_ajax_' . 'nova_ajax_url', array( $this, 'nova_get_search_results' ) );
		add_action( 'wp_ajax_nopriv_' . 'nova_ajax_url', array( $this, 'nova_get_search_results' ) );
	}

	/*
	 * Get search results via ajax
	 */

	public function nova_get_search_results() {
		global $woocommerce;

		$output	 = array();
		$results = array();
		$keyword = sanitize_text_field( $_GET[ 'search_keyword' ] );
		$category= sanitize_text_field( $_GET[ 'search_category' ] );

		if( !isset($category) || empty($category) ) {
			$category = 'all';
		}

		$args = array(
			's'						 => $keyword,
			'posts_per_page'		 => 6,
			'post_type'				 => 'product',
			'post_status'			 => 'publish',
			'suppress_filters'		 => false,
			'tax_query'				 => array(
              	array(
					'taxonomy' => 'product_visibility',
					'field'    => 'name',
					'terms'    => 'exclude-from-search',
					'operator' => 'NOT IN',
				)
			)
		);

		if ( isset( $category ) && ($category != 'all') ) {
	        $args['tax_query'] = array(
		        'relation' => 'AND',
		        array(
			        'taxonomy' => 'product_cat',
			        'field'    => 'slug',
			        'terms'    => $category
		        )
	        );
        }

		$args = apply_filters('search_products_args', $args);

		$products = get_posts( $args );

		$ids = '';

		if ( !empty( $products ) ) {

			foreach ( $products as $post ) {

				$_product = wc_get_product( $post );
				$ids .= $_product->get_id() . ',';

				$output['suggestions'] .= '<div class="cell product-search-result">
									<a href="'.$_product->get_permalink().'">
										<div class="product-search-img">
											'.wp_get_attachment_image($_product->get_image_id(), 'woocommerce_thumbnail').'
										</div>
										<div class="product-search-info">
											<span class="product-search-title">'.$_product->get_name().'</span><br/>'
											.wc_price($_product->get_price()) .'
										</div>
									</a>
								</div>';
			}
			if (count($products) == 6) {
				$output['suggestions'].= '<a class="view-all" href="#">' . esc_html__('View All', 'irina') . '</a>';
			}
			wp_reset_postdata();

		} else {
			$output['suggestions'] =  '<div class="search-no-suggestions"><span class="search-st">' . esc_html__('No results', 'irina') . '</span></div>';
		}
		if( Nova_OP::getOption('header_search_style') == 'default' ) {
			$output['suggestions'] = '<span class="product-search-heading">' . esc_html__("Search results", "irina") . '</span><div class="grid-x grid-padding-x grid-padding-y small-up-1">' . $output['suggestions'] .'</div>';
		}else {
			$output['suggestions'] = '<span class="product-search-heading">' . esc_html__("Search results", "irina") . '</span><div class="grid-x grid-padding-x grid-padding-y small-up-1 medium-up-2 large-up-3">' . $output['suggestions'] .'</div>';
		}


		echo json_encode( $output );
		die();
	}

	/*
	 * Search only in products titles
	 *
	 * @param string $search SQL
	 *
	 * @return string prepared SQL
	 */

	function nova_search_in_category($query) {
	    if( $query->is_search() && isset($_GET[ 'search_category' ]) ) {
	    	$category= sanitize_text_field( $_GET[ 'search_category' ] );
	        if (isset($category) && !empty($category) && ($category != 'all')) {
	            $query->set('tax_query', array(
			        'relation' => 'AND',
			        array(
				        'taxonomy' => 'product_cat',
				        'field'    => 'slug',
				        'terms'    => $category
			        )
		        ));
	        }
	    }
	    return $query;
	}
}

$search = new Nova_Ajax_Search;

?>
