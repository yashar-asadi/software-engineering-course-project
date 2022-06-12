<div class="cell">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="nova-blog-posts post-display-block">
			<?php if(has_post_thumbnail()): ?>
				<div class="nova-blog-posts__thumbnail">
					<?php nova_single_post_thumbnail(); ?>
				</div>
			<?php endif; ?>
			<div class="nova-blog-posts__content<?php if(has_post_thumbnail()): ?> has-thumbnail<?php endif?>">
				<?php if(has_category()): ?>
								<div class="cat-list-simple">
								<?php
								$categories = get_the_category();
								$separator = '';
								$output = '';
								if ( ! empty( $categories ) ) :
								?>
										<?php
												$i = 1;
												foreach( $categories as $category ) {
														if( 3 < $i) {
															$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
														}
														$i ++;
												}
												echo trim( $output, $separator );

										?>
								<?php endif?>
								</div>
				<?php endif?>
				<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
				<div class="entry-meta">
					<a class="author-all-posts" href="<?php echo get_author_posts_url( get_the_author_meta('ID') ) ?>">
						<figure>
							<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
						</figure>
						<span><?php echo get_the_author_meta( 'nickname' ) ?></span>
					</a>
					<div class="dot"></div>
					<?php echo nova_posted_on(); ?>
					<?php if(has_category()): ?>
						<?php
						$categories = get_the_category();
						$separator = ', ';
						$output = '';
						if ( ! empty( $categories ) ) :
						?>
							<div class="dot"></div>
							<div class="entry-meta__cat">
								<?php

										foreach( $categories as $category ) {
												$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'irina' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
										}
										echo trim( $output, $separator );

								?>
							</div>
						<?php endif?>
					<?php endif?>
				</div>
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
				<div class="nova-blog-posts__readmore-wrap">
					<a class="nova-blog-posts__readmore link-animation-icon" href="<?php echo(esc_url(get_permalink())); ?>"><?php esc_html_e( 'Read more', 'irina') ?><i class="inova ic-arrow-right"></i></a>
				</div>
			</div>
		</div>
</article>

</div>
