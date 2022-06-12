<?php

namespace Novaworks_Element\Widgets;

if (!defined('WPINC')) {
    die;
}

use Elementor\Widget_Base;


abstract class NOVA_Widget_Base extends Widget_Base
{
    public $__context         = 'render';
    public $__processed_item  = false;
    public $__processed_index = 0;

    public function __construct($data = [], $args = null) {
        parent::__construct($data, $args);
        $this->init_action();
    }

    protected function init_action(){

    }

    protected function get_widget_title(){
        return '';
    }

    public function get_title(){
        return 'Novaworks ' . $this->get_widget_title();
    }

    public function get_script_depends() {
        return [
            'novaworks-element-front'
        ];
    }

    /**
     * Get categories
     *
     * @since 0.0.1
     */
    public function get_categories() {
        return [ 'novaworks' ];
    }

    /**
     * Get globaly affected template
     *
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function __get_global_template( $name = null ) {

        $template = call_user_func( array( $this, sprintf( '__get_%s_template', $this->__context ) ) );

        if ( ! $template ) {
            $template = novaworks_elementor_get_template( $this->get_name() . '/global/' . $name . '.php' );
        }

        return $template;
    }

    /**
     * Get front-end template
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function __get_render_template( $name = null ) {
        return novaworks_elementor_get_template( $this->get_name() . '/render/' . $name . '.php' );
    }

    /**
     * Get editor template
     * @param  [type] $name [description]
     * @return [type]       [description]
     */
    public function __get_edit_template( $name = null ) {
        return novaworks_elementor_get_template( $this->get_name() . '/edit/' . $name . '.php' );
    }

    /**
     * Get global looped template for settings
     * Required only to process repeater settings.
     *
     * @param  string $name    Base template name.
     * @param  string $setting Repeater setting that provide data for template.
     * @return void
     */
    public function __get_global_looped_template( $name = null, $setting = null ) {

        $templates = array(
            'start' => $this->__get_global_template( $name . '-loop-start' ),
            'loop'  => $this->__get_global_template( $name . '-loop-item' ),
            'end'   => $this->__get_global_template( $name . '-loop-end' ),
        );

        call_user_func(
            array( $this, sprintf( '__get_%s_looped_template', $this->__context ) ), $templates, $setting
        );

    }

    /**
     * Get render mode looped template
     *
     * @param  array  $templates [description]
     * @param  [type] $setting   [description]
     * @return [type]            [description]
     */
    public function __get_render_looped_template( $templates = array(), $setting = null ) {

        $loop = $this->get_settings_for_display( $setting );
        $loop = apply_filters( 'novaworks_element/widget/loop-items', $loop, $setting, $this );

        if ( empty( $loop ) ) {
            return;
        }

        if ( ! empty( $templates['start'] ) ) {
            include $templates['start'];
        }

        foreach ( $loop as $item ) {

            $this->__processed_item = $item;
            if ( ! empty( $templates['start'] ) ) {
                include $templates['loop'];
            }
            $this->__processed_index++;
        }

        $this->__processed_item = false;
        $this->__processed_index = 0;

        if ( ! empty( $templates['end'] ) ) {
            include $templates['end'];
        }

    }

    /**
     * Get edit mode looped template
     *
     * @param  array  $templates [description]
     * @param  [type] $setting   [description]
     * @return [type]            [description]
     */
    public function __get_edit_looped_template( $templates = array(), $setting = null ) {
        ?>
        <# if ( settings.<?php echo $setting; ?> ) { #>
        <?php
        if ( ! empty( $templates['start'] ) ) {
            include $templates['start'];
        }
        ?>
        <# _.each( settings.<?php echo $setting; ?>, function( item ) { #>
        <?php
        if ( ! empty( $templates['loop'] ) ) {
            include $templates['loop'];
        }
        ?>
        <# } ); #>
        <?php
        if ( ! empty( $templates['end'] ) ) {
            include $templates['end'];
        }
        ?>
        <# } #>
        <?php
    }

    /**
     * Get current looped item dependends from context.
     *
     * @param  string $key Key to get from processed item
     * @return mixed
     */
    public function __loop_item( $keys = array(), $format = '%s' ) {

        return call_user_func( array( $this, sprintf( '__%s_loop_item', $this->__context ) ), $keys, $format );

    }

    /**
     * Loop edit item
     *
     * @param  [type]  $keys       [description]
     * @param  string  $format     [description]
     * @param  boolean $nested_key [description]
     * @return [type]              [description]
     */
    public function __edit_loop_item( $keys = array(), $format = '%s' ) {

        $settings = $keys[0];

        if ( isset( $keys[1] ) ) {
            $settings .= '.' . $keys[1];
        }

        ob_start();

        echo '<# if ( item.' . $settings . ' ) { #>';
        printf( $format, '{{{ item.' . $settings . ' }}}' );
        echo '<# } #>';

        return ob_get_clean();
    }

