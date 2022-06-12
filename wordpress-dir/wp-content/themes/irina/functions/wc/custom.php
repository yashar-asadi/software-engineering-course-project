<?php


if ( ! function_exists( 'nova_query_vars' ) ) :
	add_action( 'parse_query', 'nova_query_vars' );
	/**
	 * Parse Wordpress query and look for on-sale page or new products page, add actions accordingly
	 *
	 * @return [type] [description]
	 */
	function nova_query_vars() {
		if ( get_query_var( Nova_OP::getOption('sale_page_slug') ) === '1' ) :
			add_action( 'woocommerce_product_query', 'nova_on_sale_products_query' );
			add_filter( 'woocommerce_page_title', 'nova_on_sale_products_title' );
			add_filter( 'woocommerce_layered_nav_link', 'nova_onsale_filter_woocommerce_layered_nav_link', 10, 3 );
			add_filter( 'woocommerce_get_filtered_term_product_counts_query', 'nova_onsale_filter_woocommerce_get_filtered_term_product_counts_query', 10, 1 );
		endif;

		if ( get_query_var( Nova_OP::getOption('new_products_page_slug') ) === '1' ) :
			add_action( 'woocommerce_product_query', 'nova_new_products_query' );
			add_filter( 'woocommerce_page_title', 'nova_new_products_title' );
			add_filter( 'woocommerce_layered_nav_link', 'nova_new_products_filter_woocommerce_layered_nav_link', 10, 3 );
			add_filter( 'woocommerce_get_filtered_term_product_counts_query', 'nova_new_products_filter_woocommerce_get_filtered_term_product_counts_query', 10, 1 );
		endif;
	}
endif;

if ( ! function_exists( 'nova_on_sale_products_query' ) ) :
	/**
	 * Modify the archive query to display on-sale products
	 *
	 * @param  object $q products query
	 */
	function nova_on_sale_products_query( $q ) {
		$product_ids_on_sale = wc_get_product_ids_on_sale();
		$product_ids_on_sale= empty($product_ids_on_sale)? array(0) : $product_ids_on_sale;
		$q->set( 'post__in', (array)$product_ids_on_sale );
	}
endif;

if ( ! function_exists( 'nova_on_sale_products_title' ) ) :
	/**
	 * Modify the on-sale archive title
	 *
	 * @param  string $page_title Page title
	 */
	function nova_on_sale_products_title( $page_title ) {

		$page_title = empty( Nova_OP::getOption('sale_page_title') ) ? $page_title : Nova_OP::getOption('sale_page_title');

		return $page_title;
	}
endif;

if ( ! function_exists( 'nova_new_products_query' ) ) :
	/**
	 * Modify the archive query to display on-sale products
	 *
	 * @param  object $q products query
	 */
	function nova_new_products_query( $q ) {
		if ( Nova_OP::getOption('new_products_number_type') == 'day' ):
			$q->set( 'orderby', 'date' );
			$q->set( 'order', 'DESC' );
			$q->set('date_query', array('after' => Nova_OP::getOption('new_products_number').' days ago'));
			$q->set( 'no_found_rows', true);
			$per_page = 999;
		elseif ( Nova_OP::getOption('new_products_number_type') == 'last_added'):
			$q->set( 'orderby', 'date' );
			$q->set( 'order', 'DESC' );
			$q->set( 'no_found_rows', true);
			$per_page = empty(Nova_OP::getOption('new_products_number_last')) ? '8' : Nova_OP::getOption('new_products_number_last');
			// $q->set( 'posts_per_page', $per_page );
		endif;

		$q->set( 'posts_per_page', $per_page );
	}
endif;

if ( ! function_exists( 'nova_new_products_title' ) ) :
	/**
	 * Modify the on-sale archive title
	 *
	 * @param  string $page_title Page title
	 */
	function nova_new_products_title( $page_title ) {

		$page_title = empty( Nova_OP::getOption('new_products_page_title') ) ? $page_title : Nova_OP::getOption('new_products_page_title');

		return $page_title;
	}
endif;

