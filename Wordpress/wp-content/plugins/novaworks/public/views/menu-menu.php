<# if ( data.depth == 0 ) { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Mega Menu', 'novaworks' ) ?>" data-panel="mega"><?php esc_html_e( 'Mega Menu', 'novaworks' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Mega Menu Design', 'novaworks' ) ?>" data-panel="design"><?php esc_html_e( 'Design', 'novaworks' ) ?></a>
<div class="separator"></div>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'novaworks' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'novaworks' ) ?></a>
<# } else if ( data.depth == 1 ) { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Setting', 'novaworks' ) ?>" data-panel="settings"><?php esc_html_e( 'Settings', 'novaworks' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Mega Column Design', 'novaworks' ) ?>" data-panel="design"><?php esc_html_e( 'Design', 'novaworks' ) ?></a>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Content', 'novaworks' ) ?>" data-panel="content"><?php esc_html_e( 'Content', 'novaworks' ) ?></a>
<div class="separator"></div>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'novaworks' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'novaworks' ) ?></a>
<# } else { #>
<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Content', 'novaworks' ) ?>" data-panel="content"><?php esc_html_e( 'Content', 'novaworks' ) ?></a>
<div class="separator"></div>
<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'novaworks' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'novaworks' ) ?></a>
<# } #>
