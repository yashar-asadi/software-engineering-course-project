<?php
// If this file is called directly, abort.

if ( ! defined( 'WPINC' ) ) {
    die;
}


function novaworks_elementor_recreate_editor_file( ){
	global $wp_filesystem;
	if (empty($wp_filesystem)) {
		require_once(ABSPATH . '/wp-admin/includes/file.php');
		WP_Filesystem();
		if(!defined('FS_METHOD')){
			define('FS_METHOD', 'direct');
		}
	}
	$wp_upload_dir = wp_upload_dir( null, false );
	$target_source_folder = $wp_upload_dir['basedir'] . '/elementor/';
	$target_source_file = $target_source_folder . '/editor.min.js';
	$remote_source_file = plugin_dir_path(NOVA_PLUGIN_PATH) . 'elementor/assets/js/editor.min.js';

	if($wp_filesystem->exists($remote_source_file)){
		$file_content = $wp_filesystem->get_contents($remote_source_file);

		if ( version_compare( ELEMENTOR_VERSION, '3.2.0', '<' ) ) {
			$string_search = array(
				'["desktop","tablet","mobile"]',
				'$e.routes.saveState("library"),(0,u.default)((0,s.default)(_default.prototype),"activateTab",this).call(this,e)',
				'defaultTabs(){return{"templates/blocks":',
			);
			$string_replace = array(
				'["desktop","laptop","tablet","tabletportrait","mobile"]',
				'$e.routes.saveState("library"),(0,u.default)((0,s.default)(_default.prototype),"activateTab",this).call(this,e),jQuery(document).trigger("Novaworks/Elementor/TemplateLibraryActiveTab", [e])',
				'defaultTabs(){return{"templates/novaworks":{title:"Demos",filter:{source:"novaworks"}},"templates/blocks":',
			);
			$new_content = str_replace($string_search, $string_replace, $file_content);
			$new_content2 = preg_replace(
				'/stylesheet\.addDevice\((.*)\)},addStyleRules/',
				'stylesheet.addDevice("mobile",0).addDevice("tabletportrait",elementorFrontend.config.breakpoints.sm).addDevice("tablet",elementorFrontend.config.breakpoints.md).addDevice("laptop",elementorFrontend.config.breakpoints.lg).addDevice("desktop",elementorFrontend.config.breakpoints.xl)},addStyleRules',
				$new_content
			);
			if(empty($new_content2)){
				$tmp1 = explode('stylesheet.addDevice', $new_content);
				$tmp2 = explode('},addStyleRules', $new_content);
				$new_content = $tmp1[0] . 'stylesheet.addDevice("mobile",0).addDevice("tabletportrait",elementorFrontend.config.breakpoints.sm).addDevice("tablet",elementorFrontend.config.breakpoints.md).addDevice("laptop",elementorFrontend.config.breakpoints.lg).addDevice("desktop",elementorFrontend.config.breakpoints.xl)},addStyleRules' . $tmp2[1];
			}
			else{
				$new_content = $new_content2;
			}
		}
		else{
			$string_search = array(
				'["desktop","tablet","mobile"]',
				'$e.routes.saveState("library")',
				'defaultTabs(){return{"templates/blocks":',
				'(_tablet|_mobile)',
			);
			$string_replace = array(
				'["desktop","laptop","tablet","tabletportrait","mobile"]',
				'$e.routes.saveState("library"),jQuery(document).trigger("Novaworks/Elementor/TemplateLibraryActiveTab")',
				'defaultTabs(){return{"templates/novaworks":{title:"Demos",filter:{source:"novaworks"}},"templates/blocks":',
				'(_tablet|_mobile|_laptop|_tabletportrait)',
			);
			$new_content = str_replace($string_search, $string_replace, $file_content);
        }
		if(!$wp_filesystem->is_dir($target_source_folder)){
			if(! wp_mkdir_p( $target_source_folder )){
				return new WP_Error( 'novaworks_elementor.cannot_put_contents', __( 'Cannot put contents', 'novaworks' ) );
			}
		}
		if($wp_filesystem->put_contents($target_source_file, $new_content)){
			update_option('novaworks-has-override-elementor-editor-js', true);
			return true;
		}
		else{
			update_option('novaworks-has-override-elementor-editor-js', false);
			return new WP_Error( 'novaworks_elementor.cannot_put_contents', __( 'Cannot put contents', 'novaworks' ) );
		}
	}
	else{
		return new WP_Error( 'novaworks_elementor.resource_not_exists', __( 'Resource does not exist', 'novaworks' ) );
	}
}
add_action('novaworks_elementor_activate_hook', 'novaworks_elementor_recreate_editor_file');
add_action('elementor/core/files/clear_cache', function (){
	novaworks_elementor_recreate_editor_file();
});