if ( ! function_exists( 'nova_sale_page_url' )):
	/**
	 * Returns sale page URL or false if it's not active
	 *
	 * @return false|string
	 */
	function nova_sale_page_url() {
		if ( (Nova_OP::getOption('sale_page') === true) && ! empty( Nova_OP::getOption('sale_page_slug') ) ) :
			$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );

			if (substr($shop_page_url, -1) == "/") {
				$shop_page_url .= '?'. Nova_OP::getOption('sale_page_slug') .'=1';
			} else {
		   		$shop_page_url .= '&'. Nova_OP::getOption('sale_page_slug') .'=1';
		   	}

			return $shop_page_url;
		else:
			return false;
		endif;
	}
endif;

if ( ! function_exists( 'nova_new_products_page_url' )):
	/**
	 * Returns sale page URL or false if it's not active
	 *
	 * @return false|string
	 */
	function nova_new_products_page_url() {
		if ( (Nova_OP::getOption('new_products_page') === true) && ! empty( Nova_OP::getOption('new_products_page_slug') ) ) :
			$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );

			if (substr($shop_page_url, -1) == "/") {
				$shop_page_url .= '?'. Nova_OP::getOption('new_products_page_slug') .'=1';
			} else {
		   		$shop_page_url .= '&'. Nova_OP::getOption('new_products_page_slug') .'=1';
		   	}

			return $shop_page_url;
		else:
			return false;
		endif;
	}
endif;


if ( ! function_exists( 'nova_onsale_filter_woocommerce_layered_nav_link' )):
	/**
	 * Append the "on-sale" query argument if we're on the on-sale archive
	 *
	 * @param   $link
	 * @param   $term
	 * @param   $taxonomy
	 *
	 * @return $link
	 */
	function nova_onsale_filter_woocommerce_layered_nav_link( $link, $term, $taxonomy ) {
		if (substr($link, -1) == "/") {
			$link .= '?' . Nova_OP::getOption('sale_page_slug') .'=1';
		} else {
	   		$link .= '&' . Nova_OP::getOption('sale_page_slug') .'=1';
	   	}
	    return $link;
	};
endif;


if ( ! function_exists( 'nova_onsale_filter_woocommerce_get_filtered_term_product_counts_query' )):
	/**
	 * Modify the filter counts on onsale archive page
	 *
	 * @param  $query
	 *
	 * @return $query
	 */
	function nova_onsale_filter_woocommerce_get_filtered_term_product_counts_query( $query ) {
		global $wpdb;

	    $product_ids_on_sale = wc_get_product_ids_on_sale();
	    $product_ids_on_sale= empty($product_ids_on_sale)? '0' : implode(',',$product_ids_on_sale);
	    $query['where'] .= "AND {$wpdb->posts}.ID IN (" . $product_ids_on_sale .")";

	    return $query;
	};
endif;

if ( ! function_exists( 'nova_new_products_filter_woocommerce_layered_nav_link' )):
	/**
	 * Append the "new-products" query argument if we're on the new-products archive
	 *
	 * @param   $link
	 * @param   $term
	 * @param   $taxonomy
	 *
	 * @return $link
	 */
	function nova_new_products_filter_woocommerce_layered_nav_link( $link, $term, $taxonomy ) {
		if (substr($link, -1) == "/") {
			$link .= '?' . Nova_OP::getOption('new_products_page_slug') .'=1';
		} else {
	   		$link .= '&' . Nova_OP::getOption('new_products_page_slug') .'=1';
	   	}
	    return $link;
	};
endif;


if ( ! function_exists( 'nova_new_products_filter_woocommerce_get_filtered_term_product_counts_query' )):
	/**
	 * Modify the filter counts on new products archive page
	 *
	 * @param  $query
	 *
	 * @return $query
	 */
	function nova_new_products_filter_woocommerce_get_filtered_term_product_counts_query( $query ) {
		global $wpdb;

		if ( Nova_OP::getOption('new_products_number_type') == 'day' ):
			$query['where'] .= " AND post_date > '" . date('Y-m-d', strtotime('-'.Nova_OP::getOption('new_products_number').' days')) . "'";
		elseif ( Nova_OP::getOption('new_products_number_type') == 'last_added' ):
			$query['limit'] .= "LIMIT ". Nova_OP::getOption('new_products_number_last');
		endif;
	};
endif;

