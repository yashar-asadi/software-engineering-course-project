<?php

// ============================================
// Panel
// ============================================

// no panel


// ============================================
// Sections
// ============================================

Kirki::add_section( 'footer', array(
    'title'          => esc_html__( 'Footer', 'irina' ),
    'priority'       => 60,
    'capability'     => 'edit_theme_options',
) );


// ============================================
// Controls
// ============================================

$sep_id  = 48536;
$section = 'footer';
$footer_link = sprintf('<a href="%s">%s</a>', add_query_arg(array('post_type' => 'elementor_library', 'elementor_library_type' => 'footer'), admin_url('edit.php')), __('here', 'irina'));
Kirki::add_field( 'irina', array(
    'type'        => 'select',
    'settings'    => 'footer_template',
    'label'       => esc_html__( 'Footer Template', 'irina' ),
    'section'     => 'footer',
    'default'     => 'type-mini',
    'priority'    => 10,
    'choices'     => array(
        'type-mini'     => esc_html__( 'Footer Mini', 'irina' ),
        'type-builder'     => esc_html__( 'Footer Builder', 'irina' ),
    ),
) );
Kirki::add_field( 'irina', array(
    'type'        => 'select',
    'settings'    => 'footer_template_builder',
    'label'       => esc_html__( 'Footer Builder Template', 'irina' ),
    'section'     => 'footer',
    'default'     => 'type-mini',
    'priority'    => 10,
    'choices'     => nova_get_config_footer_layout_opts(),
    'description'        => sprintf( __('You can manage footer layout on %s', 'irina'), $footer_link ),
    'active_callback'    => array(
        array(
            'setting'  => 'footer_template',
            'operator' => '==',
            'value'    => 'type-builder',
        ),
    ),
) );
Kirki::add_field( 'irina', array(
    'type'     => 'textarea',
    'settings' => 'footer_text',
    'label'    => esc_html__( 'Copyright Text', 'irina' ),
    'section'  => $section,
    'default'  => esc_html__( '© 2021 Irina All rights reserved. Designed by Novaworks', 'irina' ),
    'priority' => 10,
    'active_callback'    => array(
        array(
            'setting'  => 'footer_template',
            'operator' => '==',
            'value'    => 'type-mini',
        ),
    ),
) );
