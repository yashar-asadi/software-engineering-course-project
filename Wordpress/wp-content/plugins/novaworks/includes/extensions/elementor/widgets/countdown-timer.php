<?php
namespace Novaworks_Element\Widgets;

if (!defined('WPINC')) {
    die;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;


use Elementor\Utils;

/**
 * Countdown_Timer Widget
 */
class Countdown_Timer extends NOVA_Widget_Base {

    public function __construct($data = [], $args = null) {

        $this->add_style_depends( $this->get_name() . '-elm' );

        parent::__construct($data, $args);
    }
    public function get_script_depends() {
        return [
            'novaworks-countdown-timer-elm'
        ];
    }
    public function get_name() {
        return 'novaworks-countdown-timer';
    }

    protected function get_widget_title() {
        return esc_html__( 'Countdown Timer', 'novaworks' );
    }

    public function get_icon() {
        return 'nova-elements-icon-9';
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_general',
            array(
                'label' => esc_html__( 'General', 'novaworks' ),
            )
        );

        $default_date = date(
            'Y-m-d H:i', strtotime( '+1 month' ) + ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS )
        );

        $this->add_control(
            'due_date',
            array(
                'label'       => esc_html__( 'Due Date', 'novaworks' ),
                'type'        => Controls_Manager::DATE_TIME,
                'default'     => $default_date,
                'description' => sprintf(
                    esc_html__( 'Date set according to your timezone: %s.', 'novaworks' ),
                    Utils::get_timezone_string()
                ),
            )
        );

        $this->add_control(
            'show_days',
            array(
                'label'        => esc_html__( 'Days', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'novaworks' ),
                'label_off'    => esc_html__( 'Hide', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'label_days',
            array(
                'label'       => esc_html__( 'Days Label', 'novaworks' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Days', 'novaworks' ),
                'placeholder' => esc_html__( 'Days', 'novaworks' ),
                'condition'   => array(
                    'show_days'      => 'yes',
                ),
            )
        );

        $this->add_control(
            'show_hours',
            array(
                'label'        => esc_html__( 'Hours', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'novaworks' ),
                'label_off'    => esc_html__( 'Hide', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'label_hours',
            array(
                'label'       => esc_html__( 'Hours Label', 'novaworks' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Hours', 'novaworks' ),
                'placeholder' => esc_html__( 'Hours', 'novaworks' ),
                'condition'   => array(
                    'show_hours'      => 'yes',
                ),
            )
        );

        $this->add_control(
            'show_min',
            array(
                'label'        => esc_html__( 'Minutes', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'novaworks' ),
                'label_off'    => esc_html__( 'Hide', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'label_min',
            array(
                'label'       => esc_html__( 'Minutes Label', 'novaworks' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Minutes', 'novaworks' ),
                'placeholder' => esc_html__( 'Minutes', 'novaworks' ),
                'condition'   => array(
                    'show_min'      => 'yes',
                ),
            )
        );

        $this->add_control(
            'show_sec',
            array(
                'label'        => esc_html__( 'Seconds', 'novaworks' ),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => esc_html__( 'Show', 'novaworks' ),
                'label_off'    => esc_html__( 'Hide', 'novaworks' ),
                'return_value' => 'yes',
                'default'      => 'yes',
            )
        );

        $this->add_control(
            'label_sec',
            array(
                'label'       => esc_html__( 'Seconds Label', 'novaworks' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__( 'Seconds', 'novaworks' ),
                'placeholder' => esc_html__( 'Seconds', 'novaworks' ),
                'condition'   => array(
                    'show_sec'      => 'yes',
                ),
            )
        );

        $this->add_control(
            'blocks_sep',
            array(
                'label'       => esc_html__( 'Blocks Separator', 'novaworks' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => '',
                'placeholder' => ':',
            )
        );

        $this->end_controls_section();

        $css_scheme = apply_filters(
            'NovaworksElement/novaworks-countdown-timer/css-scheme',
            array(
                'container'  => '.novaworks-countdown-timer',
                'item'  => '.novaworks-countdown-timer__item',
                'label' => '.novaworks-countdown-timer__item-label',
                'value' => '.novaworks-countdown-timer__item-value',
                'sep'   => '.novaworks-countdown-timer__separator',
                'digit' => '.novaworks-countdown-timer__digit',
            )
        );

        $this->start_controls_section(
            'section_item_styles',
            array(
                'label'      => esc_html__( 'Item', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'items_size',
            array(
                'label'   => esc_html__( 'Items Size', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'fixed',
                'options' => array(
                    'auto'  => esc_html__( 'Auto', 'novaworks' ),
                    'fixed' => esc_html__( 'Fixed', 'novaworks' ),
                    'inline' => esc_html__( 'Inline', 'novaworks' ),
                ),
            )
        );

        $this->add_responsive_control(
            'items_size_val',
            array(
                'label'      => esc_html__( 'Width', 'novaworks' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'default'    => array(
                    'unit' => 'px',
                    'size' => 110,
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 60,
                        'max' => 600,
                    ),
                    'em' => array(
                        'min' => 1,
                        'max' => 20,
                    ),
                ),
                'render_type' => 'template',
                'condition'   => array(
                    'items_size' => 'fixed',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['item'] => 'width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'items_width_val',
            array(
                'label'      => esc_html__( 'Height', 'novaworks' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'default'    => array(
                    'unit' => 'px',
                    'size' => 110,
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 60,
                        'max' => 600,
                    ),
                    'em' => array(
                        'min' => 1,
                        'max' => 20,
                    ),
                ),
                'render_type' => 'template',
                'condition'   => array(
                    'items_size' => 'fixed',
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['item'] => 'height: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'item_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['item'],
            )
        );

        $this->add_responsive_control(
            'item_padding',
            array(
                'label'      => esc_html__( 'Item Padding', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} '  . $css_scheme['item'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'item_margin',
            array(
                'label'      => esc_html__( 'Item Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} '  . $css_scheme['item'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'border',
                'placeholder' => '1px',
                'fields_options' => array(
                    'border' => array(
                        'default' => 'solid',
                    ),
                    'width' => array(
                        'default' => array(
                            'top'      => '1',
                            'right'    => '1',
                            'bottom'   => '1',
                            'left'     => '1',
                            'isLinked' => true,
                        ),
                    ),
                ),
                'selector'    => '{{WRAPPER}} ' . $css_scheme['item'],
            )
        );

        $this->add_control(
            'item_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['item'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name' => 'item_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['item'],
            )
        );

        $this->add_responsive_control(
            'item_alignment',
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
                    '{{WRAPPER}} ' . $css_scheme['container'] => 'justify-content: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'item_text_alignment',
            array(
                'label'   => esc_html__( 'Text Alignment', 'novaworks' ),
                'type'    => Controls_Manager::CHOOSE,
                'default' => 'center',
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
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['item'] => 'text-align: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_label_styles',
            array(
                'label'      => esc_html__( 'Labels', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'label_color',
            array(
                'label'     => esc_html__( 'Color', 'novaworks' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['label'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'label_typography',

                'selector' => '{{WRAPPER}} ' . $css_scheme['label'],
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'label_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['label'],
            )
        );

        $this->add_responsive_control(
            'label_padding',
            array(
                'label'      => esc_html__( 'Padding', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} '  . $css_scheme['label'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'label_margin',
            array(
                'label'      => esc_html__( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} '  . $css_scheme['label'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'label_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['label'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name' => 'label_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['label'],
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_digit_styles',
            array(
                'label'      => esc_html__( 'Digits', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'value_color',
            array(
                'label'     => esc_html__( 'Color', 'novaworks' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['value'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'value_typography',

                'selector' => '{{WRAPPER}} ' . $css_scheme['value'],
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'value_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['value'],
            )
        );

        $this->add_responsive_control(
            'value_padding',
            array(
                'label'      => esc_html__( 'Padding', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} '  . $css_scheme['value'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'value_margin',
            array(
                'label'      => esc_html__( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} '  . $css_scheme['value'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'value_border',
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['value'],
            )
        );

        $this->add_control(
            'value_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['value'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name' => 'value_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['value'],
            )
        );

        $this->add_control(
            'digit_item_heading',
            array(
                'label'     => esc_html__( 'Digit Item Styles', 'novaworks' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'digit_bg',
                'selector' => '{{WRAPPER}} ' . $css_scheme['digit'],
            )
        );

        $this->add_responsive_control(
            'digit_padding',
            array(
                'label'      => esc_html__( 'Padding', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} '  . $css_scheme['digit'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'digit_margin',
            array(
                'label'      => esc_html__( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} '  . $css_scheme['digit'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'        => 'digit_border',
                'placeholder' => '1px',
                'selector'    => '{{WRAPPER}} ' . $css_scheme['digit'],
            )
        );

        $this->add_control(
            'digit_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['digit'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name' => 'digit_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['digit'],
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_sep_styles',
            array(
                'label'      => esc_html__( 'Separator Styles', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'sep_color',
            array(
                'label'     => esc_html__( 'Color', 'novaworks' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['sep'] => 'color: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'sep_size',
            array(
                'label'      => esc_html__( 'Size', 'novaworks' ),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%', 'em' ),
                'default'    => array(
                    'unit' => 'px',
                    'size' => 30,
                ),
                'range'      => array(
                    'px' => array(
                        'min' => 12,
                        'max' => 300,
                    ),
                    'em' => array(
                        'min' => 1,
                        'max' => 20,
                    ),
                ),
                'render_type' => 'template',
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['sep'] => 'font-size: {{SIZE}}{{UNIT}}',
                ),
            )
        );

        $this->add_control(
            'sep_font',
            array(
                'label'     => esc_html__( 'Font', 'novaworks' ),
                'type'      => Controls_Manager::FONT,
                'default'   => '',
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['sep'] => 'font-family: {{VALUE}}',
                ),
            )
        );

        $this->add_responsive_control(
            'sep_margin',
            array(
                'label'      => esc_html__( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%', 'em' ),
                'selectors'  => array(
                    '{{WRAPPER}} '  . $css_scheme['sep'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'label'      => esc_html__( 'Order', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_STYLE,
                'show_label' => false,
            )
        );

        $this->add_control(
            'value_order',
            array(
                'label'   => esc_html__( 'Digit Order', 'novaworks' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 1,
                'min'     => 1,
                'max'     => 2,
                'step'    => 1,
                'selectors' => array(
                    '{{WRAPPER}} '. $css_scheme['value'] => 'order: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'label_order',
            array(
                'label'   => esc_html__( 'Label Order', 'novaworks' ),
                'type'    => Controls_Manager::NUMBER,
                'default' => 2,
                'min'     => 1,
                'max'     => 2,
                'step'    => 1,
                'selectors' => array(
                    '{{WRAPPER}} '. $css_scheme['label'] => 'order: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_section();

    }

    public function due_date() {
        return strtotime( $this->get_settings( 'due_date' ) ) - ( get_option( 'gmt_offset' ) * HOUR_IN_SECONDS );
    }

    public function date_placeholder() {
        return '<span class="novaworks-countdown-timer__digit">0</span><span class="novaworks-countdown-timer__digit">0</span>';
    }

    /**
     * Blocks separator
     *
     * @return string
     */
    public function blocks_separator() {

        $separator = $this->get_settings( 'blocks_sep' );

        if ( ! $separator ) {
            return;
        }

        $format = apply_filters(
            'NovaworksElement/novaworks-countdown-timer/blocks-separator-format',
            '<div class="novaworks-countdown-timer__separator">%s</div>'
        );

        return sprintf( $format, $separator );
    }

    protected function render() {

        $this->__context = 'render';

        $this->__open_wrap();
        include $this->__get_global_template( 'index' );
        $this->__close_wrap();
    }

}
