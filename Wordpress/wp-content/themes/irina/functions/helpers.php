<?php

// -----------------------------------------------------------------------------
// Define Constants
// -----------------------------------------------------------------------------

define( 'NOVA_WOOCOMMERCE_IS_ACTIVE', 	class_exists( 	'WooCommerce' ) );
define( 'NOVA_VISUAL_COMPOSER_IS_ACTIVE', defined( 		'WPB_VC_VERSION' ) );
define( 'NOVA_REV_SLIDER_IS_ACTIVE', 		class_exists( 	'RevSlider' ) );
define( 'NOVA_WPML_IS_ACTIVE', 			defined( 		'ICL_SITEPRESS_VERSION' ) );
define( 'NOVA_WISHLIST_IS_ACTIVE', 		class_exists( 	'YITH_WCWL' ) );
define( 'NOVA_KIRKI_IS_ACTIVE', 			class_exists( 	'Kirki' ) );
define( 'NOVA_GERMANIZED_IS_ACTIVE', 		class_exists( 	'WooCommerce_Germanized' ) );
define( 'NOVA_RWMB_IS_ACTIVE', 		class_exists( 	'RWMB_Core' ) );


// -----------------------------------------------------------------------------
// String to Slug
// -----------------------------------------------------------------------------

if ( ! function_exists( 'nova_string_to_slug' ) ) :
function nova_string_to_slug($str) {
	$str = strtolower(trim($str));
	$str = preg_replace('/[^a-z0-9-]/', '_', $str);
	$str = preg_replace('/-+/', "_", $str);
	return $str;
}
endif;


// -----------------------------------------------------------------------------
// Theme Name
// -----------------------------------------------------------------------------

if ( ! function_exists( 'nova_theme_name' ) ) :
function nova_theme_name() {
	$nova_theme = wp_get_theme();
	return $nova_theme->get('Name');
}
endif;

// -----------------------------------------------------------------------------
// Parent Theme Name
// -----------------------------------------------------------------------------

if ( ! function_exists( 'nova_parent_theme_name' ) ) :
function nova_parent_theme_name()
{
	$theme = wp_get_theme();
	if ($theme->parent()):
		$theme_name = $theme->parent()->get('Name');
	else:
		$theme_name = $theme->get('Name');
	endif;

	return $theme_name;
}
endif;


// -----------------------------------------------------------------------------
// Theme Slug
// -----------------------------------------------------------------------------

if ( ! function_exists( 'nova_theme_slug' ) ) :
function nova_theme_slug() {
	$nova_theme = wp_get_theme();
	return nova_string_to_slug( $nova_theme->get('Name') );
}
endif;


// -----------------------------------------------------------------------------
// Theme Author
// -----------------------------------------------------------------------------

if ( ! function_exists( 'nova_theme_author' ) ) :
function nova_theme_author() {
	$nova_theme = wp_get_theme();
	return $nova_theme->get('Author');
}
endif;


// -----------------------------------------------------------------------------
// Theme Description
// -----------------------------------------------------------------------------

if ( ! function_exists( 'nova_theme_description' ) ) :
function nova_theme_description() {
	$nova_theme = wp_get_theme();
	return $nova_theme->get('Description');
}
endif;


// -----------------------------------------------------------------------------
// Theme Version
// -----------------------------------------------------------------------------

if ( ! function_exists( 'nova_theme_version' ) ) :
function nova_theme_version() {
	$nova_theme = wp_get_theme();
	return $nova_theme->get('Version');
}
endif;


// -----------------------------------------------------------------------------
// Convert hex to rgb
// -----------------------------------------------------------------------------

function nova_hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);
	return implode(",", $rgb); // returns the rgb values separated by commas
	//return $rgb; // returns an array with the rgb values
}


// -----------------------------------------------------------------------------
// Page ID
// -----------------------------------------------------------------------------

function nova_get_page_id() {
	$page_id = "";
	if ( is_single() || is_page() ) {
	    $page_id = get_the_ID();
	} else {
	    $page_id = get_option('page_for_posts');
	}
	return $page_id;
}


// -----------------------------------------------------------------------------
// File Contents
// -----------------------------------------------------------------------------

function nova_get_local_file_contents($file_path) {

    $url_get_contents_data = false;

	if (function_exists('ob_start') && function_exists('ob_get_clean') && ($url_get_contents_data == false))
    {
        ob_start();
	    include $file_path;
	    $url_get_contents_data = ob_get_clean();
    }

    return $url_get_contents_data;

}

