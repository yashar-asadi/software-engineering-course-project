<?php get_header(); ?>
 <div class="nova-container">
	 <div class="grid-x">
		 <div class="cell small-12">
			 <div class="site-content">
				 <?php get_template_part( 'template-parts/global/page-header' ) ?>
				 <?php

						 // Elementor `single` location
						 if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {

								 // Loop through posts
								 while ( have_posts() ) : the_post();

										 get_template_part( 'template-parts/content/content', 'page' );

								 endwhile;

								 wp_reset_postdata();

						 } ?>
			 </div>

		 </div>
	 </div>
	 <?php if ( comments_open() || get_comments_number() ) : ?>
	 <div class="single-comments-container">
		 <div class="grid-x">
			 <div class="cell large-12">
				 <div class="site-content">
					<?php comments_template(); ?>
				 </div>
			 </div>
		 </div>
	 </div>
	 <?php endif; ?>

 </div>
<?php
get_footer();
