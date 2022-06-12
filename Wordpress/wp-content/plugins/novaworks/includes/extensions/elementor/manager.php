<?php
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

add_action('plugins_loaded', function (){
	if(empty(get_option('novaworks_has_elementor_error', false))){
		if( ($controls_stack = NOVA_PLUGIN_PATH . 'includes/extensions/elementor/override/includes/base/controls-stack.php') && file_exists($controls_stack) ) {
			require_once $controls_stack;
		}
		if( ($css_base = NOVA_PLUGIN_PATH . 'includes/extensions/elementor/override/core/files/css/base.php') && file_exists($css_base) ) {
			require_once $css_base;
		}
		if( ($typography = NOVA_PLUGIN_PATH . 'includes/extensions/elementor/override/includes/controls/groups/typography.php') && file_exists($typography) ) {
			require_once $typography;
		}
		if ( version_compare( ELEMENTOR_VERSION, '3.2.0', '<' ) ) {
			if( ($responsive = NOVA_PLUGIN_PATH . 'includes/extensions/elementor/override/old/core/responsive/responsive.php') && file_exists($responsive) ) {
				require_once $responsive;
			}
		}
		else{
			if( ($breakpoints = NOVA_PLUGIN_PATH . 'includes/extensions/elementor/override/core/breakpoints/manager.php') && file_exists($breakpoints) ) {
				require_once $breakpoints;
			}
		}
	}
}, 0);

require NOVA_PLUGIN_PATH . 'includes/extensions/elementor/classes/helper.php';
require_once NOVA_PLUGIN_PATH . 'includes/extensions/elementor/override/basic.php';
require_once NOVA_PLUGIN_PATH . 'includes/extensions/elementor/override/advance.php';
require_once NOVA_PLUGIN_PATH . 'includes/extensions/elementor/override/widgets.php';

