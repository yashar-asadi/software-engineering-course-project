<?php

//==============================================================================
// Add Lightbox to WP Gallery
//==============================================================================

if ( ! function_exists('nova_lightbox_to_gallery') ) :
function nova_lightbox_to_gallery ($content, $id, $size, $permalink, $icon, $text) {
    if ($permalink) {
    	return $content;
    }

    $rid = uniqid();
    // $result = '';
    // $content = preg_match('"<a href(.*?)>"', $content, $result);
    // var_dump($result);

    $content = preg_replace('"<a href(.*?)>"', '<a>', $content);
    $content = preg_replace('/<a/', '<a data-open="modal-'.$rid.'"', $content, 1);
    $content .= '<div class="full reveal gb-gallery" id="modal-'.$rid.'" data-reveal>
                    <img src="'.wp_get_attachment_url($id).'" />
                      <button class="gb-gallery-btn close-button" data-close type="button">
                      </button>
                      <button class="gb-gallery-btn next"></button>
                      <button class="gb-gallery-btn prev"></button>
                    </div>';
    return $content;
}
add_filter( 'wp_get_attachment_link', 'nova_lightbox_to_gallery', 10, 6);
endif;


//==============================================================================
// Excerpt Lenght
//==============================================================================

if ( ! function_exists('nova_excerpt_length') ) :
function nova_excerpt_length($length) {
    return 60;
}
add_filter( 'excerpt_length', 'nova_excerpt_length', 999 );
endif;


//==============================================================================
// Archives Excerpt More
//==============================================================================

if ( ! function_exists('nova_excerpt_more') ) :
function nova_excerpt_more($more) {
    global $post;
    return '…';
}
add_filter('excerpt_more', 'nova_excerpt_more');
endif;


//==============================================================================
// Archives Count Filter
//==============================================================================

if ( ! function_exists('nova_archive_count_filter') ) :
function nova_archive_count_filter($links) {
	$links = str_replace('</a>&nbsp;(', '</a><span class="count">', $links);
	$links = str_replace(')', '</span>', $links);
	return $links;
}
add_filter('get_archives_link', 'nova_archive_count_filter');
endif;


//==============================================================================
// Categories Count Filter
//==============================================================================

if ( ! function_exists('nova_categories_postcount_filter') ) :
function nova_categories_postcount_filter($links) {
    $links = str_replace('</a> (', '</a> <span class="count">', $links);
    $links = str_replace(')', '</span>', $links);
    return $links;
}
add_filter('wp_list_categories','nova_categories_postcount_filter');
endif;

//==============================================================================
// Responsive Embeds
//==============================================================================

add_filter( 'embed_oembed_html', 'wrap_embed_with_div', 99, 4 );
function wrap_embed_with_div( $cache, $url, $attr, $post_ID ) {
    $classes = array();

    // Add these classes to all embeds.
    $classes_all = array(
        'wp-embed',
    );

    // Check for different providers and add appropriate classes.

    if ( false !== strpos( $url, 'vimeo.com' ) ) {
        $classes[] = 'vimeo responsive-embed';
    }

    if ( false !== strpos( $url, 'youtube.com' ) ) {
        $classes[] = 'youtube responsive-embed';
    }

    $classes = array_merge( $classes, $classes_all );

    return '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . $cache . '</div>';
}


//==============================================================================
// Add HTML class to Post Navigation links - Blog
//==============================================================================

function nova_posts_prev_link_attributes() {
    return 'class="nav-links__item nav-links__item--next site-secondary-font"';
}
add_filter('previous_posts_link_attributes', 'nova_posts_prev_link_attributes');

function nova_posts_next_link_attributes() {
    return 'class="nav-links__item nav-links__item--prev site-secondary-font"';
}
add_filter('next_posts_link_attributes', 'nova_posts_next_link_attributes');


//==============================================================================
// Add HTML class to Post Navigation links - Single
//==============================================================================

function nova_prev_post_link_attributes($output) {
    $injection = 'class="nav-links__item nav-links__item--prev"';
    return str_replace('<a href=', '<a ' . $injection . ' href=', $output);
}
add_filter('next_post_link', 'nova_next_post_link_attributes');

function nova_next_post_link_attributes($output) {
    $injection = 'class="nav-links__item nav-links__item--next"';
    return str_replace('<a href=', '<a ' . $injection . ' href=', $output);
}
add_filter('previous_post_link', 'nova_prev_post_link_attributes');
