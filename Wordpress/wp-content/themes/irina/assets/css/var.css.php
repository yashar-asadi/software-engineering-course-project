<?php
$main_font = Nova_OP::getOption('main_font')['font-family'];
if($main_font == 'Muli') {
  $main_font = 'Mulish';
}
?>
<style>
:root {
  --site-bg-color: <?php echo esc_html(Nova_OP::getOption('bg_color')) ?>;
  --site-font-size: <?php echo esc_html(Nova_OP::getOption('font_size')) ?>px;
  --site-text-color: <?php echo esc_html(Nova_OP::getOption('primary_color')) ?>;
  --site-heading-color: <?php echo esc_html(Nova_OP::getOption('secondary_color')) ?>;
  --site-accent-color: <?php echo esc_html(Nova_OP::getOption('accent_color')) ?>;
  --site-accent-color-2: <?php echo esc_html(Nova_OP::getOption('accent_color_2')) ?>;
  --site-border-color: <?php echo esc_html(Nova_OP::getOption('border_color')) ?>;
  --site-link-color: <?php echo esc_html(Nova_OP::getOption('site_link_color')) ?>;
  --site-link-hover-color: <?php echo esc_html(Nova_OP::getOption('site_link_hover_color')) ?>;
  --site-width: <?php echo esc_html(Nova_OP::getOption('site_width')) ?>px;
  --site-main-font: <?php echo "'" . esc_html($main_font) . "'" ?>, sans-serif;
  --site-s-font: 'Playfair Display', sans-serif;
  --site-secondary-font: <?php echo "'" . esc_html(Nova_OP::getOption('secondary_font')['font-family']) . "'" ?>, serif;
  --site-accent-color-overlay: <?php echo "rgba(" . nova_hex2rgb(esc_html(Nova_OP::getOption('accent_color_2'))) 	. ",0.85)";?>;
  --site-accent-color-90: <?php echo "rgba(" . nova_hex2rgb(esc_html(Nova_OP::getOption('accent_color_2'))) 	. ",0.9)";?>;
  --site-accent-color-2-bg: <?php echo "rgba(" . nova_hex2rgb(esc_html(Nova_OP::getOption('accent_color_2'))) 	. ",0.3)";?>;

  --site-ultra-light: <?php echo "rgba(" . nova_hex2rgb(esc_html(Nova_OP::getOption('secondary_color'))) 	. ",0.1)";?>;
  --site-max-light: <?php echo "rgba(" . nova_hex2rgb(esc_html(Nova_OP::getOption('secondary_color'))) 	. ",0.25)";?>;

  --site-wc-price: <?php echo "rgba(" . nova_hex2rgb(esc_html(Nova_OP::getOption('secondary_color'))) 	. ",0.8)";?>;
  --site-wc-price-old: <?php echo "rgba(" . nova_hex2rgb(esc_html(Nova_OP::getOption('secondary_color'))) 	. ",0.5)";?>;

  --site-primary-button-color: <?php echo esc_html(Nova_OP::getOption('primary_button_color')) ?>;
  --site-secondary-button-color: <?php echo esc_html(Nova_OP::getOption('secondary_button_color')) ?>;
  --site-top-bar-bg-color: <?php echo esc_html(Nova_OP::getOption('topbar_bg_color')) ?>;
  --site-top-bar-text-color: <?php echo esc_html(Nova_OP::getOption('topbar_font_color')) ?>;
  --site-top-bar-heading-color: <?php echo esc_html(Nova_OP::getOption('topbar_heading_color')) ?>;
  --site-top-bar-accent-color: <?php echo esc_html(Nova_OP::getOption('topbar_accent_color')) ?>;
  --site-top-bar-border-color: <?php echo esc_html(Nova_OP::getOption('topbar_border_color')) ?>;
  --site-top-bar-font-size: <?php echo esc_html(Nova_OP::getOption('topbar_font_size')) ?>px;

  --site-header-height: <?php echo esc_html(Nova_OP::getOption('header_height')) ?>px;
  --site-header-logo-width: <?php echo esc_html(Nova_OP::getOption('header_logo_width')) ?>px;
  --site-header-bg-color: <?php echo esc_html(Nova_OP::getOption('header_background_color')) ?>;
  --site-header-bg-color-2: <?php echo esc_html(Nova_OP::getOption('header_background_color_2')) ?>;
  --site-header-text-color: <?php echo esc_html(Nova_OP::getOption('header_font_color')); ?>;
  --site-header-accent-color: <?php echo esc_html(Nova_OP::getOption('header_accent_color')) ?>;
  --site-header-font-size: <?php echo esc_html(Nova_OP::getOption('header_font_size') . "px"); ?>;
  --site-header-border-color: <?php echo "rgba(" . nova_hex2rgb(esc_html(Nova_OP::getOption('header_font_color'))) 	. ",0.15)";?>;

  --site-main-menu-bg-color: <?php echo esc_html(Nova_OP::getOption('main_menu_background_color')); ?>;
  --site-main-menu-text-color: <?php echo esc_html(Nova_OP::getOption('main_menu_font_color')); ?>;
  --site-main-menu-accent-color: <?php echo esc_html(Nova_OP::getOption('main_menu_accent_color')); ?>;
  --site-main-menu-border-color: <?php echo esc_html(Nova_OP::getOption('main_menu_border_color')); ?>;

  --mobile-header-bg-color: <?php echo esc_html(Nova_OP::getOption('header_mobile_background_color')) ?>;
  --mobile-header-text-color: <?php echo esc_html(Nova_OP::getOption('header_mobile_text_color')) ?>;
  --mobile-pre-header-bg-color: <?php echo esc_html(Nova_OP::getOption('handheld_bar_background_color')) ?>;
  --mobile-pre-header-text-color: <?php echo esc_html(Nova_OP::getOption('handheld_bar_text_color')) ?>;
  --mobile-pre-header-border-color: <?php echo "rgba(" . nova_hex2rgb(esc_html(Nova_OP::getOption('handheld_bar_text_color'))) 	. ",0.2)";?>;

  --page-header-bg-color: <?php echo esc_html(Nova_OP::getOption('pager_header_background_color')) ?>;
  <?php
    if( '' != Nova_OP::getOption('pager_header_overlay_color') ) {
      $page_header_overlay_color = Nova_OP::getOption('pager_header_overlay_color');
    }else {
      $page_header_overlay_color = '#000000';
    }
  ?>
  --page-header-overlay-color: <?php echo esc_html( $page_header_overlay_color ) ?>;
  --page-header-text-color: <?php echo esc_html(Nova_OP::getOption('pager_header_font_color')) ?>;
  --page-header-heading-color: <?php echo esc_html(Nova_OP::getOption('pager_header_heading_color')) ?>;
  --page-header-height: <?php echo esc_html(Nova_OP::getOption('page_header_height')) ?>px;

  --dropdown-bg-color: <?php echo esc_html(Nova_OP::getOption('dropdowns_bg_color')) ?>;
  --dropdown-text-color: <?php echo esc_html(Nova_OP::getOption('dropdowns_font_color')); ?>;
  --dropdown-accent-color: <?php echo esc_html(Nova_OP::getOption('dropdowns_accent_color')); ?>;
  --dropdown-secondary-color: <?php echo "rgba(" . nova_hex2rgb(esc_html(Nova_OP::getOption('dropdowns_font_color'))) 	. ",0.7)";?>;
  --dropdown-grey-color: <?php echo "rgba(" . nova_hex2rgb(esc_html(Nova_OP::getOption('dropdowns_font_color'))) 	. ",0.5)";?>;
  --dropdown-border-color: <?php echo "rgba(" . nova_hex2rgb(esc_html(Nova_OP::getOption('dropdowns_font_color'))) 	. ",0.15)";?>;

  --site-blog-background-color: <?php echo esc_html(Nova_OP::getOption('blog_background_color')) ?>;

  --site-footer-bg-color: <?php echo esc_html(Nova_OP::getOption('footer_background_color')) ?>;
  --site-footer-text-color: <?php echo esc_html(Nova_OP::getOption('footer_font_color')) ?>;
  --site-footer-heading-color: <?php echo esc_html(Nova_OP::getOption('footer_headings_color')) ?>;
  --site-footer-border-color: <?php echo "rgba(" . nova_hex2rgb(esc_html(Nova_OP::getOption('footer_headings_color'))) 	. ",0.15)";?>;

  --site-filter-widget-height: <?php echo esc_html(Nova_OP::getOption('shop_filter_height')) ?>px;;
}
.styling__quickview {
  --qv-bg-color: <?php echo esc_html(Nova_OP::getOption('qv_bg_color')) ?>;
  --qv-text-color: <?php echo esc_html(Nova_OP::getOption('qv_font_color')) ?>;
  --qv-heading-color: <?php echo esc_html(Nova_OP::getOption('qv_heading_color')) ?>;
  --qv-border-color: <?php echo "rgba(" . nova_hex2rgb(esc_html(Nova_OP::getOption('qv_heading_color'))) 	. ",0.15)";?>;
}
.error-404 {
  --p404-text-color: <?php echo esc_html(Nova_OP::getOption('page_404_font_color')) ?>;
}
<?php if ( (!empty(Nova_OP::getOption('catalog_mode_price'))) && (Nova_OP ::getOption('catalog_mode_price') == 1) ) : ?>
    ul.products .product .product-item .product-item__description .product-item__description--info span.price,
    .woocommerce-Price-amount,
    span.onsale,
    stock.out-of-stock {
    	display: none !important;
    }
<?php endif; ?>
/********************************************************************/
/* Shop *************************************************************/
/********************************************************************/

<?php if ( (!empty(Nova_OP::getOption('shop_mobile_columns'))) && (Nova_OP::getOption('shop_mobile_columns') == 1) ) : ?>

    @media screen and ( max-width: 480px )
    {
        ul.products:not(.shop_display_list) .product
        {
            width: 100%;
        }
    }

<?php endif; ?>
</style>
