<?php
$next_post = get_next_post();
$prev_post = get_previous_post();

if ( ! $next_post && ! $prev_post ) {
	return;
}
?>

<nav class="navigation post-navigation" role="navigation">
	<div class="nav-links">
		<?php if ( $prev_post ) : ?>
			<div class="nav-previous">
				<a href="<?php echo esc_url( get_permalink( $prev_post ) ); ?>">
					<span class="title"><?php esc_html_e( 'Prev Post', 'irina' ); ?></span>
					<div></div>
					<span class="post"><?php echo esc_html( $prev_post->post_title ); ?></span>
				</a>
			</div>
		<?php endif; ?>
		<?php if ( $next_post ) : ?>
			<div class="nav-next">
				<a href="<?php echo esc_url( get_permalink( $next_post ) ); ?>">
					<span class="title"><?php esc_html_e( 'Next Post', 'irina' ); ?></span>
					<div></div>
					<span class="post"><?php echo esc_html( $next_post->post_title );?></span>
				</a>
			</div>
		<?php endif; ?>
	</div>
</nav>
