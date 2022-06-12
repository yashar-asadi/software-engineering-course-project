<?php
// If this file is called directly, abort.

if ( ! defined( 'WPINC' ) ) {
    die;
}

add_action('elementor/element/after_section_end', function( $controls_stack, $section_id ){

    if ( 'section_custom_css_pro' !== $section_id || defined('ELEMENTOR_PRO_VERSION') ) {
        return;
    }

    $old_section = \Elementor\Plugin::instance()->controls_manager->get_control_from_stack( $controls_stack->get_unique_name(), 'section_custom_css_pro' );
    \Elementor\Plugin::instance()->controls_manager->remove_control_from_stack( $controls_stack->get_unique_name(), [ 'section_custom_css_pro', 'custom_css_pro' ] );

    $controls_stack->start_controls_section(
        'section_custom_css',
        [
            'label' => __( 'Custom CSS', 'novaworks' ),
            'tab' => $old_section['tab'],
        ]
    );

    $controls_stack->add_control(
        'custom_css',
        [
            'type' => \Elementor\Controls_Manager::CODE,
            'label' => __( 'Add your own custom CSS here', 'novaworks' ),
            'language' => 'css',
            'description' => __( 'Use "selector" to target wrapper element. Examples:<br>selector {color: red;} // For main element<br>selector .child-element {margin: 10px;} // For child element<br>.my-class {text-align: center;} // Or use any custom selector', 'novaworks' ),
            'render_type' => 'ui',
            'separator' => 'none'
        ]
    );

    $controls_stack->end_controls_section();

}, 10, 2);

add_action('elementor/element/parse_css', function( $post_css, $element ){

    if(defined('ELEMENTOR_PRO_VERSION')){
        return;
    }

    if ( $post_css instanceof \Elementor\Core\DynamicTags\Dynamic_CSS) {
        return;
    }
    $element_settings = $element->get_settings();

    if ( empty( $element_settings['custom_css'] ) ) {
        return;
    }

    $css = trim( $element_settings['custom_css'] );

    if ( empty( $css ) ) {
        return;
    }
    $css = str_replace( 'selector', $post_css->get_element_unique_selector( $element ), $css );

    // Add a css comment
    $css = sprintf( '/* Start custom CSS for %s, class: %s */', $element->get_name(), $element->get_unique_selector() ) . $css . '/* End custom CSS */';

    $post_css->get_stylesheet()->add_raw_css( $css );
}, 10, 2);

add_action('elementor/css-file/post/parse', function( $post_css ){

    if(defined('ELEMENTOR_PRO_VERSION')){
        return;
    }

    $document = \Elementor\Plugin::instance()->documents->get( $post_css->get_post_id() );
    $custom_css = $document->get_settings( 'custom_css' );

    $custom_css = trim( $custom_css );

    if ( empty( $custom_css ) ) {
        return;
    }

    $custom_css = str_replace( 'selector', $document->get_css_wrapper_selector(), $custom_css );

    // Add a css comment
    $custom_css = '/* Start custom CSS */' . $custom_css . '/* End custom CSS */';

    $post_css->get_stylesheet()->add_raw_css( $custom_css );

});

function novaworks_element_add_controls_group_to_element( $element ){
    if(defined('ELEMENTOR_PRO_VERSION')){
        return;
    }

    $exclude = [];
    $selector = '{{WRAPPER}}';
    if ( $element instanceof \Elementor\Element_Section ) {
        $exclude[] = 'motion_fx_mouse';
    }
    elseif ( $element instanceof \Elementor\Element_Column ) {
        $selector .= ' > .elementor-column-wrap';
    }
    else {
        $selector .= ' > .elementor-widget-container';
    }
    $element->add_group_control(
        'motion_fx',
        [
            'name' => 'motion_fx',
            'selector' => $selector,
            'exclude' => $exclude,
        ]
    );
}

add_action( 'elementor/element/section/section_effects/after_section_start', 'novaworks_element_add_controls_group_to_element' );
add_action( 'elementor/element/column/section_effects/after_section_start', 'novaworks_element_add_controls_group_to_element' );
add_action( 'elementor/element/common/section_effects/after_section_start', 'novaworks_element_add_controls_group_to_element' );

