<?php get_header(); ?>
<div class="nova-container">
	<div class="grid-x">

		<div class="cell small-12">

			<div class="site-content single_post_content sidebar-status<?php if ( 1 == Nova_OP::getOption('blog_single_sidebar') && 1 == Nova_OP::getOption('single_sticky_sidebar')) : ?> sidebar_sticky<?php endif; ?>">
				<div class="grid-x">

					<?php if ( 1 == Nova_OP::getOption('blog_single_sidebar') && is_active_sidebar( 'blog-widget-area' ) && 'left' == Nova_OP::getOption('blog_single_sidebar_position') ) : ?>

						<div id="sidebar_primary" class="nova-sidebar cell small-12 large-3">
							<div class="nova-sidebar__overlay js-sidebar-toogle"></div>
							<div class="nova-sidebar__container">
								<a class="nova-sidebar__toggle js-sidebar-toogle" href="javascript:void(0)"></a>
								<div class="woocommerce-sidebar-sticky sidebar-scrollable">
									<?php if (is_active_sidebar( 'blog-widget-area' )) : ?>
										<?php get_sidebar(); ?>
									<?php endif; ?>
								</div>
							</div>
						</div>

					<?php endif; ?>

					<div class="cell small-12 <?php echo ( 1 == Nova_OP::getOption('blog_single_sidebar') && is_active_sidebar( 'blog-widget-area' ) ) ? 'large-9' : 'large-12' ?> site-main-content-wrapper">

						<div class="site-main-content">

							<?php
							if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
								while ( have_posts() ) : the_post();

									get_template_part( 'template-parts/content/content', 'single' );

								endwhile; // End of the loop.
							}
							?>
							<?php if ( comments_open() || get_comments_number() ) : ?>
							<div class="single-comments-container">
								<div class="single-comments-row">
										<div class="single-post-comment-wrap">
												<?php comments_template(); ?>
										</div>
								</div>
							</div>
							<?php endif; ?>
						</div>

					</div>

					<?php if ( 1 == Nova_OP::getOption('blog_single_sidebar') && is_active_sidebar( 'blog-widget-area' ) && 'right' == Nova_OP::getOption('blog_single_sidebar_position') ) : ?>

						<div id="sidebar_primary" class="nova-sidebar cell small-12 large-3">
							<div class="nova-sidebar__overlay js-sidebar-toogle"></div>
							<div class="nova-sidebar__container">
								<a class="nova-sidebar__toggle js-sidebar-toogle" href="javascript:void(0)"></a>
								<div class="woocommerce-sidebar-sticky sidebar-scrollable">
									<?php if (is_active_sidebar( 'blog-widget-area' )) : ?>
										<?php get_sidebar(); ?>
									<?php endif; ?>
								</div>
							</div>
						</div>

					<?php endif; ?>

				</div>

			</div>

		</div>

	</div>
</div>
<?php
get_footer();
