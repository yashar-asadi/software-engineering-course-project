<?php
	$author = get_the_author();
	$author_meta_desc = get_the_author_meta( 'description' )
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<?php if ( Nova_OP::getOption('blog_single_featured') == 1 ) the_post_thumbnail('large'); ?>

	</header><!-- .entry-header -->

	<div class="grid-x">

		<div class="cell small-12">

			<div class="entry-content">

				<div class="entry-meta site-secondary-font">

					<div class="entry-meta__item entry-meta-author">

						<a class="author-all-posts" href="<?php echo get_author_posts_url( get_the_author_meta('ID') ) ?>">
							<?php echo get_the_author_meta( 'nickname' ) ?>
						</a>

						<?php esc_html_e( '<span>on</span> ', 'irina' );?><?php echo nova_posted_on(); ?>

					</div>

					<div class="entry-meta__item entry-meta_post_comments">
						<?php if ( comments_open() ) : ?>
							<i class="irina-icons-chat_chat-15"></i>
							<a href="#comments">
						 		<span class="comments_number"><?php comments_number( '0 <span>Comments</span>', '1 <span>Comment</span>', '% <span>Comments</span>' ); ?></span>
						 	</a>
						<?php endif; ?>
					</div>

				</div>

				<?php the_content(); ?>

				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . wp_kses(__( '<span class="pages">Pages:</span>', 'irina' ),'simple'),
					'after'  => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
				) );
				?>

				<div class="entry-tags">
					<div class="entry-meta__item entry-meta__item--tags site-secondary-font">
						<?php the_tags(wp_kses(__('<span>Tags</span>', 'irina'),'simple'), '', ''); ?>
					</div>
				</div>

			</div><!-- .entry-content -->

		</div>

	</div>

</article><!-- #post-## -->
