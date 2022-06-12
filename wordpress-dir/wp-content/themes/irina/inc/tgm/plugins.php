<?php


function irina_theme_register_required_plugins() {

  $plugins = array(
    'novaworks' => array(
      'name'               => esc_html__('Novaworks','irina'),
      'slug'               => 'novaworks',
      'source'             => 'http://assets.novaworks.net/plugins/irina/novaworks.zip',
      'required'           => true,
      'description'        => esc_html__('Extends the functionality of Irina with theme specific shortcodes and page builder elements.','irina'),
      'demo_required'      => true,
      'version'            => '1.0.1'
    ),
    'wc-ajax-product-filter' => array(
      'name'               => esc_html__('WC Ajax Product Filters','irina'),
      'slug'               => 'wc-ajax-product-filter',
      'source'             => 'http://assets.novaworks.net/plugins/irina/wc-ajax-product-filter.zip',
      'required'           => true,
      'description'        => esc_html__('A plugin to filter woocommerce products with AJAX request.','irina'),
      'demo_required'      => true,
      'version'            => '2.0.3.7'
    ),
    'irina-plugin' => array(
      'name'               => esc_html__('IRINA Package Demo Data','irina'),
      'slug'               => 'irina-demo-data',
      'source'             => 'http://assets.novaworks.net/plugins/irina/irina-demo-data.zip',
      'required'           => false,
      'description'        => esc_html__('This plugin use only for Novaworks Theme.','irina'),
      'demo_required'      => true,
      'version'            => '1.0.1'
    ),
    'elementor' => array(
      'name'               => esc_html__('Elementor Page Builder','irina'),
      'slug'               => 'elementor',
      'required'           => true,
      'description'        => esc_html__('The most advanced frontend drag & drop page builder. Create high-end, pixel perfect websites at record speeds. Any theme, any page, any design.','irina'),
      'demo_required'      => true
    ),
    'woocommerce' => array(
      'name'               => esc_html__('WooCommerce','irina'),
      'slug'               => 'woocommerce',
      'required'           => true,
      'description'        => esc_html__('The eCommerce engine','irina'),
      'demo_required'      => true
    ),
    'kirki' => array(
      'name'               => esc_html__('Kirki','irina'),
      'slug'               => 'kirki',
      'required'           => true,
      'demo_required'      => true
    ),
    'yith-woocommerce-wishlist' => array(
      'name'               => esc_html__('YITH WooCommerce Wishlist','irina'),
      'slug'               => 'yith-woocommerce-wishlist',
      'required'           => false,
      'description'        => esc_html__('YITH WooCommerce Wishlist gives your users the possibility to create, fill, manage and share their wishlists allowing you to analyze their interests and needs to improve your marketing strategies.','irina'),
      'demo_required'      => true
    ),
    'envato-market' => array(
      'name'               => esc_html__('Envato Market','irina'),
      'slug'               => 'envato-market',
      'source'             => 'https://envato.github.io/wp-envato-market/dist/envato-market.zip',
      'required'           => false,
      'description'        => esc_html__('Automatically update your Envato theme','irina'),
      'demo_required'      => true
    ),
    'revslider' => array(
      'name'               => esc_html__('Slider Revolution','irina'),
      'slug'               => 'revslider',
      'source'				     => 'http://assets.novaworks.net/plugins/revslider.zip',
      'required'           => false,
      'demo_required'      => true
    ),
    'woo-variation-swatches' => array(
      'name'               => esc_html__('Variation Swatches for WooCommerce','irina'),
      'slug'               => 'woo-variation-swatches',
      'required'           => false,
      'description'        => esc_html__('Beautiful colors, images and buttons variation swatches for woocommerce product attributes. Requires WooCommerce 3.2+','irina'),
      'demo_required'      => true
    ),
    'contact-form-7' => array(
      'name'               => esc_html__('Contact Form 7','irina'),
      'slug'               => 'contact-form-7',
      'required'           => false,
      'description'        => esc_html__('Just another contact form plugin. Simple but flexible.','irina'),
      'demo_required'      => true
    ),
  );

	$config = array(
	  'id'                => 'irina',
		'default_path'      => '',
		'parent_slug'       => 'themes.php',
		'menu'              => 'tgmpa-install-plugins',
		'has_notices'       => true,
		'is_automatic'      => true,
	);

	tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'irina_theme_register_required_plugins' );
