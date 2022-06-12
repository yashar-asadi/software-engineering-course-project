<?php
namespace Novaworks_Element\Widgets;

if (!defined('WPINC')) {
    die;
}

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Novaworks_Element\Controls\Group_Control_Box_Style;

/**
 * Instagram_Gallery Widget
 */
class Instagram_Gallery extends NOVA_Widget_Base {

    /**
     * Request config
     *
     * @var array
     */
    public $config = array();

    public function get_name() {
        return 'novaworks-instagram-gallery';
    }

    protected function get_widget_title() {
        return esc_html__( 'Instagram', 'novaworks' );
    }

    public function get_icon() {
        return 'novaworkselements-icon-30';
    }

    public function get_style_depends() {
        return [
            'novaworks-instagram-gallery-elm'
        ];
    }

    protected function _register_controls() {

        $css_scheme = apply_filters(
            'NovaworksElement/instagram-gallery/css-scheme',
            array(
                'instance'       => '.novaworks-instagram-gallery__instance',
                'image_instance' => '.novaworks-instagram-gallery__image',
                'item'           => '.novaworks-instagram-gallery__item',
                'inner'          => '.novaworks-instagram-gallery__inner',
                'content'        => '.novaworks-instagram-gallery__content',
                'caption'        => '.novaworks-instagram-gallery__caption',
                'meta'           => '.novaworks-instagram-gallery__meta',
                'meta_item'      => '.novaworks-instagram-gallery__meta-item',
                'meta_icon'      => '.novaworks-instagram-gallery__meta-icon',
                'meta_label'     => '.novaworks-instagram-gallery__meta-label',
                'slick_list'       => '.novaworks-carousel .slick-list',
            )
        );

        $this->start_controls_section(
            'section_instagram_settings',
            array(
                'label' => esc_html__( 'Instagram Settings', 'novaworks' ),
            )
        );

        if(empty($this->get_token())){
            $this->add_control(
                'set_key',
                array(
                    'type' => Controls_Manager::RAW_HTML,
                    'raw'  => esc_html__( 'Please enter the Instagram Token on Appearance -> Customize -> API Key -> Instagram Access Token', 'novaworks' )
                )
            );
        }

        $this->add_control(
            'cache_timeout',
            array(
                'label'   => esc_html__( 'Cache Timeout', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'hour',
                'options' => array(
                    'none'   => esc_html__( 'None', 'novaworks' ),
                    'minute' => esc_html__( 'Minute', 'novaworks' ),
                    'hour'   => esc_html__( 'Hour', 'novaworks' ),
                    'day'    => esc_html__( 'Day', 'novaworks' ),
                    'week'   => esc_html__( 'Week', 'novaworks' ),
                )
            )
        );

        $this->add_control(
            'posts_counter',
            array(
                'label'   => esc_html__( 'Limit (Maximum display of 20 posts)', 'novaworks' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
                'min'     => 1,
                'max'     => 20,
                'step'    => 1,
            )
        );

        $this->add_control(
            'post_link',
            array(
                'label'        => esc_html__( 'Enable linking photos', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'post_caption',
            array(
                'label'        => esc_html__( 'Enable caption', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'yes'
            )
        );

        $this->add_control(
            'post_caption_length',
            array(
                'label'   => esc_html__( 'Caption length', 'novaworks' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 50,
                'min'     => 1,
                'max'     => 300,
                'step'    => 1,
                'condition' => array(
                    'post_caption' => 'yes'
                ),
            )
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            array(
                'label' => esc_html__( 'Layout Settings', 'novaworks' ),
            )
        );

        $this->add_control(
            'layout_type',
            array(
                'label'   => esc_html__( 'Layout type', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => array(
                    'grid'    => esc_html__( 'Grid', 'novaworks' )
                ),
            )
        );

        $this->add_responsive_control(
            'columns',
            array(
                'label'   => esc_html__( 'Columns', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 3,
                'options' => novaworks_elementor_tools_get_select_range( 6 ),
                'condition' => array(
                    'layout_type' => array( 'masonry', 'grid' ),
                ),
            )
        );

        $this->add_responsive_control(
            'image_height',
            array(
                'label' => esc_html__( 'Image Height', 'novaworks' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em', '%',
                ),
                'default' => [
                    'size'  => 100,
                    'unit' => '%'
                ],
                'selectors' => array(
                    '{{WRAPPER}} .novaworks-instagram-gallery__media' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();
        /**
         * Slick settings
         */
        $this->start_controls_section(
            'section_carousel',
            array(
                'label' => esc_html__( 'Carousel', 'novaworks' ),
                'condition' => array(
                    'layout_type' => array(
                        'grid',
                        'list'
                    )
                )
            )
        );

        $this->add_control(
            'carousel_enabled',
            array(
                'label'        => esc_html__( 'Enable Carousel', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => '',
            )
        );

        $this->add_control(
            'slides_to_scroll',
            array(
                'label'     => esc_html__( 'Slides to Scroll', 'novaworks' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => '1',
                'options'   => novaworks_elementor_tools_get_select_range( 6 ),
                'condition' => array(
                    'columns!' => '1',
                ),
            )
        );

        $this->add_control(
            'arrows',
            array(
                'label'        => esc_html__( 'Show Arrows Navigation', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'true',
                'default'      => 'true',
            )
        );

        $this->add_control(
            'prev_arrow',
            array(
                'label'   => esc_html__( 'Prev Arrow Icon', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'novaworksicon-left-arrow',
                'options' => novaworks_elementor_tools_get_nextprev_arrows_list('prev'),
                'condition' => array(
                    'arrows' => 'true',
                ),
            )
        );

        $this->add_control(
            'next_arrow',
            array(
                'label'   => esc_html__( 'Next Arrow Icon', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'novaworksicon-right-arrow',
                'options' => novaworks_elementor_tools_get_nextprev_arrows_list('next'),
                'condition' => array(
                    'arrows' => 'true',
                ),
            )
        );

        $this->add_control(
            'dots',
            array(
                'label'        => esc_html__( 'Show Dots Navigation', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'true',
                'default'      => '',
            )
        );

        $this->add_control(
            'pause_on_hover',
            array(
                'label'        => esc_html__( 'Pause on Hover', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'true',
                'default'      => '',
            )
        );

        $this->add_control(
            'autoplay',
            array(
                'label'        => esc_html__( 'Autoplay', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'true',
                'default'      => 'true',
            )
        );

        $this->add_control(
            'autoplay_speed',
            array(
                'label'     => esc_html__( 'Autoplay Speed', 'novaworks' ),
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
                'label'        => esc_html__( 'Infinite Loop', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'true',
                'default'      => 'true',
            )
        );

        $this->add_control(
            'effect',
            array(
                'label'   => esc_html__( 'Effect', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => array(
                    'slide' => esc_html__( 'Slide', 'novaworks' ),
                    'fade'  => esc_html__( 'Fade', 'novaworks' ),
                ),
                'condition' => array(
                    'columns' => '1',
                ),
            )
        );

        $this->add_control(
            'speed',
            array(
                'label'   => esc_html__( 'Animation Speed', 'novaworks' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 500,
            )
        );

        $this->add_responsive_control(
            'slick_list_padding_left',
            array(
                'label'      => esc_html__( 'Padding Left', 'novaworks' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( '%', 'px', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 500,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                    'em' => array(
                        'min' => 0,
                        'max' => 20,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['slick_list'] . '' => 'padding-left: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'slick_list_padding_right',
            array(
                'label'      => esc_html__( 'Padding Right', 'novaworks' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( '%', 'px', 'em' ),
                'range'      => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 500,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                    'em' => array(
                        'min' => 0,
                        'max' => 20,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['slick_list'] . '' => 'padding-right: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        /**
         * General Style Section
         */
        $this->start_controls_section(
            'section_general_style',
            array(
                'label'      => esc_html__( 'General', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_responsive_control(
            'item_padding',
            array(
                'label'      => __( 'Padding', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['item'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} ' . $css_scheme['instance'] => 'margin-left: -{{LEFT}}{{UNIT}}; margin-right: -{{RIGHT}}{{UNIT}};',
                ),
                'default'    => array(
                    'top' => 10,
                    'right' => 10,
                    'bottom' => 10,
                    'left' => 10,
                    'unit' => 'px',
                    'isLinked' => true
                )
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'item_border',
                'label'       => esc_html__( 'Border', 'novaworks' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['inner'],
            )
        );

        $this->add_responsive_control(
            'item_border_radius',
            array(
                'label'      => __( 'Border Radius', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['inner'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name' => 'item_shadow',
                'exclude' => array(
                    'box_shadow_position',
                ),
                'selector' => '{{WRAPPER}} ' . $css_scheme['inner'],
            )
        );

        $this->end_controls_section();

        /**
         * Caption Style Section
         */
        $this->start_controls_section(
            'section_caption_style',
            array(
                'label'      => esc_html__( 'Caption', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'caption_color',
            array(
                'label'  => esc_html__( 'Color', 'novaworks' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['caption'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'caption_typography',
                'selector' => '{{WRAPPER}} ' . $css_scheme['caption'],
            )
        );

        $this->add_responsive_control(
            'caption_padding',
            array(
                'label'      => __( 'Padding', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['caption'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'caption_margin',
            array(
                'label'      => __( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['caption'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'caption_width',
            array(
                'label' => esc_html__( 'Caption Width', 'novaworks' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em', '%',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 50,
                        'max' => 1000,
                    ),
                    '%' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'default' => [
                    'size'  => 100,
                    'unit' => '%'
                ],
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['caption'] => 'max-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'caption_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'flex-start'    => array(
                        'title' => esc_html__( 'Left', 'novaworks' ),
                        'icon'  => 'eicon-h-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'novaworks' ),
                        'icon'  => 'eicon-h-align-center',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'Right', 'novaworks' ),
                        'icon'  => 'eicon-h-align-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['caption'] => 'align-self: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'caption_text_alignment',
            array(
                'label'   => esc_html__( 'Text Alignment', 'novaworks' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'left'    => array(
                        'title' => esc_html__( 'Left', 'novaworks' ),
                        'icon'  => 'eicon-text-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'novaworks' ),
                        'icon'  => 'eicon-text-align-center',
                    ),
                    'right' => array(
                        'title' => esc_html__( 'Right', 'novaworks' ),
                        'icon'  => 'eicon-text-align-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['caption'] => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        /**
         * Meta Style Section
         */
        $this->start_controls_section(
            'section_meta_style',
            array(
                'label'      => esc_html__( 'Meta', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'meta_icon_color',
            array(
                'label'  => esc_html__( 'Icon Color', 'novaworks' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['meta_icon'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'meta_icon_size',
            array(
                'label'      => esc_html__( 'Icon Size', 'novaworks' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em' ,
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 100,
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['meta_icon'] . ' i' => 'font-size: {{SIZE}}{{UNIT}}',
                ),
            )
        );


        $this->add_responsive_control(
            'meta_alignment',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'flex-start'    => array(
                        'title' => esc_html__( 'Left', 'novaworks' ),
                        'icon'  => 'eicon-h-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'novaworks' ),
                        'icon'  => 'eicon-h-align-center',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'Right', 'novaworks' ),
                        'icon'  => 'eicon-h-align-right',
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['meta'] => 'align-self: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        /**
         * Overlay Style Section
         */
        $this->start_controls_section(
            'section_overlay_style',
            array(
                'label'      => esc_html__( 'Overlay', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'show_on_hover',
            array(
                'label'        => esc_html__( 'Show on hover', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'overlay_background',
                'selector' => '{{WRAPPER}} ' . $css_scheme['content'] . ':before',
            )
        );

        $this->add_responsive_control(
            'overlay_padding',
            array(
                'label'      => __( 'Padding', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['content'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        /**
         * Order Style Section
         */
        $this->start_controls_section(
            'section_order_style',
            array(
                'label'      => esc_html__( 'Content Order and Alignment', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'caption_order',
            array(
                'label'   => esc_html__( 'Caption Order', 'novaworks' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1,
                'min'     => 1,
                'max'     => 4,
                'step'    => 1,
                'selectors' => array(
                    '{{WRAPPER}} '. $css_scheme['caption'] => 'order: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'meta_order',
            array(
                'label'   => esc_html__( 'Meta Order', 'novaworks' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 2,
                'min'     => 1,
                'max'     => 4,
                'step'    => 1,
                'selectors' => array(
                    '{{WRAPPER}} '. $css_scheme['meta'] => 'order: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'cover_alignment',
            array(
                'label'   => esc_html__( 'Cover Content Vertical Alignment', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'center',
                'options' => array(
                    'flex-start'    => esc_html__( 'Top', 'novaworks' ),
                    'center'        => esc_html__( 'Center', 'novaworks' ),
                    'flex-end'      => esc_html__( 'Bottom', 'novaworks' ),
                    'space-between' => esc_html__( 'Space between', 'novaworks' ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} '. $css_scheme['content'] => 'justify-content: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        /**
         * Arrow Sections
         */

        $this->start_controls_section(
            'section_arrows_style',
            array(
                'label'      => esc_html__( 'Carousel Arrows', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->start_controls_tabs( 'tabs_arrows_style' );

        $this->start_controls_tab(
            'tab_prev',
            array(
                'label' => esc_html__( 'Normal', 'novaworks' ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'arrows_style',
                'label'          => esc_html__( 'Arrows Style', 'novaworks' ),
                'selector'       => '{{WRAPPER}} .novaworks-carousel .novaworks-arrow'
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_next_hover',
            array(
                'label' => esc_html__( 'Hover', 'novaworks' ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'arrows_hover_style',
                'label'          => esc_html__( 'Arrows Style', 'novaworks' ),
                'selector'       => '{{WRAPPER}} .novaworks-carousel .novaworks-arrow:hover'
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'prev_arrow_position',
            array(
                'label'     => esc_html__( 'Prev Arrow Position', 'novaworks' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'prev_vert_position',
            array(
                'label'   => esc_html__( 'Vertical Position by', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'top',
                'options' => array(
                    'top'    => esc_html__( 'Top', 'novaworks' ),
                    'bottom' => esc_html__( 'Bottom', 'novaworks' ),
                ),
            )
        );

        $this->add_responsive_control(
            'prev_top_position',
            array(
                'label'      => esc_html__( 'Top Indent', 'novaworks' ),
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
                'label'      => esc_html__( 'Bottom Indent', 'novaworks' ),
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
                'label'   => esc_html__( 'Horizontal Position by', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'left',
                'options' => array(
                    'left'  => esc_html__( 'Left', 'novaworks' ),
                    'right' => esc_html__( 'Right', 'novaworks' ),
                ),
            )
        );

        $this->add_responsive_control(
            'prev_left_position',
            array(
                'label'      => esc_html__( 'Left Indent', 'novaworks' ),
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
                'label'      => esc_html__( 'Right Indent', 'novaworks' ),
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
                'label'     => esc_html__( 'Next Arrow Position', 'novaworks' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'next_vert_position',
            array(
                'label'   => esc_html__( 'Vertical Position by', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'top',
                'options' => array(
                    'top'    => esc_html__( 'Top', 'novaworks' ),
                    'bottom' => esc_html__( 'Bottom', 'novaworks' ),
                ),
            )
        );

        $this->add_responsive_control(
            'next_top_position',
            array(
                'label'      => esc_html__( 'Top Indent', 'novaworks' ),
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
                'label'      => esc_html__( 'Bottom Indent', 'novaworks' ),
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
                'label'   => esc_html__( 'Horizontal Position by', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => array(
                    'left'  => esc_html__( 'Left', 'novaworks' ),
                    'right' => esc_html__( 'Right', 'novaworks' ),
                ),
            )
        );

        $this->add_responsive_control(
            'next_left_position',
            array(
                'label'      => esc_html__( 'Left Indent', 'novaworks' ),
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
                'label'      => esc_html__( 'Right Indent', 'novaworks' ),
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
                'label'      => esc_html__( 'Carousel Dots', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->start_controls_tabs( 'tabs_dots_style' );

        $this->start_controls_tab(
            'tab_dots_normal',
            array(
                'label' => esc_html__( 'Normal', 'novaworks' ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'dots_style',
                'label'          => esc_html__( 'Dots Style', 'novaworks' ),
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
                'label' => esc_html__( 'Hover', 'novaworks' ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'dots_style_hover',
                'label'          => esc_html__( 'Dots Style', 'novaworks' ),
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
                'label' => esc_html__( 'Active', 'novaworks' ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'dots_style_active',
                'label'          => esc_html__( 'Dots Style', 'novaworks' ),
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
                'label' => esc_html__( 'Gap', 'novaworks' ),
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
                'label'      => esc_html__( 'Dots Box Margin', 'novaworks' ),
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
                'label'   => esc_html__( 'Alignment', 'novaworks' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'flex-start' => array(
                        'title' => esc_html__( 'Left', 'novaworks' ),
                        'icon'  => 'eicon-h-align-left',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'novaworks' ),
                        'icon'  => 'eicon-h-align-center',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'Right', 'novaworks' ),
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

    private function get_token(){
        return get_option( 'nova_elements_instagram_access_token' );
    }

    private function is_valid_token(){
        $token = $this->get_token();
        if(empty($token)){
            return __('Invalid Token', 'novaworks');
        }
        $token_cache = get_transient('novaworks_ig_token');
        if(empty($token_cache)){
            $ig_refresh_token_url = add_query_arg([
                'grant_type' => 'ig_refresh_token',
                'access_token' => $token
            ], 'https://graph.instagram.com/refresh_access_token');
            $response = wp_remote_get($ig_refresh_token_url);
            // request failed
            if ( is_wp_error( $response ) ) {
                return __('Invalid Token [1]', 'novaworks');
            }
            $code = (int) wp_remote_retrieve_response_code( $response );
            if ( $code !== 200 ) {
                return __('Invalid Token [2]', 'novaworks');
            }
            $body = wp_remote_retrieve_body($response);
            $body = json_decode($body, true);
            $expires_in = (int) $body['expires_in'] - DAY_IN_SECONDS;
            if($expires_in > 0){
                set_transient('novaworks_ig_token', $body , HOUR_IN_SECONDS * 12);
            }
            else{
                return __('Invalid Token [3]', 'novaworks');
            }
        }
        return true;
    }

    private function get_refresh_token(){
        $token_cache = get_transient('novaworks_ig_token');
        if(!empty($token_cache['access_token'])){
            return $token_cache['access_token'];
        }
        else{
            return $this->get_token();
        }
    }

    /**
     * Render gallery html.
     *
     * @return string
     */
    public function render_gallery() {

        $is_valid = $this->is_valid_token();

        if(true !== $is_valid){
            if ( ! current_user_can( 'manage_options' ) ) {
                return sprintf(
                    '<div class="loop__item grid-item novaworks-instagram-gallery__item">%s</div>',
                    esc_html__( 'Posts not found', 'novaworks' )
                );
            }
            else{
                return sprintf(
                    '<div class="loop__item grid-item novaworks-instagram-gallery__item">%s</div>',
                    $is_valid
                );

            }
        }

        $settings = $this->get_settings_for_display();
        $html = '';
        $col_class = '';

        switch ( $settings['cache_timeout'] ) {
            case 'none':
                $cache_timeout = 1;
                break;

            case 'minute':
                $cache_timeout = MINUTE_IN_SECONDS;
                break;

            case 'hour':
                $cache_timeout = HOUR_IN_SECONDS;
                break;

            case 'day':
                $cache_timeout = DAY_IN_SECONDS;
                break;

            case 'week':
                $cache_timeout = WEEK_IN_SECONDS;
                break;

            default:
                $cache_timeout = HOUR_IN_SECONDS;
                break;
        }

        $this->config = array(
            'token'               => $this->get_refresh_token(),
            'posts_counter'       => $settings['posts_counter'],
            'post_link'           => filter_var( $settings['post_link'], FILTER_VALIDATE_BOOLEAN ),
            'post_caption'        => filter_var( $settings['post_caption'], FILTER_VALIDATE_BOOLEAN ),
            'post_caption_length' => ! empty( $settings['post_caption_length'] ) ? $settings['post_caption_length'] : 50,
            'cache_timeout'       => $cache_timeout,
        );

        $posts = $this->get_posts( $this->config );

        if ( ! empty( $posts ) ) {

            foreach ( $posts as $post_data ) {
                $item_html   = '';
                $link        = $post_data['link'];
                $the_image   = $this->the_image_src( $post_data );
                $the_caption = $this->the_caption( $post_data );
                $the_meta = '<div class="novaworks-instagram-gallery__meta"><div class="novaworks-instagram-gallery__meta-item"><span class="novaworks-instagram-gallery__meta-icon"><i class="fab fa-instagram"></i></span></div></div>';
                $item_html = sprintf(
                    '<div class="novaworks-instagram-gallery__media">%1$s</div><div class="novaworks-instagram-gallery__content">%2$s%3$s</div>',
                    $the_image,
                    $the_caption,
                    $the_meta
                );

                if ( $this->config['post_link'] ) {
                    $link_format = '<a class="novaworks-instagram-gallery__link" href="%1$s" target="_blank" rel="nofollow" title="%2$s">%3$s</a>';
                    $link_format = apply_filters( 'NovaworksElement/instagram-gallery/link-format', $link_format );
                    $item_html = sprintf( $link_format, esc_url( $link ), esc_attr($post_data['caption']), $item_html );
                }

                $html .= sprintf( '<div class="cell novaworks-instagram-gallery__item %s"><div class="novaworks-instagram-gallery__inner">%s</div></div>', $col_class, $item_html );
            }

        } else {
            $html .= sprintf(
                '<div class="cell novaworks-instagram-gallery__item">%s</div>',
                esc_html__( 'Posts not found', 'novaworks' )
            );
        }

        echo $html;
    }

    /**
     * Display a HTML link with image.
     *
     * @since  1.0.0
     * @param  array $item Item photo data.
     * @return string
     */
    public function the_image_src( $item ) {
        $post_photo_url = isset( $item['image'] ) ? $item['image'] : '';

        if ( empty( $post_photo_url ) ) {
            return '';
        }

        $photo_format = apply_filters( 'NovaworksElement/instagram-gallery/photo-format-src', '<span class="novaworks-instagram-gallery__image nova-lazyload-image" data-background-image="%1$s"></span>');

        $image = sprintf( $photo_format, $post_photo_url );

        return $image;
    }

    /**
     * Display a caption.
     *
     * @since  1.0.0
     * @param  array $item Item photo data.
     * @return string
     */
    public function the_caption( $item ) {

        if ( ! $this->config['post_caption'] || empty( $item['caption'] ) ) {
            return;
        }

        $caption = isset( $item['caption'] ) ? wp_html_excerpt( $item['caption'], $this->config['post_caption_length'], '&hellip;' ) : '';

        $format = apply_filters(
            'NovaworksElement/instagram-gallery/the-caption-format', '<div class="novaworks-instagram-gallery__caption">%s</div>'
        );

        return sprintf( $format, $caption );
    }

    /**
     * Retrieve a photos.
     *
     * @since  1.0.0
     * @param  array $config Set of configuration.
     * @return array
     */
    public function get_posts( $config ) {

        $transient_key = $this->get_transient_key();

        $data = get_transient( $transient_key );

        if ( ! empty( $data ) && 1 !== $config['cache_timeout'] ) {
            return $data;
        }
        $response = $this->remote_get( $config );
        if ( is_wp_error( $response ) ) {
            return array();
        }

        $data = $this->get_response_data( $response );
        if ( empty( $data ) ) {
            return array();
        }

        set_transient( $transient_key, $data, $config['cache_timeout'] );
        return $data;
    }

    /**
     * Retrieve the raw response from the HTTP request using the GET method.
     *
     * @since  1.0.0
     * @return array|WP_Error
     */
    public function remote_get( $config ) {

        $url = add_query_arg([
            'fields'        => 'caption,media_type,media_url,thumbnail_url,permalink,timestamp,comments_count,like_count',
            'access_token'  => $config['token'],
            'limit'         => 20
        ], 'https://graph.instagram.com/me/media');

        $response = wp_remote_get( $url, array(
            'timeout'   => 60,
            'sslverify' => false
        ) );

        $response_code = wp_remote_retrieve_response_code( $response );

        if ( '' === $response_code ) {
            return new \WP_Error;
        }

        $result = json_decode( wp_remote_retrieve_body( $response ), true );

        if ( ! is_array( $result ) ) {
            return new \WP_Error;
        }

        return $result;
    }

    /**
     * Get prepared response data.
     *
     * @param $response
     *
     * @return array
     */
    public function get_response_data( $response ) {

        if(empty($response['data'])){
            return array();
        }

        $response_items = $response['data'];

        if ( empty( $response_items ) ) {
            return array();
        }

        $data  = array();
        $nodes = array_slice(
            $response_items,
            0,
            $this->config['posts_counter'],
            true
        );

        foreach ( $nodes as $post ) {
            $_post               = array();
            $_post['link']       = $post['permalink'];
            $_post['image']      = $post['media_type'] == 'VIDEO' ? $post['thumbnail_url'] : $post['media_url'];
            $_post['caption']    = isset( $post['caption'] ) ? $post['caption'] : '';
            array_push( $data, $_post );
        }
        return $data;
    }

    /**
     * Get transient key.
     *
     * @since  1.0.0
     * @return string
     */
    public function get_transient_key() {
        return 'novaworks_ig_feed';
        return sprintf( 'novaworks_elements_instagram_%s_%s_posts_count_%s_caption_%s',
            $this->config['endpoint'],
            $this->config['target'],
            $this->config['posts_counter'],
            $this->config['post_caption_length']
        );
    }

    /**
     * Generate setting json
     *
     * @return string
     */
    public function generate_carousel_setting_json(){
        $settings = $this->get_settings();

        $json_data = '';

        if ( 'yes' !== $settings['carousel_enabled'] ) {
            return $json_data;
        }

        $is_rtl = is_rtl();

        $desktop_col = absint( $settings['columns'] );
        $laptop_col = absint( isset($settings['columns_laptop']) ? $settings['columns_laptop'] : 0 );
        $tablet_col = absint( $settings['columns_tablet'] );
        $tabletportrait_col = absint(  isset($settings['columns_tabletportrait']) ? $settings['columns_tabletportrait'] : 0 );
        $mobile_col = absint( $settings['columns_mobile'] );

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

        $options = array(
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
            'nextArrow'      => novaworks_elementor_tools_get_carousel_arrow( [ 'next-arrow', 'slick-next' ], [ $settings['next_arrow'] ] ),
            'rtl'            => $is_rtl,
        );

        if ( 1 === absint( $settings['columns'] ) ) {
            $options['fade'] = ( 'fade' === $settings['effect'] );
        }

        $json_data = htmlspecialchars( json_encode( $options ) );

        return $json_data;

    }
}