function novaworks_elementor_autoload( $class ) {
    if ( 0 !== strpos( $class, 'Novaworks_Element' ) ) {
        return;
    }
    $filename = strtolower(
        preg_replace(
            [ '/^' . 'Novaworks_Element' . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
            [ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
            $class
        )
    );
    $filename = NOVA_PLUGIN_PATH .'includes/extensions/elementor/' . $filename . '.php';
    if ( is_readable( $filename ) ) {
        include( $filename );
    }
}

spl_autoload_register( 'novaworks_elementor_autoload' );


function novaworks_elementor_template_path(){
    return apply_filters( 'NovaworksElement/template-path', 'partials/elementor/' );
}

function novaworks_elementor_get_template( $name = null ){

    $template = locate_template( novaworks_elementor_template_path() . $name );

    if ( ! $template ) {
        $template = NOVA_PLUGIN_PATH  . 'includes/extensions/elementor/templates/' . str_replace('novaworks-', '', $name);
    }
    if ( file_exists( $template ) ) {
        return $template;
    }
    else {
        return false;
    }
}

function novaworks_elementor_get_all_modules(){
    $elementor_modules = [
        'advanced-carousel' => 'Advanced_Carousel',
        'advanced-map' => 'Advanced_Map',
        'animated-box' => 'Animated_Box',
        'animated-text' => 'Animated_Text',
        'audio' => 'Audio',
        'banner' => 'Banner',
        'button' => 'Button',
        'brands' => 'Brands',
        'circle-progress' => 'Circle_Progress',
        'countdown-timer' => 'Countdown_Timer',
        'dropbar'  => 'Dropbar',
        'headline' => 'Headline',
        'horizontal-timeline' => 'Horizontal_Timeline',
        'image-comparison' => 'Image_Comparison',
        'images-layout' => 'Images_Layout',
        'instagram-gallery' => 'Instagram_Gallery',
        'portfolio' => 'Portfolio',
        'posts' => 'Posts',
        'price-list' => 'Price_List',
        'pricing-table' => 'Pricing_Table',
        'progress-bar' => 'Progress_Bar',
        'scroll-navigation' => 'Scroll_Navigation',
        'services' => 'Services',
        'subscribe-form' => 'Subscribe_Form',
        'table' => 'Table',
        'tabs' => 'Tabs',
        'team-member' => 'Team_Member',
        'testimonials' => 'Testimonials',
        'timeline' => 'Timeline',
        'video-modal' => 'Video_Modal',
        'breadcrumbs' => 'Breadcrumbs',
        'post-navigation' => 'Post_Navigation',
        'slides' => 'Slides',
        'business-hours' => 'Business_Hours',
        'heading' => 'Heading',
    ];

    return $elementor_modules;
}

function novaworks_elementor_get_active_modules(){

    $all_modules = novaworks_elementor_get_all_modules();

    $active_modules = get_option('novaworks_elementor_modules');

    $enable_modules = [];

    if(!empty($active_modules)){
        foreach ($active_modules as $module => $active ){
            if(!empty($active) && isset($all_modules[$module])){
                $enable_modules[$module] = $all_modules[$module];
            }
        }
    }

    if(defined('WPCF7_PLUGIN_URL')){
        $enable_modules['contact-form-7'] = 'Contact_Form_7';
    }
    if(class_exists('WooCommerce')){
        $enable_modules['products'] = 'Products';
    }

    return $enable_modules;
}

function novaworks_elementor_get_resource_dependencies(){

    $resource_base_url = apply_filters('NovaworksElement/resource-base-url', NOVA_PLUGIN_URL . 'public/element');

    $resource_lib_url = NOVA_PLUGIN_URL . 'public/element';

    $google_api_key = apply_filters('NovaworksElement/advanced-map/api', '');

    $min = WP_DEBUG ? '' : '.min';

    $resource_dependencies = [
        'advanced-carousel' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-advanced-carousel-elm',
                    'src'       => $resource_base_url . '/css/carousel'.$min.'.css'
                ],
                [
                    'handler'   => 'novaworks-banner-elm',
                    'src'       => $resource_base_url . '/css/banner'.$min.'.css'
                ]
            ]
        ],
        'slides' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-slides-elm',
                    'src'       => $resource_base_url . '/css/slides'.$min.'.css'
                ]
            ],
            'js'   => [
                [
                    'handler'   => 'novaworks-slides-elm',
                    'src'       => $resource_base_url . '/js/slides'.$min.'.js'
                ]
            ]
        ],
        'advanced-map' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-advanced-map-elm',
                    'src'       => $resource_base_url . '/css/map'.$min.'.css'
                ]
            ],
            'js'    => [
                [
                    'handler'   => 'google-maps-api',
                    'src'       => add_query_arg( array( 'key' => $google_api_key ), 'https://maps.googleapis.com/maps/api/js' )
                ],
                [
                    'handler'   => 'novaworks-advanced-map-elm',
                    'src'       => $resource_base_url . '/js/advanced-map'.$min.'.js'
                ]
            ]
        ],
        'animated-box' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-animated-box-elm',
                    'src'       => $resource_base_url . '/css/animated-box'.$min.'.css'
                ]
            ],
            'js'   => [
                [
                    'handler'   => 'novaworks-animated-box-elm',
                    'src'       => $resource_base_url . '/js/animated-box'.$min.'.js'
                ]
            ]
        ],
        'animated-text' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-animated-text-elm',
                    'src'       => $resource_base_url . '/css/animated-text'.$min.'.css'
                ]
            ],
            'js'   => [
                [
                    'handler'   => 'novaworks-anime-js',
                    'src'       => $resource_lib_url . '/js/lib/anime.min.js'
                ],
                [
                    'handler'   => 'novaworks-animated-text-elm',
                    'src'       => $resource_base_url . '/js/animated-text'.$min.'.js'
                ]
            ]
        ],
        'audio' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-audio-elm',
                    'src'       => $resource_base_url . '/css/audio'.$min.'.css'
                ]
            ],
            'js'   => [
                [
                    'handler'   => 'novaworks-audio-elm',
                    'src'       => $resource_base_url . '/js/audio'.$min.'.js'
                ]
            ]
        ],
        'banner' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-banner-elm',
                    'src'       => $resource_base_url . '/css/banner'.$min.'.css'
                ]
            ],

        ],
        'button' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-button-elm',
                    'src'       => $resource_base_url . '/css/button'.$min.'.css'
                ]
            ]
        ],
        'posts' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-posts-elm',
                    'src'       => $resource_base_url . '/css/posts'.$min.'.css'
                ]
            ]
        ],
        'circle-progress' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-circle-progress-elm',
                    'src'       => $resource_base_url . '/css/circle-progress'.$min.'.css'
                ]
            ]
        ],
        'dropbar'  => [
            'css'   => [
                [
                    'handler'   => 'novaworks-dropbar-elm',
                    'src'       => $resource_base_url . '/css/dropbar'.$min.'.css'
                ]
            ],
            'js'   => [
                [
                    'handler'   => 'novaworks-dropbar-elm',
                    'src'       => $resource_base_url . '/js/dropbar'.$min.'.js'
                ]
            ]
        ],
        'headline' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-headline-elm',
                    'src'       => $resource_base_url . '/css/headline'.$min.'.css'
                ]
            ]
        ],
        'countdown-timer' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-countdown-timer-elm',
                    'src'       => $resource_base_url . '/css/countdown-timer'.$min.'.css'
                ]
            ],
            'js'   => [
                [
                    'handler'   => 'novaworks-countdown-timer-elm',
                    'src'       => $resource_base_url . '/js/countdown-timer'.$min.'.js'
                ]
            ]
        ],
        'horizontal-timeline' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-horizontal-timeline-elm',
                    'src'       => $resource_base_url . '/css/horizontal-timeline'.$min.'.css'
                ]
            ],
            'js'   => [
                [
                    'handler'   => 'novaworks-horizontal-timeline-elm',
                    'src'       => $resource_base_url . '/js/horizontal-timeline'.$min.'.js'
                ]
            ]
        ],
        'image-comparison' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-juxtapose',
                    'src'       => $resource_base_url . '/css/juxtapose'.$min.'.css'
                ],
                [
                    'handler'   => 'novaworks-image-comparison-elm',
                    'src'       => $resource_base_url . '/css/image-comparison'.$min.'.css'
                ]
            ],
            'js'   => [
                [
                    'handler'   => 'novaworks-juxtapose',
                    'src'       => $resource_lib_url . '/js/lib/juxtapose.min.js'
                ],
                [
                    'handler'   => 'novaworks-image-comparison-elm',
                    'src'       => $resource_base_url . '/js/image-comparison'.$min.'.js'
                ]
            ]
        ],
        'images-layout' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-images-layout-elm',
                    'src'       => $resource_base_url . '/css/image-layout'.$min.'.css'
                ]
            ]
        ],
        'instagram-gallery' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-instagram-gallery-elm',
                    'src'       => $resource_base_url . '/css/instagram-gallery'.$min.'.css'
                ]
            ]
        ],
        'price-list' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-price-list-elm',
                    'src'       => $resource_base_url . '/css/price-list'.$min.'.css'
                ]
            ]
        ],
        'pricing-table' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-pricing-table-elm',
                    'src'       => $resource_base_url . '/css/pricing-table'.$min.'.css'
                ]
            ]
        ],
        'progress-bar' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-progress-bar-elm',
                    'src'       => $resource_base_url . '/css/progress-bar'.$min.'.css'
                ]
            ],
            'js'   => [
                [
                    'handler'   => 'novaworks-anime-js',
                    'src'       => $resource_lib_url . '/js/lib/anime.min.js'
                ],
                [
                    'handler'   => 'novaworks-progress-bar-elm',
                    'src'       => $resource_base_url . '/js/progress-bar'.$min.'.js'
                ]
            ]
        ],
        'scroll-navigation' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-scroll-navigation-elm',
                    'src'       => $resource_base_url . '/css/scroll-navigation'.$min.'.css'
                ]
            ],
            'js'   => [
                [
                    'handler'   => 'novaworks-scroll-navigation-elm',
                    'src'       => $resource_base_url . '/js/scroll-navigation'.$min.'.js'
                ]
            ],

        ],
        'services' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-services-elm',
                    'src'       => $resource_base_url . '/css/services'.$min.'.css'
                ]
            ]
        ],
        'subscribe-form' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-subscribe-form-elm',
                    'src'       => $resource_base_url . '/css/subscribe-form'.$min.'.css'
                ]
            ],
            'js'   => [
                [
                    'handler'   => 'novaworks-subscribe-form-elm',
                    'src'       => $resource_base_url . '/js/subscribe-form'.$min.'.js'
                ]
            ]
        ],
        'table' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-table-elm',
                    'src'       => $resource_base_url . '/css/table'.$min.'.css'
                ]
            ],
            'js'   => [
                [
                    'handler'   => 'jquery-tablesorter',
                    'src'       => $resource_lib_url . '/js/lib/tablesorter.min.js'
                ],
                [
                    'handler'   => 'novaworks-table-elm',
                    'src'       => $resource_base_url . '/js/table'.$min.'.js'
                ]
            ],
        ],
        'tabs' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-tabs-elm',
                    'src'       => $resource_base_url . '/css/tabs'.$min.'.css'
                ]
            ]
        ],
        'team-member' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-team-member-elm',
                    'src'       => $resource_base_url . '/css/team-member'.$min.'.css'
                ]
            ]
        ],
        'testimonials' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-testimonials-elm',
                    'src'       => $resource_base_url . '/css/testimonials'.$min.'.css'
                ]
            ]
        ],
        'timeline' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-timeline-elm',
                    'src'       => $resource_base_url . '/css/timeline'.$min.'.css'
                ]
            ],
            'js'   => [
                [
                    'handler'   => 'novaworks-timeline-elm',
                    'src'       => $resource_base_url . '/js/timeline'.$min.'.js'
                ]
            ]
        ],
        'video-modal' => [
          'css'   => [
                [
                    'handler'   => 'novaworks-video-modal-elm',
                    'src'       => $resource_base_url . '/css/video-modal'.$min.'.css'
                ]
            ],
            'js'   => [
                [
                    'handler'   => 'novaworks-video-modal-lib',
                    'src'       => $resource_base_url . '/js/vendor/jquery-modal-video.js'
                ],
                [
                    'handler'   => 'novaworks-video-modal-elm',
                    'src'       => $resource_base_url . '/js/video-modal'.$min.'.js'
                ]
            ]
        ],
        'business-hours' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-business-hours-elm',
                    'src'       => $resource_base_url . '/css/business-hours'.$min.'.css'
                ]
            ]
        ],
        'heading' => [
            'css'   => [
                [
                    'handler'   => 'novaworks-heading-elm',
                    'src'       => $resource_base_url . '/css/heading'.$min.'.css'
                ]
            ]
        ],
    ];

    $resource_dependencies = apply_filters('NovaworksElement/resource-dependencies', $resource_dependencies);

    $enable_modules = novaworks_elementor_get_active_modules();

    $modules = [];

    if(!empty($enable_modules)){
        foreach ($enable_modules as $k => $v){
            if(isset($resource_dependencies[$k])){
                $modules[$k] = $resource_dependencies[$k];
            }
        }
    }
    return apply_filters('NovaworksElement/module-enabled-resource-dependency', $modules);
}
function novaworks_elementor_register_module_assets(){

    $min = WP_DEBUG ? '' : '.min';

    $theme_version = defined('WP_DEBUG') && WP_DEBUG ? time() : NOVA_VERSION;

    $modules = novaworks_elementor_get_resource_dependencies();

    if(!empty($modules)){
        foreach ($modules as $module => $resource){
            if(!empty($resource['css'])){
                foreach ($resource['css'] as $css){
                    wp_register_style($css['handler'], $css['src'], false, $theme_version);
                }
            }
            if(!empty($resource['js'])){
                foreach ($resource['js'] as $js){
                    wp_register_script($js['handler'], $js['src'], false, $theme_version, true);
                }
            }
        }
    }

    $resource_base_url = apply_filters('NovaworksElement/resource-base-url', NOVA_PLUGIN_URL . 'public/element');
    $resource_lib_url = NOVA_PLUGIN_URL . 'public/element';

    if (novaworks_get_theme_support('elementor::css-transform')) {
        $css_transform = ".la-css-transform-yes{-webkit-transition-duration:var(--la-tfx-transition-duration,.2s);transition-duration:var(--la-tfx-transition-duration,.2s);-webkit-transition-property:-webkit-transform;transition-property:transform;transition-property:transform,-webkit-transform;-webkit-transform:translate(var(--la-tfx-translate-x,0),var(--la-tfx-translate-y,0)) scale(var(--la-tfx-scale-x,1),var(--la-tfx-scale-y,1)) skew(var(--la-tfx-skew-x,0),var(--la-tfx-skew-y,0)) rotateX(var(--la-tfx-rotate-x,0)) rotateY(var(--la-tfx-rotate-y,0)) rotateZ(var(--la-tfx-rotate-z,0));transform:translate(var(--la-tfx-translate-x,0),var(--la-tfx-translate-y,0)) scale(var(--la-tfx-scale-x,1),var(--la-tfx-scale-y,1)) skew(var(--la-tfx-skew-x,0),var(--la-tfx-skew-y,0)) rotateX(var(--la-tfx-rotate-x,0)) rotateY(var(--la-tfx-rotate-y,0)) rotateZ(var(--la-tfx-rotate-z,0))}.la-css-transform-yes:hover{-webkit-transform:translate(var(--la-tfx-translate-x-hover,var(--la-tfx-translate-x,0)),var(--la-tfx-translate-y-hover,var(--la-tfx-translate-y,0))) scale(var(--la-tfx-scale-x-hover,var(--la-tfx-scale-x,1)),var(--la-tfx-scale-y-hover,var(--la-tfx-scale-y,1))) skew(var(--la-tfx-skew-x-hover,var(--la-tfx-skew-x,0)),var(--la-tfx-skew-y-hover,var(--la-tfx-skew-y,0))) rotateX(var(--la-tfx-rotate-x-hover,var(--la-tfx-rotate-x,0))) rotateY(var(--la-tfx-rotate-y-hover,var(--la-tfx-rotate-y,0))) rotateZ(var(--la-tfx-rotate-z-hover,var(--la-tfx-rotate-z,0)));transform:translate(var(--la-tfx-translate-x-hover,var(--la-tfx-translate-x,0)),var(--la-tfx-translate-y-hover,var(--la-tfx-translate-y,0))) scale(var(--la-tfx-scale-x-hover,var(--la-tfx-scale-x,1)),var(--la-tfx-scale-y-hover,var(--la-tfx-scale-y,1))) skew(var(--la-tfx-skew-x-hover,var(--la-tfx-skew-x,0)),var(--la-tfx-skew-y-hover,var(--la-tfx-skew-y,0))) rotateX(var(--la-tfx-rotate-x-hover,var(--la-tfx-rotate-x,0))) rotateY(var(--la-tfx-rotate-y-hover,var(--la-tfx-rotate-y,0))) rotateZ(var(--la-tfx-rotate-z-hover,var(--la-tfx-rotate-z,0)))}";
        wp_add_inline_style('elementor-frontend', $css_transform);
    }
    if (novaworks_get_theme_support('elementor::floating-effects')) {
        wp_register_script(
            'novaworks-wrapper-links',
            $resource_base_url . '/js/wrapper-links'.$min.'.js',
            [ 'elementor-frontend' ],
            $theme_version,
            true
        );
    }
    if (novaworks_get_theme_support('elementor::wrapper-links')) {
        wp_register_script(
            'novaworks-anime-js',
            $resource_lib_url . '/js/lib/anime.min.js',
            false,
            $theme_version,
            true
        );
        wp_register_script(
            'novaworks-floating-effects',
            $resource_base_url . '/js/floating-effects'.$min.'.js',
            [ 'novaworks-anime-js', 'elementor-frontend' ],
            $theme_version,
            true
        );
    }

    /**
     * Enqueue Monion & Sticky Scripts
     */
    if(!defined('ELEMENTOR_PRO_VERSION')){
        wp_register_script(
            'novaworks-sticky',
            $resource_lib_url . '/js/lib/jquery.sticky.min.js',
            [
                'jquery',
            ],
            $theme_version,
            true
        );
        wp_register_script(
            'novaworks-motion-fx',
            $resource_lib_url . '/js/lib/motion-fx.js' ,
            [
                'elementor-frontend-modules',
                'novaworks-sticky'
            ],
            $theme_version,
            true
        );
    }

    wp_register_script(
        'novaworks-element-front',
        $resource_base_url . '/js/novaworks-element'.$min.'.js' ,
        [ 'elementor-frontend' ],
        $theme_version,
        true
    );
    wp_localize_script(
        'novaworks-element-front',
        'NovaworksElementConfigs',
        apply_filters( 'NovaworksElement/frontend/localize-data', [
            'ajaxurl'       => admin_url( 'admin-ajax.php' ),
            'invalidMail'   => esc_attr__( 'Please specify a valid e-mail', 'novaworks' ),
        ] )
    );
}
add_action( 'elementor/frontend/after_register_styles', 'novaworks_elementor_register_module_assets' );

