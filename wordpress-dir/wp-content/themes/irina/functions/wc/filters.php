<?php

if ( NOVA_WOOCOMMERCE_IS_ACTIVE ) {



	//==============================================================================
	// Remove relative URLs for WooCommerce product images
	//==============================================================================

	add_filter( 'woocommerce_product_get_image', function( $url, $product, $size, $attr, $placeholder, $image ) {
		return $image;
	}, 10, 6 );


	//==============================================================================
	// Show Woocommerce Cart Widget Everywhere
	//==============================================================================

	if ( ! function_exists('nova_woocommerce_widget_cart_everywhere') ) :
	function nova_woocommerce_widget_cart_everywhere() {
	    return false;
	}
	add_filter( 'woocommerce_widget_cart_is_hidden', 'nova_woocommerce_widget_cart_everywhere', 10, 1 );
	endif;


	//==============================================================================
	// WooCommerce Cross Sell Columns
	//==============================================================================

	if ( ! function_exists('nova_cross_sells_columns') ) :
	function nova_cross_sells_columns( $columns ) {
		return 4;
	}
	add_filter( 'woocommerce_cross_sells_columns', 'nova_cross_sells_columns' );
	endif;


	//==============================================================================
	// WooCommerce Number of Related Products
	//==============================================================================

	if ( ! function_exists('woocommerce_output_related_products') ) :
	function woocommerce_output_related_products() {
		$atts = array(
			'posts_per_page' => Nova_OP::getOption('related_products_column'),
			'columns' 		 => Nova_OP::getOption('related_products_column'),
			'orderby'        => 'rand'
		);
		woocommerce_related_products($atts);
	}
	endif;


	//==============================================================================
	// WooCommerce Product Carousel Options
	//==============================================================================

	if ( ! function_exists('nova_woocommerce_single_product_carousel_options') ) :
	function nova_woocommerce_single_product_carousel_options( $array ) {

	    $options = array(
			'rtl'            => is_rtl(),
			'animation'      => 'slide',
			'smoothHeight'   => true,
			'directionNav'   => false,
			'controlNav'     => 'thumbnails',
			'slideshow'      => false,
			'animationSpeed' => 300,
			'animationLoop'  => false,
		);

	    return $options;
	}
	add_filter( 'woocommerce_single_product_carousel_options', 'nova_woocommerce_single_product_carousel_options', 10, 1 );
	endif;


	//==============================================================================
	// WooCommerce Post Count Filter
	//==============================================================================

	if ( ! function_exists('nova_wc_categories_postcount_filter') ) :
	function nova_wc_categories_postcount_filter($variable) {
		$variable = str_replace('<span class="count">(', '<span class="count">', $variable);
		$variable = str_replace(')</span>', '</span>', $variable);
		return $variable;
	}
	add_filter('wp_list_categories','nova_wc_categories_postcount_filter');
	endif;


	//==============================================================================
	// WooCommerce Layered Nav Filter
	//==============================================================================

	if ( ! function_exists('nova_layered_nav_filter') ) :
	function nova_layered_nav_filter($variable) {
		$variable = str_replace('(', '', $variable);
		$variable = str_replace(')', '', $variable);
		return $variable;
	}
	add_filter( 'woocommerce_layered_nav_count', 'nova_layered_nav_filter' );
	endif;


	//==============================================================================
	// WooCommerce Rating Count Filter
	//==============================================================================

	if ( ! function_exists('nova_rating_filter_count') ) :
	function nova_rating_filter_count($variable) {
		$variable = str_replace('(', '', $variable);
		$variable = str_replace(')', '', $variable);
		return $variable;
	}
	add_filter( 'woocommerce_rating_filter_count', 'nova_rating_filter_count' );
	endif;


	//==============================================================================
	// WooCommerce Remove Description Title
	//==============================================================================

	function nova_product_description_heading() {
	    echo "";
	}
	add_filter( 'woocommerce_product_description_heading', 'nova_product_description_heading' );


	//==============================================================================
	// WooCommerce Remove Additional Information Title
	//==============================================================================

	function nova_product_additional_information_heading() {
	    echo "";
	}
	add_filter( 'woocommerce_product_additional_information_heading', 'nova_product_additional_information_heading' );


	//==============================================================================
	// WooCommerce Breadcrumb
	//==============================================================================

	if ( ! function_exists('nova_custom_breadcrumb') ) :
	function nova_custom_breadcrumb($defaults) {
		$defaults['delimiter'] = '<span class="delimiter">/</span>';
		$defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb">';
		return $defaults;
	}
	add_filter( 'woocommerce_breadcrumb_defaults', 'nova_custom_breadcrumb' );
	endif;


	//==============================================================================
	// WooCommerce Categories Product Count
	//==============================================================================

	if ( ! function_exists('nova_categories_count') ) :
	add_filter( 'woocommerce_subcategory_count_html', 'nova_categories_count');
	function nova_categories_count( $count ) {
		$count = str_replace( '(', '', $count);
		$count = str_replace( ')', '', $count);
		return $count;
	}
	endif;


	//==============================================================================
	// Display Empty Subcategories
	//==============================================================================

	add_filter( 'woocommerce_product_subcategories_hide_empty', 'hide_empty_categories', 10, 1 );
	function hide_empty_categories ( $show_empty ) {
	    $hide_empty  =  FALSE;
	}


	//==============================================================================
	//	WooCommerce after cart empty products
	//==============================================================================

	if ( !function_exists('nova_cart_is_empty') ) :
	add_filter( 'woocommerce_cart_is_empty','nova_cart_is_empty');
	function nova_cart_is_empty() {
		echo '<h3 class="product-suggestions-title">'. esc_html__('You might like these', 'irina') . '</h3>';
		echo do_shortcode('[featured_products per_page="4" columns="4"]');
	}
	endif;


	//==============================================================================
	//	WooCommerce change number of orders per page
	//==============================================================================

	if ( !function_exists('nova_filter_woocommerce_my_account_my_orders_query') ) :
	add_filter( 'woocommerce_my_account_my_orders_query', 'nova_filter_woocommerce_my_account_my_orders_query', 10, 1 );
	function nova_filter_woocommerce_my_account_my_orders_query( $array ) {
	    $array['numberposts'] = 10;
	    return $array;
	};
	endif;


	//==============================================================================
	//	New products badge
	//==============================================================================

	if ( !function_exists('nova_new_product_badge') ) :
	add_filter( 'woocommerce_product_badges', 'nova_new_product_badge');
	function nova_new_product_badge() {
		static $latest_products;

		if ( Nova_OP::getOption('new_products_number_type') == 'day' && Nova_OP::getOption('new_products_page') === true && !empty(Nova_OP::getOption('new_products_badge_text')) && !empty(Nova_OP::getOption('new_products_number'))) {
			$postdate 		= get_the_time( 'Y-m-d' );			// Post date
			$postdatestamp 	= strtotime( $postdate );
			$new_interval 	= Nova_OP::getOption('new_products_number');

			if ( ( time() - ( 60 * 60 * 24 * $new_interval ) ) < $postdatestamp ) { // If the product was published within the newness time frame display the new badge
				echo '<span class="nova_new_product">' . sprintf(__( '%s', 'irina' ), Nova_OP::getOption('new_products_badge_text')) . '</span>';
			}
		}

		if ( Nova_OP::getOption('new_products_number_type') == 'last_added' && Nova_OP::getOption('new_products_page') === true && !empty(Nova_OP::getOption('new_products_badge_text')) && !empty(Nova_OP::getOption('new_products_number_last'))) {
			$thisID = get_the_ID();
			if (!(isset($latest_products) && is_array($latest_products))) :
				$args = array(
					'post_type' => 'product',
					'posts_per_page' => Nova_OP::getOption('new_products_number_last'),
					'order'			=> 'DESC',
					'orderby'		=> 'date'
				);
				$l = new WP_Query( $args );
				// wp_reset_postdata();
				$latest_products = array();
				foreach ( $l->posts AS $lp ) {
					$latest_products[] = $lp->ID;
				}
				// set_transient('nova_latest_products', $latest_products);
			endif;

			if (isset($latest_products) && is_array($latest_products) && in_array($thisID, $latest_products))
				echo '<span class="nova_new_product">' . sprintf(__( '%s', 'irina' ), Nova_OP::getOption('new_products_badge_text')) . '</span>';
		}
	}
	endif;


	//==============================================================================
	//	Single Product - Number of Thumbnails
	//==============================================================================

	add_filter( 'woocommerce_single_product_image_gallery_classes', 'nova_columns_product_gallery_thumbs' );
	function nova_columns_product_gallery_thumbs( $wrapper_classes ) {
		$columns = 6; // change this to 2, 3, 5, etc. Default is 4.
		$wrapper_classes[2] = 'woocommerce-product-gallery--columns-' . absint( $columns );
		return $wrapper_classes;
	}

	//==============================================================================
	//	Enable Youtube JS API
	//==============================================================================

	if ( !function_exists( 'nova_enable_youtube_js_api') ) :
	add_filter( 'oembed_result', 'nova_enable_youtube_js_api', 10, 3 );
	function nova_enable_youtube_js_api( $html, $url, $args ) {

		if ( strstr( $html,'youtube.com/embed/' ) ) {
			$html = str_replace( '?feature=oembed', '?feature=oembed&enablejsapi=1&rel=0&showinfo=0&color=white', $html );
		}

	    return $html;
	}
	endif;

	//==============================================================================
	//	Update Cart Items Number
	//==============================================================================

	if ( !function_exists( 'nova_js_count_bag_item') ) :
	add_filter('woocommerce_add_to_cart_fragments', 'nova_js_count_bag_item');
	function nova_js_count_bag_item($fragments) {
		ob_start(); ?>

        <div class="count-badge js_count_bag_item"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></div>

		<?php
		$fragments['.js_count_bag_item'] = ob_get_clean();
		return $fragments;
	}
	endif;

	if ( !function_exists( 'nova_js_count_bag_item_canvas') ) :
	add_filter('woocommerce_add_to_cart_fragments', 'nova_js_count_bag_item_canvas');
	function nova_js_count_bag_item_canvas($fragments) {
		ob_start(); ?>

				<span class="nova_js_count_bag_item_canvas count-item-canvas"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>

		<?php
		$fragments['.nova_js_count_bag_item_canvas'] = ob_get_clean();
		return $fragments;
	}
	endif;

}

