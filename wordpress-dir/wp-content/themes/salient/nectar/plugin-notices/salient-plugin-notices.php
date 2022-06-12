<?php
/**
 * Salient Post Type Notices
 *
 * @package Salient WordPress Theme
 * @subpackage helpers
 * @version 10.5
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/* Admin notice that Salient post types are now separated into plugins */
if( get_option( 'nectar_dismiss_plugin_notice' ) !== 'true' ) {
		
		// Do not show on welcome page/install page.
		if( isset( $_GET['page'] ) && 'salient-welcome-screen' === $_GET['page'] ||
			isset( $_GET['page'] ) && 'tgmpa-install-plugins' === $_GET['page'] ) {
			return;
		}
		
		if( ! class_exists('Salient_Portfolio') ||
			! class_exists('Salient_Nectar_Slider') ||
			! class_exists('Salient_Home_Slider') ||
			! class_exists('Salient_Shortcodes') ||
			! class_exists('Salient_Demo_Importer') ||
			! class_exists('Salient_Core') ||
			! class_exists('Salient_Widgets') ||
			! class_exists('Salient_Social') ) {
			
			if( current_user_can( 'install_plugins' ) )	{
		    add_action( 'admin_notices', 'nectar_add_dismissible_plugin_notice' );
				add_action( 'admin_enqueue_scripts', 'nectar_add_plugin_notice_admin_notice_script' );
				add_action( 'wp_ajax_nectar_dismiss_plugin_notice', 'nectar_dismiss_plugin_notice' );
			}
			
		}
		
}

function nectar_add_dismissible_plugin_notice() { ?>
      <div class='notice nectar-dismiss-cpt-notice nectar-bold-notice is-dismissible'>
          <h3><?php echo esc_html__('Important Salient Plugin Notice','salient'); ?></h3>
          <p><?php echo esc_html__('In accordance with new','salient') . ' <a href="//help.author.envato.com/hc/en-us/articles/360000481223" target="_blank">'. esc_html__('Envato guidelines', 'salient') .'</a>, ' . esc_html__('Salient has separated all of the custom post types and plugin territory functionality into individual plugins. Please install and activate the required plugins and any of the desired optional plugins which you wish to use on your site.','salient'); ?></p>
          
          <p><?php echo esc_html__('The following Salient plugins are not installed or activated: ','salient'); ?></p>
					<ul>
          <?php 
					if( ! defined( 'SALIENT_VC_ACTIVE' ) ) {
	          echo '<li><strong><a target="_blank" href="'. esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ) . '"> '. esc_html__('Salient WPBakery Page Builder', 'salient') . '</a></strong><span class="core">'.esc_html__('Required','salient').'</span></li>'; 
					}
					if( ! class_exists('Salient_Core') ) {
	          echo '<li><strong><a target="_blank" href="'. esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ). '"> '. esc_html__('Salient Core', 'salient') . '</a></strong><span class="core">'.esc_html__('Required','salient').'</span></li>'; 
					}
					if( ! class_exists('Salient_Demo_Importer') ) {
	          echo '<li><strong><a target="_blank" href="'. esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ). '"> '. esc_html__('Salient Demo Importer', 'salient') . '</a></strong><span>'. esc_html__('Optional','salient') .'</span></li>'; 
					}
					if( ! class_exists('Salient_Social') ) {
	          echo '<li><strong><a target="_blank" href="'. esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ). '"> '. esc_html__('Salient Social', 'salient') . '</a></strong><span>'. esc_html__('Optional','salient') .'</span></li>'; 
					}
					if( ! class_exists('Salient_Widgets') ) {
	          echo '<li><strong><a target="_blank" href="'. esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ). '"> '. esc_html__('Salient Widgets', 'salient') . '</a></strong><span>'. esc_html__('Optional','salient') .'</span></li>'; 
					}
					if( ! class_exists('Salient_Portfolio') ) {
            echo '<li><strong><a target="_blank" href="'. esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ). '">'. esc_html__('Salient Portfolio', 'salient') . '</a></strong><span>'. esc_html__('Optional','salient') .'</span></li>';
          } 
					if( ! class_exists('Salient_Nectar_Slider') ) {
          	echo '<li><strong><a target="_blank" href="'. esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ). '">'. esc_html__('Salient Nectar Slider', 'salient') . '</a></strong><span>'. esc_html__('Optional','salient') .'</span></li>';
					}
					if( ! class_exists('Salient_Home_Slider') ) {
	          echo '<li><strong><a target="_blank" href="'. esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ). '">'. esc_html__('Salient Home Slider', 'salient') . '</a></strong><span>'. esc_html__('Optional','salient') .'</span></li>'; 
					}
					if( ! class_exists('Salient_Shortcodes') ) {
	          echo '<li><strong><a target="_blank" href="'. esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ). '">'. esc_html__('Salient Shortcodes', 'salient') . '</a></strong><span>'. esc_html__('Optional','salient') .'</span></li>'; 
					}
          ?>
        </ul>
				<?php echo '<a class="begin-installing" target="_blank" href="'. esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ). '"><strong>' . esc_html__('Begin Installing/Activating Plugins','salient') .'</strong></a>'; ?>
      </div>
<?php }


function nectar_add_plugin_notice_admin_notice_script() {
	
		global $nectar_get_template_directory_uri;
		
		wp_register_style( 'nectar-plugin-notice-admin-notice', $nectar_get_template_directory_uri . '/nectar/plugin-notices/css/notice.css','','1.0', false );
	  wp_register_script( 'nectar-plugin-notice-admin-notice-update', $nectar_get_template_directory_uri . '/nectar/plugin-notices/js/admin_notices.js','','1.0', false );
	  
	  wp_localize_script( 'nectar-plugin-notice-admin-notice-update', 'notice_params', array(
	      'ajaxurl' => esc_url(get_admin_url()) . 'admin-ajax.php', 
	  ));
	  
		wp_enqueue_style(  'nectar-plugin-notice-admin-notice' );
	  wp_enqueue_script(  'nectar-plugin-notice-admin-notice-update' );
		
}


function nectar_dismiss_plugin_notice() {
    update_option( 'nectar_dismiss_plugin_notice', 'true' );
		wp_die();
}