<?php
if (get_post_meta( nova_get_page_id(), 'meta_box_page_header_enable', true )) {
    $page_title_option = get_post_meta( nova_get_page_id(), 'meta_box_page_header_enable', true );
} else {
    $page_title_option = "on";
}
?>

<?php if ( "on" == $page_title_option ) : ?>

    <header class="entry-header">
        <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
    </header><!-- .entry-header -->

<?php endif; ?>