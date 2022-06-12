<?php
/**
 * Timeline main template
 */

$settings = $this->get_settings_for_display();

$this->add_render_attribute( 'wrapper', 'class',
	array(
		'novaworks-hor-timeline',
		'novaworks-hor-timeline--layout-' . esc_attr( $settings['vertical_layout'] ),
		'novaworks-hor-timeline--align-' . esc_attr( $settings['horizontal_alignment'] ),
		'novaworks-hor-timeline--' . esc_attr( $settings['navigation_type'] ),
	)
);

$desktop_columns = ! empty( $settings['columns'] ) ? $settings['columns'] : 3;
$tablet_columns = ! empty( $settings['columns_tablet'] ) ? $settings['columns_tablet'] : $desktop_columns;
$mobile_columns = ! empty( $settings['columns_mobile'] ) ? $settings['columns_mobile'] : $tablet_columns;

$data_columns = array(
	'desktop' => $desktop_columns,
	'tablet'  => $tablet_columns,
	'mobile'  => $mobile_columns,
);

$this->add_render_attribute( 'wrapper', 'data-columns', esc_attr( json_encode( $data_columns ) ) );
?>

<div <?php $this->print_render_attribute_string( 'wrapper' ) ?>>
	<div class="novaworks-hor-timeline-inner">
		<div class="novaworks-hor-timeline-track">
			<?php $this->__get_global_looped_template( 'list-top', 'cards_list' ); ?>
			<?php $this->__get_global_looped_template( 'list-middle', 'cards_list' ); ?>
			<?php $this->__get_global_looped_template( 'list-bottom', 'cards_list' ); ?>
		</div>
	</div>
	<?php
		if ( 'arrows-nav' === $settings['navigation_type'] ) {
			echo novaworks_elementor_tools_get_carousel_arrow( ['novaworks-prev-arrow slick-prev novaworks-arrow-disabled'], [$settings['arrow_type']] );
			echo novaworks_elementor_tools_get_carousel_arrow( ['novaworks-next-arrow slick-next'], [ $settings['arrow_type'] ] );
		}
	?>
</div>