// -----------------------------------------------------------------------------
// Display the main breadcrumb
// -----------------------------------------------------------------------------

function nova_site_breadcrumb() {

	if ( Nova_OP::getOption('page_header_breadcrumb_toggle') == false ) {
		return;
	}

	$yoast = get_option( 'wpseo_internallinks' );

	if ( function_exists( 'yoast_breadcrumb' ) && $yoast && $yoast['breadcrumbs-enable'] ) {
		yoast_breadcrumb( '<div class="breadcrumb">', '</div>' );
	} elseif ( ( NOVA_WOOCOMMERCE_IS_ACTIVE ) ) {
		woocommerce_breadcrumb();
	} else {
		echo '<nav class="woocommerce-breadcrumb">';
		nova_breadcrumbs();
		echo '</nav>';
	}
}

// -----------------------------------------------------------------------------
// Check Woocommerce Page
// -----------------------------------------------------------------------------

function is_realy_woocommerce_page () {
    if( function_exists ( "is_woocommerce" ) && is_woocommerce()){
        return true;
    }
    $woocommerce_keys = array ( "woocommerce_shop_page_id" ,"woocommerce_terms_page_id") ;

    foreach ( $woocommerce_keys as $wc_page_id ) {
        if ( nova_get_page_id () == get_option ( $wc_page_id , 0 ) ) {
            return true ;
        }
    }
    return false;
}
function nova_page_need_header () {
	if(is_404()) {
		return false;
	}
	if( function_exists ( "is_product" ) && is_product()){
			return false;
	}
	return true;
}
//==============================================================================
// Add tabs after add to cart button & right after Wishlist button
//==============================================================================

if( ! function_exists('nova_single_product_share') ):
	function nova_single_product_share() {
		global $post, $product;

		$src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), false, ''); //Get the Thumbnail URL
		$html  = '<div class="woocommerce-product-details__share-box">';
			$html .= '<a href="//www.facebook.com/sharer/sharer.php?u=' . urlencode(get_permalink()) . '" target="_blank"><i class="fa fa-facebook"></i></a>';
			$html .= '<a href="//twitter.com/share?url=' . urlencode(get_permalink()) . '" target="_blank"><i class="fa fa-twitter"></i></a>';
			$html .= '<a href="//pinterest.com/pin/create/button/?url= '. get_permalink() .'&amp;media= '. esc_url($src[0]) .'&amp;description= ' . urlencode(get_the_title()) .'"><i class="fa fa-pinterest"></i></a>';
			$html .= '</div>';
		print wp_kses($html,'simple');
	}
endif;

//==============================================================================
// remove_js_autop
//==============================================================================
if( ! function_exists('nova_remove_js_autop') ):
	function nova_remove_js_autop($content, $autop = false){
			if ( $autop ) {
					$content = preg_replace( '/<\/?p\>/', "\n", $content );
					$content = preg_replace( '/<p[^>]*><\\/p[^>]*>/', "", $content );
					$content = wpautop( $content . "\n" );
			}
			return do_shortcode( shortcode_unautop( $content ) );
	}
endif;
//==============================================================================
// Footer Builder Template
//==============================================================================
if(!function_exists('nova_get_config_footer_layout_opts')) {
	function nova_get_config_footer_layout_opts(){

			$args = array(
					'post_type' => 'elementor_library',
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'nopaging' => true,
					// 'tax_query' => array(
					// 		array(
					// 				'taxonomy' => 'elementor_library_type',
					// 				'field' => 'slug',
					// 				'terms' => 'footer'
					// 		)
					// )
			);

			wp_reset_postdata();

			$query = new WP_Query($args);
			// echo "<pre>";
			// print_r($query);
			// echo "</pre>";
			// die();
			$options = array();

			if($query->have_posts()){
					while ($query->have_posts()){
							$query->the_post();
							$options[get_the_ID()] = get_the_title();
					}
			}
			wp_reset_postdata();
			return $options;
	}
}
//==============================================================================
// Top Bar Builder Template
//==============================================================================
if(!function_exists('nova_get_config_topbar_layout_opts')) {
	function nova_get_config_topbar_layout_opts(){

			$args = array(
					'post_type' => 'elementor_library',
					'posts_per_page' => -1,
					'post_status' => 'publish',
					'nopaging' => true,
			);

			wp_reset_postdata();

			$query = new WP_Query($args);
			$options = array();

			if($query->have_posts()){
					while ($query->have_posts()){
							$query->the_post();
							$options[get_the_ID()] = get_the_title();
					}
			}
			wp_reset_postdata();
			return $options;
	}
}

