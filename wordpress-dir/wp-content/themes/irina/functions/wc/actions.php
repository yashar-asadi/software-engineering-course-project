<?php

if ( NOVA_WOOCOMMERCE_IS_ACTIVE ) {

	//==============================================================================
	// Remove Woocommerce Styles
	//==============================================================================

	if ( ! function_exists('nova_remove_woocommerce_styles') ) :
	function nova_remove_woocommerce_styles() {
		add_filter( 'woocommerce_enqueue_styles', '__return_false' );
	}
	add_action( 'after_setup_theme', 'nova_remove_woocommerce_styles' );
	endif;


	//==============================================================================
    // Breadcrumbs
    //==============================================================================

    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

    //==============================================================================
    // Result Count & Catalog Ordering
    //==============================================================================

    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20, 0 );
    remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30, 0 );
    add_action( 'nova_woocommerce_result_count', 'woocommerce_result_count', 20 );
    add_action( 'nova_woocommerce_catalog_ordering', 'woocommerce_catalog_ordering', 30, 0 );


	//==============================================================================
	// Gallery
	//==============================================================================

	add_action( 'after_setup_theme', 'nova_woocommerce_gallery' );
	function nova_woocommerce_gallery() {
		if ( Nova_OP::getOption( 'product_image_zoom' ) ) {
			add_theme_support( 'wc-product-gallery-zoom' );
		}

		if ( Nova_OP::getOption( 'product_image_lightbox' ) ) {
			add_theme_support( 'wc-product-gallery-lightbox' );
		}
		if ( nova_product_gallery_is_slider() ) {
			add_theme_support( 'wc-product-gallery-slider' );
		}
	}

	//==============================================================================
	// Cart
	//==============================================================================

	remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
	add_action( 'woocommerce_after_cart_table', 'woocommerce_cross_sell_display' );

	//==============================================================================
	// Woocommerce Product Out of Stock
	//==============================================================================

	add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_stock', 10 );
	function woocommerce_template_loop_stock() {
	    global $product;
	    if ( ! $product->is_in_stock() )
	        echo '<span class="stock out-of-stock">' . esc_html__( 'Out of stock', 'irina' ) . '</span>';
	}

	//==============================================================================
	// Add Wishlist Icon in Product Card
	//==============================================================================

	function add_wishlist_icon_in_product_card() {
		if (class_exists('YITH_WCWL')) :
			global $product;
		?>

			<a href="<?php echo YITH_WCWL()->is_product_in_wishlist($product->get_id())? esc_url(YITH_WCWL()->get_wishlist_url()) : esc_url(add_query_arg('add_to_wishlist', $product->get_id())); ?>"
				data-product-id="<?php echo esc_attr($product->get_id()); ?>"
				data-product-type="<?php echo esc_attr($product->get_type()); ?>"
				data-wishlist-url="<?php echo esc_url(YITH_WCWL()->get_wishlist_url()); ?>"
				data-browse-wishlist-text="<?php echo esc_attr(get_option('yith_wcwl_browse_wishlist_text')); ?>"
				class="nova_product_wishlist_btn <?php echo YITH_WCWL()->is_product_in_wishlist($product->get_id())? 'clicked added' : 'add_to_wishlist'; ?>" rel="nofollow">
				<i class="inova ic-favorite"></i>
			</a>

		<?php
		endif;
	}


	//==============================================================================
	//	Product Quick View
	//==============================================================================

	if ( !function_exists('nova_product_quick_view_fn')):
	add_action( 'wp_ajax_nova_product_quick_view', 'nova_product_quick_view_fn');
	add_action( 'wp_ajax_nopriv_nova_product_quick_view', 'nova_product_quick_view_fn');
	function nova_product_quick_view_fn() {
		if (!isset( $_REQUEST['product_id'])) {
			die();
		}
		$product_id = intval($_REQUEST['product_id']);
		// wp_query for the product
		wp('p='.$product_id.'&post_type=product');
		ob_start();
		get_template_part( 'woocommerce/quick-view' );
		echo ob_get_clean();
		die();
	}
	endif;


	if ( !function_exists('nova_product_quick_view_button')):
	function nova_product_quick_view_button() {
		global $product, $custom_shop_quick_view;
		echo '
			<a href="#" class="nova_product_quick_view_btn" data-product-id="' . $product->get_id() . '" rel="nofollow"><i class="inova ic-zoom"></i></a>
		';
	}
	endif;


	//==============================================================================
	// Active Filters Before Shop Loop
	//==============================================================================

	if ( ! function_exists('nova_show_active_filters')) {
		add_action('woocommerce_before_shop_loop', 'nova_show_active_filters');
		function nova_show_active_filters() {
			the_widget('WC_Widget_Layered_Nav_Filters');
		}
	}

	//==============================================================================
	// Remove Single Product Sale from the original place
	//==============================================================================

	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	add_action( 'woocommerce_product_badges', 'woocommerce_show_product_sale_flash', 15 );

	//==============================================================================
	// woocommerce_before_add_to_cart_button Open Div
	//==============================================================================

	if( ! function_exists('woocommerce_before_add_to_cart_button_open_div') ) :
	add_action( 'woocommerce_before_add_to_cart_button', 'woocommerce_before_add_to_cart_button_open_div', 100 );
	function woocommerce_before_add_to_cart_button_open_div() {
		echo '<div class="woocommerce-product-details__add-to-cart">';
	}
	endif;

	//==============================================================================
	// woocommerce_after_add_to_cart_button Closing Div
	//==============================================================================

	if( ! function_exists('woocommerce_after_add_to_cart_button_closing_div') ) :
	add_action( 'woocommerce_after_add_to_cart_button', 'woocommerce_after_add_to_cart_button_closing_div', 0 );
	function woocommerce_after_add_to_cart_button_closing_div() {
		echo '</div>';
	}
	endif;

	//==============================================================================
	//	Custom WooCommerce subcategory open box
	//==============================================================================
	if ( ! function_exists('nova_woocommerce_subcategory_box_open') ):
		function nova_woocommerce_subcategory_box_open( ) {
			echo '<div class="nova-banner-box">';
		}
		remove_action('woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open');
		add_action('woocommerce_before_subcategory', 'nova_woocommerce_subcategory_box_open', 10);
	endif;
	//==============================================================================
	//	Custom WooCommerce subcategory images
	//==============================================================================

	if ( ! function_exists('nova_woocommerce_subcategory_thumbnail') ):
	remove_action('woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail');
	add_action('woocommerce_before_subcategory_title', 'nova_woocommerce_subcategory_thumbnail', 10, 1);
	function nova_woocommerce_subcategory_thumbnail( $category ) {

		$thumbnail_id  			= get_term_meta( $category->term_id, 'thumbnail_id', true );

		if ( $thumbnail_id ) {
			$image        = wp_get_attachment_image_src( $thumbnail_id, 'woocommerce_single' );
			$image        = $image[0];
			$image_srcset = function_exists( 'wp_get_attachment_image_srcset' ) ? wp_get_attachment_image_srcset( $thumbnail_id, 'shop_single_image_size' ) : false;
			$image_sizes  = function_exists( 'wp_get_attachment_image_sizes' ) ? wp_get_attachment_image_sizes( $thumbnail_id, 'shop_single_image_size' ) : false;
		} else {
			$image        = wc_placeholder_img_src();
			$image_srcset = $image_sizes = false;
		}

		if ( $image ) {
			// Prevent esc_url from breaking spaces in urls for image embeds
			// Ref: https://core.trac.wordpress.org/ticket/23605
			$image = str_replace( ' ', '%20', $image );

			echo '<div class="nova-banner-box__image">
				<span class="woocommerce-loop-category__thumbnail" style="background-image :url(' . esc_url( $image ) . ');"></span>
			</div>';
		}
	}
	endif;

	//==============================================================================
	//	Custom WooCommerce subcategory close box
	//==============================================================================
	if ( ! function_exists('nova_woocommerce_subcategory_box_close') ):
		function nova_woocommerce_subcategory_box_close( $category ) {
			echo '<a class="nova-banner-box__link-overlay woocommerce-loop-category__link" href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '"><span></span></a>';
			echo '</div>';
		}
		remove_action('woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close');
		add_action('woocommerce_after_subcategory', 'nova_woocommerce_subcategory_box_close', 10);
	endif;

	//==============================================================================
	//	Wishlist Button Shortcode For QuickView
	//==============================================================================

	function quickview_add_to_wishlist() {
		if (class_exists('YITH_WCWL')):
	    	echo do_shortcode('[yith_wcwl_add_to_wishlist]');
	    endif;
	}

	//==============================================================================
	//	Cart Page Add custom div anchor for sticky
	//==============================================================================

	add_action( 'woocommerce_after_cart','custom_cart_page_bottom_anchor', 10, 1);
	function custom_cart_page_bottom_anchor($bottom_anchor) {
		$cart_bottom_anchor = '<div id="cart_bottom_anchor"></div>';
		print wp_kses($cart_bottom_anchor,'simple');
	}

	//==============================================================================
	//	Cart Page Add custom div anchor for sticky
	//==============================================================================

	add_action( 'woocommerce_after_checkout_form','custom_checkout_page_bottom_anchor', 10, 1);
	function custom_checkout_page_bottom_anchor($bottom_anchor) {
		$checkout_bottom_anchor = '<div id="checkout_bottom_anchor"></div>';
		print wp_kses($checkout_bottom_anchor,'simple');
	}

	//==============================================================================
	//	Woocommerce change default placeholder
	//==============================================================================

	add_action( 'init', 'nova_change_default_woocommerce_placeholder' );
	function nova_change_default_woocommerce_placeholder() {
	  add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');
		function custom_woocommerce_placeholder_img_src( $src ) {
			$src = get_template_directory_uri().'/assets/images/placeholder.png';
			return $src;
		}
	}
	//==============================================================================
	//	Exclude products from default wordpress search
	//==============================================================================
	if ( !function_exists('nova_exclude_products')):
	add_action( 'pre_get_posts', 'nova_exclude_products', 99 );
	function nova_exclude_products() {
		global $wp_post_types;
		if ( post_type_exists( 'product' ) && is_search()) {
			//die('test');
			$wp_post_types['product']->exclude_from_search = true;
		}
	}
	endif;

	//==============================================================================
	//	Ajax search form
	//==============================================================================
	if ( !function_exists('nova_ajax_search_form')):
	add_action( 'nova_ajax_search_form', 'nova_ajax_search_form');
	function nova_ajax_search_form() {
		$rand_id = rand(1, 999);
		if( ( 1 == Nova_OP::getOption('header_search_toggle') ) ) :

			ob_start();
			$notsearch = false;

			if (isset($_GET['s']) && isset($_GET['post_type']) && $_GET['post_type']== 'product') {
				$args = array(
					's'						 => sanitize_text_field($_GET['s']),
					'posts_per_page'		 => 4,
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

				if ( isset( $_GET['search_category'] ) && ($_GET['search_category']!= 'all') ) {
			        $args['tax_query'] = array(
				        'relation' => 'AND',
				        array(
					        'taxonomy' => 'product_cat',
					        'field'    => 'slug',
					        'terms'    => sanitize_text_field($_GET['search_category'])
				        )
			        );
		        }
			} else {
				$notsearch = true;

				$meta_query  = WC()->query->get_meta_query();
			    $tax_query   = WC()->query->get_tax_query();
			    $tax_query[] = array(
			        'taxonomy' => 'product_visibility',
			        'field'    => 'name',
			        'terms'    => 'featured',
			        'operator' => 'IN',
			    );

			    $args = array(
			        'post_type'           => 'product',
			        'post_status'         => 'publish',
			        'ignore_sticky_posts' => 1,
			        'posts_per_page'      => 4,
			        'meta_query'          => $meta_query,
			        'tax_query'           => $tax_query,
			    );
			}

			echo '
				<form class="header_search_form" role="search" method="get" action="' . esc_url( home_url( '/'  ) ) .'">
					<div class="header_search_form_inner">
					<div class="header_search_input_wrapper">
						<input
							name="s"
							id="search_'.$rand_id.'"
							class="header_search_input"
							type="search"
							autocomplete="off"
							value="' . get_search_query() .'"
							data-min-chars="3"
							placeholder="' . esc_attr__( 'Product Search', 'irina' ) . '"
							/>

							<input type="hidden" name="post_type" value="product" />
					</div>';

					if( ( '1' == Nova_OP::getOption('header_search_by_category') ) ) :

						$categories= get_terms( array( 'taxonomy' => 'product_cat','hide_empty' => 0,  'parent' => 0) );

						if( $categories ) {

							echo '<div class="header_search_select_wrapper">
									<select name="search_category" id="header_search_category_'.$rand_id.'" class="header_search_select">
										<option value="all" selected>' . esc_html__( 'Select Category', 'irina' ) . '</option>';

											foreach ($categories as $cat) {
												printf('<option %s value="%s">%s</option>', isset($_GET['search_category']) && $_GET['search_category']== $cat->slug? 'selected' : '', $cat->slug, $cat->name);
											}

							echo '</select>
							</div>';
						}
					endif;
					echo '<div class="header_search_button_wrapper">
											<button class="header_search_button" type="submit">
											<svg class="irina-btn-search">
											 <use xlink:href="#irina-btn-search"></use>
											</svg>
											</button>
										</div>';
				echo '
					</div>
					<div class="header_search_ajax_loading">
						<span></span>
					</div>
					<div class="header_search_ajax_results_wrapper">
						<div class="header_search_ajax_results">
							<div class="header_search_icon">
							<svg class="irina-search-product-icon">
								<use xlink:href="#irina-search-product-icon"></use>
							</svg>
							</div>';
						echo '</div>
					</div>
				</form>';
			$output = ob_end_flush();

		endif;
	}
	endif;

	//==============================================================================
	//	External Product in new tab
	//==============================================================================
	remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
	add_action( 'woocommerce_external_add_to_cart', 'nova_external_add_to_cart', 30 );
	function nova_external_add_to_cart(){

	    global $product;

	    if ( ! $product->add_to_cart_url() ) {
	        return;
	    }

	    $product_url = $product->add_to_cart_url();
	    $button_text = $product->single_add_to_cart_text();

	    do_action( 'woocommerce_before_add_to_cart_button' ); ?>
	    <p class="cart">
	        <a href="<?php echo esc_url( $product_url ); ?>" target="_blank" rel="nofollow" class="single_add_to_cart_button button alt"><?php echo esc_html( $button_text ); ?></a>
	    </p>
	    <?php do_action( 'woocommerce_after_add_to_cart_button' );
	}

	//==============================================================================
	//	0 count for categories in shop archive
	//==============================================================================\
	if (!function_exists('nova_category_title')):
		function nova_category_title( $category ) {
			?>
			<div class="nova-banner-box__info">
				<a href="<?php echo esc_url( get_term_link( $category, 'product_cat' ) ) ?>">
				<h2 class="woocommerce-loop-category__title">
					<?php
					echo esc_html( $category->name );

					if ( $category->count >= 0 ) {
						echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . esc_html( $category->count ) . ')</mark>', $category ); // WPCS: XSS ok.
					}
					?>
				</h2>
				</a>
			</div>
			<?php
		}
		remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
		add_action('woocommerce_shop_loop_subcategory_title', 'nova_category_title', 10, 1);
	endif;

	if ( !function_exists( 'nova_category_large_icons' )):
	add_action( 'nova_category_large_icons', 'nova_category_large_icons');
	/**
	 * Output category items as selected in mega dropdown
	 *
	 *
	 * @return html
	 */
	function nova_category_large_icons() {
		if ( !NOVA_WOOCOMMERCE_IS_ACTIVE ) return;
			$cat_list = Nova_OP::getOption('nav_button_categories', 0);
			$args= array( 'taxonomy' => 'product_cat','hide_empty' => 0, 'orderby' => 'ASC',  'parent' =>0, 'include' => $cat_list );

			$cats = get_terms( $args );

			if ( is_array($cat_list)):
			$unsorted = array();
			$sorted   = array();

			foreach ($cats as $v) {
				$unsorted[$v->term_id] = $v;
			}

			foreach ($cat_list as $v) {
				if (isset($unsorted[$v]))
					$sorted[] = $unsorted[$v];
			}
			else:
				$sorted = $cats;
			endif;

			echo '<div class="megamenu_icon_list">';

			if ( nova_new_products_page_url() !== false ):
				echo '<a href="' . nova_new_products_page_url() . '"><i class="irina-icons-ui_star"></i><span>'. nova_new_products_title('') .'</span></a>';
			endif;

			if ( nova_sale_page_url() !== false ):
				echo '<a href="'.nova_sale_page_url().'"><i class="irina-icons-ecommerce_discount-symbol"></i><span>'. nova_on_sale_products_title('') .'</span></a>';
			endif;

			foreach( $sorted as $cat ) {
				$icon_type = get_term_meta( $cat->term_id, 'nova_icon_type', true );
				if ( $icon_type == 'custom_icon' ) {
					$thumbnail_id 	= get_term_meta( $cat->term_id, 'icon_img_id', true );
					if ($thumbnail_id)
						$icon = wp_get_attachment_thumb_url( $thumbnail_id );
					else
						$icon = wc_placeholder_img_src();
					// Prevent esc_url from breaking spaces in urls for image embeds
					// Ref: https://core.trac.wordpress.org/ticket/23605
					$icon = str_replace( ' ', '%20', $icon );
					echo '<a href="'.esc_url( get_term_link( $cat->term_id ) ).'"><img src="'. $icon .'" /><span>'. $cat->name .'</span></a>';
				} else {
					$icon = get_term_meta( $cat->term_id, 'icon_id', true );
					echo '<a href="'.esc_url( get_term_link( $cat->term_id ) ).'"><i class="'. $icon .'"></i><span>'. $cat->name .'</span></a>';
				}
			}
			echo '</div>';
	}
	endif;

}
//==============================================================================
//	Product Image for Quickview
//==============================================================================