function novaworks_elementor_init_hook(){
    Novaworks_Element\Classes\Query_Control::instance();
    Elementor\Plugin::instance()->elements_manager->add_category( 'novaworks', [
            'title' => esc_html__( 'Novaworks Element', 'novaworks' ),
            'icon'  => 'font'
        ], 1 );
}
add_action('elementor/init', 'novaworks_elementor_init_hook' );

add_action('elementor/controls/controls_registered', function( $controls_manager ){
    $controls_manager->add_group_control( \Novaworks_Element\Controls\Group_Control_Box_Style::get_type(), new \Novaworks_Element\Controls\Group_Control_Box_Style() );
    if(!defined('ELEMENTOR_PRO_VERSION')){
        $controls_manager->add_group_control( \Novaworks_Element\Controls\Group_Control_Motion_Fx::get_type(), new \Novaworks_Element\Controls\Group_Control_Motion_Fx() );
    }
});

add_action('elementor/widgets/widgets_registered', function(){

    $modules = novaworks_elementor_get_active_modules();

    if( !empty($modules) ) {
        foreach ($modules as $module => $name){
            $class_name = 'Novaworks_Element\\Widgets\\' . $name;
            if(class_exists($class_name)){
                \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );
            }
        }
    }

});

add_action('elementor/editor/after_enqueue_styles', function(){
    $theme_version = defined('WP_DEBUG') && WP_DEBUG ? time() : NOVA_VERSION;
    wp_enqueue_style( 'novaworks-elementor', NOVA_PLUGIN_URL . 'admin/css/elementor.css', false, $theme_version);
});

