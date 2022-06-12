<?php
$sep_id  = 76952;
$section = 'style_topbar';

// ---------------------------------------------
Kirki::add_field( 'irina', array(
    'type'        => 'color',
    'settings'    => 'topbar_bg_color',
    'label'       => esc_html__( 'Background Color', 'irina' ),
    'section'     => $section,
    'default'     => '#F5F5F5',
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
    'settings'    => 'topbar_font_color',
    'label'       => esc_html__( 'Text Color', 'irina' ),
    'section'     => $section,
    'default'     => '#242424',
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
    'settings'    => 'topbar_heading_color',
    'label'       => esc_html__( 'Heading Color', 'irina' ),
    'section'     => $section,
    'default'     => '#242424',
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
    'settings'    => 'topbar_accent_color',
    'label'       => esc_html__( 'Accent Color', 'irina' ),
    'section'     => $section,
    'default'     => '#000',
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
    'settings'    => 'topbar_border_color',
    'label'       => esc_html__( 'Border Color', 'irina' ),
    'section'     => $section,
    'default'     => '#F5F5F5',
    'priority'    => 10,
) );
// ---------------------------------------------
Kirki::add_field( 'irina', array(
    'type'        => 'separator',
    'settings'    => 'separator_'. $sep_id++,
    'section'     => $section,
) );
