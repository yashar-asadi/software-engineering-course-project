<?php
/**
 * Advanced carousel template
 */
$layout     = $this->get_settings_for_display( 'item_layout' );
$equal_cols = $this->get_settings_for_display( 'equal_height_cols' );
$arrow_style = $this->get_settings_for_display( 'arrow_style' );
$cols_class = ( 'true' === $equal_cols ) ? ' novaworks-equal-cols' : '';

$cols_class .= ' novaworks-advance-carousel-layout-' . $layout;
$cols_class .= ' arrow-style-' . $arrow_style;

?>
<div class="novaworks-carousel-wrap<?php echo $cols_class; ?>">
	<?php $this->__get_global_looped_template( esc_attr( $layout ) . '/items', 'items_list' ); ?>
</div>
