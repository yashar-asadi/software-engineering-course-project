<?php
	get_header();
	global $wp_query;
	$column_l = Nova_OP::getOption('blog_post_column_l');
	$column_m = Nova_OP::getOption('blog_post_column_m');
	$column_s = Nova_OP::getOption('blog_post_column_s');
?>
<div class="<?php echo ( 1 == Nova_OP::getOption('blog_wide_layout') ) ? 'nova-container-fluid' : 'nova-container' ?>">
	<div class="site-content">

		<div class="blog-listing sidebar-status<?php if ( 1 == Nova_OP::getOption('blog_sidebar') && 1 == Nova_OP::getOption('blog_sticky_sidebar')) : ?> sidebar_sticky<?php endif; ?>">

			<div class="grid-x">
				<?php if ( 1 == Nova_OP::getOption('blog_sidebar') && is_active_sidebar( 'blog-widget-area' ) && 'left' == Nova_OP::getOption('blog_sidebar_position') ) : ?>
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

				<div class="cell small-12 <?php echo ( 1 == Nova_OP::getOption('blog_sidebar') && is_active_sidebar( 'blog-widget-area' ) ) ? 'large-9' : 'large-12' ?> site-main-content-wrapper">
					<div class="site-main-content">
							<?php get_template_part( 'template-parts/global/page-header' ) ?>
						<div class="blog-articles">
							<?php
								if ( have_posts() ) {
									if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {
										if( 'layout-4' == Nova_OP::getOption('blog_layout') || 'layout-2' == Nova_OP::getOption('blog_layout') ) {
											echo '<div class="row-grid grid-x grid-padding-x grid-padding-y large-up-'.esc_attr( $column_l ).' medium-up-'.esc_attr( $column_m ).' small-up-'.esc_attr( $column_s ).'">';
										}
										while ( have_posts() ) : the_post();
											if( 'layout-2' == Nova_OP::getOption('blog_layout') or 'layout-3' == Nova_OP::getOption('blog_layout') or 'layout-4' == Nova_OP::getOption('blog_layout') or 'layout-5' == Nova_OP::getOption('blog_layout') ) {
												get_template_part( 'template-parts/content/content', Nova_OP::getOption('blog_layout') );
											}else {
												get_template_part( 'template-parts/content/content');
											}
										endwhile;
										if( 'layout-4' == Nova_OP::getOption('blog_layout') || 'layout-2' == Nova_OP::getOption('blog_layout') ) {
											echo '</div>';
										}
								}
								}else {
									get_template_part( 'template-parts/content/content', 'none' );
								}
							?>
						</div>

						<?php
						the_posts_navigation(array(
							'prev_text' => esc_html__( 'Older posts', 'irina' ),
							'next_text' => esc_html__( 'Newer posts', 'irina' ),
						));
						?>

					</div>
				</div>

				<?php if ( 1 == Nova_OP::getOption('blog_sidebar') && is_active_sidebar( 'blog-widget-area' ) && 'right' == Nova_OP::getOption('blog_sidebar_position') ) : ?>
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

<?php get_footer();