if ( ! function_exists( 'nova_show_qv_product_images' ) ) {

    /**
     * Output the product image before the single product summary.
     */
    function nova_show_qv_product_images() {
        wc_get_template( 'product-images/quick-view.php' );
    }
}

//==============================================================================
//	Add Wishlist button after add cart button
//==============================================================================
if( defined( 'YITH_WCWL' ) && ! function_exists( 'nova_wcwl_move_wishlist_button' ) ){
	function nova_wcwl_move_wishlist_button(  ){
		echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
	}
	add_action( 'woocommerce_after_add_to_cart_button', 'nova_wcwl_move_wishlist_button' );
}
//==============================================================================
//	Add size diverline
//==============================================================================
if( ! function_exists( 'nova_add_diver_line' ) ){
	function nova_add_diver_line(){
		echo '<div class="nova-divier-line"></div>';
	}
	add_action( 'woocommerce_single_product_summary', 'nova_add_diver_line',35);
}

if( ! function_exists( 'nova_shop_filters' ) ){
	function nova_shop_filters() {
		$widgets = wp_get_sidebars_widgets();
		$shop_filters_area_widgets_counter = count($widgets['shop-widget-area']) - 1;
		foreach( $widgets['shop-widget-area'] as $k ) {
			if(strpos($k, 'monster-') !== false) {
				$shop_filters_area_widgets_counter = 4;
			}
		}
		?>
		<div class="nova-product-filter-overlay js-product-filters-toogle"></div>
		<div id="side-filters" class="nova-product-filter-content">
				<header>
					<h2><?php echo esc_html__( 'Filters','irina' ); ?></h2>
					<button class="js-product-filters-toogle"><?php echo esc_html__( 'Close','irina' ); ?></button>
				</header>
				<div class="nova-product-filter-content__inner nova_box_ps">
					<?php if (isset($widgets['shop-widget-area'])) : ?>
						<aside class="widget-area">

							<div class="row n-block-grid-<?php echo esc_attr($shop_filters_area_widgets_counter); ?> shop-filters-area-content">
								<?php dynamic_sidebar( 'shop-widget-area' ); ?>
							</div>

						</aside>

					<?php endif; ?>
				</div>
		</div>
		<?php
	}
	add_action( 'nova_shop_filters', 'nova_shop_filters' );
}
//==============================================================================
//	Add size guidelines link
//==============================================================================
if( ! function_exists( 'nova_add_size_guide_link' ) ){
	function nova_add_size_guide_link(  ){
		if( 1 == Nova_OP::getOption('single_product_size_guide') && 'modal' != Nova_OP::getOption('product_tab_preset') ) {
			echo '<a class="product-size-guide-btn" data-toggle="SizeGuide">'.esc_html__( 'Size Guidelines', 'irina' ).'</a>';
		}
	}
	add_action( 'woocommerce_before_add_to_cart_form', 'nova_add_size_guide_link', 10);
}
//==============================================================================
//	Add login form action
//==============================================================================
if( ! function_exists( 'nova_toggle_registration_login' ) ){
	function nova_toggle_registration_login($context) {

		if ( $context == 'login' ) { ?>

			<p class="form-actions extra"><?php esc_html_e('Already a member?', 'irina'); ?><a href="#nova-login-wrap" class="login-link"><?php esc_html_e('Login', 'irina'); ?></a></p>

		<?php } else if ( $context == 'register' ) { ?>

			<p class="form-actions extra"><?php esc_html_e('Not a member?', 'irina'); ?><a href="#nova-register-wrap" class="register-link"><?php esc_html_e('Register', 'irina'); ?></a></p>

		<?php }
	}
	add_action( 'irina/action/toggle_registration_login', 'nova_toggle_registration_login' );
}