if (! function_exists( 'nova_count_new_products')):
	/**
	 * Get number of "new" products
	 *
	 * @return int
	 */
	function nova_count_new_products() {
		if ( Nova_OP::getOption('new_products_number_type') == 'day' ):
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => 999,
				'date_query' => array('after' => Nova_OP::getOption('new_products_number').' days ago')
			);
		elseif( Nova_OP::getOption('new_products_number_type') == 'last_added' ):
			$args = array(
				'post_type' => 'product',
				'posts_per_page' => Nova_OP::getOption('new_products_number_last'),
				'order'			=> 'DESC',
				'orderby'		=> 'date'
			);
		endif;
		$l = new WP_Query( $args );
		wp_reset_postdata();
		return $l->post_count;
	}
endif;

if (! function_exists( 'nova_count_sale_products')):
	/**
	 * Get number of sale products
	 *
	 * @return int
	 */
	function nova_count_sale_products() {
		$product_ids_on_sale = wc_get_product_ids_on_sale();
		$product_ids_on_sale= empty($product_ids_on_sale)? array(0) : $product_ids_on_sale;
		$args = array(
			'post_type' => 'product',
			'posts_per_page' => 999,
			'post__in' => $product_ids_on_sale,
			'tax_query' => array(
			    array(
			        'taxonomy' => 'product_visibility',
			        'field'    => 'name',
			        'terms'    => 'exclude-from-catalog',
			        'operator' => 'NOT IN',
			    ),
			),
		);

		$l = new WP_Query( $args );
		wp_reset_postdata();
		return $l->post_count;
	}
endif;

if (! function_exists( 'nova_count_categories' )):
	/**
	 * Category count - get_term seems to return incorrect count?
	 *
	 * @return int
	 */
	function nova_count_category() {
		global $wp_query;
		$cat_id = get_queried_object_id();

		$cs = get_terms('product_cat');
		$cC = false;

		if (!empty($cs) && is_array($cs)) {
			foreach ($cs as $c) {
				if ($c->term_id == $cat_id)
					$cC = $c;
			}
		}

		if (!empty($cC)) return $cC->count;

		return false;
	}
endif;

if (! function_exists( 'nova_is_custom_archive')):
	/**
	 * Returns true on on-sale or new products archives
	 *
	 * @return bool
	 */
	function nova_is_custom_archive() {
		return ( (get_query_var( Nova_OP::getOption('new_products_page_slug') ) === '1') || (get_query_var( Nova_OP::getOption('sale_page_slug') ) === '1') );
	}
endif;

//==============================================================================
// WooCommerce Number of Products per Page Allow
//==============================================================================
if(!function_exists('nova_woo_get_product_per_page_array')){
    function nova_woo_get_product_per_page_array(){
        $per_page_array = apply_filters('irina/filter/get_product_per_page_array', Nova_OP::getOption('product_per_page_allow'));
        if(!empty($per_page_array)){
            $per_page_array = explode(',', $per_page_array);
            $per_page_array = array_map('trim', $per_page_array);
            $per_page_array = array_map('absint', $per_page_array);
            asort($per_page_array);
            return $per_page_array;
        }
        else{
            return array();
        }
    }
}

if (! function_exists( 'nova_get_parameter_per_page')):
function nova_get_parameter_per_page($per_page) {
		if (isset($_GET['per_page']) && ($_per_page = $_GET['per_page'])) {
				$param_allow = nova_woo_get_product_per_page_array();
				if(!empty($param_allow) && in_array($_per_page, $param_allow)){
						$per_page = $_per_page;
				}
		}
		return $per_page;
}
endif;

if (! function_exists( 'nova_set_cookie_default')):
function nova_set_cookie_default(){
		if (isset($_GET['per_page']) && $per_page = $_GET['per_page']) {
				add_filter('irina/filter/get_product_per_page','nova_get_parameter_per_page');
		}
}
add_action('init','nova_set_cookie_default', 2 );
endif;

