<?php

// @version 3.0.0

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $post, $product, $woocommerce, $wishlists;

add_action( 'nova_qv_product_data', 	'woocommerce_template_single_title');
add_action( 'nova_qv_product_data', 	'woocommerce_template_single_rating' );
add_action( 'nova_qv_product_data', 	'woocommerce_template_single_price');
add_action( 'nova_qv_product_data', 	'woocommerce_template_single_excerpt');
add_action( 'nova_qv_product_data', 	'woocommerce_template_single_add_to_cart');
// Social Share Products
if ( 1 == Nova_OP::getOption('single_product_social_share') ) {
	add_action( 'nova_qv_product_data', 	'nova_single_product_share' );
}
add_action( 'nova_qv_product_data', 	'quickview_add_to_wishlist');
add_action( 'nova_qv_product_data', 	'woocommerce_template_single_meta' );
add_action( 'nova_qv_product_images', 'nova_show_qv_product_images' );

?>
<?php while ( have_posts() ) : the_post(); ?>
<button class="close-button" data-close aria-label="Close reveal" type="button">
	<svg class="irina-close-canvas">
		<use xlink:href="#irina-close-canvas"></use>
	</svg>
</button>
<div class="row small-collapse">
	<div class="small-12 columns">

		<div class="site-content">

			<?php

				if ( post_password_required() ) {
					echo get_the_password_form();
					return;
				}
			?>

			<div id="product-<?php the_ID(); ?>" <?php function_exists('wc_product_class')? wc_product_class() : post_class(); ?>>

				<div class="row collapse">

					<div class="small-12 large-7 columns">
						<div class="before-product-summary-wrapper">

							<?php do_action( 'nova_qv_product_images' ); ?>

						</div>
					</div>

					<div class="small-12 large-5 columns">

						<div class="summary entry-summary">
							<div class="box-summary-wrapper">
								<div class="box-scroll">
										<?php do_action( 'nova_qv_product_data' ); ?>
								</div>
							</div>
						</div>

					</div>

			</div>

		</div>

	</div>
</div>
<?php endwhile; // end of the loop. ?>
