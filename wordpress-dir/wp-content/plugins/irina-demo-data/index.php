<?php
/*
Plugin Name:    Irina Package Demo Data
Plugin URI:     https://novaworks.net/
Description:    This plugin use only for Novaworks Theme
Author:         Novaworks
Author URI:     https://novaworks.net/
Version:        1.0.1
Text Domain:    novaworks-demodata
*/

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
    exit( 'Direct script access denied.' );
}
if(!function_exists('nova_import_check_post_exists')){
    function nova_import_check_post_exists( $title, $content = '', $date = '', $type = '' ){
        global $wpdb;

        $post_title = wp_unslash( sanitize_post_field( 'post_title', $title, 0, 'db' ) );
        $post_content = wp_unslash( sanitize_post_field( 'post_content', $content, 0, 'db' ) );
        $post_date = wp_unslash( sanitize_post_field( 'post_date', $date, 0, 'db' ) );
        $post_type = wp_unslash( sanitize_post_field( 'post_type', $type, 0, 'db' ) );

        $query = "SELECT ID FROM $wpdb->posts WHERE 1=1";
        $args = array();

        if ( !empty ( $date ) ) {
            $query .= ' AND post_date = %s';
            $args[] = $post_date;
        }

        if ( !empty ( $title ) ) {
            $query .= ' AND post_title = %s';
            $args[] = $post_title;
        }

        if ( !empty ( $content ) ) {
            $query .= ' AND post_content = %s';
            $args[] = $post_content;
        }

        if ( !empty ( $type ) ) {
            $query .= ' AND post_type = %s';
            $args[] = $post_type;
        }

        if ( !empty ( $args ) )
            return (int) $wpdb->get_var( $wpdb->prepare($query, $args) );

        return 0;
    }
}


class Irina_Data_Demo_Plugin_Class{

    public static $plugin_dir_path = null;

    public static $plugin_dir_url = null;

    public static $instance = null;

    private $preset_allows = array();

    public static $theme_name = 'irina';

    public static $demo_site = 'https://irina.novaworks.net/';

    protected $demo_data = array();

    public static function get_instance() {
        if ( null === static::$instance ) {
            static::$instance = new static();
        }
        return static::$instance;
    }

    protected function __construct( ) {

        self::$plugin_dir_path = plugin_dir_path(__FILE__);

        self::$plugin_dir_url = plugin_dir_url(__FILE__);

        include_once self::$plugin_dir_path . 'demodata.php';

        $this->_setup_demo_data();

        if( self::isLocal() ){
            $this->_load_other_hook();
        }

        $this->load_importer();

        add_filter(self::$theme_name . '/filter/demo_data', array( $this, 'get_data_for_import_demo') );

        add_action( 'init', array( $this, 'register_menu_import_demo'), 99 );

        add_action( 'after_setup_theme', array( $this, 'setup_shortcode' ) );
    }

    private function load_importer(){
        require_once self::$plugin_dir_path . 'importer.php';
        if(class_exists('Novaworks_Importer')){
            new Novaworks_Importer(self::$theme_name, $this->get_data_for_import_demo(), self::$demo_site );
        }
    }

    public function register_menu_import_demo(){
        if(true){
            require_once self::$plugin_dir_path . 'panel.php';

            if(self::isLocal()){
	            require_once self::$plugin_dir_path . 'export.php';
	            new Novaworks_Export_Demo();
            }
        }
    }

    public function get_data_for_import_demo(){
        $demo = (array) $this->filter_demo_item_by_category('demo');
        return $demo;
    }

    private function _setup_demo_data(){
        $this->preset_allows = array(
            // home
            'demo-fashion-01'
        );

        $func_name = 'nova_'. self::$theme_name .'_get_demo_array';

        $this->demo_data = call_user_func( $func_name, self::$plugin_dir_url . 'previews/', self::$plugin_dir_path . 'data/');

    }

