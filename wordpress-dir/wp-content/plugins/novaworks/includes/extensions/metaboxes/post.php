<?php

//http://code.tutsplus.com/tutorials/how-to-create-custom-wordpress-writemeta-boxes--wp-20336



// CREATE

add_action( 'add_meta_boxes', 'nova_post_options_meta_box_add' );

function nova_post_options_meta_box_add()
{
    add_meta_box( 'post_options_meta_box', esc_html__('Post Options','novaworks'), 'nova_post_options_meta_box_content', 'post', 'side', 'high' );
}

function nova_post_options_meta_box_content()
{
    // $post is already set, and contains an object: the WordPress post
    global $post;
    $values = get_post_custom( $post->ID );
	$header_transparency = isset($values['page_header_transparency']) ? esc_attr( $values['page_header_transparency'][0]) : '';
    ?>

    <p><strong>Header Transparency</strong></p>

    <p>
        <select name="page_header_transparency" id="page_header_transparency" style="width:100%">
            <option value="inherit" <?php selected( $header_transparency, 'inherit' ); ?>><?php esc_html_e('Inherit','novaworks') ?></option>
            <option value="transparency_light" <?php selected( $header_transparency, 'transparency_light' ); ?>><?php esc_html_e('Light','novaworks') ?></option>
            <option value="transparency_dark" <?php selected( $header_transparency, 'transparency_dark' ); ?>><?php esc_html_e('Dark','novaworks') ?></option>
            <option value="no_transparency" <?php selected( $header_transparency, 'no_transparency' ); ?>><?php esc_html_e('No Transparency','novaworks') ?></option>
        </select>
    </p>

    <?php

	// We'll use this nonce field later on when saving.
    wp_nonce_field( 'post_options_meta_box', 'post_options_meta_box_nonce' );
}




// SAVE

add_action( 'save_post', 'nova_post_options_meta_box_save' );

function nova_post_options_meta_box_save($post_id)
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;

    // if our nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['post_options_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['post_options_meta_box_nonce'], 'post_options_meta_box' ) ) return;

    // if our current user can't edit this post, bail
    if ( !current_user_can( 'edit_post', $post_id ) ) return;

	if( isset( $_POST['page_header_transparency'] ) )
    update_post_meta( $post_id, 'page_header_transparency', esc_attr( $_POST['page_header_transparency'] ) );
}