add_action('elementor/frontend/after_render', function(){
    $scriptNeedRemove = array(
        'jquery-slick',
    );
    foreach ($scriptNeedRemove as $script) {
        if (wp_script_is($script, 'registered')) {
            wp_dequeue_script($script);
        }
    }
});

add_filter('novaworks/theme/defer_scripts', function( $scripts ){

    $modules = novaworks_elementor_get_resource_dependencies();
    if(!empty($modules)){
        foreach ($modules as $module => $resource){
            if(!empty($resource['js'])){
                foreach ($resource['js'] as $js){
                    $scripts[] = $js['handler'];
                }
            }
        }
    }

    $scripts[] = 'novaworks-element-front';
    $scripts[] = 'novaworks-sticky';
    $scripts[] = 'novaworks-motion-fx';

    return $scripts;
});

add_filter('elementor/icons_manager/additional_tabs', function( $tabs ){
    $tabs['novaicon'] = [
        'name' => 'novaicon',
        'label' => __( 'Nova Icons', 'novaworks' ),
        'url' =>  NOVA_PLUGIN_URL . 'public/css/novaicon.css',
        'prefix' => '',
        'displayPrefix' => 'novaicon',
        'labelIcon' => 'fas fa-star',
        'ver' => '1.0.0',
        'fetchJson' => NOVA_PLUGIN_URL . 'public/fonts/novaicon.json',
        'native' => false
    ];
    return $tabs;
});

