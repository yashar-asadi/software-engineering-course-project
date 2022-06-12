<?php
/**
 * Testimonials start template
 */

$data_settings = '';

$use_comment_corner = $this->get_settings( 'use_comment_corner' );

$class_array = [];

if( $this->get_settings('enable_carousel') == 'true' ) {
    $this->add_render_attribute( 'list-container', 'class', array(
     'novaworks-carousel',
     'slick-carousel'
    ));
    $data_settings = 'data-slider_config="'.htmlspecialchars( json_encode( $this->get_advanced_carousel_options() ) ).'"';
}else {
  $settings = $this->get_settings_for_display();
  $columns       = $settings['slides_to_show'];
  $columnsLaptop = !empty($settings['slides_to_show_laptop']) ? $settings['slides_to_show_laptop'] : $settings['slides_to_show'];
  $columnsTablet = !empty($settings['slides_to_show_tablet']) ? $settings['slides_to_show_tablet'] : 2;
  $columnsTabletPortrait = !empty($settings['slides_to_show_tabletportrait']) ? $settings['slides_to_show_tabletportrait'] : $settings['slides_to_show'];
  $columnsMobile = !empty($settings['slides_to_show_mobile']) ? $settings['slides_to_show_mobile'] : 1;

  $this->add_render_attribute( 'list-container', 'class', array(
   'grid-x',
   'grid-padding-x',
   'grid-padding-y',
   'xxlarge-up-' . $columns,
   'xlarge-up-' . $columnsLaptop,
   'large-up-' . $columnsTabletPortrait,
   'medium-up-' . $columnsTablet,
   'small-up-' . $columnsMobile
  ));
}


if ( filter_var( $use_comment_corner, FILTER_VALIDATE_BOOLEAN ) ) {
	$class_array[] = 'novaworks-testimonials--comment-corner';
}

$classes = implode( ' ', $class_array );

$dir = is_rtl() ? 'rtl' : 'ltr';

?>
<div <?php echo $this->get_render_attribute_string( 'list-container' ); ?> <?php echo $data_settings; ?> dir="<?php echo $dir; ?>">
