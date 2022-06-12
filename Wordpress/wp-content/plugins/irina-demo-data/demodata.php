<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

function nova_irina_get_demo_array($dir_url, $dir_path){

    $demo_items = array(
        'home-01' => array(
            'link'          => 'https://irina.novaworks.net',
            'title'         => 'Main Demo',
            'data_sample'   => 'data.json',
            'data_product'  => 'fashion.csv',
            'data_widget'   => 'widget.json',
            'data_slider'   => 'demo-01.zip',
            'category'      => array(
                'Demo',
	            'Fashion'
            )
        ),
        'home-02' => array(
            'link'          => 'https://irina.novaworks.net/home-v2/',
            'title'         => 'Fashion Demo 02',
            'data_sample'   => 'data.json',
            'data_product'  => 'fashion.csv',
            'data_widget'   => 'widget.json',
            'data_slider'   => 'demo-02.zip',
            'category'      => array(
                'Demo',
              'Fashion'
            )
        ),
        'home-03' => array(
            'link'          => 'https://irina.novaworks.net/home-v3/',
            'title'         => 'Fashion Demo 03',
            'data_sample'   => 'data.json',
            'data_product'  => 'fashion.csv',
            'data_widget'   => 'widget.json',
            'data_slider'   => 'demo-03.zip',
            'category'      => array(
                'Demo',
              'Fashion'
            )
        ),
        'home-04' => array(
            'link'          => 'https://irina.novaworks.net/home-v4/?preset=header-main-4',
            'title'         => 'Fashion Demo 04',
            'data_sample'   => 'data.json',
            'data_product'  => 'fashion.csv',
            'data_widget'   => 'widget.json',
            'data_option'   => 'header-main-4.dat',
            'category'      => array(
                'Demo',
              'Fashion'
            )
        ),
        'home-05' => array(
            'link'          => 'https://irina.novaworks.net/home-v5/',
            'title'         => 'Fashion Demo 05',
            'data_sample'   => 'data.json',
            'data_product'  => 'fashion.csv',
            'data_widget'   => 'widget.json',
            'data_slider'   => 'demo-05.zip',
            'category'      => array(
                'Demo',
              'Fashion'
            )
        ),
        'home-06' => array(
            'link'          => 'https://irina.novaworks.net/home-v6/?preset=header-main-4',
            'title'         => 'Fashion Demo 06',
            'data_sample'   => 'data.json',
            'data_product'  => 'fashion.csv',
            'data_widget'   => 'widget.json',
            'data_option'   => 'header-main-4.dat',
            'data_slider'   => 'demo-06.zip',
            'category'      => array(
                'Demo',
              'Fashion'
            )
        ),
        'home-07' => array(
            'link'          => 'https://irina.novaworks.net/home-v7/?preset=cosmetic-style',
            'title'         => 'Cosmetic Demo 01',
            'data_sample'   => 'data.json',
            'data_product'  => 'cosmetics.csv',
            'data_widget'   => 'widget.json',
            'data_option'   => 'cosmetic-style.dat',
            'data_slider'   => 'demo-07.zip',
            'category'      => array(
                'Demo',
              'Fashion'
            )
        ),
        'home-08' => array(
            'link'          => 'https://irina.novaworks.net/home-v8/?preset=cosmetic-style',
            'title'         => 'Cosmetic Demo 02',
            'data_sample'   => 'data.json',
            'data_product'  => 'cosmetics.csv',
            'data_widget'   => 'widget.json',
            'data_option'   => 'cosmetic-style.dat',
            'data_slider'   => 'demo-08.zip',
            'category'      => array(
                'Demo',
              'Fashion'
            )
        ),
        'home-09' => array(
            'link'          => 'https://irina.novaworks.net/home-v9/',
            'title'         => 'Shoes Demo',
            'data_sample'   => 'data.json',
            'data_product'  => 'shoes.csv',
            'data_widget'   => 'widget.json',
            'data_slider'   => 'demo-09.zip',
            'category'      => array(
                'Demo',
              'Fashion'
            )
        ),
        'home-10' => array(
            'link'          => 'https://irina.novaworks.net/home-v10/',
            'title'         => 'Bags Demo 01',
            'data_sample'   => 'data.json',
            'data_product'  => 'bags.csv',
            'data_widget'   => 'widget.json',
            'data_slider'   => 'demo-10.zip',
            'category'      => array(
                'Demo',
              'Fashion'
            )
        ),
        'home-11' => array(
            'link'          => 'https://irina.novaworks.net/home-v11/',
            'title'         => 'Bags Demo 02',
            'data_sample'   => 'data.json',
            'data_product'  => 'bags.csv',
            'data_widget'   => 'widget.json',
            'data_slider'   => 'demo-11.zip',
            'category'      => array(
                'Demo',
              'Fashion'
            )
        )
    );

    $default_image_setting = array(
        'woocommerce_single_image_width' => 1100,
        'woocommerce_thumbnail_image_width' => 800,
        'woocommerce_thumbnail_cropping' => 'custom',
        'woocommerce_thumbnail_cropping_custom_width' => 371,
        'woocommerce_thumbnail_cropping_custom_height' => 496
    );

    $default_menu = array(
        'nova_menu_primary'             => 'Main Menu',
        'nova_menu_fullscreen'          => 'Main Menu',
        'nova_topbar_menu'              => 'Top menu',
    );

    $default_page = array(
        'page_for_posts' 	            => 'Blog',
        'woocommerce_shop_page_id'      => 'Shop',
        'woocommerce_cart_page_id'      => 'Cart',
        'woocommerce_checkout_page_id'  => 'Checkout',
        'woocommerce_myaccount_page_id' => 'My account'
    );

    $slider = $dir_path . 'Slider/';
    $content = $dir_path . 'Content/';
    $product = $dir_path . 'Product/';
    $widget = $dir_path . 'Widget/';
    $setting = $dir_path . 'Setting/';
    $preview = $dir_url;

    $data_return = array();

    foreach ($demo_items as $demo_key => $demo_detail){
	    $value = array();
	    $value['title']             = $demo_detail['title'];
	    $value['category']          = !empty($demo_detail['category']) ? $demo_detail['category'] : array('Demo');
	    $value['demo_preset']       = $demo_key;
	    $value['demo_url']          = $demo_detail['link'];
	    $value['preview']           = !empty($demo_detail['preview']) ? $demo_detail['preview'] : ($preview . $demo_key . '.jpg');
	    $value['content']           = !empty($demo_detail['data_sample']) ? $content . $demo_detail['data_sample'] : $content . 'sample-data.json';
	    $value['option']            = !empty($demo_detail['data_option']) ? $setting . $demo_detail['data_option'] : $setting . 'settings.dat';
	    $value['product']           = !empty($demo_detail['data_product']) ? $product . $demo_detail['data_product'] : $product . 'sample-product.json';
	    $value['widget']            = !empty($demo_detail['data_widget']) ? $widget . $demo_detail['data_widget'] : $widget . 'widget.json';
	    $value['pages']             = array_merge( $default_page, array( 'page_on_front' => $demo_detail['title'] ));
	    $value['menu-locations']    = array_merge( $default_menu, isset($demo_detail['menu-locations']) ? $demo_detail['menu-locations'] : array());
	    $value['other_setting']     = array_merge( $default_image_setting, isset($demo_detail['other_setting']) ? $demo_detail['other_setting'] : array());
	    if(!empty($demo_detail['data_slider'])){
		    $value['slider'] = $slider . $demo_detail['data_slider'];
	    }
	    $data_return[$demo_key] = $value;
    }

    return $data_return;
}