function novaworks_elementor_recreate_editor_file_when_updating( $upgrader_object, $options ){
	$target_plugin = 'elementor/elementor.php';
	if( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
		foreach( $options['plugins'] as $plugin ) {
			if( $plugin == $target_plugin ) {
				novaworks_elementor_recreate_editor_file();
			}
		}
	}
}
add_action( 'upgrader_process_complete', 'novaworks_elementor_recreate_editor_file_when_updating', 10, 2 );

function novaworks_elementor_override_editor_before_enqueue_scripts( $src, $handler ){
	if($handler == 'elementor-editor'){
		$wp_upload_dir = wp_upload_dir( null, false );
		return $wp_upload_dir['baseurl'] . '/elementor/editor.min.js';
	}
	return $src;
}
add_action('script_loader_src', 'novaworks_elementor_override_editor_before_enqueue_scripts', 10, 2);

add_action('elementor/core/files/clear_cache', function (){
	$key = 'novaworks-gmap-style-' . NOVA_VERSION;
	delete_transient($key);
});

function novaworks_elementor_override_editor_wp_head(){
    ?>
    <script type="text/template" id="tmpl-elementor-control-responsive-switchers">
        <div class="elementor-control-responsive-switchers">
            <#
            var devices = responsive.devices || [ 'desktop', 'laptop', 'tablet', 'tabletportrait', 'mobile' ];
            _.each( devices, function( device ) { #>
            <a class="elementor-responsive-switcher elementor-responsive-switcher-{{ device }}" data-device="{{ device }}">
                <i class="eicon-device-{{ device }}"></i>
            </a>
            <# } );
            #>
        </div>
    </script>
    <?php
}
add_action('elementor/editor/wp_head', 'novaworks_elementor_override_editor_wp_head', 0);


function novaworks_elementor_get_widgets_black_list( $black_list ){
    $new_black_list = array(
        'WP_Widget_Calendar',
        'WP_Widget_Pages',
        'WP_Widget_Archives',
        'WP_Widget_Media_Audio',
        'WP_Widget_Media_Image',
        'WP_Widget_Media_Gallery',
        'WP_Widget_Media_Video',
        'WP_Widget_Meta',
        'WP_Widget_Text',
        'WP_Widget_RSS',
        'WP_Widget_Custom_HTML',
        'RevSliderWidget',
        'Novaworks_Widget_Recent_Posts',
    );

    $new_black_list = array_merge($black_list, $new_black_list);
    return $new_black_list;
}
add_filter('elementor/widgets/black_list', 'novaworks_elementor_get_widgets_black_list', 20);

function novaworks_elementor_backend_enqueue_scripts(){
    wp_enqueue_script(
        'novaworks-elementor-backend',
        NOVA_PLUGIN_URL . 'public/element/js/editor-backend.js' ,
        ['jquery'],
        NOVA_VERSION,
        true
    );
    $breakpoints = [
        'laptop' => [
            'name' => __( 'Laptop', 'novaworks' ),
            'text' => __( 'Preview for 1366px', 'novaworks' )
        ],
        'tablet' => [
            'name' => __( 'Tablet Landscape', 'novaworks' ),
            'text' => __( 'Preview for 1024px', 'novaworks' )
        ],
        'tabletportrait' => [
            'name' => __( 'Tablet Portrait', 'novaworks' ),
            'text' => __( 'Preview for 768px', 'novaworks' )
        ]
    ];
    if(nova_is_local()){
        $breakpoints = [
            'laptop1' => [
                'name' => __( 'Laptop 1', 'novaworks' ),
                'text' => __( 'Preview for 1680px', 'novaworks' )
            ],
            'laptop2' => [
                'name' => __( 'Laptop 2', 'novaworks' ),
                'text' => __( 'Preview for 1440px', 'novaworks' )
            ],
            'laptop' => [
                'name' => __( 'Laptop', 'novaworks' ),
                'text' => __( 'Preview for 1366px', 'novaworks' )
            ],
            'tablet' => [
                'name' => __( 'Tablet Landscape', 'novaworks' ),
                'text' => __( 'Preview for 1024px', 'novaworks' )
            ],
            'tabletportrait' => [
                'name' => __( 'Tablet Portrait', 'novaworks' ),
                'text' => __( 'Preview for 768px', 'novaworks' )
            ]
        ];
    }
    wp_localize_script('novaworks-elementor-backend', 'LaCustomBPFE', $breakpoints);
}
add_action( 'elementor/editor/before_enqueue_scripts', 'novaworks_elementor_backend_enqueue_scripts');
