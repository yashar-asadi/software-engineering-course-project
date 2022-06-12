<?php

// @version 1.6.4

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
get_header( 'shop' );
$page_header_images = array();
if ( NOVA_RWMB_IS_ACTIVE ) {
$page_header_images = rwmb_meta( 'irina_product_page_header_image', array( 'limit' => 1 ) );
}
$page_header_image = reset( $page_header_images );
?>
<?php if($page_header_image):?>
	<div class="nova-page-header nova-lazyload-image" data-background-image="<?php echo esc_url( $page_header_image['full_url'] )?>">
		<?php if( '' != Nova_OP::getOption('pager_header_overlay_color') ):?>
			<div class="nova-page-header__overlay"></div>
		<?php endif; ?>
		<div class="nova-container">
			<div class="grid-x">
				<div class="small-12">
				<div class="nova-page-header__inner">
							<?php
							if( is_realy_woocommerce_page() && ( NOVA_WOOCOMMERCE_IS_ACTIVE ) ) {
								printf( '<h1 class="page-title woocommerce-page-title">%s</h1>', woocommerce_page_title('', false) );
							} else {
								if ( ! is_singular() && !is_home() ) {
									the_archive_title( '<h1 class="page-title">', '</h1>' );
								} else {
									printf( '<h1 class="page-title">%s</h1>', single_post_title( '', false ) );
								}
							}
							nova_site_breadcrumb();
							?>
						</div>
					</div>
			</div>
		</div>
	</div>
<?php endif;?>
<div class="nova-container display-flex">
	<?php if ( !empty(Nova_OP::getOption('single_product_sidebar')) && Nova_OP::getOption('single_product_sidebar') === true && Nova_OP::getOption('single_product_sidebar_position') == 'left' ): ?>
	<div class="product-sidebar-area show-for-large">
		<?php dynamic_sidebar( 'single-product-widget-area' ); ?>
	</div>
	<?php endif; ?>
	<div class="product-content-area">
		<div class="site-content">

			<?php do_action( 'woocommerce_before_main_content' ); ?>

				<?php while ( have_posts() ) : the_post(); ?>
					<?php wc_get_template_part( 'content', 'single-product' ); ?>
				<?php endwhile; // end of the loop. ?>

			<?php do_action( 'woocommerce_after_main_content' ); ?>

			<?php do_action( 'woocommerce_sidebar' ); ?>

		</div>

	</div>
	<?php if ( !empty(Nova_OP::getOption('single_product_sidebar')) && Nova_OP::getOption('single_product_sidebar') === true && Nova_OP::getOption('single_product_sidebar_position') == 'right' ): ?>
	<div class="product-sidebar-area show-for-large">
		<?php dynamic_sidebar( 'single-product-widget-area' ); ?>
	</div>
	<?php endif; ?>
</div>

<?php get_footer( 'shop' );
