<?php
namespace Novaworks_Element\Widgets;

if (!defined('WPINC')) {
    die;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;


/**
 * Business_Hours Widget
 */
class Business_Hours extends NOVA_Widget_Base {

    public $__processed_item_index = 0;

    public function get_name() {
        return 'novaworks-business-hours';
    }

    protected function get_widget_title() {
        return esc_html__( 'Business Hours', 'novaworks' );
    }

    public function get_icon() {
        return 'nova-elements-icon-39';
    }

    public function get_style_depends() {
        return ['novaworks-business-hours-elm'];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'section_general',
            array(
                'label'      => esc_html__( 'General', 'novaworks' ),
                'tab'        => Controls_Manager::TAB_CONTENT,
                'show_label' => false,
            )
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_date',
            array(
                'label'   => esc_html__( 'Day', 'novaworks' ),
                'type'    => Controls_Manager::TEXT,
                'dynamic' => array( 'active' => true ),
            )
        );

        $repeater->add_control(
            'item_hours',
            array(
                'label'   => esc_html__( 'Time', 'novaworks' ),
                'type'    => Controls_Manager::TEXT,
                'dynamic' => array( 'active' => true ),
            )
        );

        $this->add_control(
            'business_hours',
            array(
                'type'        => Controls_Manager::REPEATER,
                'fields'      => array_values( $repeater->get_controls() ),
                'default'     => array(
                    array(
                        'item_date' => esc_html__( 'Monday', 'novaworks' ),
                        'item_hours' => esc_html__( '09:00 - 19:00', 'novaworks' ),
                    ),
                    array(
                        'item_date' => esc_html__( 'Tuesday', 'novaworks' ),
                        'item_hours' => esc_html__( '09:00 - 19:00', 'novaworks' ),
                    ),
                    array(
                        'item_date' => esc_html__( 'Wednesday:', 'novaworks' ),
                        'item_hours' => esc_html__( '09:00 - 19:00', 'novaworks' ),
                    ),
                    array(
                        'item_date' => esc_html__( 'Thursday:', 'novaworks' ),
                        'item_hours' => esc_html__( '09:00 - 19:00', 'novaworks' ),
                    ),
                    array(
                        'item_date' => esc_html__( 'Friday:', 'novaworks' ),
                        'item_hours' => esc_html__( '09:00 - 19:00', 'novaworks' ),
                    ),
                    array(
                        'item_date' => esc_html__( 'Saturday:', 'novaworks' ),
                        'item_hours' => esc_html__( '09:00 - 19:00', 'novaworks' ),
                    ),
                    array(
                        'item_date' => esc_html__( 'Sunday:', 'novaworks' ),
                        'item_hours' => esc_html__( 'Closed', 'novaworks' ),
                    ),
                ),
                'title_field' => '{{{ item_date }}}',
            )
        );

        $this->end_controls_section();


    }

    protected function render() {
        $this->__context = 'render';

        $this->__open_wrap();
        include $this->__get_global_template( 'index' );
        $this->__close_wrap();

        $this->__processed_item_index = 0;
    }

}
