<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
?>
<?php
$header_class = "header-type-default ";
$header_wide = "";
if(
	'on' == Nova_OP::getOption('header_transparent')
	|| 'transparency_light' == get_post_meta( nova_get_page_id(), 'metabox_header_transparency', true )
	|| 'transparency_dark' == get_post_meta( nova_get_page_id(), 'metabox_header_transparency', true )
)
{
	$header_class .= "header-transparent ";
	$header_class	.= get_post_meta( nova_get_page_id(), 'metabox_header_transparency', true );
}else {
	$header_class .= "header-static ";
}
 ?>
<header id="masthead" class="nova-header <?php echo esc_attr($header_class) ?> headroom">
	<?php
	if ( !function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {
    get_template_part('template-parts/headers/header','default');
	}
	?>
</header>
<?php
if( !class_exists('NOVAHB', false) ){
  get_template_part( 'template-parts/headers/header-mobiles' );
}
?>
