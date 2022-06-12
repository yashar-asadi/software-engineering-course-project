<?php
/**
 * Template part for displaying page header
 */
 $lazy_class = '';

 if( '' != Nova_OP::getOption('page_header_background_image') ) {
	 $lazy_class = ' nova-lazyload-image';
 }
?>
<div class="nova-page-header <?php echo Nova_OP::getOption('page_header_style')?><?php echo esc_attr($lazy_class); ?>"<?php if( '' != Nova_OP::getOption('page_header_background_image') ) { echo ' data-background-image="'.esc_url( Nova_OP::getOption('page_header_background_image') ).'"'; }?>>
	<?php if( '' != Nova_OP::getOption('pager_header_overlay_color') ):?>
		<div class="nova-page-header__overlay"></div>
	<?php endif; ?>
  <div class="nova-container">
    <div class="row">
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
