<?php
$sep_id  = 76153;
$section = 'style_quick_view';

Kirki::add_field( 'irina', array(
    'type'        => 'color',
    'settings'    => 'qv_bg_color',
    'label'       => esc_html__( 'QuickView Background Color', 'irina' ),
    'section'     => $section,
    'default'     => '#fff',
    'priority'    => 10,
) );

// ---------------------------------------------
Kirki::add_field( 'irina', array(
    'type'        => 'separator',
    'settings'    => 'separator_'. $sep_id++,
    'section'     => $section,
) );
// ---------------------------------------------

Kirki::add_field( 'irina', array(
    'type'        => 'color',
    'settings'    => 'qv_font_color',
    'label'       => esc_html__( 'QuickView Text Color', 'irina' ),
    'section'     => $section,
    'default'     => '#616161',
    'priority'    => 10,
) );

// ---------------------------------------------
Kirki::add_field( 'irina', array(
    'type'        => 'separator',
    'settings'    => 'separator_'. $sep_id++,
    'section'     => $section,
) );
// ---------------------------------------------

Kirki::add_field( 'irina', array(
    'type'        => 'color',
    'settings'    => 'qv_heading_color',
    'label'       => esc_html__( 'QuickView Heading Color', 'irina' ),
    'section'     => $section,
    'default'     => '#000',
    'priority'    => 10,
) );