    /**
     * Loop render item
     *
     * @param  string  $format     [description]
     * @param  [type]  $key        [description]
     * @param  boolean $nested_key [description]
     * @return [type]              [description]
     */
    public function __render_loop_item( $keys = array(), $format = '%s' ) {

        $item = $this->__processed_item;

        $key        = $keys[0];
        $nested_key = isset( $keys[1] ) ? $keys[1] : false;

        if ( empty( $item ) || ! isset( $item[ $key ] ) ) {
            return false;
        }

        if ( false === $nested_key || ! is_array( $item[ $key ] ) ) {
            $value = $item[ $key ];
        } else {
            $value = isset( $item[ $key ][ $nested_key ] ) ? $item[ $key ][ $nested_key ] : false;
        }

        if ( ! empty( $value ) ) {
            return sprintf( $format, $value );
        }

    }

    /**
     * Include global template if any of passed settings is defined
     *
     * @param  [type] $name     [description]
     * @param  [type] $settings [description]
     * @return [type]           [description]
     */
    public function __glob_inc_if( $name = null, $settings = array() ) {

        $template = $this->__get_global_template( $name );

        call_user_func( array( $this, sprintf( '__%s_inc_if', $this->__context ) ), $template, $settings );

    }

    /**
     * Include render template if any of passed setting is not empty
     *
     * @param  [type] $file     [description]
     * @param  [type] $settings [description]
     * @return [type]           [description]
     */
    public function __render_inc_if( $file = null, $settings = array() ) {

        foreach ( $settings as $setting ) {
            $val = $this->get_settings_for_display( $setting );

            if ( ! empty( $val ) ) {
                include $file;
                return;
            }

        }

    }

    /**
     * Include render template if any of passed setting is not empty
     *
     * @param  [type] $file     [description]
     * @param  [type] $settings [description]
     * @return [type]           [description]
     */
    public function __edit_inc_if( $file = null, $settings = array() ) {

        $condition = null;
        $sep       = null;

        foreach ( $settings as $setting ) {
            $condition .= $sep . 'settings.' . $setting;
            $sep = ' || ';
        }

        ?>

        <# if ( <?php echo $condition; ?> ) { #>

        <?php include $file; ?>

        <# } #>

        <?php
    }

    /**
     * Open standard wrapper
     *
     * @return void
     */
    public function __open_wrap() {
        //printf( '<div class="elementor-%s novaworks-elements">', $this->get_name() );
    }

    /**
     * Close standard wrapper
     *
     * @return void
     */
    public function __close_wrap() {
        //echo '</div>';
    }

    /**
     * Print HTML markup if passed setting not empty.
     *
     * @param  string $setting Passed setting.
     * @param  string $format  Required markup.
     * @param  array  $args    Additional variables to pass into format string.
     * @param  bool   $echo    Echo or return.
     * @return string|void
     */
    public function __html( $setting = null, $format = '%s' ) {

        call_user_func( array( $this, sprintf( '__%s_html', $this->__context ) ), $setting, $format );

    }

    /**
     * Returns HTML markup if passed setting not empty.
     *
     * @param  string $setting Passed setting.
     * @param  string $format  Required markup.
     * @param  array  $args    Additional variables to pass into format string.
     * @param  bool   $echo    Echo or return.
     * @return string|void
     */
    public function __get_html( $setting = null, $format = '%s' ) {

        ob_start();
        $this->__html( $setting, $format );
        return ob_get_clean();

    }

    /**
     * Print HTML template
     *
     * @param  [type] $setting [description]
     * @param  [type] $format  [description]
     * @return [type]          [description]
     */
    public function __render_html( $setting = null, $format = '%s' ) {

        if ( is_array( $setting ) ) {
            $key     = $setting[1];
            $setting = $setting[0];
        }

        $val = $this->get_settings_for_display( $setting );

        if ( ! is_array( $val ) && '0' === $val ) {
            printf( $format, $val );
        }

        if ( is_array( $val ) && empty( $val[ $key ] ) ) {
            return '';
        }

        if ( ! is_array( $val ) && empty( $val ) ) {
            return '';
        }

        if ( is_array( $val ) ) {
            printf( $format, $val[ $key ] );
        }
        else {
            printf( $format, $val );
        }

    }

    /**
     * Print underscore template
     *
     * @param  [type] $setting [description]
     * @param  [type] $format  [description]
     * @return [type]          [description]
     */
    public function __edit_html( $setting = null, $format = '%s' ) {

        if ( is_array( $setting ) ) {
            $setting = $setting[0] . '.' . $setting[1];
        }

        echo '<# if ( settings.' . $setting . ' ) { #>';
        printf( $format, '{{{ settings.' . $setting . ' }}}' );
        echo '<# } #>';
    }

    protected function _load_template( $file ){
        include $file;
    }

