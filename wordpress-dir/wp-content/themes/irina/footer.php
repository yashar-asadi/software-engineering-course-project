
        </div><!-- .site-content-wrapper -->
        <?php
        $header_template = '';
        	if('inherit' == get_post_meta( nova_get_page_id(), 'metabox_header_template', true ) or '' == get_post_meta( nova_get_page_id(), 'metabox_header_template', true )) {
        		$header_template = Nova_OP::getOption('header_template');
        	}else {
        		$header_template = get_post_meta( nova_get_page_id(), 'metabox_header_template', true );
        	}
          ?>
        <?php
        if($header_template != 'type-none') {
          if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'footer' ) ) {
          	nova_render_footer();
          }
        }
        ?>
        <?php get_template_part( 'template-parts/footers/footer-quickview') ?>
    </div><!-- .site-wrapper -->
    <?php get_template_part( 'template-parts/footers/footer-canvas' ) ?>
    <?php get_template_part( 'template-parts/footers/footer-support' ) ?>
    <?php get_template_part( 'template-parts/footers/footer-popup' ) ?>
    <?php get_template_part( 'template-parts/global/svg-icons' ) ?>
    <div class="nova-overlay-global"></div>
    <?php wp_footer(); ?>
</body>
</html>
