<?php
/**
 * Images Layout template
 */
$settings = $this->get_settings_for_display();

$classes_list[] = 'layout-type-' . $settings['layout_type'];
$classes = implode( ' ', $classes_list );
?>

<div class="novaworks-images-layout <?php echo $classes; ?>">
	<?php $this->__get_global_looped_template( 'images-layout', 'image_list' ); ?>
</div>