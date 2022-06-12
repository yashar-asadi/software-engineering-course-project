<?php

// -----------------------------------------------------------------------------
// Body Class - Top Bar Enable
// -----------------------------------------------------------------------------
function nova_topbar_class($classes) {
    if ( 1 == Nova_OP::getOption('topbar_toggle') ) $classes[] = 'topbar-enabled';
    return $classes;
}
// -----------------------------------------------------------------------------
// Body Class - Header Sticky
// -----------------------------------------------------------------------------
function nova_header_sticky_class($classes) {
    if ( 1 == Nova_OP::getOption('enable_header_sticky') ) $classes[] = 'sticky-header-enabled';
    return $classes;
}
// -----------------------------------------------------------------------------
// Body Class - Header Transparent
// -----------------------------------------------------------------------------
function nova_header_transparent($classes) {
  if(
  	'on' == Nova_OP::getOption('header_transparent')
  	|| 'transparency_light' == get_post_meta( nova_get_page_id(), 'metabox_header_transparency', true )
  	|| 'transparency_dark' == get_post_meta( nova_get_page_id(), 'metabox_header_transparency', true )
  )
    $classes[] = 'has-transparent-header';
    return $classes;
}

// -----------------------------------------------------------------------------
// Body Class - Blog Layout
// -----------------------------------------------------------------------------

function nova_blog_layout($classes) {
    $classes[] = 'blog-' . Nova_OP::getOption('blog_layout');
    return $classes;
}

// -----------------------------------------------------------------------------
// Body Class - Blog Sidebar
// -----------------------------------------------------------------------------

function nova_blog_sidebar($classes) {
    if ( !is_single() ) {
        if ( 1 == Nova_OP::getOption('blog_sidebar') ) {
            $classes[] = 'blog-sidebar-active';
            $classes[] = 'blog-sidebar-' . Nova_OP::getOption('blog_sidebar_position');
        }
    } else if ( is_single() ) {
            $classes[] = 'blog-sidebar-active';
            $classes[] = 'blog-sidebar-' . Nova_OP::getOption('blog_single_sidebar_position');
    }
    if ( 1 == Nova_OP::getOption('blog_single_sidebar') ) {
        $classes[] = 'single-blog-sidebar-active';
    }
    return $classes;
}

// -----------------------------------------------------------------------------
// Body Class - Page Without Title
// -----------------------------------------------------------------------------

function nova_page_title($classes) {

    $page_title_option_class            = '';
    $page_title_option_class_no_title   = 'page-without-title';

    if (get_post_meta( nova_get_page_id(), 'meta_box_page_header_enable', true )) {

        $page_title_option = get_post_meta( nova_get_page_id(), 'meta_box_page_header_enable', true );

        switch ( $page_title_option ) {
            case "off":
                $page_title_option_class = $page_title_option_class_no_title;
                break;
        }

    }
    $classes[] = $page_title_option_class;
    
    if (get_post_meta( nova_get_page_id(), 'meta_box_page_header_center', true )) {
      $classes[] = 'page-header-center';
    }
    return $classes;
}

// -----------------------------------------------------------------------------
// Body Class - Shop
// -----------------------------------------------------------------------------

function nova_shop($classes) {

    if ( NOVA_WOOCOMMERCE_IS_ACTIVE ) {
        if ( is_shop() || is_product_category() || is_product_tag() || (is_tax() && is_woocommerce()) ) {
            $classes[] = 'woocommerce-shop';
        }
    }
    return $classes;
}

// -----------------------------------------------------------------------------
// Body Class - Shop Pagination
// -----------------------------------------------------------------------------

function nova_shop_pagination($classes) {

    if ( NOVA_WOOCOMMERCE_IS_ACTIVE ) {
        if ( is_shop() || is_product_category() || is_product_tag() || (is_tax() && is_woocommerce()) ) {
            $classes[] = 'shop-pagination-' . Nova_OP::getOption('shop_pagination');
        }
    }
    return $classes;
}

// -----------------------------------------------------------------------------
// Body Class - Shop Sidebar
// -----------------------------------------------------------------------------

function nova_shop_sidebar($classes) {
    if ( NOVA_WOOCOMMERCE_IS_ACTIVE ) {
        if ( is_shop() || is_product_category() || is_product_tag() || (is_tax() && is_woocommerce()) ) {
            if ( 1 == Nova_OP::getOption('shop_sidebar') ) {
                $classes[] = 'shop-sidebar-active';
                $classes[] = 'shop-sidebar-' . Nova_OP::getOption('shop_sidebar_position');
            }
        }
    }
    return $classes;
}

// -----------------------------------------------------------------------------
// Body Class - Single Product Sidebar
// -----------------------------------------------------------------------------

function nova_single_product_sidebar($classes) {
    if ( NOVA_WOOCOMMERCE_IS_ACTIVE ) {
        if ( is_product() ) {
            if ( 1 == Nova_OP::getOption('single_product_sidebar') ) {
                $classes[] = 'single-product-sidebar-active';
                $classes[] = 'single-product-sidebar-' . Nova_OP::getOption('single_product_sidebar_position');
            }
        }
    }
    return $classes;
}

// -----------------------------------------------------------------------------
// Body Class - Catalog Mode
// -----------------------------------------------------------------------------

function nova_catalog_mode($classes) {
    if ( 1 == Nova_OP::getOption('catalog_mode') ) $classes[] = 'catalog-mode';
    return $classes;
}

// -----------------------------------------------------------------------------
// Body Class - Shop Pagination
// -----------------------------------------------------------------------------
function nova_blog_pagination($classes) {

    if ( is_home() || is_archive() || is_search() ) {
        $classes[] = 'blog-pagination-' . Nova_OP::getOption('blog_pagination');
    }

    return $classes;
}

// -----------------------------------------------------------------------------
// Body Class - Preloader
// -----------------------------------------------------------------------------
function nova_site_preloader($classes) {
    if ( 1 == Nova_OP::getOption('site_preloader') ) {
        $classes[] = 'site-loading';
    }

    return $classes;
}

// -----------------------------------------------------------------------------
// Body Class - Product Preset
// -----------------------------------------------------------------------------
function nova_product_preset($classes) {
    $classes[] = 'product_preset_' . Nova_OP::getOption('product_preset');
    return $classes;
}

// -----------------------------------------------------------------------------
// Print Body Classes
// -----------------------------------------------------------------------------

function nova_customiser_body_classes() {

    add_filter( 'body_class', 'nova_topbar_class' );
    add_filter( 'body_class', 'nova_header_sticky_class' );
    add_filter( 'body_class', 'nova_header_transparent' );
    add_filter( 'body_class', 'nova_blog_layout' );
    add_filter( 'body_class', 'nova_blog_sidebar' );
    add_filter( 'body_class', 'nova_page_title' );
    add_filter( 'body_class', 'nova_shop' );
    add_filter( 'body_class', 'nova_shop_pagination' );
    add_filter( 'body_class', 'nova_shop_sidebar' );
    add_filter( 'body_class', 'nova_single_product_sidebar' );
    add_filter( 'body_class', 'nova_blog_pagination' );
    add_filter( 'body_class', 'nova_site_preloader' );
    add_filter( 'body_class', 'nova_product_preset' );
}

add_action( 'wp_head', 'nova_customiser_body_classes', 100 );