    public static function isLocal(){
        $is_local = false;
        if (isset($_SERVER['X_FORWARDED_HOST']) && !empty($_SERVER['X_FORWARDED_HOST'])) {
            $hostname = $_SERVER['X_FORWARDED_HOST'];
        } else {
            $hostname = $_SERVER['HTTP_HOST'];
        }
        if ( strpos($hostname, '.novaworks.net') !== false || strpos($hostname, 'test.theme') !== false ) {
            $is_local = true;
        }
        return $is_local;
    }

    public function filter_demo_item_by_category( $category ){
        $demo_data = (array) $this->demo_data;
        $return = array();
        if(!empty($demo_data) && !empty($category)){
            foreach( $demo_data as $key => $demo ){
                if(!empty($demo['category'])){
                    $demo_category = array_map('strtolower', $demo['category']);
                    if(in_array(strtolower($category), $demo_category)){
                        $return[$key] = $demo;
                    }
                }
            }
        }
        return $return;
    }

    private function _load_other_hook(){
        include_once self::$plugin_dir_path . 'other-hook.php';
    }

    public function setup_shortcode(){
        add_shortcode('novaworks_demo', [ $this, 'create_shortcode'] );
    }

    public function create_shortcode( $atts, $output ){
        $demo_lists = $this->get_data_for_import_demo();
        $filters = array();
        foreach ($demo_lists as $demo){
            if(!empty($demo['category'])){
                foreach ($demo['category'] as $k => $v){
                    if(strtolower($v) == 'demo'){
                        continue;
                    }
                    $filters[strtolower($v)] = $v;
                }
            }
        }
        ob_start();
        ?>
        <div class="elementor-novaworks-demo novaworks-elements">
            <div id="nova_demo_2021" class="novaworks-demo">
                <div class="isotope__filter novaworks-demo__filter js-el" data-nova_component="MasonryFilter" data-isotope_container="#nova_demo_2021 .la-isotope-container">
                    <div class="isotope__filter-list novaworks-demo__filter-list">
                        <div class="isotope__filter-item novaworks-demo__filter-item active" data-filter="*"><span>Show All</span></div><?php
                        if(!empty($filters)){
                            foreach ($filters as $filter){
                                echo '<div class="isotope__filter-item novaworks-demo__filter-item" data-filter="nova_demo_category-'.esc_attr(strtolower(str_replace(' ', '-', $filter))) .'"><span>'.esc_html($filter).'</span></div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="novaworks-demo__list_wrapper">
                    <div class="novaworks-demo__list js-el la-isotope-container grid-items block-grid-3 laptop-block-grid-3 tablet-block-grid-3 mobile-block-grid-2 xmobile-block-grid-1" data-item_selector=".loop__item" data-nova_component="DefaultMasonry">
                        <?php
                        foreach ($demo_lists as $demo){
                            ?><div class="loop__item grid-item novaworks-demo__item<?php
                                foreach ($demo['category'] as $dc){
                                    echo ' nova_demo_category-' . esc_attr( strtolower( str_replace(' ', '-', $dc) ) );
                                }
                            ?>">
                                <div class="novaworks-demo__item__inner">
                                    <a href="<?php echo esc_url($demo['demo_url']) ?>" title="<?php echo esc_attr($demo['title']) ?>" target="_blank">
                                        <span class="demo__item-image la-lazyload-image" data-background-image="<?php echo esc_attr($demo['preview']) ?>"></span>
                                        <h2><span><?php echo esc_html($demo['title']) ?></span></h2>
                                    </a>
                                </div>

                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
<?php
        return ob_get_clean();
    }
}

add_action('plugins_loaded', function(){

    $theme = wp_get_theme();

    if(strtolower($theme->get_template()) != 'irina'){

        add_action( 'admin_notices', function(){
            printf( __( '%1$s"Irina Package Demo Data" requires %3$s"Irina"%4$s theme to be installed and activated. Please active %3$s"Irina"%4$s to continue.%2$s', 'novaworks-demodata' ), '<div class="error"><p>', '</p></div>' ,'<strong>', '</strong>' );
        });

        add_action( 'admin_init', function(){
            deactivate_plugins( plugin_basename( __FILE__ ) );
        });

        return;
    }

    Irina_Data_Demo_Plugin_Class::get_instance();
}, 999);
