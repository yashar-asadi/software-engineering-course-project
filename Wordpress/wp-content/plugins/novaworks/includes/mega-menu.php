<?php
/**
 * Customize and add more data into menu items.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Walker_Nav_Menu_Edit' ) ) {
	require_once ABSPATH . 'wp-admin/includes/nav-menu.php';
}

/**
 * Class Nova_Addons_Waler_Mega_Menu_Edit
 *
 * Class for adding more controllers into a menu item
 */
class Nova_Addons_Waler_Mega_Menu_Edit extends Walker_Nav_Menu_Edit {
	/**
	 * Start the element output.
	 *
	 * @see   Walker_Nav_Menu::start_el()
	 * @since 3.0.0
	 *
	 * @global int   $_wp_nav_menu_max_depth
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 * @param int    $id     Not used.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$mega = get_post_meta( $item->ID, '_menu_item_mega', true );
		$mega = nova_addons_recurse_parse_args( $mega, Nova_Addons_Mega_Menu::default_settings() );

		$item_output = '';
		parent::start_el( $item_output, $item, $depth, $args );

		// Allows plugins to add more fields
		$item_output = preg_replace(
			'/(?=<(p|fieldset)[^>]+class="[^"]*field-move)/',
			$this->custom_fields( $item, $depth, $args ),
			$item_output
		);

		$dom = new DOMDocument();

		$dom->validateOnParse = true;
		$dom->loadHTML( mb_convert_encoding( $item_output, 'HTML-ENTITIES', 'UTF-8' ) );
		$xpath = new DOMXPath( $dom );

		// Remove spaces in href attribute
		$anchors = $xpath->query( "//a" );

		foreach ( array_reverse( iterator_to_array( $anchors ) ) as $anchor ) {
			$anchor->setAttribute( 'href', trim( $anchor->getAttribute( 'href' ) ) );
		}

		// Adds mega menu data holder
		$settings = $xpath->query( "//*[@id='menu-item-settings-" . $item->ID . "']" )->item( 0 );

		if ( $settings ) {
			$node            = $dom->createElement( 'span' );
			$node->nodeValue = $mega['content'];
			unset( $mega['content'] );
			$node->setAttribute( 'data-mega', json_encode( $mega ) );
			$node->setAttribute( 'class', 'hidden mega-data' );
			$settings->appendChild( $node );
		}

		// Add settings link
		$cancel = $xpath->query( "//*[@id='cancel-" . $item->ID . "']" )->item( 0 );

		if ( $cancel ) {
			$link            = $dom->createElement( 'a' );
			$link->nodeValue = esc_html__( 'Settings', 'novaworks' );
			$link->setAttribute( 'class', 'item-config-mega opensettings submitcancel hide-if-no-js' );
			$link->setAttribute( 'href', '#' );
			$sep            = $dom->createElement( 'span' );
			$sep->nodeValue = ' | ';
			$sep->setAttribute( 'class', 'meta-sep hide-if-no-js' );
			$cancel->parentNode->insertBefore( $link, $cancel );
			$cancel->parentNode->insertBefore( $sep, $cancel );
		}

		$output .= $dom->saveHTML();
	}

	/**
	 * Get custom fields from plugins
	 *
	 * @param object $item
	 * @param int    $depth
	 * @param array  $args
	 *
	 * @return string
	 */
	protected function custom_fields( $item, $depth, $args = array() ) {
		ob_start();

		/**
		 * Get menu item custom fields from plugins/themes
		 *
		 * @param object $item  Menu item data object.
		 * @param int    $depth Depth of menu item. Used for padding.
		 * @param array  $args  Menu item args.
		 *
		 * @return string
		 */
		do_action( 'wp_nav_menu_item_custom_fields', $item->ID, $item, $depth, $args );

		return ob_get_clean();
	}
}

/**
 * Class Nova_Mega_Menu_Walker
 *
 * Walker class for mega menu
 */
class Nova_Mega_Menu_Walker extends Walker_Nav_Menu {
	/**
	 * Tells child items know it is in a mega menu or not
	 *
	 * @var bool
	 */
	protected $in_mega = false;

	/**
	 * Mega data of a mega menu
	 *
	 * @var array
	 */
	protected $mega_data = array();