//==============================================================================
// Render Topbar
//==============================================================================
function nova_render_topbar(){
		$topbar_type = Nova_OP::getOption('topbar_template');
		$value = Nova_OP::getOption('topbar_template_builder');
		if(!empty($value) && $topbar_type == 'type-builder'){
				$value = absint($value);
				if(!empty($value) && get_post_type($value) == 'elementor_library'){
						echo sprintf('<div class="topbar-builder">%s</div>', do_shortcode('[elementor-template id="'. $value .'"]'));
				}
		}
		else{
				get_template_part( 'template-parts/headers/topbar', 'type-default' );
		}
}
//==============================================================================
// Render Footer
//==============================================================================
function nova_render_footer(){
		$footer_type = Nova_OP::getOption('footer_template');
		$value = Nova_OP::getOption('footer_template_builder');
		if(!empty($value) && $footer_type == 'type-builder'){
				$value = absint($value);
				if(!empty($value) && get_post_type($value) == 'elementor_library'){
						echo sprintf('<footer id="colophon" class="site-footer nova-footer-builder"><div class="container">%s</div></footer>', do_shortcode('[elementor-template id="'. $value .'"]'));
				}
		}
		else{
				get_template_part( 'template-parts/footers/footer', 'type-mini' );
		}
}

//==============================================================================
// Render Post Meta
//==============================================================================
if ( ! function_exists( 'nova_get_post_meta' ) ) {
    function nova_get_post_meta( $object_id, $sub_key = '', $meta_key = '', $single = true ) {

        if (!is_numeric($object_id)) {
            return false;
        }

        if (empty($meta_key)) {
            $meta_key = '_irina_post_options';
        }

        $object_value = get_post_meta($object_id, $meta_key, $single);

        if(!empty($sub_key)){
            if( $single ) {
                if(isset($object_value[$sub_key])){
                    return $object_value[$sub_key];
                }
                else{
                    return false;
                }
            }
            else{
                $tmp = array();
                if( ! empty( $object_value ) ) {
                    foreach( $object_value as $k => $v ){
                        $tmp[] = (isset($v[$sub_key])) ? $v[$sub_key] : '';
                    }
                }
                return $tmp;
            }
        }
        else{
            return $object_value;
        }
    }
}
 //==============================================================================
 // Render single post format content
 //==============================================================================

if(!function_exists('nova_single_post_thumbnail')){
    function nova_single_post_thumbnail( $thumbnail_size = 'full' ) {
        if ( post_password_required() || is_attachment() ) {
            return;
        }
        if(has_post_thumbnail()){ ?>
            <div class="post-thumbnail">
							<a<?php
							if( 'video' == get_post_format() && NOVA_RWMB_IS_ACTIVE  ){
									$popup_video_link = rwmb_meta('irina_post_video_url');
									$id = rand();
									if(!empty($popup_video_link)) {
										printf(' data-video-url="%s" id="%s" class="js-video-popup-btn post-thumbnail__link"', $popup_video_link,$id );
									}
							}
							else{
									?> class="post-thumbnail__link" href="<?php the_permalink();?>"<?php
							}
							?>>
                    <figure class="blog_item--thumbnail figure__object_fit">
                        <?php echo get_the_post_thumbnail(get_the_ID(), $thumbnail_size, array('class' => 'post-thumbnail__img')); ?>
                    </figure>
										<?php
										if( 'video' == get_post_format() && NOVA_RWMB_IS_ACTIVE  ){
												$popup_video_link = rwmb_meta('irina_post_video_url');
												if(!empty($popup_video_link)) {
													printf('<span class="video-play-btn"></span>', $popup_video_link );
												}
										}
										?>
                </a>
            </div>
            <?php
        }

    }
}

 //==============================================================================
 // Return correct schema markup
 //==============================================================================
