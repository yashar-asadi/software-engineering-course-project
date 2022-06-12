<?php
if ( !function_exists( 'nova_shopbycat_dropdown' )):
	/**
	 * Build the layout for the "Shop" type megamenu
	 *
	 * @param  int $theID  id of the menu item
	 *
	 * @return html
	 */
	function nova_shopbycat_dropdown($in_cat= false, $loc= false) {
		if ( !NOVA_WOOCOMMERCE_IS_ACTIVE ) return;
			$cat_list = Nova_OP::getOption('shopbycat_product_categories' );
			ob_start();
			$args= array( 'taxonomy' => 'product_cat','hide_empty' => 0, 'menu_order' => 'asc',  'parent' =>0, 'include' => $cat_list );
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
				if ( Nova_OP::getOption('shopbycat_thumbnail', false) == true)
					$sorted = array_slice($cats, 0, 4);
				else
					$sorted = array_slice($cats, 0, 6);
			endif;

			echo '<div class="shopbycat__dropdown-wrap">';

				echo '<div class="row">';

					echo '<div class="large-12 columns">';

						echo '<div class="shopbycat-item_list row small-up-1 medium-up-3 large-up-4">';

						foreach( $sorted as $cat ) {

					    	$category_image_html  = '';
					    	$subcategories_html   = '';

							if ( Nova_OP::getOption('shopbycat_thumbnail', false) == true ):
								$thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
						    	$image = wp_get_attachment_image_src( $thumbnail_id, 'medium_large' );

						    	if (!empty($image[0])) {
						    		$category_image_html = '<span style="background-image: url(' . $image[0] .') "  class="megamenu_thumbnail"></span>';
						    	}
						    endif;

						    if ( Nova_OP::getOption('shopbycat_subcategories', true) == true ):
						    	$subcats = get_terms( array( 'taxonomy' => 'product_cat','hide_empty' => 0, 'menu_order' => 'ASC',  'parent' =>$cat->term_id ) );
						    	if ( !empty ($subcats) && is_array( $subcats) ):
						    		$subcategories_html = '<div class="shopbycat_subcategory_list">';
							    	foreach ( $subcats as $subcat ) {
							    		$subcategory_link_text = is_rtl() ? '<div><a href="%1$s">' : ' <div><a href="%1$s">%3$s ';

										if ( Nova_OP::getOption('shopbycat_counter', false) == true ) {

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

							if ( Nova_OP::getOption('shopbycat_counter', false) == true ) {

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

						    echo '<div class="shopbycat-item column ">'. $category_link . $subcategories_html .'</div>';
						}

						echo '</div>';

					echo '</div>';

				echo '</div>';

			echo '</div>';


			$output = ob_get_contents();
			ob_end_clean();
			return $output;
	}
endif;
