<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}

add_action('admin_menu', 'nova_admin_init_menu_import' );

function nova_admin_init_menu_import(){
    add_submenu_page(
        'tools.php',
        esc_html__('Demo Importer', 'novaworks'),
        esc_html__('Demo Importer', 'novaworks'),
        'manage_options',
        'nova_importer',
        'nova_admin_import_panel'
    );
}

function nova_admin_import_panel(){

    $theme_name = 'irina';

    $demos = apply_filters('irina/filter/demo_data', array());

    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Demo Importer', 'novaworks') ?></h1>
        <div class="nova_demo_importer_panel">
            <div class="lasf-field lasf-field-no-title lasf-field-nova_demo_importer">
                <div class="demo-importer-message"></div>
                <div class="demo-importer-message-info"></div>
                <div class="theme-browser">
                    <div class="themes">
                        <?php
                        $options_name = $theme_name . '_imported_demos';
                        $demo_installed = get_option( $options_name );
                        foreach ($demos as $key => $demo){
                            $class = 'wrap-importer theme';

                            if(isset($demo_installed[$key])){
                                $class .= ' imported';
                                $more_detail = esc_html__('Demo Imported', 'novaworks');
                                $btn_import = esc_html__('Imported', 'novaworks');
                                $btn_import_class = 'button button-secondary';
                                $btn_reimport_class = 'button button-primary reimporter-button';
                                if(isset($demo_installed['active_import']) && $key == $demo_installed['active_import']){
                                    $class .= ' active';
                                }
                            }
                            else{
                                $class .= ' not-imported';
                                $more_detail = esc_html__('Import Demo', 'novaworks');
                                $btn_import = esc_html__('Import Demo', 'novaworks');
                                $btn_import_class = 'button button-primary importer-button';
                                $btn_reimport_class = 'button button-secondary reimporter-button';
                            }
                            ?>
                            <div class="<?php echo esc_attr($class)?>" data-demo-id="<?php echo esc_attr($key)?>">
                                <div class="theme-screenshot">
                                    <img src="<?php echo esc_url($demo['preview'])?>" alt="<?php echo esc_attr($demo['title'])?>"/>
                                </div>
                                <span class="more-details"><?php echo esc_html($more_detail);?></span>
                                <div class="theme-id-container">
                                    <h2 class="theme-name"><span><?php esc_html_e('Active:', 'novaworks');?></span> <?php echo esc_html( $demo['title'] )?></h2>
                                    <div class="theme-actions">
                                        <div class="importer-buttons">
                                            <span class="spinner"><?php esc_html_e('Please Wait...', 'novaworks');?></span>
                                            <span data-title="<?php echo esc_attr('Import Demo Content?', 'novaworks')?>" class="<?php echo esc_attr($btn_import_class)?>"><?php echo esc_html($btn_import);?></span>
                                            <span data-title="<?php echo esc_attr('Re-Import Content?', 'novaworks')?>" class="<?php echo esc_attr($btn_reimport_class)?>"><?php esc_html_e('Re-Import', 'novaworks')?></span>
                                        </div>
                                    </div>
                                    <div class="theme-extra-options hidden">
                                        <label>
                                            <input class="checkbox extra-import-options" type="checkbox"/><?php esc_html_e('Without Content', 'novaworks')?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <style type="text/css">
            .nova_demo_importer_panel .lasf-field-nova_demo_importer {
                padding: 0;
            }
        </style>
    </div>
<?php
}