if ( ! function_exists( 'nova_get_schema_markup' ) ) {

    function nova_get_schema_markup( $location, $original_render = false ) {

        // Default
        $schema = $itemprop = $itemtype = '';

        // HTML
        if ( 'html' == $location ) {
            $schema = 'itemscope itemtype="//schema.org/WebPage"';
        }

        // Header
        elseif ( 'header' == $location ) {
            $schema = 'itemscope="itemscope" itemtype="//schema.org/WPHeader"';
        }

        // Logo
        elseif ( 'logo' == $location ) {
            $schema = 'itemscope itemtype="//schema.org/Brand"';
        }

        // Navigation
        elseif ( 'site_navigation' == $location ) {
            $schema = 'itemscope="itemscope" itemtype="//schema.org/SiteNavigationElement"';
        }

        // Main
        elseif ( 'main' == $location ) {
            $itemtype = '//schema.org/WebPageElement';
            $itemprop = 'mainContentOfPage';
            if ( is_singular( 'post' ) ) {
                $itemprop = '';
                $itemtype = '//schema.org/Blog';
            }
        }

        // Breadcrumb
        elseif ( 'breadcrumb' == $location ) {
            $schema = 'itemscope itemtype="//schema.org/BreadcrumbList"';
        }

        // Breadcrumb list
        elseif ( 'breadcrumb_list' == $location ) {
            $schema = 'itemprop="itemListElement" itemscope itemtype="//schema.org/ListItem"';
        }

        // Breadcrumb itemprop
        elseif ( 'breadcrumb_itemprop' == $location ) {
            $schema = 'itemprop="breadcrumb"';
        }

        // Sidebar
        elseif ( 'sidebar' == $location ) {
            $schema = 'itemscope="itemscope" itemtype="//schema.org/WPSideBar"';
        }

        // Footer widgets
        elseif ( 'footer' == $location ) {
            $schema = 'itemscope="itemscope" itemtype="//schema.org/WPFooter"';
        }

        // Headings
        elseif ( 'headline' == $location ) {
            $schema = 'itemprop="headline"';
        }

        // Posts
        elseif ( 'entry_content' == $location ) {
            $schema = 'itemprop="text"';
        }

        // Publish date
        elseif ( 'publish_date' == $location ) {
            $schema = 'itemprop="datePublished"';
        }

        // Author name
        elseif ( 'author_name' == $location ) {
            $schema = 'itemprop="name"';
        }

        // Author link
        elseif ( 'author_link' == $location ) {
            $schema = 'itemprop="author" itemscope="itemscope" itemtype="//schema.org/Person"';
        }

        // Item
        elseif ( 'item' == $location ) {
            $schema = 'itemprop="item"';
        }

        // Url
        elseif ( 'url' == $location ) {
            $schema = 'itemprop="url"';
        }

        // Position
        elseif ( 'position' == $location ) {
            $schema = 'itemprop="position"';
        }

        // Image
        elseif ( 'image' == $location ) {
            $schema = 'itemprop="image"';
        }

        // Name
        elseif ( 'name' == $location ) {
            $schema = 'itemprop="name"';
        }
        else{
            if($original_render){
                $schema = $location;
            }
        }
        return ' ' . apply_filters( 'nova_schema_markup', $schema, $location );

    }

}

