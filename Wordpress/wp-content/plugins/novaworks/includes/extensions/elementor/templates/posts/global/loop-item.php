<?php
/**
 * Posts loop start template
 */

$preset = $this->get_settings_for_display('preset');
$enable_custom_image_height = $this->get_settings_for_display('enable_custom_image_height');

$show_image     = $this->get_settings_for_display('show_image');
$show_meta      = $this->get_settings_for_display('show_meta');
$show_author    = $this->get_settings_for_display('show_author');
$show_date      = $this->get_settings_for_display('show_date');
$show_comments  = $this->get_settings_for_display('show_comments');
$show_categories= $this->get_settings_for_display('show_categories');
$show_title     = $this->get_settings_for_display('show_title');
$show_more      = $this->get_settings_for_display('show_more');
$show_excerpt   = $this->get_settings_for_display('show_excerpt');
$excerpt_length = absint($this->get_settings_for_display('excerpt_length'));
$title_html_tag = $this->get_settings_for_display('title_html_tag');
$active_class = '';
if($enable_custom_image_height) {
  $active_class = ' active-object-fit';
}
//active-object-fit
?>
<article class="cell novaworks-posts__item loop__item<?php echo $active_class?> <?php if(has_post_thumbnail()) echo ' has-post-thumbnail'; ?>">
    <div class="novaworks-posts__inner-box"><?php
        if( $show_image == 'yes' && has_post_thumbnail() ) {
            ?>
            <div class="post-thumbnail">
              <?php
              if( $show_meta == 'yes' && $show_categories == 'yes' && $preset == 'grid-2') {
                  nova_entry_meta_item_category_list('<div class="post-meta post-meta--top"><div class="post-terms post-meta__item">', '</div></div>','');
              }
               ?>
                <a href="<?php the_permalink(); ?>" class="post-thumbnail__link figure__object_fit"><?php
                    the_post_thumbnail($this->get_settings_for_display( 'thumb_size' ), array(
                        'class' => 'post-thumbnail__img wp-post-image nova-lazyload-image'
                    ))
                    ?></a>
            </div>
            <?php
        }

        echo '<div class="novaworks-posts__inner-content">';
        if( $show_meta == 'yes' && $show_categories == 'yes' && $preset == 'grid-1') {
            nova_entry_meta_item_category_list('<div class="post-meta post-meta--top"><div class="post-terms post-meta__item">', '</div></div>','');
        }
        if( $show_meta == 'yes' ) {
            echo '<div class="post-meta">';

            if(filter_var($show_author, FILTER_VALIDATE_BOOLEAN)){
                echo sprintf(
                    '<span class="posted-by post-meta__item"><span>%1$s</span><a href="%2$s" class="posted-by__author" rel="author">%3$s</a></span>',
                    esc_html__( 'by ', 'novaworks' ),
                    esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                    esc_html( get_the_author() )
                );
            }

            if(filter_var($show_date, FILTER_VALIDATE_BOOLEAN)){
                echo sprintf(
                    '<span class="post__date post-meta__item"><time datetime="%1$s" title="%1$s">%2$s</time></span>',
                    esc_attr( get_the_date( 'c' ) ),
                    esc_html( get_the_date() )
                );
            }

            if($show_comments == 'yes'){
                echo '<span class="post__comments post-meta__item"><i class="novaworksicon-b-meeting"></i>';
                comments_popup_link(__('0 comment', 'novaworks'),__('1 comment', 'novaworks'),false, 'post__comments-link');
                echo '</span>';
            }

            echo '</div>';
        }

        if($show_title == 'yes'){
            $title_length = -1;
            $title_ending = $this->get_settings_for_display( 'title_trimmed_ending_text' );

            if ( filter_var( $this->get_settings_for_display( 'title_trimmed' ), FILTER_VALIDATE_BOOLEAN ) ) {
                $title_length = $this->get_settings_for_display( 'title_length' );
            }

            $title = get_the_title();
            if($title_length > 0){
                $title = wp_trim_words( $title, $title_length, $title_ending );
            }

            echo sprintf(
                '<%1$s class="entry-title"><a href="%2$s" title="%3$s" rel="bookmark">%4$s</a></%1$s>',
                esc_attr($title_html_tag),
                esc_url(get_the_permalink()),
                esc_html(get_the_title()),
                esc_html($title)
            );
        }
        if( $show_meta == 'yes' && $show_categories == 'yes' && $preset == 'grid-3') {
            nova_entry_meta_item_category_list('<div class="post-meta post-meta--top is-cat"><div class="post-terms post-meta__item">', '</div></div>',', ');
        }
        if($show_excerpt){
          if($excerpt_length > 0){
              echo sprintf(
                  '<div class="entry-excerpt">%1$s</div>',
                  nova_excerpt(intval( $excerpt_length ))
              );
          }
        }
        if($show_more == 'yes'){

            echo sprintf(
                '<div class="novaworks-more-wrap"><a href="%2$s" class="elementor-button novaworks-more" title="%3$s" rel="bookmark"><span class="btn__text">%1$s</span><i class="novaworks-more-icon %4$s"></i></a></div>',
                $this->get_settings_for_display( 'more_text' ),
                esc_url(get_the_permalink()),
                esc_html(get_the_title()),
                esc_attr($this->get_settings_for_display( 'more_icon' ))
            );
        }

        echo '</div>';

        ?></div>
</article>
