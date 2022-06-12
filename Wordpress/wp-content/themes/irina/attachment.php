<?php get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

		<div class="row small-collapse">

			<div class="small-12 columns">

				<div class="site-content">

					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header>

					 <div class="nav-links">
					    <?php previous_image_link( false, '<span class="previous-image">' . esc_html__( 'Previous ', 'irina' ) . '</span>' ); ?>
					    <?php next_image_link( false, '<span class="next-image">' . esc_html__( 'Next ', 'irina' ) . '</span>' ); ?>
					</div><!-- .nav-links -->

			        <div class="entry-attachment">

						<?php if ( wp_attachment_is_image( $post->id ) ) : $att_image = wp_get_attachment_image_src( $post->id, "full"); ?>

			                <a href="<?php echo wp_get_attachment_url($post->id); ?>" title="<?php the_title_attribute(); ?>" rel="attachment">
			                	<img src="<?php echo esc_url($att_image[0]);?>" width="<?php echo esc_attr($att_image[1]);?>" height="<?php echo esc_attr($att_image[2]);?>" class="attachment-medium" alt="<?php echo esc_attr($post->post_excerpt); ?>" />

			                </a>

						<?php else : ?>

			                <a href="<?php echo wp_get_attachment_url($post->ID) ?>" title="<?php echo esc_attr( get_the_title($post->ID), 1 ) ?>" rel="attachment"><?php echo basename($post->guid) ?></a>

						<?php endif; ?>

			        </div>

		        </div> <!-- site-content -->

			</div> <!-- small-12 columns-->

		</div> <!-- row small-collapse -->


	<?php endwhile; ?>

<?php
get_footer();
