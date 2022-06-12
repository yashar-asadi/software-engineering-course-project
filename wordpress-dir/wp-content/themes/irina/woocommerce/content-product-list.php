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
add_action('nova_loop_thumbnail', 'woocommerce_template_loop_product_thumbnail', 10);
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
 add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 20 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 15);
?>


<li class="product">
  <div class="nova-product-mini">
    <div class="nova-product-mini__thumb">
      <a href="<?php echo get_the_permalink() ?>">
        <?php do_action('nova_loop_thumbnail'); ?>
      </a>
    </div>
    <div class="nova-product-mini__content">
      <a href="<?php echo get_the_permalink() ?>" class="title"><?php do_action( 'woocommerce_shop_loop_item_title' ); ?></a>
      <?php do_action( 'woocommerce_after_shop_loop_item_title' ); ?>
    </div>
  </div>
</li>
