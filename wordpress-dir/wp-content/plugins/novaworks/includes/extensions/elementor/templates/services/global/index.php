<?php
/**
 * Services main template
 */
$classes_list[] = 'novaworks-services';

$show_on_hover = $this->get_settings_for_display( 'show_on_hover' );
$header_position = $this->get_settings_for_display( 'header_position' );

$classes_list[] = 'novaworks-services--header-position-' . $header_position;

if ( filter_var( $show_on_hover, FILTER_VALIDATE_BOOLEAN ) ) {
	$classes_list[] = 'novaworks-services--cover-hover';
}

$classes = implode( ' ', $classes_list );

?>
<div class="<?php echo $classes; ?>">
	<div class="novaworks-services__inner">
		<div class="novaworks-services__header">
			<div class="novaworks-services__cover"><?php
			echo $this->__generate_icon( true );
			echo $this->__generate_title( true );
			echo $this->__generate_description( true );
			echo $this->__generate_action_button( true ); ?></div>
		</div>
		<div class="novaworks-services__content"><?php
			echo $this->__generate_icon();
			echo $this->__generate_title();
			echo $this->__generate_description();
			echo $this->__generate_action_button(); ?></div>
	</div>
</div>