    public static function get_labrandicon( $key_only = false ){
        $icons = array (
            'novaworksicon-b-dribbble'       => 'Dribbble',
            'novaworksicon-b-facebook'       => 'Facebook',
            'novaworksicon-b-flickr'         => 'Flickr',
            'novaworksicon-b-foursquare'     => 'Foursquare',
            'novaworksicon-b-github-circled' => 'Github',
            'novaworksicon-b-instagram'      => 'Instagram',
            'novaworksicon-b-lastfm'         => 'Lastfm',
            'novaworksicon-b-linkedin'       => 'LinkedIn',
            'novaworksicon-b-pinterest'      => 'Pinterest',
            'novaworksicon-b-reddit'         => 'Reddit',
            'novaworksicon-b-soundcloud'     => 'Soundcloud',
            'novaworksicon-b-spotify'        => 'Spotify',
            'novaworksicon-b-tumblr'         => 'Tumblr',
            'novaworksicon-b-twitter'        => 'Twitter',
            'novaworksicon-b-vimeo'          => 'Vimeo',
            'novaworksicon-b-vine'           => 'Vine',
            'novaworksicon-b-yelp'           => 'Yelp',
            'novaworksicon-b-yahoo-1'        => 'Yahoo',
            'novaworksicon-b-youtube-play'   => 'Youtube',
            'novaworksicon-b-wordpress'      => 'WordPress',
            'novaworksicon-b-dropbox'        => 'Dropbox',
            'novaworksicon-b-evernote'       => 'Evernote',
            'novaworksicon-b-skype'          => 'Skype',
            'novaworksicon-b-telegram'       => 'Telegram',
            'novaworksicon-mail'             => 'Email',
            'novaworksicon-phone-1'          => 'Phone',
        );
        if($key_only){
            return array_keys($icons);
        }
        return $icons;
    }

    public static function get_laicon_default( $key_only = false ){
	    $icon_list = array(
		    "ic_mail_outline_24px",
		    "ic_compare_arrows_24px",
		    "ic_compare_24px",
		    "ic_share_24px",
		    "bath-tub-1",
		    "shopping-cart-1",
		    "contrast",
		    "heart-1",
		    "sort-tool",
		    "list-bullet-1",
		    "menu-8-1",
		    "menu-4-1",
		    "menu-3-1",
		    "menu-1",
		    "down-arrow",
		    "left-arrow",
		    "right-arrow",
		    "up-arrow",
		    "phone-1",
		    "pin-3-1",
		    "search-content",
		    "single-01-1",
		    "i-delete",
		    "zoom-1",
		    "b-meeting",
		    "bag-20",
		    "bath-tub-2",
		    "web-link",
		    "shopping-cart-2",
		    "cart-return",
		    "check",
		    "g-check",
		    "d-check",
		    "circle-10",
		    "circle-simple-left",
		    "circle-simple-right",
		    "compare",
		    "letter",
		    "mail",
		    "email",
		    "eye",
		    "heart-2",
		    "shopping-cart-3",
		    "list-bullet-2",
		    "marker-3",
		    "measure-17",
		    "menu-8-2",
		    "menu-7",
		    "menu-4-2",
		    "menu-3-2",
		    "menu-2",
		    "microsoft",
		    "phone-2",
		    "phone-call-1",
		    "pin-3-2",
		    "pin-check",
		    "e-remove",
		    "single-01-2",
		    "i-add",
		    "small-triangle-down",
		    "small-triangle-left",
		    "small-triangle-right",
		    "tag-check",
		    "tag",
		    "clock",
		    "time-clock",
		    "triangle-left",
		    "triangle-right",
		    "business-agent",
		    "zoom-2",
		    "zoom-88",
		    "search-zoom-in",
		    "search-zoom-out",
		    "small-triangle-up",
		    "phone-call-2",
		    "full-screen",
		    "car-parking",
		    "transparent",
		    "bedroom-1",
		    "bedroom-2",
		    "search-property",
		    "menu-5",
		    "circle-simple-right-2",
		    "detached-property",
		    "armchair",
		    "measure-big",
		    "b-meeting-2",
		    "bulb-63",
		    "new-construction",
		    "quite-happy",
		    "shape-star-1",
		    "shape-star-2",
		    "star-rate-1",
		    "star-rate-2",
		    "home-2",
		    "home-3",
		    "home",
		    "home-2-2",
		    "home-3-2",
		    "home-4",
		    "home-search",
		    "e-add",
		    "e-delete",
		    "i-delete-2",
		    "i-add-2",
		    "arrow-right",
		    "arrow-left",
		    "arrow-up",
		    "arrow-down",
		    "a-check",
		    "a-add",
		    "chart-bar-32",
		    "chart-bar-32-2",
		    "cart-simple-add",
		    "cart-add",
		    "cart-add-2",
		    "cart-speed-1",
		    "cart-speed-2",
		    "cart-refresh",
		    "ic_format_quote_24px",
		    "quote-1",
		    "quote-2",
		    "dot",
	    );
	    $icons = array();
	    foreach ($icon_list as $value){
		    $icons['novaworksicon-'.$value] = str_replace(array('-', '_'), ' ', $value);
        }
	    if($key_only){
	        return array_keys($icons);
        }
	    return $icons;
    }

    public static function get_gif_img_for_lazy(){
        return 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
    }
}
