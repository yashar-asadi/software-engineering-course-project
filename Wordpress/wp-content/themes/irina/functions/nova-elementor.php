<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

if(!function_exists('irina_override_elementor_resource')){
    function irina_override_elementor_resource( $path ){
        $path = get_theme_file_uri('assets/addon');
        return $path;
    }
}
add_filter('NovaworksElement/resource-base-url', 'irina_override_elementor_resource');

if(!function_exists('irina_register_elementor_locations')){
  function irina_register_elementor_locations( $elementor_theme_manager ) {
  	$elementor_theme_manager->register_all_core_location();
  }
  add_action( 'elementor/theme/register_locations', 'irina_register_elementor_locations' );
}

if(!function_exists('irina_add_banner_hover_effect')){
    function irina_add_banner_hover_effect( $effects ){
        return array_merge(array(
            'none'   => esc_html__( 'None', 'irina' ),
            'hidden-content' => esc_html__( 'Hidden Content', 'irina' ),
            'type-1' => esc_html__( 'Shadow', 'irina' ),
            'irina' => esc_html__( 'Irina', 'irina' )
        ), $effects);
    }
}
add_filter('NovaworksElement/banner/hover_effect', 'irina_add_banner_hover_effect');

if(!function_exists('irina_add_google_maps_api')){
    function irina_add_google_maps_api( $key ){
        return Nova_OP::getOption( 'google_map_api_key' );
    }
}
add_filter('NovaworksElement/advanced-map/api', 'irina_add_google_maps_api');

if(!function_exists('irina_add_mailchimp_access_token_api')){
    function irina_add_mailchimp_access_token_api( $key ){
        return Nova_OP::getOption( 'mailchimp_api_key' );
    }
}
add_filter('NovaworksElement/mailchimp/api', 'irina_add_mailchimp_access_token_api');

if(!function_exists('irina_add_mailchimp_list_id')){
    function irina_add_mailchimp_list_id( $key ){
        return Nova_OP::getOption( 'mailchimp_list_id');
    }
}
add_filter('NovaworksElement/mailchimp/list_id', 'irina_add_mailchimp_list_id');

if(!function_exists('irina_add_mailchimp_double_opt_in')){
    function irina_add_mailchimp_double_opt_in( $key ){
        return Nova_OP::getOption('mailchimp_double_opt_in');
    }
}
add_filter('NovaworksElement/mailchimp/double_opt_in', 'irina_add_mailchimp_double_opt_in');