function novaworks_element_add_controls_group_to_element_background( $element ){
    if(defined('ELEMENTOR_PRO_VERSION')){
        return;
    }

    $element->start_injection( [
        'of' => 'background_bg_width_mobile',
    ] );

    $element->add_group_control(
        'motion_fx',
        [
            'name' => 'background_motion_fx',
            'exclude' => [
                'rotateZ_effect',
                'tilt_effect',
                'transform_origin_x',
                'transform_origin_y',
            ],
        ]
    );

    $options = [
        'separator' => 'before',
        'conditions' => [
            'relation' => 'or',
            'terms' => [
                [
                    'terms' => [
                        [
                            'name' => 'background_background',
                            'value' => 'classic',
                        ],
                        [
                            'name' => 'background_image[url]',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
                [
                    'terms' => [
                        [
                            'name' => 'background_background',
                            'value' => 'gradient',
                        ],
                        [
                            'name' => 'background_color',
                            'operator' => '!==',
                            'value' => '',
                        ],
                        [
                            'name' => 'background_color_b',
                            'operator' => '!==',
                            'value' => '',
                        ],
                    ],
                ],
            ],
        ],
    ];

    $element->update_control( 'background_motion_fx_motion_fx_scrolling', $options );

    $element->update_control( 'background_motion_fx_motion_fx_mouse', $options );

    $element->end_injection();
}
add_action( 'elementor/element/section/section_background/before_section_end', 'novaworks_element_add_controls_group_to_element_background' );
add_action( 'elementor/element/column/section_style/before_section_end', 'novaworks_element_add_controls_group_to_element_background' );

function novaworks_element_add_sticky_control_to_element( $element ){
    if(defined('ELEMENTOR_PRO_VERSION')){
        return;
    }
    $element->add_control(
        'sticky',
        [
            'label' => __( 'Sticky', 'novaworks' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                '' => __( 'None', 'novaworks' ),
                'top' => __( 'Top', 'novaworks' ),
                'bottom' => __( 'Bottom', 'novaworks' ),
            ],
            'separator' => 'before',
            'render_type' => 'none',
            'frontend_available' => true,
        ]
    );

    $element->add_control(
        'sticky_on',
        [
            'label' => __( 'Sticky On', 'novaworks' ),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'label_block' => 'true',
            'default' => [ 'desktop', 'tablet', 'mobile' ],
            'options' => [
                'desktop' => __( 'Desktop', 'novaworks' ),
                'tablet' => __( 'Tablet', 'novaworks' ),
                'mobile' => __( 'Mobile', 'novaworks' ),
            ],
            'condition' => [
                'sticky!' => '',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]
    );

    $element->add_control(
        'sticky_offset',
        [
            'label' => __( 'Offset', 'novaworks' ),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0,
            'min' => 0,
            'max' => 500,
            'required' => true,
            'condition' => [
                'sticky!' => '',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]
    );

    $element->add_control(
        'sticky_effects_offset',
        [
            'label' => __( 'Effects Offset', 'novaworks' ),
            'type' => \Elementor\Controls_Manager::NUMBER,
            'default' => 0,
            'min' => 0,
            'max' => 1000,
            'required' => true,
            'condition' => [
                'sticky!' => '',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]
    );

    /*		if ( $element instanceof \Elementor\Widget_Base ) { */
    $element->add_control(
        'sticky_parent',
        [
            'label' => __( 'Stay In Column', 'novaworks' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'condition' => [
                'sticky!' => '',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]
    );
    /*		} */

    $element->add_control(
        'sticky_divider',
        [
            'type' => \Elementor\Controls_Manager::DIVIDER,
        ]
    );
}
add_action( 'elementor/element/section/section_effects/after_section_start', 'novaworks_element_add_sticky_control_to_element' );
add_action( 'elementor/element/common/section_effects/after_section_start', 'novaworks_element_add_sticky_control_to_element' );

/** Add Shortcode **/
if(!defined('ELEMENTOR_PRO_VERSION')) {
    if (is_admin()) {
        add_action('manage_' . \Elementor\TemplateLibrary\Source_Local::CPT . '_posts_columns', function ($defaults) {
            $defaults['shortcode'] = __('Shortcode', 'novaworks');
            return $defaults;
        });
        add_action('manage_' . \Elementor\TemplateLibrary\Source_Local::CPT . '_posts_custom_column', function ( $column_name, $post_id) {
            if ( 'shortcode' === $column_name ) {
                // %s = shortcode, %d = post_id
                $shortcode = esc_attr( sprintf( '[%s id="%d"]', 'elementor-template', $post_id ) );
                printf( '<input class="elementor-shortcode-input" type="text" readonly onfocus="this.select()" value="%s" />', $shortcode );
            }
        }, 10, 2);
    }
    add_shortcode( 'elementor-template', function( $attributes = [] ){
        if ( empty( $attributes['id'] ) ) {
            return '';
        }
        $include_css = false;
        if ( isset( $attributes['css'] ) && 'false' !== $attributes['css'] ) {
            $include_css = (bool) $attributes['css'];
        }
        return \Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $attributes['id'], $include_css );
    } );

    add_action('elementor/init', function(){
        \Elementor\Plugin::instance()->documents->register_document_type( 'footer', \Novaworks_Element\Classes\Footer_Location::get_class_full_name() );
    });
}

add_filter('single_template', function( $template ){
    if(is_singular('elementor_library') && !defined('ELEMENTOR_PRO_VERSION')){
        return NOVA_PLUGIN_PATH .'includes/extensions/elementor/single-elementor_library.php';
    }
    return $template;
});
/** Add Footer Location **/

/**   OVERRIDE Widget Base  **/
add_action('elementor/element/section/section_layout/before_section_end', 'novaworks_element_modify_content_width_for_section', 10, 2);
function novaworks_element_modify_content_width_for_section( $element, $args ){
    $element->remove_control('content_width');
    $element->add_responsive_control(
        'nova_content_width',
        [
            'label' => __( 'Content Width', 'elementor' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 500,
                    'max' => 1600,
                ],
                '%' => [
                    'min' => 10,
                    'max' => 100,
                ],
                'vw' => [
                    'min' => 10,
                    'max' => 100,
                ],
            ],
            'size_units' => [ 'px' , '%' , 'vw' ],
            'selectors' => [
                '{{WRAPPER}} > .elementor-container' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'layout' => [ 'boxed' ],
            ],
            'separator' => 'none',
            'show_label' => false,
        ],
        [
            'index' => 3
        ]
    );
    $element->update_control(
        'html_tag',
        [
            'default' => 'div'
        ]
    );
}

add_action('elementor/element/after_section_end', 'novaworks_element_modify_padding_margin_from_widget_common', 10, 2);
function novaworks_element_modify_padding_margin_from_widget_common( $controls_stack, $section_id ){
    if($section_id === 'section_advanced'){
        $controls_stack->update_responsive_control(
            'margin',
            [
                'size_units' => [ 'px', 'em', '%', 'rem', 'vw', 'vh' ]
            ]
        );
        $controls_stack->update_responsive_control(
            'padding',
            [
                'size_units' => [ 'px', 'em', '%', 'rem', 'vw', 'vh' ]
            ]
        );
    }

    if($section_id === '_section_style'){
        $controls_stack->update_responsive_control(
            '_margin',
            [
                'size_units' => [ 'px', 'em', '%', 'rem', 'vw', 'vh' ]
            ]
        );
        $controls_stack->update_responsive_control(
            '_padding',
            [
                'size_units' => [ 'px', 'em', '%', 'rem', 'vw', 'vh' ]
            ]
        );
    }

    if(novaworks_get_theme_support('elementor::wrapper-links')){
        $stack_name = $controls_stack->get_name();
        if( (($stack_name === 'column' || $stack_name === 'section') && $section_id === 'section_advanced') || ($stack_name === 'common' && $section_id === '_section_style') ){
            $tabs = \Elementor\Controls_Manager::TAB_CONTENT;
            if($stack_name === 'column' || $stack_name === 'section'){
                $tabs = \Elementor\Controls_Manager::TAB_LAYOUT;
            }
            $controls_stack->start_controls_section(
                '_section_la_wrapper_link',
                [
                    'label' => __( 'Novaworks Wrapper Link', 'novaworks' ),
                    'tab'   => $tabs,
                ]
            );
            $controls_stack->add_control(
                'la_element_link',
                [
                    'label'       => __( 'Link', 'novaworks' ),
                    'type'        => \Elementor\Controls_Manager::URL,
                    'dynamic'     => [
                        'active' => true,
                    ],
                    'placeholder' => 'https://example.com',
                ]
            );
            $controls_stack->end_controls_section();
        }
    }
}

/**
 * Render wrapper links for widget
 */
add_action('elementor/frontend/before_render', function ( $element ){
    if(novaworks_get_theme_support('elementor::wrapper-links')) {
        $link_settings = $element->get_settings_for_display('la_element_link');
        if (!empty($link_settings) && !empty($link_settings['url'])) {
            $element->add_render_attribute('_wrapper', [
                'data-la-element-link' => json_encode($link_settings),
                'style' => 'cursor: pointer'
            ]);
            $element->add_script_depends('novaworks-wrapper-links');
        }
    }

    if(novaworks_get_theme_support('elementor::floating-effects')) {
        //if ( 'yes' == $element->get_settings_for_display( 'la_floating_fx' ) && 'yes' != $element->get_settings_for_display('motion_fx_motion_fx_mouse') && 'yes' != $element->get_settings_for_display('motion_fx_motion_fx_scrolling') ) {
            $element->add_script_depends('novaworks-floating-effects');
        //}
    }
    if(!defined('ELEMENTOR_PRO_VERSION')) {
        $motion_groups = [
            'motion_fx_motion_fx_mouse',
            'motion_fx_motion_fx_scrolling',
            'sticky',
            'background_motion_fx_motion_fx_scrolling',
            'background_motion_fx_motion_fx_mouse',
        ];
        $need_enqueue_motion = false;
        foreach ($motion_groups as $group_key) {
            $group_value = $element->get_settings_for_display($group_key);
            if (!empty($group_value) && ($group_value == 'yes' || $group_value == 'top' || $group_value == 'bottom')) {
                $need_enqueue_motion = true;
            }
        }
        if ($need_enqueue_motion) {
            $element->add_script_depends('novaworks-motion-fx');
        }
    }
});
add_action('elementor/preview/enqueue_scripts', function (){
    if(novaworks_get_theme_support('elementor::floating-effects')) {
        wp_enqueue_script('novaworks-floating-effects');
    }
    if(!defined('ELEMENTOR_PRO_VERSION')){
        wp_enqueue_script('novaworks-motion-fx');
    }
});

/**
 * Modify Icon List - Text Indent control
 */
add_action('elementor/element/icon-list/section_text_style/before_section_end', function( $element ){
    $element->remove_control('text_indent');
    $element->update_control('icon_color', [
        'selectors' => [
            '{{WRAPPER}} .elementor-icon-list-icon i' => 'color: {{VALUE}};',
            '{{WRAPPER}} .elementor-icon-list-icon svg' => 'fill: {{VALUE}};color: {{VALUE}};',
        ]
    ]);
    $element->add_responsive_control(
        'text_indent',
        [
            'label' => __( 'Text Indent', 'elementor' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-list-text' => is_rtl() ? 'padding-right: {{SIZE}}{{UNIT}};' : 'padding-left: {{SIZE}}{{UNIT}};',
            ],
        ]
    );
}, 10 );

/**
 * Modify Icon - Padding & shadow
 */
add_action('elementor/element/icon/section_style_icon/before_section_end', function( $element ){
    $element->remove_control('icon_padding');
    $element->add_responsive_control(
        'icon_padding',
        [
            'label' => __( 'Padding', 'elementor' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
            ],
            'range' => [
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'size_units' => [ 'em', 'px' ],
            'condition' => [
                'view!' => 'default',
            ],
        ]
    );
    $element->add_group_control(
        Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name'     => 'i_shadow',
            'selector' => '{{WRAPPER}} .elementor-icon',
            'condition' => [
                'view!' => 'default',
            ]
        ]
    );
}, 10 );

/**
 * Modify Divider - Weight control
 */
add_action('elementor/element/divider/section_divider_style/before_section_end', function( $element ){
    $element->remove_control('weight');
    $element->add_responsive_control(
        'weight',
        [
            'label' => __( 'Weight', 'novaworks' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'size' => 1
            ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 10,
                    'step' => 0.1,
                ],
            ],
            'render_type' => 'template',
            'selectors' => [
                '{{WRAPPER}}' => '--divider-border-width: {{SIZE}}{{UNIT}}'
            ]
        ]
    );
}, 10 );
/**
 * Modify Image - Max Width control
 */
add_action('elementor/element/image/section_style_image/before_section_end', function( $element ){
    $element->update_responsive_control(
        'space',
        [
            'label' => __( 'Max Width', 'elementor' ),
            'size_units' => [ '%', 'px' ],
        ]
    );
}, 10);

/**
 * Modify Image Box - Position control
 */
add_action('elementor/element/image-box/section_image/before_section_end', function( $element ){
    $element->add_control(
        'keep_position',
        [
            'label' => __( 'Keep position on mobile', 'elementor' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => '',
            'condition'    => [
                'position!' => 'top'
            ],
            'prefix_class' => 'keep-mb-pos-',
        ]
    );
    $element->add_control(
        'enable_divider',
        [
            'label' => __( 'Enable Divider', 'elementor' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                '' => __( 'Disable', 'novaworks' ),
                'before' => __( 'Before Title', 'novaworks' ),
                'after' => __( 'After Title', 'novaworks' ),
            ],
            'prefix_class' => 'divider-ps-',
        ]
    );
    $element->add_responsive_control(
        'divider_alignment',
        array(
            'label'   => esc_html__( 'Alignment', 'novaworks' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'default' => 'left',
            'options' => array(
                'left'    => array(
                    'title' => esc_html__( 'Left', 'novaworks' ),
                    'icon'  => 'eicon-h-align-left',
                ),
                'center' => array(
                    'title' => esc_html__( 'Center', 'novaworks' ),
                    'icon'  => 'eicon-h-align-center',
                ),
                'right' => array(
                    'title' => esc_html__( 'Right', 'novaworks' ),
                    'icon'  => 'eicon-h-align-right',
                ),
            ),
            'selectors' => [
                '{{WRAPPER}} .elementor-image-box-title:before' => 'margin: 0 auto; margin-{{VALUE}}: 0',
                '{{WRAPPER}} .elementor-image-box-title:after' => 'margin: 0 auto; margin-{{VALUE}}: 0',
            ],
            'condition' => [
                'enable_divider!' => '',
            ]
        )
    );
    $element->add_control(
        'divider_color',
        [
            'label' => __( 'Divider Color', 'novaworks' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-image-box-title' => '--divider-color: {{VALUE}};',
            ],
            'condition' => [
                'enable_divider!' => '',
            ]
        ]
    );
    $element->add_responsive_control(
        'divider_width',
        [
            'label' => __( 'Divider Width', 'elementor' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .elementor-image-box-title' => '--divider-width: {{SIZE}}{{UNIT}};',
            ],
            'range' => [
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
                'px' => [
                    'min' => 0,
                    'max' => 500,
                ],
            ],
            'size_units' => [ 'em', 'px' ],
            'condition' => [
                'enable_divider!' => '',
            ],
        ]
    );
    $element->add_responsive_control(
        'divider_height',
        [
            'label' => __( 'Divider Height', 'elementor' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .elementor-image-box-title' => '--divider-height: {{SIZE}}{{UNIT}};',
            ],
            'range' => [
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
                'px' => [
                    'min' => 0,
                    'max' => 20,
                ],
            ],
            'size_units' => [ 'em', 'px' ],
            'condition' => [
                'enable_divider!' => '',
            ],
        ]
    );
    $element->add_responsive_control(
        'divider_spacing',
        [
            'label'      => esc_html__( 'Divider Space', 'novaworks' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'selectors'  => [
                '{{WRAPPER}} .elementor-image-box-title' => '--divider-space: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'enable_divider!' => ''
            ]
        ]
    );
}, 10 );

/**
 * Modify Image Box - Width & Space controls
 */
add_action('elementor/element/image-box/section_style_image/before_section_end', function( $element ){

    $element->update_responsive_control(
        'image_size',
        [
            'size_units' => [ '%', 'px' ],
        ]
    );
    $element->update_responsive_control(
        'image_space',
        [
            'selectors' => [
                '{{WRAPPER}}.elementor-position-right .elementor-image-box-img' => 'margin-left: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}}.elementor-position-left .elementor-image-box-img' => 'margin-right: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}}.elementor-position-top .elementor-image-box-img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                '(mobile){{WRAPPER}}:not(.keep-mb-pos-yes) .elementor-image-box-img' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                '(mobile){{WRAPPER}}.elementor-position-right.keep-mb-pos-yes .elementor-image-box-img' => 'margin-left: {{SIZE}}{{UNIT}} !important;',
                '(mobile){{WRAPPER}}.elementor-position-left.keep-mb-pos-yes .elementor-image-box-img' => 'margin-right: {{SIZE}}{{UNIT}} !important;',
            ],
        ]
    );
}, 10 );

/**
 * Modify Icon Box - Position control
 */
add_action('elementor/element/icon-box/section_icon/before_section_end', function( $element ){
    $element->add_control(
        'keep_position',
        [
            'label' => __( 'Keep position on mobile', 'elementor' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'default' => '',
            'condition'    => [
                'position!' => 'top'
            ],
            'prefix_class' => 'keep-mb-pos-',
        ]
    );
    $element->add_control(
        'enable_divider',
        [
            'label' => __( 'Enable Divider', 'elementor' ),
            'type' => \Elementor\Controls_Manager::SELECT,
            'options' => [
                '' => __( 'Disable', 'novaworks' ),
                'before' => __( 'Before Title', 'novaworks' ),
                'after' => __( 'After Title', 'novaworks' ),
            ],
            'prefix_class' => 'divider-ps-',
        ]
    );
    $element->add_responsive_control(
        'divider_alignment',
        array(
            'label'   => esc_html__( 'Alignment', 'novaworks' ),
            'type'    => \Elementor\Controls_Manager::CHOOSE,
            'default' => 'left',
            'options' => array(
                'left'    => array(
                    'title' => esc_html__( 'Left', 'novaworks' ),
                    'icon'  => 'eicon-h-align-left',
                ),
                'center' => array(
                    'title' => esc_html__( 'Center', 'novaworks' ),
                    'icon'  => 'eicon-h-align-center',
                ),
                'right' => array(
                    'title' => esc_html__( 'Right', 'novaworks' ),
                    'icon'  => 'eicon-h-align-right',
                ),
            ),
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-box-title:before' => 'margin: 0 auto; margin-{{VALUE}}: 0',
                '{{WRAPPER}} .elementor-icon-box-title:after' => 'margin: 0 auto; margin-{{VALUE}}: 0',
            ],
            'condition' => [
                'enable_divider!' => '',
            ]
        )
    );
    $element->add_control(
        'divider_color',
        [
            'label' => __( 'Divider Color', 'novaworks' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-box-title' => '--divider-color: {{VALUE}};',
            ],
            'condition' => [
                'enable_divider!' => '',
            ]
        ]
    );
    $element->add_responsive_control(
        'divider_width',
        [
            'label' => __( 'Divider Width', 'elementor' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-box-title' => '--divider-width: {{SIZE}}{{UNIT}};',
            ],
            'range' => [
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
                'px' => [
                    'min' => 0,
                    'max' => 500,
                ],
            ],
            'size_units' => [ 'em', 'px' ],
            'condition' => [
                'enable_divider!' => '',
            ],
        ]
    );
    $element->add_responsive_control(
        'divider_height',
        [
            'label' => __( 'Divider Height', 'elementor' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .elementor-icon-box-title' => '--divider-height: {{SIZE}}{{UNIT}};',
            ],
            'range' => [
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
                'px' => [
                    'min' => 0,
                    'max' => 20,
                ],
            ],
            'size_units' => [ 'em', 'px' ],
            'condition' => [
                'enable_divider!' => '',
            ],
        ]
    );
    $element->add_responsive_control(
        'divider_space',
        [
            'label'      => esc_html__( 'Divider Space', 'novaworks' ),
            'type'       => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px', '%'],
            'selectors'  => [
                '{{WRAPPER}} .elementor-icon-box-title' => '--divider-space: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'enable_divider!' => ''
            ]
        ]
    );
}, 10);

/**
 * Modify Icon Box - Icon Space & Padding & Shadow control
 */
add_action('elementor/element/icon-box/section_style_icon/before_section_end', function( $element ){
    $element->remove_control('icon_padding');
    $element->add_responsive_control(
        'icon_padding',
        [
            'label' => __( 'Padding', 'elementor' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'selectors' => [
                '{{WRAPPER}} .elementor-icon' => 'padding: {{SIZE}}{{UNIT}};',
            ],
            'range' => [
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
                'px' => [
                    'min' => 0,
                    'max' => 200,
                ],
            ],
            'size_units' => [ 'em', 'px' ],
            'condition' => [
                'view!' => 'default',
            ],
        ]
    );
    $element->add_group_control(
        Elementor\Group_Control_Box_Shadow::get_type(),
        [
            'name'     => 'i_shadow',
            'selector' => '{{WRAPPER}} .elementor-icon',
            'condition' => [
                'view!' => 'default',
            ]
        ]
    );
    $element->update_responsive_control(
        'icon_space',
        [
            'selectors' => [
                '{{WRAPPER}}.elementor-position-right .elementor-icon-box-icon' => 'margin-left: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}}.elementor-position-left .elementor-icon-box-icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}}.elementor-position-top .elementor-icon-box-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                '(mobile){{WRAPPER}}:not(.keep-mb-pos-yes) .elementor-icon-box-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                '(mobile){{WRAPPER}}.elementor-position-right.keep-mb-pos-yes .elementor-icon-box-icon' => 'margin-left: {{SIZE}}{{UNIT}}!important;',
                '(mobile){{WRAPPER}}.elementor-position-left.keep-mb-pos-yes .elementor-icon-box-icon' => 'margin-right: {{SIZE}}{{UNIT}}!important;',
            ],
        ]
    );
}, 10 );

/**
 * Modify Heading - Color Hover
 */
add_action('elementor/element/heading/section_title_style/before_section_end', function( $element ){
    $element->add_control(
        'title_hover_color',
        [
            'label' => __( 'Text Hover Color', 'elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-heading-title:hover' => 'color: {{VALUE}};',
            ],
        ]
    );
}, 10 );

/**
 * Modify Button - Icons
 */
add_action('elementor/element/button/section_style/before_section_end', function( $element ){
    $element->add_responsive_control(
        'icon_size',
        [
            'label' => __( 'Icon Size', 'novaworks' ),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 100
                ],
            ],
            'condition' => [
                'selected_icon[value]!' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button .elementor-button-icon' => 'font-size: {{SIZE}}{{UNIT}}'
            ],
            'separator' => 'before',
        ]
    );
    $element->add_control(
        'icon_color',
        [
            'label' => __( 'Icon Color', 'elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-button .elementor-button-icon' => 'color: {{VALUE}};'
            ],
            'condition' => [
                'selected_icon[value]!' => '',
            ],
        ]
    );
    $element->add_control(
        'icon_hover_color',
        [
            'label' => __( 'Icon Hover Color', 'elementor' ),
            'type' => \Elementor\Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} .elementor-button:hover .elementor-button-icon' => 'color: {{VALUE}};'
            ],
            'condition' => [
                'selected_icon[value]!' => '',
            ],
        ]
    );
    $element->add_responsive_control(
        'icon_margin',
        [
            'label' => __( 'Icon Margin', 'elementor' ),
            'type' => \Elementor\Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', 'em', '%' ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button .elementor-button-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'selected_icon[value]!' => '',
            ],
        ]
    );
}, 10 );

/**
 * Modify Spacer - space
 */
add_action('elementor/element/spacer/section_spacer/before_section_end', function( $element ){
    $element->update_responsive_control(
        'space',
        [
            'size_units' => [ 'px', 'vh', 'em', 'vw', '%' ],
        ]
    );
}, 10);

/**
 * Added Fix browser on backend editor
 */
add_action('elementor/element/editor-preferences/preferences/before_section_end', function ( $element ) {
    $element->add_control(
        'novaworks_fix_small_browser',
        [
            'label' => __( 'Fix Small Browser', 'novaworks' ),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'description' => __( 'Force set up minimum width for Elementor Preview', 'novaworks' ),
        ]
    );
}, 10);

/**
 * Support multiple breakpoint for columns
 */
add_action('elementor/element/column/layout/before_section_end', function ($element){
    $element->update_responsive_control(
        '_inline_size',
        [
            'device_args' => [
                'laptop' => [
                    'max' => 100,
                    'required' => false,
                ],
                'tabletportrait' => [
                    'max' => 100,
                    'required' => false,
                ],
                'tablet' => [
                    'max' => 100,
                    'required' => false,
                ],
                'mobile' => [
                    'max' => 100,
                    'required' => false,
                ],
            ],
            'min_affected_device' => [
                'desktop' => 'laptop',
                'laptop' => 'laptop'
            ],
        ]
    );
}, 99 );

/**
 * Support CSS transforms & Floating Effects for common widgets
 */
add_action('elementor/element/common/_section_style/after_section_end', function ($element) {
    if (novaworks_get_theme_support('elementor::floating-effects')) {
        $element->start_controls_section('_section_novaworks_floating_effects', [
            'label' => __('Novaworks Floating Effects', 'novaworks'),
            'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
        ]);
	    $element->add_control(
		    'la_floating_msg',
		    [
			    'type' => \Elementor\Controls_Manager::RAW_HTML,
			    'content_classes' => 'elementor-descriptor',
			    'raw' => __( 'This option will not work if Motion Scrolling Effects or Motion Mouse Effects is enabled', 'elementor' ),
		    ]
	    );
        $element->add_control('la_floating_fx', [
            'label' => __('Enable', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'frontend_available' => true,
        ]);
        $element->add_control('la_floating_fx_translate_toggle', [
            'label' => __('Translate', 'novaworks'),
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'return_value' => 'yes',
            'frontend_available' => true,
            'condition' => [
                'la_floating_fx' => 'yes',
            ]
        ]);
        $element->start_popover();
        $element->add_control('la_floating_fx_translate_x', [
            'label' => __('Translate X', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'sizes' => [
                    'from' => 0,
                    'to' => 5,
                ],
                'unit' => 'px',
            ],
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                ]
            ],
            'labels' => [
                __('From', 'novaworks'),
                __('To', 'novaworks'),
            ],
            'scales' => 1,
            'handles' => 'range',
            'condition' => [
                'la_floating_fx_translate_toggle' => 'yes',
                'la_floating_fx' => 'yes',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]);
        $element->add_control('la_floating_fx_translate_y', [
            'label' => __('Translate Y', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'sizes' => [
                    'from' => 0,
                    'to' => 5,
                ],
                'unit' => 'px',
            ],
            'range' => [
                'px' => [
                    'min' => -100,
                    'max' => 100,
                ]
            ],
            'labels' => [
                __('From', 'novaworks'),
                __('To', 'novaworks'),
            ],
            'scales' => 1,
            'handles' => 'range',
            'condition' => [
                'la_floating_fx_translate_toggle' => 'yes',
                'la_floating_fx' => 'yes',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]);
        $element->add_control('la_floating_fx_translate_duration', [
            'label' => __('Duration', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 10000,
                    'step' => 100
                ]
            ],
            'default' => [
                'size' => 1000,
            ],
            'condition' => [
                'la_floating_fx_translate_toggle' => 'yes',
                'la_floating_fx' => 'yes',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]);
        $element->add_control('la_floating_fx_translate_delay', [
            'label' => __('Delay', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 5000,
                    'step' => 100
                ]
            ],
            'condition' => [
                'la_floating_fx_translate_toggle' => 'yes',
                'la_floating_fx' => 'yes',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]);
        $element->end_popover();
        $element->add_control('la_floating_fx_rotate_toggle', [
            'label' => __('Rotate', 'novaworks'),
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'return_value' => 'yes',
            'frontend_available' => true,
            'condition' => [
                'la_floating_fx' => 'yes',
            ]
        ]);
        $element->start_popover();
        $element->add_control('la_floating_fx_rotate_x', [
            'label' => __('Rotate X', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'sizes' => [
                    'from' => 0,
                    'to' => 45,
                ],
                'unit' => 'px',
            ],
            'range' => [
                'px' => [
                    'min' => -180,
                    'max' => 180,
                ]
            ],
            'labels' => [
                __('From', 'novaworks'),
                __('To', 'novaworks'),
            ],
            'scales' => 1,
            'handles' => 'range',
            'condition' => [
                'la_floating_fx_rotate_toggle' => 'yes',
                'la_floating_fx' => 'yes',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]);
        $element->add_control('la_floating_fx_rotate_y', [
            'label' => __('Rotate Y', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'sizes' => [
                    'from' => 0,
                    'to' => 45,
                ],
                'unit' => 'px',
            ],
            'range' => [
                'px' => [
                    'min' => -180,
                    'max' => 180,
                ]
            ],
            'labels' => [
                __('From', 'novaworks'),
                __('To', 'novaworks'),
            ],
            'scales' => 1,
            'handles' => 'range',
            'condition' => [
                'la_floating_fx_rotate_toggle' => 'yes',
                'la_floating_fx' => 'yes',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]);
        $element->add_control('la_floating_fx_rotate_z', [
            'label' => __('Rotate Z', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'sizes' => [
                    'from' => 0,
                    'to' => 45,
                ],
                'unit' => 'px',
            ],
            'range' => [
                'px' => [
                    'min' => -180,
                    'max' => 180,
                ]
            ],
            'labels' => [
                __('From', 'novaworks'),
                __('To', 'novaworks'),
            ],
            'scales' => 1,
            'handles' => 'range',
            'condition' => [
                'la_floating_fx_rotate_toggle' => 'yes',
                'la_floating_fx' => 'yes',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]);
        $element->add_control('la_floating_fx_rotate_duration', [
            'label' => __('Duration', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 10000,
                    'step' => 100
                ]
            ],
            'default' => [
                'size' => 1000,
            ],
            'condition' => [
                'la_floating_fx_rotate_toggle' => 'yes',
                'la_floating_fx' => 'yes',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]);
        $element->add_control('la_floating_fx_rotate_delay', [
            'label' => __('Delay', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 5000,
                    'step' => 100
                ]
            ],
            'condition' => [
                'la_floating_fx_rotate_toggle' => 'yes',
                'la_floating_fx' => 'yes',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]);
        $element->end_popover();
        $element->add_control('la_floating_fx_scale_toggle', [
            'label' => __('Scale', 'novaworks'),
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'return_value' => 'yes',
            'frontend_available' => true,
            'condition' => [
                'la_floating_fx' => 'yes',
            ]
        ]);
        $element->start_popover();
        $element->add_control('la_floating_fx_scale_x', [
            'label' => __('Scale X', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'sizes' => [
                    'from' => 1,
                    'to' => 1.2,
                ],
                'unit' => 'px',
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => .1
                ]
            ],
            'labels' => [
                __('From', 'novaworks'),
                __('To', 'novaworks'),
            ],
            'scales' => 1,
            'handles' => 'range',
            'condition' => [
                'la_floating_fx_scale_toggle' => 'yes',
                'la_floating_fx' => 'yes',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]);
        $element->add_control('la_floating_fx_scale_y', [
            'label' => __('Scale Y', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'default' => [
                'sizes' => [
                    'from' => 1,
                    'to' => 1.2,
                ],
                'unit' => 'px',
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => .1
                ]
            ],
            'labels' => [
                __('From', 'novaworks'),
                __('To', 'novaworks'),
            ],
            'scales' => 1,
            'handles' => 'range',
            'condition' => [
                'la_floating_fx_scale_toggle' => 'yes',
                'la_floating_fx' => 'yes',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]);
        $element->add_control('la_floating_fx_scale_duration', [
            'label' => __('Duration', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 10000,
                    'step' => 100
                ]
            ],
            'default' => [
                'size' => 1000,
            ],
            'condition' => [
                'la_floating_fx_scale_toggle' => 'yes',
                'la_floating_fx' => 'yes',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]);
        $element->add_control('la_floating_fx_scale_delay', [
            'label' => __('Delay', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 5000,
                    'step' => 100
                ]
            ],
            'condition' => [
                'la_floating_fx_scale_toggle' => 'yes',
                'la_floating_fx' => 'yes',
            ],
            'render_type' => 'none',
            'frontend_available' => true,
        ]);
        $element->end_popover();
        $element->end_controls_section();
    }
    if (novaworks_get_theme_support('elementor::css-transform')) {
        $element->start_controls_section('_section_novaworks_css_transform', [
            'label' => __('Novaworks CSS Transform', 'novaworks'),
            'tab' => \Elementor\Controls_Manager::TAB_ADVANCED,
        ]);
        $element->add_control('la_transform_fx', [
            'label' => __('Enable', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SWITCHER,
            'return_value' => 'yes',
            'prefix_class' => 'la-css-transform-',
        ]);
        $element->start_controls_tabs('_tabs_la_transform', [
            'condition' => [
                'la_transform_fx' => 'yes',
            ],
        ]);
        $element->start_controls_tab('_tabs_la_transform_normal', [
            'label' => __('Normal', 'novaworks'),
            'condition' => [
                'la_transform_fx' => 'yes',
            ],
        ]);
        $element->add_control('la_transform_fx_translate_toggle', [
            'label' => __('Translate', 'novaworks'),
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'return_value' => 'yes',
            'condition' => [
                'la_transform_fx' => 'yes',
            ],
        ]);
        $element->start_popover();
        $element->add_responsive_control('la_transform_fx_translate_x', [
            'label' => __('Translate X', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -1000,
                    'max' => 1000,
                ]
            ],
            'condition' => [
                'la_transform_fx_translate_toggle' => 'yes',
                'la_transform_fx' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-translate-x: {{SIZE}}px;'
            ],
        ]);
        $element->add_responsive_control('la_transform_fx_translate_y', [
            'label' => __('Translate Y', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -1000,
                    'max' => 1000,
                ]
            ],
            'condition' => [
                'la_transform_fx_translate_toggle' => 'yes',
                'la_transform_fx' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-translate-y: {{SIZE}}px;'
            ],
        ]);
        $element->end_popover();
        $element->add_control('la_transform_fx_rotate_toggle', [
            'label' => __('Rotate', 'novaworks'),
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'condition' => [
                'la_transform_fx' => 'yes',
            ],
        ]);
        $element->start_popover();
        $element->add_control('la_transform_fx_rotate_mode', [
            'label' => __('Mode', 'novaworks'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'compact' => [
                    'title' => __('Compact', 'novaworks'),
                    'icon' => 'eicon-plus-circle',
                ],
                'loose' => [
                    'title' => __('Loose', 'novaworks'),
                    'icon' => 'eicon-minus-circle',
                ],
            ],
            'default' => 'loose',
            'toggle' => false
        ]);
        $element->add_control('la_transform_fx_rotate_hr', [
            'type' => \Elementor\Controls_Manager::DIVIDER,
        ]);
        $element->add_responsive_control('la_transform_fx_rotate_x', [
            'label' => __('Rotate X', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -180,
                    'max' => 180,
                ]
            ],
            'condition' => [
                'la_transform_fx_rotate_toggle' => 'yes',
                'la_transform_fx' => 'yes',
                'la_transform_fx_rotate_mode' => 'loose'
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-rotate-x: {{SIZE}}deg;'
            ],
        ]);
        $element->add_responsive_control('la_transform_fx_rotate_y', [
            'label' => __('Rotate Y', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -180,
                    'max' => 180,
                ]
            ],
            'condition' => [
                'la_transform_fx_rotate_toggle' => 'yes',
                'la_transform_fx' => 'yes',
                'la_transform_fx_rotate_mode' => 'loose'
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-rotate-y: {{SIZE}}deg;'
            ],
        ]);
        $element->add_responsive_control('la_transform_fx_rotate_z', [
            'label' => __('Rotate (Z)', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -180,
                    'max' => 180,
                ]
            ],
            'condition' => [
                'la_transform_fx_rotate_toggle' => 'yes',
                'la_transform_fx' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-rotate-z: {{SIZE}}deg;'
            ],
        ]);
        $element->end_popover();
        $element->add_control('la_transform_fx_scale_toggle', [
            'label' => __('Scale', 'novaworks'),
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'return_value' => 'yes',
            'condition' => [
                'la_transform_fx' => 'yes',
            ],
        ]);
        $element->start_popover();
        $element->add_control('la_transform_fx_scale_mode', [
            'label' => __('Mode', 'novaworks'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'compact' => [
                    'title' => __('Compact', 'novaworks'),
                    'icon' => 'eicon-plus-circle',
                ],
                'loose' => [
                    'title' => __('Loose', 'novaworks'),
                    'icon' => 'eicon-minus-circle',
                ],
            ],
            'default' => 'loose',
            'toggle' => false
        ]);
        $element->add_control('la_transform_fx_scale_hr', [
            'type' => \Elementor\Controls_Manager::DIVIDER,
        ]);
        $element->add_responsive_control('la_transform_fx_scale_x', [
            'label' => __('Scale (X)', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'default' => [
                'size' => 1
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => .1
                ]
            ],
            'condition' => [
                'la_transform_fx_scale_toggle' => 'yes',
                'la_transform_fx' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-scale-x: {{SIZE}}; --la-tfx-scale-y: {{SIZE}};'
            ],
        ]);
        $element->add_responsive_control('la_transform_fx_scale_y', [
            'label' => __('Scale Y', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'default' => [
                'size' => 1
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => .1
                ]
            ],
            'condition' => [
                'la_transform_fx_scale_toggle' => 'yes',
                'la_transform_fx' => 'yes',
                'la_transform_fx_scale_mode' => 'loose',
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-scale-y: {{SIZE}};'
            ],
        ]);
        $element->end_popover();
        $element->add_control('la_transform_fx_skew_toggle', [
            'label' => __('Skew', 'novaworks'),
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'return_value' => 'yes',
            'condition' => [
                'la_transform_fx' => 'yes',
            ],
        ]);
        $element->start_popover();
        $element->add_responsive_control('la_transform_fx_skew_x', [
            'label' => __('Skew X', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['deg'],
            'range' => [
                'px' => [
                    'min' => -180,
                    'max' => 180,
                ]
            ],
            'condition' => [
                'la_transform_fx_skew_toggle' => 'yes',
                'la_transform_fx' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-skew-x: {{SIZE}}deg;'
            ],
        ]);
        $element->add_responsive_control('la_transform_fx_skew_y', [
            'label' => __('Skew Y', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['deg'],
            'range' => [
                'px' => [
                    'min' => -180,
                    'max' => 180,
                ]
            ],
            'condition' => [
                'la_transform_fx_skew_toggle' => 'yes',
                'la_transform_fx' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-skew-y: {{SIZE}}deg;'
            ],
        ]);
        $element->end_popover();
        $element->end_controls_tab();
        $element->start_controls_tab('_tabs_la_transform_hover', [
            'label' => __('Hover', 'novaworks'),
            'condition' => [
                'la_transform_fx' => 'yes',
            ],
        ]);
        $element->add_control('la_transform_fx_translate_toggle_hover', [
            'label' => __('Translate', 'novaworks'),
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'return_value' => 'yes',
            'condition' => [
                'la_transform_fx' => 'yes',
            ],
        ]);
        $element->start_popover();
        $element->add_responsive_control('la_transform_fx_translate_x_hover', [
            'label' => __('Translate X', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -1000,
                    'max' => 1000,
                ]
            ],
            'condition' => [
                'la_transform_fx_translate_toggle_hover' => 'yes',
                'la_transform_fx' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-translate-x-hover: {{SIZE}}px;'
            ],
        ]);
        $element->add_responsive_control('la_transform_fx_translate_y_hover', [
            'label' => __('Translate Y', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -1000,
                    'max' => 1000,
                ]
            ],
            'condition' => [
                'la_transform_fx_translate_toggle_hover' => 'yes',
                'la_transform_fx' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-translate-y-hover: {{SIZE}}px;'
            ],
        ]);
        $element->end_popover();
        $element->add_control('la_transform_fx_rotate_toggle_hover', [
            'label' => __('Rotate', 'novaworks'),
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'condition' => [
                'la_transform_fx' => 'yes',
            ],
        ]);
        $element->start_popover();
        $element->add_control('la_transform_fx_rotate_mode_hover', [
            'label' => __('Mode', 'novaworks'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'compact' => [
                    'title' => __('Compact', 'novaworks'),
                    'icon' => 'eicon-plus-circle',
                ],
                'loose' => [
                    'title' => __('Loose', 'novaworks'),
                    'icon' => 'eicon-minus-circle',
                ],
            ],
            'default' => 'loose',
            'toggle' => false
        ]);
        $element->add_control('la_transform_fx_rotate_hr_hover', [
            'type' => \Elementor\Controls_Manager::DIVIDER,
        ]);
        $element->add_responsive_control('la_transform_fx_rotate_x_hover', [
            'label' => __('Rotate X', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -180,
                    'max' => 180,
                ]
            ],
            'condition' => [
                'la_transform_fx_rotate_toggle_hover' => 'yes',
                'la_transform_fx' => 'yes',
                'la_transform_fx_rotate_mode_hover' => 'loose'
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-rotate-x-hover: {{SIZE}}deg;'
            ],
        ]);
        $element->add_responsive_control('la_transform_fx_rotate_y_hover', [
            'label' => __('Rotate Y', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -180,
                    'max' => 180,
                ]
            ],
            'condition' => [
                'la_transform_fx_rotate_toggle_hover' => 'yes',
                'la_transform_fx' => 'yes',
                'la_transform_fx_rotate_mode_hover' => 'loose'
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-rotate-y-hover: {{SIZE}}deg;'
            ],
        ]);
        $element->add_responsive_control('la_transform_fx_rotate_z_hover', [
            'label' => __('Rotate (Z)', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => -180,
                    'max' => 180,
                ]
            ],
            'condition' => [
                'la_transform_fx_rotate_toggle_hover' => 'yes',
                'la_transform_fx' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-rotate-z-hover: {{SIZE}}deg;'
            ],
        ]);
        $element->end_popover();
        $element->add_control('la_transform_fx_scale_toggle_hover', [
            'label' => __('Scale', 'novaworks'),
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'return_value' => 'yes',
            'condition' => [
                'la_transform_fx' => 'yes',
            ],
        ]);
        $element->start_popover();
        $element->add_control('la_transform_fx_scale_mode_hover', [
            'label' => __('Mode', 'novaworks'),
            'type' => \Elementor\Controls_Manager::CHOOSE,
            'options' => [
                'compact' => [
                    'title' => __('Compact', 'novaworks'),
                    'icon' => 'eicon-plus-circle',
                ],
                'loose' => [
                    'title' => __('Loose', 'novaworks'),
                    'icon' => 'eicon-minus-circle',
                ],
            ],
            'default' => 'loose',
            'toggle' => false
        ]);
        $element->add_control('la_transform_fx_scale_hr_hover', [
            'type' => \Elementor\Controls_Manager::DIVIDER,
        ]);
        $element->add_responsive_control('la_transform_fx_scale_x_hover', [
            'label' => __('Scale (X)', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'default' => [
                'size' => 1
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => .1
                ]
            ],
            'condition' => [
                'la_transform_fx_scale_toggle_hover' => 'yes',
                'la_transform_fx' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-scale-x-hover: {{SIZE}}; --la-tfx-scale-y-hover: {{SIZE}};'
            ],
        ]);
        $element->add_responsive_control('la_transform_fx_scale_y_hover', [
            'label' => __('Scale Y', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['px'],
            'default' => [
                'size' => 1
            ],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 5,
                    'step' => .1
                ]
            ],
            'condition' => [
                'la_transform_fx_scale_toggle_hover' => 'yes',
                'la_transform_fx' => 'yes',
                'la_transform_fx_scale_mode_hover' => 'loose',
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-scale-y-hover: {{SIZE}};'
            ],
        ]);
        $element->end_popover();
        $element->add_control('la_transform_fx_skew_toggle_hover', [
            'label' => __('Skew', 'novaworks'),
            'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
            'return_value' => 'yes',
            'condition' => [
                'la_transform_fx' => 'yes',
            ],
        ]);
        $element->start_popover();
        $element->add_responsive_control('la_transform_fx_skew_x_hover', [
            'label' => __('Skew X', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['deg'],
            'range' => [
                'px' => [
                    'min' => -180,
                    'max' => 180,
                ]
            ],
            'condition' => [
                'la_transform_fx_skew_toggle_hover' => 'yes',
                'la_transform_fx' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-skew-x-hover: {{SIZE}}deg;'
            ],
        ]);
        $element->add_responsive_control('la_transform_fx_skew_y_hover', [
            'label' => __('Skew Y', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'size_units' => ['deg'],
            'range' => [
                'px' => [
                    'min' => -180,
                    'max' => 180,
                ]
            ],
            'condition' => [
                'la_transform_fx_skew_toggle_hover' => 'yes',
                'la_transform_fx' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-skew-y-hover: {{SIZE}}deg;'
            ],
        ]);
        $element->end_popover();
        $element->add_control('la_transform_fx_transition_duration', [
            'label' => __('Transition Duration', 'novaworks'),
            'type' => \Elementor\Controls_Manager::SLIDER,
            'separator' => 'before',
            'size_units' => ['px'],
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 3,
                    'step' => .1,
                ]
            ],
            'condition' => [
                'la_transform_fx' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--la-tfx-transition-duration: {{SIZE}}s;'
            ],
        ]);
        $element->end_controls_tab();
        $element->end_controls_tabs();
        $element->end_controls_section();
    }
});
