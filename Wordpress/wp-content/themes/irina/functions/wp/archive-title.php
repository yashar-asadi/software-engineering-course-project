<?php

/******************************************************************************/
/* Archive Title **************************************************************/
/******************************************************************************/

add_filter( 'get_the_archive_title', function ($title) {

    if ( is_category() ) {

        $title = single_cat_title('', false);

    } elseif ( is_tag() ) {

        $title = single_tag_title('', false);

    } elseif ( is_author() ) {

        $title = get_the_author();

    } elseif ( is_search() ){
        $title = esc_html__( 'Search','irina');

    }

    return $title;

});
