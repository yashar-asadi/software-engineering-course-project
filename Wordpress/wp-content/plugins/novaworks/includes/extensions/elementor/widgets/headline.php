<?php
namespace Novaworks_Element\Widgets;

if (!defined('WPINC')) {
    die;
}


// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Icons_Manager;



/**
 * Headline Widget
 */
class Headline extends NOVA_Widget_Base {

    public function __construct($data = [], $args = null) {

        $this->add_style_depends( $this->get_name() . '-elm' );

        parent::__construct($data, $args);
    }

    public function get_name() {
        return 'novaworks-headline';
    }

    protected function get_widget_title() {
        return esc_html__( 'Headline', 'novaworks' );
    }

    public function get_icon() {
        return 'nova-elements-icon-31';
    }

    protected function _register_controls() {

        $css_scheme = apply_filters(
            'NovaworksElement/headline/css-scheme',
            array(
                'instance'    => '.novaworks-headline',
                'first_part'  => '.novaworks-headline__first',
                'second_part' => '.novaworks-headline__second',
                'divider'     => '.novaworks-headline__divider',
            )
        );

        $this->start_controls_section(
            'section_title',
            array(
                'label' => esc_html__( 'Title', 'novaworks' ),
            )
        );

        $this->add_control(
            'first_part',
            array(
                'label'       => esc_html__( 'Title first part', 'novaworks' ),
                'type'        => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__( 'Enter title first part', 'novaworks' ),
                'default'     => esc_html__( 'Heading', 'novaworks' ),
                'dynamic'     => array( 'active' => true ),
            )
        );

        $this->add_control(
            'second_part',
            array(
                'label'       => esc_html__( 'Title second part', 'novaworks' ),
                'type'        => Controls_Manager::TEXTAREA,
                'placeholder' => esc_html__( 'Enter title second part', 'novaworks' ),
                'default'     => esc_html__( 'element', 'novaworks' ),
                'dynamic'     => array( 'active' => true ),
            )
        );

        $this->add_control(
            'link',
            array(
                'label'       => esc_html__( 'Link', 'novaworks' ),
                'type'        => Controls_Manager::URL,
                'placeholder' => 'http://your-link.com',
                'default' => array(
                    'url' => '',
                ),
                'separator'   => 'before',
                'dynamic'     => array( 'active' => true ),
            )
        );

        $this->add_control(
            'header_size',
            array(
                'label'   => esc_html__( 'HTML Tag', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'options' => array(
                    'h1'   => esc_html__( 'H1', 'novaworks' ),
                    'h2'   => esc_html__( 'H2', 'novaworks' ),
                    'h3'   => esc_html__( 'H3', 'novaworks' ),
                    'h4'   => esc_html__( 'H4', 'novaworks' ),
                    'h5'   => esc_html__( 'H5', 'novaworks' ),
                    'h6'   => esc_html__( 'H6', 'novaworks' ),
                    'div'  => esc_html__( 'div', 'novaworks' ),
                    'span' => esc_html__( 'span', 'novaworks' ),
                    'p'    => esc_html__( 'p', 'novaworks' ),
                ),
                'default' => 'h2',
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_deco_elements',
            array(
                'label' => esc_html__( 'Decorative Elements', 'novaworks' ),
            )
        );

        $this->add_control(
            'before_deco_heading',
            array(
                'label' => esc_html__( 'Before Deco Element', 'novaworks' ),
                'type'  => Controls_Manager::HEADING,
            )
        );

        $this->add_control(
            'before_deco_type',
            array(
                'label'   => esc_html__( 'Before Deco Type', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => array(
                    'none'  => esc_html__( 'None', 'novaworks' ),
                    'icon'  => esc_html__( 'Icon', 'novaworks' ),
                    'image' => esc_html__( 'Image', 'novaworks' ),
                ),
            )
        );

        $this->add_control(
            'before_icon',
            array(
                'label'       => esc_html__( 'Before Icon', 'novaworks' ),
                'type'        => Controls_Manager::ICONS,
                'fa4compatibility' => 'none',
                'label_block' => true,
                'default' => [
                    'value' => 'far fa-star',
                    'library' => 'solid',
                ],
                'condition' => array(
                    'before_deco_type' => 'icon',
                ),
            )
        );

        $this->add_control(
            'before_image',
            array(
                'label'   => esc_html__( 'Before Image', 'novaworks' ),
                'type'    => Controls_Manager::MEDIA,
                'condition' => array(
                    'before_deco_type' => 'image',
                ),
            )
        );

        $this->add_control(
            'after_deco_heading',
            array(
                'label'     => esc_html__( 'After Deco Element', 'novaworks' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'after_deco_type',
            array(
                'label'   => esc_html__( 'After Deco Type', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => array(
                    'none'  => esc_html__( 'None', 'novaworks' ),
                    'icon'  => esc_html__( 'Icon', 'novaworks' ),
                    'image' => esc_html__( 'Image', 'novaworks' ),
                ),
            )
        );

        $this->add_control(
            'after_icon',
            array(
                'label'       => esc_html__( 'After Icon', 'novaworks' ),
                'type'        => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'label_block' => true,
                'default' => [
                    'value' => 'fas fa-star',
                    'library' => 'solid',
                ],
                'condition' => array(
                    'after_deco_type' => 'icon',
                ),
            )
        );

        $this->add_control(
            'after_image',
            array(
                'label'   => esc_html__( 'After Image', 'novaworks' ),
                'type'    => Controls_Manager::MEDIA,
                'condition' => array(
                    'after_deco_type' => 'image',
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

        $this->add_control(
            'instance_direction',
            array(
                'label'   => esc_html__( 'Direction', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => array(
                    'horizontal' => esc_html__( 'Horizontal', 'novaworks' ),
                    'vertical'   => esc_html__( 'Vertical', 'novaworks' ),
                )
            )
        );

        $this->add_control(
            'use_space_between',
            array(
                'label'        => esc_html__( 'Space Between', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition' => array(
                    'instance_direction' => 'horizontal',
                ),
            )
        );

        $this->add_control(
            'instance_alignment_horizontal',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks' ),
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
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} '. $css_scheme['instance'] => 'justify-content: {{VALUE}};',
                    '{{WRAPPER}} '. $css_scheme['instance'] . ' > .novaworks-headline__link' => 'justify-content: {{VALUE}};',
                ),
                'condition' => array(
                    'instance_direction' => 'horizontal',
                ),
            )
        );

        $this->add_control(
            'instance_alignment_vertical',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks' ),
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
                    ),
                ),
                'selectors'  => array(
                    '{{WRAPPER}} '. $css_scheme['instance'] => 'align-items: {{VALUE}};',
                    '{{WRAPPER}} '. $css_scheme['instance'] . ' > .novaworks-headline__link' => 'align-items: {{VALUE}};',
                ),
                'condition' => array(
                    'instance_direction' => 'vertical',
                ),
            )
        );

        $this->end_controls_section();

        /**
         * First Part Style Section
         */
        $this->start_controls_section(
            'section_first_part_style',
            array(
                'label'      => esc_html__( 'First Part', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'first_color',
            array(
                'label'  => esc_html__( 'Text Color', 'novaworks' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part']  . ' .novaworks-headline__label' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'f_t',

                'selector' => '{{WRAPPER}} ' . $css_scheme['first_part'] . ' .novaworks-headline__label',
            )
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            array(
                'name'     => 'f_tsd',
                'selector' => '{{WRAPPER}} ' . $css_scheme['first_part'] . ' .novaworks-headline__label',
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'f_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['first_part'],
            )
        );

        $this->add_control(
            'use_first_text_image',
            array(
                'label'        => esc_html__( 'Use Text Image', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'separator'    => 'before',
            )
        );

        $this->add_control(
            'first_text_image',
            array(
                'label'   => esc_html__( 'Text Image', 'novaworks' ),
                'type'    => Controls_Manager::MEDIA,
                'condition' => array(
                    'use_first_text_image' => 'yes',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part'] . ' .novaworks-headline__label' => 'background-image: url({{URL}})',
                ),
            )
        );

        $this->add_control(
            'first_text_image_position',
            array(
                'label'   =>esc_html__( 'Background Position', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => array(
                    ''              => esc_html__( 'Default', 'novaworks' ),
                    'top left'      => esc_html__( 'Top Left', 'novaworks' ),
                    'top center'    => esc_html__( 'Top Center', 'novaworks' ),
                    'top right'     => esc_html__( 'Top Right', 'novaworks' ),
                    'center left'   => esc_html__( 'Center Left', 'novaworks' ),
                    'center center' => esc_html__( 'Center Center', 'novaworks' ),
                    'center right'  => esc_html__( 'Center Right', 'novaworks' ),
                    'bottom left'   => esc_html__( 'Bottom Left', 'novaworks' ),
                    'bottom center' => esc_html__( 'Bottom Center', 'novaworks' ),
                    'bottom right'  => esc_html__( 'Bottom Right', 'novaworks' ),
                ),
                'condition' => array(
                    'use_first_text_image' => 'yes',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part'] . ' .novaworks-headline__label' => 'background-position: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'first_text_image_repeat',
            array(
                'label'   =>esc_html__( 'Background Repeat', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => array(
                    ''          => esc_html__( 'Default', 'novaworks' ),
                    'no-repeat' => esc_html__( 'No-repeat', 'novaworks' ),
                    'repeat'    => esc_html__( 'Repeat', 'novaworks' ),
                    'repeat-x'  => esc_html__( 'Repeat-x', 'novaworks' ),
                    'repeat-y'  => esc_html__( 'Repeat-y', 'novaworks' ),
                ),
                'condition' => array(
                    'use_first_text_image' => 'yes',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part'] . ' .novaworks-headline__label' => 'background-repeat: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'first_text_image_size',
            array(
                'label'   =>esc_html__( 'Background Size', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => array(
                    ''        => esc_html__( 'Default', 'novaworks' ),
                    'auto'    => esc_html__( 'Auto', 'novaworks' ),
                    'cover'   => esc_html__( 'Cover', 'novaworks' ),
                    'contain' => esc_html__( 'Contain', 'novaworks' ),
                ),
                'condition' => array(
                    'use_first_text_image' => 'yes',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part'] . ' .novaworks-headline__label' => 'background-size: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'f_bd',
                'label'       => esc_html__( 'Border', 'novaworks' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['first_part'],
                'separator'   => 'before',
            )
        );

        $this->add_responsive_control(
            'f_bdr',
            array(
                'label'      => __( 'Border Radius', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'f_pd',
            array(
                'label'      => __( 'Padding', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'f_mg',
            array(
                'label'      => __( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'f_va',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'flex-start'    => array(
                        'title' => esc_html__( 'Top', 'novaworks' ),
                        'icon'  => 'eicon-v-align-top',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'novaworks' ),
                        'icon'  => 'eicon-v-align-middle',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'Bottom', 'novaworks' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ),
                ),
                'condition' => array(
                    'instance_direction' => 'horizontal',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part'] => 'align-self: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'f_ha',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks' ),
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
                    ),
                ),
                'condition' => array(
                    'instance_direction' => 'vertical',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part'] => 'align-self: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'f_ta',
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
                    '{{WRAPPER}} ' . $css_scheme['first_part'] . ' .novaworks-headline__label' => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        /**
         * Second Part Style Section
         */
        $this->start_controls_section(
            'section_second_part_style',
            array(
                'label'      => esc_html__( 'Second Part', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'second_color',
            array(
                'label'  => esc_html__( 'Text Color', 'novaworks' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] . ' .novaworks-headline__label' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 's_t',

                'selector' => '{{WRAPPER}} ' . $css_scheme['second_part'] . ' .novaworks-headline__label',
            )
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            array(
                'name'     => 's_tsd',
                'selector' => '{{WRAPPER}} ' . $css_scheme['second_part'] . ' .novaworks-headline__label',
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 's_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['second_part'],
            )
        );

        $this->add_control(
            'use_second_text_image',
            array(
                'label'        => esc_html__( 'Use Text Image', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'no',
                'separator'    => 'before',
            )
        );

        $this->add_control(
            'second_text_image',
            array(
                'label'   => esc_html__( 'Text Image', 'novaworks' ),
                'type'    => Controls_Manager::MEDIA,
                'condition' => array(
                    'use_second_text_image' => 'yes',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] . ' .novaworks-headline__label' => 'background-image: url({{URL}});',
                ),
            )
        );

        $this->add_control(
            'second_text_image_position',
            array(
                'label'   =>esc_html__( 'Background Position', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => array(
                    ''              => esc_html__( 'Default', 'novaworks' ),
                    'top left'      => esc_html__( 'Top Left', 'novaworks' ),
                    'top center'    => esc_html__( 'Top Center', 'novaworks' ),
                    'top right'     => esc_html__( 'Top Right', 'novaworks' ),
                    'center left'   => esc_html__( 'Center Left', 'novaworks' ),
                    'center center' => esc_html__( 'Center Center', 'novaworks' ),
                    'center right'  => esc_html__( 'Center Right', 'novaworks' ),
                    'bottom left'   => esc_html__( 'Bottom Left', 'novaworks' ),
                    'bottom center' => esc_html__( 'Bottom Center', 'novaworks' ),
                    'bottom right'  => esc_html__( 'Bottom Right', 'novaworks' ),
                ),
                'condition' => array(
                    'use_second_text_image' => 'yes',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] . ' .novaworks-headline__label' => 'background-position: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'second_text_image_repeat',
            array(
                'label'   =>esc_html__( 'Background Repeat', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => array(
                    ''          => esc_html__( 'Default', 'novaworks' ),
                    'no-repeat' => esc_html__( 'No-repeat', 'novaworks' ),
                    'repeat'    => esc_html__( 'Repeat', 'novaworks' ),
                    'repeat-x'  => esc_html__( 'Repeat-x', 'novaworks' ),
                    'repeat-y'  => esc_html__( 'Repeat-y', 'novaworks' ),
                ),
                'condition' => array(
                    'use_second_text_image' => 'yes',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] . ' .novaworks-headline__label' => 'background-repeat: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'second_text_image_size',
            array(
                'label'   =>esc_html__( 'Background Size', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => array(
                    ''        => esc_html__( 'Default', 'novaworks' ),
                    'auto'    => esc_html__( 'Auto', 'novaworks' ),
                    'cover'   => esc_html__( 'Cover', 'novaworks' ),
                    'contain' => esc_html__( 'Contain', 'novaworks' ),
                ),
                'condition' => array(
                    'use_second_text_image' => 'yes',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] . ' .novaworks-headline__label' => 'background-size: {{VALUE}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 's_bd',
                'label'       => esc_html__( 'Border', 'novaworks' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['second_part'],
                'separator'   => 'before',
            )
        );

        $this->add_responsive_control(
            's_bdr',
            array(
                'label'      => __( 'Border Radius', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            's_pd',
            array(
                'label'      => __( 'Padding', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            's_mg',
            array(
                'label'      => __( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            's_va',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'flex-start'    => array(
                        'title' => esc_html__( 'Top', 'novaworks' ),
                        'icon'  => 'eicon-v-align-top',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'novaworks' ),
                        'icon'  => 'eicon-v-align-middle',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'Bottom', 'novaworks' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ),
                ),
                'condition' => array(
                    'instance_direction' => 'horizontal',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] => 'align-self: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            's_ha',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks' ),
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
                    ),
                ),
                'condition' => array(
                    'instance_direction' => 'vertical',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] => 'align-self: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            's_ta',
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
                    '{{WRAPPER}} ' . $css_scheme['second_part'] . ' .novaworks-headline__label' => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        /**
         * Decorative Style Section
         */
        $this->start_controls_section(
            'section_deco_style',
            array(
                'label'      => esc_html__( 'Decorative Elements', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'before_deco',
            array(
                'label' => esc_html__( 'Before Deco Element', 'novaworks' ),
                'type'  => Controls_Manager::HEADING,
                'condition' => array(
                    'before_deco_type!' => 'none',
                ),
            )
        );

        $this->add_control(
            'before_icon_color',
            array(
                'label'     => esc_html__( 'Before Icon Color', 'novaworks' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => array(
                    'before_deco_type' => 'icon',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part'] . ' .novaworks-headline__deco-icon i' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'b_ics',
            array(
                'label'      => esc_html__( 'Before Icon Size', 'novaworks' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 18,
                        'max' => 200,
                    ),
                ),
                'condition' => array(
                    'before_deco_type' => 'icon',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part'] . ' .novaworks-headline__deco-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        $this->add_responsive_control(
            'b_igws',
            array(
                'label'      => esc_html__( 'Before Image Width Size', 'novaworks' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em', '%',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 18,
                        'max' => 200,
                    ),
                ),
                'condition' => array(
                    'before_deco_type' => 'image',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part'] . ' .novaworks-headline__deco-image' => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'b_ighs',
            array(
                'label'      => esc_html__( 'Before Image Height Size', 'novaworks' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em', '%',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 18,
                        'max' => 200,
                    ),
                ),
                'condition' => array(
                    'before_deco_type' => 'image',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part'] . ' .novaworks-headline__deco-image' => 'height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'b_d_mg',
            array(
                'label'      => __( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part'] . ' .novaworks-headline__deco' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'condition' => array(
                    'before_deco_type!' => 'none',
                ),
            )
        );

        $this->add_responsive_control(
            'b_d_a',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'flex-start'    => array(
                        'title' => esc_html__( 'Top', 'novaworks' ),
                        'icon'  => 'eicon-v-align-top',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'novaworks' ),
                        'icon'  => 'eicon-v-align-middle',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'Bottom', 'novaworks' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ),
                ),
                'condition' => array(
                    'before_deco_type!' => 'none',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['first_part'] . ' .novaworks-headline__deco' => 'align-self: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'after_deco',
            array(
                'label'     => esc_html__( 'After Deco Element', 'novaworks' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'after_deco_type!' => 'none',
                ),
            )
        );

        $this->add_control(
            'after_icon_color',
            array(
                'label'     => esc_html__( 'After Icon Color', 'novaworks' ),
                'type'      => Controls_Manager::COLOR,
                'condition' => array(
                    'after_deco_type' => 'icon',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] . ' .novaworks-headline__deco-icon i' => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'a_ics',
            array(
                'label'      => esc_html__( 'After Icon Size', 'novaworks' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 18,
                        'max' => 200,
                    ),
                ),
                'condition' => array(
                    'after_deco_type' => 'icon',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] . ' .novaworks-headline__deco-icon i' => 'font-size: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        $this->add_responsive_control(
            'a_igws',
            array(
                'label'      => esc_html__( 'After Image Width Size', 'novaworks' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em', '%',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 18,
                        'max' => 200,
                    ),
                ),
                'condition' => array(
                    'after_deco_type' => 'image',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] . ' .novaworks-headline__deco-image' => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'a_ighs',
            array(
                'label'      => esc_html__( 'After Image Height Size', 'novaworks' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array(
                    'px', 'em', '%',
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 18,
                        'max' => 200,
                    ),
                ),
                'condition' => array(
                    'after_deco_type' => 'image',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] . ' .novaworks-headline__deco-image' => 'height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'a_d_mg',
            array(
                'label'      => __( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] . ' .novaworks-headline__deco' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'condition' => array(
                    'after_deco_type!' => 'none',
                ),
            )
        );

        $this->add_responsive_control(
            'a_d_a',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
                'options' => array(
                    'flex-start'    => array(
                        'title' => esc_html__( 'Top', 'novaworks' ),
                        'icon'  => 'eicon-v-align-top',
                    ),
                    'center' => array(
                        'title' => esc_html__( 'Center', 'novaworks' ),
                        'icon'  => 'eicon-v-align-middle',
                    ),
                    'flex-end' => array(
                        'title' => esc_html__( 'Bottom', 'novaworks' ),
                        'icon'  => 'eicon-v-align-bottom',
                    ),
                ),
                'condition' => array(
                    'after_deco_type!' => 'none',
                ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['second_part'] . ' .novaworks-headline__deco' => 'align-self: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'divider_deco',
            array(
                'label'     => esc_html__( 'Divider Deco Element', 'novaworks' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'use_divider_deco',
            array(
                'label'        => esc_html__( 'Use Divider Mode', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'no',
            )
        );

        $this->add_responsive_control(
            'divider_deco_height',
            array(
                'label'   => esc_html__( 'Divider Height', 'novaworks' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 2,
                'min'     => 1,
                'max'     => 50,
                'step'    => 1,
                'condition' => array(
                    'use_divider_deco' => 'yes',
                ),
                'selectors' => array(
                    '{{WRAPPER}} '. $css_scheme['divider'] => 'height: {{VALUE}}px;',
                ),
            )
        );

        $this->add_responsive_control(
            'divider_deco_w',
            [
                'label' => __( 'Divider Width', 'novaworks' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range'      => array(
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ]
                ),
                'selectors' => [
                    '{{WRAPPER}} '. $css_scheme['divider'] => 'flex: {{SIZE}}{{UNIT}} 0 0;',
                ],
                'condition' => [
                    'use_divider_deco' => 'yes'
                ]
            ]
        );

        $this->add_responsive_control(
            'divider_deco_space',
            array(
                'label'   => esc_html__( 'Divider Space', 'novaworks' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 10,
                'min'     => 0,
                'max'     => 200,
                'step'    => 1,
                'condition' => array(
                    'use_divider_deco'   => 'yes',
                    'instance_direction' => 'horizontal',
                ),
                'selectors' => array(
                    '{{WRAPPER}} '. $css_scheme['divider'] . '.novaworks-headline__left-divider' => 'margin-right: {{VALUE}}px;',
                    '{{WRAPPER}} '. $css_scheme['divider'] . '.novaworks-headline__right-divider' => 'margin-left: {{VALUE}}px;',
                ),
            )
        );

        $this->start_controls_tabs( 'tabs_deco_divider' );

        $this->start_controls_tab(
            'tab_deco_divider_left',
            array(
                'label' => esc_html__( 'Left', 'novaworks' ),
                'condition' => array(
                    'use_divider_deco' => 'yes',
                ),
            )
        );

        $this->add_control(
            'use_divider_deco_left',
            array(
                'label'        => esc_html__( 'Enable', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => array(
                    'use_divider_deco' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'      => 'dd_l_bg',
                'label'     => esc_html__( 'Background', 'novaworks' ),
                'selector'  => '{{WRAPPER}} ' . $css_scheme['divider'] . '.novaworks-headline__left-divider',
                'condition' => array(
                    'use_divider_deco' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'dd_l_bd',
                'label'       => esc_html__( 'Border', 'novaworks' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['divider'] . '.novaworks-headline__left-divider',
                'condition'   => array(
                    'use_divider_deco' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_deco_divider_right',
            array(
                'label' => esc_html__( 'Right', 'novaworks' ),
                'condition' => array(
                    'use_divider_deco' => 'yes',
                ),
            )
        );

        $this->add_control(
            'use_divider_deco_right',
            array(
                'label'        => esc_html__( 'Enable', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'yes',
                'condition'    => array(
                    'use_divider_deco' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'      => 'dd_r_bg',
                'label'     => esc_html__( 'Background', 'novaworks' ),
                'selector'  => '{{WRAPPER}} ' . $css_scheme['divider'] . '.novaworks-headline__right-divider',
                'condition' => array(
                    'use_divider_deco' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'dd_r_bd',
                'label'       => esc_html__( 'Border', 'novaworks' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['divider'] . '.novaworks-headline__right-divider',
                'condition'   => array(
                    'use_divider_deco' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    /**
     * [render description]
     * @return [type] [description]
     */
    protected function render() {

        $settings = $this->get_settings_for_display();

        if ( empty( $settings['first_part'] ) && empty( $settings['second_part'] ) ) {
            return;
        }

        $first_part = '';
        $second_part = '';
        $before_deco_html = '';
        $after_deco_html = '';
        $space = '';

        $heading_classes_array = array( 'novaworks-headline' );
        $heading_classes_array[] = 'novaworks-headline--direction-' . $settings['instance_direction'];

        $heading_classes = implode( ' ', $heading_classes_array );

        if ( filter_var( $settings['use_space_between'], FILTER_VALIDATE_BOOLEAN ) && 'horizontal' === $settings['instance_direction'] ) {
            $space = '<span class="novaworks-headline__space">&nbsp;</span>';
        }

        // Before Deco Render
        if ( 'none' !== $settings['before_deco_type'] ) {

            if ( 'icon' === $settings['before_deco_type'] && ! empty( $settings['before_icon'] ) ) {
                ob_start();
                Icons_Manager::render_icon( $settings['before_icon'], [ 'aria-hidden' => 'true' ] );
                $before_deco_icon = ob_get_clean();
                $before_deco_html = sprintf( '<span class="novaworks-headline__deco novaworks-headline__deco-icon">%1$s</span>', $before_deco_icon );
            }

            if ( 'image' === $settings['before_deco_type'] && ! empty( $settings['before_image']['url'] ) ) {
                $before_deco_image = sprintf( '<img src="%s" alt="">', apply_filters('novaworks_wp_get_attachment_image_url', $settings['before_image']['url']) );
                $before_deco_html = sprintf( '<span class="novaworks-headline__deco novaworks-headline__deco-image">%1$s</span>', $before_deco_image );
            }
        }

        // After Deco Render
        if ( 'none' !== $settings['after_deco_type'] ) {

            if ( 'icon' === $settings['after_deco_type'] && ! empty( $settings['after_icon'] ) ) {
                ob_start();
                Icons_Manager::render_icon( $settings['after_icon'], [ 'aria-hidden' => 'true' ] );
                $after_deco_icon = ob_get_clean();
                $after_deco_html = sprintf( '<span class="novaworks-headline__deco novaworks-headline__deco-icon">%1$s</span>', $after_deco_icon );
            }

            if ( 'image' === $settings['after_deco_type'] && ! empty( $settings['after_image']['url'] ) ) {
                $after_deco_image = sprintf( '<img src="%s" alt="">', apply_filters('novaworks_wp_get_attachment_image_url', $settings['after_image']['url']) );
                $after_deco_html = sprintf( '<span class="novaworks-headline__deco novaworks-headline__deco-image">%1$s</span>', $after_deco_image );
            }
        }

        if ( ! empty( $settings['first_part'] ) ) {

            $first_classes_array = array( 'novaworks-headline__part', 'novaworks-headline__first' );

            if ( filter_var( $settings['use_first_text_image'], FILTER_VALIDATE_BOOLEAN ) ) {
                $first_classes_array[] = 'headline__part--image-text';
            }

            $first_classes = implode( ' ', $first_classes_array );

            $first_part = sprintf( '<span class="%1$s">%2$s<span class="novaworks-headline__label">%3$s</span></span>%4$s', $first_classes, $before_deco_html, $settings['first_part'], $space );
        }

        if ( ! empty( $settings['second_part'] ) ) {
            $second_classes_array = array( 'novaworks-headline__part', 'novaworks-headline__second' );

            if ( filter_var( $settings['use_second_text_image'], FILTER_VALIDATE_BOOLEAN ) ) {
                $second_classes_array[] = 'headline__part--image-text';
            }

            $second_classes = implode( ' ', $second_classes_array );

            $second_part = sprintf( '<span class="%1$s"><span class="novaworks-headline__label">%2$s</span>%3$s</span>', $second_classes, $settings['second_part'], $after_deco_html );
        }

        $deco_devider_left = '';
        $deco_devider_right = '';

        if ( filter_var( $settings['use_divider_deco'], FILTER_VALIDATE_BOOLEAN ) ) {

            if ( filter_var( $settings['use_divider_deco_left'], FILTER_VALIDATE_BOOLEAN ) ) {
                $deco_devider_left ='<span class="novaworks-headline__divider novaworks-headline__left-divider"></span>';
            }

            if ( filter_var( $settings['use_divider_deco_right'], FILTER_VALIDATE_BOOLEAN ) ) {
                $deco_devider_right ='<span class="novaworks-headline__divider novaworks-headline__right-divider"></span>';
            }
        }

        $title = sprintf( '%1$s%2$s%3$s%4$s', $deco_devider_left, $first_part, $second_part, $deco_devider_right );

        if ( ! empty( $settings['link']['url'] ) ) {
            $this->add_render_attribute( 'url', 'href', $settings['link']['url'] );

            if ( $settings['link']['is_external'] ) {
                $this->add_render_attribute( 'url', 'target', '_blank' );
            }

            if ( ! empty( $settings['link']['nofollow'] ) ) {
                $this->add_render_attribute( 'url', 'rel', 'nofollow' );
            }

            $title = sprintf( '<a class="novaworks-headline__link" %1$s>%2$s</a>', $this->get_render_attribute_string( 'url' ), $title );
        }

        $title_html = sprintf( '<%1$s class="%2$s">%3$s</%1$s>', $settings['header_size'], $heading_classes, $title );

        echo $title_html;
    }

}
