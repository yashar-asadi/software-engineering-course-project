<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="nova-blog-posts post-display-flex">
			<?php if(has_post_thumbnail()): ?>
				<div class="nova-blog-posts__thumbnail">
					<?php nova_single_post_thumbnail(); ?>
				</div>
			<?php endif; ?>
			<?php
			if ( has_post_format( 'quote' ) && NOVA_RWMB_IS_ACTIVE):
				$quote_content = rwmb_meta('irina_post_quote_content');
				$quote_author = rwmb_meta('irina_post_quote_author');
				$quote_background = rwmb_meta('irina_post_quote_bg_color');
				$quote_color = rwmb_meta('irina_post_quote_text_color');
				$quote_content = '<p class="quote-content">' . $quote_content . '</p>';
				if ( !empty( $quote_author ) ) {
						$quote_content .= '<span class="quote-author">' . $quote_author . '</span>';
				}
				$styles = array();
				$styles[] = 'background-color:' . $quote_background;
				$styles[] = 'color:' . $quote_color;
				echo sprintf( '<div class="nova-blog-posts__content">
				<div class="quote-wrapper" style="%2$s">
				<div class="format-content">%1$s</div></div>
				</div>', $quote_content, esc_attr( implode( ';', $styles ) ) );
			else:
			?>
			<div class="nova-blog-posts__content<?php if(has_post_thumbnail()): ?> has-thumbnail<?php endif?>">
				<?php if(has_category()): ?>
								<div class="cat-list">
								<?php
								$categories = get_the_category();
								$separator = '';
								$output = '';
								if ( ! empty( $categories ) ) :
								?>
										<?php

												foreach( $categories as $category ) {
														$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
												}
												echo trim( $output, $separator );

										?>
								<?php endif?>
								</div>
				<?php endif?>
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
				<?php
				$excerpt_limit = Nova_OP::getOption('limit_excerpt');
				$excerpt_length = Nova_OP::getOption('limit_excerpt_word');
				$excerpt_status = Nova_OP::getOption('blog_post_excerpt');
				if($excerpt_status) {
					if( $excerpt_limit ) {
						if($excerpt_length > 0){
								echo sprintf(
										'<div class="entry-excerpt">%1$s</div>',
										irina_excerpt(intval( $excerpt_length ))
								);
						}
					}else {
						echo sprintf(
								'<div class="entry-excerpt">%1$s</div>',
								get_the_excerpt()
						);
					}
				}
				?>
				<div class="entry-meta">
					<?php echo nova_posted_on(); ?>
					<?php echo esc_html__( 'by', 'irina' );?>
					<a class="author-all-posts" href="<?php echo get_author_posts_url( get_the_author_meta('ID') ) ?>">
						<?php echo get_the_author_meta( 'nickname' ) ?>
					</a>
				</div>
			</div>
		<?php endif // check postformat?>
		</div>
</article>
