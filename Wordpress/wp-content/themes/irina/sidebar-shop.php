
<?php if ( NOVA_WOOCOMMERCE_IS_ACTIVE ) : ?>
	<?php if ( is_shop() || is_product_category() || is_product_tag() || (is_tax() && is_woocommerce()) ) : ?>

		<aside class="site-sidebar site-sidebar--shop widget-area">
			<?php dynamic_sidebar( 'shop-widget-area' ); ?>
		</aside><!-- .site-sidebar -->

	<?php endif; ?>
<?php endif; ?>
