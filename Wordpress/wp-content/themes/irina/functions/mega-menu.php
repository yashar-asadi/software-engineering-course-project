<?php

//==============================================================================
//	Hook into Walker to output our megamenu
//==============================================================================

if ( !function_exists( 'nova_widedropdown_css_classes' )) :

	add_filter( 'nav_menu_css_class', 'nova_widedropdown_css_classes',10,4);
	/**
	 * Add megamenu specific classes to megamenu marked items
	 *
	 * @param  array $classes <li> classes
	 * @param  object $item    menu item
	 * @param  object $args    menu object
	 * @param  int $depth
	 *
	 * @return array  an array of classes
	 */
	function nova_widedropdown_css_classes ( $classes, $item, $args, $depth ) {
		if ( $args->theme_location === 'nova_menu_primary' && // Only for primary navigation
			( Nova_OP::getOption('enable_megamenu_' . $item->ID, 0) == true )) // Is there a megamenu option on this item
		{
			$classes[] = 'nova_widedropdown';
		}
		return $classes;
	}
endif;

if ( !function_exists( 'nova_widedropdown_item' )) :

	add_filter( 'walker_nav_menu_start_el', 'nova_widedropdown_item', 10, 4);
	/**
	 * Add our megamenu html to megamenu items
	 *
	 * @param  string $item_output html output of menu item
	 * @param  object $item        menu item
	 * @param  int $depth
	 * @param  object $args        menu object
	 *
	 * @return string            html for the menu item
	 */
	function nova_widedropdown_item ( $item_output, $item, $depth, $args ) {

		if ($args->theme_location === 'nova_menu_primary' && Nova_OP::getOption('enable_megamenu_' . $item->ID, 0) == true ) {

			$id_fragment = 'primary-';

			$item_output = '<a data-toggle="'.$id_fragment.'panel-'.$item->ID.'" href="'.$item->url.'"><span>' . $item->title .'</span></a>';

			$megamenu_content = '';
			$mega_wrapper = 'class="foundation-mega-menu-content dropdown-pane" data-dropdown data-hover="true" data-hover-pane="true"';
			if('shop_mega' == Nova_OP::getOption( 'typeof_megamenu_' . $item->ID, 'shop_mega')) {
				$megamenu_content .= '<div id="'.$id_fragment.'panel-'.$item->ID.'" ' . $mega_wrapper . '>' . nova_widedropdown_output_shop_mega( $item->ID, false, $args->theme_location ). '</div>';
			}

			if ($args->theme_location == 'nova_menu_primary') {
				add_action($id_fragment . 'nova_widedropdown', function() use ( $megamenu_content ) { print wp_kses($megamenu_content,'simple'); });
			}
		}

		return $item_output;

	}
endif;

