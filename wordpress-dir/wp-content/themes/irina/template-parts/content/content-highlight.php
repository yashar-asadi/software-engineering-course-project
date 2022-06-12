<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if(has_post_thumbnail()): ?>
		<div class="entry-thumbnail">
			<a href="<?php echo esc_url( get_permalink() ); ?>">
				<?php the_post_thumbnail('large'); ?>
			</a>
		</div>
	<?php endif; ?>

	<div class="entry-content-wrap">

		<header class="entry-header">

				<div class="entry-meta">
					<?php echo nova_posted_on(); ?>
				</div>

			<?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h3>' ); ?>

		</header>

		<div class="entry-content">

			<div><?php the_excerpt(); ?></div>

		</div>

		<a class="entry-content__readmore site-secondary-font" href="<?php echo(esc_url(get_permalink())); ?>"><?php esc_html_e( 'Read More', 'irina') ?></a>

	</div>

</article>
