<?php
$settings = $this->get_settings_for_display();
$layout        = $settings['layout_type'];


if ( filter_var( $settings['show_on_hover'], FILTER_VALIDATE_BOOLEAN ) ) {
	$class_array[] = 'show-overlay-on-hover';
}

$columns       = $settings['columns'];
$columnsLaptop = !empty($settings['columns_laptop']) ? $settings['columns_laptop'] : 'auto';
$columnsTablet = !empty($settings['columns_tablet']) ? $settings['columns_tablet'] : 'auto';
$columnsTabletPortrait = !empty($settings['columns_tabletportrait']) ? $settings['columns_tabletportrait'] : 'auto';
$columnsMobile = !empty($settings['columns_mobile']) ? $settings['columns_mobile'] : 'auto';


$this->add_render_attribute( 'main-container', 'id', 'ig_' . $this->get_id() );

$this->add_render_attribute( 'main-container', 'class', array(
    'novaworks-instagram-gallery',
    'layout-type-' . $layout
) );

$this->add_render_attribute( 'list-container', 'class', array(
    'novaworks-instagram-gallery__list',
    'novaworks-instagram-gallery__instance'
) );

if ( filter_var( $settings['show_on_hover'], FILTER_VALIDATE_BOOLEAN ) ) {
    $this->add_render_attribute( 'list-container', 'class', array(
        'show-overlay-on-hover'
    ) );
}

if( isset($settings['enable_custom_image_height']) && $settings['enable_custom_image_height'] ) {
    $this->add_render_attribute( 'list-container', 'class', array(
        'active-object-fit'
    ) );
}

$this->add_render_attribute( 'list-container', 'data-item_selector', array(
    '.loop__item'
) );

if('grid' == $layout){
    $this->add_render_attribute( 'list-container', 'class', array(
			'grid-x',
			'large-up-' . $columns,
			'large-up-' . $columnsLaptop,
			'medium-up-' . $columnsTablet,
			'medium-ex-up-' . $columnsTabletPortrait,
			'small-up-' . $columnsMobile
    ));
}

if( 'grid' == $layout ) {
    $slider_options = $this->generate_carousel_setting_json();
    if(!empty($slider_options)){
        $this->add_render_attribute( 'list-container', 'data-slider_config', $slider_options );
        $this->add_render_attribute( 'list-container', 'dir', is_rtl() ? 'rtl' : 'ltr' );
        $this->add_render_attribute( 'list-container', 'class', 'js-el nova-slick-slider slick-carousel' );
        $this->add_render_attribute( 'list-container', 'data-la_component', 'AutoCarousel');
    }
}

?>

<div <?php echo $this->get_render_attribute_string( 'main-container' ); ?>>
    <div class="novaworks-instagram-gallery__list_wrapper">
        <div <?php echo $this->get_render_attribute_string( 'list-container' ); ?>>
            <?php $this->render_gallery(); ?>
        </div>
    </div>
</div>
