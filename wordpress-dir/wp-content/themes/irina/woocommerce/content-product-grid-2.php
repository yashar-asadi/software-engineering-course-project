<?php

// @version 3.6.0

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

// Ensure visibility
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

//==============================================================================
// Default WC Hooks
//==============================================================================

// woocommerce_before_shop_loop_item
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );

// woocommerce_before_shop_loop_item_title
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );

// woocommerce_shop_loop_item_title
// nothing

// woocommerce_after_shop_loop_item_title
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);

// woocommerce_after_shop_loop_item
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

// remove thumbnail from product title
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_stock', 10);


//==============================================================================
// Custom Hooks
//==============================================================================
//show thumbnail
add_action('nova_loop_thumbnail', 'woocommerce_template_loop_product_thumbnail', 10);
add_action( 'nova_loop_thumbnail', 'woocommerce_template_loop_stock', 10);

// woocommerce_shop_loop_wishlist
add_action( 'woocommerce_shop_loop_wishlist', 'add_wishlist_icon_in_product_card', 10);

// woocommerce_shop_loop_quick_view
add_action( 'woocommerce_shop_loop_quick_view', 'nova_product_quick_view_button', 10 );

// woocommerce_shop_loop_add_to_cart
add_action( 'woocommerce_shop_loop_add_to_cart', 'woocommerce_template_loop_add_to_cart', 10 );
$class = array('product_item', 'product-grid-item', 'product');
?>


<li <?php function_exists('wc_product_class')? wc_product_class( $class, get_the_ID() ) : post_class('product'); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<div class="product-item">

		<div class="product-item__thumbnail">
						<div class="product-item__thumbnail_overlay">
						</div>
						<a class="product-item-link" href="<?php echo get_the_permalink() ?>"></a>
						<div class="product-item__description--actions">
							<?php
							if( 1 ==  Nova_OP::getOption('shop_product_wishlist_button') ):
								do_action( 'woocommerce_shop_loop_wishlist' );
							endif;
							if( 1 ==  Nova_OP::getOption('shop_product_addtocart_button') ):
								do_action( 'woocommerce_shop_loop_add_to_cart' );
							endif;
							if( 1 ==  Nova_OP::getOption('shop_product_quickview_button') ):
								do_action( 'woocommerce_shop_loop_quick_view' );
							endif;
							?>
						</div>

			<div class="product-item__badges">
				<?php do_action( 'woocommerce_product_badges' ); ?>
			</div>
			<div class="product-item__thumbnail-placeholder">
				<a href="<?php echo get_the_permalink() ?>">
					<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'nova-custom-p2-size' );?>
					<img alt="<?php echo esc_attr($product->get_id()); ?>" src="<?php  echo esc_url( $image[0] ); ?>" loading="lazy" />
				</a>
			</div>

		</div>

		<div class="product-item__description">

			<div class="product-item__description--info">
				<div class="info-left">
					<?php do_action( 'woocommerce_before_shop_loop_item_title'); ?>
					<a href="<?php echo get_the_permalink() ?>" class="title"><?php do_action( 'woocommerce_shop_loop_item_title' ); ?></a>
				</div>
				<div class="info-right">
					<?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
				</div>
			</div>
		</div>

	</div>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

</li>