//==============================================================================
//	Fash sale percent
//==============================================================================
if ( !function_exists( 'nova_percentage_sale') ) :
if( 1 ==  Nova_OP::getOption('sale_page_badge_type') ):
	add_filter( 'woocommerce_sale_flash', 'nova_percentage_sale', 11, 3 );
endif;
function nova_percentage_sale( $text, $post, $product ) {
    $discount = 0;
    if ( $product->get_type() == 'variable' ) {
        $available_variations = $product->get_available_variations();
        $maximumper = 0;
        for ($i = 0; $i < count($available_variations); ++$i) {
            $variation_id=$available_variations[$i]['variation_id'];
            $variable_product1= new WC_Product_Variation( $variation_id );
            $regular_price = $variable_product1->get_regular_price();
            $sales_price = $variable_product1->get_sale_price();
            if( $sales_price ) {
                $percentage= round( ( ( $regular_price - $sales_price ) / $regular_price ) * 100 ) ;
                if ($percentage > $maximumper) {
                    $maximumper = $percentage;
                }
            }
        }
        $text = '<span class="onsale">-' . $maximumper  . '%</span>';
    } elseif ( $product->get_type() == 'simple' ) {
        $percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
        $text = '<span class="onsale">-' . $percentage . '%</span>';
    }

    return $text;
}
endif;
//==============================================================================
//	Change product per page default
//==============================================================================
if ( !function_exists( 'nova_change_per_page_default') ) :
function nova_change_per_page_default() {
	$per_page = nova_woo_get_product_per_page();
	return $per_page;
}
add_filter('loop_shop_per_page','nova_change_per_page_default', 10 );
endif;

//==============================================================================
//	Change product per page default
//==============================================================================
if ( !function_exists( 'nova_change_per_row_default') ) :
function nova_change_per_row_default() {
	$per_row = nova_woo_get_product_per_row();
	return $per_row;
}
add_filter('loop_shop_columns','nova_change_per_row_default', 999 );
endif;

//==============================================================================
//	Change photoswipe options
//==============================================================================
if ( !function_exists( 'nova_photoswipe_options') ) :
	function nova_photoswipe_options( $options ) {
			$options['captionEl']             = false;
			$options['showHideOpacity']       = true;
			$options['showAnimationDuration'] = 400;
			$options['hideAnimationDuration'] = 400;

			return $options;
	}
	add_filter( 'woocommerce_single_product_photoswipe_options', 'nova_photoswipe_options' );
endif;
