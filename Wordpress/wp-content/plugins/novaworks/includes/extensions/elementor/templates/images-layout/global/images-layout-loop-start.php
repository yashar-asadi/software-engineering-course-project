<?php
/**
 * Features list start template
 */

$settings = $this->get_settings_for_display();

$columns       = $settings['columns'];
$columnsLaptop = !empty($settings['columns_laptop']) ? $settings['columns_laptop'] : $columns;
$columnsTablet = !empty($settings['columns_tablet']) ? $settings['columns_tablet'] : $columnsLaptop;
$columnsTabletPortrait = !empty($settings['columns_tabletportrait']) ? $settings['columns_tabletportrait'] : $columnsTablet;
$columnsMobile = !empty($settings['columns_mobile']) ? $settings['columns_mobile'] : $columnsTabletPortrait;

$class_array[] = 'novaworks-images-layout__list';
$attr_array = [];

if ( 'grid' === $settings['layout_type'] ) {
    $class_array[] = 'grid-items';
    $class_array[] = novaworks_element_render_grid_classes([
        'desktop'   => $columns,
        'laptop'    => $columnsLaptop,
        'tablet'    => $columnsTablet,
        'mobile'    => $columnsTabletPortrait,
        'xmobile'   => $columnsMobile
    ]);
}

if ( 'masonry' === $settings['layout_type'] ) {
    $class_array[]  = 'grid-items';
    $class_array[]  = novaworks_element_render_grid_classes([
        'desktop'   => $columns,
        'laptop'    => $columnsLaptop,
        'tablet'    => $columnsTablet,
        'mobile'    => $columnsTabletPortrait,
        'xmobile'   => $columnsMobile
    ]);
    $class_array[]  = 'js-el nova-isotope-container';

    $attr_array[]   = 'data-la_component="DefaultMasonry"';
    $attr_array[]   = 'data-md-col="' . $columnsTablet . '"';
    $attr_array[]   = 'data-sm-col="' . $columnsTabletPortrait . '"';
    $attr_array[]   = 'data-xs-col="' . $columnsMobile . '"';
    $attr_array[]   = 'data-mb-col="' . $columnsMobile . '"';
    $attr_array[]   = 'data-item_selector=".novaworks-images-layout__item"';
    $attr_array[]   = 'data-nova-effect="sequencefade"';
}

$classes = implode( ' ', $class_array );
$attrs = implode( ' ', $attr_array );

?>
<div class="<?php echo $classes; ?>" <?php echo $attrs; ?>>
