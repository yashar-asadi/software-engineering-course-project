<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.5.1
 */

defined( 'ABSPATH' ) || exit;


global $product;

$post_thumbnail_id = method_exists( $product, 'get_image_id' ) ? $product->get_image_id() : get_post_thumbnail_id( $product->get_id() );
$thumbnail_size    = apply_filters( 'woocommerce_product_thumbnails_large_size', 'full' );
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, $thumbnail_size );
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
	//	'woocommerce-product-gallery',
	'woocommerce-product-gallery--' . ( has_post_thumbnail() ? 'with-images' : 'without-images' ),
	'woocommerce-product-gallery--columns-' . absint( $columns ),
	'images',
) );

?>
<div class="nova-qv-images">
	<div class="product-item__badges">
		<?php do_action( 'woocommerce_product_badges' ); ?>
	</div>
	<ul class="qv-carousel <?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-slider_config="{"slidesToShow":"{}">
			<?php
			$attributes = array(
				'title'                   => get_post_field( 'post_title', $post_thumbnail_id ),
				'data-caption'            => get_post_field( 'post_excerpt', $post_thumbnail_id ),
			);

			if ( has_post_thumbnail() ) {
				$html  = '<li>';
				$html .= get_the_post_thumbnail( $product->get_id(), 'woocommerce_single', $attributes );
				$html .= '</li>';
			} else {
				$html  = '<li>';
				$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'irina' ) );
				$html .= '</li>';
			}

			$images         = array();
			$images[]       = apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id );
			$attachment_ids = method_exists( $product, 'get_gallery_image_ids' ) ? $product->get_gallery_image_ids() : $product->get_gallery_attachment_ids();

			if ( $attachment_ids && has_post_thumbnail() ) {
				foreach ( $attachment_ids as $attachment_id ) {
					$full_size_image = wp_get_attachment_image_src( $attachment_id, 'full' );
					$attributes      = array(
						'title'                   => get_post_field( 'post_title', $attachment_id ),
						'data-caption'            => get_post_field( 'post_excerpt', $attachment_id ),
					);

					$html = '<li>';
					$html .= wp_get_attachment_image( $attachment_id, 'woocommerce_single', false, $attributes );
					$html .= '</li>';

					$images[] = $html;
				}
			}
			echo implode( "\n\t", $images );
			?>
	</ul>
</div>
