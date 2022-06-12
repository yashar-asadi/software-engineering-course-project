<?php
// If this file is called directly, abort.

if ( ! defined( 'WPINC' ) ) {
    die;
}

function novaworks_grab_shutdown_handler_if_has_elementor_error() {
    $last_error = error_get_last();
    if (isset($last_error['type']) && $last_error['type'] == E_ERROR) {
        if(strpos($last_error['file'], 'wp-content/plugins/elementor/') !== false || strpos($last_error['file'], 'wp-content/plugins/novaworks/') !== false){
            update_option('novaworks_has_elementor_error', 'has_error');
        }
    }
}
register_shutdown_function ('novaworks_grab_shutdown_handler_if_has_elementor_error');

function novaworks_elementor_remove_error_status(){
    delete_option('novaworks_has_elementor_error');
}
add_action('novaworks_elementor_activate_hook', 'novaworks_elementor_remove_error_status');

function novaworks_admin_notices_if_has_elementor_error(){
    $has_error = get_option('novaworks_has_elementor_error', false);
    if(!empty($has_error)){
        $msg = sprintf('The latest version of %1$s is incompatible with %2$s plugin,<br/> Please go to Tools >> Novaworks Elements. Click to Fix now! Then deactivate and active %2$s plugin again. Or downgrade %1$s plugin to the previous version', '<strong>Elementor</strong>', '<strong>Novaworks</strong>');
        echo sprintf('<div class="%1$s"><p>%2$s</p></div>', 'notice notice-error la-has-elementor-error', $msg);
    }
}

add_action('admin_notices', 'novaworks_admin_notices_if_has_elementor_error');



if(!function_exists('novaworks_elements_fix_elementor_override_core_file')){
    function novaworks_elements_fix_elementor_override_core_file(){
        $msg = [];
        $elementor_path = WP_PLUGIN_DIR . '/elementor/';
        $target_path = NOVA_PLUGIN_PATH . 'includes/extensions/elementor/override/';
	    if ( version_compare( ELEMENTOR_VERSION, '3.2.0', '<' ) ) {
		    $override = [
			    'core-files-css-base' => [
				    'source' => $elementor_path . 'core/files/css/base.php',
				    'target' => $target_path . 'core/files/css/base.php',
				    'find' => [
					    '->add_device( \'tablet\', $breakpoints[\'md\'] )',
					    '->add_device( \'desktop\', $breakpoints[\'lg\'] )'
				    ],
				    'replace' => [
					    '->add_device( \'tabletportrait\', $breakpoints[\'sm\'] )->add_device( \'tablet\', $breakpoints[\'md\'] )',
					    '->add_device( \'laptop\', $breakpoints[\'lg\'] )->add_device( \'desktop\', $breakpoints[\'xl\'] )'
				    ]
			    ],
			    'includes-base-controlsstack' => [
				    'source' => $elementor_path . 'includes/base/controls-stack.php',
				    'target' => $target_path . 'includes/base/controls-stack.php',
				    'find' => [
					    'const RESPONSIVE_MOBILE = \'mobile\';',
					    'self::RESPONSIVE_MOBILE,',
					    'unset( $control_args[\'mobile_default\'] );'
				    ],
				    'replace' => [
					    'const RESPONSIVE_MOBILE = \'mobile\';const RESPONSIVE_LAPTOP = \'laptop\';const RESPONSIVE_TABLET_PORTRAIT = \'tabletportrait\';',
					    'self::RESPONSIVE_MOBILE,self::RESPONSIVE_LAPTOP,self::RESPONSIVE_TABLET_PORTRAIT,',
					    'unset( $control_args[\'mobile_default\'] ); if(isset($control_args[\'laptop_default\'])){unset( $control_args[\'laptop_default\'] );}if(isset($control_args[\'tabletportrait_default\'])){unset( $control_args[\'tabletportrait_default\'] );}'
				    ]
			    ]
		    ];
	    }
	    else{
		    $override = [
			    'core-breakpoints-manager' => [
				    'source' => $elementor_path . 'core/breakpoints/manager.php',
				    'target' => $target_path . 'core/breakpoints/manager.php',
				    'find' => [
              '\'tablet\' => \'eicon-device-tablet\',',
					    'const BREAKPOINT_KEY_WIDESCREEN = \'widescreen\';',
					    'self::BREAKPOINT_KEY_TABLET => [',
                        '767',
                        '1024',
                        '1620',
                        'self::BREAKPOINT_KEY_TABLET === $breakpoint_name'
				    ],
				    'replace' => [
              '\'tablet\' => \'eicon-device-tablet\',\'tabletportrait\' => \'eicon-device-tabletportrait\',',
					    'const BREAKPOINT_KEY_WIDESCREEN = \'widescreen\';const BREAKPOINT_KEY_TABLET_PORTRAIT = \'tabletportrait\';',
					    'self::BREAKPOINT_KEY_TABLET_PORTRAIT => [ \'label\' => __( \'Tablet Portrait\', \'elementor\' ), \'default_value\' => 991, \'direction\' => \'max\', ],self::BREAKPOINT_KEY_TABLET => [',
                        '575',
                        '1279',
                        '1699',
                        'self::BREAKPOINT_KEY_TABLET === $breakpoint_name || self::BREAKPOINT_KEY_LAPTOP === $breakpoint_name || self::BREAKPOINT_KEY_TABLET_PORTRAIT === $breakpoint_name'
				    ]
			    ],
                'core-files-css-base' => [
				    'source' => $elementor_path . 'core/files/css/base.php',
				    'target' => $target_path . 'core/files/css/base.php',
				    'find' => [
					    '\'_tablet\', \'_mobile\'',
				    ],
				    'replace' => [
					    '\'_tablet\', \'_mobile\', \'_laptop\', \'_tabletportrait\'',
				    ]
			    ],
			    'includes-base-controlsstack' => [
				    'source' => $elementor_path . 'includes/base/controls-stack.php',
				    'target' => $target_path . 'includes/base/controls-stack.php',
				    'find' => [
					    'const RESPONSIVE_MOBILE = \'mobile\';',
					    'self::RESPONSIVE_MOBILE,',
					    'unset( $control_args[\'mobile_default\'] );'
				    ],
				    'replace' => [
					    'const RESPONSIVE_MOBILE = \'mobile\';const RESPONSIVE_LAPTOP = \'laptop\';const RESPONSIVE_TABLET_PORTRAIT = \'tabletportrait\';',
					    'self::RESPONSIVE_MOBILE,self::RESPONSIVE_LAPTOP,self::RESPONSIVE_TABLET_PORTRAIT,',
					    'unset( $control_args[\'mobile_default\'] ); if(isset($control_args[\'laptop_default\'])){unset( $control_args[\'laptop_default\'] );}if(isset($control_args[\'tabletportrait_default\'])){unset( $control_args[\'tabletportrait_default\'] );}'
				    ]
			    ]
		    ];
        }

        global $wp_filesystem;
        if (empty($wp_filesystem)) {
            require_once(ABSPATH . '/wp-admin/includes/file.php');
            WP_Filesystem();
            if(!defined('FS_METHOD')){
                define('FS_METHOD', 'direct');
            }
        }
        foreach ($override as $k => $file){
            $status = false;
            if($wp_filesystem->exists($file['source'])){
                $file_content = $wp_filesystem->get_contents($file['source']);
                $new_content = str_replace( $file['find'], $file['replace'], $file_content );
                if($wp_filesystem->put_contents($file['target'], $new_content)){
                    $status = true;
                }
            }
            $msg[$k] = $status;
        }

        $result = array_filter( $msg, function ( $val ) {
            return !$val;
        } );

        if(count($result) > 0){
            return false;
        }
        else{
            return true;
        }
    }
}

