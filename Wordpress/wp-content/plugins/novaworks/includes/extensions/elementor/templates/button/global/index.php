<?php

use Elementor\Icons_Manager;

$settings = $this->get_settings_for_display();

$position = $this->get_settings_for_display( 'button_icon_position' );
$use_icon = $this->get_settings_for_display( 'use_button_icon' );
$hover_effect = $this->get_settings_for_display( 'hover_effect' );

$button_icon_normal = $this->get_settings_for_display( 'button_icon_normal' );
$button_icon_hover = $this->get_settings_for_display( 'button_icon_hover' );

$this->add_render_attribute( 'novaworks-button', 'class', 'novaworks-button__instance' );
$this->add_render_attribute( 'novaworks-button', 'class', 'novaworks-button__instance--icon-' . $position );
$this->add_render_attribute( 'novaworks-button', 'class', 'hover-' . $hover_effect );

$tag = 'div';

if ( ! empty( $settings['button_url']['url'] ) ) {
	$this->add_render_attribute( 'novaworks-button', 'href', $settings['button_url']['url'] );

	if ( $settings['button_url']['is_external'] ) {
		$this->add_render_attribute( 'novaworks-button', 'target', '_blank' );
	}

	if ( $settings['button_url']['nofollow'] ) {
		$this->add_render_attribute( 'novaworks-button', 'rel', 'nofollow' );
	}

	$tag = 'a';
}

?>
<div class="novaworks-button__container">
	<<?php echo $tag; ?> <?php echo $this->get_render_attribute_string( 'novaworks-button' ); ?>>
		<div class="novaworks-button__plane novaworks-button__plane-normal"></div>
		<div class="novaworks-button__plane novaworks-button__plane-hover"></div>
		<div class="novaworks-button__state novaworks-button__state-normal">
			<?php
				if ( filter_var( $use_icon, FILTER_VALIDATE_BOOLEAN ) ) {
                    if ( !empty( $button_icon_normal['value'] ) ) {
                        echo '<span class="novaworks-button__icon">';
	                    Icons_Manager::render_icon( $button_icon_normal, [ 'aria-hidden' => 'true' ] );
	                    echo '</span>';
                    }
				}
				echo $this->__html( 'button_label_normal', '<span class="novaworks-button__label">%s</span>' );
			?>
		</div>
		<div class="novaworks-button__state novaworks-button__state-hover">
			<?php
				if ( filter_var( $use_icon, FILTER_VALIDATE_BOOLEAN ) ) {
					if ( !empty( $button_icon_hover['value'] ) ) {
						echo '<span class="novaworks-button__icon">';
						Icons_Manager::render_icon( $button_icon_hover, [ 'aria-hidden' => 'true' ] );
						echo '</span>';
					}
				}
				echo $this->__html( 'button_label_hover', '<span class="novaworks-button__label">%s</span>' );
			?>
		</div>
	</<?php echo $tag; ?>>
</div>
