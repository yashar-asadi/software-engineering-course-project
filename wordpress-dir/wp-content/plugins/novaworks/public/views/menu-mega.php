<div id="novamm-panel-mega" class="novamm-panel-mega novamm-panel">
	<p class="mega-settings">
		<span class="setting-field">
			<label>
				<?php esc_html_e( 'Enable mega menu', 'novaworks' ) ?><br>
				<select name="{{ novamm.getFieldName( 'mega', data.data['menu-item-db-id'] ) }}">
					<option value="0"><?php esc_html_e( 'No', 'novaworks' ) ?></option>
					<option value="1" {{ parseInt( data.megaData.mega ) ? 'selected="selected"' : '' }}><?php esc_html_e( 'Yes', 'novaworks' ) ?></option>
				</select>
			</label>
		</span>

		<span class="setting-field novamm-mega-width-field">
			<label>
				<?php esc_html_e( 'Container width', 'novaworks' ) ?><br>
				<select name="{{ novamm.getFieldName( 'width', data.data['menu-item-db-id'] ) }}">
					<option value="container"><?php esc_html_e( 'Default', 'novaworks' ) ?></option>
					<option value="container-fluid" {{ 'container-fluid' == data.megaData.width ? 'selected="selected"' : '' }}><?php esc_html_e( 'Fluid', 'novaworks' ) ?></option>
					<option value="custom" {{ 'custom' == data.megaData.width ? 'selected="selected"' : '' }}><?php esc_html_e( 'Custom', 'novaworks' ) ?></option>
				</select>
			</label>
		</span>


		<span class="setting-field" style="{{ 'custom' == data.megaData.width ? '' : 'display: none;' }}">
			<label>
				<?php esc_html_e( 'Custom width', 'novaworks' ) ?><br>
				<input type="text" name="{{ novamm.getFieldName( 'custom_width', data.data['menu-item-db-id'] ) }}" placeholder="1140px" value="{{ data.megaData.custom_width }}">
			</label>
		</span>
	</p>

	<div id="novamm-mega-content" class="novamm-mega-content">
		<#
		var items = _.filter( data.children, function( item ) {
		return item.subDepth == 0;
		} );
		#>
		<# _.each( items, function( item, index ) { #>

		<div class="novamm-submenu-column" data-width="{{ item.megaData.width }}">
			<ul>
				<li class="menu-item menu-item-depth-{{ item.subDepth }}">
					<# if ( item.megaData.icon ) { #>
					<i class="{{ item.megaData.icon }}"></i>
					<# } #>
					{{{ item.data['menu-item-title'] }}}
					<# if ( item.subDepth == 0 ) { #>
					<span class="novamm-column-handle novamm-resizable-e"><i class="dashicons dashicons-arrow-left-alt2"></i></span>
					<span class="novamm-column-width-label"></span>
					<span class="novamm-column-handle novamm-resizable-w"><i class="dashicons dashicons-arrow-right-alt2"></i></span>
					<input type="hidden" name="{{ novamm.getFieldName( 'width', item.data['menu-item-db-id'] ) }}" value="{{ item.megaData.width }}" class="menu-item-width">
					<# } #>
				</li>
			</ul>
		</div>

		<# } ) #>
	</div>
</div>
