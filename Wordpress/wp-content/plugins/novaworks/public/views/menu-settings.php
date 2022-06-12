<div id="novamm-panel-settings" class="novamm-panel-settings novamm-panel">
	<# if ( data.depth == 1 ) { #>

	<table class="form-table">
		<tr class="item-visible-fields">
			<th scope="row"><?php esc_html_e( 'Visibility', 'novaworks' ) ?></th>
			<td>
				<label>
					<input type="radio" name="{{ novamm.getFieldName( 'visible', data.data['menu-item-db-id'] ) }}" value="visible" {{ 'visible' == data.megaData.visible ? 'checked="checked"' : '' }}>
					<?php esc_html_e( 'Visible', 'novaworks' ) ?>
				</label>
				&nbsp;
				<label>
					<input type="radio" name="{{ novamm.getFieldName( 'visible', data.data['menu-item-db-id'] ) }}" value="none" {{ 'none' == data.megaData.visible ? 'checked="checked"' : '' }}>
					<?php esc_html_e( 'Hidden', 'novaworks' ) ?>
				</label>
				&nbsp;
				<label>
					<input type="radio" name="{{ novamm.getFieldName( 'visible', data.data['menu-item-db-id'] ) }}" value="hidden" {{ 'hidden' == data.megaData.visible ? 'checked="checked"' : '' }}>
					<?php esc_html_e( 'Soft hidden (keep spacing)', 'novaworks' ) ?>
				</label>
			</td>
		</tr>

		<tr class="item-link-field" style="{{ 'visible' !== data.megaData.visible ? 'display:none' : '' }}">
			<th scope="row"><?php esc_html_e( 'Disable link', 'novaworks' ) ?></th>
			<td>
				<label>
					<input type="checkbox" name="{{ novamm.getFieldName( 'disable_link', data.data['menu-item-db-id'] ) }}" value="1" {{ parseInt( data.megaData.disable_link ) ? 'checked="checked"' : '' }}>
					<?php esc_html_e( 'Disable menu item link', 'novaworks' ) ?>
				</label>
			</td>
		</tr>
	</table>

	<# } #>
</div>
