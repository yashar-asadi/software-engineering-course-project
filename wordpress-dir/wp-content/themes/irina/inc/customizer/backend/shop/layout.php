<?php

$sep_id  = 45785;
$section = 'shop';

Kirki::add_field( 'irina', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'shop_layout_width',
    'label'       => esc_html__( 'Layout Width', 'irina' ),
    'section'     => $section,
    'default'     => 'boxed',
    'priority'    => 10,
    'choices'     => array(
        'wide'  => esc_html__( 'Wide', 'irina' ),
        'boxed'  => esc_html__( 'Boxed', 'irina' ),
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
    'type'        => 'toggle',
    'settings'    => 'shop_sidebar',
    'label'       => esc_html__( 'Shop Sidebar', 'irina' ),
    'section'     => $section,
    'default'     => false,
    'priority'    => 10,
) );

// ---------------------------------------------
Kirki::add_field( 'irina', array(
    'type'        => 'separator',
    'settings'    => 'separator_'. $sep_id++,
    'section'     => $section,
    'active_callback'    => array(
        array(
            'setting'  => 'shop_sidebar',
            'operator' => '==',
            'value'    => true,
        ),
    ),
) );
// ---------------------------------------------

Kirki::add_field( 'irina', array(
    'type'        => 'radio-buttonset',
    'settings'    => 'shop_sidebar_position',
    'label'       => esc_html__( 'Sidebar Position', 'irina' ),
    'section'     => $section,
    'default'     => 'left',
    'priority'    => 10,
    'choices'     => array(
        'left'    => esc_html__( 'Left', 'irina' ),
        'right'   => esc_html__( 'Right', 'irina' ),
    ),
    'active_callback'    => array(
        array(
            'setting'  => 'shop_sidebar',
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
) );
// ---------------------------------------------

// ---------------------------------------------
Kirki::add_field( 'irina', array(
    'type'        => 'toggle',
    'settings'    => 'shop_sticky_sidebar',
    'label'       => esc_html__( 'Shop Sticky Sidebar', 'irina' ),
    'section'     => $section,
    'default'     => false,
    'priority'    => 10,
		'active_callback'    => array(
				array(
						'setting'  => 'shop_sidebar',
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
						'setting'  => 'shop_sidebar',
						'operator' => '==',
						'value'    => true,
				),
		),
) );

Kirki::add_field( 'irina', array(
    'type'        => 'toggle',
    'settings'    => 'shop_filter_active',
    'label'       => esc_html__( 'Shop Filters', 'irina' ),
    'section'     => $section,
    'default'     => true,
    'priority'    => 10,
    'active_callback'    => array(
        array(
            'setting'  => 'shop_sidebar',
            'operator' => '==',
            'value'    => false,
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
            'setting'  => 'shop_sidebar',
            'operator' => '==',
            'value'    => false,
        ),
    ),
) );
Kirki::add_field( 'irina', array(
    'type'        => 'slider',
    'settings'    => 'shop_filter_height',
    'label'       => esc_html__( 'Widget Scrollbar Max Height', 'irina' ),
    'section'     => $section,
    'default'     => 150,
    'priority'    => 10,
    'choices'     => array(
        'min'  => 150,
        'max'  => 1000,
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
    'type'        => 'radio-buttonset',
    'settings'    => 'shop_pagination',
    'label'       => esc_html__( 'Pagination', 'irina' ),
    'section'     => $section,
    'default'     => 'infinite_scroll',
    'priority'    => 10,
    'choices'     => array(
        'default'           => esc_html__( 'Classic', 'irina' ),
        'load_more_button'  => esc_html__( 'Load More', 'irina' ),
        'infinite_scroll'   => esc_html__( 'Infinite', 'irina' ),
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
    'type'        => 'slider',
    'settings'    => 'shop_mobile_columns',
    'label'       => esc_html__( 'Number of Columns on Mobile', 'irina' ),
    'section'     => $section,
    'default'     => 2,
    'priority'    => 10,
    'choices'     => array(
        'min'  => 1,
        'max'  => 2,
        'step' => 1
    ),
) );