if ( !function_exists( 'nova_widedropdown_output_shop_mega' )):
	/**
	 * Build the layout for the "Shop" type megamenu
	 *
	 * @param  int $theID  id of the menu item
	 *
	 * @return html
	 */
	function nova_widedropdown_output_shop_mega( $theID, $in_cat= false, $loc= false) {
		if ( !NOVA_WOOCOMMERCE_IS_ACTIVE ) return;
			$cat_list = Nova_OP::getOption('product_categories_megamenu_' . $theID );
			ob_start();
			if ($in_cat !== true):
				$args= array( 'taxonomy' => 'product_cat','hide_empty' => 0, 'menu_order' => 'asc',  'parent' =>0, 'include' => $cat_list );
			else:
				$args= array( 'taxonomy' => 'product_cat','hide_empty' => 0, 'menu_order' => 'asc',  'parent' =>$theID, 'include' => $cat_list );
			endif;
			$cats = get_terms( $args );
			if ( is_array($cat_list)):
			$unsorted = array();
			$sorted   = array();

			foreach ($cats as $v) {
				$unsorted[$v->term_id] = $v;
			}

			foreach ($cat_list as $v) {
				if (isset($unsorted[$v]))
					$sorted[] = $unsorted[$v];
			}
			else:
				if ( Nova_OP::getOption('thumbnail_shop_megamenu_' . $theID, false) == true)
					$sorted = array_slice($cats, 0, 4);
				else
					$sorted = array_slice($cats, 0, 6);
			endif;

			echo '<div class="foundation-megamenu-item_wrapper">';

				echo '<div class="row">';

					echo '<div class="' . ( Nova_OP::getOption('right_banner_shop_megamenu_' . $theID, false) == true ? ($in_cat== true ? 'large-8': 'large-9') : 'large-12' ) . ' columns">';

						$cno = $in_cat == true ? 2 : 3;

						$cno2 = $in_cat == true ? 3 : 4;

						echo '<div class="foundation-megamenu-item_list row ' . ( Nova_OP::getOption('right_banner_shop_megamenu_' . $theID, false) == true ? 'small-up-1 medium-up-2 large-up-'.$cno : 'small-up-1 medium-up-3 large-up-'.$cno2 ) . '">';

						foreach( $sorted as $cat ) {

					    	$category_image_html  = '';
					    	$subcategories_html   = '';

							if ( Nova_OP::getOption('thumbnail_shop_megamenu_' . $theID, false) == true ):
								$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
						    	$image = wp_get_attachment_image_src( $thumbnail_id, 'medium_large' );

						    	if (!empty($image[0])) {
						    		$category_image_html = '<span style="background-image: url(' . $image[0] .') "  class="megamenu_thumbnail"></span>';
						    	}
						    endif;

						    if ( Nova_OP::getOption('subcategories_shop_megamenu_' . $theID, true) == true ):
						    	$subcats = get_terms( array( 'taxonomy' => 'product_cat','hide_empty' => 0, 'menu_order' => 'ASC',  'parent' =>$cat->term_id ) );
						    	if ( !empty ($subcats) && is_array( $subcats) ):
						    		$subcategories_html = '<div class="megamenu_subcategory_list">';
							    	foreach ( $subcats as $subcat ) {

							    		$subcategory_link_text = is_rtl() ? '<div><a href="%1$s">' : ' <div><a href="%1$s">%3$s ';

										if ( Nova_OP::getOption('product_counter_megamenu_' . $theID, true) == true ) {

											$subcategory_link_text .= '<span class="count">%4$s</span>';
										}

										$subcategory_link_text .=  is_rtl() ? '%3$s</a></div>' : '</a></div>';

							    		$subcategories_html .= sprintf(
									        $subcategory_link_text,
									        esc_url( get_term_link( $subcat->term_id ) ),
									        esc_html( sprintf(__( 'View all posts in %s', 'irina' ), $subcat->name )),
									        esc_html( $subcat->name ),
									        $subcat->count
									    );
							    	}
							    	$subcategories_html .= '</div>';
							    endif;
						    endif;

						    $category_link_text = is_rtl() ? '<a href="%1$s">%3$s ' : '<a href="%1$s">%3$s %4$s ';

							if ( Nova_OP::getOption('product_counter_megamenu_' . $theID, true) == true ) {

								$category_link_text .= '<span class="count">%5$s</span>';
							}

							$category_link_text .=  is_rtl() ? '<span>%4$s</span></a><br/>' : '</a><br/>';

						    $category_link = sprintf(
						        $category_link_text,
						        esc_url( get_term_link( $cat->term_id ) ),
						        esc_html( sprintf(__( 'View all posts in %s', 'irina' ), $cat->name )),
						        $category_image_html,
						        esc_html( $cat->name ),
						        $cat->count
						    );

						    echo '<div class="foundation-megamenu-item column ">'. $category_link . $subcategories_html .'</div>';
						}

						echo '</div>';

					echo '</div>';

					// Right Banner
					$rclumn = 'large-3';
					if($in_cat==true) {
						$rclumn = 'large-4';
					}
					if ( Nova_OP::getOption('right_banner_shop_megamenu_' . $theID, false) == true ):?>
						<div class="<?php echo esc_attr($rclumn); ?> columns">
							<div class="right-banner-box">
								<a href="<?php echo esc_url( Nova_OP::getOption('megamenu_right_banner_url_' . $theID, false) ); ?>"><img alt src="<?php echo esc_url( Nova_OP::getOption('megamenu_right_banner_image_' . $theID, false) ); ?>" /></a>
							</div>
						</div>

					<?php
					endif;

				echo '</div>';

			echo '</div>';


			$output = ob_get_contents();
			ob_end_clean();
			return $output;
	}
endif;
