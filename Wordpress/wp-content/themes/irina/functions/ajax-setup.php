<?php

// =============================================================================
// Ajax url
// =============================================================================

if ( ! function_exists('nova_ajax_url_fn') ) :
function nova_ajax_url_fn() {
?>
    <script>
        var nova_ajax_url = '<?php echo esc_url( admin_url("admin-ajax.php") ); ?>';
    </script>
<?php
}
add_action( 'wp_head','nova_ajax_url_fn' );
endif;
