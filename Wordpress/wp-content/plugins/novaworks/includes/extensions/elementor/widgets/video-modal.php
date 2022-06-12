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
class Video_Modal extends NOVA_Widget_Base {

    public function __construct($data = [], $args = null) {

        parent::__construct($data, $args);
    }
    public function get_script_depends() {
        return [
            'fancybox',
            'novaworks-video-modal-elm'
        ];
    }
    public function get_style_depends() {
        return [
            'fancybox',
            'novaworks-video-modal-elm'
        ];
    }
    public function get_name() {
        return 'novaworks-video-modal';
    }

    protected function get_widget_title() {
        return esc_html__( 'Video Modal', 'novaworks' );
    }

    public function get_icon() {
        return 'nova-elements-icon-41';
    }
    protected function _register_controls() {
      $css_scheme = apply_filters(
          'NovaworksElement/video-modal/css-scheme',
          array(
              'icon_play'   => '.nova-video-modal .video-modal-btn',
              'icon_play_hover'   => '.nova-video-modal .video-modal-btn:hover',
          )
      );
      $this->start_controls_section(
          'section_video_content',
          array(
              'label'      => esc_html__( 'Video', 'nova-elements' ),
              'tab'        => Controls_Manager::TAB_CONTENT,
              'show_label' => false,
          )
      );
      $this->add_control(
          'video_url',
          array(
              'label'   => esc_html__( 'Video Url', 'nova-elements' ),
              'type'    => Controls_Manager::URL,
              'dynamic' => array( 'active' => true ),
          )
      );

      $this->add_control(
          'play_icon',
          array(
              'label'       => esc_html__( 'Play Icon', 'novaworks' ),
              'type' => Controls_Manager::ICONS,
              'fa4compatibility' => 'icon',
              'default' => [
                  'value' => 'fas fa-play',
                  'library' => 'fa-solid',
              ]
          )
      );

      $this->end_controls_section();

      $this->start_controls_section(
          'section_icon_style',
          array(
              'label'      => esc_html__( 'Icon Play', 'nova-elements' ),
              'tab'        => Controls_Manager::TAB_STYLE,
              'show_label' => false,
          )
      );
      $this->add_control(
          'icon_play_color',
          array(
              'label' => esc_html__( 'Icon Color', 'novaworks' ),
              'type' => Controls_Manager::COLOR,
              'selectors' => array(
                  '{{WRAPPER}} ' . $css_scheme['icon_play'] => 'color: {{VALUE}}',
              ),
          )
      );
      $this->add_control(
          'icon_play_hover_color',
          array(
              'label' => esc_html__( 'Icon Hover Color', 'novaworks' ),
              'type' => Controls_Manager::COLOR,
              'selectors' => array(
                  '{{WRAPPER}} ' . $css_scheme['icon_play_hover']  => 'color: {{VALUE}}',
              ),
          )
      );
      $this->add_control(
          'button_icon_size',
          array(
              'label' => esc_html__( 'Icon Size', 'novaworks' ),
              'type' => Controls_Manager::SLIDER,
              'range' => array(
                  'px' => array(
                      'min' => 7,
                      'max' => 90,
                  ),
              ),
              'selectors' => array(
                  '{{WRAPPER}} ' . $css_scheme['icon_play'] => 'font-size: {{SIZE}}{{UNIT}};',
              ),
          )
      );
      $this->end_controls_section();
    }
    /**
     * [render description]
     * @return [type] [description]
     */
     protected function render() {
         $this->__context 	= 'render';
 				$video_url 				= $this->get_settings_for_display( 'video_url' );
 				$video_icon 				= $this->get_settings_for_display( 'play_icon' );
        ob_start();
        Icons_Manager::render_icon($video_icon,[ 'aria-hidden' => 'true' ]);
        $play_icon = ob_get_clean();
        if($video_url['url']) {
          echo '<div class="nova-video-modal"><a href="'.$video_url['url'].'" class="js-video-modal video-modal-btn">'.$play_icon.'</a></div>';
        }
     }

}