	/**
	 * Mega data of a column
	 *
	 * @var array
	 */
	protected $column_data = array();

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see   Walker::start_lvl()
	 *
	 * @since 1.0.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 */
	public function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		// Default class.
		$classes = array( 'sub-menu' );

		if ( ! $depth && $this->in_mega ) {
			$classes[] = 'mega-menu';
		}

		/**
		 * Filters the CSS class(es) applied to a menu list element.
		 *
		 * @since 4.8.0
		 *
		 * @param array    $classes The CSS classes that are applied to the menu `<ul>` element.
		 * @param stdClass $args    An object of `wp_nav_menu()` arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_submenu_css_class', $classes, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		if ( ! $depth && $this->in_mega ) {
			$mega_style     = $this->get_mega_menu_css();
			$mega_container = $this->get_mega_container_attrs();

			$output .= "{$n}{$indent}<ul$class_names $mega_style>{$n}";
			$output .= "{$n}{$indent}<li$mega_container>{$n}";
			$output .= "{$n}{$indent}<ul class='mega-menu-main'>{$n}";
		} else {
			$output .= "{$n}{$indent}<ul$class_names>{$n}";
		}
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see   Walker::end_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = str_repeat( $t, $depth );

		if ( ! $depth && $this->in_mega ) {
			$output .= "$indent</ul></li></ul>{$n}";
		} else {
			$output .= "$indent</ul>{$n}";
		}
	}

	/**
	 * Start the element output.
	 * Display item description text and classes
	 *
	 * @see   Walker::start_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   An array of arguments. @see wp_nav_menu()
	 * @param int    $id     Current item ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$item_mega = get_post_meta( $item->ID, '_menu_item_mega', true );
		$item_mega = nova_addons_recurse_parse_args( $item_mega, Nova_Addons_Mega_Menu::default_settings() );

		// Store mega data
		if ( ! $depth ) {
			$this->in_mega   = $item_mega['mega'];
			$this->mega_data = $item_mega;
		} elseif ( 1 == $depth ) {
			$this->column_data = $item_mega;
		}

		if ( ! $this->in_mega ) {
			$output .= parent::start_el( $output, $item, $depth, $args, $id );
			return;
		}

		if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
			$t = '';
			$n = '';
		} else {
			$t = "\t";
			$n = "\n";
		}
		$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

		// Get mega data from post meta
		$item_css  = '';

		$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		/**
		 * Filters the arguments for a single nav menu item.
		 *
		 * @since 4.4.0
		 *
		 * @param array  $args  An array of arguments.
		 * @param object $item  Menu item data object.
		 * @param int    $depth Depth of menu item. Used for padding.
		 */
		$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

		// Adding icon
		if ( $item_mega['icon'] ) {
			$classes[] = 'menu-item-has-icon';
		}

		// Adding classes for mega menu
		if ( $item_mega['mega'] && ! $depth ) {
			$classes[] = 'menu-item-mega';

			if ( $item_mega['background']['image'] ) {
				$classes[] = 'menu-item-has-background';
			}
		}

		// Add classes for columns
		if ( 1 == $depth && $this->in_mega ) {
			$classes[] = 'mega-sub-menu ' . $this->get_column_class( $item_mega['width'] );

			if ( 'hidden' == $item_mega['visible'] ) {
				$classes[]                 = 'hide-title';
				$item_mega['disable_link'] = true;
			} elseif ( 'none' == $item_mega['visible'] ) {
				$classes[] = 'hide-link';
			}

			if ( $item_mega['disable_link'] ) {
				$classes[] = 'link-disabled';
			}

			$item_css = $this->get_column_css();
		}

		/**
		 * Filters the CSS class(es) applied to a menu item's list item element.
		 *
		 * @since 3.0.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		/**
		 * Filters the ID applied to a menu item's list item element.
		 *
		 * @since 3.0.1
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
		 * @param WP_Post  $item    The current menu item.
		 * @param stdClass $args    An object of wp_nav_menu() arguments.
		 * @param int      $depth   Depth of menu item. Used for padding.
		 */
		$item_id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
		$item_id = $item_id ? ' id="' . esc_attr( $item_id ) . '"' : '';

		$output .= $indent . '<li' . $item_id . $class_names . $item_css . '>';

