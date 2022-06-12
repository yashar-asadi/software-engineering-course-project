<?php if (get_post_meta( nova_get_page_id(), 'meta_box_page_header_enable', true ) != 'off' && 'mini' == Nova_OP::getOption('page_header_style') ) : ?>
<div class="page-header-content">
<?php
nova_site_breadcrumb();
if( is_realy_woocommerce_page() && ( NOVA_WOOCOMMERCE_IS_ACTIVE ) ) {
  printf( '<h1 class="page-title woocommerce-page-title">%s</h1>', woocommerce_page_title('', false) );
} else {
  if ( ! is_singular() && !is_home() ) {
    the_archive_title( '<h1 class="page-title">', '</h1>' );
  } else {
    printf( '<h1 class="page-title">%s</h1>', single_post_title( '', false ) );
  }
}
?>
</div>
<?php endif; ?>
