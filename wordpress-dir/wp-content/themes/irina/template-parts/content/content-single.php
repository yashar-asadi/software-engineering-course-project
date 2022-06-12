<?php
	$author = get_the_author();
	$author_meta_desc = get_the_author_meta( 'description' )
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">
		<?php if ( Nova_OP::getOption('blog_single_featured') == 1 ):?>
			<div class="entry-featured-img">
				<?php the_post_thumbnail('full'); ?>
			</div>
		<?php endif?>
		<?php if(has_category()): ?>
						<div class="cat-list grid-x">
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

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="entry-meta">
				<a class="author-all-posts" href="<?php echo get_author_posts_url( get_the_author_meta('ID') ) ?>">
					<figure>
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 80 ); ?>
					</figure>
					<span><?php echo get_the_author_meta( 'nickname' ) ?></span>
				</a>
				<div class="dot"></div>
				<?php echo nova_posted_on(); ?>
		</div>
	</header><!-- .entry-header -->

	<div class="grid-x">

		<div class="cell small-12">

			<div class="entry-content">
				<div class="entry-content__inner">
					<?php the_content(); ?>
				</div>
				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . wp_kses(__( '<span class="pages">Pages:</span>', 'irina' ),'simple'),
					'after'  => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
				?>
				<div class="entry-footer">
					<div class="display-flex">
						<?php if(has_tag()):?>
						<div class="entry-tags">
							<div class="entry-meta__item entry-meta__item--tags">
								<?php the_tags('', '', ''); ?>
							</div>
						</div>
					<?php endif?>
					<?php if( 1 == Nova_OP::getOption('blog_single_social_share') ):?>
						<?php
						echo '<div class="nova-sharing-single-posts">';
						nova_social_sharing(get_the_permalink(), get_the_title(), (has_post_thumbnail() ? get_the_post_thumbnail_url(get_the_ID(), 'full') : ''));
						echo '</div>';
					?>
					<?php endif?>
					</div>

			</div>
			<?php
			if ( 1 == Nova_OP::getOption('blog_single_author_box') ) {
					get_template_part( 'template-parts/content/biography' );
				}
			?>
			<?php
			if ( 1 == Nova_OP::getOption('blog_single_post_nav') ) {
					get_template_part( 'template-parts/content/post-navigation' );
				}
			?>
			</div><!-- .entry-content -->

		</div>

	</div>

</article><!-- #post-## -->
