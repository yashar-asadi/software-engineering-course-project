<?php

namespace Novaworks_Element\Widgets;

if (!defined('WPINC')) {
    die;
}


use Novaworks_Element\Controls\Group_Control_Box_Style;

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Modules\DynamicTags\Module as TagsModule;

/**
 * Advanced_Carousel Widget
 */
class Advanced_Carousel extends NOVA_Widget_Base {

    public function get_style_depends() {
        return [
            'novaworks-banner-elm',
            'novaworks-advanced-carousel-elm'
        ];
    }

    public function get_name() {
        return 'novaworks-advanced-carousel';
    }

    protected function get_widget_title() {
        return esc_html__( 'Advanced Carousel', 'novaworks');
    }

    public function get_icon() {
        return 'nova-elements-icon-1';
    }
    /**
     * [$item_counter description]
     * @var integer
     */
    public $item_counter = 0;

    protected function _register_controls() {

        $this->start_controls_section(
            'section_slides',
            array(
                'label' => esc_html__( 'Slides', 'novaworks'),
            )
        );

        $this->add_control(
            'item_layout',
            array(
                'label'   => esc_html__( 'Items Layout', 'novaworks'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'simple',
                'options' => array(
                    'banners'=> esc_html__( 'Banners', 'novaworks'),
                    'simple' => esc_html__( 'Simple', 'novaworks'),
                    'brand' => esc_html__( 'Brand', 'novaworks')
                )
            )
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_image',
            array(
                'label'   => esc_html__( 'Image', 'novaworks'),
                'type'    => Controls_Manager::MEDIA,
                'default' => array(
                    'url' => Utils::get_placeholder_image_src(),
                ),
                'dynamic' => array( 'active' => true ),
            )
        );

        $repeater->add_control(
            'item_title',
            array(
                'label'   => esc_html__( 'Item Title', 'novaworks'),
                'type'    => Controls_Manager::TEXT,
                'dynamic' => array( 'active' => true ),
            )
        );

        $repeater->add_control(
            'item_text',
            array(
                'label'   => esc_html__( 'Item Description', 'novaworks'),
                'type'    => Controls_Manager::TEXTAREA,
                'dynamic' => array( 'active' => true ),
            )
        );
        $repeater->add_control(
            'item_link_type',
            array(
                'label'   => esc_html__( 'Link type', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'lightbox',
                'options' => array(
                    'lightbox' => esc_html__( 'Lightbox', 'novaworks' ),
                    'external' => esc_html__( 'External', 'novaworks' ),
                ),
            )
        );

        $repeater->add_control(
            'item_link',
            array(
                'label'   => esc_html__( 'Item Link', 'novaworks'),
                'type'    => Controls_Manager::TEXT,
                'condition' => array(
                    'item_link_type' => 'external',
                ),
                'dynamic' => array(
                    'active' => true,
                    'categories' => array(
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY,
                    ),
                ),
            )
        );

        $repeater->add_control(
            'item_link_target',
            array(
                'label'        => esc_html__( 'Open link in new window', 'novaworks'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => '_blank',
                'condition' => array(
                    'item_link_type' => 'external',
                ),
            )
        );

        $repeater->add_control(
            'item_button_text',
            array(
                'label'   => esc_html__( 'Item Button Text', 'novaworks'),
                'type'    => Controls_Manager::TEXT,
                'default' => '',
                'condition' => array(
                    'item_link_type' => 'external',
                ),
            )
        );

        $repeater->add_control(
            'item_css_class',
            array(
                'label'   => esc_html__( 'Item CSS Class', 'novaworks'),
                'type'    => Controls_Manager::TEXT,
                'default' => '',
            )
        );

        $this->add_control(
            'items_list',
            array(
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => array(
                    array(
                        'item_image' => array(
                            'url' => Utils::get_placeholder_image_src(),
                        ),
                        'item_title' => esc_html__( 'Item #1', 'novaworks'),
                        'item_text'  => esc_html__( 'Item #1 Description', 'novaworks'),
                        'item_link'  => '#',
                        'item_link_target'  => '',
                    ),
                ),
                'title_field' => '{{{ item_title }}}',
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            array(
                'label' => esc_html__( 'Settings', 'novaworks'),
            )
        );

        $hover_effect = apply_filters(
            'NovaworksElement/banner/hover_effect',
            array(
                'none'   => esc_html__( 'None', 'novaworks' ),
                'lily'   => esc_html__( 'Lily', 'novaworks' ),
                'sadie'  => esc_html__( 'Sadie', 'novaworks' ),
                'layla'  => esc_html__( 'Layla', 'novaworks' ),
                'oscar'  => esc_html__( 'Oscar', 'novaworks' ),
                'marley' => esc_html__( 'Marley', 'novaworks' ),
                'ruby'   => esc_html__( 'Ruby', 'novaworks' ),
                'roxy'   => esc_html__( 'Roxy', 'novaworks' ),
                'bubba'  => esc_html__( 'Bubba', 'novaworks' ),
                'romeo'  => esc_html__( 'Romeo', 'novaworks' ),
                'sarah'  => esc_html__( 'Sarah', 'novaworks' ),
                'chico'  => esc_html__( 'Chico', 'novaworks' )
            )
        );

        $this->add_control(
            'animation_effect',
            array(
                'label'   => esc_html__( 'Animation Effect', 'novaworks'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => $hover_effect,
                'condition' => array(
                    'item_layout' => 'banners',
                ),
            )
        );

        $this->add_control(
            'img_size',
            array(
                'type'       => 'select',
                'label'      => esc_html__( 'Images Size', 'novaworks'),
                'default'    => 'full',
                'options'    => nova_get_all_image_sizes(),
                'condition' => array(
                    'item_layout!' => 'icon',
                ),
            )
        );

        $this->add_control(
            'equal_height_cols',
            array(
                'label'        => esc_html__( 'Equal Columns Height', 'novaworks'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks'),
                'label_off'    => esc_html__( 'No', 'novaworks'),
                'return_value' => 'true',
                'default'      => '',
            )
        );

	    $this->add_control(
		    'custom_banner_height',
		    array(
			    'label'        => esc_html__( 'Enable Custom Image Height', 'novaworks' ),
			    'type'         => Controls_Manager::SWITCHER,
			    'label_on'     => esc_html__( 'Yes', 'novaworks' ),
			    'label_off'    => esc_html__( 'No', 'novaworks' ),
			    'return_value' => 'true',
			    'default'      => '',
			    'condition' => array(
				    'item_layout' => 'banners',
			    ),
		    )
	    );

	    $this->add_responsive_control(
		    'img_height',
		    array(
			    'label' => esc_html__( 'Image Height', 'novaworks' ),
			    'type'  => Controls_Manager::SLIDER,
			    'range' => array(
				    'px' => array(
					    'min' => 100,
					    'max' => 1000,
				    ),
				    '%' => [
					    'min' => 0,
					    'max' => 200,
				    ],
				    'vh' => array(
					    'min' => 0,
					    'max' => 100,
				    )
			    ),
			    'size_units' => ['px', '%', 'vh'],
			    'default' => [
				    'size' => 300,
				    'unit' => 'px'
			    ],
			    'selectors' => array(
				    '{{WRAPPER}} .novaworks-banner' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				    '{{WRAPPER}} .novaworks-banner img' => 'position: absolute; width: 100%; height: 100%; left: 0; top: 0; object-fit: cover'
			    ),
			    'render_type' => 'template',
			    'condition' => [
				    'custom_banner_height!' => ''
			    ]
		    )
	    );

        $this->add_control(
            'fluid_width',
            array(
                'label'        => esc_html__( 'Fluid Columns Width', 'novaworks'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks'),
                'label_off'    => esc_html__( 'No', 'novaworks'),
                'return_value' => 'true',
                'default'      => '',
            )
        );

        $this->add_responsive_control(
            'slides_to_show',
            array(
                'label'   => esc_html__( 'Slides to Show', 'novaworks'),
                'type'    => Controls_Manager::SELECT,
                'default' => '2',
                'options' => novaworks_elementor_tools_get_select_range(10)
            )
        );

        $this->add_control(
            'slides_to_scroll',
            array(
                'label'     => esc_html__( 'Slides to Scroll', 'novaworks'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '1',
                'options' => novaworks_elementor_tools_get_select_range(10),
                'condition' => array(
                    'slides_to_show!' => '1',
                ),
            )
        );

        $this->add_control(
            'arrows',
            array(
                'label'        => esc_html__( 'Show Arrows Navigation', 'novaworks'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks'),
                'label_off'    => esc_html__( 'No', 'novaworks'),
                'return_value' => 'true',
                'default'      => 'true',
            )
        );

        $this->add_control(
            'arrow_style',
            array(
                'label'   => esc_html__( 'Arrow Style', 'novaworks'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => novaworks_elementor_tools_get_arrows_style(),
                'condition' => array(
                    'arrows' => 'true'
                )
            )
        );

        $this->add_control(
            'prev_arrow',
            array(
                'label'   => esc_html__( 'Prev Arrow Icon', 'novaworks'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'novaworksicon-left-arrow',
                'options' => novaworks_elementor_tools_get_nextprev_arrows_list('prev'),
                'condition' => array(
                    'arrows' => 'true'
                )
            )
        );

        $this->add_control(
            'next_arrow',
            array(
                'label'   => esc_html__( 'Next Arrow Icon', 'novaworks'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'novaworksicon-right-arrow',
                'options' => novaworks_elementor_tools_get_nextprev_arrows_list('next'),
                'condition' => array(
                    'arrows' => 'true'
                )
            )
        );

        $this->add_control(
            'dots',
            array(
                'label'        => esc_html__( 'Show Dots Navigation', 'novaworks'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks'),
                'label_off'    => esc_html__( 'No', 'novaworks'),
                'return_value' => 'true',
                'default'      => '',
            )
        );

        $this->add_control(
            'center_mode',
            array(
                'label'        => esc_html__( 'Center Mode', 'novaworks'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks'),
                'label_off'    => esc_html__( 'No', 'novaworks'),
                'return_value' => 'yes',
                'default'      => ''
            )
        );

        $this->add_responsive_control(
            'center_mode_gap_left',
            array(
                'label' => esc_html__( 'Padding Left', 'novaworks'),
                'type'  => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                    ),
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'vw' => array(
                        'min' => 0,
                        'max' => 50,
                    )
                ),
                'size_units' => ['px', '%', 'vw'],
                'selectors' => array(
                    '{{WRAPPER}} .slick-list' => 'padding-left: {{SIZE}}{{UNIT}} !important;',
                )
            )
        );

        $this->add_responsive_control(
            'center_mode_gap_right',
            array(
                'label' => esc_html__( 'Padding Right', 'novaworks'),
                'type'  => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                    ),
                    '%' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'vw' => array(
                        'min' => 0,
                        'max' => 50,
                    )
                ),
                'size_units' => ['px', '%', 'vw'],
                'selectors' => array(
                    '{{WRAPPER}} .slick-list' => 'padding-right: {{SIZE}}{{UNIT}} !important;',
                )
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_additional_options',
            array(
                'label' => esc_html__( 'Additional Options', 'novaworks'),
            )
        );

        $this->add_control(
            'pause_on_hover',
            array(
                'label'        => esc_html__( 'Pause on Hover', 'novaworks'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks'),
                'label_off'    => esc_html__( 'No', 'novaworks'),
                'return_value' => 'true',
                'default'      => '',
            )
        );

        $this->add_control(
            'autoplay',
            array(
                'label'        => esc_html__( 'Autoplay', 'novaworks'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks'),
                'label_off'    => esc_html__( 'No', 'novaworks'),
                'return_value' => 'true',
                'default'      => 'true',
            )
        );

        $this->add_control(
            'autoplay_speed',
            array(
                'label'     => esc_html__( 'Autoplay Speed', 'novaworks'),
                'type'      => Controls_Manager::NUMBER,
                'default'   => 5000,
                'condition' => array(
                    'autoplay' => 'true',
                ),
            )
        );

        $this->add_control(
            'infinite',
            array(
                'label'        => esc_html__( 'Infinite Loop', 'novaworks'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks'),
                'label_off'    => esc_html__( 'No', 'novaworks'),
                'return_value' => 'true',
                'default'      => 'true',
            )
        );

        $this->add_control(
            'effect',
            array(
                'label'   => esc_html__( 'Effect', 'novaworks'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => array(
                    'slide' => esc_html__( 'Slide', 'novaworks'),
                    'fade'  => esc_html__( 'Fade', 'novaworks'),
                ),
                'condition' => array(
                    'slides_to_show' => '1',
                ),
            )
        );

        $this->add_control(
            'speed',
            array(
                'label'   => esc_html__( 'Animation Speed', 'novaworks'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 500,
            )
        );

        $this->end_controls_section();

        $css_scheme = apply_filters(
            'NovaworksElement/advanced-carousel/css-scheme',
            array(
                'arrow_next'     => '.novaworks-carousel .slick-next:before',
                'arrow_prev'     => '.novaworks-carousel .slick-prev:before',
                'arrow_next_hov' => '.novaworks-carousel .slick-next:hover:before',
                'arrow_prev_hov' => '.novaworks-carousel .slick-prev:hover:before',
                'dot'            => '.novaworks-carousel .slick-dots li button:before',
                'dot_hover'      => '.novaworks-carousel .slick-dots li button:hover:before',
                'dot_active'     => '.novaworks-carousel .slick-dots .slick-active button:before',
                'wrap'           => '.novaworks-carousel',
                'column'         => '.novaworks-carousel .novaworks-carousel__item',
                'image'          => '.novaworks-carousel__item-img',
                'items'          => '.novaworks-carousel__content',
                'items_title'    => '.novaworks-carousel__content .novaworks-carousel__item-title',
                'items_text'     => '.novaworks-carousel__content .novaworks-carousel__item-text',
                'items_button'   => '.novaworks-carousel__item-button',
                'banner'         => '.novaworks-banner',
                'banner_content' => '.novaworks-banner__content',
                'banner_overlay' => '.novaworks-banner__overlay',
                'banner_title'   => '.novaworks-banner__title',
                'banner_text'    => '.novaworks-banner__text',
                'icon_wrap'      => '.novaworks-carousel__icon',
                'icon'           => '.novaworks-carousel__icon > *'
            )
        );

        $this->start_controls_section(
            'section_column_style',
            array(
                'label'      => esc_html__( 'Column', 'novaworks'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_responsive_control(
            'column_padding',
            array(
                'label'       => esc_html__( 'Column Padding', 'novaworks'),
                'type'        => Controls_Manager::DIMENSIONS,
                'size_units'  => array( 'px' ),
                'render_type' => 'template',
                'selectors'   => array(
                    '{{WRAPPER}} ' . $css_scheme['column'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['wrap'] => 'margin-right: -{{RIGHT}}{{UNIT}}; margin-left: -{{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'column_margin',
            array(
                'label'       => esc_html__( 'Column Margin', 'novaworks'),
                'type'        => Controls_Manager::DIMENSIONS,
                'size_units'  => array( 'px' ),
                'selectors'   => array(
                    '{{WRAPPER}} ' . $css_scheme['column'] . ' .novaworks-carousel__item-inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'column_border',
                'label'       => esc_html__( 'Border', 'novaworks'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['column'] . ' .novaworks-carousel__item-inner',
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_brand_item_style',
            array(
                'label'      => esc_html__( 'Brand Items', 'novaworks'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
                'condition'  => array(
                    'item_layout' => 'brand',
                ),
            )
        );
        $this->add_responsive_control(
            'item_image_height',
            array(
                'label'      => esc_html__( 'Height', 'novaworks'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em', '%',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['image'] => 'height: {{SIZE}}{{UNIT}};',
                ),
            )
        );
        $this->add_control(
          'hover_animation',
          array(
            'label' => __( 'Hover Animation', 'novaworks' ),
            'type' => Controls_Manager::HOVER_ANIMATION,
          )
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_simple_item_style',
            array(
                'label'      => esc_html__( 'Simple Items', 'novaworks'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
                'condition'  => array(
                    'item_layout' => 'simple',
                ),
            )
        );

        $this->start_controls_tabs( 'tabs_box_item_style' );

        $this->start_controls_tab(
            'tab_box_item_normal',
            array(
                'label' => esc_html__( 'Normal', 'novaworks'),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'simple_box_item_bg',
                'selector' => '{{WRAPPER}} .novaworks-carousel__item-inner',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'box_item_border',
                'label'       => esc_html__( 'Border', 'novaworks'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .novaworks-carousel__item-inner',
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'box_item_box_shadow',
                'selector' => '{{WRAPPER}} .novaworks-carousel__item-inner',
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_box_item_hover',
            array(
                'label' => esc_html__( 'Hover', 'novaworks'),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'simple_box_item_bg_hover',
                'selector' => '{{WRAPPER}} .novaworks-carousel__item:hover .novaworks-carousel__item-inner',
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'box_item_border_hover',
                'label'       => esc_html__( 'Border', 'novaworks'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .novaworks-carousel__item:hover .novaworks-carousel__item-inner',
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'box_item_box_shadow_hover',
                'selector' => '{{WRAPPER}} .novaworks-carousel__item:hover .novaworks-carousel__item-inner',
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'item_column_padding',
            array(
                'label'       => esc_html__( 'Item Padding', 'novaworks'),
                'type'        => Controls_Manager::DIMENSIONS,
                'size_units'  => array( 'px' ),
                'render_type' => 'template',
                'selectors'   => array(
                    '{{WRAPPER}} ' . $css_scheme['column'] . ' .novaworks-carousel__item-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'condition'  => array(
                    'item_layout' => 'simple',
                )
            )
        );

        $this->add_control(
            'item_image_heading',
            array(
                'label' => esc_html__( 'Image', 'novaworks'),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'item_image_width',
            array(
                'label'      => esc_html__( 'Width', 'novaworks'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em', '%',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['image'] => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );


        $this->add_responsive_control(
            'item_image_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'novaworks'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['image'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'item_image_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['image'],
            )
        );

        $this->add_control(
            'item_content_heading',
            array(
                'label'     => esc_html__( 'Content', 'novaworks'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->start_controls_tabs( 'tabs_item_style' );

        $this->start_controls_tab(
            'tab_item_normal',
            array(
                'label' => esc_html__( 'Normal', 'novaworks'),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'simple_item_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['items'],
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'item_border',
                'label'       => esc_html__( 'Border', 'novaworks'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['items'],
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'item_bs',
                'selector' => '{{WRAPPER}} ' . $css_scheme['items'],
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_item_hover',
            array(
                'label' => esc_html__( 'Hover', 'novaworks'),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'simple_item_bg_hover',
                'selector' => '{{WRAPPER}} .novaworks-carousel__item:hover ' . $css_scheme['items'],
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'item_border_hover',
                'label'       => esc_html__( 'Border', 'novaworks'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .novaworks-carousel__item:hover ' . $css_scheme['items'],
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'item_bsh',
                'selector' => '{{WRAPPER}} .novaworks-carousel__item:hover ' . $css_scheme['items'],
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'items_padding',
            array(
                'label'      => esc_html__( 'Padding', 'novaworks'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'items_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'novaworks'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'items_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks'),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'left',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'novaworks'),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'novaworks'),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'novaworks'),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items'] => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_banner_item_style',
            array(
                'label'      => esc_html__( 'Banner Items', 'novaworks'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
                'condition'  => array(
                    'item_layout' => 'banners',
                ),
            )
        );

        $this->start_controls_tabs( 'tabs_background' );

        $this->start_controls_tab(
            'tab_background_normal',
            array(
                'label' => esc_html__( 'Normal', 'novaworks'),
            )
        );

        $this->add_control(
            'items_content_color',
            array(
                'label'     => esc_html__( 'Additional Elements Color', 'novaworks'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .novaworks-effect-layla ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-layla ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-oscar ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-marley ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-ruby ' . $css_scheme['banner_text'] => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-roxy ' . $css_scheme['banner_text'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-roxy ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-bubba ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-bubba ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-romeo ' . $css_scheme['banner_content'] . '::before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-romeo ' . $css_scheme['banner_content'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-sarah ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-chico ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                ),
            )
        );

	    $this->add_control(
		    'bg_n',
		    array(
			    'label'     => esc_html__( 'Overlay Background Color', 'novaworks' ),
			    'type'      => Controls_Manager::COLOR,
			    'selectors' => array(
				    '{{WRAPPER}} ' . $css_scheme['banner_overlay'] => 'background-color: {{VALUE}};',
			    )
		    )
	    );

        $this->add_control(
            'normal_opacity',
            array(
                'label'   => esc_html__( 'Opacity', 'novaworks'),
                'type'    => Controls_Manager::NUMBER,
                'default' => '0',
                'min'     => 0,
                'max'     => 1,
                'step'    => 0.1,
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner_overlay'] => 'opacity: {{VALUE}};',
                ),
            )
        );

	    $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    array(
			    'name'     => 'bbs',
			    'selector' => '{{WRAPPER}} ' . $css_scheme['banner']
		    )
	    );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_background_hover',
            array(
                'label' => esc_html__( 'Hover', 'novaworks'),
            )
        );

        $this->add_control(
            'items_content_hover_color',
            array(
                'label'     => esc_html__( 'Additional Elements Color', 'novaworks'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .novaworks-effect-layla:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-layla:hover ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-oscar:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-marley:hover ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-ruby:hover ' . $css_scheme['banner_text'] => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-roxy:hover ' . $css_scheme['banner_text'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-roxy:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-bubba:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-bubba:hover ' . $css_scheme['banner_content'] . '::after' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-romeo:hover ' . $css_scheme['banner_content'] . '::before' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-romeo:hover ' . $css_scheme['banner_content'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-sarah:hover ' . $css_scheme['banner_title'] . '::after' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-effect-chico:hover ' . $css_scheme['banner_content'] . '::before' => 'border-color: {{VALUE}}',
                ),
            )
        );

	    $this->add_control(
		    'bg_h',
		    array(
			    'label'     => esc_html__( 'Overlay Background Color', 'novaworks' ),
			    'type'      => Controls_Manager::COLOR,
			    'selectors' => array(
				    '{{WRAPPER}} ' .$css_scheme['banner'] . ':hover ' . $css_scheme['banner_overlay'] => 'background-color: {{VALUE}};'
			    )
		    )
	    );

        $this->add_control(
            'hover_opacity',
            array(
                'label'   => esc_html__( 'Opacity', 'novaworks'),
                'type'    => Controls_Manager::NUMBER,
                'default' => '0.2',
                'min'     => 0,
                'max'     => 1,
                'step'    => 0.1,
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['banner'] . ':hover ' . $css_scheme['banner_overlay'] => 'opacity: {{VALUE}};',
                ),
            )
        );
	    $this->add_group_control(
		    Group_Control_Box_Shadow::get_type(),
		    array(
			    'name'     => 'bbsh',
			    'selector' => '{{WRAPPER}} ' . $css_scheme['banner'] . ':hover'
		    )
	    );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'b_w',
            array(
                'label'      => esc_html__( 'Content Width', 'novaworks' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em', '%',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .novaworks-banner__content-wrap' => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

	    $this->add_responsive_control(
		    'b_m',
		    array(
			    'label'      => esc_html__( 'Margin', 'novaworks'),
			    'type'       => Controls_Manager::DIMENSIONS,
			    'size_units' => array( 'px', '%', 'em' ),
			    'separator'  => 'before',
			    'selectors'  => array(
				    '{{WRAPPER}} .novaworks-banner__content-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
			    ),
		    )
	    );

	    $this->add_responsive_control(
		    'b_p',
		    array(
			    'label'      => esc_html__( 'Padding', 'novaworks'),
			    'type'       => Controls_Manager::DIMENSIONS,
			    'size_units' => array( 'px', '%', 'em' ),
			    'separator'  => 'before',
			    'selectors'  => array(
				    '{{WRAPPER}} .novaworks-banner__content-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
			    ),
		    )
	    );

        $this->add_control(
            'ha',
            array(
                'label'   => esc_html__( 'Horizontal Alignment', 'novaworks' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'flex-start'    => array(
                        'title' => esc_html__( 'Left', 'novaworks' ),
                        'icon'  => 'eicon-arrow-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'novaworks' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'Right', 'novaworks' ),
                        'icon'  => 'eicon-arrow-right',
                    )
                ),
                'selectors'  => array(
                    '{{WRAPPER}} '. $css_scheme['banner_content'] => 'justify-content: {{VALUE}};',
                ),
                'condition' => array(
                    'animation_effect' => 'none'
                )
            )
        );

        $this->add_control(
            'va',
            array(
                'label'   => esc_html__( 'Vertical Alignment', 'novaworks' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'flex-start'    => array(
                        'title' => esc_html__( 'Start', 'novaworks' ),
                        'icon'  => 'eicon-v-align-top',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'novaworks' ),
                        'icon'  => 'eicon-v-align-middle',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'End', 'novaworks' ),
                        'icon'  => 'eicon-v-align-bottom',
                    )
                ),
                'selectors'  => array(
                    '{{WRAPPER}} '. $css_scheme['banner_content'] => 'align-items: {{VALUE}};',
                ),
                'condition' => array(
                    'animation_effect' => 'none'
                )
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_item_title_style',
            array(
                'label'      => esc_html__( 'Items Title Typography', 'novaworks'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->start_controls_tabs( 'tabs_title_style' );

        $this->start_controls_tab(
            'tab_title_normal',
            array(
                'label' => esc_html__( 'Normal', 'novaworks'),
            )
        );

        $this->add_control(
            'items_title_color',
            array(
                'label'     => esc_html__( 'Items Title Color', 'novaworks'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['items_title'] => 'color: {{VALUE}}',
                    '{{WRAPPER}} ' . $css_scheme['banner_title'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'items_title_bgc',
            array(
                'label'     => esc_html__( 'Items Background Color', 'novaworks'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['items_title'] => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} ' . $css_scheme['banner_title'] => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            array(
                'label' => esc_html__( 'Hover', 'novaworks'),
            )
        );

        $this->add_control(
            'items_title_color_hover',
            array(
                'label'     => esc_html__( 'Items Title Color', 'novaworks'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .novaworks-carousel__item:hover ' . $css_scheme['items_title'] => 'color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-carousel__item:hover ' . $css_scheme['banner_title'] => 'color: {{VALUE}}',
                ),
            )
        );
        $this->add_control(
            'items_title_bgc_hover',
            array(
                'label'     => esc_html__( 'Items Background Color', 'novaworks'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .novaworks-carousel__item:hover ' . $css_scheme['items_title'] => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-carousel__item:hover ' . $css_scheme['banner_title'] => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'items_title_typography',
                'selector' => '{{WRAPPER}}  ' . $css_scheme['items_title'] . ', {{WRAPPER}} ' . $css_scheme['banner_title'],
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'items_title_margin',
            array(
                'label'      => esc_html__( 'Margin', 'novaworks'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'separator'  => 'before',
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items_title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['banner_title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'items_tpd',
            array(
                'label'      => esc_html__( 'Padding', 'novaworks'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'separator'  => 'before',
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items_title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['banner_title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                )
            )
        );

        $this->add_responsive_control(
            'title_a',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'novaworks' ),
                        'icon'  => 'eicon-arrow-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'novaworks' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'novaworks' ),
                        'icon'  => 'eicon-arrow-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items_title'] => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} ' . $css_scheme['banner_title'] => 'text-align: {{VALUE}};'
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_item_text_style',
            array(
                'label'      => esc_html__( 'Items Content Typography', 'novaworks'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->start_controls_tabs( 'tabs_text_style' );

        $this->start_controls_tab(
            'tab_text_normal',
            array(
                'label' => esc_html__( 'Normal', 'novaworks'),
            )
        );

        $this->add_control(
            'items_text_color',
            array(
                'label'     => esc_html__( 'Items Content Color', 'novaworks'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['items_text'] => 'color: {{VALUE}}',
                    '{{WRAPPER}} ' . $css_scheme['banner_text'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'items_text_bgc',
            array(
                'label'     => esc_html__( 'Items Content Background Color', 'novaworks'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['items_text'] => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} ' . $css_scheme['banner_text'] => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_text_hover',
            array(
                'label' => esc_html__( 'Hover', 'novaworks'),
            )
        );

        $this->add_control(
            'items_text_color_hover',
            array(
                'label'     => esc_html__( 'Items Content Color', 'novaworks'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .novaworks-carousel__item:hover ' . $css_scheme['items_text'] => 'color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-carousel__item:hover ' . $css_scheme['banner_text'] => 'color: {{VALUE}}',
                ),
            )
        );
        $this->add_control(
            'items_text_bgc_hover',
            array(
                'label'     => esc_html__( 'Items Content Background Color', 'novaworks'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .novaworks-carousel__item:hover ' . $css_scheme['items_text'] => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-carousel__item:hover ' . $css_scheme['banner_text'] => 'background-color: {{VALUE}}',
                )
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'items_text_typography',
                'selector' => '{{WRAPPER}}  ' . $css_scheme['items_text'] . ', {{WRAPPER}} ' . $css_scheme['banner_text'],
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'items_text_margin',
            array(
                'label'      => esc_html__( 'Margin', 'novaworks'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'separator'  => 'before',
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items_text'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['banner_text'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'text_a',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'novaworks' ),
                        'icon'  => 'eicon-arrow-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'novaworks' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'novaworks' ),
                        'icon'  => 'eicon-arrow-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items_text'] => 'text-align: {{VALUE}};',
                    '{{WRAPPER}} ' . $css_scheme['banner_text'] => 'text-align: {{VALUE}};'
                )
            )
        );

        $this->end_controls_section();

        /**
         * Action Button Style Section
         */
        $this->start_controls_section(
            'section_action_button_style',
            array(
                'label'      => esc_html__( 'Action Button', 'novaworks'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
                'condition'  => array(
                    'item_layout!' => 'icon'
                ),
            )
        );

        $this->add_responsive_control(
            'btn_w',
            array(
                'label'      => esc_html__( 'Width', 'novaworks' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em', '%',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 1000,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button'] => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'btn_a',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => array(
                    'flex-start' => array(
                        'title' => esc_html__( 'Left', 'novaworks' ),
                        'icon'  => 'eicon-arrow-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'novaworks' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'Right', 'novaworks' ),
                        'icon'  => 'eicon-arrow-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button']  => 'align-self: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'button_typography',
                'selector' => '{{WRAPPER}}  ' . $css_scheme['items_button'],
            )
        );

        $this->add_responsive_control(
            'button_padding',
            array(
                'label'      => esc_html__( 'Padding', 'novaworks'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'button_margin',
            array(
                'label'      => __( 'Margin', 'novaworks'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'button_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'novaworks'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'after',
            )
        );

        $this->start_controls_tabs( 'tabs_button_style' );

        $this->start_controls_tab(
            'tab_button_normal',
            array(
                'label' => esc_html__( 'Normal', 'novaworks'),
            )
        );

        $this->add_control(
            'button_bg_color',
            array(
                'label' => esc_html__( 'Background Color', 'novaworks'),
                'type' => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button'] => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'button_color',
            array(
                'label'     => esc_html__( 'Text Color', 'novaworks'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'button_border',
                'label'       => esc_html__( 'Border', 'novaworks'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['items_button'],
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'button_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['items_button'],
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            array(
                'label' => esc_html__( 'Hover', 'novaworks'),
            )
        );

        $this->add_control(
            'primary_button_hover_bg_color',
            array(
                'label'     => esc_html__( 'Background Color', 'novaworks'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button'] . ':hover' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-banner:hover ' . $css_scheme['items_button'] => 'background-color: {{VALUE}}',
                ),
            )
        );

        $this->add_control(
            'button_hover_color',
            array(
                'label'     => esc_html__( 'Text Color', 'novaworks'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['items_button'] . ':hover' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .novaworks-banner:hover ' . $css_scheme['items_button'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'button_hover_border',
                'label'       => esc_html__( 'Border', 'novaworks'),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['items_button'] . ':hover, {{WRAPPER}} .novaworks-banner:hover ' . $css_scheme['items_button'],
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'button_hover_box_shadow',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['items_button'] . ':hover, {{WRAPPER}} .novaworks-banner:hover ' . $css_scheme['items_button'],
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'section_arrows_style',
            array(
                'label'      => esc_html__( 'Carousel Arrows', 'novaworks'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->start_controls_tabs( 'tabs_arrows_style' );

        $this->start_controls_tab(
            'tab_prev',
            array(
                'label' => esc_html__( 'Normal', 'novaworks'),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'arrows_style',
                'label'          => esc_html__( 'Arrows Style', 'novaworks'),
                'selector'       => '{{WRAPPER}} .novaworks-carousel .novaworks-arrow',
                'fields_options' => array(
                    'color' => array(
                    ),
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_next_hover',
            array(
                'label' => esc_html__( 'Hover', 'novaworks'),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'arrows_hover_style',
                'label'          => esc_html__( 'Arrows Style', 'novaworks'),
                'selector'       => '{{WRAPPER}} .novaworks-carousel .novaworks-arrow:hover',
                'fields_options' => array(
                    'color' => array(
                    ),
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'prev_arrow_position',
            array(
                'label'     => esc_html__( 'Prev Arrow Position', 'novaworks'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'prev_vert_position',
            array(
                'label'   => esc_html__( 'Vertical Position by', 'novaworks'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'top',
                'options' => array(
                    'top'    => esc_html__( 'Top', 'novaworks'),
                    'bottom' => esc_html__( 'Bottom', 'novaworks'),
                ),
            )
        );

        $this->add_responsive_control(
            'prev_top_position',
            array(
                'label'      => esc_html__( 'Top Indent', 'novaworks'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'prev_vert_position' => 'top',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .novaworks-carousel .novaworks-arrow.prev-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
                ),
            )
        );

        $this->add_responsive_control(
            'prev_bottom_position',
            array(
                'label'      => esc_html__( 'Bottom Indent', 'novaworks'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'prev_vert_position' => 'bottom',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .novaworks-carousel .novaworks-arrow.prev-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
                ),
            )
        );

        $this->add_control(
            'prev_hor_position',
            array(
                'label'   => esc_html__( 'Horizontal Position by', 'novaworks'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => array(
                    'left'  => esc_html__( 'Left', 'novaworks'),
                    'right' => esc_html__( 'Right', 'novaworks'),
                ),
            )
        );

        $this->add_responsive_control(
            'prev_left_position',
            array(
                'label'      => esc_html__( 'Left Indent', 'novaworks'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'prev_hor_position' => 'left',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .novaworks-carousel .novaworks-arrow.prev-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
                ),
            )
        );

        $this->add_responsive_control(
            'prev_right_position',
            array(
                'label'      => esc_html__( 'Right Indent', 'novaworks'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'prev_hor_position' => 'right',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .novaworks-carousel .novaworks-arrow.prev-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                ),
            )
        );

        $this->add_control(
            'next_arrow_position',
            array(
                'label'     => esc_html__( 'Next Arrow Position', 'novaworks'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'next_vert_position',
            array(
                'label'   => esc_html__( 'Vertical Position by', 'novaworks'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'top',
                'options' => array(
                    'top'    => esc_html__( 'Top', 'novaworks'),
                    'bottom' => esc_html__( 'Bottom', 'novaworks'),
                ),
            )
        );

        $this->add_responsive_control(
            'next_top_position',
            array(
                'label'      => esc_html__( 'Top Indent', 'novaworks'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'next_vert_position' => 'top',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .novaworks-carousel .novaworks-arrow.next-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
                ),
            )
        );

        $this->add_responsive_control(
            'next_bottom_position',
            array(
                'label'      => esc_html__( 'Bottom Indent', 'novaworks'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'next_vert_position' => 'bottom',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .novaworks-carousel .novaworks-arrow.next-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
                ),
            )
        );

        $this->add_control(
            'next_hor_position',
            array(
                'label'   => esc_html__( 'Horizontal Position by', 'novaworks'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => array(
                    'left'  => esc_html__( 'Left', 'novaworks'),
                    'right' => esc_html__( 'Right', 'novaworks'),
                ),
            )
        );

        $this->add_responsive_control(
            'next_left_position',
            array(
                'label'      => esc_html__( 'Left Indent', 'novaworks'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'next_hor_position' => 'left',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .novaworks-carousel .novaworks-arrow.next-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
                ),
            )
        );

        $this->add_responsive_control(
            'next_right_position',
            array(
                'label'      => esc_html__( 'Right Indent', 'novaworks'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => -400,
                        'max' => 400,
                    ),
                    '%' => array(
                        'min' => -100,
                        'max' => 100,
                    ),
                    'em' => array(
                        'min' => -50,
                        'max' => 50,
                    ),
                ),
                'condition' => array(
                    'next_hor_position' => 'right',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .novaworks-carousel .novaworks-arrow.next-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_dots_style',
            array(
                'label'      => esc_html__( 'Carousel Dots', 'novaworks'),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->start_controls_tabs( 'tabs_dots_style' );

        $this->start_controls_tab(
            'tab_dots_normal',
            array(
                'label' => esc_html__( 'Normal', 'novaworks'),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'dots_style',
                'label'          => esc_html__( 'Dots Style', 'novaworks'),
                'selector'       => '{{WRAPPER}} .novaworks-carousel .novaworks-slick-dots li span',
                'exclude' => array(
                    'box_font_color',
                    'box_font_size',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_dots_hover',
            array(
                'label' => esc_html__( 'Hover', 'novaworks'),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'dots_style_hover',
                'label'          => esc_html__( 'Dots Style', 'novaworks'),
                'selector'       => '{{WRAPPER}} .novaworks-carousel .novaworks-slick-dots li span:hover',
                'exclude' => array(
                    'box_font_color',
                    'box_font_size',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_dots_active',
            array(
                'label' => esc_html__( 'Active', 'novaworks'),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'dots_style_active',
                'label'          => esc_html__( 'Dots Style', 'novaworks'),
                'selector'       => '{{WRAPPER}} .novaworks-carousel .novaworks-slick-dots li.slick-active span',
                'exclude' => array(
                    'box_font_color',
                    'box_font_size',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'dots_gap',
            array(
                'label' => esc_html__( 'Gap', 'novaworks'),
                'type' => Controls_Manager::SLIDER,
                'default' => array(
                    'size' => 5,
                    'unit' => 'px',
                ),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .novaworks-carousel .novaworks-slick-dots li' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
                ),
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'dots_margin',
            array(
                'label'      => esc_html__( 'Dots Box Margin', 'novaworks'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} .novaworks-carousel .novaworks-slick-dots' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'dots_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks'),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'flex-start' => array(
                        'title' => esc_html__( 'Left', 'novaworks'),
                        'icon'  => 'eicon-h-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'novaworks'),
                        'icon'  => 'eicon-h-align-center',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'Right', 'novaworks'),
                        'icon'  => 'eicon-h-align-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} .novaworks-carousel .novaworks-slick-dots' => 'justify-content: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

    }

    protected function render() {

        $this->__context = 'render';

        $this->__open_wrap();
        include $this->__get_global_template( 'index' );
        $this->__close_wrap();
    }

    public function get_advanced_carousel_options() {

        $settings = $this->get_settings();

        $desktop_col = absint( $settings['slides_to_show'] );
        $laptop_col = absint( isset($settings['slides_to_show_laptop']) ? $settings['slides_to_show_laptop'] : 0 );
        $tablet_col = absint( $settings['slides_to_show_tablet'] );
        $tabletportrait_col = absint( isset($settings['slides_to_show_tabletportrait']) ? $settings['slides_to_show_tabletportrait'] : 0 );
        $mobile_col = absint( $settings['slides_to_show_mobile'] );

        if($laptop_col == 0){
            $laptop_col = $desktop_col;
        }
        if($tablet_col == 0){
            $tablet_col = $laptop_col;
        }
        if($tabletportrait_col == 0){
            $tabletportrait_col = $tablet_col;
        }

        if($mobile_col == 0){
            $mobile_col = 1;
        }

        $slidesToShow = array(
            'desktop'           => $desktop_col,
            'laptop'            => $laptop_col,
            'tablet'            => $tablet_col,
            'tabletportrait'    => $tabletportrait_col,
            'mobile'            => $mobile_col
        );

        $options  = array(
            'slidesToShow'   => $slidesToShow,
            'autoplaySpeed'  => absint( $settings['autoplay_speed'] ),
            'autoplay'       => filter_var( $settings['autoplay'], FILTER_VALIDATE_BOOLEAN ),
            'infinite'       => filter_var( $settings['infinite'], FILTER_VALIDATE_BOOLEAN ),
            'pauseOnHover'   => filter_var( $settings['pause_on_hover'], FILTER_VALIDATE_BOOLEAN ),
            'speed'          => absint( $settings['speed'] ),
            'arrows'         => filter_var( $settings['arrows'], FILTER_VALIDATE_BOOLEAN ),
            'dots'           => filter_var( $settings['dots'], FILTER_VALIDATE_BOOLEAN ),
            'slidesToScroll' => absint( $settings['slides_to_scroll'] ),
            'prevArrow'      => novaworks_elementor_tools_get_carousel_arrow( [ 'prev-arrow', 'slick-prev' ], [ $settings['prev_arrow'] ] ),
            'variableWidth'  => filter_var( $settings['fluid_width'], FILTER_VALIDATE_BOOLEAN ),
            'nextArrow'      => novaworks_elementor_tools_get_carousel_arrow( ['next-arrow', 'slick-next'], [ $settings['next_arrow'] ] ),
            'rtl'            => is_rtl()
        );
        if(isset($settings['center_mode']) && $settings['center_mode'] == 'yes'){
            $options['centerMode'] = true;
            $options['centerPadding'] = '200px';
        }
        if ( 1 === absint( $settings['slides_to_show'] ) ) {
            $options['fade'] = ( 'fade' === $settings['effect'] );
        }

        return $options;
    }

    public function get_advanced_carousel_img( $class = '' ) {

        $settings = $this->get_settings_for_display();
        $size     = isset( $settings['img_size'] ) ? $settings['img_size'] : 'full';
        $image    = isset( $this->__processed_item['item_image'] ) ? $this->__processed_item['item_image'] : '';

        if ( ! $image ) {
            return;
        }

        if ( 'full' !== $size && ! empty( $image['id'] ) ) {
            $url = wp_get_attachment_image_url( $image['id'], $size );
        }
        else {
            $url = $image['url'];
        }

        $url = apply_filters('novaworks_wp_get_attachment_image_url', $url);

        $giflazy = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';

        return sprintf( '<img src="%1$s" data-src="%1$s" alt="" class="nova-lazyload-image %2$s" srcset="%1$s">', $url, $class , $giflazy);

    }

    public function get_advanced_carousel_img_src(){
	    $settings = $this->get_settings_for_display();
	    $size     = isset( $settings['img_size'] ) ? $settings['img_size'] : 'full';
	    $image    = isset( $this->__processed_item['item_image'] ) ? $this->__processed_item['item_image'] : '';

	    if ( ! $image ) {
		    return;
	    }

	    if ( 'full' !== $size && ! empty( $image['id'] ) ) {
		    $url = wp_get_attachment_image_url( $image['id'], $size );
	    }
	    else {
		    $url = $image['url'];
	    }

	    return apply_filters('novaworks_wp_get_attachment_image_url', $url);
    }
    public function get_loop_image_item() {

        $settings = $this->get_settings_for_display();
        $image_data = $this->__loop_image_item('item_image', '', false);
        $class_animation = '';
        if ( ! empty( $settings['hover_animation'] ) ) {
          $class_animation = ' elementor-animation-' . $settings['hover_animation'];
        }
        if(!empty($image_data)){
            $giflazy = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';
            $srcset = sprintf('width="%d" height="%d" srcset="%s"', $image_data[1], $image_data[2], $giflazy);
            return sprintf( apply_filters('NovaworksElement/adv-images-layout/image-format', '<img src="%1$s" data-src="%2$s" alt="" class="nova-lazyload-image %3$s%4$s" %5$s>'), $giflazy, $image_data[0], 'novaworks-images-layout__image-instance novaworks-carousel__item-img', $class_animation , $srcset);
        }

        return '';
    }

    /**
     * Get loop image html
     *
     */
    protected function __loop_image_item( $key = '', $format = '%s', $html_return = true ) {
        $item = $this->__processed_item;
        $params = [];

        if ( ! array_key_exists( $key, $item ) ) {
            return false;
        }

        $image_item = $item[ $key ];

        if ( ! empty( $image_item['id'] ) ) {
            $image_data = wp_get_attachment_image_src( $image_item['id'], 'full' );

            $params[] = apply_filters('novaworks_wp_get_attachment_image_url', $image_data[0]);
            $params[] = $image_data[1];
            $params[] = $image_data[2];
        } else {
            $params[] = $image_item['url'];
            $params[] = 1200;
            $params[] = 800;
        }

        if($html_return){
            return vsprintf( $format, $params );
        }
        else{
            return $params;
        }
    }

    protected function __loop_button_item( $keys = array(), $format = '%s' ) {
        $item = $this->__processed_item;
        $params = [];

        foreach ( $keys as $key => $value ) {

            if ( ! array_key_exists( $value, $item ) ) {
                return false;
            }

            if ( empty( $item[$value] ) ) {
                return false;
            }

            $params[] = $item[ $value ];
        }

        return vsprintf( $format, $params );
    }
}