function novaworks_elementor_tools_get_select_range( $to = 10 ){
    $range = range( 1, $to );
    return array_combine( $range, $range );
}

function novaworks_elementor_tools_get_nextprev_arrows_list( $type = '' ){
    if($type == 'prev'){
        return apply_filters(
            'novaworks_elements/carousel/available_arrows/prev',
            array(
                'novaworksicon-left-arrow'           => __( 'Default', 'novaworks' ),
                'novaworksicon-small-triangle-left'  => __( 'Small Triangle', 'novaworks' ),
                'novaworksicon-triangle-left'        => __( 'Triangle', 'novaworks' ),
                'novaworksicon-arrow-left'           => __( 'Arrow', 'novaworks' ),
                'novaworksicon-svgleft'              => __( 'SVG', 'novaworks' ),
            )
        );
    }
    return apply_filters(
        'novaworks_elements/carousel/available_arrows/next',
        array(
            'novaworksicon-right-arrow'           => __( 'Default', 'novaworks' ),
            'novaworksicon-small-triangle-right'  => __( 'Small Triangle', 'novaworks' ),
            'novaworksicon-triangle-right'        => __( 'Triangle', 'novaworks' ),
            'novaworksicon-arrow-right'           => __( 'Arrow', 'novaworks' ),
            'novaworksicon-svgright'              => __( 'SVG', 'novaworks' ),
        )
    );
}

