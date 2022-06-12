<?php

// ============================================
// Panel
// ============================================

// no panel


// ============================================
// Sections
// ============================================

Kirki::add_section( 'fonts', array(
    'title'          => esc_html__( 'Fonts', 'irina' ),
    'priority'       => 35,
    'capability'     => 'edit_theme_options',
) );


// ============================================
// Controls
// ============================================

$sep_id  = 59374;
$section = 'fonts';


Kirki::add_field( 'irina', array(
    'type'        => 'number',
    'settings'    => 'font_size',
    'label'       => esc_html__( 'Base Font Size', 'irina' ),
    'description' => esc_html__( 'The Base Font Size refers to the size applied to the paragraph text. All other elements, such as headings, links, buttons, etc will adjusted automatically to keep the hierarchy of font sizes based on this one size. Easy-peasy!', 'irina' ),
    'section'     => $section,
    'default'     => 16,
    'priority'    => 10,
    'choices'     => array(
        'min'  => 12,
        'max'  => 24,
        'step' => 1
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
    'type'        => 'typography',
    'settings'    => 'main_font',
    'label'       => esc_html__( 'Body Font', 'irina' ),
    'section'     => $section,
    'default'     => array(
        'font-family'    => 'Montserrat',
        'variant'        => '400',
        'subsets'        => array( 'latin-ext' ),
    ),
    'choices' => array(
      'variant' => array(
          '400',
      ),
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
    'type'        => 'typography',
    'settings'    => 'secondary_font',
    'label'       => esc_html__( 'Headings Font', 'irina' ),
    'section'     => $section,
    'default'     => array(
        'font-family'    => 'Raleway',
        'variant'        => '600',
        'subsets'        => array( 'latin' ),
    ),
) );
