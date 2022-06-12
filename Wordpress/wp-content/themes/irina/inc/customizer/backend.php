<?php

if ( NOVA_KIRKI_IS_ACTIVE ) {

  require_once(get_template_directory() .'/inc/customizer/backend/index.php');
  require_once(get_template_directory() .'/inc/customizer/backend/go-to-page.php');

  require_once(get_template_directory() .'/inc/customizer/backend/global/index.php');
	require_once(get_template_directory() .'/inc/customizer/backend/header/index.php');
	require_once(get_template_directory() .'/inc/customizer/backend/fonts/index.php');
  require_once(get_template_directory() .'/inc/customizer/backend/styles/index.php');
  require_once(get_template_directory() .'/inc/customizer/backend/blog/index.php');
	require_once(get_template_directory() .'/inc/customizer/backend/footer/index.php');
	require_once(get_template_directory() .'/inc/customizer/backend/social/index.php');
	require_once(get_template_directory() .'/inc/customizer/backend/social-share/index.php');
  require_once(get_template_directory() .'/inc/customizer/backend/api/index.php');
	require_once(get_template_directory() .'/inc/customizer/backend/404/index.php');

	if (NOVA_WOOCOMMERCE_IS_ACTIVE) {
		require_once(get_template_directory() .'/inc/customizer/backend/shop/index.php');
		require_once(get_template_directory() .'/inc/customizer/backend/product/index.php');
	}
  function nova_after_customize_save() {
  //instagram
  $i_access_token = Nova_OP::getOption( 'instagram_access_token' );
  if(isset($i_access_token)) {
    update_option('nova_elements_instagram_access_token', $i_access_token);
  }
  if(isset($i_access_token)){
    $new = Nova_OP::getOption( 'instagram_access_token' );
    $old = get_option( 'nova_elements_instagram_access_token' );
    if($old !== $new){
        delete_transient('novaworks_ig_token');
        delete_transient('novaworks_ig_feed');
    }
}
  //mailchimp api
  $api_key = Nova_OP::getOption( 'mailchimp_api_key' );
  if(isset($api_key)) {
    update_option('nova_elements_mailchimp_api_key', $api_key);
  }
  $mailchimp_list_id = Nova_OP::getOption( 'mailchimp_list_id');
  if(isset($mailchimp_list_id)) {
      update_option('nova_elements_mailchimp_list_id', $mailchimp_list_id);
  }
  if( Nova_OP::getOption('mailchimp_double_opt_in') ) {
      $mailchimp_double_opt_in = Nova_OP::getOption( 'mailchimp_double_opt_in');
  }else {
      $mailchimp_double_opt_in = false;
  }
  update_option('nova_elements_mailchimp_double_opt_in', $mailchimp_double_opt_in);
}
add_action( 'customize_save_after', 'nova_after_customize_save' );
}