if(!function_exists('nova_woo_get_product_per_page')){
    function nova_woo_get_product_per_page(){
        return apply_filters('irina/filter/get_product_per_page', Nova_OP::getOption('shop_product_per_page'));
    }
}
if(!function_exists('nova_woo_get_product_per_row')){
    function nova_woo_get_product_per_row(){
        return apply_filters('irina/filter/get_product_per_row', Nova_OP::getOption('shop_product_columns'));
    }
}
//==============================================================================
// WooCommerce Custom Tabs
//==============================================================================
if(!function_exists('nova_woo_custom_info_tab')){
    function nova_woo_custom_info_tab(){
				$tabs = apply_filters( 'woocommerce_product_tabs', array() );
        echo '<ul class="nova-product-info-mn">';
				foreach ( $tabs as $key => $tab ) :
					$icon  = '';
					if($key == 'description')  {
						if(Nova_OP::getOption('panel_description_icon')) {
							$icon = '<img  class="panel-icon" src="'.esc_url( Nova_OP::getOption('panel_description_icon') ).'" />';
						}
					}
					if($key == 'additional_information')  {
						if(Nova_OP::getOption('panel_additional_information_icon')) {
							$icon = '<img  class="panel-icon" src="'.esc_url( Nova_OP::getOption('panel_additional_information_icon') ).'" />';
						}
					}
					if($key == 'reviews')  {
						if(Nova_OP::getOption('panel_reviews_icon')) {
							$icon = '<img  class="panel-icon" src="'.esc_url( Nova_OP::getOption('panel_reviews_icon') ).'" />';
						}
					}
					echo '<li class="panel_'.esc_attr( $key ).'"><a data-toggle="'.esc_attr( $key ).'">'.$icon.apply_filters( 'woocommerce_product_' . $key . '_tab_title', esc_html( $tab['title'] ), $key ).'</a></li>';
				endforeach;
				if( 1 == Nova_OP::getOption('single_product_size_guide') ) {
					$icon_guide =  '';
					if(Nova_OP::getOption('panel_sizeguide_icon')) {
						$icon_guide = '<img  class="panel-icon" src="'.esc_url( Nova_OP::getOption('panel_sizeguide_icon') ).'" />';
					}
					echo '<li class="panel_size_guide"><a data-toggle="SizeGuide">'.$icon_guide.esc_html__( 'Size Guidelines', 'irina' ).'</a></li>';
				}
				if( 1 == Nova_OP::getOption('single_product_store_availiable') ) {
					$icon_store =  '';
					if(Nova_OP::getOption('panel_store_available_icon')) {
						$icon_store = '<img  class="panel-icon" src="'.esc_url( Nova_OP::getOption('panel_store_available_icon') ).'" />';
					}
					echo '<li class="panel_size_guide"><a target="_blank" href="'.esc_url( Nova_OP::getOption('single_product_store_availiable_url') ).'">'.$icon_store.esc_html__( 'Store availability', 'irina' ).'</a></li>';
				}
				echo '</ul>';
    }
}
/**
 * Adds custom classes to product image gallery
 *
 * @param array $classes Gallery classes.
 *
 * @return array
 */
if( !function_exists('nova_woo_gallery_classes')  ) {
	function nova_woo_gallery_classes( $classes ) {
		global $product;

		if ( current_theme_supports( 'wc-product-gallery-lightbox' ) ) {
			$classes[] = 'lightbox-support';
		}

		if ( current_theme_supports( 'wc-product-gallery-zoom' ) ) {
			$classes[] = 'zoom-support';
		}

		$attachment_ids = $product->get_gallery_image_ids();

		if ( ! $attachment_ids ) {
			$classes[] = 'no-thumbnails';
		}

		return $classes;
	}
}
if( !function_exists('nova_product_gallery_is_slider')  ) {
	function nova_product_gallery_is_slider() {
		$support = ! in_array( Nova_OP::getOption( 'product_preset' ), array( 'style_3' ) );
		return apply_filters( 'nova_product_gallery_is_slider', $support );
	}
}
/**
 * Change the image size of product style_3.
 *
 * @param string $size Image size name.
 *
 * @return string
 */
if( !function_exists('nova_gallery_image_size_large')  ) {
	function nova_gallery_image_size_large( $size ) {
		return 'woocommerce_single';
	}
}
// disable photoswipe js file
if( !function_exists('nova_photoswipe_dequeue_script')  ) {
function nova_photoswipe_dequeue_script() {
		if ( defined('ELEMENTOR_VERSION' ) ) {
			wp_dequeue_script( 'photoswipe-ui-default' );
		}
}
add_action( 'wp_print_scripts', 'nova_photoswipe_dequeue_script', 100 );
}
