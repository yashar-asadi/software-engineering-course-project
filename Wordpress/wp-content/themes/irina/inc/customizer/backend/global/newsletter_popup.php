<?php
$sep_id  = 8325;
$section = 'global_popup';

Kirki::add_field( 'irina', array(
	'type'        => 'switch',
	'settings'    => 'newsletter_popup',
  'label'       => esc_html__( 'Newsletter Popup', 'irina' ),
	'section'     => $section,
	'default'     => 'off',
	'priority'    => 10,
	'choices'     => array(
		'on'  => esc_html__( 'Enable', 'irina' ),
		'off' => esc_html__( 'Disable', 'irina' ),
	),
) );
// ---------------------------------------------
Kirki::add_field( 'irina', array(
    'type'        => 'separator',
    'settings'    => 'separator_'. $sep_id++,
    'section'     => $section,

) );
// ---------------------------------------------
Kirki::add_field( 'irina', array(
	'type'        => 'switch',
	'settings'    => 'popup_showonly_homepage',
  'label'       => esc_html__( 'Only showing on homepage', 'irina' ),
	'section'     => $section,
	'default'     => 'on',
	'priority'    => 10,
	'choices'     => array(
		'on'  => esc_html__( 'Yes', 'irina' ),
		'off' => esc_html__( 'No', 'irina' ),
	),
  'active_callback'    => array(
      array(
          'setting'  => 'newsletter_popup',
          'operator' => '==',
          'value'    => true,
      ),
  ),
) );
// ---------------------------------------------
Kirki::add_field( 'irina', array(
    'type'        => 'separator',
    'settings'    => 'separator_'. $sep_id++,
    'section'     => $section,
    'active_callback'    => array(
        array(
            'setting'  => 'newsletter_popup',
            'operator' => '==',
            'value'    => true,
        ),
    ),

) );
// ---------------------------------------------
Kirki::add_field( 'irina', array(
	'type'        => 'switch',
	'settings'    => 'popup_show_mobile',
  'label'       => esc_html__( 'Don\'t show popup on mobile', 'irina' ),
	'section'     => $section,
	'default'     => 'off',
	'priority'    => 10,
	'choices'     => array(
		'on'  => esc_html__( 'Yes', 'irina' ),
		'off' => esc_html__( 'No', 'irina' ),
	),
  'active_callback'    => array(
      array(
          'setting'  => 'newsletter_popup',
          'operator' => '==',
          'value'    => true,
      ),
  ),
) );
// ---------------------------------------------
Kirki::add_field( 'irina', array(
    'type'        => 'separator',
    'settings'    => 'separator_'. $sep_id++,
    'section'     => $section,
    'active_callback'    => array(
        array(
            'setting'  => 'newsletter_popup',
            'operator' => '==',
            'value'    => true,
        ),
    ),

) );
// ---------------------------------------------
Kirki::add_field( 'irina', array(
	'type'        => 'switch',
	'settings'    => 'popup_show_again',
  'label'       => esc_html__( 'Display option "Does not show popup again"', 'irina' ),
	'section'     => $section,
	'default'     => 'off',
	'priority'    => 10,
	'choices'     => array(
		'on'  => esc_html__( 'Yes', 'irina' ),
		'off' => esc_html__( 'No', 'irina' ),
	),
  'active_callback'    => array(
      array(
          'setting'  => 'newsletter_popup',
          'operator' => '==',
          'value'    => true,
      ),
  ),
) );
// ---------------------------------------------
Kirki::add_field( 'irina', array(
    'type'        => 'separator',
    'settings'    => 'separator_'. $sep_id++,
    'section'     => $section,
    'active_callback'    => array(
        array(
            'setting'  => 'newsletter_popup',
            'operator' => '==',
            'value'    => true,
        ),
    ),

) );
// ---------------------------------------------
Kirki::add_field( 'irina', array(
  'type'     => 'text',
  'settings' => 'popup_show_again_text',
  'label'       => esc_html__( 'Text "Does not show popup again"', 'irina' ),
  'section'  => $section,
  'default'  => esc_html__( 'Don’t show this popup again', 'irina' ),
  'priority' => 10,
  'active_callback'    => array(
      array(
          'setting'  => 'newsletter_popup',
          'operator' => '==',
          'value'    => true,
      ),
      array(
          'setting'  => 'popup_show_again',
          'operator' => '==',
          'value'    => true,
      ),
  ),
) );
// ---------------------------------------------
Kirki::add_field( 'irina', array(
    'type'        => 'separator',
    'settings'    => 'separator_'. $sep_id++,
    'section'     => $section,
    'active_callback'    => array(
        array(
            'setting'  => 'newsletter_popup',
            'operator' => '==',
            'value'    => true,
        ),
        array(
            'setting'  => 'popup_show_again',
            'operator' => '==',
            'value'    => true,
        ),
    ),

) );
// ---------------------------------------------
Kirki::add_field( 'irina', array(
  'type'     => 'text',
  'settings' => 'popup_show_after',
  'label'       => esc_html__( 'Popup showing after', 'irina' ),
	'description' => esc_html__( 'Show Popup when site loaded after (number) seconds ( 1000ms = 1 second )', 'irina' ),
  'section'  => $section,
  'default'  => 2000,
  'priority' => 10,
  'active_callback'    => array(
      array(
          'setting'  => 'newsletter_popup',
          'operator' => '==',
          'value'    => true,
      ),
  ),
) );
// ---------------------------------------------
Kirki::add_field( 'irina', array(
    'type'        => 'separator',
    'settings'    => 'separator_'. $sep_id++,
    'section'     => $section,
    'active_callback'    => array(
        array(
            'setting'  => 'newsletter_popup',
            'operator' => '==',
            'value'    => true,
        ),
    ),

) );
// ---------------------------------------------
Kirki::add_field( 'irina', array(
  'type'        => 'editor',
	'settings'    => 'popup_content',
	'label'       => esc_html__( 'Newsletter Popup Content', 'irina' ),
	'section'     => $section,
	'default'     => '',
  'active_callback'    => array(
      array(
          'setting'  => 'newsletter_popup',
          'operator' => '==',
          'value'    => true,
      ),
  ),
) );
// ---------------------------------------------
Kirki::add_field( 'irina', array(
    'type'        => 'separator',
    'settings'    => 'separator_'. $sep_id++,
    'section'     => $section,
    'active_callback'    => array(
        array(
            'setting'  => 'newsletter_popup',
            'operator' => '==',
            'value'    => true,
        ),
    ),

) );
// ---------------------------------------------
