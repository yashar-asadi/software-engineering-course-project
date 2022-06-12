<?php
// Vendors
require_once( get_template_directory() . '/functions/admin-setup.php' );

// Helpers
require_once( get_template_directory() . '/functions/helpers.php' );

// Filters
require_once( get_template_directory() . '/functions/filters.php' );

// Breadcrumbs
require_once( get_template_directory() . '/functions/breadcrumbs.php' );

// Ajax
require_once( get_template_directory()	. '/functions/ajax-setup.php' );

// Body Classes
require_once( get_template_directory() . '/functions/body-classes.php' );

// Menus
require_once( get_template_directory() . '/inc/menus/menus.php' );

// Elementor
require_once( get_template_directory() . '/functions/nova-elementor.php' );
// Metabox
if ( NOVA_RWMB_IS_ACTIVE ) {
require_once( get_template_directory() . '/functions/metabox.php' );
}
// Customiser
require_once( get_template_directory() . '/inc/customizer/frontend.php' );
require_once( get_template_directory() . '/inc/customizer/backend.php' );
require_once( get_template_directory() . '/inc/customizer/styles.php' );
require_once( get_template_directory() . '/inc/customizer/read_options.php' );

// Theme Setup
require_once( get_template_directory() . '/functions/menu-walkers.php' );
require_once( get_template_directory() . '/functions/mega-menu.php' );
require_once( get_template_directory() . '/functions/theme-setup.php' );
require_once( get_template_directory() . '/functions/ajax-search.php' );
require_once( get_template_directory() . '/functions/shopbycat.php' );

// Enqueue Styles & Scripts
require_once( get_template_directory() . '/functions/enqueue/default-fonts.php' );
require_once( get_template_directory() . '/functions/enqueue/google-fonts.php' );
require_once( get_template_directory() . '/functions/enqueue/theme-icon-fonts.php' );
require_once( get_template_directory() . '/functions/enqueue/styles.php' );
require_once( get_template_directory() . '/functions/enqueue/scripts.php' );
require_once( get_template_directory() . '/functions/enqueue/admin-styles.php' );
require_once( get_template_directory() . '/functions/enqueue/admin-scripts.php' );

// WP
require_once( get_template_directory() . '/functions/wp/filters.php' );
require_once( get_template_directory() . '/functions/wp/archive-title.php' );
require_once( get_template_directory() . '/functions/wp/archive-meta.php' );

// WC
require_once( get_template_directory() . '/functions/wc/actions.php' );
require_once( get_template_directory() . '/functions/wc/filters.php' );
require_once( get_template_directory() . '/functions/wc/custom.php' );

// Widgets
require_once( get_template_directory() . '/inc/widgets/widget-areas.php' );
