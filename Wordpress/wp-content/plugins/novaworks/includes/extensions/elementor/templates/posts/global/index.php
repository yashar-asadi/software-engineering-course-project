<?php
/**
 * Posts template
 */

$settings = $this->get_settings_for_display();

$preset        = $settings['preset'];
$layout        = $settings['layout_type'];
$columns       = $settings['columns'];
$columnsLaptop = !empty($settings['columns_laptop']) ? $settings['columns_laptop'] : 'auto';
$columnsTablet = !empty($settings['columns_tablet']) ? $settings['columns_tablet'] : 'auto';
$columnsTabletPortrait = !empty($settings['columns_tabletportrait']) ? $settings['columns_tabletportrait'] : 'auto';
$columnsMobile = !empty($settings['columns_mobile']) ? $settings['columns_mobile'] : 'auto';

$this->add_render_attribute( 'main-container', 'id', 'novapost_' . $this->get_id() );

$this->add_render_attribute( 'main-container', 'class', array(
	'novaworks-posts',
	'layout-type-' . $layout,
	'type-' . $preset,
) );

if(false !== strpos($preset, 'grid')){
    $this->add_render_attribute( 'main-container', 'class', array(
        'novaworks-posts--grid'
    ) );
}
else{
    $this->add_render_attribute( 'main-container', 'class', array(
        'novaworks-posts--list'
    ) );
}

$this->add_render_attribute( 'list-container', 'class', array(
    'novaworks-posts__list'
) );

$this->add_render_attribute( 'list-container', 'data-item_selector', array(
    '.loop__item'
) );


if('grid' == $layout){
    $grid_css_classes = array('grid-items');
    $this->add_render_attribute( 'list-container', 'class', array(
			'grid-x',
			'grid-padding-x',
			'grid-padding-y',
			'xxlarge-up-' . $columns,
			'xlarge-up-' . $columnsLaptop,
			'large-up-' . $columnsTablet,
			'medium-up-' . $columnsTabletPortrait,
			'small-up-' . $columnsMobile
    ));
}

$slider_options = $this->generate_carousel_setting_json();
if(!empty($slider_options)){
    $this->add_render_attribute( 'list-container', 'data-slider_config', $slider_options );
    $this->add_render_attribute( 'list-container', 'dir', is_rtl() ? 'rtl' : 'ltr' );
    $this->add_render_attribute( 'list-container', 'class', 'js-el nova-slick-slider slick-carousel' );
}

$the_query = $this->the_query();

?>

<div <?php echo $this->get_render_attribute_string( 'main-container' ); ?>><?php

    if($the_query->have_posts()){
        ?>
    <div class="novaworks-posts__list_wrapper">
        <div <?php echo $this->get_render_attribute_string( 'list-container' ); ?>>
        <?php

        while ($the_query->have_posts()){

            $the_query->the_post();

            $this->_load_template( $this->__get_global_template( 'loop-item' ) );

            $this->item_counter++;
            $this->__processed_index++;
        }

        ?>
        </div>
    </div>

    <?php
        $this->item_counter = 0;
        $this->__processed_index = 0;
    }
    ?>
</div>