add_action('admin_menu', function (){
    add_submenu_page(
        'tools.php',
        esc_html__('Novaworks Elements', 'novaworks'),
        esc_html__('Novaworks Elements', 'novaworks'),
        'manage_options',
        'fix-novaworks-elements',
        'novaworks_elements_admin_menu_fix_cb'
    );
});

if(!function_exists('novaworks_elements_admin_menu_fix_cb')){
    function novaworks_elements_admin_menu_fix_cb(){
        ?>
        <div class="wrap">
            <br/>
            <h1><?php esc_html_e('Fix Novaworks Elements', 'novaworks') ?></h1>
            <br/>
            <?php
            if(isset($_POST['lasf_fix_elem'])){
                $nonce = isset($_POST['_wpnonce']) ? $_POST['_wpnonce'] : '';
                if(wp_verify_nonce($nonce, 'novaworks_elements_fix')){
                    $result = novaworks_elements_fix_elementor_override_core_file();
                    if($result){
                        do_action('novaworks_elementor_recreate_editor_file');
                        echo sprintf('<p>%s</p>', __('All done!, please re-active `Novaworks` plugin', 'novaworks'));
                    }
                    else{
                        $msg = __('An error has occurred please contact support %s', 'novaworks');
                        echo '<p>'. sprintf($msg, '<a href="https://novaworks.ticksy.com/" target="_blank">https://novaworks.ticksy.com/</a>') .'</p>';
                    }
                }
                else{
                    echo sprintf('<p>%s</p>', __('Invalid Nonce', 'novaworks'));
                }
            }
            else{
                ?>
                <form method="post">
                    <button name="lasf_fix_elem" value="yes" id="lasf_fix_elem" class="button button-primary" type="submit"><?php esc_html_e('Fix now!', 'novaworks') ?></button>
                    <?php wp_nonce_field('novaworks_elements_fix'); ?>
                </form>
                <?php
            }
            ?>
        </div>
        <?php
    }
}
