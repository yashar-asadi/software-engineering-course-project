<?php
/**
 * Features list start template
 */

 $settings = $this->get_settings_for_display();
 $columns       = $settings['columns'];
 $columnsLaptop = !empty($settings['columns_laptop']) ? $settings['columns_laptop'] : $settings['columns'];
 $columnsTablet = !empty($settings['columns_tablet']) ? $settings['columns_tablet'] : 2;
 $columnsTabletPortrait = !empty($settings['columns_tabletportrait']) ? $settings['columns_tabletportrait'] : $settings['columns'];
 $columnsMobile = !empty($settings['columns_mobile']) ? $settings['columns_mobile'] : 1;
 $this->add_render_attribute( 'list-container', 'class', array(
  'brands-list',
  'grid-x',
  'grid-padding-x',
  'grid-padding-y',
  'xxlarge-up-' . $columns,
  'xlarge-up-' . $columnsLaptop,
  'large-up-' . $columnsTabletPortrait,
  'medium-up-' . $columnsTablet,
  'small-up-' . $columnsMobile
 ));
?>
<div <?php echo $this->get_render_attribute_string( 'list-container' ); ?>>
