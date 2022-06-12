<?php
/**
 * Nectar Lazy Load Images 
 *
 * 
 * @package Salient WordPress Theme
 * @version 11.5
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Nectar Lazy Images.
 */
if( !class_exists('NectarLazyImages') ) { 
	
	class NectarLazyImages {
	  
	  private static $instance;
	  
	  public static $global_option_active   = false;
		public static $woo_single_main_count  = 0;
		public static $woo_single_thumb_count = 0;
		
		public function __construct() {
			
			add_action( 'wp', array($this, 'check_global_active'), 10 );
			
		}
		
		/**
		 * Initiator.
		 */
	  public static function get_instance() {
			if ( !self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
		
		
		/**
		 * Checks if lazy loading is globally active.
		 */
		public static function check_global_active() {
			
			global $nectar_options;

			if( isset( $nectar_options['global_lazy_load_images'] ) &&
		  !empty( $nectar_options['global_lazy_load_images'] ) &&
		  '1' === $nectar_options['global_lazy_load_images'] && 
			self::verify_use_case() ) {
				
				self::$global_option_active = true;
				
			}
			
		}		
		
		/**
		 * Check if lazy loading needs to be disabled.
		 */
		public static function verify_use_case() {
			
				// Disable for Feed.
			 if( is_feed() ) {
				 return false;
			 }
			 
			 // Disable for AMP.
			 if( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
				 return false;
			 }
			 
			 // Disable for FE Editor.
			 $nectar_using_VC_front_end_editor = (isset($_GET['vc_editable'])) ? sanitize_text_field($_GET['vc_editable']) : '';
			 $nectar_using_VC_front_end_editor = ($nectar_using_VC_front_end_editor == 'true') ? true : false;
			 if( true === $nectar_using_VC_front_end_editor ) {
				 return false;
			 }
			 
			 return true;
		}
		
	  /**
		 * Determines whether or not to use lazy 
		 * loading data source on a case by case basis.
		 */
	  public static function activate_lazy() {
	    
	   if( self::verify_use_case() ) {
			 return true;
		 }
		 
		 return false;
		 
	  }
		
	  
	}


	/**
	 * Initialize the NectarElAssets class
	 */
	NectarLazyImages::get_instance();

}