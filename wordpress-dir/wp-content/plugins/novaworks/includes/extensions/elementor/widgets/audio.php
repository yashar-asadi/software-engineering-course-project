<?php
namespace Novaworks_Element\Widgets;

if (!defined('WPINC')) {
    die;
}

// Elementor Classes
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;
use Elementor\Modules\DynamicTags\Module as TagsModule;

/**
 * Audio Widget
 */
class Audio extends NOVA_Widget_Base {
    public function get_name() {
        return 'novaworks-audio';
    }

    protected function get_widget_title() {
        return esc_html__( 'Audio Player', 'novaworks' );
    }

    public function get_icon() {
        return 'nova-elements-icon-40';
    }

    public function get_script_depends() {
        return [
            'mediaelement',
            'novaworks-audio-elm'
        ];
    }

    public function get_style_depends() {
        return [
            'mediaelement',
            'novaworks-audio-elm'
        ];
    }

    protected function _register_controls() {
        $css_scheme = apply_filters(
            'NovaworksElement/audio/css-scheme',
            array(
                'play_pause_btn_wrap' => '.novaworks-audio .mejs-playpause-button',
                'play_pause_btn'      => '.novaworks-audio .mejs-playpause-button > button',
                'time'                => '.novaworks-audio .mejs-time',
                'current_time'        => '.novaworks-audio .mejs-currenttime',
                'duration_time'       => '.novaworks-audio .mejs-duration',
                'rail_progress'       => '.novaworks-audio .mejs-time-rail',
                'total_progress'      => '.novaworks-audio .mejs-time-total',
                'current_progress'    => '.novaworks-audio .mejs-time-current',
                'volume_btn_wrap'     => '.novaworks-audio .mejs-volume-button',
                'volume_btn'          => '.novaworks-audio .mejs-volume-button > button',
                'volume_slider_hor'   => '.novaworks-audio .mejs-horizontal-volume-slider',
                'total_volume_hor'    => '.novaworks-audio .mejs-horizontal-volume-total',
                'current_volume_hor'  => '.novaworks-audio .mejs-horizontal-volume-current',
                'total_volume_vert'   => '.novaworks-audio .mejs-volume-total',
                'current_volume_vert' => '.novaworks-audio .mejs-volume-current',
                'volume_slider_vert'  => '.novaworks-audio .mejs-volume-slider',
                'volume_handle_vert'  => '.novaworks-audio .mejs-volume-handle',
            )
        );

        /**
         * `Audio` Section
         */
        $this->start_controls_section(
            'section_audio',
            array(
                'label' => esc_html__( 'Audio', 'novaworks' ),
            )
        );

        $this->add_control(
            'audio_source',
            array(
                'label'   => esc_html__( 'Audio Source', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'self',
                'options' => array(
                    'self'     => esc_html__( 'Self Hosted', 'novaworks' ),
                    'external' => esc_html__( 'External', 'novaworks' ),
                ),
            )
        );

        $this->add_control(
            'self_url',
            array(
                'label' => esc_html__( 'URL', 'novaworks' ),
                'type'  => Controls_Manager::MEDIA,
                'media_type' => 'audio',
                'condition' => array(
                    'audio_source' => 'self',
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

        $this->add_control(
            'external_url',
            array(
                'label'       => esc_html__( 'URL', 'novaworks' ),
                'label_block' => true,
                'type'        => Controls_Manager::TEXT,
                'placeholder' => esc_html__( 'Enter your URL', 'novaworks' ),
                'condition' => array(
                    'audio_source' => 'external',
                ),
            )
        );

        $this->add_control(
            'audio_support_desc',
            array(
                'type' => Controls_Manager::RAW_HTML,
                'raw'  => esc_html__( 'Audio Player support MP3 audio format', 'novaworks' ),
                'content_classes' => 'elementor-descriptor',
            )
        );

        $this->add_control(
            'audio_options_heading',
            array(
                'label' => esc_html__( 'Audio Options', 'novaworks' ),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'loop',
            array(
                'label' => esc_html__( 'Loop', 'novaworks' ),
                'type'  => Controls_Manager::SWITCHER,
            )
        );

        $this->add_control(
            'muted',
            array(
                'label' => esc_html__( 'Muted', 'novaworks' ),
                'type'  => Controls_Manager::SWITCHER,
            )
        );

        $this->add_control(
            'audio_controls_options_heading',
            array(
                'label' => esc_html__( 'Controls Options', 'novaworks' ),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_control(
            'progress',
            array(
                'label'   => esc_html__( 'Progress Bar', 'novaworks' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'current',
            array(
                'label'   => esc_html__( 'Current Time', 'novaworks' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'duration',
            array(
                'label'   => esc_html__( 'Duration Time', 'novaworks' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'volume',
            array(
                'label'   => esc_html__( 'Volume', 'novaworks' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
            )
        );

        $this->add_control(
            'hide_volume_on_touch_devices',
            array(
                'label'   => esc_html__( 'Hide Volume On Touch Devices', 'novaworks' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->add_control(
            'volume_bar',
            array(
                'label'   => esc_html__( 'Volume Bar', 'novaworks' ),
                'type'    => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'render_type' => 'template',
                'selectors_dictionary' => array(
                    '' => 'display: none !important;',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .novaworks-audio .mejs-volume-slider' => '{{VALUE}}',
                    '{{WRAPPER}} .novaworks-audio .mejs-horizontal-volume-slider' => '{{VALUE}}',
                ),
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->add_control(
            'volume_bar_layout',
            array(
                'label'   => esc_html__( 'Volume Bar Layout', 'novaworks' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'horizontal',
                'options' => array(
                    'horizontal' => esc_html__( 'Horizontal', 'novaworks' ),
                    'vertical'   => esc_html__( 'Vertical', 'novaworks' ),
                ),
                'condition' => array(
                    'volume'     => 'yes',
                    'volume_bar' => 'yes',
                ),
            )
        );

        $this->add_control(
            'start_volume',
            array(
                'label'       => esc_html__( 'Start Volume', 'novaworks' ),
                'description' => esc_html__( 'Initial volume when the player starts. Override by user cookie.', 'novaworks' ),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => array( '%' ),
                'range' => array(
                    '%' => array(
                        'min'  => 0,
                        'max'  => 1,
                        'step' => 0.1,
                    ),
                ),
                'default' => array(
                    'unit' => '%',
                    'size' => 0.8,
                ),
            )
        );

        $this->end_controls_section();

        /**
         * `General` Style Section
         */
        $this->start_controls_section(
            'section_general_style',
            array(
                'label' => esc_html__( 'General', 'novaworks' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_responsive_control(
            'width',
            array(
                'label' => esc_html__( 'Width', 'novaworks' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => array( 'px', '%' ),
                'range' => array(
                    'px' => array(
                        'min' => 100,
                        'max' => 1200,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-widget-container' => 'max-width: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'align',
            array(
                'label'   => esc_html__( 'Alignment', 'novaworks' ),
                'type'    => Controls_Manager::CHOOSE,
                'options' => array(
                    'left' => array(
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
                'selectors_dictionary' => array(
                    'left'   => 'margin-left: 0; margin-right: auto;',
                    'center' => 'margin-left: auto; margin-right: auto;',
                    'right'  => 'margin-left: auto; margin-right: 0;',
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-widget-container' => '{{VALUE}}',
                ),
            )
        );

        $this->end_controls_section();

        /**
         * `Play-Pause Button and Time` Style Section
         */
        $this->start_controls_section(
            'section_play_button_and_time_style',
            array(
                'label' => esc_html__( 'Play-Pause Button and Time', 'novaworks' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            )
        );

        $this->add_control(
            'play_pause_button_heading',
            array(
                'label' => esc_html__( 'Play-Pause Button', 'novaworks' ),
                'type'  => Controls_Manager::HEADING,
            )
        );

        $this->add_control(
            'play_pause_button_font_size',
            array(
                'label' => esc_html__( 'Font size', 'novaworks' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => array( 'px', 'em' ),
                'range' => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['play_pause_btn'] => 'font-size: {{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->start_controls_tabs( 'play_pause_button_style' );

        $this->start_controls_tab(
            'play_pause_button_normal_style',
            array(
                'label' => esc_html__( 'Normal', 'novaworks' ),
            )
        );

        $this->add_control(
            'play_pause_button_color',
            array(
                'label' => esc_html__( 'Color', 'novaworks' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['play_pause_btn'] => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'play_pause_button_bg_color',
            array(
                'label' => esc_html__( 'Background color', 'novaworks' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['play_pause_btn'] => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'play_pause_button_hover_style',
            array(
                'label' => esc_html__( 'Hover', 'novaworks' ),
            )
        );

        $this->add_control(
            'play_pause_button_hover_color',
            array(
                'label' => esc_html__( 'Color', 'novaworks' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['play_pause_btn'] . ':hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'play_pause_button_hover_bg_color',
            array(
                'label' => esc_html__( 'Background color', 'novaworks' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['play_pause_btn'] . ':hover' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->add_control(
            'play_pause_button_hover_border_color',
            array(
                'label' => esc_html__( 'Border Color', 'novaworks' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['play_pause_btn'] . ':hover' => 'border-color: {{VALUE}};',
                ),
                'condition' => array(
                    'play_pause_button_border_border!' => '',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'play_pause_button_padding',
            array(
                'label'      => esc_html__( 'Padding', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['play_pause_btn'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'before',
            )
        );

        $this->add_responsive_control(
            'play_pause_button_margin',
            array(
                'label'      => esc_html__( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['play_pause_btn_wrap'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_control(
            'play_pause_button_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['play_pause_btn'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'     => 'play_pause_button_border',
                'selector' => '{{WRAPPER}} ' . $css_scheme['play_pause_btn'],
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'play_pause_button_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['play_pause_btn'],
            )
        );

        $this->add_control(
            'time_heading',
            array(
                'label'     => esc_html__( 'Time', 'novaworks' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            )
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            array(
                'name'     => 'time_typography',
                'selector' => '{{WRAPPER}} ' . $css_scheme['time'],
            )
        );

        $this->add_control(
            'time_color',
            array(
                'label' => esc_html__( 'Color', 'novaworks' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['time'] => 'color: {{VALUE}};',
                ),
            )
        );

        $this->add_responsive_control(
            'current_time_margin',
            array(
                'label'      => esc_html__( 'Current Time Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['current_time'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->add_responsive_control(
            'duration_time_margin',
            array(
                'label'      => esc_html__( 'Duration Time Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['duration_time'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_progress_style',
            array(
                'label' => esc_html__( 'Progress', 'novaworks' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'progress' => 'yes',
                ),
            )
        );

        $this->add_control(
            'total_progress_heading',
            array(
                'label'     => esc_html__( 'Total Progress Bar', 'novaworks' ),
                'type'      => Controls_Manager::HEADING,
                'condition' => array(
                    'progress' => 'yes',
                ),
            )
        );

        $this->add_control(
            'total_progress_height',
            array(
                'label' => esc_html__( 'Height', 'novaworks' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['total_progress'] => 'height: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'progress' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'total_progress_background',
                'selector' => '{{WRAPPER}} ' . $css_scheme['total_progress'],
                'condition' => array(
                    'progress' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'     => 'total_progress_border',
                'selector' => '{{WRAPPER}} ' . $css_scheme['total_progress'],
                'condition' => array(
                    'progress' => 'yes',
                ),
            )
        );

        $this->add_control(
            'total_progress_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['total_progress'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'condition' => array(
                    'progress' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'rail_progress_margin',
            array(
                'label'      => esc_html__( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['rail_progress'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'condition' => array(
                    'progress' => 'yes',
                ),
            )
        );

        $this->add_control(
            'current_progress_heading',
            array(
                'label'     => esc_html__( 'Current Progress Bar', 'novaworks' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'progress' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'current_progress_background',
                'selector' => '{{WRAPPER}} ' . $css_scheme['current_progress'],
                'condition' => array(
                    'progress' => 'yes',
                ),
            )
        );

        $this->add_control(
            'current_progress_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['current_progress'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'condition' => array(
                    'progress' => 'yes',
                ),
            )
        );

        $this->end_controls_section();

        /**
         * `Volume` Style Section
         */
        $this->start_controls_section(
            'section_volume_style',
            array(
                'label' => esc_html__( 'Volume', 'novaworks' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->add_control(
            'volume_button_style_heading',
            array(
                'label' => esc_html__( 'Volume Button', 'novaworks' ),
                'type'  => Controls_Manager::HEADING,
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->add_control(
            'volume_button_font_size',
            array(
                'label' => esc_html__( 'Font size', 'novaworks' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => array( 'px', 'em' ),
                'range' => array(
                    'px' => array(
                        'min' => 1,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['volume_btn'] => 'font-size: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->start_controls_tabs( 'volume_button_style' );

        $this->start_controls_tab(
            'volume_button_normal_style',
            array(
                'label' => esc_html__( 'Normal', 'novaworks' ),
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->add_control(
            'volume_button_color',
            array(
                'label' => esc_html__( 'Color', 'novaworks' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['volume_btn'] => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->add_control(
            'volume_button_bg_color',
            array(
                'label' => esc_html__( 'Background color', 'novaworks' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['volume_btn'] => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'volume_button_hover_style',
            array(
                'label' => esc_html__( 'Hover', 'novaworks' ),
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->add_control(
            'volume_button_hover_color',
            array(
                'label' => esc_html__( 'Color', 'novaworks' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['volume_btn'] . ':hover' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->add_control(
            'volume_button_hover_bg_color',
            array(
                'label' => esc_html__( 'Background color', 'novaworks' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['volume_btn'] . ':hover' => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->add_control(
            'volume_button_hover_border_color',
            array(
                'label' => esc_html__( 'Border Color', 'novaworks' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['volume_btn'] . ':hover' => 'border-color: {{VALUE}};',
                ),
                'condition' => array(
                    'volume_button_border_border!' => '',
                    'volume' => 'yes',
                ),
            )
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'volume_button_padding',
            array(
                'label'      => esc_html__( 'Padding', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['volume_btn'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'separator' => 'before',
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->add_responsive_control(
            'volume_button_margin',
            array(
                'label'      => esc_html__( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['volume_btn_wrap'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->add_control(
            'volume_button_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['volume_btn'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'     => 'volume_button_border',
                'selector' => '{{WRAPPER}} ' . $css_scheme['volume_btn'],
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            array(
                'name'     => 'volume_button_box_shadow',
                'selector' => '{{WRAPPER}} ' . $css_scheme['volume_btn'],
                'condition' => array(
                    'volume' => 'yes',
                ),
            )
        );

        $this->add_control(
            'volume_slider_style_heading',
            array(
                'label' => esc_html__( 'Volume Slider', 'novaworks' ),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'volume' => 'yes',
                    'volume_bar' => 'yes',
                ),
            )
        );

        $this->add_control(
            'volume_slider_bg_color',
            array(
                'label' => esc_html__( 'Background color', 'novaworks' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['volume_slider_vert'] => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'volume' => 'yes',
                    'volume_bar' => 'yes',
                    'volume_bar_layout' => 'vertical',
                ),
            )
        );

        $this->add_responsive_control(
            'volume_slider_margin',
            array(
                'label'      => esc_html__( 'Margin', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['volume_slider_hor'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'condition' => array(
                    'volume' => 'yes',
                    'volume_bar' => 'yes',
                    'volume_bar_layout' => 'horizontal',
                ),
            )
        );

        $this->add_control(
            'total_volume_bar_style_heading',
            array(
                'label' => esc_html__( 'Total Volume Bar', 'novaworks' ),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'volume' => 'yes',
                    'volume_bar' => 'yes',
                ),
            )
        );

        $this->add_control(
            'total_volume_hor_width',
            array(
                'label' => esc_html__( 'Width', 'novaworks' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 100,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['total_volume_hor'] => 'width: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'volume' => 'yes',
                    'volume_bar' => 'yes',
                    'volume_bar_layout' => 'horizontal',
                ),
            )
        );

        $this->add_control(
            'total_volume_hor_height',
            array(
                'label' => esc_html__( 'Height', 'novaworks' ),
                'type'  => Controls_Manager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 50,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['total_volume_hor'] => 'height: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'volume' => 'yes',
                    'volume_bar' => 'yes',
                    'volume_bar_layout' => 'horizontal',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'total_volume_background',
                'selector' => '{{WRAPPER}} ' . $css_scheme['total_volume_hor'] . ', {{WRAPPER}} ' . $css_scheme['total_volume_vert'],
                'condition' => array(
                    'volume' => 'yes',
                    'volume_bar' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            array(
                'name'     => 'total_volume_border',
                'selector' => '{{WRAPPER}} ' . $css_scheme['total_volume_hor'],
                'condition' => array(
                    'volume' => 'yes',
                    'volume_bar' => 'yes',
                    'volume_bar_layout' => 'horizontal',
                ),
            )
        );

        $this->add_control(
            'total_volume_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['total_volume_hor'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'condition' => array(
                    'volume' => 'yes',
                    'volume_bar' => 'yes',
                    'volume_bar_layout' => 'horizontal',
                ),
            )
        );

        $this->add_control(
            'current_volume_heading',
            array(
                'label'     => esc_html__( 'Current Volume Bar', 'novaworks' ),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'volume' => 'yes',
                    'volume_bar' => 'yes',
                ),
            )
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            array(
                'name'     => 'current_volume_background',
                'selector' => '{{WRAPPER}} ' . $css_scheme['current_volume_hor'] . ', {{WRAPPER}} ' . $css_scheme['current_volume_vert'],
                'condition' => array(
                    'volume' => 'yes',
                    'volume_bar' => 'yes',
                ),
            )
        );

        $this->add_control(
            'current_volume_border_radius',
            array(
                'label'      => esc_html__( 'Border Radius', 'novaworks' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => array( 'px', '%' ),
                'selectors'  => array(
                    '{{WRAPPER}} ' . $css_scheme['current_volume_hor'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
                'condition' => array(
                    'volume' => 'yes',
                    'volume_bar' => 'yes',
                    'volume_bar_layout' => 'horizontal',
                ),
            )
        );

        $this->add_control(
            'volume_handle_style_heading',
            array(
                'label' => esc_html__( 'Volume Handle', 'novaworks' ),
                'type'  => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'volume' => 'yes',
                    'volume_bar' => 'yes',
                    'volume_bar_layout' => 'vertical',
                ),
            )
        );

        $this->add_control(
            'volume_handle_bg_color',
            array(
                'label' => esc_html__( 'Background color', 'novaworks' ),
                'type'  => Controls_Manager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} ' . $css_scheme['volume_handle_vert'] => 'background-color: {{VALUE}};',
                ),
                'condition' => array(
                    'volume' => 'yes',
                    'volume_bar' => 'yes',
                    'volume_bar_layout' => 'vertical',
                ),
            )
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings     = $this->get_settings_for_display();
        $audio_url    = '';
        $audio_source = $settings['audio_source'];

        switch ( $audio_source ) :
            case 'self':
                $audio_url = $settings['self_url']['url'];
                break;

            case 'external':
                $audio_url = $settings['external_url'];
                break;

        endswitch;

        if ( empty( $audio_url ) ) {
            return;
        }

        $controls = array( 'playpause' );
        $available_controls = array( 'current', 'progress', 'duration', 'volume' );

        foreach ( $available_controls as $control ) {
            if ( isset( $settings[ $control ] ) && filter_var( $settings[ $control ], FILTER_VALIDATE_BOOLEAN ) ) {
                $controls[] = $control;
            }
        }

        $data_settings = array();
        $data_settings['controls'] = $controls;

        if ( ! empty( $settings['volume_bar_layout'] ) ) {
            $data_settings['audioVolume'] = $settings['volume_bar_layout'];
        }

        if ( ! empty( $settings['start_volume']['size'] ) ) {
            $data_settings['startVolume'] = ( abs( $settings['start_volume']['size'] ) > 1 ) ? 1 : abs( $settings['start_volume']['size'] );
        }

        $data_settings['hideVolumeOnTouchDevices'] = isset( $settings['hide_volume_on_touch_devices'] ) ? filter_var( $settings['hide_volume_on_touch_devices'], FILTER_VALIDATE_BOOLEAN ) : true;

        $this->add_render_attribute(
            'wrapper',
            array(
                'class'         => 'novaworks-audio',
                'data-settings' => esc_attr( json_encode( $data_settings ) ),
            )
        );

        $this->add_render_attribute(
            'player',
            array(
                'class'    => 'novaworks-audio-player',
                'preload'  => 'none',
                'controls' => '',
                'src'      => esc_url( $audio_url ),
                'width'    => '100%',
            )
        );

        if ( isset( $settings['loop'] ) && filter_var( $settings['loop'], FILTER_VALIDATE_BOOLEAN ) ) {
            $this->add_render_attribute( 'player', 'loop', '' );
        }

        if ( isset( $settings['muted'] ) && filter_var( $settings['muted'], FILTER_VALIDATE_BOOLEAN ) ) {
            $this->add_render_attribute( 'player', 'muted', '' );
        }

        $this->__open_wrap();
        ?>

        <div <?php $this->print_render_attribute_string( 'wrapper' ); ?>>
            <audio <?php $this->print_render_attribute_string( 'player' ); ?>></audio>
        </div>

        <?php
        $this->__close_wrap();
    }
}