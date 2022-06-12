<!DOCTYPE html>

<html <?php language_attributes(); ?> class="no-js">

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link rel="profile" href="https://gmpg.org/xfn/11" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<?php if ( 1 == Nova_OP::getOption('site_preloader') ) : ?>
	<div class="nova-site-preloader">
		<div class="nova-site-preloader__inner">
			<div class="nova-loader-01">
				<div></div><div></div><div></div><div></div><div></div>
			</div>
		</div>
	</div>
	<?php endif; ?>
	<?php
	$header_template = '';
	if('inherit' == get_post_meta( nova_get_page_id(), 'metabox_header_template', true ) or '' == get_post_meta( nova_get_page_id(), 'metabox_header_template', true )) {
		$header_template = Nova_OP::getOption('header_template');
	}else {
		$header_template = get_post_meta( nova_get_page_id(), 'metabox_header_template', true );
	}
	?>
	<?php get_template_part( 'template-parts/headers/full-screen-menu' ); ?>
	<?php get_template_part( 'template-parts/headers/search-modal' ) ?>
	<div class="site-wrapper">
		<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ):?>
			<?php if ( 1 == Nova_OP::getOption('topbar_toggle') &&  $header_template !='type-none') : ?>
				<?php get_template_part( 'template-parts/headers/header-topbar' ) ?>
			<?php endif; ?>
			<?php get_template_part( 'template-parts/headers/header', $header_template ) ?>
			<?php get_template_part( 'template-parts/headers/header-mobiles' ) ?>
			<div id="site-content" class="site-content-wrapper">
			<?php if (get_post_meta( nova_get_page_id(), 'meta_box_page_header_enable', true ) != 'off' && nova_page_need_header() && 'large' == Nova_OP::getOption('page_header_style')): ?>
				<?php get_template_part( 'template-parts/headers/page-header' ); ?>
			<?php endif; ?>
		<?php endif; ?>
