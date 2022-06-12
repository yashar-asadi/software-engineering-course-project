<?php
namespace Novaworks_Element\Widgets;

if (!defined('WPINC')) {
    die;
}
use Novaworks_Element\Controls\Group_Control_Box_Style;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Repeater;



/**
 * Pricing_Table Widget
 */
class Scroll_Navigation extends NOVA_Widget_Base {

    public function get_name() {
        return 'novaworks-scroll-navigation';
    }

    protected function get_widget_title() {
        return esc_html__( 'Scroll Navigation', 'novaworks' );
    }

    public function get_icon() {
        return 'nova-elements-icon-32';
    }

    public function get_style_depends() {
        return [
            'novaworks-scroll-navigation-elm'
        ];
    }

    public function get_script_depends() {
        return [
            'novaworks-element-front',
            'novaworks-scroll-navigation-elm'
        ];
    }

    protected function _register_controls() {
        $css_scheme = apply_filters(
            'NovaworksElement/scroll-navigation/css-scheme',
            array(
                'instance' => '.novaworks-scroll-navigation',
                'item'     => '.novaworks-scroll-navigation__item',
                'hint'     => '.novaworks-scroll-navigation__item-hint',
                'icon'     => '.novaworks-scroll-navigation__icon',
                'label'    => '.novaworks-scroll-navigation__label',
                'dots'     => '.novaworks-scroll-navigation__dot',
            )
        );

        $this->start_controls_section(
            'section_items_data',
            array(
                'label' => esc_html__( 'Items', 'novaworks' ),
            )
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_icon',
            array(
                'label'       => esc_html__( 'Hint Icon', 'novaworks' ),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
                'include' => self::get_laicon_default(true),
                'options' => self::get_laicon_default()
            )
        );

        $repeater->add_control(
            'item_dot_icon',
            array(
                'label'       => esc_html__( 'Dot Icon', 'novaworks' ),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
                'include' => self::get_laicon_default(true),
                'options' => self::get_laicon_default()
            )
        );

        $repeater->add_control(
            'item_label',
            array(
                'label'   => esc_html__( 'Label', 'novaworks' ),
                'type'    => Controls_Manager::TEXT,
            )
        );

        $repeater->add_control(
            'item_section_id',
            array(
                'label'   => esc_html__( 'Section Id', 'novaworks' ),
                'type'    => Controls_Manager::TEXT,
            )
        );

        $repeater->add_control(
            'item_section_invert',
            array(
                'label'        => esc_html__( 'Invert Under This Section', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'no',
            )
        );

        $this->add_control(
            'item_list',
            array(
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => array(
                    array(
                        'item_label'      => esc_html__( 'Section 1', 'novaworks' ),
                        'item_section_id' => 'section_1',
                    ),
                    array(
                        'item_label'      => esc_html__( 'Section 2', 'novaworks' ),
                        'item_section_id' => 'section_2',
                    ),
                    array(
                        'item_label'      => esc_html__( 'Section 3', 'novaworks' ),
                        'item_section_id' => 'section_3',
                    ),
                ),
                'title_field' => '{{{ item_label }}}',
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_settings',
            array(
                'label' => esc_html__( 'Settings', 'novaworks' ),
            )
        );

        $this->add_control(
            'position',
            array(
                'label'   => esc_html__( 'Position', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'right',
                'options' => array(
                    'left'  => esc_html__( 'Left', 'novaworks' ),
                    'right' => esc_html__( 'Right', 'novaworks' ),
                ),
            )
        );

        $this->add_control(
            'speed',
            array(
                'label'   => esc_html__( 'Scroll Speed', 'novaworks' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 500,
            )
        );

        $this->add_control(
            'offset',
            array(
                'label'   => esc_html__( 'Scroll Offset', 'novaworks' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1,
            )
        );

        $this->add_control(
            'full_section_switch',
            array(
                'label'        => esc_html__( 'Full Section Switch', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Yes', 'novaworks' ),
                'label_off'    => esc_html__( 'No', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'no',
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

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'instance_background',
                'selector' => '{{WRAPPER}} ' . $css_scheme['instance'],
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'instance_border',
                'label'       => esc_html__( 'Border', 'novaworks' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'  => '{{WRAPPER}} ' . $css_scheme['instance'],
            )
        );

        $this->add_responsive_control(
            'instance_border_radius',
            array(
                'label'      => __( 'Border Radius', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['instance'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'instance_padding',
            array(
                'label'      => __( 'Padding', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['instance'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'instance_margin',
            array(
                'label'      => __( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['instance'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'instance_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['instance'],
            )
        );

        $this->end_controls_section();

        /**
         * Hint Style Section
         */
        $this->start_controls_section(
            'section_hint_style',
            array(
                'label'      => esc_html__( 'Hint', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'hint_background',
                'selector' => '{{WRAPPER}} ' . $css_scheme['hint'],
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'hint_border',
                'label'       => esc_html__( 'Border', 'novaworks' ),
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'  => '{{WRAPPER}} ' . $css_scheme['hint'],
            )
        );

        $this->add_responsive_control(
            'hint_border_radius',
            array(
                'label'      => __( 'Border Radius', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['hint'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'hint_padding',
            array(
                'label'      => __( 'Padding', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['hint'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'hint_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['hint'],
            )
        );

        $this->add_control(
            'hint_icon_style',
            array(
                'label'     => esc_html__( 'Hint Icon', 'novaworks' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'hint_icon_color',
            array(
                'label'  => esc_html__( 'Icon Color', 'novaworks' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['icon'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'hint_icon_size',
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
                    '{{WRAPPER}} ' . $css_scheme['icon'] . ' i' => 'font-size: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        $this->add_responsive_control(
            'hint_icon_margin',
            array(
                'label'      => __( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'hint_label_style',
            array(
                'label'     => esc_html__( 'Hint Label', 'novaworks' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'hint_label_color',
            array(
                'label'  => esc_html__( 'Text Color', 'novaworks' ),
                'type'   => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['label'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'hint_label_margin',
            array(
                'label'      => __( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['label'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'hint_label_padding',
            array(
                'label'      => __( 'Padding', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['label'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'hint_label_typography',

                'selector' => '{{WRAPPER}} ' . $css_scheme['label'],
            )
        );

        $this->add_control(
            'hint_visible',
            array(
                'label'     => esc_html__( 'Hint Visible', 'novaworks' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'desktop_hint_hide',
            array(
                'label'        => esc_html__( 'Hide On Desktop', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Hide', 'novaworks' ),
                'label_off'    => esc_html__( 'Show', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'no',
            )
        );

        $this->add_control(
            'tablet_hint_hide',
            array(
                'label'        => esc_html__( 'Hide On Tablet', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Hide', 'novaworks' ),
                'label_off'    => esc_html__( 'Show', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'no',
            )
        );

        $this->add_control(
            'mobile_hint_hide',
            array(
                'label'        => esc_html__( 'Hide On Mobile', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Hide', 'novaworks' ),
                'label_off'    => esc_html__( 'Show', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'no',
            )
        );

        $this->end_controls_section();

        /**
         * Dots Style Section
         */
        $this->start_controls_section(
            'section_dots_style',
            array(
                'label'      => esc_html__( 'Dots', 'novaworks' ),
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
                'selector'       => '{{WRAPPER}} ' . $css_scheme['item'] . ' ' . $css_scheme['dots'],
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_dots_invert',
            array(
                'label' => esc_html__( 'Invert', 'novaworks' ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Style::get_type(),
            array(
                'name'           => 'dots_style_invert',
                'label'          => esc_html__( 'Dots Style', 'novaworks' ),
                'selector'       => '{{WRAPPER}} ' . $css_scheme['item'] . '.invert ' . $css_scheme['dots'],
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
                'selector'       => '{{WRAPPER}} ' . $css_scheme['item'] . ':hover ' . $css_scheme['dots'],
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
                'selector'       => '{{WRAPPER}} ' . $css_scheme['item'] . '.active ' . $css_scheme['dots'],
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'dots_padding',
            array(
                'label'      => __( 'Dots Padding', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['dots'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'item_margin',
            array(
                'label'      => __( 'Dots Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['item'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

    /**
     * Generate setting json
     *
     * @return string
     */
    public function generate_setting_json() {
        $settings = $this->get_settings();

        $instance_settings = array(
            'position'      => $settings['position'],
            'speed'         => absint( $settings['speed'] ),
            'offset'        => absint( $settings['offset'] ),
            'sectionSwitch' => filter_var( $settings['full_section_switch'], FILTER_VALIDATE_BOOLEAN ),
        );

        $instance_settings = json_encode( $instance_settings );

        return sprintf( 'data-settings=\'%1$s\'', $instance_settings );
    }

}
