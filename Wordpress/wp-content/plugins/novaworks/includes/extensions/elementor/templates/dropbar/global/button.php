<?php
/**
 * Dropbar button template
 */

use Elementor\Icons_Manager;

$settings = $this->get_settings_for_display();

$this->add_render_attribute( 'button', 'class', 'novaworks-dropbar__button' );

if ( isset( $settings['button_hover_animation'] ) && $settings['button_hover_animation'] ) {
	$this->add_render_attribute( 'button', 'class', 'elementor-animation-' . esc_attr( $settings['button_hover_animation'] ) );
}

$button_before_icon = $this->get_settings_for_display('button_before_icon');
$button_after_icon = $this->get_settings_for_display('button_after_icon');

?>

<button <?php $this->print_render_attribute_string( 'button' ); ?>><?php

	if ( !empty( $button_before_icon['value'] ) ) {
		echo '<span class="novaworks-dropbar__button-icon novaworks-dropbar__button-icon--before">';
		Icons_Manager::render_icon( $button_before_icon, [ 'aria-hidden' => 'true' ] );
		echo '</span>';
	}

	$this->__html( 'button_text', '<span class="novaworks-dropbar__button-text">%s</span>' );

	if ( !empty( $button_after_icon['value'] ) ) {
		echo '<span class="novaworks-dropbar__button-icon novaworks-dropbar__button-icon--after">';
		Icons_Manager::render_icon( $button_after_icon, [ 'aria-hidden' => 'true' ] );
		echo '</span>';
	}

?></button>
