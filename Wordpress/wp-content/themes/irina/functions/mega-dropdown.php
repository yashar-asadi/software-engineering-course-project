<?php

if ( !function_exists( 'nova_walk_categories' )):
/**
 * Walk and output the category tree
 *
 * @param  $cat category id
 *
 */
function nova_walk_categories( $cat, $sticky = false ) {
	if (!class_exists('WooCommerce')) return;
	$selected_cats = Nova_OP::getOption('nav_button_categories', 0);
	if ( is_array( $selected_cats ) && $cat == 0):
		$categories =get_terms( array( 'taxonomy' => 'product_cat','hide_empty' => 0, 'parent' => $cat, 'include' => $selected_cats ) );

		$unsorted = array();
		$sorted   = array();

		foreach ($categories as $v) {
			$unsorted[$v->term_id] = $v;
		}

		foreach ($selected_cats as $v) {
			if (isset($unsorted[$v]))
				$sorted[] = $unsorted[$v];
		}

		$next = is_array($sorted)? $sorted : $categories;

	else:
		$next =get_terms( array( 'taxonomy' => 'product_cat', 'menu_order' => 'asc', 'hide_empty' => 0,  'parent' => $cat) );
	endif;

	$has_icons= (Nova_OP::getOption('nav_button_show_category_icons', 1) == 1)? true : false;
	$has_product_counts = (Nova_OP::getOption('nav_button_show_product_counts', 1) == 1)? true : false;
	$icon_class= $has_icons==true? 'has-icons' : '';

	if( $next ) :
		if ($cat != 0):
			echo '<ul class="menu vertical nested">';
		else:
			echo '<ul class="' . $icon_class . ' vertical menu drilldown mega-dropdown-categories" data-drilldown data-auto-height="true" data-animate-height="true" data-parent-link="true">';
		endif;

		$new_products_icon 	= $has_icons?'<i class="irina-icons-ui_star"></i>' : '';
		$on_sale_icon 		= $has_icons?'<i class="irina-icons-ecommerce_discount-symbol"></i>' : '';

		if ( nova_new_products_page_url() !== false ):
			$product_counter = $has_product_counts? '<span class="count">' . nova_count_new_products() . '</span>' : '';
			echo 			'<li>
								<a class="site-secondary-font" href="'. nova_new_products_page_url().'">  ' . $new_products_icon .'   '. nova_new_products_title('') .
								$product_counter . '</a>
							</li>';
		endif;

		if ( nova_sale_page_url() !== false ):
			$product_counter = $has_product_counts? '<span class="count">' . nova_count_sale_products() . '</span>' : '';
			echo 			'<li>
								<a class="site-secondary-font" href="'. nova_sale_page_url().'"> ' . $on_sale_icon . '  '. nova_on_sale_products_title('') .
								$product_counter . '</a>
							</li>';
		endif;

		foreach( $next as $cat ) :
			$icon_type = get_term_meta( $cat->term_id, 'nova_icon_type', true );

			$category_icon = '';
			// Fetch the category icon
			if ( $has_icons ) {
				if ( ($icon_type == 'theme_default') || ($icon_type != 'custom_icon' && get_term_meta( $cat->term_id, 'icon_id', true )) ) {
					$icon = get_term_meta( $cat->term_id, 'icon_id', true );
					$category_icon = '<i class="' . $icon . '"></i>';
				}

				if ($icon_type == 'custom_icon') {
					$thumbnail_id 	= get_term_meta( $cat->term_id, 'icon_img_id', true );
					if ($thumbnail_id)
						$image = wp_get_attachment_thumb_url( $thumbnail_id );
					else
						$image = wc_placeholder_img_src();
					// Prevent esc_url from breaking spaces in urls for image embeds
					// Ref: https://core.trac.wordpress.org/ticket/23605
					$image = str_replace( ' ', '%20', $image );
					$category_icon = '<img src="' . esc_url( $image ) . '"  />';
				}

				if (empty($icon_type)) {
					$icon = 'irina-icons-alignment_align-all-1';
					$category_icon = '<i class="' . $icon . '"></i>';
				}
			}

			// Is it a megamenu?
			if (Nova_OP::getOption('enable_megamenu_' . $cat->term_id, 0) === true):
				// do megamenu stuff
				if ($sticky === true) {
					$fragment = 'sticky-dropdown-';
				} else {
					$fragment = 'dropdown-';
				}
				$product_counter = $has_product_counts? '<span class="count">'. esc_html($cat->count) . '</span>' : '';
				$item_output = '<li class="nova_widedropdown"><a data-toggle="' . $fragment . 'panel-'.$cat->term_id.'" href="'.get_term_link( $cat->term_id ).'">' . $category_icon . '<span>' . $cat->name .'</span> ' . $product_counter . '</a></li>';
				$megamenu_content = '';
				$mega_wrapper = 'class="foundation-mega-menu-content dropdown-pane" data-dropdown data-hover="true" data-hover-pane="true"';

				switch ( Nova_OP::getOption( 'typeof_megamenu_' . $cat->term_id, 'shop_mega')) {
					case 'shop_mega':
						$megamenu_content .= '<div id="' . $fragment . 'panel-'.$cat->term_id.'" ' . $mega_wrapper . '>' . nova_widedropdown_output_shop_mega( $cat->term_id, true ). '</div> ';
						break;

					default:
						break;
				}
				print wp_kses($item_output,'simple');
				add_action($fragment . 'nova_mega_dropdown_megamenu_action', function() use ( $megamenu_content ) { print wp_kses($megamenu_content,'simple'); });
			// Walk the tree normally
			else:
				if (!empty(get_terms( array( 'taxonomy' => 'product_cat','hide_empty' => 0, 'orderby' => 'ASC',  'parent' => $cat->term_id )))):
					echo '<li class="menu-item-has-children">';
				else:
					echo '<li>';
				endif;

				$product_counter = $has_product_counts? '<span class="count">'. esc_html($cat->count) . '</span>' : '';

				echo '<a href="' . get_term_link( $cat->term_id ) . '" title="' . esc_attr($cat->name) . '" ' . '>' . esc_html($category_icon) . esc_html($cat->name) . ' ' .$product_counter . '</a>  ';
				nova_walk_categories( $cat->term_id );
				echo '</li>';
			endif;
		endforeach;
		echo '</ul>';

	endif;
}
endif;
