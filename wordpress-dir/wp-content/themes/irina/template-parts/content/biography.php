<?php if ( get_the_author_meta( 'user_description' ) ) : ?>
	<div class="author-info">
		<div class="author-vcard">
			<a class="author-avatar" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), 300 ); ?>
			</a>
			<div class="author-socials">
				<?php
				$socials = array( 'facebook', 'twitter', 'linkedin', 'instagram', 'pinterest' );
				foreach ( $socials as $social ) {
					$link = get_the_author_meta( $social );

					if ( empty( $link ) ) {
						continue;
					}

					printf(
						'<a href="%s" target="_blank" rel="nofollow"><i class="fab fa-%s" aria-hidden="true"></i></a>',
						esc_url( $link ),
						esc_attr( str_replace( array( 'pinterest' ), array( 'pinterest-p' ), $social ) )
					);
				}
				?>
			</div><!-- .author-description -->
		</div><!-- .author-avatar -->

		<div class="author-description">
			<div class="author-name">
				<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) ?>"><?php echo get_the_author(); ?></a>
			</div>
			<?php echo wp_kses(get_the_author_meta( 'user_description' ),'simple'); ?>
		</div>
	</div><!-- .author-info -->
<?php endif; ?>
