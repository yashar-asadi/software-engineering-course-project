<?php
namespace Novaworks_Element\Widgets;

if (!defined('WPINC')) {
    die;
}
use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;


use Elementor\Modules\DynamicTags\Module as TagsModule;


/**
 * Team_Member Widget
 */
class Team_Member extends NOVA_Widget_Base {


    public function get_name() {
        return 'novaworks-team-member';
    }

    protected function get_widget_title() {
        return esc_html__( 'Team Member', 'novaworks' );
    }

    public function get_icon() {
        return 'eicon-slider-push';
    }

	public function get_style_depends() {
        return ['novaworks-team-member-elm'];
    }
    /**
   * Retrieve the list of scripts the team member widget depended on.
   *
   * Used to set scripts dependencies required to run the widget.
   *
   * @access public
   *
   * @return array Widget scripts dependencies.
   */
    protected function _register_controls() {

        /*-----------------------------------------------------------------------------------*/
        /*	CONTENT TAB
        /*-----------------------------------------------------------------------------------*/

        /**
         * Content Tab: Image
         */
        $this->start_controls_section(
            'section_image',
            [
                'label'                 => __( 'Image', 'novaworks' ),
            ]
        );

    $this->add_control(
      'image',
      [
        'label'                 => __( 'Image', 'novaworks' ),
        'type'                  => Controls_Manager::MEDIA,
        'dynamic'               => [
          'active'   => true,
        ],
        'default'               => [
          'url' => Utils::get_placeholder_image_src(),
        ],
      ]
    );

        $this->add_group_control(
      Group_Control_Image_Size::get_type(),
      [
        'name'                  => 'image',
        'label'                 => __( 'Image Size', 'novaworks' ),
        'default'               => 'medium_large',
      ]
    );

        $this->end_controls_section();

        /**
         * Content Tab: Details
         */
        $this->start_controls_section(
            'section_details',
            [
                'label'                 => __( 'Details', 'novaworks' ),
            ]
        );

        $this->add_control(
            'team_member_name',
            [
                'label'                 => __( 'Name', 'novaworks' ),
                'type'                  => Controls_Manager::TEXT,
        'dynamic'               => [
          'active'   => true,
        ],
                'default'               => __( 'John Doe', 'novaworks' ),
            ]
        );

        $this->add_control(
            'team_member_position',
            [
                'label'                 => __( 'Position', 'novaworks' ),
                'type'                  => Controls_Manager::TEXT,
        'dynamic'               => [
          'active'   => true,
        ],
                'default'               => __( 'WordPress Developer', 'novaworks' ),
            ]
        );

        $this->add_control(
            'team_member_description_switch',
            [
                'label'                 => __( 'Show Description', 'novaworks' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'novaworks' ),
                'label_off'             => __( 'No', 'novaworks' ),
                'return_value'          => 'yes',
            ]
        );

        $this->add_control(
            'team_member_description',
            [
                'label'                 => __( 'Description', 'novaworks' ),
                'type'                  => Controls_Manager::WYSIWYG,
        'dynamic'               => [
          'active'   => true,
        ],
                'default'               => __( 'Enter member description here which describes the position of member in company', 'novaworks' ),
        'condition'             => [
          'team_member_description_switch' => 'yes',
        ],
            ]
        );

        $this->add_control(
            'link_type',
            [
                'label'                 => __( 'Link Type', 'novaworks' ),
                'type'                  => Controls_Manager::SELECT,
                'default'               => 'none',
                'options'               => [
                    'none'      => __( 'None', 'novaworks' ),
                    'image'     => __( 'Image', 'novaworks' ),
                    'title'     => __( 'Title', 'novaworks' ),
                ],
            ]
        );

        $this->add_control(
            'link',
            [
                'label'                 => __( 'Link', 'novaworks' ),
                'type'                  => Controls_Manager::URL,
        'dynamic'               => [
          'active'        => true,
                    'categories'    => [
                        TagsModule::POST_META_CATEGORY,
                        TagsModule::URL_CATEGORY
                    ],
        ],
                'placeholder'           => 'https://www.your-link.com',
                'default'               => [
                    'url' => '#',
                ],
                'condition'             => [
                    'link_type!'   => 'none',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * Content Tab: Social Links
         */
        $this->start_controls_section(
            'section_member_social_links',
            [
                'label'                 => __( 'Social Links', 'novaworks' ),
            ]
        );

        $this->add_control(
            'member_social_links',
            [
                'label'                 => __( 'Show Social Links', 'novaworks' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'yes',
                'label_on'              => __( 'Yes', 'novaworks' ),
                'label_off'             => __( 'No', 'novaworks' ),
                'return_value'          => 'yes',
            ]
        );

    $repeater = new Repeater();

    $repeater->add_control(
      'select_social_icon',
      [
        'label'					=> __( 'Social Icon', 'novaworks' ),
        'type'					=> Controls_Manager::ICONS,
        'fa4compatibility'		=> 'social_icon',
        'recommended' => [
          'fa-brands' => [
            'android',
            'apple',
            'behance',
            'bitbucket',
            'codepen',
            'delicious',
            'deviantart',
            'digg',
            'dribbble',
            'elementor',
            'facebook',
            'flickr',
            'foursquare',
            'free-code-camp',
            'github',
            'gitlab',
            'globe',
            'google-plus',
            'houzz',
            'instagram',
            'jsfiddle',
            'linkedin',
            'medium',
            'meetup',
            'mixcloud',
            'odnoklassniki',
            'pinterest',
            'product-hunt',
            'reddit',
            'shopping-cart',
            'skype',
            'slideshare',
            'snapchat',
            'soundcloud',
            'spotify',
            'stack-overflow',
            'steam',
            'stumbleupon',
            'telegram',
            'thumb-tack',
            'tripadvisor',
            'tumblr',
            'twitch',
            'twitter',
            'viber',
            'vimeo',
            'vk',
            'weibo',
            'weixin',
            'whatsapp',
            'wordpress',
            'xing',
            'yelp',
            'youtube',
            '500px',
          ],
          'fa-solid' => [
            'envelope',
            'link',
            'rss',
          ],
        ],
      ]
    );

    $repeater->add_control(
      'social_link',
      [
        'label'                 => __( 'Social Link', 'novaworks' ),
        'type'                  => Controls_Manager::URL,
        'dynamic'				=> [
          'active'  => true,
        ],
        'label_block'			=> true,
        'placeholder'			=> __( 'Enter URL', 'novaworks' ),
      ]
    );

        $this->add_control(
      'team_member_social',
      [
        'label'                 => __( 'Add Social Links', 'novaworks' ),
        'type'                  => Controls_Manager::REPEATER,
        'default'               => [
          [
            'select_social_icon' => [
              'value' => 'fab fa-facebook',
              'library' => 'fa-brands',
            ],
            'social_link' => [
                            'url' => '#',
                        ],
          ],
          [
            'select_social_icon' => [
              'value' => 'fab fa-twitter',
              'library' => 'fa-brands',
            ],
            'social_link' => [
                            'url' => '#',
                        ],
          ],
          [
            'select_social_icon' => [
              'value' => 'fab fa-youtube',
              'library' => 'fa-brands',
            ],
            'social_link' => [
                            'url' => '#',
                        ],
          ],
        ],
        'fields'				=> $repeater->get_controls(),
        'title_field' => '<# var migrated = "undefined" !== typeof __fa4_migrated, social = ( "undefined" === typeof social ) ? false : social; #>{{{ elementor.helpers.getSocialNetworkNameFromIcon( select_social_icon, social, true, migrated, true ) }}}',
        'condition'             => [
          'member_social_links' => 'yes',
        ],
      ]
    );

        $this->end_controls_section();

        /**
         * Content Tab: Settings
         */
        $this->start_controls_section(
            'section_member_box_settings',
            [
                'label'                 => __( 'Settings', 'novaworks' ),
            ]
        );

        $this->add_control(
            'name_html_tag',
            [
                'label'                => __( 'Name HTML Tag', 'novaworks' ),
                'type'                 => Controls_Manager::SELECT,
                'default'              => 'h4',
                'options'              => [
                    'h1'     => __( 'H1', 'novaworks' ),
                    'h2'     => __( 'H2', 'novaworks' ),
                    'h3'     => __( 'H3', 'novaworks' ),
                    'h4'     => __( 'H4', 'novaworks' ),
                    'h5'     => __( 'H5', 'novaworks' ),
                    'h6'     => __( 'H6', 'novaworks' ),
                    'div'    => __( 'div', 'novaworks' ),
                    'span'   => __( 'span', 'novaworks' ),
                    'p'      => __( 'p', 'novaworks' ),
                ],
            ]
        );

        $this->add_control(
            'position_html_tag',
            [
                'label'                => __( 'Position HTML Tag', 'novaworks' ),
                'type'                 => Controls_Manager::SELECT,
                'default'              => 'div',
                'options'              => [
                    'h1'     => __( 'H1', 'novaworks' ),
                    'h2'     => __( 'H2', 'novaworks' ),
                    'h3'     => __( 'H3', 'novaworks' ),
                    'h4'     => __( 'H4', 'novaworks' ),
                    'h5'     => __( 'H5', 'novaworks' ),
                    'h6'     => __( 'H6', 'novaworks' ),
                    'div'    => __( 'div', 'novaworks' ),
                    'span'   => __( 'span', 'novaworks' ),
                    'p'      => __( 'p', 'novaworks' ),
                ],
            ]
        );

        $this->add_control(
            'social_links_position',
            [
                'label'                => __( 'Social Links Position', 'novaworks' ),
                'type'                 => Controls_Manager::SELECT,
                'default'              => 'after_desc',
                'options'              => [
                    'before_desc'      => __( 'Before Description', 'novaworks' ),
                    'after_desc'       => __( 'After Description', 'novaworks' ),
                ],
        'condition'            => [
          'member_social_links' => 'yes',
          'overlay_content!' => 'social_icons',
        ],
            ]
        );

        $this->add_control(
            'overlay_content',
            [
                'label'                => __( 'Overlay Content', 'novaworks' ),
                'type'                 => Controls_Manager::SELECT,
                'default'              => 'none',
                'options'              => [
                    'none'             => __( 'None', 'novaworks' ),
                    'all'             => __( 'All', 'novaworks' ),
                    'social_icons'     => __( 'Social Icons', 'novaworks' ),
                    'all_content'      => __( 'Content + Social Icons', 'novaworks' ),
                ],
            ]
        );

        $this->add_control(
            'member_title_divider',
            [
                'label'                 => __( 'Divider after Name', 'novaworks' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'no',
                'label_on'              => __( 'Show', 'novaworks' ),
                'label_off'             => __( 'Hide', 'novaworks' ),
                'return_value'          => 'yes',
            ]
        );

        $this->add_control(
            'member_position_divider',
            [
                'label'                 => __( 'Divider after Position', 'novaworks' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'hide',
                'label_on'              => __( 'Show', 'novaworks' ),
                'label_off'             => __( 'Hide', 'novaworks' ),
                'return_value'          => 'yes',
        'condition'             => [
          'team_member_position!'  => '',
        ],
            ]
        );

        $this->add_control(
            'member_description_divider',
            [
                'label'                 => __( 'Divider after Description', 'novaworks' ),
                'type'                  => Controls_Manager::SWITCHER,
                'default'               => 'hide',
                'label_on'              => __( 'Show', 'novaworks' ),
                'label_off'             => __( 'Hide', 'novaworks' ),
                'return_value'          => 'yes',
        'condition'             => [
          'team_member_description_switch'  => 'yes',
        ],
            ]
        );

        $this->end_controls_section();

        /*-----------------------------------------------------------------------------------*/
        /*	STYLE TAB
        /*-----------------------------------------------------------------------------------*/

        /**
         * Style Tab: Content
         */
        $this->start_controls_section(
            'section_content_style',
            [
                'label'                 => __( 'Content', 'novaworks' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'member_box_alignment',
            [
                'label'                 => __( 'Alignment', 'novaworks' ),
        'type'                  => Controls_Manager::CHOOSE,
        'options'               => [
          'left'      => [
            'title' => __( 'Left', 'novaworks' ),
            'icon'  => 'fa fa-align-left',
          ],
          'center'    => [
            'title' => __( 'Center', 'novaworks' ),
            'icon'  => 'fa fa-align-center',
          ],
          'right'     => [
            'title' => __( 'Right', 'novaworks' ),
            'icon'  => 'fa fa-align-right',
          ],
        ],
        'default'               => '',
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-wrapper' => 'text-align: {{VALUE}};',
        ],
      ]
    );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'                  => 'content_background',
                'label'                 => __( 'Background', 'novaworks' ),
                'types'                 => [ 'classic','gradient' ],
                'separator'				=> 'before',
                'selector'              => '{{WRAPPER}} .nova-tm-content-normal',
            ]
        );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'                  => 'member_content_border',
        'label'                 => __( 'Border', 'novaworks' ),
        'placeholder'           => '1px',
        'default'               => '1px',
                'separator'				=> 'before',
        'selector'              => '{{WRAPPER}} .nova-tm-content',
      ]
    );

        $this->add_group_control(
      Group_Control_Box_Shadow::get_type(),
      [
        'name'                  => 'content_box_shadow',
        'selector'              => '{{WRAPPER}} .nova-tm-content',
      ]
    );

    $this->add_responsive_control(
      'member_box_content_margin',
      [
        'label'                 => __( 'Margin', 'novaworks' ),
        'type'                  => Controls_Manager::DIMENSIONS,
        'size_units'            => [ 'px', 'em', '%' ],
                'separator'				=> 'before',
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-content-normal' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'member_box_content_padding',
      [
        'label'                 => __( 'Padding', 'novaworks' ),
        'type'                  => Controls_Manager::DIMENSIONS,
        'size_units'            => [ 'px', 'em', '%' ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

        $this->end_controls_section();

        /**
         * Style Tab: Overlay
         */
        $this->start_controls_section(
            'section_member_overlay_style',
            [
                'label'                 => __( 'Overlay', 'novaworks' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
        'condition'             => [
          'overlay_content!'  => 'none',
        ],
            ]
        );

        $this->add_responsive_control(
            'overlay_alignment',
            [
                'label'                 => __( 'Alignment', 'novaworks' ),
        'type'                  => Controls_Manager::CHOOSE,
        'options'               => [
          'left'      => [
            'title' => __( 'Left', 'novaworks' ),
            'icon'  => 'fa fa-align-left',
          ],
          'center'    => [
            'title' => __( 'Center', 'novaworks' ),
            'icon'  => 'fa fa-align-center',
          ],
          'right'     => [
            'title' => __( 'Right', 'novaworks' ),
            'icon'  => 'fa fa-align-right',
          ],
        ],
        'default'               => '',
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-overlay-content-wrap' => 'text-align: {{VALUE}};',
        ],
        'condition'             => [
          'overlay_content!'  => 'none',
        ],
      ]
    );

        $this->add_group_control(
      Group_Control_Background::get_type(),
      [
        'name'                  => 'overlay_background',
        'types'                 => [ 'classic', 'gradient' ],
        'selector'              => '{{WRAPPER}} .nova-tm-overlay-content-wrap:before',
        'condition'             => [
          'overlay_content!'  => 'none',
        ],
      ]
    );

        $this->add_control(
      'overlay_opacity',
      [
        'label'                 => __( 'Opacity', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'range'                 => [
          'px' => [
                        'min'   => 0,
                        'max'   => 1,
                        'step'  => 0.1,
                    ],
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-overlay-content-wrap:before' => 'opacity: {{SIZE}};',
        ],
        'condition'             => [
          'overlay_content!'  => 'none',
        ],
      ]
    );

        $this->end_controls_section();

        /**
         * Style Tab: Image
         */
        $this->start_controls_section(
            'section_member_image_style',
            [
                'label'                 => __( 'Image', 'novaworks' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
      'member_image_width',
      [
        'label'                 => __( 'Image Width', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'size_units'            => [ '%', 'px' ],
        'range'                 => [
          'px' => [
            'max' => 1200,
          ],
        ],
        'tablet_default'        => [
          'unit' => 'px',
        ],
        'mobile_default'        => [
          'unit' => 'px',
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-image' => 'width: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'                  => 'member_image_border',
        'label'                 => __( 'Border', 'novaworks' ),
        'placeholder'           => '1px',
        'default'               => '1px',
        'selector'              => '{{WRAPPER}} .nova-tm-image img',
      ]
    );

    $this->add_control(
      'member_image_border_radius',
      [
        'label'                 => __( 'Border Radius', 'novaworks' ),
        'type'                  => Controls_Manager::DIMENSIONS,
        'size_units'            => [ 'px', '%' ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-image img, {{WRAPPER}} .nova-tm-overlay-content-wrap:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

        $this->end_controls_section();

        /**
         * Style Tab: Name
         */
        $this->start_controls_section(
            'section_member_name_style',
            [
                'label'                 => __( 'Name', 'novaworks' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'member_name_typography',
                'label'                 => __( 'Typography', 'novaworks' ),
                'selector'              => '{{WRAPPER}} .nova-tm-name',
            ]
        );

        $this->add_control(
            'member_name_text_color',
            [
                'label'                 => __( 'Text Color', 'novaworks' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .nova-tm-name' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
      'member_name_margin',
      [
        'label'                 => __( 'Margin Bottom', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'default'               => [
                    'size' => 10,
                    'unit' => 'px',
                ],
        'size_units'            => [ 'px', '%' ],
        'range'                 => [
          'px' => [
            'max' => 100,
          ],
        ],
        'tablet_default'        => [
          'unit' => 'px',
        ],
        'mobile_default'        => [
          'unit' => 'px',
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-name' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

        $this->add_control(
            'name_divider_heading',
            [
                'label'                 => __( 'Divider', 'novaworks' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
        'condition'             => [
          'member_title_divider' => 'yes',
        ],
            ]
        );

        $this->add_control(
            'name_divider_color',
            [
                'label'                 => __( 'Divider Color', 'novaworks' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .nova-tm-title-divider' => 'border-bottom-color: {{VALUE}}',
                ],
        'condition'             => [
          'member_title_divider' => 'yes',
        ],
            ]
        );

        $this->add_control(
            'name_divider_style',
            [
                'label'                => __( 'Divider Style', 'novaworks' ),
                'type'                 => Controls_Manager::SELECT,
                'default'              => 'solid',
                'options'              => [
                    'solid'     => __( 'Solid', 'novaworks' ),
                    'dotted'    => __( 'Dotted', 'novaworks' ),
                    'dashed'    => __( 'Dashed', 'novaworks' ),
                    'double'    => __( 'Double', 'novaworks' ),
                ],
                'selectors'             => [
                    '{{WRAPPER}} .nova-tm-title-divider' => 'border-bottom-style: {{VALUE}}',
                ],
        'condition'             => [
          'member_title_divider' => 'yes',
        ],
            ]
        );

        $this->add_responsive_control(
      'name_divider_width',
      [
        'label'                 => __( 'Divider Width', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'default'               => [
                    'size' => 100,
                    'unit' => 'px',
                ],
        'size_units'            => [ 'px', '%' ],
        'range'                 => [
          'px' => [
            'max' => 800,
          ],
        ],
        'tablet_default'        => [
          'unit' => 'px',
        ],
        'mobile_default'        => [
          'unit' => 'px',
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-title-divider' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'condition'             => [
          'member_title_divider' => 'yes',
        ],
      ]
    );

        $this->add_responsive_control(
      'name_divider_height',
      [
        'label'                 => __( 'Divider Height', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'default'               => [
                    'size' => 4,
                ],
        'size_units'            => [ 'px' ],
        'range'                 => [
          'px' => [
            'max' => 20,
          ],
        ],
        'tablet_default'        => [
          'unit' => 'px',
        ],
        'mobile_default'        => [
          'unit' => 'px',
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-title-divider' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
        ],
        'condition'             => [
          'member_title_divider' => 'yes',
        ],
      ]
    );

        $this->add_responsive_control(
      'name_divider_margin',
      [
        'label'                 => __( 'Margin Bottom', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'default'               => [
                    'size' => 10,
                    'unit' => 'px',
                ],
        'size_units'            => [ 'px', '%' ],
        'range'                 => [
          'px' => [
            'max' => 100,
          ],
        ],
        'tablet_default'        => [
          'unit' => 'px',
        ],
        'mobile_default'        => [
          'unit' => 'px',
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-title-divider-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
        'condition'             => [
          'member_title_divider' => 'yes',
        ],
      ]
    );

        $this->end_controls_section();

        /**
         * Style Tab: Position
         */
        $this->start_controls_section(
            'section_member_position_style',
            [
                'label'                 => __( 'Position', 'novaworks' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'member_position_typography',
                'label'                 => __( 'Typography', 'novaworks' ),
                'selector'              => '{{WRAPPER}} .nova-tm-position',
            ]
        );

        $this->add_control(
            'member_position_text_color',
            [
                'label'                 => __( 'Text Color', 'novaworks' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .nova-tm-position' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
      'member_position_margin',
      [
        'label'                 => __( 'Margin Bottom', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'default'               => [
                    'size' => 10,
                    'unit' => 'px',
                ],
        'size_units'            => [ 'px', '%' ],
        'range'                 => [
          'px' => [
            'max' => 100,
          ],
        ],
        'tablet_default'        => [
          'unit' => 'px',
        ],
        'mobile_default'        => [
          'unit' => 'px',
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-position' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

        $this->add_control(
            'position_divider_heading',
            [
                'label'                 => __( 'Divider', 'novaworks' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
        'condition'             => [
          'member_position_divider' => 'yes',
        ],
            ]
        );

        $this->add_control(
            'position_divider_color',
            [
                'label'                 => __( 'Divider Color', 'novaworks' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .nova-tm-position-divider' => 'border-bottom-color: {{VALUE}}',
                ],
        'condition'             => [
          'member_position_divider' => 'yes',
        ],
            ]
        );

        $this->add_control(
            'position_divider_style',
            [
                'label'                => __( 'Divider Style', 'novaworks' ),
                'type'                 => Controls_Manager::SELECT,
                'default'              => 'solid',
                'options'              => [
                    'solid'     => __( 'Solid', 'novaworks' ),
                    'dotted'    => __( 'Dotted', 'novaworks' ),
                    'dashed'    => __( 'Dashed', 'novaworks' ),
                    'double'    => __( 'Double', 'novaworks' ),
                ],
                'selectors'             => [
                    '{{WRAPPER}} .nova-tm-position-divider' => 'border-bottom-style: {{VALUE}}',
                ],
        'condition'             => [
          'member_position_divider' => 'yes',
        ],
            ]
        );

        $this->add_responsive_control(
      'position_divider_width',
      [
        'label'                 => __( 'Divider Width', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'default'               => [
                    'size' => 100,
                    'unit' => 'px',
                ],
        'size_units'            => [ 'px', '%' ],
        'range'                 => [
          'px' => [
            'max' => 800,
          ],
        ],
        'tablet_default'        => [
          'unit' => 'px',
        ],
        'mobile_default'        => [
          'unit' => 'px',
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-position-divider' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'condition'             => [
          'member_position_divider' => 'yes',
        ],
      ]
    );

        $this->add_responsive_control(
      'position_divider_height',
      [
        'label'                 => __( 'Divider Height', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'default'               => [
                    'size' => 4,
                ],
        'size_units'            => [ 'px' ],
        'range'                 => [
          'px' => [
            'max' => 20,
          ],
        ],
        'tablet_default'        => [
          'unit' => 'px',
        ],
        'mobile_default'        => [
          'unit' => 'px',
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-position-divider' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
        ],
        'condition'             => [
          'member_position_divider' => 'yes',
        ],
      ]
    );

        $this->add_responsive_control(
      'position_divider_margin',
      [
        'label'                 => __( 'Margin Bottom', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'default'               => [
                    'size' => 10,
                    'unit' => 'px',
                ],
        'size_units'            => [ 'px', '%' ],
        'range'                 => [
          'px' => [
            'max' => 100,
          ],
        ],
        'tablet_default'        => [
          'unit' => 'px',
        ],
        'mobile_default'        => [
          'unit' => 'px',
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-position-divider-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
        'condition'             => [
          'member_position_divider' => 'yes',
        ],
      ]
    );

        $this->end_controls_section();

        /**
         * Style Tab: Description
         */
        $this->start_controls_section(
            'section_member_description_style',
            [
                'label'                 => __( 'Description', 'novaworks' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
        'condition'             => [
          'team_member_description_switch' => 'yes',
          'team_member_description!' => '',
        ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'                  => 'member_description_typography',
                'label'                 => __( 'Typography', 'novaworks' ),
                'selector'              => '{{WRAPPER}} .nova-tm-description',
        'condition'             => [
          'team_member_description_switch' => 'yes',
          'team_member_description!' => '',
        ],
            ]
        );

        $this->add_control(
            'member_description_text_color',
            [
                'label'                 => __( 'Text Color', 'novaworks' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .nova-tm-description' => 'color: {{VALUE}}',
                ],
        'condition'             => [
          'team_member_description_switch' => 'yes',
          'team_member_description!' => '',
        ],
            ]
        );

        $this->add_responsive_control(
      'member_description_margin',
      [
        'label'                 => __( 'Margin Bottom', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'default'               => [
                    'size' => 10,
                    'unit' => 'px',
                ],
        'size_units'            => [ 'px', '%' ],
        'range'                 => [
          'px' => [
            'max' => 100,
          ],
        ],
        'tablet_default'        => [
          'unit' => 'px',
        ],
        'mobile_default'        => [
          'unit' => 'px',
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
        'condition'             => [
          'team_member_description_switch' => 'yes',
          'team_member_description!' => '',
        ],
      ]
    );

        $this->add_control(
            'description_divider_heading',
            [
                'label'                 => __( 'Divider', 'novaworks' ),
                'type'                  => Controls_Manager::HEADING,
                'separator'             => 'before',
        'condition'             => [
          'team_member_description_switch' => 'yes',
          'team_member_description!' => '',
          'member_description_divider' => 'yes',
        ],
            ]
        );

        $this->add_control(
            'description_divider_color',
            [
                'label'                 => __( 'Divider Color', 'novaworks' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .nova-tm-description-divider' => 'border-bottom-color: {{VALUE}}',
                ],
        'condition'             => [
          'team_member_description_switch' => 'yes',
          'team_member_description!' => '',
          'member_description_divider' => 'yes',
        ],
            ]
        );

        $this->add_control(
            'description_divider_style',
            [
                'label'                => __( 'Divider Style', 'novaworks' ),
                'type'                 => Controls_Manager::SELECT,
                'default'              => 'solid',
                'options'              => [
                    'solid'     => __( 'Solid', 'novaworks' ),
                    'dotted'    => __( 'Dotted', 'novaworks' ),
                    'dashed'    => __( 'Dashed', 'novaworks' ),
                    'double'    => __( 'Double', 'novaworks' ),
                ],
                'selectors'             => [
                    '{{WRAPPER}} .nova-tm-description-divider' => 'border-bottom-style: {{VALUE}}',
                ],
        'condition'             => [
          'team_member_description_switch' => 'yes',
          'team_member_description!' => '',
          'member_description_divider' => 'yes',
        ],
            ]
        );

        $this->add_responsive_control(
      'description_divider_width',
      [
        'label'                 => __( 'Divider Width', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'default'               => [
                    'size' => 100,
                    'unit' => 'px',
                ],
        'size_units'            => [ 'px', '%' ],
        'range'                 => [
          'px' => [
            'max' => 800,
          ],
        ],
        'tablet_default'        => [
          'unit' => 'px',
        ],
        'mobile_default'        => [
          'unit' => 'px',
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-description-divider' => 'width: {{SIZE}}{{UNIT}};',
        ],
        'condition'             => [
          'team_member_description_switch' => 'yes',
          'team_member_description!' => '',
          'member_description_divider' => 'yes',
        ],
      ]
    );

        $this->add_responsive_control(
      'description_divider_height',
      [
        'label'                 => __( 'Divider Height', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'default'               => [
                    'size' => 4,
                ],
        'size_units'            => [ 'px' ],
        'range'                 => [
          'px' => [
            'max' => 20,
          ],
        ],
        'tablet_default'        => [
          'unit' => 'px',
        ],
        'mobile_default'        => [
          'unit' => 'px',
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-description-divider' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
        ],
        'condition'             => [
          'team_member_description_switch' => 'yes',
          'team_member_description!' => '',
          'member_description_divider' => 'yes',
        ],
      ]
    );

        $this->add_responsive_control(
      'description_divider_margin',
      [
        'label'                 => __( 'Margin Bottom', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'default'               => [
                    'size' => 10,
                    'unit' => 'px',
                ],
        'size_units'            => [ 'px', '%' ],
        'range'                 => [
          'px' => [
            'max' => 100,
          ],
        ],
        'tablet_default'        => [
          'unit' => 'px',
        ],
        'mobile_default'        => [
          'unit' => 'px',
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-description-divider-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
        ],
        'condition'             => [
          'team_member_description_switch' => 'yes',
          'team_member_description!' => '',
          'member_description_divider' => 'yes',
        ],
      ]
    );

        $this->end_controls_section();

        /**
         * Style Tab: Social Links
         */
        $this->start_controls_section(
            'section_member_social_links_style',
            [
                'label'                 => __( 'Social Links', 'novaworks' ),
                'tab'                   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
      'member_icons_gap',
      [
        'label'                 => __( 'Icons Gap', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'size_units'            => [ '%', 'px' ],
        'range'                 => [
          'px' => [
            'max' => 60,
          ],
        ],
        'tablet_default'        => [
          'unit' => 'px',
        ],
        'mobile_default'        => [
          'unit' => 'px',
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-social-links li:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

        $this->add_responsive_control(
      'member_icon_size',
      [
        'label'                 => __( 'Icon Size', 'novaworks' ),
        'type'                  => Controls_Manager::SLIDER,
        'size_units'            => [ 'px' ],
        'range'                 => [
          'px' => [
            'max' => 30,
          ],
        ],
        'default'    => [
          'size' => '14',
          'unit' => 'px',
        ],
        'tablet_default'        => [
          'unit' => 'px',
        ],
        'mobile_default'        => [
          'unit' => 'px',
        ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-social-links .nova-tm-social-icon' => 'font-size: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; width: {{SIZE}}{{UNIT}};',
        ],
      ]
    );

        $this->start_controls_tabs( 'tabs_links_style' );

        $this->start_controls_tab(
            'tab_links_normal',
            [
                'label'                 => __( 'Normal', 'novaworks' ),
            ]
        );

        $this->add_control(
            'member_links_icons_color',
            [
                'label'                 => __( 'Color', 'novaworks' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .nova-tm-social-links .nova-tm-social-icon-wrap' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .nova-tm-social-links .nova-tm-social-icon-wrap svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'member_links_bg_color',
            [
                'label'                 => __( 'Background Color', 'novaworks' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .nova-tm-social-links .nova-tm-social-icon-wrap' => 'background-color: {{VALUE}};',
                ],
            ]
        );

    $this->add_group_control(
      Group_Control_Border::get_type(),
      [
        'name'                  => 'member_links_border',
        'label'                 => __( 'Border', 'novaworks' ),
        'placeholder'           => '1px',
        'default'               => '1px',
        'separator'             => 'before',
        'selector'              => '{{WRAPPER}} .nova-tm-social-links .nova-tm-social-icon-wrap',
      ]
    );

    $this->add_control(
      'member_links_border_radius',
      [
        'label'                 => __( 'Border Radius', 'novaworks' ),
        'type'                  => Controls_Manager::DIMENSIONS,
        'size_units'            => [ 'px', '%' ],
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-social-links .nova-tm-social-icon-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

    $this->add_responsive_control(
      'member_links_padding',
      [
        'label'                 => __( 'Padding', 'novaworks' ),
        'type'                  => Controls_Manager::DIMENSIONS,
        'size_units'            => [ 'px', 'em', '%' ],
        'separator'             => 'before',
        'selectors'             => [
          '{{WRAPPER}} .nova-tm-social-links .nova-tm-social-icon-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
        ],
      ]
    );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_links_hover',
            [
                'label'                 => __( 'Hover', 'novaworks' ),
            ]
        );

        $this->add_control(
            'member_links_icons_color_hover',
            [
                'label'                 => __( 'Color', 'novaworks' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .nova-tm-social-links .nova-tm-social-icon-wrap:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .nova-tm-social-links .nova-tm-social-icon-wrap:hover svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'member_links_bg_color_hover',
            [
                'label'                 => __( 'Background Color', 'novaworks' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .nova-tm-social-links .nova-tm-social-icon-wrap:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'member_links_border_color_hover',
            [
                'label'                 => __( 'Border Color', 'novaworks' ),
                'type'                  => Controls_Manager::COLOR,
                'default'               => '',
                'selectors'             => [
                    '{{WRAPPER}} .nova-tm-social-links .nova-tm-social-icon-wrap:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    protected function render_image() {
        $settings = $this->get_settings();
        $link_key = 'link';

        if ( ! empty( $settings['image']['url'] ) ) {
            if ( $settings['link_type'] == 'image' && $settings['link']['url'] != '' ) {
                printf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( $link_key ), Group_Control_Image_Size::get_attachment_image_html( $settings ) );
            } else {
                echo Group_Control_Image_Size::get_attachment_image_html( $settings );
            }
        }
    }

    protected function render_name() {
        $settings = $this->get_settings_for_display();

        $member_key = 'team_member_name';
        $link_key = 'link';

        $this->add_inline_editing_attributes( $member_key, 'none' );
        $this->add_render_attribute( $member_key, 'class', 'nova-tm-name' );

        if ( $settings[$member_key] != '' ) {
            if ( $settings['link_type'] == 'title' && $settings['link']['url'] != '' ) {
                printf( '<%1$s %2$s><a %3$s>%4$s</a></%1$s>', $settings['name_html_tag'], $this->get_render_attribute_string( $member_key ), $this->get_render_attribute_string( $link_key ), $settings['team_member_name'] );
            } else {
                printf( '<%1$s %2$s>%3$s</%1$s>', $settings['name_html_tag'], $this->get_render_attribute_string( $member_key ), $settings['team_member_name'] );
            }
        }

        if ( $settings['member_title_divider'] == 'yes' ) { ?>
            <div class="nova-tm-title-divider-wrap">
                <div class="nova-tm-divider nova-tm-title-divider"></div>
            </div>
            <?php
        }
    }

    protected function render_position() {
        $settings = $this->get_settings_for_display();
        $this->add_inline_editing_attributes( 'team_member_position', 'none' );
        $this->add_render_attribute( 'team_member_position', 'class', 'nova-tm-position' );

        if ( $settings['team_member_position'] != '' ) {
            printf( '<%1$s %2$s>%3$s</%1$s>', $settings['position_html_tag'], $this->get_render_attribute_string( 'team_member_position' ), $settings['team_member_position'] );
        }

        if ( $settings['member_position_divider'] == 'yes' ) { ?>
            <div class="nova-tm-position-divider-wrap">
                <div class="nova-tm-divider nova-tm-position-divider"></div>
            </div>
        <?php }
    }

    protected function render_description() {
        $settings = $this->get_settings_for_display();
        $this->add_inline_editing_attributes( 'team_member_description', 'basic' );
        $this->add_render_attribute( 'team_member_description', 'class', 'nova-tm-description' );

        if ( $settings['team_member_description_switch'] == 'yes' ) {
            if ( $settings['team_member_description'] != '' ) { ?>
                <div <?php echo $this->get_render_attribute_string( 'team_member_description' ); ?>>
                    <?php echo $this->parse_text_editor( $settings['team_member_description'] ); ?>
                </div>
            <?php } ?>
            <?php if ( $settings['member_description_divider'] == 'yes' ) { ?>
                <div class="nova-tm-description-divider-wrap">
                    <div class="nova-tm-divider nova-tm-description-divider"></div>
                </div>
            <?php }
        }
    }

    protected function render_social_links() {
        $settings = $this->get_settings_for_display();
        $i = 1;

    $fallback_defaults = [
      'fa fa-facebook',
      'fa fa-twitter',
      'fa fa-google-plus',
    ];

    $migration_allowed = Icons_Manager::is_migration_allowed();

    // add old default
    if ( ! isset( $item['icon'] ) && ! $migration_allowed ) {
      $item['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
    }

    $migrated = isset( $item['__fa4_migrated']['select_social_icon'] );
    $is_new = ! isset( $item['icon'] ) && $migration_allowed;
        ?>
        <div class="nova-tm-social-links-wrap">
            <ul class="nova-tm-social-links">
                <?php foreach ( $settings['team_member_social'] as $index => $item ) : ?>
                    <?php
            $migrated = isset( $item['__fa4_migrated']['select_social_icon'] );
            $is_new = empty( $item['social_icon'] ) && $migration_allowed;
            $social = '';

            // add old default
            if ( empty( $item['social_icon'] ) && ! $migration_allowed ) {
              $item['social_icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-wordpress';
            }

            if ( ! empty( $item['social_icon'] ) ) {
              $social = str_replace( 'fa fa-', '', $item['social_icon'] );
            }

            if ( ( $is_new || $migrated ) && 'svg' !== $item['select_social_icon']['library'] ) {
              $social = explode( ' ', $item['select_social_icon']['value'], 2 );
              if ( empty( $social[1] ) ) {
                $social = '';
              } else {
                $social = str_replace( 'fa-', '', $social[1] );
              }
            }
            if ( 'svg' === $item['select_social_icon']['library'] ) {
              $social = '';
            }

                        $this->add_render_attribute( 'social-link', 'class', 'nova-tm-social-link' );
                        $social_link_key = 'social-link' . $i;
                        if ( ! empty( $item['social_link']['url'] ) ) {
              $this->add_link_attributes( $social_link_key, $item['social_link'] );
                        }
                    ?>
                    <li>
                        <?php
                            //if ( $item['social_icon'] ) : ?>
                                <a <?php echo $this->get_render_attribute_string( $social_link_key ); ?>>
                                    <span class="nova-tm-social-icon-wrap">
                    <span class="elementor-screen-only"><?php echo ucwords( $social ); ?></span>
                                        <span class="nova-tm-social-icon pp-icon">
                    <?php
                    if ( $is_new || $migrated ) {
                      Icons_Manager::render_icon( $item['select_social_icon'], [ 'aria-hidden' => 'true' ] );
                    } else { ?>
                      <i class="<?php echo esc_attr( $item['social_icon'] ); ?>"></i>
                    <?php } ?>
                    </span>
                                    </span>
                                </a>
                            <?php //endif;
                        ?>
                    </li>
                <?php $i++; endforeach; ?>
            </ul>
        </div>
        <?php
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $link_key = 'link';

        if ( $settings['link_type'] != 'none' ) {
            if ( ! empty( $settings['link']['url'] ) ) {
        $this->add_link_attributes( $link_key, $settings['link'] );
            }
        }
        ?>
        <div class="nova-tm-wrapper">
            <div class="nova-tm">
                <?php
                    if ( $settings['overlay_content'] == 'social_icons' ) { ?>
                        <div class="nova-tm-image">
                            <?php
                                // Image
                                $this->render_image();
                            ?>
                            <div class="nova-tm-overlay-content-wrap">
                                <div class="nova-tm-content">
                                    <?php
                                        if ( $settings['member_social_links'] == 'yes' ) {
                                            $this->render_social_links();
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="nova-tm-content nova-tm-content-normal">
                            <?php
                                // Name
                                $this->render_name();

                                // Position
                                $this->render_position();
                            ?>
                        </div>
                        <?php
                    }

                    if ( $settings['overlay_content'] == 'all_content' ) { ?>
                        <div class="nova-tm-image">
                            <?php
                                // Image
                                $this->render_image();
                            ?>
                            <div class="nova-tm-overlay-content-wrap">
                                <div class="nova-tm-content">
                                    <?php
                                        if ( $settings['member_social_links'] == 'yes' ) {
                                            if ( $settings['social_links_position'] == 'before_desc' ) {
                                                $this->render_social_links();
                                            }
                                        }

                                        // Description
                                        $this->render_description();

                                        if ( $settings['member_social_links'] == 'yes' ) {
                                            if ( $settings['social_links_position'] == 'after_desc' ) {
                                                $this->render_social_links();
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="nova-tm-content nova-tm-content-normal">
                            <?php
                                // Name
                                $this->render_name();

                                // Position
                                $this->render_position();
                                // Description
                                $this->render_description();
                            ?>
                        </div>
                        <?php
                    }
                    if ( $settings['overlay_content'] == 'all' ) { ?>
                        <div class="nova-tm-image">
                            <?php
                                // Image
                                $this->render_image();
                            ?>
                            <div class="nova-tm-overlay-content-wrap">
                                <div class="nova-tm-content">
                                  <?php
                                  // Position
                                  $this->render_position();
                                      // Name
                                      $this->render_name();

                                  ?>
                                    <?php
                                        if ( $settings['member_social_links'] == 'yes' ) {
                                            if ( $settings['social_links_position'] == 'before_desc' ) {
                                                $this->render_social_links();
                                            }
                                        }

                                        // Description
                                        $this->render_description();

                                        if ( $settings['member_social_links'] == 'yes' ) {
                                            if ( $settings['social_links_position'] == 'after_desc' ) {
                                                $this->render_social_links();
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    if ( $settings['overlay_content'] == 'none' || $settings['overlay_content'] == '' ) {
            if ( ! empty( $settings['image']['url'] ) ) { ?>
              <div class="nova-tm-image">
                <?php
                  // Image
                  $this->render_image();
                ?>
              </div>
              <?php
            }
                    ?>
                    <div class="nova-tm-content nova-tm-content-normal">
                        <?php
                            // Name
                            $this->render_name();

                            // Position
                            $this->render_position();

                            if ( $settings['member_social_links'] == 'yes' && $settings['overlay_content'] == 'none' ) {
                                if ( $settings['social_links_position'] == 'before_desc' ) {
                                    $this->render_social_links();
                                }
                            }

                            // Description
                            $this->render_description();

                            if ( $settings['member_social_links'] == 'yes' && $settings['overlay_content'] == 'none' ) {
                                if ( $settings['social_links_position'] == 'after_desc' ) {
                                    $this->render_social_links();
                                }
                            }
                        ?>
                    </div><!-- .nova-tm-content -->
                <?php } ?>
            </div><!-- .nova-tm -->
        </div>
        <?php
    }

    protected function _content_template() {
        ?>
    <#
        function member_image() {
          if ( '' !== settings.image.url ) {
          var image = {
            id: settings.image.id,
            url: settings.image.url,
            size: settings.image_size,
            dimension: settings.image_custom_dimension,
            model: view.getEditModel()
          };

          var image_url = elementor.imagesManager.getImageUrl( image );
        }

          if ( settings.image.url != '' ) {
            if ( settings.link_type == 'image' && settings.link.url != '' ) {
            var target = settings.link.is_external ? ' target="_blank"' : '';
            var nofollow = settings.link.nofollow ? ' rel="nofollow"' : '';
            #>
            <a href="{{ settings.link.url }}"{{ target }}{{ nofollow }}>
              <img src="{{ image_url }}" alt="">
            </a>
          <# } else { #>
            <img src="{{ image_url }}" alt="">
          <# }
        }
      }

        function member_name() {
          if ( settings.team_member_name != '' ) {
          var name = settings.team_member_name;

          view.addRenderAttribute( 'team_member_name', 'class', 'nova-tm-name' );

          view.addInlineEditingAttributes( 'team_member_name' );

          var name_html = '<' + settings.name_html_tag  + ' ' + view.getRenderAttributeString( 'team_member_name' ) + '>' + name + '</' + settings.name_html_tag + '>';
        }

          if ( settings.link_type == 'title' && settings.link.url != '' ) { #>
          <#
          var target = settings.link.is_external ? ' target="_blank"' : '';
          var nofollow = settings.link.nofollow ? ' rel="nofollow"' : '';
          #>
          <a href="{{ settings.link.url }}"{{ target }}{{ nofollow }}>
            <# print( name_html ); #>
          </a>
        <# } else {
           print( name_html );
        }

        if ( settings.member_title_divider == 'yes' ) { #>
          <div class="nova-tm-title-divider-wrap">
            <div class="nova-tm-divider nova-tm-title-divider"></div>
          </div>
        <# }
      }

        function member_position() {
          if ( settings.team_member_position != '' ) {
          var position = settings.team_member_position;

          view.addRenderAttribute( 'team_member_position', 'class', 'nova-tm-position' );

          view.addInlineEditingAttributes( 'team_member_position' );

          var position_html = '<' + settings.position_html_tag  + ' ' + view.getRenderAttributeString( 'team_member_position' ) + '>' + position + '</' + settings.position_html_tag + '>';

          print( position_html );
        }

          if ( settings.member_position_divider == 'yes' ) { #>
          <div class="nova-tm-position-divider-wrap">
            <div class="nova-tm-divider nova-tm-position-divider"></div>
          </div>
        <# }
      }

      function member_description() {
          if ( settings.team_member_description_switch == 'yes' ) {
          if ( settings.team_member_description != '' ) {
            var description = settings.team_member_description;

            view.addRenderAttribute( 'team_member_description', 'class', 'nova-tm-description' );

            view.addInlineEditingAttributes( 'team_member_description', 'advanced' );

            var description_html = '<' + settings.position_html_tag  + ' ' + view.getRenderAttributeString( 'team_member_description' ) + '>' + description + '</' + settings.position_html_tag + '>';

            print( description_html );
          }

            if ( settings.member_description_divider == 'yes' ) { #>
            <div class="nova-tm-description-divider-wrap">
              <div class="nova-tm-divider nova-tm-description-divider"></div>
            </div>
          <# }
        }
      }

      function member_social_links() { #>
        <# var iconsHTML = {}; #>
        <div class="nova-tm-social-links-wrap">
          <ul class="nova-tm-social-links">
            <# _.each( settings.team_member_social, function( item, index ) {
              var migrated = elementor.helpers.isIconMigrated( item, 'select_social_icon' );
                social = elementor.helpers.getSocialNetworkNameFromIcon( item.select_social_icon, item.social_icon, false, migrated );
              #>
              <li>
                <# if ( item.social_icon || item.select_social_icon ) { #>
                  <# if ( item.social_link && item.social_link.url ) { #>
                    <a class="nova-tm-social-link" href="{{ item.social_link.url }}">
                  <# } #>
                    <span class="nova-tm-social-icon-wrap">
                      <span class="nova-tm-social-icon pp-icon">
                        <span class="elementor-screen-only">{{{ social }}}</span>
                        <#
                          iconsHTML[ index ] = elementor.helpers.renderIcon( view, item.select_social_icon, {}, 'i', 'object' );
                          if ( ( ! item.social_icon || migrated ) && iconsHTML[ index ] && iconsHTML[ index ].rendered ) { #>
                            {{{ iconsHTML[ index ].value }}}
                          <# } else { #>
                            <i class="{{ item.social_icon }}"></i>
                          <# }
                        #>
                      </span>
                    </span>
                  <# if ( item.social_link && item.social_link.url ) { #>
                    </a>
                  <# } #>
                <# } #>
              </li>
            <# } ); #>
          </ul>
        </div>
    <# } #>

        <div class="nova-tm-wrapper">
            <div class="nova-tm">
                <# if ( settings.overlay_content == 'social_icons' ) { #>
                    <div class="nova-tm-image">
            <# member_image(); #>
                        <div class="nova-tm-overlay-content-wrap">
                            <div class="nova-tm-content">
                                <# if ( settings.member_social_links == 'yes' ) { #>
                                    <# member_social_links(); #>
                                <# } #>
                            </div>
                        </div>
                    </div>
                    <div class="nova-tm-content nova-tm-content-normal">
                      <# member_name(); #>
                      <# member_position(); #>
                    </div>
                <# } #>

                <# if ( settings.overlay_content == 'all_content' ) { #>
                    <div class="nova-tm-image">
                        <# member_image(); #>
                        <div class="nova-tm-overlay-content-wrap">
                            <div class="nova-tm-content">
                                <#
                   if ( settings.member_social_links == 'yes' ) {
                      if ( settings.social_links_position == 'before_desc' ) {
                        member_social_links();
                      }
                   }

                   member_description();

                   if ( settings.member_social_links == 'yes' ) {
                      if ( settings.social_links_position == 'after_desc' ) {
                        member_social_links();
                      }
                   }
                #>
                            </div>
                        </div>
                    </div>
                    <div class="nova-tm-content nova-tm-content-normal">
            <# member_name(); #>
            <# member_position(); #>
                    </div>
                <# } #>
                <# if ( settings.overlay_content == 'all' ) { #>
                    <div class="nova-tm-image">
                        <# member_image(); #>
                        <div class="nova-tm-overlay-content-wrap">
                            <div class="nova-tm-content">
                              <# member_position(); #>
                              <# member_name(); #>
                                <#
                   if ( settings.member_social_links == 'yes' ) {
                      if ( settings.social_links_position == 'before_desc' ) {
                        member_social_links();
                      }
                   }

                   member_description();

                   if ( settings.member_social_links == 'yes' ) {
                      if ( settings.social_links_position == 'after_desc' ) {
                        member_social_links();
                      }
                   }
                #>
                            </div>
                        </div>
                    </div>
                <# } #>
                <# if ( settings.overlay_content != 'all_content' ) { #>
                <# if ( settings.overlay_content != 'all' ) { #>
                    <# if ( settings.overlay_content != 'social_icons' ) { #>
            <# if ( settings.image.url != '' ) { #>
              <div class="nova-tm-image">
                <# member_image(); #>
              </div>
            <# } #>
                    <# } #>
                    <div class="nova-tm-content nova-tm-content-normal">
            <#
               member_name();
               member_position();

               if ( settings.member_social_links == 'yes' && settings.overlay_content == 'none' ) {
                  if ( settings.social_links_position == 'before_desc' ) {
                    member_social_links();
                  }
              }

                member_description();

                if ( settings.member_social_links == 'yes' && settings.overlay_content == 'none' ) {
                  if ( settings.social_links_position == 'after_desc' ) {
                    member_social_links();
                  }
                }
            #>
                    </div>
                <# } #>
                <# } #>
            </div>
        </div>
        <?php }
}