		$atts           = array();
		$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
		$atts['target'] = ! empty( $item->target ) ? $item->target : '';
		$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
		$atts['href']   = ! empty( $item->url ) ? $item->url : '';

		/**
		 * Filters the HTML attributes applied to a menu item's anchor element.
		 *
		 * @since 3.6.0
		 * @since 4.1.0 The `$depth` parameter was added.
		 *
		 * @param array    $atts   {
		 *                         The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 * @type string    $title  Title attribute.
		 * @type string    $target Target attribute.
		 * @type string    $rel    The rel attribute.
		 * @type string    $href   The href attribute.
		 * }
		 *
		 * @param WP_Post  $item   The current menu item.
		 * @param stdClass $args   An object of wp_nav_menu() arguments.
		 * @param int      $depth  Depth of menu item. Used for padding.
		 */
		$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$value      = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		// Check if link is disable
		if ( $this->in_mega && $depth == 1 && $item_mega['disable_link'] ) {
			$link_open = '<span>';
		} else {
			$link_open = '<a' . $attributes . '>';
		}

		// Adds icon
		if ( $item_mega['icon'] ) {
			$icon = '<i class="' . esc_attr( $item_mega['icon'] ) . '"></i>';
		} else {
			$icon = '';
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = apply_filters( 'the_title', $item->title, $item->ID );

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string $title The menu item's title.
		 * @param object $item  The current menu item.
		 * @param array  $args  An array of wp_nav_menu() arguments.
		 * @param int    $depth Depth of menu item. Used for padding.
		 */
		$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

		// Check if link is disable
		if ( $this->in_mega && $depth == 1 && $item_mega['disable_link'] ) {
			$link_close = '</span>';
		} else {
			$link_close = '</a>';
		}

		$item_output = $args->before;
		$item_output .= $link_open;
		$item_output .= $args->link_before . $icon . $title . $args->link_after;
		$item_output .= $link_close;
		$item_output .= $args->after;

		if ( 1 <= $depth && ! empty( $item_mega['content'] ) ) {
			$item_output .= '<div class="menu-item-content">' . do_shortcode( $item_mega['content'] ) . '</div>';
		}

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	/**
	 * Get column class name
	 *
	 * @param string $width
	 *
	 * @return string
	 */
	public function get_column_class( $width = '20.00%' ) {
		$columns = array(
			'1_8' => '12.50%',
			'1_5' => '20%',
			'1_4' => '25.00%',
			'1_3' => '33.33%',
			'3_8' => '37.50%',
			'1_2' => '50.00%',
			'5_8' => '62.50%',
			'2_3' => '66.66%',
			'3_4' => '75.00%',
			'7_8' => '87.50%',
			'1_1' => '100.00%',
		);

		$column = array_search( $width, $columns );
		$column = false === $column ? '1_5' : $column;

		return 'col-' . $column;
	}

	/**
	 * Get inline style attribute
	 * Generate margin, padding, background properties.
	 *
	 * @return string
	 */
	public function get_column_css() {
		if ( ! $this->in_mega ) {
			return '';
		}

		return $this->get_css( $this->column_data );
	}

	/**
	 * Get inline css for mega menu container
	 *
	 * @return string
	 */
	public function get_mega_menu_css() {
		if ( ! $this->in_mega ) {
			return '';
		}

		$data = $this->mega_data;
		unset( $data['margin'] );
		unset( $data['padding'] );

		return $this->get_css( $data );
	}

	/**
	 * Generate the style attribute
	 *
	 * @param array $data
	 *
	 * @return string
	 */
	protected function get_css( $data ) {
		$props = array();

		if ( ! empty( $data['background'] ) ) {
			if ( $data['background']['color'] ) {
				$props['background-color'] = $data['background']['color'];
			}

			if ( $data['background']['image'] ) {
				$props['background-image']      = 'url(' . $data['background']['image'] . ')';
				$props['background-attachment'] = $data['background']['attachment'];
				$props['background-repeat']     = $data['background']['repeat'];

				if ( $data['background']['size'] ) {
					$props['background-size'] = $data['background']['size'];

					if ( 'cover' == $data['background']['size'] ) {
						unset( $props['background-repeat'] );
					}
				}

				if ( $data['background']['position']['x'] == 'custom' ) {
					$position_x = $data['background']['position']['custom']['x'];
				} else {
					$position_x = $data['background']['position']['x'];
				}

				if ( $data['background']['position']['y'] == 'custom' ) {
					$position_y = $data['background']['position']['custom']['y'];
				} else {
					$position_y = $data['background']['position']['y'];
				}

				$props['background-position'] = $position_x . ' ' . $position_y;
			}
		}

		if ( ! empty( $data['padding'] ) ) {
			if ( '' != $data['padding']['top'] ) {
				$props['padding-top'] = $data['padding']['top'];
			}

			if ( '' != $data['padding']['bottom'] ) {
				$props['padding-bottom'] = $data['padding']['bottom'];
			}

			if ( '' != $data['padding']['left'] ) {
				$props['padding-left'] = $data['padding']['left'];
			}

			if ( '' != $data['padding']['right'] ) {
				$props['padding-right'] = $data['padding']['right'];
			}
		}

		if ( ! empty( $data['margin'] ) ) {
			if ( ! empty( $data['margin']['top'] ) ) {
				$props['margin-top'] = $data['margin']['top'];
			}

			if ( '' != $data['margin']['bottom'] ) {
				$props['margin-bottom'] = $data['margin']['bottom'];
			}

			if ( '' != $data['margin']['left'] ) {
				$props['margin-left'] = $data['margin']['left'];
			}

			if ( '' != $data['margin']['right'] ) {
				$props['margin-right'] = $data['margin']['right'];
			}
		}

		if ( empty( $props ) ) {
			return '';
		}

		$style = '';
		foreach ( $props as $prop => $value ) {
			$style .= $prop . ':' . esc_attr( $value ) . ';';
		}

		return ' style="' . $style . '"';
	}

	/**
	 * Get mega container tag attributes
	 *
	 * @return string
	 */
	protected function get_mega_container_attrs() {
		if ( ! $this->in_mega ) {
			return '';
		}

		$class = array( 'mega-menu-container' );

		if ( 'custom' == $this->mega_data['width'] ) {
			$class[] = 'container-custom';
			$attrs   = ' class="' . esc_attr( join( ' ', $class ) ) . '"';
			$attrs   .= ' style="width: ' . esc_attr( $this->mega_data['custom_width'] ) . '"';
		} elseif ( in_array( $this->mega_data['width'], array( 'container', 'container-fluid' ) ) ) {
			$class[] = $this->mega_data['width'];
			$attrs   = ' class="' . esc_attr( join( ' ', $class ) ) . '"';
		} else {
			$class[] = 'container';
			$attrs   = ' class="' . esc_attr( join( ' ', $class ) ) . '"';
		}

		return $attrs;
	}
}

/**
 * Class Nova_Addons_Mega_Menu
 *
 * Main class for supporting mega men in the theme.
 */
class Nova_Addons_Mega_Menu {
	/**
	 * Modal screen of mega menu settings
	 *
	 * @var array
	 */
	public $modals = array();

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->modals = apply_filters( 'nova_addons_mega_menu_modal_panels', array(
			'menu',
			'title',
			'mega',
			'design',
			'icon',
			'content',
			'design',
			'settings',
		) );

		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'edit_walker' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'admin_footer-nav-menus.php', array( $this, 'modal' ) );
		add_action( 'admin_footer-nav-menus.php', array( $this, 'templates' ) );
		add_action( 'wp_ajax_nova_addons_save_menu_item_data', array( $this, 'save_menu_item_data' ) );
	}

	/**
	 * Change walker class for editing nav menu
	 *
	 * @return string
	 */
	public function edit_walker() {
		return 'Nova_Addons_Waler_Mega_Menu_Edit';
	}

	/**
	 * Load scripts on Menus page only
	 *
	 * @param string $hook
	 */
	public function scripts( $hook ) {
		if ( 'nav-menus.php' !== $hook ) {
			return;
		}
		wp_register_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
		wp_register_style( 'nova-addons-mega-menu-admin', get_template_directory_uri() . '/assets/css/admin.mega-menu.css', array(
			'media-views',
			'wp-color-picker',
			'font-awesome',
		) );
		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'nova-addons-mega-menu-admin' );

		wp_register_script( 'nova-addons-mega-menu-admin', NOVA_PLUGIN_URL . 'public/js/admin/mega-menu.js', array(
			'jquery',
			'jquery-ui-resizable',
			'wp-util',
			'wp-color-picker',
		), null, true );
		wp_enqueue_media();
		wp_enqueue_script( 'nova-addons-mega-menu-admin' );

		wp_localize_script( 'nova-addons-mega-menu-admin', 'novaMenuModal', $this->modals );
	}

	/**
	 * Prints HTML of modal on footer
	 */
	public function modal() {
		?>
		<div id="novamm-mega-menu" tabindex="0" class="novamm-mega-menu">
			<div class="novamm-modal media-modal wp-core-ui">
				<button type="button" class="button-link media-modal-close novamm-modal-close">
					<span class="media-modal-icon"><span class="screen-reader-text"><?php esc_html_e( 'Close', 'novaworks' ) ?></span></span>
				</button>
				<div class="media-modal-content">
					<div class="novamm-frame-menu media-frame-menu">
						<div class="novamm-menu media-menu"></div>
					</div>
					<div class="novamm-frame-title media-frame-title"></div>
					<div class="novamm-frame-content media-frame-content">
						<div class="novamm-content"></div>
					</div>
					<div class="novamm-frame-toolbar media-frame-toolbar">
						<div class="novamm-toolbar media-toolbar">
							<div class="novamm-toolbar-primary media-toolbar-primary search-form">
								<button type="button" class="button novamm-button-save media-button button-primary button-large"><?php esc_html_e( 'Save Changes', 'novaworks' ) ?></button>
								<button type="button" class="button novamm-button-cancel media-button button-secondary button-large"><?php esc_html_e( 'Cancel', 'novaworks' ) ?></button>
								<span class="spinner"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="media-modal-backdrop novamm-modal-backdrop"></div>
		</div>
		<?php
	}

	/**
	 * Prints underscore template on footer
	 */
	public function templates() {
		foreach ( $this->modals as $template ) {
			$file = NOVA_PLUGIN_PATH . 'public/views/menu-' . $template . '.php';

			if ( ! file_exists( $file ) ) {
				continue;
			}
			?>
			<script type="text/html" id="tmpl-novamm-<?php echo esc_attr( $template ) ?>">
				<?php include( $file ); ?>
			</script>
			<?php
		}
	}

	/**
	 * Ajax function to save menu item data
	 */
	public function save_menu_item_data() {
		$_POST['data'] = stripslashes_deep( $_POST['data'] );
		parse_str( $_POST['data'], $data );
		$updated = $data;

		// Save menu item data
		foreach ( $data['menu-item-mega'] as $id => $meta ) {
			$old_meta = get_post_meta( $id, '_menu_item_mega', true );
			$old_meta = nova_addons_recurse_parse_args( $old_meta, Nova_Addons_Mega_Menu::default_settings() );
			$meta     = nova_addons_recurse_parse_args( $meta, $old_meta );

			$updated['menu-item-mega'][ $id ] = $meta;

			update_post_meta( $id, '_menu_item_mega', $meta );
		}

		wp_send_json_success( $updated );
	}

	/**
	 * Define default mega menu settings
	 */
	public static function default_settings() {
		return apply_filters(
			'nova_addons_mega_menu_default',
			array(
				'mega'         => false,
				'icon'         => '',
				'visible'      => 'visible',
				'disable_link' => false,
				'content'      => '',
				'width'        => 'container',
				'custom_width' => '1140px',
				'padding'      => array(
					'top'    => '',
					'bottom' => '',
					'left'   => '',
					'right'  => '',
				),
				'margin'       => array(
					'top'    => '',
					'bottom' => '',
					'left'   => '',
					'right'  => '',
				),
				'background'   => array(
					'image'      => '',
					'color'      => '',
					'attachment' => 'scroll',
					'size'       => '',
					'repeat'     => 'no-repeat',
					'position'   => array(
						'x'      => 'left',
						'y'      => 'top',
						'custom' => array(
							'x' => '',
							'y' => '',
						),
					),
				),
			)
		);
	}
}

new Nova_Addons_Mega_Menu();
