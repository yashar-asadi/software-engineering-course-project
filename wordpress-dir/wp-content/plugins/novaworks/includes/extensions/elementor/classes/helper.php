<?php
/**
 * NOVA Helper.
 *
 * @package NOVA
 */

namespace Novaworks_Element\Classes;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Class NOVA_Helper.
 */
class NOVA_Helper {

	/**
	 * CSS files folder
	 *
	 * @var script_debug
	 */
	private static $script_debug = null;

	/**
	 * CSS files folder
	 *
	 * @var css_folder
	 */
	private static $css_folder = null;

	/**
	 * CSS Suffix
	 *
	 * @var css_suffix
	 */
	private static $css_suffix = null;

	/**
	 * RTL CSS Suffix
	 *
	 * @var rtl_css_suffix
	 */
	private static $rtl_css_suffix = null;

	/**
	 * JS files folder
	 *
	 * @var js_folder
	 */
	private static $js_folder = null;

	/**
	 * JS Suffix
	 *
	 * @var js_suffix
	 */
	private static $js_suffix = null;

	/**
	 * Widget Options
	 *
	 * @var widget_options
	 */
	private static $widget_options = null;

	/**
	 * Skins Options
	 *
	 * @var skins_options
	 */
	private static $skins_options = null;

	/**
	 * Widget List
	 *
	 * @var widget_list
	 */
	private static $widget_list = null;

	/**
	 * Google Map Language List
	 *
	 * @var google_map_languages
	 */
	private static $google_map_languages = null;

	/**
	 * WHite label data
	 *
	 * @var branding
	 */
	private static $branding = null;

	/**
	 * Post Skins List
	 *
	 * @var post_skins_list
	 */
	private static $post_skins_list = null;

	/**
	 * Elementor Saved page templates list
	 *
	 * @var page_templates
	 */
	private static $page_templates = null;

	/**
	 * Elementor saved section templates list
	 *
	 * @var section_templates
	 */
	private static $section_templates = null;

	/**
	 * Elementor saved widget templates list
	 *
	 * @var widget_templates
	 */
	private static $widget_templates = null;

   /**
  * Check if the Elementor is updated.
  *
  * @since 1.16.1
  *
  * @return boolean if Elementor updated.
  */
   public static function is_elementor_updated() {
     if ( class_exists( 'Elementor\Icons_Manager' ) ) {
       return true;
     } else {
       return false;
     }
   }
}