//==============================================================================
// Render Social Sharing
//==============================================================================
if ( ! function_exists('nova_social_sharing') ) {
    function nova_social_sharing( $post_link = '', $post_title = '', $image = '', $post_excerpt = '', $echo = true){
        if(empty($post_link) || empty($post_title)){
            return;
        }
        if(!$echo){
            ob_start();
        }
        echo '<span class="social--sharing">';
        if( 'on' == Nova_OP::getOption('sharing_facebook') ){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="facebook" title="%2$s"><i class="fab fa-facebook-f"></i></a>',
                esc_url( 'https://www.facebook.com/sharer.php?u=' . $post_link ),
                esc_attr_x('Share this post on Facebook', 'front-view', 'irina')
            );
        }
        if( 'on' == Nova_OP::getOption('sharing_twitter') ){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="twitter" title="%2$s"><i class="fab fa-twitter"></i></a>',
                esc_url( 'https://twitter.com/intent/tweet?text=' . $post_title . '&url=' . $post_link ),
                esc_attr_x('Share this post on Twitter', 'front-view', 'irina')
            );
        }
        if( 'on' == Nova_OP::getOption('sharing_reddit') ){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="reddit" title="%2$s"><i class="fab fa-reddit-alien"></i></a>',
                esc_url( 'https://www.reddit.com/submit?url=' . $post_link . '&title=' . $post_title ),
                esc_attr_x('Share this post on Reddit', 'front-view', 'irina')
            );
        }
        if( 'on' == Nova_OP::getOption('sharing_linkedin') ){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="linkedin" title="%2$s"><i class="fab fa-linkedin-in"></i></a>',
                esc_url( 'https://www.linkedin.com/shareArticle?mini=true&url=' . $post_link . '&title=' . $post_title ),
                esc_attr_x('Share this post on Linked In', 'front-view', 'irina')
            );
        }
        if( 'on' == Nova_OP::getOption('sharing_tumblr') ){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="tumblr" title="%2$s"><i class="fab fa-tumblr"></i></a>',
                esc_url( 'https://www.tumblr.com/share/link?url=' . $post_link ) ,
                esc_attr_x('Share this post on Tumblr', 'front-view', 'irina')
            );
        }
        if( 'on' == Nova_OP::getOption('sharing_pinterest') ){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="pinterest" title="%2$s"><i class="fab fa-pinterest-p"></i></a>',
                esc_url( 'https://pinterest.com/pin/create/button/?url=' . $post_link . '&media=' . $image . '&description=' . $post_title) ,
                esc_attr_x('Share this post on Pinterest', 'front-view', 'irina')
            );
        }
        if( 'on' == Nova_OP::getOption('sharing_line') ){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="network-line" title="%2$s"><i class="fab fa-line"></i></a>',
                esc_url( 'https://social-plugins.line.me/lineit/share?url=' . $post_link ),
                esc_attr_x('LINE it!', 'front-view', 'irina')
            );

        }
        if( 'on' == Nova_OP::getOption('sharing_vk') ){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="vk" title="%2$s"><i class="fab fa-vk"></i></a>',
                esc_url( 'https://vkontakte.ru/share.php?url=' . $post_link . '&title=' . $post_title ) ,
                esc_attr_x('Share this post on VK', 'front-view', 'irina')
            );
        }
        if( 'on' == Nova_OP::getOption('sharing_whatapps') ){
            printf('<a href="%1$s" rel="nofollow" class="whatsapp" data-action="share/whatsapp/share" title="%2$s"><i class="fab fa-whatsapp"></i></a>',
                'whatsapp://send?text=' . esc_attr( $post_title . ' ' . $post_link ),
                esc_attr_x('Share via Whatsapp', 'front-view', 'irina')
            );
        }
        if( 'on' == Nova_OP::getOption('sharing_telegram') ){
            printf('<a href="%1$s" rel="nofollow" class="telegram" title="%2$s"><i class="fab fa-telegram-plane"></i></a>',
                esc_attr( add_query_arg(array( 'url' => $post_link, 'text' => $post_title ), 'https://telegram.me/share/url') ),
                esc_attr_x('Share via Telegram', 'front-view', 'irina')
            );
        }
        if( 'on' == Nova_OP::getOption('sharing_email') ){
            printf('<a target="_blank" href="%1$s" rel="nofollow" class="email" title="%2$s"><i class="fal fa-envelope"></i></a>',
                esc_url( 'mailto:?subject=' . $post_title . '&body=' . $post_link ),
                esc_attr_x('Share this post via Email', 'front-view', 'irina')
            );
        }
        echo '</span>';
        if(!$echo){
            return ob_get_clean();
        }
    }
}

//==============================================================================
//  Post excerpt limit words.
//==============================================================================
if ( ! function_exists( 'irina_excerpt' ) ) {

	function irina_excerpt( $length = 30 ) {
		global $post;

		// Check for custom excerpt
		if ( has_excerpt( $post->ID ) ) {
			$output = $post->post_excerpt;
		}

		// No custom excerpt
		else {

			// Check for more tag and return content if it exists
			if ( strpos( $post->post_content, '<!--more-->' ) || strpos( $post->post_content, '<!--nextpage-->' ) ) {
				$output = apply_filters( 'the_content', get_the_content() );
			}

			// No more tag defined
			else {
				$output = wp_trim_words( strip_shortcodes( $post->post_content ), $length );
			}

		}

		return $output;

	}

}
if ( ! function_exists( 'nova_post_time_ago' ) ) {
	function nova_post_time_ago( $type = 'post' ) {
	    $d = 'comment' == $type ? 'get_comment_time' : 'get_post_time';

	    return human_time_diff($d('U'), current_time('timestamp')) . " " . esc_html__('ago','irina');

	}
}
/* Fullscreen menu check */
function nova_load_menu_location($location) {

	if (has_nav_menu( $location )) {
		$menu = $location;
	} else if (has_nav_menu( 'nova_menu_primary' )) {
		$menu = 'nova_menu_primary';
	} else {
		$menu = false;
	}

	return $menu;
}
