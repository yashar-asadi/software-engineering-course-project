<?php
global $wp_widget_factory;
?>
<div id="novamm-panel-content" class="novamm-panel-content novamm-panel">
	<p>
		<textarea name="{{ novamm.getFieldName( 'content', data.data['menu-item-db-id'] ) }}" class="widefat" rows="20" contenteditable="true">{{{ data.megaData.content }}}</textarea>
	</p>
	<p class="description"><?php esc_html_e( 'Allow HTML and Shortcodes', 'novaworks' ) ?></p>
	<p class="description"><?php esc_html_e( 'Tip: Build your content inside a page with visual page builder then copy generated content here.', 'novaworks' ) ?></p>
</div>