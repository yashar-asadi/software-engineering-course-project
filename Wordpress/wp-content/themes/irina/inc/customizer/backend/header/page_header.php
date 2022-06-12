<?php

$sep_id  = 6477;
$section = 'page_header';

Kirki::add_field( 'irina', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'page_header_style',
    'label'       => esc_html__( 'Page Header Style', 'irina' ),
    'section'     => $section,
    'default'     => 'large',
    'priority'    => 10,
    'choices'     => array(
        'mini'  => esc_html__( 'Mini', 'irina' ),
        'large'  => esc_html__( 'Large', 'irina' ),
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
    'type'        => 'image',
    'settings'    => 'page_header_background_image',
    'label'       => esc_html__( 'Background Image', 'irina' ),
    'section'     => $section,
    'priority'    => 10,
    'active_callback'    => array(
        array(
            'setting'  => 'page_header_style',
            'operator' => '==',
            'value'    => 'large',
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
            'setting'  => 'page_header_style',
            'operator' => '==',
            'value'    => 'large',
        ),
    ),

) );
Kirki::add_field( 'irina', array(
    'type'        => 'color',
    'settings'    => 'pager_header_overlay_color',
    'label'       => esc_html__( 'Page Header Background Overlay Color', 'irina' ),
    'section'     => $section,
    'default'     => '',
    'priority'    => 10,
    'active_callback'    => array(
        array(
            'setting'  => 'page_header_style',
            'operator' => '==',
            'value'    => 'large',
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
            'setting'  => 'page_header_style',
            'operator' => '==',
            'value'    => 'large',
        ),
    ),

) );
// ---------------------------------------------

Kirki::add_field( 'irina', array(
    'type'        => 'color',
    'settings'    => 'pager_header_background_color',
    'label'       => esc_html__( 'Page Header Background Color', 'irina' ),
    'section'     => $section,
    'default'     => '#ECEBE7',
    'priority'    => 10,
    'active_callback'    => array(
        array(
            'setting'  => 'page_header_style',
            'operator' => '==',
            'value'    => 'large',
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
            'setting'  => 'page_header_style',
            'operator' => '==',
            'value'    => 'large',
        ),
    ),

) );
// ---------------------------------------------

Kirki::add_field( 'irina', array(
    'type'        => 'slider',
    'settings'    => 'page_header_height',
    'label'       => esc_html__( 'Page Header Height', 'irina' ),
    'section'     => $section,
    'default'     => 200,
    'priority'    => 10,
    'choices'     => array(
        'min'  => 100,
        'max'  => 1000,
        'step' => 1
    ),
    'active_callback'    => array(
        array(
            'setting'  => 'page_header_style',
            'operator' => '==',
            'value'    => 'large',
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
            'setting'  => 'page_header_style',
            'operator' => '==',
            'value'    => 'large',
        ),
    ),

) );
// ---------------------------------------------

Kirki::add_field( 'irina', array(
    'type'        => 'color',
    'settings'    => 'pager_header_font_color',
    'label'       => esc_html__( 'Page Header Font Color', 'irina' ),
    'section'     => $section,
    'default'     => '#616161',
    'priority'    => 10,
    'active_callback'    => array(
        array(
            'setting'  => 'page_header_style',
            'operator' => '==',
            'value'    => 'large',
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
            'setting'  => 'page_header_style',
            'operator' => '==',
            'value'    => 'large',
        ),
    ),

) );
// ---------------------------------------------

Kirki::add_field( 'irina', array(
    'type'        => 'color',
    'settings'    => 'pager_header_heading_color',
    'label'       => esc_html__( 'Page Header Heading Color', 'irina' ),
    'section'     => $section,
    'default'     => '#000',
    'priority'    => 10,
    'active_callback'    => array(
        array(
            'setting'  => 'page_header_style',
            'operator' => '==',
            'value'    => 'large',
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
            'setting'  => 'page_header_style',
            'operator' => '==',
            'value'    => 'large',
        ),
    ),

) );
// ---------------------------------------------

Kirki::add_field( 'irina', array(
    'type'        => 'toggle',
    'settings'    => 'page_header_breadcrumb_toggle',
    'label'       => esc_html__( 'Site Breadcrumb', 'irina' ),
    'section'     => $section,
    'default'     => 1,
    'priority'    => 10,
    'choices'     => array(
        'on'  => esc_html__( 'On', 'irina' ),
        'off' => esc_html__( 'Off', 'irina' ),
    ),

) );

// ---------------------------------------------
