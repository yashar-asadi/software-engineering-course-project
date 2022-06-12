<?php
	/**
	 * Plugin Name: Novaworks
	 * Plugin URI: https://irina.novaworks.net/
	 * Description: The plugin for Irina Woocommerce WordPress Theme
	 * Author: Novaworks
	 * Author URI: https://novaworks.net
	 * Version:          1.0.1
	 * License:           GNU General Public License v2
	 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
	 * Domain Path:       /languages
	 * Text Domain:       novaworks
	 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Currently plugin version.
 */
define( 'NOVA_VERSION', '1.0.0' );
define( 'NOVA_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'NOVA_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}
/**
 * The code that runs during plugin activation.
 */
function novaworks_core_activate_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nova-activator.php';
	Novaworks_Activator::activate();
}
/**
 * The code that runs during plugin deactivation.
 */
function novaworks_core_deactivate_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nova-deactivator.php';
	Novaworks_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'novaworks_core_activate_plugin' );
register_deactivation_hook( __FILE__, 'novaworks_core_deactivate_plugin' );


include_once( 'includes/helpers.php' );
include_once( 'includes/actions.php' );
include_once( 'includes/mega-menu.php' );

//Elementor
if ( defined('ELEMENTOR_VERSION' ) ) {
	require plugin_dir_path( __FILE__ ) . 'includes/extensions/elementor/manager.php';
}
// Meta Boxes
include_once( 'includes/extensions/metaboxes/page.php' );
// Widgets
function nova_load_widget() {
		include_once( 'includes/widgets/nova-widget-recent-posts.php' );
    register_widget( 'Novaworks_Widget_Recent_Posts' );
}
add_action( 'widgets_init', 'nova_load_widget' );

// Add css
function novaworks_register_script() {
    wp_register_style( 'novaworks_plugin_fontend', plugins_url('public/css/frontend.css', __FILE__), false, NOVA_VERSION, 'all');
    wp_register_style( 'novaworks_plugin_backend', plugins_url('admin/css/admin.css', __FILE__), false, NOVA_VERSION, 'all');
}
add_action('init', 'novaworks_register_script');
function novaworks_enqueue_style(){
   wp_enqueue_script('custom_jquery');
   wp_enqueue_style( 'novaworks_plugin_fontend' );
}
function novaworks_enqueue_admin_style() {
	wp_enqueue_style( 'novaworks_plugin_backend' );
}
add_action('wp_enqueue_scripts', 'novaworks_enqueue_style');
add_action('admin_enqueue_scripts', 'novaworks_enqueue_admin_style');