function novaworks_elementor_tools_get_arrows_style(){
    return apply_filters(
        'novaworks_elements/carousel/arrows_styles',
        array(
            'default'           => __( 'Default', 'novaworks' ),
            'style-01'  => __( 'Style 01', 'novaworks' ),
        )
    );
}

function novaworks_elementor_tools_get_carousel_arrow( $classes = [], $icons = []){
    $format = apply_filters( 'NovaworksElement/carousel/arrows_format', '<button class="novaworks-arrow %1$s"><i class="%2$s"></i></button>', $classes, $icons );

    return sprintf( $format, implode( ' ', $classes ), implode( ' ', $icons ) );
}

function novaworks_elementor_get_public_post_types( $args = [] ){
    $post_type_args = [
        'show_in_nav_menus' => true,
    ];

    if ( ! empty( $args['post_type'] ) ) {
        $post_type_args['name'] = $args['post_type'];
    }

    $_post_types = get_post_types( $post_type_args, 'objects' );

    $post_types = [];

    foreach ( $_post_types as $post_type => $object ) {
        $post_types[ $post_type ] = $object->label;
    }

    return $post_types;
}

function novaworks_element_render_grid_classes( $columns = [] ){
    $columns = wp_parse_args( $columns, array(
        'desktop'  => '1',
        'laptop'   => '',
        'tablet'   => '',
        'mobile'  => '',
        'xmobile'   => ''
    ) );

    $replaces = array(
        'xmobile' => 'xmobile-block-grid',
        'mobile' => 'mobile-block-grid',
        'tablet' => 'tablet-block-grid',
        'laptop' => 'laptop-block-grid',
        'desktop' => 'block-grid'
    );

    $classes = array();

    foreach ( $columns as $device => $cols ) {
        if ( ! empty( $cols ) ) {
            $classes[] = sprintf( '%1$s-%2$s', $replaces[$device], $cols );
        }
    }
    return implode( ' ' , $classes );
}
/** Fix Elementor AutoSave `revision`  problem */
add_filter('wp_insert_post_data', function ( $data ){
    if(strpos($data['post_content'], '<!-- Created With Elementor -->') !== false ){
        $data['post_content'] = '<!-- Created With Elementor -->' . current_time('timestamp');
    }
    return $data;
}, 10);
