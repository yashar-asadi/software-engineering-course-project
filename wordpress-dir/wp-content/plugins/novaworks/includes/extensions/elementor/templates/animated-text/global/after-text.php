<?php
/**
 * Animated after text template
 */
$settings = $this->get_settings_for_display();
?>
<div class="novaworks-animated-text__after-text">
	<?php
		echo '&nbsp;' . $this->str_to_spanned_html( $settings['after_text_content'], 'word' );
	?>
</div>
